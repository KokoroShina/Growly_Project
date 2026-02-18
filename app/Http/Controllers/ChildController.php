<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChildController extends Controller
{
    public function index(Request $request)
    {
        $children = $request->user()
            ->children()
            ->with('latestMeasurement')
            ->get();

        return view('children.index', compact('children'));
    }

    public function create()
    {
        return view('children.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'photo' => 'nullable|image|max:2048',
            'notes' => 'nullable|string'
        ]);

        $user = $request->user();

        $child = $user->children()->create([
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'notes' => $request->notes,
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('children', 'public');

            $child->update([
                'photo_path' => $path
            ]);
        }

        return redirect()
            ->route('children.index')
            ->with('success', 'Data anak berhasil ditambahkan');
    }

    public function show(Request $request, Child $child)
{
    // Cek kepemilikan
    if ($child->user_id !== Auth::id()) {
        abort(403);
    }

    // Load measurements
    $child->load('measurements');

    // AMBIL TODO UNTUK HARI INI
    $todos = $child->todos()->whereDate('date', today())->get();

    // HITUNG STREAK
    $streak = 0;
    $currentDate = today();
    
    // Cek streak mundur (max 30 hari untuk keamanan)
    for ($i = 0; $i < 30; $i++) {
        $checkDate = today()->subDays($i);
        $completed = $child->todos()
            ->whereDate('date', $checkDate)
            ->where('is_completed', true)
            ->exists();
        
        if ($completed) {
            $streak++;
        } else {
            // Kalau hari ini tidak ada todo selesai, streak 0
            if ($i === 0) {
                $streak = 0;
            }
            break;
        }
    }

    // SIAPKAN DATA CHART
    $chartData = [
        'labels' => [], // tanggal
        'weight' => [], // berat
        'height' => [], // tinggi
    ];

    // Urutkan dari lama ke baru biar grafiknya bagus
    foreach($child->measurements->sortBy('date') as $m) {
        $chartData['labels'][] = $m->date->format('d M');
        $chartData['weight'][] = $m->weight;
        $chartData['height'][] = $m->height;
    }

    // AMBIL MEASUREMENTS (urut dari terbaru)
    $measurements = $child->measurements()
        ->orderBy('date', 'desc')
        ->get();

    // RETURN VIEW DENGAN SEMUA DATA
    return view('children.show', compact(
        'child', 
        'measurements', 
        'chartData', 
        'todos', 
        'streak'
    ));
}

    public function edit(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        return view('children.edit', compact('child'));
    }

    public function update(Request $request, Child $child)
    {
        // Cek kepemilikan
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'photo' => 'nullable|image|max:2048',
            'notes' => 'nullable|string',
        ]);

        $child->update([
            'name' => $request->name,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'notes' => $request->notes,
        ]);

        // Update foto jika ada
        if ($request->hasFile('photo')) {

            // Hapus foto lama
            if ($child->photo_path) {
                Storage::disk('public')->delete($child->photo_path);
            }

            $path = $request->file('photo')->store('children', 'public');

            $child->update([
                'photo_path' => $path
            ]);
        }

        return redirect()
            ->route('children.show', $child->id)
            ->with('success', 'Data anak berhasil diupdate!');
    }

    public function destroy(Child $child)
    {
        if ($child->user_id !== Auth::id()) {
            abort(403);
        }

        // Hapus foto jika ada
        if ($child->photo_path) {
            Storage::disk('public')->delete($child->photo_path);
        }

        $child->delete();

        return redirect()
            ->route('children.index')
            ->with('success', 'Data anak berhasil dihapus!');
    }
}

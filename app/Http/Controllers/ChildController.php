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

        $child->load('measurements');

        $chartData = [
            'labels'=> [], //tanggal
            'weight'=> [], //berat
            'height'=> [], //tinggi
        ];

        foreach($child->measurements->sortBy('date') as $m)
            {
                $chartData['label'][]= $m->date->format('d M');
                $chartData['weight'][]= $m->weight;
                $chartData['height'][]= $m->height;
                
            }

        $measurements = $child->measurements()
            ->orderBy('date', 'desc')
            ->get();

        $todos = $child->todos()
            ->whereDate('date', today())
            ->get();

        return view('children.show', compact('child', 'measurements', 'todos', 'chartData'));
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

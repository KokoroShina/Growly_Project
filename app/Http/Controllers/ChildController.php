<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;

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
            'name'=> 'required|string|max:100',
            'birth_date' => 'required|date',
            'gender' => 'required|in:male,female',
            'photo'=> 'nullable|image|max:2048',
        ]);

        $user = $request->user();

        $child = $user->children()->create([
            'name'=> $request->name,
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
            ->route('children.show', $child)
            ->with('success', 'Data anak berhasil ditambahkan');
    }

    public function show(Request $request, Child $child)
    {
        if ($child->user_id !== $request->user()->id) {
            abort(403);
        }

        $measurements = $child->measurements()
            ->orderBy('date', 'desc')
            ->get();

        $todos = $child->todos()
            ->whereDate('date', today())
            ->get();

        return view('children.show', compact('child', 'measurements', 'todos'));
    }
}

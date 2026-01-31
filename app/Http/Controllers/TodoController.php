<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Todo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodoController extends Controller
{
    public function store(Request $request, Child $child)
    {
        if ($child->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'date' => 'required|date',
        ]);
        
        $todo = $child->todos()->create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'is_completed' => false,
        ]);
        
        return back()->with('success', 'Todo berhasil ditambahkan!');
    }
    
    public function toggle(Request $request, Todo $todo)
    {
        if ($todo->child->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $todo->update([
            'is_completed' => !$todo->is_completed,
        ]);
        
        // FIX: Convert string date to Carbon object
        $todoDate = Carbon::parse($todo->date);
        $today = Carbon::today();
        
        // Hitung streak jika todo hari ini selesai
        if ($todo->is_completed && $todoDate->isSameDay($today)) {
            $this->updateStreak($todo->child);
        }
        
        return response()->json([
            'success' => true,
            'is_completed' => $todo->is_completed,
            'streak' => $this->getStreak($todo->child),
        ]);
    }
    
    public function destroy(Request $request, Todo $todo)
    {
        $child = $todo->child;
        
        if ($child->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $todo->delete();
        
        return back()->with('success', 'Todo berhasil dihapus!');
    }
    
    private function updateStreak(Child $child)
    {
        $yesterday = Carbon::yesterday();
        
        // FIX: Parse date string untuk comparison
        $yesterdayTodo = $child->todos()
            ->get()
            ->filter(function ($todo) use ($yesterday) {
                $todoDate = Carbon::parse($todo->date);
                return $todoDate->isSameDay($yesterday) && $todo->is_completed;
            })
            ->isNotEmpty();
        
        if ($yesterdayTodo) {
            $currentStreak = session("streak_{$child->id}", 1);
            session(["streak_{$child->id}" => $currentStreak + 1]);
        } else {
            session(["streak_{$child->id}" => 1]);
        }
    }
    
    private function getStreak(Child $child)
    {
        return session("streak_{$child->id}", 0);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Todo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TodoController extends Controller
{
    /**
     * Store a new todo
     */
    public function store(Request $request, Child $child)
    {
        // CEK KEPEMILIKAN - PAKAI STYLE KAMU
        if ($child->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        // Validasi
        $request->validate([
            'title' => 'required|string|max:100',
        ]);
        
        // Simpan todo
        $todo = $child->todos()->create([
            'title' => $request->title,
            'date' => today(),
            'is_completed' => false,
        ]);
        
        // Hitung streak
        $streak = $this->calculateStreak($child);

        return response()->json([
            'success' => true,
            'todo' => [
                'id' => $todo->id,
                'title' => $todo->title,
                'is_completed' => $todo->is_completed
            ],
            'streak' => $streak
        ]);
    }
    
    /**
     * Toggle todo completion status
     */
    public function toggle(Request $request, Todo $todo)
    {
        // CEK KEPEMILIKAN - PAKAI STYLE KAMU
        if ($todo->child->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        // Toggle status
        $todo->update([
            'is_completed' => !$todo->is_completed
        ]);
        
        // Hitung streak
        $streak = $this->calculateStreak($todo->child);
        
        return response()->json([
            'success' => true,
            'is_completed' => $todo->is_completed,
            'streak' => $streak
        ]);
    }
    
    /**
     * Delete a todo
     */
    public function destroy(Request $request, Todo $todo)
    {
        // CEK KEPEMILIKAN - PAKAI STYLE KAMU
        if ($todo->child->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        $child = $todo->child;
        $todo->delete();
        
        // Hitung streak
        $streak = $this->calculateStreak($child);
        
        return response()->json([
            'success' => true,
            'streak' => $streak
        ]);
    }
    
    /**
     * Calculate streak based on database
     */
    private function calculateStreak(Child $child)
    {
        $streak = 0;
        
        // Cek streak mundur sampai 30 hari
        for ($i = 0; $i < 30; $i++) {
            $checkDate = today()->subDays($i);
            
            $completed = $child->todos()
                ->whereDate('date', $checkDate)
                ->where('is_completed', true)
                ->exists();
            
            if ($completed) {
                $streak++;
            } else {
                // Kalau hari ini tidak ada todo selesai, streak = 0
                if ($i === 0) {
                    return 0;
                }
                break;
            }
        }
        
        return $streak;
    }


    public function globalIndex(Request $request)
{
    $user = $request->user();
    $children = $user->children()->with('todos')->get();
    
    // Semua todo, group by status
    $todos = collect();
    foreach ($children as $child) {
        $todos = $todos->concat($child->todos()->with('child')->orderBy('date', 'desc')->get());
    }
    
    // Group by date
    $todosByDate = $todos->groupBy(function($todo) {
        return $todo->date->format('Y-m-d');
    })->sortKeysDesc();
    
    // Statistik
    $totalTodos = $todos->count();
    $completedTodos = $todos->where('is_completed', true)->count();
    $pendingTodos = $totalTodos - $completedTodos;
    $totalStreak = $this->calculateTotalStreak($children);
    
    return view('todos.global', compact('todosByDate', 'totalTodos', 'completedTodos', 'pendingTodos', 'totalStreak'));
}

private function calculateTotalStreak($children)
{
    $total = 0;
    foreach ($children as $child) {
        $streak = 0;
        for ($i = 0; $i < 30; $i++) {
            $date = today()->subDays($i);
            $completed = $child->todos()
                ->whereDate('date', $date)
                ->where('is_completed', true)
                ->exists();
            if ($completed) {
                $streak++;
            } else {
                break;
            }
        }
        $total += $streak;
    }
    return $total;
}
}
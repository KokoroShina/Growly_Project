<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Measurement;
use App\Models\Todo;

class DashboardController extends Controller
{
    public function index(Request $request)  // PASTIKAN ADA Request $request
    {
        $user = $request->user();  // PAKAI GAYA KAMU - SUDAH BENAR
        
        $children = $user->children()->with('latestMeasurement')->take(5)->get();
        $totalChildren = $user->children()->count();
        
        $statusCounts = [
            'normal' => 0,
            'underweight' => 0,
            'overweight' => 0,
            'severely_underweight' => 0,
        ];
        
        foreach ($user->children as $child) {
            if ($child->latestMeasurement) {
                $status = $child->latestMeasurement->status;
                if (isset($statusCounts[$status])) {
                    $statusCounts[$status]++;
                }
            }
        }
        
        $todayTodos = [];
        foreach ($user->children as $child) {
            $todos = $child->todos()
                ->whereDate('date', today())
                ->get();
            
            foreach ($todos as $todo) {
                $todayTodos[] = $todo;
            }
        }
        
        $recentMeasurements = Measurement::whereIn('child_id', $user->children()->pluck('id'))
            ->with('child')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'children',
            'totalChildren',
            'statusCounts',
            'todayTodos',
            'recentMeasurements'
        ));
    }
}
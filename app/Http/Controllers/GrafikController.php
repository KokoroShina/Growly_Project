<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Measurement;
use Carbon\Carbon;

class GrafikController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $children = $user->children()->with('measurements')->get();
        
        // Data untuk chart
        $chartData = [];
        $period = request('period', 30); // default 30 hari
        
        foreach ($children as $child) {
            $measurements = $child->measurements()
                ->where('date', '>=', now()->subDays($period))
                ->orderBy('date')
                ->get();
            
            $chartData[$child->id] = [
                'name' => $child->name,
                'labels' => $measurements->pluck('date')->map(fn($d) => $d->format('d M'))->toArray(),
                'weight' => $measurements->pluck('weight')->toArray(),
                'height' => $measurements->pluck('height')->toArray(),
            ];
        }
        
        return view('grafik.index', compact('children', 'chartData', 'period'));
    }
}
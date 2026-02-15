<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Services\GrowthService;

class MeasurementController extends Controller
{

    public function create(Child $child)
    {
        return view('measurements.create', compact('child'));
    }

    public function store(Request $request, Child $child)
    {
        // Authorization - PAKAI GAYA KAMU
        if ($child->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $request->validate([
            'date' => 'required|date',
            'weight' => 'required|numeric|min:1|max:50', // kg
            'height' => 'required|numeric|min:30|max:150', // cm
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Hitung status gizi
        $growthService = new GrowthService();
        $result = $growthService->calculate($child, $request);
        
        // Simpan measurement
        $measurement = $child->measurements()->create([
            'date' => $request->date,
            'weight' => $request->weight,
            'height' => $request->height,
            'z_score_weight' => $result['z_score_weight'],
            'z_score_height' => $result['z_score_height'],
            'status' => $result['status'],
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('children.show', $child)
            ->with('success', 'Data pengukuran berhasil disimpan!')
            ->with('measurement_result', $result);
    }
    
    public function update(Request $request, Measurement $measurement)
    {
        // Cek ownership via child - PAKAI GAYA KAMU
        if ($measurement->child->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $request->validate([
            'date' => 'required|date',
            'weight' => 'required|numeric|min:1|max:50',
            'height' => 'required|numeric|min:30|max:150',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // Recalculate jika data berubah
        if ($request->weight != $measurement->weight || 
            $request->height != $measurement->height ||
            $request->date != $measurement->date) {
            
            $growthService = new GrowthService();
            $result = $growthService->calculate($measurement->child, $request);
            
            $measurement->update([
                'date' => $request->date,
                'weight' => $request->weight,
                'height' => $request->height,
                'z_score_weight' => $result['z_score_weight'],
                'z_score_height' => $result['z_score_height'],
                'status' => $result['status'],
                'notes' => $request->notes,
            ]);
        } else {
            $measurement->update($request->only(['notes']));
        }
        
        return redirect()->route('children.show', $measurement->child)
            ->with('success', 'Data pengukuran berhasil diperbarui!');
    }
    
    public function destroy(Request $request, Measurement $measurement)  // TAMBAH Request $request
    {
        $child = $measurement->child;
        
        // PAKAI GAYA KAMU
        if ($child->user_id !== $request->user()->id) {
            abort(403);
        }
        
        $measurement->delete();
        
        return redirect()->route('children.show', $child)
            ->with('success', 'Data pengukuran berhasil dihapus!');
    }
}
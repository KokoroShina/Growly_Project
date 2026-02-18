<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Child;
use App\Models\Measurement;
use App\Models\Todo;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // AMBIL SEMUA ANAK USER
        $children = $user->children()->with('latestMeasurement')->get();
        
        // TOTAL ANAK
        $totalChildren = $children->count();
        
        // STATUS COUNTS
        $statusCounts = [
            'normal' => 0,
            'underweight' => 0,
            'overweight' => 0,
            'severely_underweight' => 0,
        ];
        
        // STREAK TERBAIK
        $bestStreak = 0;
        
        foreach ($children as $child) {
            // Hitung status
            if ($child->latestMeasurement) {
                $status = $child->latestMeasurement->status;
                if (isset($statusCounts[$status])) {
                    $statusCounts[$status]++;
                }
            }
            
            // Hitung streak
            $streak = $this->calculateStreak($child);
            if ($streak > $bestStreak) {
                $bestStreak = $streak;
            }
        }
        
        // TODO HARI INI
        $todayTodos = collect();
        foreach ($children as $child) {
            $todos = $child->todos()
                ->whereDate('date', today())
                ->where('is_completed', false)
                ->take(5 - $todayTodos->count())
                ->get();
            $todayTodos = $todayTodos->concat($todos);
            if ($todayTodos->count() >= 5) break;
        }
        
        // PENGUKURAN TERBARU
        $recentMeasurements = Measurement::whereIn('child_id', $children->pluck('id'))
            ->with('child')
            ->orderBy('date', 'desc')
            ->take(5)
            ->get();
        
        // TIPS RANDOM
        $tips = [
            'Anak usia 1-3 tahun butuh 11-14 jam tidur per hari.',
            'Biasakan anak makan sayur dan buah sejak dini.',
            'Ajak anak bermain di luar rumah minimal 30 menit sehari.',
            'Batasi screen time maksimal 1 jam untuk anak di bawah 6 tahun.',
            'Timbang berat badan anak setiap bulan untuk pantau pertumbuhan.',
            'Vitamin A diberikan setiap bulan Februari dan Agustus.',
            'ASI eksklusif sampai 6 bulan, dilanjutkan sampai 2 tahun.',
            'Imunisasi dasar lengkap sebelum usia 1 tahun.',
            'Stimulasi perkembangan dengan mainan sesuai usia.',
            'Konsultasi ke dokter jika anak tidak nafsu makan > 3 hari.'
        ];
        $randomTip = $tips[array_rand($tips)];
        
        // KIRIM SEMUA KE VIEW
        return view('layouts.dashboard', compact(
            'children',              // ← INI PENTING!
            'totalChildren',
            'statusCounts',
            'bestStreak',
            'todayTodos',
            'recentMeasurements',
            'randomTip'
        ));
    }
    
    private function calculateStreak(Child $child)
    {
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
        return $streak;
    }
}
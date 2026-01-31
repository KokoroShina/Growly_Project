<?php

namespace App\Services;

use App\Models\Child;
use Illuminate\Http\Request;

class GrowthService
{
    private $whoStandards = [
        'male' => [
            12 => ['weight_median' => 10.2, 'weight_sd' => 1.2, 'height_median' => 75.7, 'height_sd' => 3.3],
            24 => ['weight_median' => 12.5, 'weight_sd' => 1.5, 'height_median' => 87.1, 'height_sd' => 3.7],
            36 => ['weight_median' => 14.5, 'weight_sd' => 1.8, 'height_median' => 95.2, 'height_sd' => 4.1],
            48 => ['weight_median' => 16.3, 'weight_sd' => 2.1, 'height_median' => 102.3, 'height_sd' => 4.5],
            60 => ['weight_median' => 18.0, 'weight_sd' => 2.4, 'height_median' => 108.4, 'height_sd' => 4.8],
            72 => ['weight_median' => 19.5, 'weight_sd' => 2.7, 'height_median' => 114.5, 'height_sd' => 5.1],
        ],
        'female' => [
            12 => ['weight_median' => 9.5, 'weight_sd' => 1.1, 'height_median' => 74.0, 'height_sd' => 3.2],
            24 => ['weight_median' => 11.8, 'weight_sd' => 1.4, 'height_median' => 85.7, 'height_sd' => 3.6],
            36 => ['weight_median' => 13.8, 'weight_sd' => 1.7, 'height_median' => 94.1, 'height_sd' => 4.0],
            48 => ['weight_median' => 15.8, 'weight_sd' => 2.0, 'height_median' => 101.0, 'height_sd' => 4.4],
            60 => ['weight_median' => 17.5, 'weight_sd' => 2.3, 'height_median' => 107.0, 'height_sd' => 4.7],
            72 => ['weight_median' => 19.0, 'weight_sd' => 2.6, 'height_median' => 112.8, 'height_sd' => 5.0],
        ]
    ];
    
    public function calculate(Child $child, Request $request)
    {
        $ageMonths = $child->age_in_months;
        $gender = $child->gender;
        $weight = $request->weight;
        $height = $request->height;
        
        $standard = $this->getClosestStandard($ageMonths, $gender);
        
        if (!$standard) {
            return $this->calculateByBMI($weight, $height);
        }
        
        $zScoreWeight = ($weight - $standard['weight_median']) / $standard['weight_sd'];
        $zScoreHeight = ($height - $standard['height_median']) / $standard['height_sd'];
        
        $status = $this->classify($zScoreWeight, $zScoreHeight);
        
        return [
            'z_score_weight' => round($zScoreWeight, 2),
            'z_score_height' => round($zScoreHeight, 2),
            'status' => $status,
            'recommendation' => $this->getRecommendation($status),
        ];
    }
    
    private function getClosestStandard($ageMonths, $gender)
    {
        if (!isset($this->whoStandards[$gender])) {
            return null;
        }
        
        $ages = array_keys($this->whoStandards[$gender]);
        
        $closest = null;
        $minDiff = PHP_INT_MAX;
        
        foreach ($ages as $age) {
            $diff = abs($age - $ageMonths);
            if ($diff < $minDiff) {
                $minDiff = $diff;
                $closest = $age;
            }
        }
        
        return $closest ? $this->whoStandards[$gender][$closest] : null;
    }
    
    private function classify($zWeight, $zHeight)
    {
        if ($zWeight < -3 || $zHeight < -3) {
            return 'severely_underweight';
        } elseif ($zWeight < -2 || $zHeight < -2) {
            return 'underweight';
        } elseif ($zWeight > 2) {
            return 'overweight';
        } else {
            return 'normal';
        }
    }
    
    private function calculateByBMI($weight, $height)
    {
        $heightM = $height / 100;
        $bmi = $weight / ($heightM * $heightM);
        
        if ($bmi < 14) {
            $status = 'underweight';
        } elseif ($bmi > 18) {
            $status = 'overweight';
        } else {
            $status = 'normal';
        }
        
        return [
            'z_score_weight' => null,
            'z_score_height' => null,
            'status' => $status,
            'recommendation' => $this->getRecommendation($status),
        ];
    }
    
    private function getRecommendation($status)
    {
        $recommendations = [
            'severely_underweight' => 'Konsultasi segera dengan dokter anak dan ahli gizi.',
            'underweight' => 'Tingkatkan asupan kalori dan protein secara bertahap.',
            'normal' => 'Pertahankan pola makan seimbang dan aktivitas fisik rutin.',
            'overweight' => 'Perhatikan porsi makan dan tingkatkan aktivitas fisik.',
        ];
        
        return $recommendations[$status] ?? 'Pertahankan pola hidup sehat.';
    }
}
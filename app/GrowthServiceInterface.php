<?php

namespace App\Contracts;

use App\Models\Child;
use Illuminate\Http\Request;

interface GrowthServiceInterface
{
    public function calculate(Child $child, Request $request): array;
    public function getRecommendation(string $status): string;
}
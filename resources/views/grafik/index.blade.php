@extends('layouts.app')

@section('title', 'Grafik Pertumbuhan')
@section('page_title', '📈 Grafik Pertumbuhan')
@section('page_subtitle', 'Pantau perkembangan semua anak dalam satu halaman')

@section('content')
<!-- Filter Period -->
<div class="bg-white rounded-xl shadow-lg p-4 mb-6">
    <form method="GET" class="flex items-center space-x-4">
        <label class="text-sm font-medium text-gray-700">Periode:</label>
        <select name="period" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
            <option value="7" {{ $period == 7 ? 'selected' : '' }}>7 Hari</option>
            <option value="30" {{ $period == 30 ? 'selected' : '' }}>30 Hari</option>
            <option value="90" {{ $period == 90 ? 'selected' : '' }}>3 Bulan</option>
            <option value="180" {{ $period == 180 ? 'selected' : '' }}>6 Bulan</option>
            <option value="365" {{ $period == 365 ? 'selected' : '' }}>1 Tahun</option>
        </select>
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">
            Tampilkan
        </button>
    </form>
</div>

<!-- Charts -->
<div class="space-y-8">
    @forelse($children as $child)
        @if(!empty($chartData[$child->id]['labels']))
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $child->name }}</h3>
                <p class="text-sm text-gray-500 mb-4">
                    {{ $child->gender == 'male' ? 'Laki-laki' : 'Perempuan' }} • 
                    {{ floor($child->age_in_months/12) }} tahun {{ $child->age_in_months % 12 }} bulan
                </p>
                
                <div class="h-80 relative">
                    <canvas id="chart-{{ $child->id }}"></canvas>
                </div>
                
                <div class="flex justify-center space-x-6 mt-4">
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-600">Berat Badan (kg)</span>
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-sm text-gray-600">Tinggi Badan (cm)</span>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <div class="text-6xl mb-4">📊</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Data</h3>
            <p class="text-gray-500">Tambahkan pengukuran anak untuk melihat grafik pertumbuhan</p>
        </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @foreach($children as $child)
        @if(!empty($chartData[$child->id]['labels']))
            new Chart(document.getElementById('chart-{{ $child->id }}').getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($chartData[$child->id]['labels']),
                    datasets: [
                        {
                            label: 'Berat Badan (kg)',
                            data: @json($chartData[$child->id]['weight']),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            pointBackgroundColor: 'rgb(59, 130, 246)',
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        },
                        {
                            label: 'Tinggi Badan (cm)',
                            data: @json($chartData[$child->id]['height']),
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            borderWidth: 2,
                            tension: 0.3,
                            pointBackgroundColor: 'rgb(34, 197, 94)',
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            title: {
                                display: true,
                                text: 'kg / cm'
                            }
                        }
                    }
                }
            });
        @endif
    @endforeach
});
</script>
@endsection
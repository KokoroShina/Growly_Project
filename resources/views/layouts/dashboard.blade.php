@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Pantau tumbuh kembang anak dengan mudah')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Anak -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                👶
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Total Anak</p>
                <p class="text-2xl font-bold">{{ $totalChildren ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Status Normal -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                ✅
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Status Normal</p>
                <p class="text-2xl font-bold">{{ $statusCounts['normal'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <!-- Perlu Perhatian -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                ⚠️
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Perlu Perhatian</p>
                <p class="text-2xl font-bold">
                    {{ ($statusCounts['underweight'] ?? 0) + ($statusCounts['overweight'] ?? 0) + ($statusCounts['severely_underweight'] ?? 0) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Streak Terbaik -->
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                🔥
            </div>
            <div class="ml-4">
                <p class="text-sm text-gray-500">Streak Terbaik</p>
                <p class="text-2xl font-bold">{{ $bestStreak ?? 0 }} hari</p>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Anak -->
<div class="bg-white rounded-xl shadow overflow-hidden mb-8">
    <div class="px-6 py-4 border-b flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Anak-anak Anda</h3>
        <a href="{{ route('children.index') }}" class="text-sm text-green-600 hover:text-green-800">Lihat Semua →</a>
    </div>

    @if(isset($children) && $children->count() > 0)
        <div class="divide-y divide-gray-200">
    @foreach($children as $child)
    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
        <div class="flex items-center">
            <!-- Foto/Avatar - OTOMATIS EMOJI ATAU FOTO -->
            <div class="h-10 w-10 rounded-full flex items-center justify-center text-xl
                @if($child->hasPhoto())
                    overflow-hidden
                @else
                    {{ $child->gender == 'male' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}
                @endif">
                
                @if($child->hasPhoto())
                    <img src="{{ $child->photo_url }}" alt="{{ $child->name }}" 
                         class="h-full w-full object-cover rounded-full">
                @else
                    {{ $child->photo_url }}  {{-- Akan nampilin emoji 👦 atau 👧 --}}
                @endif
            </div>
            <div class="ml-4">
                <h4 class="text-sm font-medium text-gray-900">{{ $child->name }}</h4>
                <p class="text-sm text-gray-500">
                    {{ floor($child->age_in_months/12) }} tahun {{ $child->age_in_months % 12 }} bulan
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-4">
            @if($child->latestMeasurement)
                @php
                    $statusClass = match($child->latestMeasurement->status) {
                        'normal' => 'bg-green-100 text-green-700',
                        'underweight' => 'bg-yellow-100 text-yellow-700',
                        'overweight' => 'bg-orange-100 text-orange-700',
                        'severely_underweight' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700'
                    };
                @endphp
                <span class="px-2 py-1 text-xs rounded-full {{ $statusClass }}">
                    {{ ucfirst($child->latestMeasurement->status) }}
                </span>
            @else
                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                    Belum diukur
                </span>
            @endif
            <a href="{{ route('children.show', $child) }}" 
               class="text-sm text-green-600 hover:text-green-800">
                Detail →
            </a>
        </div>
    </div>
    @endforeach
</div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="text-6xl mb-4">👶</div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Belum Ada Data Anak
                </h2>
                <p class="text-gray-600 mb-6">
                    Tambahkan data anak pertama untuk mulai memantau tumbuh kembangnya
                </p>
                <a href="{{ route('children.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    ➕ Tambah Anak Pertama
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Todo Hari Ini -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-medium text-gray-900 mb-4">📋 Todo Hari Ini</h4>
        @if(isset($todayTodos) && $todayTodos->count() > 0)
            <ul class="space-y-3">
                @foreach($todayTodos as $todo)
                <li class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               class="todo-checkbox rounded text-green-600 mr-3" 
                               data-id="{{ $todo->id }}"
                               {{ $todo->is_completed ? 'checked' : '' }}>
                        <span class="text-sm {{ $todo->is_completed ? 'text-gray-500 line-through' : 'text-gray-700' }}">
                            {{ $todo->title }}
                        </span>
                    </div>
                    <span class="text-xs text-gray-400">{{ $todo->child->name ?? '' }}</span>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 text-center py-4">Belum ada todo untuk hari ini</p>
        @endif
        <div class="mt-4 text-right">
            <a href="{{ route('todos.global') }}" class="text-sm text-green-600 hover:text-green-800">
                Lihat Semua →
            </a>
        </div>
    </div>
    
    <!-- Tips Hari Ini -->
    <div class="bg-white rounded-xl shadow p-6">
        <h4 class="font-medium text-gray-900 mb-4">📈 Tips Hari Ini</h4>
        <div class="flex items-start">
            <div class="text-3xl mr-3">💡</div>
            <p class="text-gray-600">{{ $randomTip ?? 'Pantau tumbuh kembang anak secara rutin untuk deteksi dini masalah gizi.' }}</p>
        </div>
    </div>
</div>

<!-- Recent Measurements -->
@if(isset($recentMeasurements) && $recentMeasurements->count() > 0)
<div class="mt-8 bg-white rounded-xl shadow p-6">
    <h4 class="font-medium text-gray-900 mb-4">📊 Pengukuran Terbaru</h4>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Tanggal</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Anak</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Berat</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Tinggi</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($recentMeasurements as $m)
                <tr>
                    <td class="px-4 py-2 text-sm">{{ $m->date->format('d M') }}</td>
                    <td class="px-4 py-2 text-sm">{{ $m->child->name ?? '' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $m->weight }} kg</td>
                    <td class="px-4 py-2 text-sm">{{ $m->height }} cm</td>
                    <td class="px-4 py-2">
                        @php
                            $statusClass = match($m->status) {
                                'normal' => 'bg-green-100 text-green-700',
                                'underweight' => 'bg-yellow-100 text-yellow-700',
                                'overweight' => 'bg-orange-100 text-orange-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp
                        <span class="px-2 py-1 text-xs rounded-full {{ $statusClass }}">
                            {{ ucfirst($m->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle checkbox toggle di dashboard
    document.querySelectorAll('.todo-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const todoId = this.dataset.id;
            fetch(`/todos/${todoId}/toggle`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const span = this.nextElementSibling;
                    if (data.is_completed) {
                        span.classList.add('line-through', 'text-gray-500');
                    } else {
                        span.classList.remove('line-through', 'text-gray-500');
                    }
                    // Optional: refresh halaman setelah 1 detik
                    // setTimeout(() => location.reload(), 1000);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});
</script>
@endsection
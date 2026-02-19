@extends('layouts.app')

@section('title', 'Anak Saya')
@section('page_title', '👶 Anak Saya')
@section('page_subtitle', 'Kelola data dan pantau tumbuh kembang anak')

@section('content')
<!-- Header dengan tombol tambah -->
<div class="flex justify-between items-center mb-6">
    <div>
        <!-- Optional sub-header -->
    </div>
    <a href="{{ route('children.create') }}" 
       class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Anak Baru
    </a>
</div>

<!-- Stats Cards -->
@php
    $totalAnak = $children->count();
    $normalCount = $children->filter(function($child) {
        return $child->latestMeasurement && $child->latestMeasurement->status == 'normal';
    })->count();
    $perluPerhatian = $children->filter(function($child) {
        return $child->latestMeasurement && in_array($child->latestMeasurement->status, ['underweight', 'overweight', 'severely_underweight']);
    })->count();
    $pengukuranHariIni = $children->filter(function($child) {
        return $child->latestMeasurement && $child->latestMeasurement->date->isToday();
    })->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Total Anak</p>
        <p class="text-2xl font-bold">{{ $totalAnak }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Status Normal</p>
        <p class="text-2xl font-bold text-green-600">{{ $normalCount }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Perlu Perhatian</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $perluPerhatian }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-sm text-gray-500">Pengukuran Hari Ini</p>
        <p class="text-2xl font-bold">{{ $pengukuranHariIni }}</p>
    </div>
</div>

<!-- Tabel/List Anak -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Daftar Anak</h3>
    </div>

    @if($children->isEmpty())
        <!-- Empty State  -->
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
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    ➕ Tambah Anak Pertama
                </a>
            </div>
        </div>
    @else
        <!-- Tabel Data Anak -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anak</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Terakhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Update</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($children as $child)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
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
                                        {{ $child->photo_url }}  {{-- Ini akan nampilin emoji --}}
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $child->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $child->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ floor($child->age_in_months/12) }} tahun {{ $child->age_in_months % 12 }} bulan
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($child->latestMeasurement)
                                @php
                                    $status = $child->latestMeasurement->status;
                                    $statusClass = match($status) {
                                        'normal' => 'bg-green-100 text-green-800',
                                        'underweight' => 'bg-yellow-100 text-yellow-800',
                                        'overweight' => 'bg-orange-100 text-orange-800',
                                        'severely_underweight' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                    Belum diukur
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($child->latestMeasurement)
                                {{ $child->latestMeasurement->date->diffForHumans() }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('children.show', $child) }}" class="text-green-600 hover:text-green-900 mr-3">Lihat</a>
                            <a href="{{ route('children.edit', $child) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('children.destroy', $child) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus {{ $child->name }}? Semua data pengukuran akan ikut terhapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(method_exists($children, 'links'))
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $children->links() }}
        </div>
        @endif
    @endif
</div>

<!-- Quick Actions -->
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
        <h4 class="font-medium text-blue-800 mb-2">📊 Ringkasan Cepat</h4>
        <p class="text-sm text-blue-600">
            @if($totalAnak > 0 && $normalCount > 0)
                {{ $normalCount }} dari {{ $totalAnak }} anak berstatus normal
            @else
                Belum ada data pengukuran
            @endif
        </p>
    </div>
    <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
        <h4 class="font-medium text-purple-800 mb-2">🎯 Target Minggu Ini</h4>
        <p class="text-sm text-purple-600">
            Catat pengukuran untuk {{ $totalAnak - $pengukuranHariIni }} anak hari ini
        </p>
    </div>
</div>
@endsection
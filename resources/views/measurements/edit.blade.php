@extends('layouts.app')

@section('title', 'Edit Pengukuran')
@section('page_title', '✏️ Edit Pengukuran')
@section('page_subtitle', 'Ubah data pengukuran anak')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('children.show', $measurement->child) }}" 
           class="inline-flex items-center text-green-600 hover:text-green-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Profil {{ $measurement->child->name }}
        </a>
    </div>

    <!-- Info Anak -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <div class="flex items-center">
            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl">
                {{ $measurement->child->gender == 'male' ? '👦' : '👧' }}
            </div>
            <div class="ml-4">
                <h3 class="font-medium text-blue-900">{{ $measurement->child->name }}</h3>
                <p class="text-sm text-blue-700">
                    {{ floor($measurement->child->age_in_months/12) }} tahun {{ $measurement->child->age_in_months % 12 }} bulan
                </p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('measurements.update', $measurement) }}">
            @csrf
            @method('PUT')
            
            <!-- Tanggal -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Pengukuran *</label>
                <input type="date" name="date" value="{{ old('date', $measurement->date->format('Y-m-d')) }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                @error('date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Berat & Tinggi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Berat Badan (kg) *</label>
                    <input type="number" step="0.1" name="weight" value="{{ old('weight', $measurement->weight) }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    @error('weight')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2">Tinggi Badan (cm) *</label>
                    <input type="number" step="0.1" name="height" value="{{ old('height', $measurement->height) }}" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                    @error('height')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status (readonly) -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Status Saat Ini</label>
                <div class="px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                    @php
                        $statusClass = match($measurement->status) {
                            'normal' => 'bg-green-100 text-green-800',
                            'underweight' => 'bg-yellow-100 text-yellow-800',
                            'overweight' => 'bg-orange-100 text-orange-800',
                            'severely_underweight' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                        {{ ucfirst($measurement->status) }}
                    </span>
                    <span class="ml-2 text-sm text-gray-500">(akan dihitung ulang setelah simpan)</span>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Catatan</label>
                <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">{{ old('notes', $measurement->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('children.show', $measurement->child) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Update Pengukuran
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
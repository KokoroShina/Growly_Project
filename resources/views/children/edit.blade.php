@extends('layouts.app')

@section('title', 'Edit Anak')
@section('page_title', '✏️ Edit Data Anak')
@section('page_subtitle', 'Ubah informasi data anak')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('children.show', $child) }}" class="inline-flex items-center text-green-600 hover:text-green-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Profil
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('children.update', $child) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Name -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Nama Lengkap Anak *</label>
                <input type="text" name="name" value="{{ old('name', $child->name) }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birth Date -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Tanggal Lahir *</label>
                <input type="date" name="birth_date" value="{{ old('birth_date', $child->birth_date->format('Y-m-d')) }}" required 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">
                @error('birth_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Jenis Kelamin *</label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="male" {{ old('gender', $child->gender) == 'male' ? 'checked' : '' }} required class="mr-2">
                        <span>Laki-laki</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="gender" value="female" {{ old('gender', $child->gender) == 'female' ? 'checked' : '' }} required class="mr-2">
                        <span>Perempuan</span>
                    </label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Photo -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Foto Anak</label>
                @if($child->photo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$child->photo_path) }}" class="h-32 rounded-lg">
                        <p class="text-sm text-gray-500 mt-1">Foto saat ini</p>
                    </div>
                @endif
                <input type="file" name="photo" accept="image/*" 
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                <p class="text-sm text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah foto</p>
                @error('photo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-2">Catatan Kesehatan</label>
                <textarea name="notes" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500">{{ old('notes', $child->notes) }}</textarea>
                @error('notes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('children.show', $child) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Tambah Pengukuran')
@section('page_title', '📏 Tambah Pengukuran')
@section('page_subtitle', 'Catat berat dan tinggi badan anak')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('children.show', $childId ?? 1) }}" class="inline-flex items-center text-green-600 hover:text-green-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Profil Anak
        </a>
    </div>

    <!-- Info Anak Card -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <div class="flex items-center">
            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-2xl">
                👦
            </div>
            <div class="ml-4">
                <h3 class="font-medium text-blue-900">Andi Pratama</h3>
                <p class="text-sm text-blue-700">3 tahun 2 bulan • Laki-laki</p>
            </div>
            <div class="ml-auto">
                <span class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full">
                    Pengukuran ke-4
                </span>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('measurements.store') }}">
            @csrf
            <input type="hidden" name="child_id" value="{{ $childId ?? 1 }}">
            
            <!-- Section: Data Pengukuran -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Data Pengukuran</h3>
                
                <!-- Tanggal -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="date">
                        Tanggal Pengukuran *
                    </label>
                    <input
                        id="date"
                        type="date"
                        name="date"
                        value="{{ date('Y-m-d') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                    >
                    <p class="mt-1 text-xs text-gray-500">Default: hari ini</p>
                </div>

                <!-- Berat & Tinggi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Berat -->
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="weight">
                            Berat Badan (kg) *
                        </label>
                        <div class="relative">
                            <input
                                id="weight"
                                type="number"
                                step="0.1"
                                min="1"
                                max="50"
                                name="weight"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="Contoh: 14.5"
                            >
                            <span class="absolute right-3 top-3 text-gray-500">kg</span>
                        </div>
                    </div>

                    <!-- Tinggi -->
                    <div>
                        <label class="block text-gray-700 text-sm font-medium mb-2" for="height">
                            Tinggi Badan (cm) *
                        </label>
                        <div class="relative">
                            <input
                                id="height"
                                type="number"
                                step="0.1"
                                min="30"
                                max="150"
                                name="height"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                                placeholder="Contoh: 95.0"
                            >
                            <span class="absolute right-3 top-3 text-gray-500">cm</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Hasil Perhitungan (Preview) -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-medium text-gray-700">🔍 Preview Hasil</h4>
                    <button type="button" id="calculateBtn" class="text-sm bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                        Hitung Status
                    </button>
                </div>
                
                <!-- Result Box (hidden by default) -->
                <div id="resultBox" class="hidden">
                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div class="bg-white p-3 rounded border">
                            <p class="text-xs text-gray-500">Status Gizi</p>
                            <p id="statusResult" class="font-bold text-green-600">Normal</p>
                        </div>
                        <div class="bg-white p-3 rounded border">
                            <p class="text-xs text-gray-500">Z-Score</p>
                            <p id="zscoreResult" class="font-bold">+0.8</p>
                        </div>
                    </div>
                    <div class="bg-blue-50 p-3 rounded border border-blue-200">
                        <p id="recommendationResult" class="text-sm text-blue-800">
                            💡 Pertahankan pola makan sehat dan aktivitas rutin.
                        </p>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="calculatePrompt" class="text-center py-4 text-gray-500">
                    Klik "Hitung Status" untuk melihat hasil preview
                </div>
            </div>

            <!-- Section: Catatan -->
            <div class="mb-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Catatan</h3>
                
                <div>
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="notes">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Contoh: Setelah imunisasi, nafsu makan menurun, dll."
                    ></textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('children.show', $childId ?? 1) }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Simpan Pengukuran
                </button>
            </div>
        </form>
    </div>

    <!-- Tips Card -->
    <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex">
            <div class="text-green-600 mr-3">📌</div>
            <div>
                <p class="text-sm text-green-800">
                    <strong>Tips Pengukuran:</strong> Lakukan pengukuran di waktu yang sama setiap kali (misal: pagi hari sebelum makan) untuk hasil yang konsisten.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('calculateBtn').addEventListener('click', function() {
        const weight = document.getElementById('weight').value;
        const height = document.getElementById('height').value;
        
        if (!weight || !height) {
            alert('Isi berat dan tinggi badan dulu!');
            return;
        }

        // Simulasi perhitungan (nanti diganti dengan AJAX ke server)
        const age = 38; // dummy umur dalam bulan
        const gender = 'male'; // dummy gender
        
        // Logika sederhana untuk demo
        let status, zscore, recommendation;
        const bmi = weight / ((height/100) * (height/100));
        
        if (bmi < 14) {
            status = 'Underweight';
            zscore = '-2.1';
            recommendation = 'Tingkatkan asupan kalori dan protein. Konsultasi dengan ahli gizi.';
        } else if (bmi > 18) {
            status = 'Overweight';
            zscore = '+2.3';
            recommendation = 'Perhatikan pola makan, kurangi makanan tinggi gula, tingkatkan aktivitas fisik.';
        } else {
            status = 'Normal';
            zscore = '+0.8';
            recommendation = 'Pertahankan pola makan sehat dan aktivitas rutin.';
        }

        // Tampilkan hasil
        document.getElementById('statusResult').textContent = status;
        document.getElementById('zscoreResult').textContent = zscore;
        document.getElementById('recommendationResult').innerHTML = '💡 ' + recommendation;
        
        // Sembunyikan prompt, tampilkan result
        document.getElementById('calculatePrompt').classList.add('hidden');
        document.getElementById('resultBox').classList.remove('hidden');
        
        // Warna status
        const statusEl = document.getElementById('statusResult');
        if (status === 'Normal') {
            statusEl.className = 'font-bold text-green-600';
        } else if (status === 'Underweight') {
            statusEl.className = 'font-bold text-yellow-600';
        } else {
            statusEl.className = 'font-bold text-orange-600';
        }
    });

    // Auto-format input number
    document.getElementById('weight').addEventListener('input', function() {
        if (this.value < 0) this.value = 1;
        if (this.value > 50) this.value = 50;
    });

    document.getElementById('height').addEventListener('input', function() {
        if (this.value < 30) this.value = 30;
        if (this.value > 150) this.value = 150;
    });
</script>
@endsection
@extends('layouts.app')

@section('title', 'Profil Anak')
@section('page_title', '👤 Profil Anak')
@section('page_subtitle', 'Detail informasi dan riwayat pertumbuhan anak')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('children.index') }}" class="inline-flex items-center text-green-600 hover:text-green-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Anak
        </a>
    </div>

    <!-- Profile Header Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between">
            <div class="flex items-center space-x-4">
                <!-- Foto/Avatar -->
                <div class="h-20 w-20 rounded-full bg-green-100 flex items-center justify-center text-4xl text-green-600">
                    👦
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ $child->name }}</h2>
                    <div class="flex flex-wrap gap-2 mt-2">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $child->birth_date->format('d F Y') }}</span>
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">{{$child->gender == 'male' ? 'laki laki' : 'perempuan'}}</span>
                    </div>
                </div>
            </div>
            
            <!-- Status Gizi -->
            <div class="mt-4 md:mt-0">
                <div class="text-center">
                    <p class="text-sm text-gray-500 mb-1">Status Gizi</p>
                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full text-lg font-semibold">
                        🟢 Normal
                    </span>
                </div>
            </div>
        </div>

        <!-- Info Tambahan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t">
            <div>
                <p class="text-sm text-gray-500">Tanggal Lahir</p>
                <p class="font-medium">15 Januari 2023</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Usia (bulan)</p>
                <p class="font-medium">38 bulan</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Terakhir Diukur</p>
                <p class="font-medium">2 hari lalu</p>
            </div>
        </div>

        <!-- Catatan Kesehatan -->
        <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
            <p class="text-sm font-medium text-yellow-800 mb-1">📝 Catatan Kesehatan</p>
            <p class="text-sm text-yellow-700">Alergi susu sapi, perlu perhatian khusus untuk asupan protein.</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="#" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Pengukuran
        </a>
        <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Edit Profil
        </a>
        <button class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Hapus
        </button>
    </div>

    <!-- Growth Chart Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">📈 Grafik Pertumbuhan</h3>
        <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
            <p class="text-gray-400">Grafik akan tampil di sini (Chart.js)</p>
        </div>
        <div class="flex justify-center space-x-6 mt-4">
            <div class="flex items-center">
                <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                <span class="text-sm text-gray-600">Berat Badan</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                <span class="text-sm text-gray-600">Tinggi Badan</span>
            </div>
            <div class="flex items-center">
                <span class="w-3 h-3 bg-gray-300 rounded-full mr-2"></span>
                <span class="text-sm text-gray-600">Standar WHO</span>
            </div>
        </div>
    </div>

    <!-- Riwayat Pengukuran & Todo List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Riwayat Pengukuran (2 kolom) -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">📋 Riwayat Pengukuran</h3>
                <a href="#" class="text-sm text-green-600 hover:text-green-800">Lihat Semua</a>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berat</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tinggi</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">13 Feb 2026</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">14.5 kg</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">95.0 cm</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Normal
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">06 Feb 2026</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">14.2 kg</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">94.5 cm</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Underweight
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm">
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-2">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Todo List Sidebar (1 kolom) -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">✅ Todo List</h3>
                <span class="text-sm bg-orange-100 text-orange-800 px-2 py-1 rounded-full">🔥 Streak 7 hari</span>
            </div>
            
            <!-- Add Todo Form -->
            <form class="mb-4 flex">
                <input type="text" placeholder="Tambah todo..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-green-500">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-r-lg hover:bg-green-700">
                    Tambah
                </button>
            </form>

            <!-- Todo List -->
            <ul class="space-y-3">
                <li class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" class="rounded text-green-600 mr-3">
                        <span class="text-sm text-gray-700">Ukur berat badan</span>
                    </div>
                    <button class="text-red-500 hover:text-red-700">✕</button>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" class="rounded text-green-600 mr-3" checked>
                        <span class="text-sm text-gray-500 line-through">Beri vitamin</span>
                    </div>
                    <button class="text-red-500 hover:text-red-700">✕</button>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" class="rounded text-green-600 mr-3">
                        <span class="text-sm text-gray-700">Catat pola makan</span>
                    </div>
                    <button class="text-red-500 hover:text-red-700">✕</button>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" class="rounded text-green-600 mr-3">
                        <span class="text-sm text-gray-700">Aktivitas fisik 30 menit</span>
                    </div>
                    <button class="text-red-500 hover:text-red-700">✕</button>
                </li>
            </ul>

            <!-- Progress -->
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Progress hari ini</span>
                    <span class="font-medium">1/4 selesai</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 25%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Section -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="text-blue-600 text-2xl mr-4">💡</div>
            <div>
                <h4 class="font-medium text-blue-800 mb-2">Rekomendasi Berdasarkan Status</h4>
                <p class="text-blue-700">
                    Status gizi normal. Pertahankan pola makan sehat dan aktivitas fisik rutin. 
                    Lanjutkan pengukuran setiap minggu untuk memantau perkembangan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Nanti untuk chart.js dan interaktivitas lainnya
    console.log('Halaman detail anak siap');
</script>
@endsection
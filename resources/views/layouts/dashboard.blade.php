<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Growly</title>
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/dashboard" class="text-xl font-bold text-green-600 flex items-center">
                        <span class="text-2xl mr-2">🌱</span> Growly
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="/children" class="text-gray-700 hover:text-green-600">👶 Anak Saya</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="text-gray-700 hover:text-red-600">🚪 Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                Selamat Datang, {{ Auth::user()->name }}! 👋
            </h1>
            <p class="text-gray-600 mt-2">
                Pantau tumbuh kembang anak dengan mudah
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Anak -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        👶
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Anak</p>
                        <p class="text-2xl font-bold">0</p>
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
                        <p class="text-2xl font-bold">0</p>
                    </div>
                </div>
            </div>

            <!-- Streak -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        🔥
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Streak Terbaik</p>
                        <p class="text-2xl font-bold">0 hari</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State / Anak List -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Anak-anak Anda</h3>
            </div>

            <!-- Jika belum ada anak -->
            <div class="text-center py-12">
                <div class="max-w-md mx-auto">
                    <div class="text-6xl mb-4">👶</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        Belum Ada Data Anak
                    </h2>
                    <p class="text-gray-600 mb-6">
                        Tambahkan data anak pertama untuk mulai memantau tumbuh kembangnya
                    </p>
                    <a href="/children/create" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                        ➕ Tambah Anak Pertama
                    </a>
                </div>
            </div>

            <!-- Jika ada anak (nanti diisi) -->
            <!--
            <div class="divide-y divide-gray-200">
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                            👦
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-gray-900">Andi</h4>
                            <p class="text-sm text-gray-500">3 tahun • Laki-laki</p>
                        </div>
                    </div>
                    <a href="/children/1" 
                       class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Lihat Profil
                    </a>
                </div>
            </div>
            -->
        </div>

        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h4 class="font-medium text-gray-900 mb-4">📋 Todo Hari Ini</h4>
                <ul class="space-y-2">
                    <li class="flex items-center">
                        <input type="checkbox" class="rounded text-green-600">
                        <span class="ml-2 text-gray-700">Ukur berat badan anak</span>
                    </li>
                    <li class="flex items-center">
                        <input type="checkbox" class="rounded text-green-600">
                        <span class="ml-2 text-gray-700">Beri vitamin</span>
                    </li>
                </ul>
            </div>
            
            <div class="bg-white rounded-xl shadow p-6">
                <h4 class="font-medium text-gray-900 mb-4">📈 Tips Hari Ini</h4>
                <p class="text-gray-600">
                    Anak usia 1-3 tahun butuh 11-14 jam tidur per hari termasuk tidur siang.
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="mt-8 pt-6 border-t">
        <div class="max-w-7xl mx-auto text-center text-gray-500 text-sm">
            &copy; 2026 Growly - Capstone Project PABCL
        </div>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anak Saya - Growly</title>
    @vite('resources/css/app.css')
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
                    <a href="/dashboard" class="text-gray-700 hover:text-green-600">📊 Dashboard</a>
                    <a href="/children" class="text-gray-700 hover:text-green-600 font-medium">👶 Anak Saya</a>
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
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">👶 Anak Saya</h1>
                <p class="text-gray-600 mt-2">Kelola data anak-anak Anda</p>
            </div>
            <a href="/children/create" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                ➕ Tambah Anak Baru
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Total Anak</p>
                <p class="text-2xl font-bold">0</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Status Normal</p>
                <p class="text-2xl font-bold">0</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Perlu Perhatian</p>
                <p class="text-2xl font-bold">0</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow">
                <p class="text-sm text-gray-500">Update Terakhir</p>
                <p class="text-2xl font-bold">-</p>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-medium text-gray-900">Daftar Anak</h3>
            </div>

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
                    <a href="/children/create" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                        ➕ Tambah Anak Pertama
                    </a>
                </div>
            </div>

            <!-- Table Content (akan diisi nanti) -->
            <!--
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Umur</th>
                            <th class="px-6 py-3 text-left text-xs font-gray-500 uppercase">Status Terakhir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Update</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        👦
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Andi</div>
                                        <div class="text-sm text-gray-500">Laki-laki</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">3 tahun 2 bulan</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Normal
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                2 hari lalu
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="/children/1" class="text-green-600 hover:text-green-900 mr-3">Lihat</a>
                                <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <a href="#" class="text-red-600 hover:text-red-900">Hapus</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            -->
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
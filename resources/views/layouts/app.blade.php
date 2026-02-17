<!DOCTYPE html>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Growly') - Pantau Tumbuh Kembang Anak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-gray-50">

```
<!-- Mobile Menu Button -->
<button id="mobileMenuBtn"
    class="lg:hidden fixed top-4 left-4 z-50 p-2 bg-white rounded-lg shadow">
    ☰
</button>

<!-- Sidebar -->
<aside id="sidebar"
    class="sidebar fixed top-0 left-0 h-full w-250px bg-white shadow-lg z-40 hidden lg:block">

    <!-- Logo -->
    <div class="p-6 border-b">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                <span class="text-xl">🌱</span>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Growly</h1>
                <p class="text-xs text-gray-500">Pantau Anak</p>
            </div>
        </div>
    </div>

    <!-- User -->
    <div class="p-4 border-b">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                <span class="text-lg">👤</span>
            </div>
            <div class="text-sm text-gray-700">
                User
            </div>
        </div>
    </div>

    <!-- Menu -->
    <nav class="p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50
                   {{ request()->routeIs('dashboard') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('children.index') }}"
                   class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50
                   {{ request()->routeIs('children.*') ? 'bg-green-50 text-green-700' : 'text-gray-700' }}">
                    <span>👶</span>
                    <span>Anak Saya</span>
                </a>
            </li>

            <li>
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 text-gray-700">
                    <span>📈</span>
                    <span>Grafik</span>
                </a>
            </li>

            <li>
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 text-gray-700">
                    <span>✅</span>
                    <span>Todo List</span>
                </a>
            </li>

            <li>
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-green-50 text-gray-700">
                    <span>⚙️</span>
                    <span>Pengaturan</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Logout -->
    <div class="absolute bottom-0 w-full p-4 border-t">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center space-x-3 p-3 w-full rounded-lg hover:bg-red-50 text-gray-700 hover:text-red-700">
                <span>🚪</span>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</aside>


<!-- Main Content Area -->
<main id="mainContent" class="min-h-screen lg:ml-250px">

    <div class="p-4 lg:p-8">

        <!-- Center Container (INI YANG BIKIN SIMETRIS) -->
        <div class="max-w-7xl mx-auto">

            <!-- Page Header -->
            <div class="mb-8 max-w-5xl mx-auto">
                <h2 class="text-2xl font-bold text-gray-900 mx-auto">
                    @yield('page_title')
                </h2>
                <p class="text-gray-600 mt-1">
                    @yield('page_subtitle')
                </p>

            <!-- Page Content -->
            @yield('content')

            <!-- Footer -->
            <footer class="mt-12 pt-6 border-t text-center text-gray-500 text-sm">
                &copy; 2026 Growly - Capstone Project PABCL
            </footer>

        </div>
    </div>
</main>


<!-- Mobile Script -->
<script>
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const sidebar = document.getElementById('sidebar');

    mobileMenuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
    });

    document.addEventListener('click', (e) => {
        if (window.innerWidth < 1024) {
            if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                sidebar.classList.add('hidden');
            }
        }
    });
</script>

@yield('scripts')
```

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Growly</title>
    @vite('resources/css/app.css')
    <style>
        body { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 te">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <span class="text-3xl">🌱</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Growly</h1>
            <p class="text-gray-600 mt-2">Pantau Tumbuh Kembang Anak</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Masuk ke Akun</h2>
            
            <!-- Error/Success Messages -->
            @if(session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <p class="text-red-600 text-sm">{{ session('error') }}</p>
            </div>
            @endif
            
            @if(session('status'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-green-600 text-sm">{{ session('status') }}</p>
            </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="/login">
                @csrf
                
                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="nama@email.com"
                    >
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300 mb-4"
                >
                    Masuk
                </button>

                <!-- Register Link -->
                <div class="text-center">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="/register" class="font-medium text-green-600 hover:text-green-800">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-gray-500 text-sm">
            &copy; 2026 Growly - Capstone Project PABCL
        </div>
    </div>
</body>
</html>
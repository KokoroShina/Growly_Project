{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Growly</title>
    @vite('resources/css/app.css')
    <style>
        body { background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                <span class="text-3xl">🌱</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Growly</h1>
            <p class="text-gray-600 mt-2">Daftar akun baru</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Buat Akun Baru</h2>
            
            @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-red-600 text-sm list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <!-- Name -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="name">
                        Nama Lengkap
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Nama Anda"
                    >
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="email">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
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
                        placeholder="Minimal 8 karakter"
                    >
                    <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2" for="password_confirmation">
                        Konfirmasi Password
                    </label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Ulangi password"
                    >
                </div>

                <!-- Terms -->
                <div class="mb-6">
                    <div class="flex items-start">
                        <input
                            id="terms"
                            type="checkbox"
                            name="terms"
                            required
                            class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded mt-1"
                        >
                        <label for="terms" class="ml-2 text-sm text-gray-700">
                            Saya setuju dengan 
                            <a href="#" class="text-green-600 hover:text-green-800">Syarat & Ketentuan</a>
                            dan 
                            <a href="#" class="text-green-600 hover:text-green-800">Kebijakan Privasi</a>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg transition duration-300 mb-4"
                >
                    Daftar Sekarang
                </button>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-800">
                            Masuk di sini
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
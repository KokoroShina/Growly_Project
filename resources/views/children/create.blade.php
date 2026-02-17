@extends('layouts.app')
@section('title', 'Tambah Anak') 
@section('page_title','➕ Tambah Anak Baru')
@section('page_subtitle', 'Isi data anak untuk mulaimemantau tumbuh kembangnya')
@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a
            href="{{ route('children.index') }}"
            class="inline-flex items-center text-green-600 hover:text-green-800"
        >
            <svg
                class="w-5 h-5 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                />
            </svg>
            Kembali ke Daftar Anak
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="POST" action="{{ route('children.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Section 1: Basic Info -->
            <div class="mb-8">
                <h3
                    class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b"
                >
                    Informasi Dasar
                </h3>

                <!-- Name -->
                <div class="mb-6">
                    <label
                        class="block text-gray-700 text-sm font-medium mb-2"
                        for="name"
                    >
                        Nama Lengkap Anak *
                    </label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Contoh: Andi Pratama"
                    />
                </div>

                <!-- Birth Date & Gender -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Birth Date -->
                    <div>
                        <label
                            class="block text-gray-700 text-sm font-medium mb-2"
                            for="birth_date"
                        >
                            Tanggal Lahir *
                        </label>
                        <input
                            id="birth_date"
                            type="date"
                            name="birth_date"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        />
                        <p class="mt-1 text-xs text-gray-500">
                            Otomatis menghitung usia
                        </p>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label
                            class="block text-gray-700 text-sm font-medium mb-2"
                        >
                            Jenis Kelamin *
                        </label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input
                                    type="radio"
                                    name="gender"
                                    value="male"
                                    required
                                    class="mr-2 text-green-600"
                                />
                                <span>Laki-laki</span>
                            </label>
                            <label class="flex items-center">
                                <input
                                    type="radio"
                                    name="gender"
                                    value="female"
                                    required
                                    class="mr-2 text-green-600"
                                />
                                <span>Perempuan</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload -->
                <div class="mb-6">
                    <label
                        class="block text-gray-700 text-sm font-medium mb-2"
                        for="photo"
                    >
                        Foto Anak (Opsional)
                    </label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-400 transition cursor-pointer"
                        onclick="document.getElementById('photo').click()"
                    >
                        <div class="text-4xl mb-2">📷</div>
                        <p class="text-gray-600 mb-2">Klik untuk upload foto</p>
                        <p class="text-sm text-gray-500">
                            Maksimal 2MB. Format: JPG, PNG
                        </p>
                        <input
                            type="file"
                            id="photo"
                            name="photo"
                            class="hidden"
                            accept="image/*"
                        />
                    </div>
                    <div id="preview" class="mt-2 hidden">
                        <img id="previewImage" class="h-32 rounded-lg" />
                    </div>
                </div>
            </div>

            <!-- Section 2: Additional Info -->
            <div class="mb-8">
                <h3
                    class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b"
                >
                    Informasi Tambahan
                </h3>

                <!-- Notes -->
                <div>
                    <label
                        class="block text-gray-700 text-sm font-medium mb-2"
                        for="notes"
                    >
                        Catatan Kesehatan
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="4"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                        placeholder="Contoh: Alergi susu sapi, riwayat asma, kondisi khusus lainnya..."
                    ></textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        Informasi penting untuk perhatian khusus
                    </p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a
                    href="{{ route('children.index') }}"
                    class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition"
                >
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center"
                >
                    <svg
                        class="w-5 h-5 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                        />
                    </svg>
                    Simpan Data Anak
                </button>
            </div>
        </form>
    </div>

    <!-- Help Text -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="text-blue-600 mr-3">💡</div>
            <div>
                <p class="text-sm text-blue-800">
                    <strong>Tips:</strong> Isi data seakurat mungkin. Setelah
                    menambahkan anak, Anda bisa langsung mencatat pengukuran
                    pertama untuk melihat status gizinya.
                </p>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Photo preview
    document.getElementById("photo").addEventListener("change", function (e) {
        const file = e.target.files[0];
        const preview = document.getElementById("preview");
        const previewImage = document.getElementById("previewImage");

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                preview.classList.remove("hidden");
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add("hidden");
        }
    });

    // Auto-calculate age
    document
        .getElementById("birth_date")
        .addEventListener("change", function () {
            const birthDate = new Date(this.value);
            const today = new Date();
            const ageInMonths =
                (today.getFullYear() - birthDate.getFullYear()) * 12 +
                (today.getMonth() - birthDate.getMonth());

            if (ageInMonths >= 0 && ageInMonths <= 72) {
                // 0-6 tahun
                console.log(
                    "Umur:",
                    Math.floor(ageInMonths / 12),
                    "tahun",
                    ageInMonths % 12,
                    "bulan",
                );
            }
        });
</script>
@endsection

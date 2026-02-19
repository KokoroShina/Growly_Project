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
            <!-- Foto/Avatar --->
            <div class="h-20 w-20 rounded-full flex items-center justify-center text-4xl
                @if($child->hasPhoto())
                    overflow-hidden
                @else
                    {{ $child->gender == 'male' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}
                @endif">
                
                @if($child->hasPhoto())
                    <img src="{{ $child->photo_url }}" alt="{{ $child->name }}" 
                         class="h-full w-full object-cover rounded-full">
                @else
                    {{ $child->photo_url }}  {{-- Kalau gak ada foto bakalan nampilin emoji cwk/cwk --}}
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $child->name }}</h2>
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">{{ $child->birth_date->format('d F Y') }}</span>
                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">{{ $child->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                </div>
            </div>
        </div>
        
        <!-- Status Gizi -->
        <div class="mt-4 md:mt-0">
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-1">Status Gizi</p>
                @php
                    $latestMeasurement = $child->measurements->last();
                    $statusClass = match($latestMeasurement->status ?? '') {
                        'normal' => 'bg-green-100 text-green-800',
                        'underweight' => 'bg-yellow-100 text-yellow-800',
                        'overweight' => 'bg-orange-100 text-orange-800',
                        'severely_underweight' => 'bg-red-100 text-red-800',
                        default => 'bg-gray-100 text-gray-800'
                    };
                @endphp
                <span class="px-4 py-2 {{ $statusClass }} rounded-full text-lg font-semibold">
                    {{ $latestMeasurement ? ucfirst($latestMeasurement->status) : 'Belum diukur' }}
                </span>
            </div>
        </div>
    </div>

    <!-- Info Tambahan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 pt-6 border-t">
        <div>
            <p class="text-sm text-gray-500">Tanggal Lahir</p>
            <p class="font-medium">{{ $child->birth_date->format('d F Y') }}</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Usia (bulan)</p>
            <p class="font-medium">{{ $child->age_in_months }} bulan</p>
        </div>
        <div>
            <p class="text-sm text-gray-500">Terakhir Diukur</p>
            <p class="font-medium">{{ $latestMeasurement ? $latestMeasurement->date->diffForHumans() : '-' }}</p>
        </div>
    </div>

    <!-- Catatan Kesehatan -->
    @if($child->notes)
    <div class="mt-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
        <p class="text-sm font-medium text-yellow-800 mb-1">📝 Catatan Kesehatan</p>
        <p class="text-sm text-yellow-700">{{ $child->notes }}</p>
    </div>
    @endif
</div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-3 mb-6">
        <a href="{{ route('measurements.create', $child) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Tambah Pengukuran
        </a>
        <a href="{{ route('children.edit', $child) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
            </svg>
            Edit Profil
        </a>
        <form action="{{ route('children.destroy', $child) }}" method="post" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition" onclick="return confirm('Yakin ingin menghapus {{ $child->name }}?')">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </form>
    </div>

    <!-- Growth Chart Section -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">📈 Grafik Pertumbuhan</h3>
        
        @if(count($chartData['labels']) > 0)
            <div class="h-80 relative">
                <canvas id="growthChart"></canvas>
            </div>
            <div class="flex justify-center space-x-6 mt-4">
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                    <span class="text-sm text-gray-600">Berat Badan (kg)</span>
                </div>
                <div class="flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                    <span class="text-sm text-gray-600">Tinggi Badan (cm)</span>
                </div>
            </div>
        @else
            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                <p class="text-gray-400">Belum ada data pengukuran untuk ditampilkan</p>
            </div>
        @endif
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tinggi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($child->measurements->sortByDesc('date') as $measurement)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $measurement->date->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $measurement->weight }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $measurement->height }} cm</td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('measurements.edit', $measurement) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    Edit
                                </a>
                                <form action="{{ route('measurements.destroy', $measurement) }}" method="post" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin ingin menghapus pengukuran ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Belum ada data pengukuran
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Todo List Sidebar -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">✅ Todo List Hari Ini</h3>
                <span class="text-sm bg-orange-100 text-orange-800 px-2 py-1 rounded-full">
                    🔥 Streak {{ $streak ?? 0 }} hari
                </span>
            </div>
            
            <!-- Add Todo Form -->
            <form id="todoForm" class="mb-4 flex">
                @csrf
                <input type="text" id="todoTitle" name="title" placeholder="Tambah todo..." 
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                       autocomplete="off">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-r-lg hover:bg-green-700 transition">
                    Tambah
                </button>
            </form>

            <!-- Todo List -->
            <ul id="todoList" class="space-y-3">
                @forelse($todos ?? [] as $todo)
                <li class="flex items-center justify-between group" data-id="{{ $todo->id }}">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               class="todo-checkbox rounded text-green-600 mr-3" 
                               {{ $todo->is_completed ? 'checked' : '' }}>
                        <span class="text-sm {{ $todo->is_completed ? 'text-gray-500 line-through' : 'text-gray-700' }}">
                            {{ $todo->title }}
                        </span>
                    </div>
                    <button class="delete-todo text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition">
                        ✕
                    </button>
                </li>
                @empty
                <li class="text-center text-gray-500 py-4">
                    Belum ada todo untuk hari ini
                </li>
                @endforelse
            </ul>

            <!-- Progress -->
            @php
                $totalTodos = count($todos ?? []);
                $completedTodos = $todos ? $todos->where('is_completed', true)->count() : 0;
                $progress = $totalTodos > 0 ? ($completedTodos / $totalTodos) * 100 : 0;
            @endphp
            
            @if($totalTodos > 0)
            <div class="mt-4 pt-4 border-t">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Progress hari ini</span>
                    <span class="font-medium">{{ $completedTodos }}/{{ $totalTodos }} selesai</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Rekomendasi Section -->
    @if($latestMeasurement)
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <div class="text-blue-600 text-2xl mr-4">💡</div>
            <div>
                <h4 class="font-medium text-blue-800 mb-2">Rekomendasi Berdasarkan Status</h4>
                <p class="text-blue-700">
                    @php
                        $recommendations = [
                            'normal' => 'Status gizi normal. Pertahankan pola makan sehat dan aktivitas fisik rutin. Lanjutkan pengukuran setiap minggu untuk memantau perkembangan.',
                            'underweight' => 'Anak underweight. Tingkatkan asupan kalori dan protein. Konsultasi dengan ahli gizi untuk menu makanan yang tepat.',
                            'overweight' => 'Anak overweight. Perhatikan porsi makan, kurangi makanan tinggi gula, tingkatkan aktivitas fisik.',
                            'severely_underweight' => 'Anak severely underweight. Segera konsultasi dengan dokter anak dan ahli gizi untuk penanganan lebih lanjut.'
                        ];
                    @endphp
                    {{ $recommendations[$latestMeasurement->status] ?? 'Pertahankan pola hidup sehat.' }}
                </p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@if(count($chartData['labels']) > 0)
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== CHART.JS ==========
    const canvas = document.getElementById('growthChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        const labels = @json($chartData['labels']);
        const weightData = @json($chartData['weight']);
        const heightData = @json($chartData['height']);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Berat Badan (kg)',
                        data: weightData,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: 'white',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    },
                    {
                        label: 'Tinggi Badan (cm)',
                        data: heightData,
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        pointBackgroundColor: 'rgb(34, 197, 94)',
                        pointBorderColor: 'white',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    }
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== TODO LIST ==========
    const todoForm = document.getElementById('todoForm');
    const todoList = document.getElementById('todoList');
    const todoTitle = document.getElementById('todoTitle');
    const childId = {{ $child->id }};

    if (!todoForm || !todoList) return;

    // Tambah todo
    todoForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const title = todoTitle.value.trim();
        if (!title) return;

        fetch(`/children/${childId}/todos`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title: title })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Hapus empty state
                const emptyState = todoList.querySelector('.text-center.text-gray-500');
                if (emptyState) emptyState.remove();

                // Tambah todo baru
                const newTodo = document.createElement('li');
                newTodo.className = 'flex items-center justify-between group';
                newTodo.dataset.id = data.todo.id;
                newTodo.innerHTML = `
                    <div class="flex items-center">
                        <input type="checkbox" class="todo-checkbox rounded text-green-600 mr-3">
                        <span class="text-sm text-gray-700">${data.todo.title}</span>
                    </div>
                    <button class="delete-todo text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition">✕</button>
                `;
                todoList.appendChild(newTodo);
                
                todoTitle.value = '';
                updateStreak(data.streak);
                updateProgress();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // TOGGLE CHECKBOX
    todoList.addEventListener('change', function(e) {
        if (!e.target.classList.contains('todo-checkbox')) return;
        
        const li = e.target.closest('li');
        if (!li) return;
        
        const todoId = li.dataset.id;
        const span = li.querySelector('span');
        
        fetch(`/todos/${todoId}/toggle`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (data.is_completed) {
                    span.classList.add('line-through', 'text-gray-500');
                    span.classList.remove('text-gray-700');
                } else {
                    span.classList.remove('line-through', 'text-gray-500');
                    span.classList.add('text-gray-700');
                }
                updateStreak(data.streak);
                updateProgress();
            }
        });
    });

    // Delete Todo
    todoList.addEventListener('click', function(e) {
        if (!e.target.classList.contains('delete-todo')) return;
        
        const li = e.target.closest('li');
        if (!li) return;
        
        const todoId = li.dataset.id;
        
        if (confirm('Yakin ingin menghapus todo ini?')) {
            fetch(`/todos/${todoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    li.remove();
                    
                    if (todoList.children.length === 0) {
                        todoList.innerHTML = '<li class="text-center text-gray-500 py-4">Belum ada todo untuk hari ini</li>';
                    }
                    
                    updateStreak(data.streak);
                    updateProgress();
                }
            });
        }
    });

    function updateStreak(streak) {
        const streakEl = document.querySelector('.bg-orange-100');
        if (streakEl) {
            streakEl.textContent = `🔥 Streak ${streak} hari`;
        }
    }

    function updateProgress() {
        const checkboxes = document.querySelectorAll('.todo-checkbox');
        const total = checkboxes.length;
        const completed = Array.from(checkboxes).filter(cb => cb.checked).length;
        
        if (total === 0) {
            const progressContainer = document.querySelector('.mt-4.pt-4.border-t');
            if (progressContainer) progressContainer.remove();
            return;
        }
        
        let progressContainer = document.querySelector('.todo-progress');
        if (!progressContainer) {
            const sidebar = document.querySelector('.bg-white.rounded-xl.shadow-lg.p-6:last-child');
            progressContainer = document.createElement('div');
            progressContainer.className = 'mt-4 pt-4 border-t todo-progress';
            sidebar.appendChild(progressContainer);
        }
        
        const percentage = (completed / total) * 100;
        progressContainer.innerHTML = `
            <div class="flex justify-between text-sm mb-1">
                <span class="text-gray-600">Progress hari ini</span>
                <span class="font-medium">${completed}/${total} selesai</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-600 h-2 rounded-full" style="width: ${percentage}%"></div>
            </div>
        `;
    }
});
</script>
@endsection
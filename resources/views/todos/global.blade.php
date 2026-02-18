@extends('layouts.app')

@section('title', 'Todo List')
@section('page_title', '✅ Todo List')
@section('page_subtitle', 'Kelola semua tugas dan pantau konsistensi')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Total Todo</p>
        <p class="text-2xl font-bold">{{ $totalTodos }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Selesai</p>
        <p class="text-2xl font-bold text-green-600">{{ $completedTodos }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $pendingTodos }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Total Streak</p>
        <p class="text-2xl font-bold text-orange-600">{{ $totalStreak }} hari</p>
    </div>
</div>

<!-- Todo List by Date -->
<div class="space-y-6">
    @forelse($todosByDate as $date => $todos)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gray-50 px-6 py-3 border-b">
                <h3 class="font-medium text-gray-900">
                    {{ Carbon\Carbon::parse($date)->format('l, d F Y') }}
                    @if(Carbon\Carbon::parse($date)->isToday())
                        <span class="ml-2 text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Hari Ini</span>
                    @endif
                </h3>
            </div>
            
            <div class="divide-y divide-gray-200">
                @foreach($todos as $todo)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition group">
                    <div class="flex items-center flex-1">
                        <input type="checkbox" 
                               class="todo-checkbox rounded text-green-600 mr-4" 
                               {{ $todo->is_completed ? 'checked' : '' }}
                               data-id="{{ $todo->id }}">
                        <div>
                            <p class="{{ $todo->is_completed ? 'text-gray-500 line-through' : 'text-gray-900' }}">
                                {{ $todo->title }}
                            </p>
                            <p class="text-sm text-gray-500">
                                Anak: {{ $todo->child->name }}
                                @if($todo->description)
                                    • {{ $todo->description }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition">
                        <button class="delete-todo text-red-500 hover:text-red-700 p-1" data-id="{{ $todo->id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <div class="text-6xl mb-4">✅</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Todo</h3>
            <p class="text-gray-500 mb-6">Tambahkan todo di halaman masing-masing anak</p>
            <a href="{{ route('children.index') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg">
                Lihat Anak Saya
            </a>
        </div>
    @endforelse
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle checkbox
    document.querySelectorAll('.todo-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const todoId = this.dataset.id;
            fetch(`/todos/${todoId}/toggle`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const text = this.nextElementSibling.querySelector('p:first-child');
                    if (data.is_completed) {
                        text.classList.add('line-through', 'text-gray-500');
                        text.classList.remove('text-gray-900');
                    } else {
                        text.classList.remove('line-through', 'text-gray-500');
                        text.classList.add('text-gray-900');
                    }
                    location.reload(); // Refresh buat update stats
                }
            });
        });
    });
    
    // Delete todo
    document.querySelectorAll('.delete-todo').forEach(button => {
        button.addEventListener('click', function() {
            if (!confirm('Yakin ingin menghapus todo ini?')) return;
            
            const todoId = this.dataset.id;
            fetch(`/todos/${todoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.closest('.px-6.py-4').remove();
                }
            });
        });
    });
});
</script>
@endsection
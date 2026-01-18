@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-10">Админ-панель</h1>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <p class="mb-6 text-lg text-slate-700">Добро пожаловать в админ-панель!</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.posts.index') }}" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                    Управление постами
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="px-6 py-3 bg-slate-600 text-white font-medium rounded-lg hover:bg-slate-700 transition-colors shadow-sm">
                    Настройки баннера
                </a>
            </div>
        </div>
    </div>
@endsection

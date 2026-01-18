@extends('layouts.app')

@section('title', 'Редактировать категорию')

@section('content')
    <div class="max-w-2xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-10">Редактировать категорию</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.categories.update', $category->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Название -->
            <div class="space-y-2">
                <x-input-label for="title" value="Название категории *" class="text-slate-700 font-medium" />
                <x-text-input id="title"
                              name="title"
                              type="text"
                              class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition text-slate-800"
                              value="{{ old('title', $category->title) }}"
                              required
                              autofocus
                              placeholder="Например: Технологии" />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <p class="mt-1 text-sm text-slate-500">Slug будет автоматически обновлен из названия</p>
            </div>

            <!-- Текущий slug -->
            <div>
                <p class="text-sm text-slate-600">Текущий slug: <code class="bg-slate-100 px-2 py-1 rounded text-slate-800">{{ $category->slug }}</code></p>
            </div>

            <!-- Кнопки -->
            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                    Сохранить изменения
                </button>
                <a href="{{ route('user.categories.index') }}" class="px-6 py-3 border-2 border-gray-200 text-slate-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection

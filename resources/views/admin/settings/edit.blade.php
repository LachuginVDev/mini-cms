@extends('layouts.app')

@section('title', 'Настройки баннера')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-10">Настройки баннера</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            @csrf
            @method('PATCH')

            <div class="space-y-2">
                <label for="banner_title" class="block text-sm font-medium text-slate-700">Заголовок баннера *</label>
                <input type="text" 
                       id="banner_title" 
                       name="banner_title" 
                       value="{{ old('banner_title', $bannerTitle) }}" 
                       required
                       class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-slate-800 transition"
                       placeholder="Например: Добро пожаловать в нашу CMS">
                @error('banner_title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="banner_subtitle" class="block text-sm font-medium text-slate-700">Подзаголовок баннера *</label>
                <textarea id="banner_subtitle" 
                          name="banner_subtitle" 
                          rows="3"
                          required
                          class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-slate-800 resize-y transition">{{ old('banner_subtitle', $bannerSubtitle) }}</textarea>
                @error('banner_subtitle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Изображение баннера -->
            <div class="space-y-2">
                <label for="banner_image" class="block text-sm font-medium text-slate-700">Изображение баннера</label>
                
                @if($bannerImage)
                    <div class="mb-4 p-4 bg-slate-50 rounded-lg border border-gray-100">
                        <p class="text-sm font-medium text-slate-700 mb-3">Текущее изображение:</p>
                        <img src="{{ $bannerImage }}" alt="Баннер" class="w-full max-w-2xl h-64 object-cover rounded-lg border border-gray-200 shadow-sm mb-3">
                        <label class="flex items-center gap-2 text-sm text-slate-600">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <span>Удалить изображение</span>
                        </label>
                    </div>
                @endif
                
                <input id="banner_image" 
                       name="banner_image" 
                       type="file" 
                       accept="image/jpeg,image/png,image/gif,image/webp"
                       class="mt-1 block w-full text-sm text-slate-600
                              file:mr-4 file:py-2.5 file:px-5
                              file:rounded-lg file:border-0
                              file:text-sm file:font-medium
                              file:bg-emerald-600
                              file:text-white file:shadow-sm
                              hover:file:bg-emerald-700
                              file:transition file:duration-200
                              file:cursor-pointer" />
                @error('banner_image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-slate-500">Максимальный размер: 2MB. Форматы: JPEG, PNG, GIF, WebP</p>
            </div>

            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                    Сохранить изменения
                </button>
                <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 border-2 border-gray-200 text-slate-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection

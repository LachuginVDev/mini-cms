@extends('layouts.app')

@section('title', 'Редактировать пост')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-10">Редактировать пост</h1>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Заголовок -->
            <div class="space-y-2">
                <x-input-label for="title" value="Заголовок *" class="text-slate-700 font-medium" />
                <x-text-input id="title" 
                              name="title" 
                              type="text" 
                              class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition text-slate-800" 
                              value="{{ old('title', $post->title) }}" 
                              required 
                              autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Содержание -->
            <div class="space-y-2">
                <x-input-label for="content" value="Содержание *" class="text-slate-700 font-medium" />
                <textarea id="content" 
                          name="content" 
                          rows="10" 
                          class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition resize-y text-slate-800"
                          required>{{ old('content', $post->content) }}</textarea>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <!-- Категория -->
            <div class="space-y-2">
                <x-input-label for="category_id" value="Категория" class="text-slate-700 font-medium" />
                <select id="category_id" 
                        name="category_id" 
                        class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition bg-white text-slate-800">
                    <option value="">Без категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <!-- Статус -->
            <div class="space-y-2">
                <x-input-label for="status" value="Статус *" class="text-slate-700 font-medium" />
                <select id="status" 
                        name="status" 
                        class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition bg-white text-slate-800"
                        required>
                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Черновик</option>
                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Опубликован</option>
                    <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Архив</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <!-- Изображение (загрузка файла) -->
            <div class="space-y-2">
                <x-input-label for="image" value="Изображение" class="text-slate-700 font-medium" />
                
                @if($post->image)
                    <div class="mb-4 p-4 bg-slate-50 rounded-lg border border-gray-100">
                        <p class="text-sm font-medium text-slate-700 mb-3">Текущее изображение:</p>
                        <img src="{{ $post->image_url ?? $post->image }}" alt="{{ $post->title }}" class="w-full max-w-md h-64 object-cover rounded-lg border border-gray-200 shadow-sm">
                    </div>
                @endif
                
                <input id="image" 
                       name="image" 
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
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                <p class="mt-2 text-sm text-slate-500">Оставьте пустым, чтобы сохранить текущее изображение. Максимальный размер: 2MB</p>
            </div>

            <!-- Meta Title -->
            <div class="space-y-2">
                <x-input-label for="meta_title" value="Meta Title (для SEO)" class="text-slate-700 font-medium" />
                <x-text-input id="meta_title" 
                              name="meta_title" 
                              type="text" 
                              class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition text-slate-800" 
                              value="{{ old('meta_title', $post->meta_title) }}" />
                <x-input-error :messages="$errors->get('meta_title')" class="mt-2" />
            </div>

            <!-- Meta Description -->
            <div class="space-y-2">
                <x-input-label for="meta_description" value="Meta Description (для SEO)" class="text-slate-700 font-medium" />
                <textarea id="meta_description" 
                          name="meta_description" 
                          rows="3" 
                          class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 transition resize-y text-slate-800">{{ old('meta_description', $post->meta_description) }}</textarea>
                <x-input-error :messages="$errors->get('meta_description')" class="mt-2" />
            </div>

            <!-- Кнопки -->
            <div class="flex gap-4 pt-4 border-t border-gray-100">
                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                    Сохранить изменения
                </button>
                <a href="{{ route('user.posts.index') }}" class="px-6 py-3 border-2 border-gray-200 text-slate-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Отмена
                </a>
            </div>
        </form>
    </div>
@endsection

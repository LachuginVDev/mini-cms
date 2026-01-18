@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-12">
        <div class="mb-6">
            <a href="{{ route('user.posts.index') }}" class="text-blue-600 hover:underline">
                ← Назад к списку постов
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex justify-between items-start mb-6">
                <h1 class="text-4xl font-bold">{{ $post->title }}</h1>
                <span class="px-3 py-1 text-sm rounded 
                    {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $post->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                    {{ $post->status === 'archived' ? 'bg-red-100 text-red-800' : '' }}">
                    {{ $post->status === 'published' ? 'Опубликован' : ($post->status === 'draft' ? 'Черновик' : 'Архив') }}
                </span>
            </div>

            @if($post->category)
                <div class="mb-4">
                    <span class="text-emerald-600">Категория: {{ $post->category->title }}</span>
                </div>
            @endif

            @if($post->image)
                <img src="{{ $post->image_url ?? $post->image }}" alt="{{ $post->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
            @endif

            <div class="prose max-w-none mb-6">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="text-sm text-gray-500 mb-6">
                Создан: {{ $post->created_at->format('d.m.Y H:i') }}
                @if($post->updated_at != $post->created_at)
                    <br>Обновлен: {{ $post->updated_at->format('d.m.Y H:i') }}
                @endif
            </div>

            <div class="flex gap-4 pt-6 border-t border-gray-100">
                <a href="{{ route('user.posts.edit', $post->id) }}" 
                   class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                    Редактировать
                </a>
                <form action="{{ route('user.posts.destroy', $post->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?');"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                        Удалить
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

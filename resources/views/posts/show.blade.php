@extends('layouts.app')

@section('title', $post->meta_title)

@section('content')
    <x-breadcrumbs :items="[
    ['title' => 'Главная', 'url' => route('home')],
    ['title' => 'Посты', 'url' => route('posts.index')],
    ['title' => $post->category?->title ?? 'Без категории', 'url' => '#'],
    ['title' => $post->title, 'url' => '']
]" />

    <div class="max-w-4xl mx-auto px-6 py-12">

        @if($post->image)
            <img src="{{ $post->image_url ?? $post->image }}" alt="{{ $post->title }}" class="w-full rounded-3xl shadow mb-8">
        @endif

        <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>

        <p class="text-slate-500 mb-6">
            {{ $post->created_at->format('d.m.Y') }}
        </p>

        <div class="prose max-w-none mb-12">
            {!! nl2br(e($post->content)) !!}
        </div>

        <!-- Раздел комментариев -->
        <div class="mt-12 pt-8 border-t border-gray-200">
            <h2 class="text-2xl font-bold mb-6 text-slate-800">
                Комментарии 
                <span class="text-base font-normal text-slate-500">({{ $post->comments->count() }})</span>
            </h2>

            <!-- Форма добавления комментария -->
            @auth
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-4 text-slate-700">Добавить комментарий</h3>
                    <form action="{{ route('comments.store', $post) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <textarea 
                                    name="content" 
                                    id="content" 
                                    rows="4"
                                    required
                                    class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-slate-800 resize-y"
                                    placeholder="Напишите ваш комментарий...">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                                    Отправить комментарий
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <div class="bg-slate-50 rounded-lg border border-gray-200 p-6 mb-8 text-center">
                    <p class="text-slate-600 mb-4">Для добавления комментария необходимо войти в систему</p>
                    <a href="{{ route('login') }}" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm inline-block">
                        Войти
                    </a>
                </div>
            @endauth

            <!-- Список комментариев -->
            <div class="space-y-6">
                @forelse($post->comments as $comment)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <span class="text-emerald-600 font-semibold">
                                        {{ mb_substr($comment->user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $comment->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $comment->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                            @auth
                                @if(Auth::id() === $comment->user_id || Auth::user()->isAdmin())
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Удалить комментарий?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm">
                                            Удалить
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        <div class="text-slate-700 whitespace-pre-wrap">{{ $comment->content }}</div>
                    </div>
                @empty
                    <div class="bg-slate-50 rounded-lg border border-gray-200 p-8 text-center">
                        <p class="text-slate-500">Пока нет комментариев. Будьте первым!</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection

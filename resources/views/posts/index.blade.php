@extends('layouts.app')

@section('title', 'Посты')

@section('content')
    <x-breadcrumbs :items="[
        ['title' => 'Главная', 'url' => route('home')],
        ['title' => 'Посты', 'url' => '']
    ]" />
    <div class="max-w-7xl mx-auto px-6 py-12">

        <h1 class="text-3xl font-bold mb-10">Все публикации</h1>

        <div class="grid md:grid-cols-3 gap-8">

            @foreach($posts as $post)
                <article class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                    <img src="{{ $post->image }}" class="h-48 w-full object-cover">

                    <div class="p-6">
                        <h2 class="font-bold text-lg mb-2">
                            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-emerald-600">
                                {{ $post->title }}
                            </a>
                        </h2>
                        <span class="text-xs text-emerald-600">
                            {{ $post->category?->title ?? 'Без категории' }}
                        </span>
                        <p class="text-slate-600 text-sm mb-4">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </p>

                        <span class="text-xs text-slate-400">
                        {{ $post->created_at->format('d.m.Y') }}
                    </span>
                    </div>

                </article>
            @endforeach

        </div>

        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    </div>
@endsection

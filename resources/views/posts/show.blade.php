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

        <img src="{{ $post->image }}" class="rounded-3xl shadow mb-8">

        <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>

        <p class="text-slate-500 mb-6">
            {{ $post->created_at->format('d.m.Y') }}
        </p>

        <div class="prose max-w-none">
            {!! nl2br(e($post->content)) !!}
        </div>

    </div>
@endsection

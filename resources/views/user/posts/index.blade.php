@extends('layouts.app')

@section('title', 'Мои посты')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold">Мои посты</h1>
            <div class="flex gap-3">
                <a href="{{ route('user.categories.index') }}" class="px-5 py-2.5 bg-slate-600 text-white font-medium rounded-lg hover:bg-slate-700 transition-colors shadow-sm">
                    Категории
                </a>
                <a href="{{ route('user.posts.create') }}" class="px-5 py-2.5 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm">
                    + Создать пост
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($posts->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-1">
                        @if($post->image)
                            <div class="relative h-48 w-full overflow-hidden">
                                <img src="{{ $post->image_url ?? $post->image }}" alt="{{ $post->title }}" class="h-full w-full object-cover">
                                <div class="absolute top-3 right-3">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-md
                                        {{ $post->status === 'published' ? 'bg-green-500 text-white' : '' }}
                                        {{ $post->status === 'draft' ? 'bg-gray-500 text-white' : '' }}
                                        {{ $post->status === 'archived' ? 'bg-red-500 text-white' : '' }}">
                                        {{ $post->status === 'published' ? 'Опубликован' : ($post->status === 'draft' ? 'Черновик' : 'Архив') }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="h-48 w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">Нет изображения</span>
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="mb-3">
                                <h2 class="font-bold text-lg mb-2 line-clamp-2">
                                    <a href="{{ route('user.posts.show', $post->id) }}" class="text-gray-900 hover:text-emerald-600 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                @if($post->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $post->category->title }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-slate-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($post->content), 120) }}
                            </p>

                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="text-xs text-slate-500">
                                    {{ $post->created_at->format('d.m.Y') }}
                                </span>

                                <div class="flex gap-3">
                                    <a href="{{ route('user.posts.edit', $post->id) }}"
                                       class="px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                        Редактировать
                                    </a>
                                    <form action="{{ route('user.posts.destroy', $post->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Вы уверены, что хотите удалить этот пост?');"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                            Удалить
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <p class="text-slate-600 mb-4">У вас пока нет постов</p>
                <a href="{{ route('user.posts.create') }}" class="px-6 py-3 bg-emerald-600 text-white font-medium rounded-lg hover:bg-emerald-700 transition-colors shadow-sm inline-block">
                    Создать первый пост
                </a>
            </div>
        @endif
    </div>
@endsection

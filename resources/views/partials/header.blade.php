<header class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
    <div class="text-2xl font-bold tracking-tight">MiniCMS</div>

    <nav class="space-x-6 text-sm font-medium text-slate-600">
        <a href="{{ route('home') }}">Главная</a>
        <a href="{{ route('posts.index') }}">Посты</a>

        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Админка</a>
            @endif
        @endauth
    </nav>
</header>

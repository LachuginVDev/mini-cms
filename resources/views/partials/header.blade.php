<header class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
    <div class="text-2xl font-bold tracking-tight">MiniCMS</div>

    <nav class="space-x-6 text-sm font-medium text-slate-600">
        <a href="{{ route('home') }}">Главная</a>
        <a href="{{ route('posts.index') }}">Посты</a>

        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Админка</a>
            @endif

            <a href="{{ route('profile.edit') }}" class="ml-4 text-slate-500 hover:text-slate-900">
                {{ auth()->user()->name }}
            </a>

            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button class="ml-2 text-red-500 hover:underline">Выход</button>
            </form>
        @else
            <a href="{{ route('login') }}">Войти</a>
            <a href="{{ route('register') }}">Регистрация</a>
        @endauth
    </nav>
</header>

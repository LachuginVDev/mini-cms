@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <section class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h1 class="text-5xl font-bold mb-6">
                Современная CMS на <span class="text-emerald-600">Laravel</span>
            </h1>
            <p class="text-slate-600 mb-8 text-lg">
                Учебный проект с чистой архитектурой и современным стеком.
            </p>
        </div>

        <x-stack />
    </section>
@endsection

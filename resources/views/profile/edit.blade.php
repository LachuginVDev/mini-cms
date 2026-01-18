@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold">Личный кабинет</h1>
            <a href="{{ route('user.posts.index') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition">
                Мои посты →
            </a>
        </div>

        <div class="max-w-2xl space-y-6">
            <div class="p-6 bg-white shadow rounded-lg">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="p-6 bg-white shadow rounded-lg">
                @include('profile.partials.update-password-form')
            </div>

            <div class="p-6 bg-white shadow rounded-lg">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection

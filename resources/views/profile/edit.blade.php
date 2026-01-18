@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold mb-10">Личный кабинет</h1>

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

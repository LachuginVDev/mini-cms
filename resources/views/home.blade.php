@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <!-- Баннер на всю ширину -->
    <section class="w-full relative mb-16">
        @if($bannerImage)
            <div class="relative h-96 w-full overflow-hidden">
                <img src="{{ $bannerImage }}" alt="Баннер" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center px-6">
                        <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white drop-shadow-lg">
                            {{ $bannerTitle }}
                        </h1>
                        <p class="text-lg md:text-2xl text-white max-w-3xl mx-auto leading-relaxed drop-shadow-md">
                            {{ $bannerSubtitle }}
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="w-full bg-gradient-to-r from-emerald-50 to-slate-50 py-20">
                <div class="max-w-7xl mx-auto px-6 text-center">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 text-slate-800">
                        {{ $bannerTitle }}
                    </h1>
                    <p class="text-xl md:text-2xl text-slate-600 max-w-3xl mx-auto leading-relaxed">
                        {{ $bannerSubtitle }}
                    </p>
                </div>
            </div>
        @endif
    </section>

    <!-- Слайдер с постами -->
    @if($posts->count() > 0)
        <section class="max-w-7xl mx-auto px-6 py-12 mb-16">
            <h2 class="text-3xl font-bold mb-10 text-slate-800 text-center">Последние публикации</h2>

            <div class="relative overflow-hidden">
                <div id="postsSlider" class="flex transition-transform duration-500 ease-in-out" style="transform: translateX(0);">
                    @foreach($posts as $index => $post)
                        <div class="post-slide min-w-full md:min-w-[calc(33.333%-1rem)] px-4">
                            <article class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100 transform hover:-translate-y-1 h-full">
                                @if($post->image)
                                    <div class="relative h-64 w-full overflow-hidden">
                                        <img src="{{ $post->image_url ?? $post->image }}" alt="{{ $post->title }}" class="h-full w-full object-cover">
                                    </div>
                                @else
                                    <div class="h-64 w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <span class="text-slate-400 text-sm">Нет изображения</span>
                                    </div>
                                @endif

                                <div class="p-6">
                                    <h3 class="font-bold text-xl mb-3 text-slate-800">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-emerald-600 transition-colors">
                                            {{ $post->title }}
                                        </a>
                                    </h3>

                                    @if($post->category)
                                        <span class="inline-block px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full mb-3">
                                            {{ $post->category->title }}
                                        </span>
                                    @endif

                                    <p class="text-slate-600 text-sm mb-4 line-clamp-3">
                                        {{ Str::limit(strip_tags($post->content), 120) }}
                                    </p>

                                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                        <span class="text-xs text-slate-400">
                                            {{ $post->created_at->format('d.m.Y') }}
                                        </span>
                                        <a href="{{ route('posts.show', $post->slug) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                            Читать →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Навигация слайдера -->
            @if($posts->count() > 3)
                <div class="flex justify-center items-center gap-3 mt-8">
                    <button id="prevBtn" class="p-2 rounded-full bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 hover:text-emerald-600 transition-colors shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>

                    <div id="dots" class="flex gap-2">
                        @php
                            $totalSlides = ceil($posts->count() / 3);
                            $totalDots = min(3, $totalSlides);
                        @endphp
                        @for($i = 0; $i < $totalDots; $i++)
                            <button class="dot w-2 h-2 rounded-full {{ $i === 0 ? 'bg-emerald-600' : 'bg-gray-300' }} transition-colors" data-index="{{ $i }}"></button>
                        @endfor
                    </div>

                    <button id="nextBtn" class="p-2 rounded-full bg-white border border-gray-200 text-slate-600 hover:bg-gray-50 hover:text-emerald-600 transition-colors shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </section>
    @endif


    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('postsSlider');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const dots = document.querySelectorAll('.dot');

            if (!slider || {{ $posts->count() }} === 0) return;

            let itemsPerView = window.innerWidth >= 768 ? 3 : 1;
            const totalItems = {{ $posts->count() }};

            if (totalItems <= itemsPerView) return;

            const totalSlides = Math.ceil(totalItems / itemsPerView);
            let currentIndex = 0;

            function updateSlider() {
                const slideWidth = 100 / itemsPerView;
                const translateX = -(currentIndex * slideWidth);
                slider.style.transform = `translateX(${translateX}%)`;

                if (dots.length > 0) {
                    dots.forEach((dot, index) => {
                        if (index < totalSlides) {
                            dot.classList.toggle('bg-emerald-600', index === currentIndex);
                            dot.classList.toggle('bg-gray-300', index !== currentIndex);
                        }
                    });
                }
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % totalSlides;
                updateSlider();
            }

            function prevSlide() {
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateSlider();
            }

            if (prevBtn && nextBtn) {
                nextBtn.addEventListener('click', nextSlide);
                prevBtn.addEventListener('click', prevSlide);
            }

            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    currentIndex = index;
                    updateSlider();
                });
            });

            let autoSlideInterval = setInterval(nextSlide, 5000);

            slider.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
            slider.addEventListener('mouseleave', () => {
                autoSlideInterval = setInterval(nextSlide, 5000);
            });

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    const newItemsPerView = window.innerWidth >= 768 ? 3 : 1;
                    if (newItemsPerView !== itemsPerView) {
                        itemsPerView = newItemsPerView;
                        currentIndex = 0;
                        updateSlider();
                    }
                }, 250);
            });

            updateSlider();
        });
    </script>
    @endpush
@endsection

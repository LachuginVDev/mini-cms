<div class="max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
    <nav class="text-sm text-slate-500 mb-6">
        @foreach($items as $item)
            @if(!$loop->last)
                <a href="{{ $item['url'] }}" class="hover:text-emerald-600">
                    {{ $item['title'] }}
                </a>
                <span class="mx-2">/</span>
            @else
                <span class="text-slate-700 font-medium">
                    {{ $item['title'] }}
                </span>
            @endif
        @endforeach
    </nav>
</div>

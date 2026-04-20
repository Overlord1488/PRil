<div class="bg-slate-900 rounded-2xl overflow-hidden hover:ring-1 hover:ring-blue-800 transition-all group">
    <a href="{{ route('trainers.show', $trainer->slug) }}" class="block relative overflow-hidden h-64">
        @if($trainer->photo_url)
        <img src="{{ $trainer->photo_url }}" alt="{{ $trainer->display_name }}"
             class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105">
        @else
        <div class="w-full h-full bg-gradient-to-br from-blue-950 to-slate-800 flex flex-col items-center justify-center gap-2">
            <div class="w-20 h-20 rounded-full bg-slate-700 flex items-center justify-center">
                <span class="text-2xl font-bold text-slate-300">
                    {{ mb_strtoupper(mb_substr($trainer->display_name, 0, 1)) }}{{ mb_strtoupper(mb_substr(strrchr($trainer->display_name, ' ') ?: ' ', 1, 1)) }}
                </span>
            </div>
        </div>
        @endif
    </a>
    <div class="p-5">
        <a href="{{ route('trainers.show', $trainer->slug) }}"
           class="text-lg font-semibold text-slate-100 hover:text-blue-400 transition-colors">
            {{ $trainer->display_name }}
        </a>

        @if($trainer->directions->isNotEmpty())
        <div class="flex flex-wrap gap-1 mt-2">
            @foreach($trainer->directions as $dir)
            <span class="px-2 py-0.5 bg-blue-900/40 text-blue-400 rounded text-xs">{{ $dir->name }}</span>
            @endforeach
        </div>
        @endif

        <div class="flex items-center gap-4 mt-3 text-sm text-slate-400">
            @if($trainer->experience_years)
            <span>{{ $trainer->experience_years }} лет опыта</span>
            @endif
            @if($trainer->rating)
            <span class="flex items-center gap-1">
                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                {{ number_format($trainer->rating, 1) }}
            </span>
            @endif
        </div>

        <a href="{{ route('trainers.show', $trainer->slug) }}"
           class="mt-4 inline-block w-full text-center py-2 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl text-sm font-medium transition-colors">
            Подробнее
        </a>
    </div>
</div>

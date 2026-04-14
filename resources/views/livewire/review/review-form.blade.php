<div>
    @if($submitted)
    <div class="rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
        Спасибо! Ваш отзыв отправлен на модерацию и появится после проверки.
    </div>

    @elseif($existing && !$submitted)
    <div class="rounded-xl bg-slate-800 px-5 py-4">
        <p class="text-sm text-slate-400 mb-3">Ваш отзыв (на модерации)</p>
        <div class="flex gap-0.5 mb-2">
            @for($i = 1; $i <= 5; $i++)
            <svg class="w-5 h-5 {{ $i <= $existing->rating ? 'text-yellow-400' : 'text-slate-600' }}"
                 fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            @endfor
        </div>
        @if($existing->body)
        <p class="text-sm text-slate-300">{{ $existing->body }}</p>
        @endif
    </div>

    @elseif(auth()->check())
    <form wire:submit="submit" class="space-y-4">
        {{-- Star rating --}}
        <div>
            <p class="text-sm font-medium text-slate-400 mb-2">Оценка</p>
            <div class="flex gap-1" x-data="{ hovered: 0 }">
                @for($i = 1; $i <= 5; $i++)
                <button type="button"
                        wire:click="setRating({{ $i }})"
                        @mouseenter="hovered = {{ $i }}"
                        @mouseleave="hovered = 0"
                        class="focus:outline-none">
                    <svg class="w-8 h-8 transition-colors"
                         :class="(hovered >= {{ $i }} || (!hovered && {{ $i }} <= $wire.rating)) ? 'text-yellow-400' : 'text-slate-600'"
                         fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </button>
                @endfor
            </div>
            @error('rating') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>

        {{-- Body --}}
        <div>
            <label class="block text-sm font-medium text-slate-400 mb-1">Комментарий (необязательно)</label>
            <textarea wire:model="body" rows="3"
                      placeholder="Поделитесь впечатлениями..."
                      class="w-full bg-slate-800 border border-slate-700 text-slate-100 rounded-lg px-3 py-2 text-sm
                             focus:outline-none focus:ring-1 focus:ring-blue-900 resize-none"></textarea>
            @error('body') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>

        <button type="submit"
                wire:loading.attr="disabled"
                class="px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-lg text-sm font-semibold transition-colors">
            <span wire:loading.remove>Отправить отзыв</span>
            <span wire:loading>Отправка...</span>
        </button>
    </form>

    @else
    <p class="text-sm text-slate-500">
        <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Войдите</a>,
        чтобы оставить отзыв
    </p>
    @endif
</div>

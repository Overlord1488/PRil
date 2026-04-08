<div>
    @if($availableDates->isEmpty())
    <div class="rounded-xl bg-slate-800 p-6 text-center text-slate-400">
        У тренера пока нет доступных слотов для записи
    </div>
    @else

    {{-- Date selector --}}
    <div class="mb-6">
        <p class="text-sm font-medium text-slate-400 mb-3">Выберите дату</p>
        <div class="flex flex-wrap gap-2">
            @foreach($availableDates as $date)
            @php $d = \Carbon\Carbon::parse($date); @endphp
            <button wire:click="$set('selectedDate', '{{ $date }}')"
                    class="px-3 py-2 rounded-lg text-sm transition-colors {{ $selectedDate === $date ? 'bg-blue-900 text-slate-100' : 'bg-slate-800 text-slate-400 hover:text-slate-100' }}">
                <span class="block font-medium">{{ $d->isoFormat('D MMM') }}</span>
                <span class="block text-xs opacity-70">{{ $d->isoFormat('ddd') }}</span>
            </button>
            @endforeach
        </div>
    </div>

    {{-- Time slots --}}
    <div class="mb-6">
        <p class="text-sm font-medium text-slate-400 mb-3">Выберите время</p>
        @if($slots->isEmpty())
        <p class="text-slate-500 text-sm">На выбранную дату свободных слотов нет</p>
        @else
        <div class="flex flex-wrap gap-2">
            @foreach($slots as $slot)
            <button wire:click="selectSlot('{{ $slot['datetime'] }}')"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ $selectedSlot === $slot['datetime'] ? 'bg-blue-900 text-slate-100 ring-1 ring-blue-400' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">
                {{ $slot['label'] }}
            </button>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Extra fields (shown after slot selected) --}}
    @if($selectedSlot)
    <div class="space-y-4 mb-6 border-t border-slate-800 pt-6">
        @if($directions->isNotEmpty())
        <div>
            <label class="block text-sm font-medium text-slate-400 mb-1">Направление (необязательно)</label>
            <select wire:model="directionId"
                    class="w-full bg-slate-800 border border-slate-700 text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-900">
                <option value="">— не выбрано —</option>
                @foreach($directions as $dir)
                <option value="{{ $dir->id }}">{{ $dir->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div>
            <label class="block text-sm font-medium text-slate-400 mb-1">Комментарий</label>
            <textarea wire:model="notes" rows="3"
                      placeholder="Цели, пожелания..."
                      class="w-full bg-slate-800 border border-slate-700 text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-900 resize-none"></textarea>
        </div>
    </div>
    @endif

    {{-- Error --}}
    @if($error)
    <div class="mb-4 rounded-lg bg-red-900/30 border border-red-700/40 px-4 py-3 text-sm text-red-400">
        {{ $error }}
    </div>
    @endif

    {{-- Submit --}}
    <button wire:click="submit"
            wire:loading.attr="disabled"
            @class([
                'w-full py-3 rounded-xl font-semibold text-sm transition-colors',
                'bg-blue-900 hover:bg-blue-800 text-slate-100' => (bool) $selectedSlot,
                'bg-slate-800 text-slate-500 cursor-not-allowed' => ! $selectedSlot,
            ])>
        <span wire:loading.remove>Записаться</span>
        <span wire:loading>Обработка...</span>
    </button>

    @endif
</div>

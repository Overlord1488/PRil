<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            @include('trainer._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-2">Расписание</h1>
                <p class="text-sm text-slate-400 mb-6">Настройте рабочие дни и время приёма клиентов</p>

                @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                @if(! $trainer)
                <div class="bg-slate-900 rounded-2xl p-10 text-center text-slate-500">
                    Профиль тренера не найден. Обратитесь к администратору.
                </div>
                @else

                <form action="{{ route('trainer.schedule.store') }}" method="POST">
                    @csrf

                    <div class="bg-slate-900 rounded-2xl overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-800 hidden sm:grid grid-cols-12 gap-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            <div class="col-span-1"></div>
                            <div class="col-span-3">День</div>
                            <div class="col-span-3">Начало</div>
                            <div class="col-span-3">Конец</div>
                            <div class="col-span-2">Слот, мин</div>
                        </div>

                        @foreach($days as $dayNum => $dayName)
                        @php $row = $schedule->get($dayNum); @endphp
                        <div class="px-6 py-5 border-b border-slate-800 last:border-0 grid grid-cols-12 gap-4 items-center"
                             x-data="{ active: {{ $row && $row->is_active ? 'true' : 'false' }} }">

                            {{-- Active checkbox --}}
                            <div class="col-span-1">
                                <input type="checkbox"
                                       name="days[]"
                                       value="{{ $dayNum }}"
                                       {{ $row && $row->is_active ? 'checked' : '' }}
                                       @change="active = $event.target.checked"
                                       class="w-5 h-5 rounded bg-slate-800 border-slate-600 text-blue-600 focus:ring-blue-900 cursor-pointer">
                            </div>

                            {{-- Day name --}}
                            <div class="col-span-3">
                                <span class="text-sm font-medium" :class="active ? 'text-slate-100' : 'text-slate-500'">
                                    {{ $dayName }}
                                </span>
                            </div>

                            {{-- Start time --}}
                            <div class="col-span-3">
                                <input type="time"
                                       name="start_time[{{ $dayNum }}]"
                                       value="{{ $row ? $row->start_time : '09:00' }}"
                                       :disabled="!active"
                                       class="w-full bg-zinc-800 border border-slate-700 text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-900 disabled:opacity-40">
                            </div>

                            {{-- End time --}}
                            <div class="col-span-3">
                                <input type="time"
                                       name="end_time[{{ $dayNum }}]"
                                       value="{{ $row ? $row->end_time : '18:00' }}"
                                       :disabled="!active"
                                       class="w-full bg-zinc-800 border border-slate-700 text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-900 disabled:opacity-40">
                            </div>

                            {{-- Slot duration --}}
                            <div class="col-span-2">
                                <select name="slot_minutes[{{ $dayNum }}]"
                                        :disabled="!active"
                                        class="w-full bg-zinc-800 border border-slate-700 text-slate-100 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-blue-900 disabled:opacity-40">
                                    @foreach([30 => '30', 45 => '45', 60 => '60', 90 => '90', 120 => '120'] as $min => $label)
                                    <option value="{{ $min }}" {{ ($row && $row->slot_minutes == $min) ? 'selected' : ($min == 60 ? 'selected' : '') }}>
                                        {{ $label }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="px-8 py-3 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl font-semibold text-sm transition-colors">
                            Сохранить расписание
                        </button>
                    </div>
                </form>

                @endif
            </main>
        </div>
    </div>
</div>
</x-app-layout>

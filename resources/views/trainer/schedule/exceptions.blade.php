<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            @include('trainer._sidebar')

            <main class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-6">
                    <a href="{{ route('trainer.schedule.index') }}"
                       class="text-slate-400 hover:text-slate-100 transition-colors text-sm">← Расписание</a>
                    <span class="text-slate-600">/</span>
                    <h1 class="text-2xl font-bold text-slate-100">Исключения</h1>
                </div>

                <div class="bg-slate-900 rounded-2xl p-10 text-center text-slate-500">
                    <svg class="w-12 h-12 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-slate-400 font-medium mb-1">Управление исключениями</p>
                    <p class="text-sm">Возможность добавлять выходные дни и особые перерывы появится в следующем обновлении.</p>
                </div>
            </main>
        </div>
    </div>
</div>
</x-app-layout>

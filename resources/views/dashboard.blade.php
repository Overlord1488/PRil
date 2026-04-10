<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-12 flex items-center justify-center">
    <div class="text-center">
        <p class="text-slate-400 mb-4">Вы вошли в систему.</p>
        <a href="{{ route('account.index') }}"
           class="px-6 py-3 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl font-semibold text-sm transition-colors">
            Перейти в личный кабинет
        </a>
    </div>
</div>
</x-app-layout>

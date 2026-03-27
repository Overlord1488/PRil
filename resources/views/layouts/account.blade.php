<x-app-layout>
    <x-slot name="title">{{ $title ?? __('Личный кабинет') }} — {{ config('app.name') }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex gap-8">
            <aside class="w-56 shrink-0">
                <nav class="flex flex-col gap-1">
                    <a href="{{ route('account.index') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('account.index') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Обзор') }}
                    </a>
                    <a href="{{ route('account.profile.edit') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('account.profile.*') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Профиль') }}
                    </a>
                    <a href="{{ route('account.orders.index') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('account.orders.*') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Заказы') }}
                    </a>
                    <a href="{{ route('account.downloads.index') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('account.downloads.*') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Скачивания') }}
                    </a>
                    <a href="{{ route('account.bookings.index') }}"
                       class="px-4 py-2 rounded-lg text-sm {{ request()->routeIs('account.bookings.*') ? 'bg-blue-900 text-white' : 'text-slate-300 hover:bg-slate-800' }} transition-colors">
                        {{ __('Мои тренировки') }}
                    </a>
                </nav>
            </aside>
            <div class="flex-1 min-w-0">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-app-layout>

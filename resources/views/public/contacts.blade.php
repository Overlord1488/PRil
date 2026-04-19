@extends('layouts.app')

@section('title', 'Контакты — Sport Division')

@section('content')

<section class="bg-zinc-950 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-slate-100 mb-6">Контакты</h1>
        <p class="text-lg text-slate-400 mb-12">
            Есть вопросы? Свяжитесь с нами любым удобным способом.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-slate-900 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-100 mb-1">Email</p>
                        <p class="text-slate-400 text-sm">info@gymhub.ru</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-100 mb-1">Телефон</p>
                        <p class="text-slate-400 text-sm">+7 (800) 000-00-00</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-100 mb-1">Адрес</p>
                        <p class="text-slate-400 text-sm">Москва, ул. Спортивная, 1</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-blue-900/30 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-100 mb-1">Режим работы</p>
                        <p class="text-slate-400 text-sm">Пн–Пт: 8:00–22:00</p>
                        <p class="text-slate-400 text-sm">Сб–Вс: 9:00–20:00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

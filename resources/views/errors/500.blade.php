@extends('layouts.app')

@section('title', 'Ошибка сервера')

@section('content')
<div class="bg-zinc-950 min-h-[70vh] flex items-center justify-center py-16">
    <div class="text-center px-4">
        <p class="text-8xl font-extrabold text-blue-900/60 leading-none">500</p>
        <h1 class="mt-4 text-2xl font-bold text-slate-100">Ошибка сервера</h1>
        <p class="mt-3 text-slate-400 max-w-md mx-auto">
            Что-то пошло не так с нашей стороны. Мы уже работаем над исправлением.
        </p>
        <div class="mt-8">
            <a href="{{ route('home') }}"
               class="px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl text-sm font-semibold transition-colors">
                На главную
            </a>
        </div>
    </div>
</div>
@endsection

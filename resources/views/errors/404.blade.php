@extends('layouts.app')

@section('title', 'Страница не найдена')

@section('content')
<div class="bg-zinc-950 min-h-[70vh] flex items-center justify-center py-16">
    <div class="text-center px-4">
        <p class="text-8xl font-extrabold text-blue-900/60 leading-none">404</p>
        <h1 class="mt-4 text-2xl font-bold text-slate-100">Страница не найдена</h1>
        <p class="mt-3 text-slate-400 max-w-md mx-auto">
            Возможно, она была удалена или вы ввели неверный адрес.
        </p>
        <div class="mt-8 flex flex-wrap gap-3 justify-center">
            <a href="{{ route('home') }}"
               class="px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-xl text-sm font-semibold transition-colors">
                На главную
            </a>
            <a href="{{ route('catalog.index') }}"
               class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-slate-100 rounded-xl text-sm font-semibold transition-colors">
                В каталог
            </a>
        </div>
    </div>
</div>
@endsection

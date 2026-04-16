@extends('layouts.app')

@section('title', 'О нас — GymHub')

@section('content')

<section class="bg-zinc-950 py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-extrabold text-slate-100 mb-6">О GymHub</h1>
        <p class="text-lg text-slate-400 leading-relaxed mb-6">
            GymHub — это онлайн-платформа для поиска тренеров и записи на тренировки.
            Мы объединяем профессиональных тренеров и людей, которые хотят улучшить
            своё здоровье и физическую форму.
        </p>
        <p class="text-slate-400 leading-relaxed mb-6">
            Наша миссия — сделать профессиональный фитнес доступным каждому.
            Удобная онлайн-запись, прозрачные отзывы и широкий выбор направлений —
            всё для того, чтобы вы достигали своих целей.
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-12">
            <div class="bg-slate-900 rounded-2xl p-6 text-center">
                <p class="text-3xl font-bold text-blue-400 mb-2">2024</p>
                <p class="text-slate-400 text-sm">Год основания</p>
            </div>
            <div class="bg-slate-900 rounded-2xl p-6 text-center">
                <p class="text-3xl font-bold text-blue-400 mb-2">24/7</p>
                <p class="text-slate-400 text-sm">Онлайн-запись</p>
            </div>
            <div class="bg-slate-900 rounded-2xl p-6 text-center">
                <p class="text-3xl font-bold text-blue-400 mb-2">100%</p>
                <p class="text-slate-400 text-sm">Проверенные тренеры</p>
            </div>
        </div>
    </div>
</section>

@endsection

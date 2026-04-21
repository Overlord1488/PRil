<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('account.index', absolute: false), navigate: true);
    }
}; ?>

<div class="bg-slate-900 rounded-2xl border border-slate-800 p-8">
    <h1 class="text-2xl font-bold text-slate-100 mb-2">Вход в аккаунт</h1>
    <p class="text-sm text-slate-400 mb-8">Нет аккаунта? <a href="{{ route('register') }}" wire:navigate class="text-blue-400 hover:text-blue-300 transition-colors">Зарегистрироваться</a></p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-1.5" />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <x-input-label for="password" :value="__('Пароль')" class="mb-0" />
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate class="text-xs text-blue-400 hover:text-blue-300 transition-colors">Забыли пароль?</a>
                @endif
            </div>
            <x-text-input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-1.5" />
        </div>

        <div class="flex items-center gap-2">
            <input wire:model="form.remember" id="remember" type="checkbox"
                   class="w-4 h-4 rounded border-slate-600 bg-slate-800 text-blue-700 focus:ring-blue-700 focus:ring-offset-slate-900">
            <label for="remember" class="text-sm text-slate-400">Запомнить меня</label>
        </div>

        <x-primary-button class="w-full mt-2">Войти</x-primary-button>
    </form>
</div>

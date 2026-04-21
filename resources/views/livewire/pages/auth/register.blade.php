<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('account.index', absolute: false), navigate: true);
    }
}; ?>

<div class="bg-slate-900 rounded-2xl border border-slate-800 p-8">
    <h1 class="text-2xl font-bold text-slate-100 mb-2">Создать аккаунт</h1>
    <p class="text-sm text-slate-400 mb-8">Уже есть аккаунт? <a href="{{ route('login') }}" wire:navigate class="text-blue-400 hover:text-blue-300 transition-colors">Войти</a></p>

    <form wire:submit="register" class="space-y-5">
        <div>
            <x-input-label for="name" :value="__('Имя')" />
            <x-text-input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name" placeholder="Иван Иванов" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" type="email" name="email" required autocomplete="username" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Пароль')" />
            <x-text-input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password" placeholder="Минимум 8 символов" />
            <p class="mt-1.5 text-xs text-slate-500">Минимум 8 символов, используйте буквы и цифры</p>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Повторите пароль')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Повторите пароль" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <x-primary-button class="w-full mt-2">Зарегистрироваться</x-primary-button>
    </form>
</div>

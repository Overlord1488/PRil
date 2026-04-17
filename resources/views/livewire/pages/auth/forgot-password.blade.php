<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<div class="bg-slate-900 rounded-2xl border border-slate-800 p-8">
    <h1 class="text-2xl font-bold text-slate-100 mb-2">Восстановление пароля</h1>
    <p class="text-sm text-slate-400 mb-8">
        Введите email — мы пришлём ссылку для сброса пароля.
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-5">
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" type="email" name="email" required autofocus placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <x-primary-button class="w-full">Отправить ссылку</x-primary-button>

        <p class="text-center text-sm text-slate-500">
            <a href="{{ route('login') }}" wire:navigate class="text-blue-400 hover:text-blue-300 transition-colors">Вернуться к входу</a>
        </p>
    </form>
</div>

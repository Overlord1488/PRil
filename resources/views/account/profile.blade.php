<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex gap-8">
            @include('account._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-6">Профиль</h1>

                @if(session('status'))
                <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
                    {{ session('status') }}
                </div>
                @endif

                <div class="bg-slate-900 rounded-2xl p-8 max-w-lg">
                    <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Имя</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                   class="w-full bg-zinc-800 border border-slate-700 text-slate-100 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-900
                                          @error('name') border-red-700 @enderror">
                            @error('name')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" disabled
                                   class="w-full bg-zinc-800 border border-slate-700 text-slate-500 rounded-lg px-4 py-2.5 text-sm cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-400 mb-1">Телефон</label>
                            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                   placeholder="+7 (999) 000-00-00"
                                   class="w-full bg-zinc-800 border border-slate-700 text-slate-100 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-blue-900">
                        </div>

                        <button type="submit"
                                class="px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-lg text-sm font-semibold transition-colors">
                            Сохранить
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>
</x-app-layout>

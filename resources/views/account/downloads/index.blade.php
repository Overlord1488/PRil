<x-app-layout>
<div class="bg-zinc-950 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            @include('account._sidebar')

            <main class="flex-1 min-w-0">
                <h1 class="text-2xl font-bold text-slate-100 mb-6">Мои загрузки</h1>

                @if(session('success'))
                <div class="mb-6 rounded-xl bg-green-900/30 border border-green-700/40 px-5 py-4 text-green-400 text-sm">
                    {{ session('success') }}
                </div>
                @endif

                @forelse($downloads as $download)
                @php
                    $file = $download->productFile;
                    $product = $download->orderItem?->product;
                    $canDownload = $download->canDownload();
                @endphp
                <div class="bg-slate-900 rounded-xl mb-3 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-slate-100 truncate">
                                {{ $file?->label ?? $product?->name ?? 'Файл' }}
                            </p>
                            @if($product)
                            <p class="text-xs text-slate-500 mt-0.5">
                                Из заказа #{{ $download->orderItem?->order?->number }}
                            </p>
                            @endif
                            <div class="flex items-center gap-3 mt-2 text-xs text-slate-500">
                                @if($file?->size_bytes)
                                <span>{{ number_format($file->size_bytes / 1024 / 1024, 1) }} МБ</span>
                                @endif
                                <span>
                                    {{ $download->downloads_count }} / {{ $download->max_downloads }} скачиваний
                                </span>
                                @if($download->expires_at)
                                <span class="{{ $download->expires_at->isPast() ? 'text-red-400' : '' }}">
                                    До {{ $download->expires_at->format('d.m.Y') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex-shrink-0">
                            @if($canDownload)
                            <a href="{{ route('account.downloads.download', $download) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-900 hover:bg-blue-800 text-slate-100 rounded-lg text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Скачать
                            </a>
                            @else
                            <span class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 text-slate-500 rounded-lg text-sm cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Недоступно
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-slate-900 rounded-2xl p-12 text-center text-slate-500">
                    Здесь появятся ваши цифровые покупки.
                    <a href="{{ route('catalog.programs') }}" class="text-blue-400 hover:underline ml-1">В каталог программ →</a>
                </div>
                @endforelse
            </main>
        </div>
    </div>
</div>
</x-app-layout>

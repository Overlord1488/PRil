<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 bg-blue-900 hover:bg-blue-800 text-white text-sm font-semibold rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-blue-700 focus:ring-offset-2 focus:ring-offset-slate-900']) }}>
    {{ $slot }}
</button>

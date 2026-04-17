@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full bg-slate-800 border border-slate-700 text-slate-100 placeholder-slate-500 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-700 focus:border-blue-700 transition-colors']) }}>

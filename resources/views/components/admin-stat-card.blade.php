@props(['label', 'value', 'description', 'tone' => 'blue', 'href' => null])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class(['admin-stat-card', 'admin-stat-card--'.$tone]) }}>
        <p class="text-sm font-bold text-slate-600">{{ $label }}</p><p class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ number_format($value) }}</p><p class="mt-2 text-xs font-semibold leading-5 text-slate-500">{{ $description }}</p>
    </a>
@else
    <article {{ $attributes->class(['admin-stat-card', 'admin-stat-card--'.$tone]) }}>
        <p class="text-sm font-bold text-slate-600">{{ $label }}</p><p class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ number_format($value) }}</p><p class="mt-2 text-xs font-semibold leading-5 text-slate-500">{{ $description }}</p>
    </article>
@endif

@props(['title', 'description', 'actionLabel' => null, 'actionUrl' => null])

<div {{ $attributes->class('admin-empty-state') }}>
    <span class="grid size-12 place-items-center rounded-2xl bg-blue-50 text-xl font-black text-blue-700" aria-hidden="true">+</span>
    <h3 class="mt-4 text-lg font-black text-slate-950">{{ $title }}</h3>
    <p class="mt-2 max-w-md text-sm leading-6 text-slate-600">{{ $description }}</p>
    @if ($actionLabel && $actionUrl)
        <a href="{{ $actionUrl }}" class="admin-button admin-button--primary mt-5">{{ $actionLabel }}</a>
    @endif
</div>

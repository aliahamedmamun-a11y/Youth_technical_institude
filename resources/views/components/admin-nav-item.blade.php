@props(['item', 'badge' => null])

@php($isActive = collect($item['active'])->contains(fn (string $pattern): bool => request()->routeIs($pattern)))

<a href="{{ route($item['route'], $item['parameters'] ?? []) }}"
   @class(['admin-nav-item', 'admin-nav-item--active' => $isActive])
   @if ($isActive) aria-current="page" @endif>
    <span class="admin-nav-icon" aria-hidden="true">
        @switch($item['icon'])
            @case('overview') ◫ @break
            @case('students') ♙ @break
            @case('teachers') ♟ @break
            @case('branches') ▦ @break
            @case('courses') ▤ @break
            @case('semesters') S @break
            @case('documents') ▧ @break
            @case('homepage') ◇ @break
            @case('notices') ! @break
            @case('news') N @break
            @default i
        @endswitch
    </span>
    <span class="min-w-0 flex-1">
        <span class="flex items-center justify-between gap-2">
            <span class="block font-black">{{ $item['label'] }}</span>
            @if ($badge)
                <span class="admin-nav-badge" aria-label="{{ $badge }} pending">{{ $badge }}</span>
            @endif
        </span>
        <span class="mt-0.5 block text-[11px] font-semibold leading-4 opacity-70">{{ $item['description'] }}</span>
    </span>
</a>

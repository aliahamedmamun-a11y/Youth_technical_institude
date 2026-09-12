@props(['title', 'eyebrow', 'description', 'breadcrumbs' => []])

@php($isSuperAdmin = auth()->user()->hasRole(\App\Enums\UserRole::SuperAdmin))

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} | Bangladesh National Youth Technical Institute</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#03224c] text-white antialiased">
        {{-- Top Navigation Bar --}}
        <header class="sticky top-0 z-40 flex h-16 items-center justify-between border-b border-white/10 bg-[#071c2c] px-6 text-white shadow-md">
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="size-9 brightness-0 invert">
                    <span class="text-sm font-black uppercase tracking-wider hidden sm:inline">BNTEI</span>
                </a>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 rounded-full bg-white/5 py-1.5 pl-4 pr-1.5 ring-1 ring-white/10">
                    <span class="text-xs font-black uppercase tracking-wider opacity-80">Admin</span>
                    <div class="grid size-8 place-items-center rounded-full bg-slate-400 text-slate-900">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex">
            {{-- Sidebar Navigation --}}
            @if ($isSuperAdmin)
                <aside class="sticky top-16 h-[calc(100vh-64px)] w-72 shrink-0 flex flex-col border-r border-white/10 bg-[#071c2c] shadow-sm">
                    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1 scrollbar-hide">
                        @foreach ($adminNavigation as $group)
                            @foreach ($group['items'] as $item)
                                @php($isActive = collect($item['active'])->contains(fn (string $pattern): bool => request()->routeIs($pattern)))
                                <a href="{{ route($item['route'], $item['parameters'] ?? []) }}"
                                   @class([
                                       'group flex items-center gap-3 rounded-md px-3 py-2 text-[13px] font-bold transition-all',
                                       'bg-blue-600 text-white shadow-lg shadow-blue-900/20' => $isActive,
                                       'text-slate-300 hover:bg-white/5 hover:text-white' => !$isActive
                                   ])>
                                    <span class="shrink-0 text-white/70">
                                        @switch($item['icon'])
                                            @case('overview') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg> @break
                                            @case('students') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> @break
                                            @case('branches') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg> @break
                                            @case('courses') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg> @break
                                            @case('semesters') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> @break
                                            @case('notices') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg> @break
                                            @case('homepage') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg> @break
                                            @case('about') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> @break
                                            @default <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        @endswitch
                                    </span>
                                    <span class="flex-1 truncate">{{ $item['label'] }}</span>
                                </a>
                            @endforeach
                        @endforeach
                    </nav>

                    {{-- Logout Section --}}
                    <div class="border-t border-white/5 p-4 bg-black/20">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2 text-[13px] font-black text-slate-300 transition-all hover:bg-white/5 hover:text-white">
                                <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </aside>
            @endif

            {{-- Main Content Area --}}
            <main class="min-w-0 flex-1 p-6 lg:p-12">
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm font-bold text-emerald-400 shadow-sm backdrop-blur-sm" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                <div data-admin-workspace>
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>

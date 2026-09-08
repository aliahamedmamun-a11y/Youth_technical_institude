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
    <body class="min-h-screen bg-[#f1f5f9] text-slate-900 antialiased">
        {{-- Top Navigation Bar --}}
        <header class="sticky top-0 z-40 flex h-16 items-center justify-between border-b border-white/10 bg-[#071c2c] px-6 text-white shadow-md">
            <div class="flex items-center gap-4">
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="size-9 brightness-0 invert">
                    <span class="text-sm font-black uppercase tracking-wider hidden sm:inline">South Asia National Technical Institute</span>
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
                <aside class="sticky top-16 h-[calc(100vh-64px)] w-64 shrink-0 flex flex-col border-r border-slate-200 bg-white shadow-sm">
                    <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-6 scrollbar-hide">
                        @foreach ($adminNavigation as $group)
                            <div>
                                <h2 class="px-3 pb-2 text-[10px] font-black uppercase tracking-[0.15em] text-slate-400">{{ $group['label'] }}</h2>
                                <div class="space-y-1">
                                    @foreach ($group['items'] as $item)
                                        @php($isActive = collect($item['active'])->contains(fn (string $pattern): bool => request()->routeIs($pattern)))
                                        @php($badge = isset($item['badge']) ? get_defined_vars()[$item['badge']] ?? null : null)
                                        <a href="{{ route($item['route'], $item['parameters'] ?? []) }}"
                                           @class([
                                               'group flex items-center gap-3 rounded-lg px-3 py-2 text-[13px] font-bold transition-all',
                                               'bg-blue-50 text-blue-700' => $isActive,
                                               'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => !$isActive
                                           ])>
                                            <span @class([
                                                'grid size-8 shrink-0 place-items-center rounded-lg border transition-colors',
                                                'border-blue-200 bg-white text-blue-600 shadow-sm' => $isActive,
                                                'border-slate-200 bg-slate-50 text-slate-500 group-hover:border-slate-300 group-hover:bg-white' => !$isActive
                                            ])>
                                                @switch($item['icon'])
                                                    @case('overview') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> @break
                                                    @case('students') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> @break
                                                    @case('teachers') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg> @break
                                                    @case('branches') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> @break
                                                    @case('courses') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg> @break
                                                    @case('semesters') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg> @break
                                                    @case('notices') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg> @break
                                                    @case('homepage') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/><path d="M3 9h18"/></svg> @break
                                                    @case('about') <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg> @break
                                                    @default <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                                                @endswitch
                                            </span>
                                            <span class="flex-1 truncate">{{ $item['label'] }}</span>
                                            @if ($badge)
                                                <span class="grid size-5 place-items-center rounded-full bg-amber-500 text-[10px] font-black text-white shadow-sm">{{ $badge }}</span>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </nav>

                    {{-- Logout Section --}}
                    <div class="border-t border-slate-100 p-4 bg-slate-50/50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-3 rounded-xl bg-white px-4 py-2.5 text-[13px] font-black text-rose-600 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-rose-50 hover:text-rose-700 hover:ring-rose-200">
                                <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </aside>
            @endif
            @endif

            {{-- Main Content Area --}}
            <main class="min-w-0 flex-1 p-6 lg:p-10">
                @if (session('status'))
                    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-100/50 px-4 py-3 text-sm font-bold text-emerald-800 shadow-sm backdrop-blur-sm" role="status">
                        {{ session('status') }}
                    </div>
                @endif

                <div data-admin-workspace>
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{-- Mockup Footer --}}
        <footer class="border-t border-slate-200 bg-white py-12">
            <div class="mx-auto grid max-w-7xl gap-8 px-8 sm:grid-cols-3">
                <div>
                    <h2 class="text-sm font-black uppercase tracking-widest text-slate-400">Contact</h2>
                    <div class="mt-4 space-y-2 text-[13px] font-bold text-slate-600">
                        <p>Main Campus, Kolkata</p>
                        <p>Address, +91 588998888</p>
                        <p>Raw +91 9886058860</p>
                        <p class="mt-4 opacity-50">Copyright © contact@sainti.in</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-sm font-black uppercase tracking-widest text-slate-400">Our Services</h2>
                    <div class="mt-4 space-y-2 text-[13px] font-bold text-slate-600">
                        <p>Online Class</p>
                        <p>Online Support</p>
                        <p>Teacher's Dashboard</p>
                        <p>Admin Panel</p>
                    </div>
                </div>
                <div>
                    <h2 class="text-sm font-black uppercase tracking-widest text-slate-400">Links</h2>
                    <div class="mt-4 space-y-2 text-[13px] font-bold text-slate-600">
                        <p>Institute Info</p>
                        <p>Course List</p>
                        <p>Staff List</p>
                        <p>Notice Board</p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>

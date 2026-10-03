@php
    $user = auth()->user();
    $isSuperAdmin = $user?->hasRole(\App\Enums\UserRole::SuperAdmin) ?? false;
    $isBranchUser = $user?->hasRole(\App\Enums\UserRole::Branch) ?? false;

    $branchNavigation = [
        ['label' => 'Main', 'items' => [
            ['label' => 'Profile', 'route' => 'dashboards.branch', 'active' => ['dashboards.branch'], 'icon' => 'overview'],
            ['label' => 'Students List', 'route' => 'students.index', 'active' => ['students.*'], 'icon' => 'students'],
            ['label' => 'Add Student', 'route' => 'student-registrations.create', 'active' => ['student-registrations.*'], 'icon' => 'courses'],
            ['label' => 'Exam Document', 'route' => 'branch-messages.omr-sheet', 'active' => ['branch-messages.omr-sheet'], 'icon' => 'notices'],
            ['label' => 'Contact admin', 'route' => 'branch-messages.contact-admin', 'active' => ['branch-messages.contact-admin'], 'icon' => 'about'],
        ]],
    ];
@endphp

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
        {{-- Mobile Overlay Backdrop --}}
        <div data-admin-overlay class="fixed inset-0 z-40 hidden bg-black/60 backdrop-blur-sm lg:hidden"></div>

        {{-- Top Navigation Bar --}}
        <header class="sticky top-0 z-40 flex h-16 items-center justify-between border-b border-white/10 bg-[#071c2c] px-4 sm:px-6 text-white shadow-md">
            <div class="flex items-center gap-3 sm:gap-4">
                @if ($isSuperAdmin || $isBranchUser)
                    <button type="button" data-admin-menu-open class="flex size-10 items-center justify-center rounded-xl bg-white/10 text-white transition hover:bg-white/20 active:scale-95 lg:hidden" aria-label="Open sidebar menu">
                        <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                @endif

                <a href="/" class="flex items-center gap-2 sm:gap-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="BNYTI logo" class="size-8 sm:size-9 brightness-0 invert">
                    <span class="text-xs sm:text-sm font-black uppercase tracking-wider">BNTEI</span>
                </a>
            </div>
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="flex items-center gap-2 rounded-full bg-white/5 py-1 pl-3 pr-1 sm:py-1.5 sm:pl-4 sm:pr-1.5 ring-1 ring-white/10">
                    <span class="text-[11px] sm:text-xs font-black uppercase tracking-wider opacity-80">{{ $isBranchUser ? 'Branch Panel' : 'Admin' }}</span>
                    <div class="grid size-7 sm:size-8 place-items-center rounded-full bg-slate-400 text-slate-900">
                        <svg viewBox="0 0 24 24" class="size-4 sm:size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex">
            {{-- Sidebar Navigation --}}
            @if ($isSuperAdmin || $isBranchUser)
                @php
                    $navigationGroups = $isSuperAdmin ? $adminNavigation : $branchNavigation;
                @endphp
                <aside data-admin-sidebar class="fixed inset-y-0 left-0 z-50 flex h-full w-72 shrink-0 flex-col border-r border-white/10 bg-[#071c2c] shadow-2xl transition-transform duration-300 -translate-x-full lg:sticky lg:top-16 lg:z-auto lg:h-[calc(100vh-64px)] lg:translate-x-0 lg:shadow-sm">
                    {{-- Mobile Menu Header --}}
                    <div class="flex items-center justify-between border-b border-white/10 px-4 py-3.5 lg:hidden">
                        <div class="flex items-center gap-2.5">
                            <img src="{{ asset('images/Logo.png') }}" alt="BNYTI logo" class="size-7 brightness-0 invert">
                            <span class="text-xs font-black uppercase tracking-wider text-white">Navigation</span>
                        </div>
                        <button type="button" data-admin-menu-close class="rounded-lg p-1.5 text-slate-400 hover:bg-white/10 hover:text-white transition" aria-label="Close sidebar">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <nav class="flex-1 overflow-y-auto py-4 px-2 space-y-1 scrollbar-hide">
                        @foreach ($navigationGroups as $group)
                            @foreach ($group['items'] as $item)
                                @php
                                    $itemRoute = $item['route'] ?? null;
                                    $itemUrl = $item['url'] ?? ($itemRoute ? route($itemRoute, $item['parameters'] ?? []) : '#');
                                    $isActive = false;

                                    if ($itemRoute) {
                                        $isActive = collect($item['active'])->contains(function (string $pattern) use ($item): bool {
                                            if (! request()->routeIs($pattern)) {
                                                return false;
                                            }

                                            $itemParams = $item['parameters'] ?? [];

                                            if ($pattern === 'super-admin.students.index') {
                                                $isBranchView = request()->has('show_branches') || request()->has('branch_id') || request()->has('branch');
                                                $itemIsBranchView = ! empty($itemParams['show_branches']);

                                                return $isBranchView === $itemIsBranchView;
                                            }

                                            if (! empty($itemParams)) {
                                                foreach ($itemParams as $paramKey => $paramValue) {
                                                    $currentVal = request()->route($paramKey) ?? request()->query($paramKey);
                                                    if ((string) $currentVal !== (string) $paramValue) {
                                                        return false;
                                                    }
                                                }
                                                return true;
                                            }

                                            if (request()->routeIs('super-admin.branch-applications.index') && request()->has('status')) {
                                                return false;
                                            }

                                            return true;
                                        });
                                    }
                                @endphp
                                <a href="{{ $itemUrl }}"
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
            <main class="min-w-0 flex-1 p-3 sm:p-6 lg:p-12">
                @if (session('status'))
                    <div id="status-popup" class="fixed top-24 right-6 z-50 transform transition-all duration-500 ease-out translate-x-[calc(100%+24px)]">
                        <div class="flex items-center gap-5 rounded-[2rem] border border-white/20 bg-[#03224c]/90 p-5 shadow-2xl backdrop-blur-xl ring-1 ring-white/10 min-w-[340px]">
                            <div class="flex size-12 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
                                <svg viewBox="0 0 24 24" class="size-7" fill="none" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#6cb2eb]">System Notification</h4>
                                <p class="mt-1 text-sm font-black text-white">{{ session('status') }}</p>
                            </div>
                            <button onclick="document.getElementById('status-popup').classList.add('translate-x-[calc(100%+24px)]')" class="text-slate-500 transition hover:text-white">
                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const popup = document.getElementById('status-popup');
                            setTimeout(() => {
                                popup.classList.remove('translate-x-[calc(100%+24px)]');
                            }, 300);
                            setTimeout(() => {
                                popup.classList.add('translate-x-[calc(100%+24px)]');
                            }, 6000);
                        });
                    </script>
                @endif

                <div data-admin-workspace>
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>

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
        {{-- Top Navigation Bar --}}
        <header class="sticky top-0 z-40 flex h-16 items-center justify-between border-b border-white/10 bg-[#071c2c] px-4 sm:px-6 text-white shadow-md">
            <div class="flex items-center gap-3 sm:gap-4">
                @if ($isSuperAdmin || $isBranchUser)
                    <button type="button" id="mobile-menu-toggle" class="grid size-10 place-items-center rounded-xl bg-white/10 text-white lg:hidden hover:bg-white/20 active:scale-95 transition-all" aria-label="Toggle navigation">
                        <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                @endif
                <a href="/" class="flex items-center gap-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="BNYTI logo" class="size-8 sm:size-9 brightness-0 invert">
                    <span class="text-xs sm:text-sm font-black uppercase tracking-wider">South Asia Institute</span>
                </a>
            </div>
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="flex items-center gap-2 rounded-full bg-white/5 py-1.5 pl-3 pr-1.5 sm:pl-4 ring-1 ring-white/10">
                    <span class="text-[10px] sm:text-xs font-black uppercase tracking-wider opacity-80">{{ $isBranchUser ? 'Branch Panel' : 'Admin' }}</span>
                    <div class="grid size-7 sm:size-8 place-items-center rounded-full bg-slate-400 text-slate-900">
                        <svg viewBox="0 0 24 24" class="size-4 sm:size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex min-h-[calc(100vh-64px)]">
            {{-- Sidebar Navigation --}}
            @if ($isSuperAdmin || $isBranchUser)
                @php
                    $navigationGroups = $isSuperAdmin ? $adminNavigation : $branchNavigation;
                @endphp

                {{-- Desktop Sidebar --}}
                <aside class="hidden lg:flex sticky top-16 h-[calc(100vh-64px)] w-72 shrink-0 flex-col border-r border-white/10 bg-[#071c2c] shadow-sm">
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

                {{-- Mobile Drawer Sidebar --}}
                <div id="mobile-sidebar" class="fixed inset-0 z-50 hidden lg:hidden">
                    <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity"></div>
                    <aside class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[85vw] flex-col border-r border-white/10 bg-[#071c2c] text-white shadow-2xl">
                        <div class="flex h-16 items-center justify-between border-b border-white/10 px-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset('images/Logo.png') }}" alt="BNYTI logo" class="size-8 brightness-0 invert">
                                <span class="text-xs font-black uppercase tracking-wider">{{ $isBranchUser ? 'Branch Panel' : 'Admin Panel' }}</span>
                            </div>
                            <button type="button" id="mobile-sidebar-close" class="grid size-9 place-items-center rounded-lg bg-white/10 text-white hover:bg-white/20 active:scale-95 transition-all">
                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1 scrollbar-hide">
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
                                           'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-bold transition-all',
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
                        <div class="border-t border-white/5 p-4 bg-black/20">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-sm font-black text-slate-300 transition-all hover:bg-white/5 hover:text-white">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3">
                                        <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Log out
                                </button>
                            </form>
                        </div>
                    </aside>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', () => {
                        const toggleBtn = document.getElementById('mobile-menu-toggle');
                        const mobileSidebar = document.getElementById('mobile-sidebar');
                        const closeBtn = document.getElementById('mobile-sidebar-close');
                        const backdrop = document.getElementById('mobile-sidebar-backdrop');

                        function openSidebar() {
                            if (mobileSidebar) mobileSidebar.classList.remove('hidden');
                        }

                        function closeSidebar() {
                            if (mobileSidebar) mobileSidebar.classList.add('hidden');
                        }

                        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
                        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
                        if (backdrop) backdrop.addEventListener('click', closeSidebar);
                    });
                </script>
            @endif

            {{-- Main Content Area --}}
            <main class="min-w-0 flex-1 p-3 sm:p-6 lg:p-12 overflow-x-hidden">
                @if (session('status'))
                    <div id="status-popup" class="fixed top-20 right-4 sm:top-24 sm:right-6 z-50 transform transition-all duration-500 ease-out translate-x-[calc(100%+24px)]">
                        <div class="flex items-center gap-4 sm:gap-5 rounded-2xl sm:rounded-[2rem] border border-white/20 bg-[#03224c]/90 p-4 sm:p-5 shadow-2xl backdrop-blur-xl ring-1 ring-white/10 max-w-[90vw] sm:min-w-[340px]">
                            <div class="flex size-10 sm:size-12 shrink-0 items-center justify-center rounded-full bg-emerald-500/20 text-emerald-400">
                                <svg viewBox="0 0 24 24" class="size-6 sm:size-7" fill="none" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#6cb2eb]">System Notification</h4>
                                <p class="mt-0.5 sm:mt-1 text-xs sm:text-sm font-black text-white truncate">{{ session('status') }}</p>
                            </div>
                            <button onclick="document.getElementById('status-popup').classList.add('translate-x-[calc(100%+24px)]')" class="text-slate-500 transition hover:text-white">
                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const popup = document.getElementById('status-popup');
                            if (popup) {
                                setTimeout(() => {
                                    popup.classList.remove('translate-x-[calc(100%+24px)]');
                                }, 300);
                                setTimeout(() => {
                                    popup.classList.add('translate-x-[calc(100%+24px)]');
                                }, 6000);
                            }
                        });
                    </script>
                @endif

                <div data-admin-workspace class="w-full overflow-x-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>

        {{-- Login Welcome Modal Popup (Full Screen Experience with Time-Based 3D Visual Effects) --}}
        @if (session('show_welcome_modal'))
            @php
                $hour = (int) now()->timezone('Asia/Dhaka')->format('H');

                if ($hour >= 5 && $hour < 12) {
                    $timePeriod = 'morning';
                    $greetingEmoji = '🌞';
                    $greetingTitle = 'শুভ সকাল!';
                    $greetingSubtitle = 'আপনার আজকের দিনটি সফল, আনন্দময় ও নতুন সম্ভাবনাময় হোক।';
                    $bgGradient = 'from-amber-950/95 via-[#1b122c]/95 to-[#030914]/95';
                    $borderColor = 'border-amber-400/60';
                    $glowShadow = 'shadow-[0_0_100px_rgba(251,191,36,0.45)]';
                    $accentText = 'text-amber-300';
                    $badgeBg = 'bg-amber-400/10 border-amber-400/40 text-amber-300';
                    $btnGradient = 'from-amber-500 via-amber-400 to-amber-500 text-slate-950 shadow-amber-500/30';
                } elseif ($hour >= 12 && $hour < 16) {
                    $timePeriod = 'afternoon';
                    $greetingEmoji = '🌤️';
                    $greetingTitle = 'শুভ দুপুর!';
                    $greetingSubtitle = 'আপনার সকল কর্মপরিকল্পনা ও শিক্ষা উদ্যোগ সফলভাবে সম্পন্ন হোক।';
                    $bgGradient = 'from-[#032338]/95 via-[#08304b]/95 to-[#020b18]/95';
                    $borderColor = 'border-sky-400/60';
                    $glowShadow = 'shadow-[0_0_100px_rgba(56,189,248,0.45)]';
                    $accentText = 'text-sky-300';
                    $badgeBg = 'bg-sky-400/10 border-sky-400/40 text-sky-300';
                    $btnGradient = 'from-sky-500 via-sky-400 to-cyan-500 text-slate-950 shadow-sky-500/30';
                } elseif ($hour >= 16 && $hour < 20) {
                    $timePeriod = 'evening';
                    $greetingEmoji = '🌆';
                    $greetingTitle = 'শুভ সন্ধ্যা!';
                    $greetingSubtitle = 'শেখার প্রতিটি মুহূর্ত হোক আনন্দময় ও সফলতার নতুন পদচিহ্ন।';
                    $bgGradient = 'from-[#2a0e2a]/95 via-[#1a1030]/95 to-[#050614]/95';
                    $borderColor = 'border-amber-400/60';
                    $glowShadow = 'shadow-[0_0_100px_rgba(245,158,11,0.45)]';
                    $accentText = 'text-amber-300';
                    $badgeBg = 'bg-amber-400/10 border-amber-400/40 text-amber-300';
                    $btnGradient = 'from-amber-500 via-amber-400 to-orange-500 text-slate-950 shadow-amber-500/30';
                } else {
                    $timePeriod = 'night';
                    $greetingEmoji = '🌙';
                    $greetingTitle = 'শুভ রাত্রি!';
                    $greetingSubtitle = 'শান্তিময় রাত্রি ও আগামী দিনের শুভসূচনার জন্য আন্তরিক শুভকামনা।';
                    $bgGradient = 'from-[#0a0f29]/95 via-[#111638]/95 to-[#020412]/95';
                    $borderColor = 'border-indigo-400/60';
                    $glowShadow = 'shadow-[0_0_100px_rgba(129,140,248,0.45)]';
                    $accentText = 'text-indigo-300';
                    $badgeBg = 'bg-indigo-400/10 border-indigo-400/40 text-indigo-300';
                    $btnGradient = 'from-indigo-500 via-amber-400 to-indigo-500 text-slate-950 shadow-indigo-500/30';
                }

                $userPhoto = null;
                if ($isBranchUser) {
                    $branchApp = \App\Models\BranchApplication::query()->where('email', $user?->email)->first();
                    if ($branchApp?->director_photo_path) {
                        $userPhoto = asset('storage/' . $branchApp->director_photo_path);
                    }
                }
                if (! $userPhoto) {
                    $userPhoto = asset('images/principal-portrait.webp');
                }

                $userRoleTitle = $isSuperAdmin ? 'Super Admin' : ($isBranchUser ? 'Branch Director' : 'Panel User');
            @endphp

            <div id="welcome-modal" class="fixed inset-0 z-[100] flex flex-col items-center justify-center p-4 sm:p-8 bg-slate-950/90 backdrop-blur-2xl transition-all duration-700 overflow-y-auto">
                {{-- Ambient Background Light Particles --}}
                <div class="pointer-events-none fixed inset-0 overflow-hidden">
                    <div class="absolute -top-32 -left-32 size-96 rounded-full bg-amber-500/15 blur-[120px] animate-pulse"></div>
                    <div class="absolute -bottom-32 -right-32 size-96 rounded-full bg-indigo-500/15 blur-[120px] animate-pulse"></div>
                </div>

                <div class="relative w-full max-w-lg sm:max-w-xl overflow-hidden rounded-[3rem] border-2 {{ $borderColor }} bg-gradient-to-b {{ $bgGradient }} p-6 sm:p-10 text-white text-center {{ $glowShadow }} ring-1 ring-white/20 backdrop-blur-3xl transition-all my-auto">

                    {{-- Corner Decorative Frames --}}
                    <div class="absolute top-4 left-4 size-8 border-t-2 border-l-2 border-amber-400/80 rounded-tl-xl pointer-events-none"></div>
                    <div class="absolute top-4 right-4 size-8 border-t-2 border-r-2 border-amber-400/80 rounded-tr-xl pointer-events-none"></div>
                    <div class="absolute bottom-4 left-4 size-8 border-b-2 border-l-2 border-amber-400/80 rounded-bl-xl pointer-events-none"></div>
                    <div class="absolute bottom-4 right-4 size-8 border-b-2 border-r-2 border-amber-400/80 rounded-br-xl pointer-events-none"></div>

                    {{-- Close Button --}}
                    <button onclick="document.getElementById('welcome-modal').remove()" class="absolute top-5 right-5 z-30 grid size-10 place-items-center rounded-full bg-white/10 text-slate-300 hover:bg-white/20 hover:text-white transition shadow-lg">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>

                    {{-- User Portrait Photo with 3D Glowing Ring --}}
                    <div class="relative mt-2 mx-auto inline-block">
                        <div class="relative size-36 sm:size-44 rounded-3xl p-1 bg-gradient-to-tr from-cyan-400 via-amber-400 to-indigo-500 shadow-[0_0_40px_rgba(251,191,36,0.6)]">
                            <div class="size-full overflow-hidden rounded-[1.3rem] bg-slate-900 border-2 border-white/40 shadow-inner">
                                <img src="{{ $userPhoto }}" onerror="this.onerror=null; this.src='{{ asset('images/Logo.png') }}';" alt="{{ $user?->name }}" class="size-full object-cover object-center transform transition duration-500 hover:scale-105">
                            </div>
                        </div>
                        <span class="absolute -bottom-3 left-1/2 -translate-x-1/2 rounded-full bg-slate-900/90 border border-amber-400/60 px-4 py-0.5 text-[10px] font-black uppercase tracking-widest text-amber-300 shadow-lg backdrop-blur-md">
                            {{ $userRoleTitle }}
                        </span>
                    </div>

                    {{-- User Name --}}
                    <h2 class="mt-6 text-2xl sm:text-4xl font-serif font-black tracking-wide text-[#fce080] drop-shadow-[0_0_20px_rgba(252,224,128,0.8)]">
                        {{ $user?->name ?: 'আলী মামুন' }}
                    </h2>

                    {{-- DYNAMIC 3D TIME-BASED VISUAL EFFECT DISPLAY CONTAINER --}}
                    <div class="relative my-6 mx-auto w-full max-w-sm h-32 sm:h-36 rounded-2xl border border-white/15 bg-white/5 backdrop-blur-md overflow-hidden flex items-center justify-center p-4 shadow-2xl">

                        @if ($timePeriod === 'morning')
                            {{-- 3D MORNING SUN & RAYS EFFECT --}}
                            <div class="relative size-28 flex items-center justify-center">
                                <div class="absolute inset-0 rounded-full bg-amber-400/30 blur-xl animate-pulse"></div>
                                {{-- Rotating Solar Ray Ring --}}
                                <div class="absolute size-24 rounded-full border-2 border-dashed border-amber-300/60 animate-[spin_20s_linear_infinite]"></div>
                                <div class="absolute size-28 rounded-full border border-amber-400/30 animate-[spin_35s_linear_infinite_reverse]"></div>
                                {{-- 3D Sun Sphere --}}
                                <div class="size-16 rounded-full bg-gradient-to-tr from-amber-600 via-amber-400 to-yellow-100 shadow-[0_0_35px_rgba(251,191,36,0.9)] flex items-center justify-center">
                                    <div class="size-12 rounded-full bg-gradient-to-br from-yellow-200 to-amber-500 opacity-90"></div>
                                </div>
                            </div>
                        @elseif ($timePeriod === 'afternoon')
                            {{-- 3D AFTERNOON CRYSTAL & SOLAR FLARE EFFECT --}}
                            <div class="relative size-28 flex items-center justify-center">
                                <div class="absolute inset-0 rounded-full bg-sky-400/30 blur-xl animate-pulse"></div>
                                <div class="absolute size-24 rounded-full border-2 border-dashed border-cyan-300/60 animate-[spin_15s_linear_infinite]"></div>
                                {{-- Floating 3D Diamond Prism --}}
                                <div class="size-16 rotate-45 rounded-2xl bg-gradient-to-tr from-cyan-500 via-sky-300 to-white shadow-[0_0_35px_rgba(56,189,248,0.9)] flex items-center justify-center transform transition duration-1000 animate-[bounce_4s_easeInOut_infinite]">
                                    <div class="size-10 rotate-12 rounded-xl bg-white/80 backdrop-blur-sm"></div>
                                </div>
                            </div>
                        @elseif ($timePeriod === 'evening')
                            {{-- 3D EVENING SUNSET & COSMIC AURORA EFFECT --}}
                            <div class="relative size-28 flex items-center justify-center">
                                <div class="absolute inset-0 rounded-full bg-orange-500/30 blur-xl animate-pulse"></div>
                                <div class="absolute size-24 rounded-full border-2 border-amber-400/50 animate-[spin_25s_linear_infinite]"></div>
                                <div class="absolute size-28 rounded-full border border-purple-400/40 animate-[spin_40s_linear_infinite_reverse]"></div>
                                {{-- 3D Sunset Glow Orb --}}
                                <div class="size-16 rounded-full bg-gradient-to-tr from-orange-600 via-rose-400 to-amber-200 shadow-[0_0_35px_rgba(245,158,11,0.9)] flex items-center justify-center">
                                    <div class="size-12 rounded-full bg-gradient-to-b from-amber-300 to-rose-600 opacity-90"></div>
                                </div>
                            </div>
                        @else
                            {{-- 3D NIGHT GALAXY & MOON EFFECT --}}
                            <div class="relative size-28 flex items-center justify-center">
                                <div class="absolute inset-0 rounded-full bg-indigo-500/30 blur-xl animate-pulse"></div>
                                {{-- Saturn Ring --}}
                                <div class="absolute size-28 rounded-full border-2 border-indigo-400/40 rotate-[60deg] animate-[spin_30s_linear_infinite]"></div>
                                {{-- 3D Moon Crescent --}}
                                <div class="relative size-16 rounded-full bg-gradient-to-tr from-indigo-300 via-slate-100 to-amber-200 shadow-[0_0_35px_rgba(165,180,252,0.9)] flex items-center justify-center">
                                    <div class="absolute top-1 right-1 size-12 rounded-full bg-[#0d1335]"></div>
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- Dynamic Time-Based Greeting Message --}}
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2.5 rounded-full {{ $badgeBg }} px-6 py-2 text-xl sm:text-2xl font-serif font-black shadow-lg backdrop-blur-md">
                            <span class="text-2xl sm:text-3xl">{{ $greetingEmoji }}</span>
                            <span>{{ $greetingTitle }}</span>
                        </div>
                        <p class="text-xs sm:text-base font-bold text-slate-200 max-w-sm mx-auto leading-relaxed mt-2">
                            {{ $greetingSubtitle }}
                        </p>
                    </div>

                    {{-- Enter Dashboard Action Button --}}
                    <div class="mt-8">
                        <button onclick="document.getElementById('welcome-modal').remove()" class="w-full rounded-2xl bg-gradient-to-r {{ $btnGradient }} py-4 text-sm sm:text-base font-black uppercase tracking-wider shadow-2xl transition-all duration-300 hover:scale-[1.02] active:scale-95 cursor-pointer">
                            ড্যাশবোর্ডে প্রবেশ করুন ➔
                        </button>
                    </div>

                </div>
            </div>
        @endif
    </body>
</html>

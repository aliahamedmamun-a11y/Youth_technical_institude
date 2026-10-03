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
                    <span class="text-xs sm:text-sm font-black uppercase tracking-wider">BNTEI</span>
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

        {{-- Login Welcome Modal Popup --}}
        @if (session('show_welcome_modal'))
            @php
                $hour = (int) now()->timezone('Asia/Dhaka')->format('H');

                if ($hour >= 5 && $hour < 12) {
                    $greetingEmoji = '🌞';
                    $greetingTitle = 'শুভ সকাল!';
                    $greetingSubtitle = 'আপনার আজকের দিনটি সফল ও ফলপ্রসূ হোক।';
                } elseif ($hour >= 12 && $hour < 16) {
                    $greetingEmoji = '🌤️';
                    $greetingTitle = 'শুভ দুপুর!';
                    $greetingSubtitle = 'আপনার সকল কার্যক্রম সফলভাবে সম্পন্ন হোক।';
                } elseif ($hour >= 16 && $hour < 18) {
                    $greetingEmoji = '🌇';
                    $greetingTitle = 'শুভ বিকেল!';
                    $greetingSubtitle = 'নতুন উদ্যমে আপনার কাজ এগিয়ে নিন।';
                } elseif ($hour >= 18 && $hour < 20) {
                    $greetingEmoji = '🌆';
                    $greetingTitle = 'শুভ সন্ধ্যা!';
                    $greetingSubtitle = 'শেখার প্রতিটি মুহূর্ত হোক আনন্দময়।';
                } else {
                    $greetingEmoji = '🌙';
                    $greetingTitle = 'শুভ রাত্রি!';
                    $greetingSubtitle = 'আগামী দিনের জন্য আন্তরিক শুভকামনা।';
                }

                $userPhoto = null;
                if ($isBranchUser) {
                    $branchApp = \App\Models\BranchApplication::query()->where('email', $user?->email)->first();
                    if ($branchApp?->director_photo_path) {
                        $userPhoto = asset('storage/' . $branchApp->director_photo_path);
                    }
                }
                if (!$userPhoto) {
                    $userPhoto = 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg';
                }
            @endphp

            <div id="welcome-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/85 backdrop-blur-md transition-all duration-500">
                <div class="relative w-full max-w-xs sm:max-w-sm overflow-hidden rounded-[2.5rem] border-2 border-amber-400/50 bg-gradient-to-b from-[#061b2e] via-[#082a40] to-[#041220] p-6 text-white text-center shadow-[0_0_60px_rgba(234,179,8,0.3)] ring-1 ring-white/20 animate-[scaleIn_0.4s_ease-out]">

                    {{-- Corner Decorative Borders --}}
                    <div class="absolute top-3 left-3 size-6 border-t-2 border-l-2 border-amber-400/70 rounded-tl-lg pointer-events-none"></div>
                    <div class="absolute top-3 right-3 size-6 border-t-2 border-r-2 border-amber-400/70 rounded-tr-lg pointer-events-none"></div>
                    <div class="absolute bottom-3 left-3 size-6 border-b-2 border-l-2 border-amber-400/70 rounded-bl-lg pointer-events-none"></div>
                    <div class="absolute bottom-3 right-3 size-6 border-b-2 border-r-2 border-amber-400/70 rounded-br-lg pointer-events-none"></div>

                    {{-- Close Button --}}
                    <button onclick="document.getElementById('welcome-modal').remove()" class="absolute top-4 right-4 z-20 grid size-8 place-items-center rounded-full bg-white/10 text-slate-300 hover:bg-white/20 hover:text-white transition">
                        <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>

                    {{-- Top Portrait Photo inside Glowing Box --}}
                    <div class="relative mt-2 mx-auto inline-block">
                        <div class="size-36 sm:size-44 rounded-2xl p-1 bg-gradient-to-tr from-cyan-400 via-blue-500 to-amber-400 shadow-[0_0_25px_rgba(56,189,248,0.5)]">
                            <div class="size-full overflow-hidden rounded-xl bg-slate-900 border border-white/30">
                                <img src="{{ $userPhoto }}" alt="{{ $user?->name }}" class="size-full object-cover object-center">
                            </div>
                        </div>
                    </div>

                    {{-- Logged in User Name --}}
                    <h2 class="mt-4 text-xl sm:text-2xl font-serif font-black tracking-wide text-amber-300 drop-shadow-[0_0_12px_rgba(252,211,77,0.6)]">
                        {{ $user?->name ?: 'আলী মামুন' }}
                    </h2>

                    {{-- Animated Handshake Graphic (Hands coming from left and right) --}}
                    <div class="relative my-4 flex items-center justify-center h-20 overflow-hidden">
                        {{-- Aura Glow Center --}}
                        <div class="absolute size-24 rounded-full bg-amber-400/25 blur-xl animate-pulse"></div>

                        {{-- Handshake Illustration --}}
                        <div class="relative z-10 flex items-center justify-center text-amber-300 drop-shadow-[0_0_15px_rgba(251,191,36,0.7)]">
                            <svg viewBox="0 0 100 60" class="w-56 h-16">
                                <defs>
                                    <linearGradient id="welcomeGold" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%" stop-color="#fef08a" />
                                        <stop offset="50%" stop-color="#f59e0b" />
                                        <stop offset="100%" stop-color="#d97706" />
                                    </linearGradient>
                                </defs>
                                <path d="M0,35 Q20,35 35,30 L45,35 C42,40 35,42 25,42 Z" fill="url(#welcomeGold)" />
                                <path d="M100,35 Q80,35 65,30 L55,35 C58,40 65,42 75,42 Z" fill="url(#welcomeGold)" />
                                <path d="M35,30 C38,22 50,22 52,28 C55,24 62,25 62,32 C62,38 52,44 42,40 C38,38 35,34 35,30 Z" fill="url(#welcomeGold)" stroke="#fef3c7" stroke-width="1.5" />
                                <path d="M42,28 Q48,32 52,38" fill="none" stroke="#78350f" stroke-width="1.5" stroke-linecap="round" />
                                <path d="M46,26 Q52,30 56,36" fill="none" stroke="#78350f" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                        </div>
                    </div>

                    {{-- Time-based Dynamic Greeting Message --}}
                    <div class="space-y-1.5">
                        <div class="inline-flex items-center gap-2 rounded-full bg-amber-400/10 border border-amber-400/40 px-4 py-1 text-lg sm:text-xl font-serif font-black text-amber-300 drop-shadow-[0_0_10px_rgba(251,191,36,0.5)]">
                            <span>{{ $greetingEmoji }}</span>
                            <span>{{ $greetingTitle }}</span>
                        </div>
                        <p class="text-xs font-bold text-slate-200 max-w-xs mx-auto leading-relaxed">
                            {{ $greetingSubtitle }}
                        </p>
                    </div>

                    {{-- Enter Dashboard Button --}}
                    <div class="mt-5">
                        <button onclick="document.getElementById('welcome-modal').remove()" class="w-full rounded-xl bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 py-2.5 text-xs font-black uppercase tracking-wider text-slate-950 shadow-lg shadow-amber-500/30 transition-all hover:scale-[1.02] active:scale-95">
                            ড্যাশবোর্ডে প্রবেশ করুন ➔
                        </button>
                    </div>

                </div>
            </div>
        @endif
    </body>
</html>

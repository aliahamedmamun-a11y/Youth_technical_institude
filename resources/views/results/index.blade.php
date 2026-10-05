<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#061527">
        <meta name="description" content="Find and verify your official Bangladesh National Youth Technical Institute examination result.">
        <title>Student Result Portal | BNYTI</title>
        <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/png">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- HTML5 QR CODE SCANNER LIBRARY -->
        <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    </head>
    <body class="min-h-screen overflow-x-hidden bg-[#04101e] text-white antialiased font-sans">

        <!-- HEADER NAVIGATION BAR -->
        <header class="relative z-50 border-b border-white/10 bg-[#061527]/95 backdrop-blur-xl">
            <div class="mx-auto flex h-[76px] max-w-7xl items-center justify-between gap-5 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-3" aria-label="Home">
                    <img src="{{ asset('images/Logo.png') }}" alt="BNYTI logo" class="brand-logo size-12 shrink-0 transition duration-300 group-hover:-rotate-3 sm:size-14">
                    <span class="hidden min-w-0 sm:block">
                        <span class="block truncate text-sm font-black tracking-tight text-white sm:text-[15px]">
                            <span class="text-emerald-400">SOUTH ASIA</span> <span class="text-rose-500">NATIONAL</span>
                        </span>
                        <span class="block truncate text-[10px] font-bold tracking-[0.17em] text-slate-300 sm:text-[11px]">TECHNICAL INSTITUTE</span>
                    </span>
                    <span class="sm:hidden">
                        <span class="block text-base font-black tracking-tight text-white">SOUTH ASIA</span>
                        <span class="block text-[9px] font-bold tracking-[0.14em] text-slate-300">TECHNICAL INSTITUTE</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-6 lg:flex" aria-label="Primary navigation">
                    <a href="{{ route('home') }}#home" class="text-slate-300 hover:text-white font-bold text-sm transition">Home</a>
                    <a href="{{ route('home') }}#courses" class="text-slate-300 hover:text-white font-bold text-sm transition">Course List</a>
                    <a href="{{ route('home') }}#verified-branches" class="text-slate-300 hover:text-white font-bold text-sm transition">Verified Branches</a>
                    <a href="{{ route('results.index') }}" class="text-emerald-400 font-bold text-sm border-b-2 border-emerald-400 pb-1" aria-current="page">Result Search</a>
                    <a href="{{ route('home') }}#about" class="text-slate-300 hover:text-white font-bold text-sm transition">About</a>
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white font-bold text-sm transition">Login</a>
                    <a href="{{ route('home') }}#contact" class="text-slate-300 hover:text-white font-bold text-sm transition">Contact</a>
                </nav>

                <div class="flex shrink-0 items-center gap-2">
                    <button type="button" class="icon-button border border-white/10 bg-white/5 text-white hover:bg-white/10 rounded-xl px-3 py-1.5" data-locale-toggle aria-label="Switch language">
                        <span class="text-xs font-black" data-locale-label>বাংলা</span>
                    </button>
                    <button type="button" class="icon-button border border-white/10 bg-white/5 text-white hover:bg-white/10 rounded-xl p-2" data-theme-toggle aria-label="Toggle color theme">
                        <svg data-theme-sun viewBox="0 0 24 24" aria-hidden="true" class="size-5"><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg>
                        <svg data-theme-moon viewBox="0 0 24 24" aria-hidden="true" class="hidden size-5"><path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/></svg>
                    </button>
                    <button type="button" class="icon-button lg:hidden border border-white/10 bg-white/5 text-white hover:bg-white/10 rounded-xl p-2" data-menu-toggle aria-expanded="false" aria-controls="results-mobile-menu" aria-label="Open menu">
                        <svg data-menu-open viewBox="0 0 24 24" aria-hidden="true" class="size-6"><path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                        <svg data-menu-close viewBox="0 0 24 24" aria-hidden="true" class="hidden size-6"><path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                    </button>
                </div>
            </div>

            <div id="results-mobile-menu" class="border-t border-white/10 bg-[#061527] px-4 py-5 shadow-2xl lg:hidden" data-mobile-menu hidden>
                <nav class="mx-auto grid max-w-7xl gap-1" aria-label="Mobile navigation">
                    <a href="{{ route('home') }}#home" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-slate-200 hover:bg-white/5">Home</a>
                    <a href="{{ route('home') }}#courses" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-slate-200 hover:bg-white/5">Course List</a>
                    <a href="{{ route('home') }}#verified-branches" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-slate-200 hover:bg-white/5">Verified Branches</a>
                    <a href="{{ route('results.index') }}" class="block rounded-xl px-4 py-2.5 text-sm font-bold bg-emerald-500/10 text-emerald-400">Result Search</a>
                    <a href="{{ route('home') }}#about" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-slate-200 hover:bg-white/5">About</a>
                    <a href="{{ route('login') }}" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-slate-200 hover:bg-white/5">Login</a>
                    <a href="{{ route('home') }}#contact" class="block rounded-xl px-4 py-2.5 text-sm font-bold text-slate-200 hover:bg-white/5">Contact</a>
                </nav>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="mx-auto flex min-h-screen w-full max-w-5xl flex-col px-4 py-8 sm:px-6 sm:py-12 lg:px-8">

            <!-- HERO HEADER -->
            <header class="text-center space-y-3">
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center" aria-label="Back to BNYTI home">
                    <div class="relative size-24 sm:size-32 rounded-full p-1 bg-gradient-to-tr from-amber-400 via-emerald-400 to-cyan-400 shadow-2xl">
                        <div class="size-full overflow-hidden rounded-full bg-[#061527] p-1 flex items-center justify-center border-2 border-white/20">
                            <img src="{{ asset('images/Logo.png') }}" alt="Bangladesh National Youth Technical Institute logo" class="brand-logo size-full object-contain transition duration-300 group-hover:-rotate-3">
                        </div>
                    </div>
                    <h1 class="mt-4 text-2xl sm:text-3xl lg:text-4xl font-black tracking-tight text-[#10b981] drop-shadow-md">
                        South Asia Engineering & Technical Institute
                    </h1>
                    <div class="flex items-center justify-center gap-3 text-xs sm:text-sm font-semibold text-slate-300">
                        <span class="hidden h-px w-10 bg-emerald-500 sm:block"></span>
                        Skill for Today, Success for Tomorrow
                        <span class="hidden h-px w-10 bg-emerald-500 sm:block"></span>
                    </div>
                </a>
            </header>

            <!-- MAIN RESULT SEARCH CARD (DESIGN MATCHING SECOND IMAGE) -->
            <section class="mt-8 sm:mt-10 rounded-3xl border border-cyan-500/20 bg-[#0c2035] p-6 sm:p-10 lg:p-12 shadow-[0_20px_70px_rgba(0,0,0,0.6)] text-center relative overflow-hidden">

                <div class="mx-auto max-w-2xl space-y-6">

                    <!-- TOP CIRCULAR BADGE ICON -->
                    <div class="mx-auto size-16 sm:size-20 rounded-full border-2 border-cyan-500/30 bg-[#071728] shadow-[0_0_25px_rgba(6,182,212,0.25)] flex items-center justify-center text-cyan-400">
                        <svg class="size-8 sm:size-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.75 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            <circle cx="16.5" cy="16.5" r="3.5" fill="#071728" stroke="currentColor" stroke-width="1.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 19l2.5 2.5" />
                        </svg>
                    </div>

                    <!-- CARD TITLE -->
                    <div>
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black uppercase tracking-wider text-[#f0c15c] drop-shadow-[0_0_12px_rgba(240,193,92,0.4)]">
                            STUDENT RESULT PORTAL
                        </h2>
                        <div class="mt-3 flex items-center justify-center gap-2">
                            <span class="h-0.5 w-12 bg-cyan-500/40 rounded-full"></span>
                            <span class="size-2 rounded-full bg-cyan-400"></span>
                            <span class="size-2.5 rounded-full bg-amber-400 shadow-[0_0_8px_#fbbf24]"></span>
                            <span class="size-2 rounded-full bg-cyan-400"></span>
                            <span class="h-0.5 w-12 bg-cyan-500/40 rounded-full"></span>
                        </div>
                    </div>

                    <!-- SUBTITLE -->
                    <p class="text-sm sm:text-base font-medium text-slate-300">
                        Enter your Roll Number to view your official examination result
                    </p>

                    <!-- NOT FOUND ALERT -->
                    @if ($searched)
                        <div role="alert" class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-3.5 text-xs sm:text-sm font-bold text-rose-300">
                            No published result was found for this Roll Number. Please check the number and try again.
                        </div>
                    @endif

                    <!-- SEARCH FORM -->
                    <form id="result-search-form" method="GET" action="{{ route('results.index') }}" class="space-y-4 pt-2">
                        <label for="roll-number" class="sr-only">Roll Number</label>

                        <!-- INPUT FIELD WITH ICON -->
                        <div class="flex items-stretch overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-lg focus-within:ring-4 focus-within:ring-cyan-500/30 transition-all">
                            <div class="w-14 sm:w-16 flex items-center justify-center bg-slate-100 text-slate-500 border-r border-slate-200 shrink-0">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
                            <input id="roll-number" name="roll_number" value="{{ old('roll_number', $rollNumber ?? '') }}" inputmode="numeric" autocomplete="off" required maxlength="50" placeholder="Enter Your Roll Number" class="w-full bg-white px-4 py-4 text-slate-800 placeholder-slate-400 font-semibold text-base sm:text-lg outline-none">
                        </div>

                        <!-- SUBMIT BUTTON -->
                        <button type="submit" class="w-full rounded-2xl bg-white text-slate-900 py-4 text-base sm:text-lg font-black uppercase tracking-wider shadow-2xl transition-all hover:bg-slate-100 active:scale-98 flex items-center justify-center gap-3">
                            <svg class="size-6 text-slate-900" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <circle cx="11" cy="11" r="7"/>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                            </svg>
                            VIEW RESULT
                        </button>

                        <!-- SCAN QR CODE BUTTON -->
                        <div class="pt-2">
                            <button type="button" onclick="openResultQrScanner()" class="w-full rounded-2xl border-2 border-cyan-400/50 bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-300 py-3.5 px-6 font-black text-xs sm:text-sm uppercase tracking-wider transition-all flex items-center justify-center gap-2.5 shadow-lg active:scale-98">
                                <svg class="size-5 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.008v.008H6.75V6.75zM6.75 16.5h.008v.008H6.75V16.5zM16.5 6.75h.008v.008H16.5V6.75zM13.5 13.5h2.25v2.25H13.5v-2.25zM16.5 16.5h2.25v2.25H16.5v-2.25zM13.5 18.75h2.25v2.25H13.5v-2.25zM18.75 13.5h2.25v2.25H18.75v-2.25z" />
                                </svg>
                                <span>SCAN QR CODE TO VERIFY RESULT</span>
                            </button>
                        </div>

                        <!-- FOOTER NOTE -->
                        <p class="pt-2 flex items-center justify-center gap-2 text-xs sm:text-sm font-medium text-slate-300">
                            <svg class="size-4 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0110.43-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                            Please enter a valid Roll Number to view your official result.
                        </p>
                    </form>

                </div>
            </section>

            <!-- 4 FEATURE ITEMS CARD (WHITE CARD) -->
            <section class="mt-6 sm:mt-8 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-2xl text-slate-900" aria-label="Result portal benefits">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 divide-y sm:divide-y-0 lg:divide-x divide-slate-200">

                    <!-- Item 1: FAST & EASY -->
                    <div class="flex flex-col items-center text-center p-3 space-y-2">
                        <div class="size-12 rounded-full bg-[#0c2035] text-cyan-400 flex items-center justify-center shadow-lg">
                            <svg class="size-6 fill-current" viewBox="0 0 24 24">
                                <path d="m13.2 2-8 11h5.7L10 22l8.8-12h-5.6z"/>
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider">FAST & EASY</h3>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed">Get your result in just a second</p>
                    </div>

                    <!-- Item 2: 100% OFFICIAL -->
                    <div class="flex flex-col items-center text-center p-3 space-y-2 pt-6 sm:pt-3">
                        <div class="size-12 rounded-full bg-[#0c2035] text-cyan-400 flex items-center justify-center shadow-lg">
                            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider">100% OFFICIAL</h3>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed">Authentic & official examination result</p>
                    </div>

                    <!-- Item 3: SECURE & SAFE -->
                    <div class="flex flex-col items-center text-center p-3 space-y-2 pt-6 sm:pt-3">
                        <div class="size-12 rounded-full bg-[#0c2035] text-cyan-400 flex items-center justify-center shadow-lg">
                            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="5" y="10" width="14" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider">SECURE & SAFE</h3>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed">Your data is protected and fully secure</p>
                    </div>

                    <!-- Item 4: TRUSTED INSTITUTE -->
                    <div class="flex flex-col items-center text-center p-3 space-y-2 pt-6 sm:pt-3">
                        <div class="size-12 rounded-full bg-[#0c2035] text-cyan-400 flex items-center justify-center shadow-lg">
                            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="8" r="4"/>
                                <path d="m9 12-2 9 5-3 5 3-2-9"/>
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider">TRUSTED INSTITUTE</h3>
                        <p class="text-xs font-medium text-slate-500 leading-relaxed">Govt. Registered Technical Institute</p>
                    </div>

                </div>
            </section>

            <!-- CYAN/TEAL IMPORTANT BANNER (BOTTOM BANNER FROM SECOND IMAGE) -->
            <aside class="mt-6 sm:mt-8 rounded-2xl bg-gradient-to-r from-[#0d6088] via-[#0284c7] to-[#0ea5e9] p-4 sm:p-5 text-white flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl border border-cyan-400/30 relative overflow-hidden">
                <div class="flex items-center gap-3 sm:gap-4 w-full sm:w-auto">
                    <div class="size-10 sm:size-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white shrink-0 shadow-inner">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm sm:text-base font-black tracking-wider uppercase text-white">IMPORTANT</h2>
                    </div>
                    <div class="hidden sm:block h-8 w-px bg-white/30 mx-2"></div>
                </div>

                <p class="text-xs sm:text-sm font-semibold text-slate-100 text-center sm:text-left flex-1">
                    Make sure you enter the correct Roll Number to get your accurate result.
                </p>

                <!-- Graduation Cap & Book Graphic Icon -->
                <div class="shrink-0 text-amber-300 opacity-90 hidden sm:block">
                    <svg class="size-10 sm:size-12 drop-shadow-md" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147L12 14.63l7.74-4.483a1.125 1.125 0 000-1.954L12 3.71 4.26 8.193a1.125 1.125 0 000 1.954z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12v5.25c0 1.5 2.686 2.25 6 2.25s6-.75 6-2.25V12" />
                    </svg>
                </div>
            </aside>

            <!-- FOOTER -->
            <footer class="mt-auto pt-12 text-center space-y-4">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-sm font-black text-white hover:text-emerald-400 transition">
                    <span class="h-px w-12 bg-emerald-500"></span>
                    <img src="{{ asset('images/Logo.png') }}" alt="BNYTI Logo" class="size-10">
                    <span class="h-px w-12 bg-emerald-500"></span>
                </a>
                <p class="text-xs sm:text-sm font-medium text-slate-300">
                    © {{ date('Y') }} South Asia Engineering & Technical Institute. All Rights Reserved.
                </p>
                <p class="text-emerald-400 text-xs tracking-widest" aria-hidden="true">★ ★ ★</p>
            </footer>

        </main>

        <!-- QR SCANNER MODAL -->
        <div id="qr-scanner-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
            <div class="w-full max-w-md rounded-3xl border border-cyan-500/30 bg-[#071c2c] p-6 shadow-2xl space-y-5 relative text-center">

                <!-- Header -->
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="size-3 rounded-full bg-emerald-400 animate-ping"></span>
                        <h3 class="text-sm font-black text-cyan-300 uppercase tracking-wider">
                            Scan Result QR Code
                        </h3>
                    </div>
                    <button type="button" onclick="closeResultQrScanner()" class="rounded-xl bg-white/10 p-2 text-slate-300 hover:bg-white/20 hover:text-white transition-all">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Scanner Reader Box -->
                <div class="relative w-full h-64 sm:h-72 rounded-2xl overflow-hidden bg-black border border-cyan-500/30 shadow-inner flex items-center justify-center">
                    <div id="qr-reader" class="size-full"></div>

                    <!-- Scanning Overlay Frame -->
                    <div class="absolute inset-0 pointer-events-none border-2 border-cyan-400/40 rounded-2xl flex items-center justify-center">
                        <div class="size-48 border-2 border-dashed border-cyan-400 rounded-xl relative">
                            <div class="absolute -top-1 -left-1 size-4 border-t-2 border-l-2 border-cyan-300"></div>
                            <div class="absolute -top-1 -right-1 size-4 border-t-2 border-r-2 border-cyan-300"></div>
                            <div class="absolute -bottom-1 -left-1 size-4 border-b-2 border-l-2 border-cyan-300"></div>
                            <div class="absolute -bottom-1 -right-1 size-4 border-b-2 border-r-2 border-cyan-300"></div>
                            <div class="w-full h-0.5 bg-cyan-400 shadow-[0_0_15px_#22d3ee] animate-pulse absolute top-1/2"></div>
                        </div>
                    </div>
                </div>

                <!-- File Upload Fallback -->
                <div class="pt-1 space-y-3">
                    <p class="text-xs font-semibold text-slate-300">Or choose a QR Code photo from device:</p>
                    <label class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-white px-4 py-3 text-xs font-bold uppercase tracking-wider cursor-pointer border border-white/10 shadow transition active:scale-95">
                        <svg class="size-4 text-cyan-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <span>Upload QR Code Image</span>
                        <input type="file" id="qr-file-input" accept="image/*" class="hidden" onchange="scanQrCodeImageFile(this)">
                    </label>
                </div>

                <p id="qr-scan-status" class="text-xs font-medium text-slate-400">
                    Point camera at the QR code on Result Sheet or Admit Card.
                </p>

            </div>
        </div>

        <script>
            let html5QrScanner = null;

            function openResultQrScanner() {
                const modal = document.getElementById('qr-scanner-modal');
                if (modal) modal.classList.remove('hidden');

                if (typeof Html5Qrcode !== 'undefined') {
                    html5QrScanner = new Html5Qrcode("qr-reader");
                    const config = { fps: 10, qrbox: { width: 220, height: 220 } };

                    html5QrScanner.start(
                        { facingMode: "environment" },
                        config,
                        onQrCodeSuccess,
                        onQrCodeError
                    ).catch(err => {
                        console.warn("Camera QR scanner start error:", err);
                        document.getElementById('qr-scan-status').textContent = "Camera access denied. Please upload QR Code image file below.";
                    });
                } else {
                    document.getElementById('qr-scan-status').textContent = "QR library loading. Please upload QR image file below.";
                }
            }

            function closeResultQrScanner() {
                const modal = document.getElementById('qr-scanner-modal');
                if (modal) modal.classList.add('hidden');

                if (html5QrScanner) {
                    html5QrScanner.stop().then(() => {
                        html5QrScanner.clear();
                        html5QrScanner = null;
                    }).catch(() => {
                        html5QrScanner = null;
                    });
                }
            }

            function onQrCodeSuccess(decodedText, decodedResult) {
                console.log("QR Code Scanned:", decodedText);
                handleDecodedQrResult(decodedText);
            }

            function onQrCodeError(errorMessage) {
                // Ignore scanning retry frames
            }

            function scanQrCodeImageFile(input) {
                if (input.files && input.files[0] && typeof Html5Qrcode !== 'undefined') {
                    const html5QrCode = new Html5Qrcode("qr-reader");
                    html5QrCode.scanFile(input.files[0], true)
                        .then(decodedText => {
                            handleDecodedQrResult(decodedText);
                        })
                        .catch(err => {
                            alert("Could not detect QR code in this image. Please ensure the QR code is clear.");
                        });
                }
            }

            function handleDecodedQrResult(decodedText) {
                closeResultQrScanner();

                if (decodedText.startsWith("http://") || decodedText.startsWith("https://")) {
                    window.location.href = decodedText;
                } else {
                    const rollInput = document.getElementById('roll-number');
                    const form = document.getElementById('result-search-form');
                    if (rollInput && form) {
                        rollInput.value = decodedText.trim();
                        form.submit();
                    }
                }
            }
        </script>
    </body>
</html>

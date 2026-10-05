<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#03224c">
        <title>Branch Registration | South Asia Engineering & Technical Institute</title>
        <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/png">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen overflow-x-hidden bg-[#e7f3f9] text-slate-900 antialiased dark:bg-ink dark:text-white">
        <a href="#main-content" class="fixed top-3 left-3 z-[100] -translate-y-20 rounded-full bg-amber-400 px-5 py-3 text-sm font-bold text-[#03224c] transition focus:translate-y-0">Skip to content</a>

        <header class="relative z-50 border-b border-slate-200 bg-white/95 backdrop-blur-xl dark:border-white/10 dark:bg-ink/95">
            <div class="border-b border-slate-100 bg-[#03224c] text-white dark:border-white/10">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 text-[11px] font-semibold tracking-wide sm:px-6 lg:px-8">
                    <p class="flex items-center gap-2">
                        <span class="size-1.5 rounded-full bg-amber-400"></span>Branch applications are open nationwide
                    </p>
                    <div class="hidden gap-5 sm:flex">
                        <a href="tel:+8809696481628" class="hover:text-amber-300 transition">+880 9696-481628</a>
                        <a href="mailto:bnyti-edubd@gmail.com" class="hover:text-amber-300 transition">bnyti-edubd@gmail.com</a>
                    </div>
                </div>
            </div>

            <div class="mx-auto flex h-[76px] max-w-7xl items-center justify-between gap-5 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="brand-logo size-12 shrink-0 sm:size-14">
                    <span class="hidden min-w-0 sm:block">
                        <span class="block text-sm font-black tracking-tight text-[#03224c] dark:text-white sm:text-[15px]">
                            <span class="text-[#03224c] dark:text-white">SOUTH ASIA</span> <span class="text-rose-600">ENGINEERING &</span>
                        </span>
                        <span class="block text-[10px] font-bold tracking-[.17em] text-slate-500 dark:text-slate-300">TECHNICAL INSTITUTE</span>
                    </span>
                    <span class="sm:hidden">
                        <span class="block text-base font-black text-[#03224c] dark:text-white">SOUTH ASIA</span>
                        <span class="block text-[9px] font-bold tracking-[.14em] text-slate-500">TECHNICAL INSTITUTE</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-7 lg:flex" aria-label="Primary navigation">
                    <a href="{{ route('home') }}#home" class="nav-link">Home</a>
                    <a href="{{ route('home') }}#courses" class="nav-link">Course List</a>
                    <a href="{{ route('home') }}#verified-branches" class="nav-link">Verified Branches</a>
                    <a href="{{ route('results.index') }}" class="nav-link">Result Search</a>
                    <a href="{{ route('home') }}#about" class="nav-link">About</a>
                    <a href="{{ route('login') }}" class="nav-link">Login</a>
                    <a href="{{ route('home') }}#contact" class="nav-link">Contact</a>
                </nav>

                <div class="flex shrink-0 items-center gap-2">
                    <button type="button" class="icon-button" data-locale-toggle aria-label="Switch language">
                        <span class="text-xs font-black" data-locale-label>বাংলা</span>
                    </button>
                    <button type="button" class="icon-button" data-theme-toggle aria-label="Toggle theme">
                        <svg data-theme-sun viewBox="0 0 24 24" class="size-5"><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2M12 20v2M2 12h2m16 0h2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg>
                        <svg data-theme-moon viewBox="0 0 24 24" class="hidden size-5"><path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/></svg>
                    </button>
                    <button type="button" class="icon-button lg:hidden" data-menu-toggle aria-expanded="false" aria-controls="branch-mobile-menu" aria-label="Open menu">
                        <svg data-menu-open viewBox="0 0 24 24" aria-hidden="true" class="size-6"><path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                        <svg data-menu-close viewBox="0 0 24 24" aria-hidden="true" class="hidden size-6"><path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                    </button>
                </div>
            </div>

            <div id="branch-mobile-menu" class="border-t border-slate-200 bg-white px-4 py-5 shadow-2xl dark:border-white/10 dark:bg-ink lg:hidden" data-mobile-menu hidden>
                <nav class="mx-auto grid max-w-7xl gap-1" aria-label="Mobile navigation">
                    <a href="{{ route('home') }}#home" class="mobile-nav-link">Home</a>
                    <a href="{{ route('home') }}#courses" class="mobile-nav-link">Course List</a>
                    <a href="{{ route('home') }}#verified-branches" class="mobile-nav-link">Verified Branches</a>
                    <a href="{{ route('results.index') }}" class="mobile-nav-link">Result Search</a>
                    <a href="{{ route('home') }}#about" class="mobile-nav-link">About</a>
                    <a href="{{ route('login') }}" class="mobile-nav-link">Login</a>
                    <a href="{{ route('home') }}#contact" class="mobile-nav-link">Contact</a>
                </nav>
            </div>
        </header>

        <main id="main-content" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <!-- HERO HEADER BANNER -->
            <section class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-[#03224c] via-[#071c2c] to-[#0a3560] px-6 py-8 text-white shadow-2xl sm:px-10 sm:py-12 lg:px-14">
                <div class="absolute -right-20 -top-24 size-72 rounded-full border-[40px] border-amber-300/10"></div>
                <div class="relative grid items-center gap-8 lg:grid-cols-[1fr_auto_1fr]">
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="size-20 rounded-full bg-white p-1 shadow-lg sm:size-28">
                        <div>
                            <p class="text-lg font-black uppercase tracking-wide sm:text-2xl text-white">South Asia Engineering &</p>
                            <p class="text-sm font-bold uppercase tracking-[.12em] text-amber-300 sm:text-base">Technical Institute</p>
                            <p class="mt-2 text-xs text-slate-300">Empowering Youth, Building Future</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="mb-3 text-amber-300">◆</div>
                        <h1 class="text-3xl font-black uppercase tracking-tight sm:text-5xl text-white">Branch Registration</h1>
                        <p class="mt-3 font-medium text-amber-300">Build Your Future With Us</p>
                    </div>
                    <div class="hidden justify-self-end rounded-2xl border border-white/20 bg-white/10 p-5 text-right backdrop-blur sm:block">
                        <p class="text-xs font-bold uppercase tracking-widest text-amber-300">{{ now()->format('d F Y') }}</p>
                        <p class="mt-2 text-lg font-black text-white">{{ now()->format('l') }}</p>
                        <p class="mt-1 text-sm text-slate-200">{{ now()->format('h:i A') }} · Local Time</p>
                    </div>
                </div>
                <div class="relative mt-8 grid gap-3 rounded-2xl border border-white/20 bg-white/10 p-4 text-center backdrop-blur sm:grid-cols-4">
                    @foreach ([['Secure Registration', 'Your information is safe'], ['Verified Partnership', 'Government approved'], ['Approved Branch', 'Trusted learning center'], ['Nationwide Network', '250+ branches across Bangladesh']] as [$title, $body])
                        <div class="border-white/15 px-3 sm:border-r sm:last:border-r-0">
                            <p class="text-xs font-black uppercase tracking-wide text-white">{{ $title }}</p>
                            <p class="mt-1 text-xs text-slate-200">{{ $body }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            @if (session('status'))
                <!-- SUCCESS POPUP MODAL -->
                <div id="branch-success-modal" class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-950/70 p-4 backdrop-blur-sm transition-opacity duration-300">
                    <div class="relative w-full max-w-lg transform overflow-hidden rounded-[2.5rem] border border-slate-200/80 bg-white p-6 text-center shadow-2xl transition-all dark:border-white/10 dark:bg-[#071c2c] sm:p-10">
                        <button type="button" onclick="closeBranchSuccessModal()" class="absolute top-5 right-5 grid size-9 place-items-center rounded-full bg-slate-100 text-slate-400 transition hover:bg-slate-200 hover:text-slate-700 dark:bg-white/10 dark:text-slate-300 dark:hover:bg-white/20">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>

                        <!-- Icon Badge -->
                        <div class="mx-auto flex size-20 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 shadow-xl shadow-indigo-500/20 ring-8 ring-indigo-50 dark:bg-indigo-500/20 dark:text-indigo-400 dark:ring-indigo-500/10">
                            <svg viewBox="0 0 24 24" class="size-10" fill="none" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>

                        <!-- Content -->
                        <h3 class="mt-6 text-2xl font-black tracking-tight text-slate-900 dark:text-white sm:text-3xl">
                            Branch Registration Successful!
                        </h3>
                        <p class="mt-2 text-sm font-bold text-indigo-600 dark:text-indigo-400 sm:text-base">
                            শাখা আবেদন সফলভাবে সম্পন্ন হয়েছে!
                        </p>

                        <div class="mt-4 rounded-2xl bg-indigo-50/80 p-4 text-xs font-semibold text-slate-700 dark:bg-indigo-900/20 dark:text-indigo-200 sm:text-sm">
                            {{ session('status') }}
                        </div>

                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                            Our administration team will verify your information and review your application soon.
                        </p>

                        <!-- OK Button -->
                        <div class="mt-7">
                            <button type="button" onclick="closeBranchSuccessModal()" class="w-full rounded-2xl bg-gradient-to-r from-[#03224c] to-[#0a3560] py-3.5 text-base font-black uppercase tracking-wide text-white shadow-xl transition hover:bg-slate-800">
                                OK, GOT IT!
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function closeBranchSuccessModal() {
                        const modal = document.getElementById('branch-success-modal');
                        if (modal) {
                            modal.classList.add('opacity-0', 'pointer-events-none');
                            setTimeout(() => modal.remove(), 250);
                        }
                    }
                </script>
            @endif

            <div class="mt-7">
                <x-branch-application-form :action="route('branch-applications.store')" />
            </div>
        </main>

        <footer class="mt-8 bg-[#031735] text-white">
            <div class="mx-auto grid max-w-7xl gap-4 px-4 py-7 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
                @foreach ([['Trusted & Verified', 'Government Registered'], ['Quality Technical Education', 'Practical & Skill Based'], ['Nationwide Network', '250+ branches across Bangladesh'], ['Support 24/7', '+880 9696-481628']] as [$title, $body])
                    <div class="flex items-center gap-3 border-white/15 sm:border-r sm:last:border-r-0">
                        <span class="grid size-10 shrink-0 place-items-center rounded-full bg-[#03224c] text-amber-300">✓</span>
                        <span>
                            <strong class="block text-sm">{{ $title }}</strong>
                            <small class="text-slate-300">{{ $body }}</small>
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="border-t border-white/10 px-4 py-4 text-center text-xs text-slate-400">
                © {{ date('Y') }} South Asia Engineering & Technical Institute. All rights reserved.
            </div>
        </footer>
    </body>
</html>

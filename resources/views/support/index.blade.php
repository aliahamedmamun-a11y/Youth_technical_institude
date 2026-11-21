<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#071c2c">
        <meta name="description" content="Support & Student Services Hub - South Asia Engineering & Technical Institute">

        <title>Support & Student Services Hub - {{ config('app.name') }}</title>
        <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/png">

        <script>
            document.documentElement.classList.add('js');
            document.documentElement.classList.toggle(
                'dark',
                localStorage.theme === 'dark'
                    || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
            );
        </script>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="overflow-x-hidden bg-[#f8fafc] text-slate-900 antialiased transition-colors duration-300 dark:bg-ink dark:text-white">
        {{-- Header Navigation --}}
        <header class="fixed inset-x-0 top-0 z-50 border-b border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-ink">
            <div class="mx-auto flex h-16 sm:h-20 max-w-7xl items-center justify-between px-3 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="group flex items-center gap-2 sm:gap-3 min-w-0">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-9 w-auto shrink-0 sm:h-12">
                    <div class="flex flex-col justify-center min-w-0">
                        <span class="block text-sm sm:text-2xl font-black tracking-tight text-[#03224c] dark:text-white uppercase leading-tight shrink-0">
                            South Asia
                        </span>
                        <span class="block text-[9px] sm:text-[11px] font-bold tracking-[0.03em] sm:tracking-[0.1em] text-slate-600 dark:text-slate-300 uppercase leading-none mt-0.5 sm:mt-1 whitespace-nowrap overflow-hidden text-ellipsis">
                            Engineering & Technical Institute
                        </span>
                    </div>
                </a>
                <div class="flex items-center gap-2 sm:gap-4 shrink-0">
                    <a href="{{ route('branch-applications.create') }}" class="rounded-lg bg-[#03224c] px-3 py-1.5 sm:px-5 sm:py-2 text-[10px] sm:text-xs font-black text-white uppercase tracking-wider transition hover:bg-slate-800">
                        Admission 2026
                    </a>
                </div>
            </div>
            <nav class="hidden border-t border-slate-100 bg-[#03224c] lg:block dark:border-white/5">
                <div class="mx-auto flex h-14 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-7">
                        <a href="{{ route('home') }}" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Home</a>
                        <a href="{{ route('home') }}#courses" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Course List</a>
                        <a href="{{ route('public.verified-branches') }}" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Verified Branches</a>
                        <a href="{{ route('results.index') }}" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Result Search</a>
                        <a href="{{ route('home') }}#about" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">About</a>
                        <a href="{{ route('support.index') }}" class="text-xs font-bold text-amber-400 uppercase tracking-widest transition">Support Team</a>
                        <a href="{{ route('home') }}#contact" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Contact</a>
                    </div>
                    <a href="{{ route('login') }}" class="rounded bg-amber-500 px-6 py-1.5 text-xs font-black text-[#03224c] uppercase transition hover:bg-amber-400">
                        Login
                    </a>
                </div>
            </nav>
        </header>

        <main id="main-content" class="pt-24 sm:pt-32 pb-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-10">

                {{-- Top Sub-Header Card (Image 2 & 3 style) --}}
                <div class="rounded-3xl border border-slate-200/80 bg-white p-5 sm:p-6 shadow-sm dark:border-white/10 dark:bg-slate-800 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4 min-w-0">
                        <div class="flex size-14 shrink-0 items-center justify-center rounded-2xl bg-[#03224c] text-amber-400 shadow-md">
                            <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-black text-[#03224c] dark:text-white tracking-tight">
                                Student Services Hub
                            </h1>
                            <p class="text-xs font-bold text-slate-500 dark:text-slate-400">
                                South Asia University Portal & Support Assistance
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-xs font-extrabold text-slate-600 dark:text-slate-300">
                        <a href="#contact-info" class="hover:text-[#03224c] dark:hover:text-amber-400 transition">Contact Info</a>
                        <a href="#categories" class="hover:text-[#03224c] dark:hover:text-amber-400 transition">Support Categories</a>
                        <a href="#faq" class="hover:text-[#03224c] dark:hover:text-amber-400 transition">FAQ</a>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 px-3.5 py-1.5 text-xs font-black text-amber-700 dark:text-amber-400">
                            🛡️ Support Portal
                        </span>
                        <a href="tel:01619142266" class="inline-flex items-center gap-2 rounded-xl bg-[#03224c] hover:bg-slate-800 text-white px-5 py-2 text-xs font-black shadow-md transition">
                            🎧 Open Ticket
                        </a>
                    </div>
                </div>

                {{-- SECTION 1: Contact Information (Image 2) --}}
                <section id="contact-info" class="space-y-6 pt-4">
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-amber-600 dark:text-amber-400 mb-1">
                            COMMUNICATION CHANNELS
                        </p>
                        <h2 class="text-2xl sm:text-3xl font-black text-[#03224c] dark:text-white uppercase tracking-tight">
                            Contact Information
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Card 1: Main Campus Address --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-sky-50 text-[#03224c] dark:bg-sky-500/10 dark:text-sky-400 border border-sky-100 dark:border-sky-500/20">
                                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/>
                                        <circle cx="12" cy="10" r="3"/>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-lg font-black text-[#03224c] dark:text-white">
                                    Main Campus Address
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300">
                                    Kanchan Bridge Crossing (Adj. Purbachal American City), Rupganj, Narayanganj
                                </p>
                            </div>
                            <a href="https://maps.google.com" target="_blank" class="mt-6 inline-flex items-center gap-1 text-xs font-extrabold text-amber-600 dark:text-amber-400 hover:underline">
                                <span>View on Google Maps</span> ↗
                            </a>
                        </div>

                        {{-- Card 2: Hotline & Direct Phone --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-lg font-black text-[#03224c] dark:text-white">
                                    Hotline & Direct Phone
                                </h3>
                                <div class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 space-y-1">
                                    <p><strong class="font-bold text-slate-800 dark:text-white">Mobile:</strong> 01619-142266</p>
                                    <p><strong class="font-bold text-slate-800 dark:text-white">Telephone:</strong> +880 2-55000000</p>
                                </div>
                            </div>
                            <a href="tel:01619142266" class="mt-6 inline-flex items-center gap-1.5 text-xs font-extrabold text-amber-600 dark:text-amber-400 hover:underline">
                                <span>📞 Call Helpline Now</span>
                            </a>
                        </div>

                        {{-- Card 3: Official Email Support --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 border border-indigo-100 dark:border-indigo-500/20">
                                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                        <polyline points="22,6 12,13 2,6"/>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-lg font-black text-[#03224c] dark:text-white">
                                    Official Email Support
                                </h3>
                                <div class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 space-y-1">
                                    <p><strong class="font-bold text-slate-800 dark:text-white">General:</strong> southasian.edu.bd@gmail.com</p>
                                    <p><strong class="font-bold text-slate-800 dark:text-white">Admissions:</strong> admissions@southasian.edu.bd</p>
                                    <p><strong class="font-bold text-slate-800 dark:text-white">IT / Portal:</strong> support@southasian.edu.bd</p>
                                </div>
                            </div>
                            <a href="mailto:support@southasian.edu.bd" class="mt-6 inline-flex items-center gap-1.5 text-xs font-extrabold text-amber-600 dark:text-amber-400 hover:underline">
                                <span>✉️ Send Support Email</span>
                            </a>
                        </div>

                        {{-- Card 4: Website & Live Chat --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-5 flex size-12 items-center justify-center rounded-2xl bg-purple-50 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400 border border-purple-100 dark:border-purple-500/20">
                                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="2" y1="12" x2="22" y2="12"/>
                                        <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-lg font-black text-[#03224c] dark:text-white">
                                    Website & Live Chat
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 mb-2">
                                    Official Portal & Instant Online Assistance Desk
                                </p>
                                <p class="text-xs font-bold text-sky-600 dark:text-sky-400">
                                    www.southasian.edu.bd
                                </p>
                            </div>
                            <a href="tel:01619142266" class="mt-6 inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-100 hover:bg-slate-200 text-[#03224c] dark:bg-slate-700 dark:text-white px-4 py-2.5 text-xs font-black transition">
                                💬 Start Live Chat
                            </a>
                        </div>
                    </div>
                </section>

                {{-- SECTION 2: Support Categories (Image 3) --}}
                <section id="categories" class="space-y-6 pt-8">
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-amber-600 dark:text-amber-400 mb-1">
                            DEPARTMENTS & SERVICES
                        </p>
                        <h2 class="text-2xl sm:text-3xl font-black text-[#03224c] dark:text-white uppercase tracking-tight">
                            Support Categories
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        {{-- Category 1: Admission & Programs --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex size-12 items-center justify-center rounded-2xl bg-amber-100/70 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400">
                                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                            <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                                        </svg>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3.5 py-1 text-xs font-black text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                        Priority Desk
                                    </span>
                                </div>
                                <h3 class="mb-2 text-xl font-black text-[#03224c] dark:text-white">
                                    Admission & Programs
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 sm:text-sm">
                                    Course details, eligibility, tuition fees, scholarship guidance, application status.
                                </p>
                            </div>
                            <div class="mt-8 flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/10">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400">📞 01619-142266</span>
                                <a href="tel:01619142266" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#03224c] dark:bg-slate-700 dark:text-white px-4 py-2 text-xs font-bold transition">
                                    Get Help →
                                </a>
                            </div>
                        </div>

                        {{-- Category 2: Academic & Exam Support --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex size-12 items-center justify-center rounded-2xl bg-emerald-100/70 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                                        </svg>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3.5 py-1 text-xs font-black text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                        Academics
                                    </span>
                                </div>
                                <h3 class="mb-2 text-xl font-black text-[#03224c] dark:text-white">
                                    Academic & Exam Support
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 sm:text-sm">
                                    Class routines, semester schedules, exam notices, result queries, transcript requests.
                                </p>
                            </div>
                            <div class="mt-8 flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/10">
                                <span class="text-xs font-bold text-slate-500">Faculty Desk</span>
                                <a href="mailto:support@southasian.edu.bd" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#03224c] dark:bg-slate-700 dark:text-white px-4 py-2 text-xs font-bold transition">
                                    Get Help →
                                </a>
                            </div>
                        </div>

                        {{-- Category 3: Student Portal & IT Help --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex size-12 items-center justify-center rounded-2xl bg-sky-100/70 text-sky-700 dark:bg-sky-500/20 dark:text-sky-400">
                                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                            <line x1="8" y1="21" x2="16" y2="21"/>
                                            <line x1="12" y1="17" x2="12" y2="21"/>
                                        </svg>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3.5 py-1 text-xs font-black text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                        IT Helpdesk
                                    </span>
                                </div>
                                <h3 class="mb-2 text-xl font-black text-[#03224c] dark:text-white">
                                    Student Portal & IT Help
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 sm:text-sm">
                                    Student ID login issues, LMS access, password reset, online exam link help.
                                </p>
                            </div>
                            <div class="mt-8 flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/10">
                                <span class="text-xs font-bold text-sky-600">🔑 Password Reset</span>
                                <a href="mailto:support@southasian.edu.bd" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#03224c] dark:bg-slate-700 dark:text-white px-4 py-2 text-xs font-bold transition">
                                    Get Help →
                                </a>
                            </div>
                        </div>

                        {{-- Category 4: Accounts & Fee Payment --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex size-12 items-center justify-center rounded-2xl bg-purple-100/70 text-purple-700 dark:bg-purple-500/20 dark:text-purple-400">
                                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                            <line x1="1" y1="10" x2="23" y2="10"/>
                                        </svg>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3.5 py-1 text-xs font-black text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                        Accounts
                                    </span>
                                </div>
                                <h3 class="mb-2 text-xl font-black text-[#03224c] dark:text-white">
                                    Accounts & Fee Payment
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 sm:text-sm">
                                    Tuition fee submissions, payment gateway issues, invoice receipts.
                                </p>
                            </div>
                            <div class="mt-8 flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/10">
                                <span class="text-xs font-bold text-slate-500">Finance Office</span>
                                <a href="tel:01619142266" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#03224c] dark:bg-slate-700 dark:text-white px-4 py-2 text-xs font-bold transition">
                                    Get Help →
                                </a>
                            </div>
                        </div>

                        {{-- Category 5: Campus Services & Transport --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex size-12 items-center justify-center rounded-2xl bg-orange-100/70 text-orange-700 dark:bg-orange-500/20 dark:text-orange-400">
                                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="6" width="18" height="11" rx="2"/>
                                            <circle cx="7" cy="17" r="2"/>
                                            <circle cx="17" cy="17" r="2"/>
                                        </svg>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3.5 py-1 text-xs font-black text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                        Campus & Travel
                                    </span>
                                </div>
                                <h3 class="mb-2 text-xl font-black text-[#03224c] dark:text-white">
                                    Campus Services & Transport
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 sm:text-sm">
                                    Campus visit scheduling, hostel assistance, transport routes and timing.
                                </p>
                            </div>
                            <div class="mt-8 flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/10">
                                <span class="text-xs font-bold text-amber-600">⏰ Timings Available</span>
                                <a href="tel:01619142266" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#03224c] dark:bg-slate-700 dark:text-white px-4 py-2 text-xs font-bold transition">
                                    Get Help →
                                </a>
                            </div>
                        </div>

                        {{-- Category 6: General Support Desk --}}
                        <div class="group rounded-3xl border border-slate-200/80 bg-white p-7 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800 flex flex-col justify-between">
                            <div>
                                <div class="mb-6 flex items-center justify-between">
                                    <div class="flex size-12 items-center justify-center rounded-2xl bg-indigo-100/70 text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-400">
                                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                        </svg>
                                    </div>
                                    <span class="rounded-full bg-slate-100 px-3.5 py-1 text-xs font-black text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                        24/7 Helpline
                                    </span>
                                </div>
                                <h3 class="mb-2 text-xl font-black text-[#03224c] dark:text-white">
                                    General Inquiry & Support
                                </h3>
                                <p class="text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 sm:text-sm">
                                    Institutional queries, branch application support, verification help, and official assistance.
                                </p>
                            </div>
                            <div class="mt-8 flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/10">
                                <span class="text-xs font-bold text-slate-500">Support Team</span>
                                <a href="mailto:southasian.edu.bd@gmail.com" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-[#03224c] dark:bg-slate-700 dark:text-white px-4 py-2 text-xs font-bold transition">
                                    Get Help →
                                </a>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- SECTION 3: FAQ --}}
                <section id="faq" class="space-y-6 pt-8">
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-amber-600 dark:text-amber-400 mb-1">
                            FREQUENTLY ASKED QUESTIONS
                        </p>
                        <h2 class="text-2xl sm:text-3xl font-black text-[#03224c] dark:text-white uppercase tracking-tight">
                            Help & FAQ Desk
                        </h2>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-800 space-y-2">
                            <h3 class="text-base font-black text-[#03224c] dark:text-white">
                                Q: How can I apply for admission online?
                            </h3>
                            <p class="text-xs sm:text-sm font-medium leading-relaxed text-slate-600 dark:text-slate-300">
                                You can apply online through our official website portal under the Admission tab or visit our main campus office in person.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-800 space-y-2">
                            <h3 class="text-base font-black text-[#03224c] dark:text-white">
                                Q: Whom should I contact if I lose my Student Portal password?
                            </h3>
                            <p class="text-xs sm:text-sm font-medium leading-relaxed text-slate-600 dark:text-slate-300">
                                Send an email to <a href="mailto:support@southasian.edu.bd" class="text-sky-600 underline dark:text-sky-400">support@southasian.edu.bd</a> with your Student ID and Registered Mobile Number for a password reset link.
                            </p>
                        </div>

                        <div class="rounded-3xl border border-slate-200/80 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-slate-800 space-y-2">
                            <h3 class="text-base font-black text-[#03224c] dark:text-white">
                                Q: What are the office hours for campus visits?
                            </h3>
                            <p class="text-xs sm:text-sm font-medium leading-relaxed text-slate-600 dark:text-slate-300">
                                Our administrative offices and counseling desks are open from Saturday to Thursday, 9:00 AM to 6:00 PM.
                            </p>
                        </div>
                    </div>
                </section>

            </div>
        </main>

        <footer class="border-t border-slate-200 bg-white py-8 text-center text-xs font-bold text-slate-500 dark:border-white/10 dark:bg-ink dark:text-slate-400">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.</p>
        </footer>
    </body>
</html>

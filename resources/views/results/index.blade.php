<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#15803d">
        <meta name="description" content="Find and verify your official Bangladesh National Youth Technical Institute examination result.">
        <title>Student Result Portal | BNYTI</title>
        <link rel="icon" href="{{ asset('images/bnyti-logo.svg') }}" type="image/svg+xml">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen overflow-x-hidden bg-stone-50 text-slate-900 antialiased dark:bg-ink dark:text-white">
        <header class="border-b border-slate-900/5 bg-stone-50/95 backdrop-blur-xl dark:border-white/10 dark:bg-ink/95">
            <div class="mx-auto flex h-[76px] max-w-7xl items-center justify-between gap-5 px-4 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" class="group flex min-w-0 items-center gap-3" aria-label="BNYTI home">
                    <img src="{{ asset('images/bnyti-logo.svg') }}" alt="Bangladesh National Youth Technical Institute logo" class="brand-logo size-12 shrink-0 transition duration-300 group-hover:-rotate-3 sm:size-14">
                    <span class="hidden min-w-0 sm:block"><span class="block truncate text-sm font-black tracking-tight text-slate-950 dark:text-white sm:text-[15px]"><span class="text-emerald-600 dark:text-emerald-400">BANGLADESH</span><span class="text-red-600 dark:text-red-400"> NATIONAL</span></span><span class="block truncate text-[10px] font-bold tracking-[0.17em] text-slate-600 dark:text-slate-300 sm:text-[11px]">YOUTH TECHNICAL INSTITUTE</span></span>
                    <span class="sm:hidden"><span class="block text-base font-black tracking-tight text-slate-950 dark:text-white">BNYTI</span><span class="block text-[9px] font-bold tracking-[0.14em] text-slate-500 dark:text-slate-300">TECHNICAL INSTITUTE</span></span>
                </a>
                <nav class="hidden items-center gap-7 lg:flex" aria-label="Primary navigation">
                    <a href="{{ route('home') }}#home" class="nav-link">Home</a>
                    <a href="{{ route('home') }}#courses" class="nav-link">Courses</a>
                    <a href="{{ route('home') }}#about" class="nav-link">About</a>
                    <a href="{{ route('home') }}#branch-application-promo" class="nav-link">Branches</a>
                    <a href="{{ route('branch-applications.create') }}" class="nav-link">Branch Register</a>
                    <a href="{{ route('student-registrations.create') }}" class="nav-link">Student Register</a>
                    <a href="{{ route('results.index') }}" class="nav-link active" aria-current="page">Student Results</a>
                </nav>
                <div class="flex shrink-0 items-center gap-2">
                    <button type="button" class="icon-button" data-locale-toggle aria-label="Switch language"><span class="text-xs font-black" data-locale-label>বাংলা</span></button>
                    <button type="button" class="icon-button" data-theme-toggle aria-label="Toggle color theme"><svg data-theme-sun viewBox="0 0 24 24" aria-hidden="true" class="size-5"><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg><svg data-theme-moon viewBox="0 0 24 24" aria-hidden="true" class="hidden size-5"><path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/></svg></button>
                    <button type="button" class="icon-button lg:hidden" data-menu-toggle aria-expanded="false" aria-controls="results-mobile-menu" aria-label="Open menu"><svg data-menu-open viewBox="0 0 24 24" aria-hidden="true" class="size-6"><path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg><svg data-menu-close viewBox="0 0 24 24" aria-hidden="true" class="hidden size-6"><path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg></button>
                </div>
            </div>
            <div id="results-mobile-menu" class="border-t border-slate-900/5 bg-stone-50 px-4 py-5 shadow-2xl dark:border-white/10 dark:bg-ink lg:hidden" data-mobile-menu hidden>
                <nav class="mx-auto grid max-w-7xl gap-1" aria-label="Mobile navigation">
                    <a href="{{ route('home') }}#home" class="mobile-nav-link">Home</a><a href="{{ route('home') }}#courses" class="mobile-nav-link">Courses</a><a href="{{ route('home') }}#about" class="mobile-nav-link">About</a><a href="{{ route('home') }}#branch-application-promo" class="mobile-nav-link">Branches</a><a href="{{ route('branch-applications.create') }}" class="mobile-nav-link">Branch Register</a><a href="{{ route('student-registrations.create') }}" class="mobile-nav-link">Student Register</a><a href="{{ route('results.index') }}" class="mobile-nav-link bg-emerald-500/10 text-emerald-700 dark:text-emerald-300" aria-current="page">Student Results</a>
                </nav>
            </div>
        </header>
        <main class="mx-auto flex min-h-screen w-full max-w-6xl flex-col px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
            <header class="text-center">
                <a href="{{ route('home') }}" class="group inline-flex flex-col items-center" aria-label="Back to BNYTI home">
                    <img src="{{ asset('images/bnyti-logo.svg') }}" alt="Bangladesh National Youth Technical Institute logo" class="brand-logo size-28 transition duration-300 group-hover:-rotate-3 sm:size-36">
                    <span class="mt-5 text-xl font-black tracking-tight text-emerald-700 dark:text-emerald-400 sm:text-3xl">Bangladesh National Youth Technical Institute</span>
                    <span class="mt-2 flex items-center gap-3 text-sm font-medium text-slate-600 dark:text-slate-300 sm:text-base"><span class="hidden h-px w-12 bg-emerald-600 sm:block"></span>Skill for Today, Success for Tomorrow<span class="hidden h-px w-12 bg-emerald-600 sm:block"></span></span>
                </a>
            </header>

            <section class="mt-10 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-[0_20px_70px_rgb(15_23_42/0.09)] dark:border-white/10 dark:bg-white/5 sm:mt-14 sm:p-10 lg:p-14">
                <div class="mx-auto max-w-3xl text-center">
                    <div class="mx-auto grid size-20 place-items-center rounded-full border-8 border-white bg-emerald-50 text-emerald-700 shadow-[0_8px_30px_rgb(15_23_42/0.12)] dark:border-ink dark:bg-emerald-400/10 dark:text-emerald-400 sm:size-24">
                        <svg viewBox="0 0 48 48" class="size-11 fill-none stroke-current sm:size-14" aria-hidden="true" stroke-width="2"><path d="M12 5h19l7 7v28H12z"/><path d="M31 5v8h7M17 19h16M17 25h10"/><circle cx="31" cy="32" r="6" fill="currentColor" stroke="white" stroke-width="1.5"/><path d="m29 32 1.5 1.5L34 30" stroke="white" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h1 class="mt-8 text-3xl font-black tracking-tight text-slate-950 dark:text-white sm:text-5xl">STUDENT <span class="text-emerald-700 dark:text-emerald-400">RESULT</span> PORTAL</h1>
                    <div class="mx-auto mt-5 flex items-center justify-center gap-2 text-emerald-600"><span class="h-px w-16 bg-emerald-200"></span><span class="size-2 rounded-full bg-emerald-600"></span><span class="size-3 rounded-full bg-emerald-600"></span><span class="size-2 rounded-full bg-emerald-600"></span><span class="h-px w-16 bg-emerald-200"></span></div>
                    <p class="mt-6 text-base font-medium text-slate-600 dark:text-slate-300 sm:text-lg">Enter your Roll Number to view your official examination result</p>

                    @if ($searched)
                        <div role="alert" class="mt-7 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm font-bold text-rose-700 dark:border-rose-400/20 dark:bg-rose-400/10 dark:text-rose-200">No published result was found for this Roll Number. Please check the number and try again.</div>
                    @endif

                    <form method="GET" action="{{ route('results.index') }}" class="mx-auto mt-8 max-w-2xl text-left">
                        <label for="roll-number" class="sr-only">Roll Number</label>
                        <div class="flex overflow-hidden rounded-2xl border border-slate-300 bg-white shadow-sm transition focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-500/15 dark:border-white/15 dark:bg-white/10">
                            <span class="grid w-20 shrink-0 place-items-center bg-emerald-600 text-white sm:w-24"><svg viewBox="0 0 24 24" class="size-8 fill-none stroke-current" aria-hidden="true" stroke-width="1.8"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 21c.7-4.2 3.2-6.5 7.5-6.5s6.8 2.3 7.5 6.5"/></svg></span>
                            <input id="roll-number" name="roll_number" value="{{ old('roll_number', $rollNumber ?? '') }}" inputmode="numeric" autocomplete="off" required maxlength="50" placeholder="Enter Your Roll Number" class="min-w-0 flex-1 bg-transparent px-5 py-4 text-lg font-medium text-slate-900 outline-none placeholder:text-slate-400 dark:text-white sm:px-7 sm:text-xl">
                        </div>
                        <button type="submit" class="mt-5 inline-flex min-h-16 w-full items-center justify-center gap-4 rounded-2xl bg-gradient-to-r from-green-600 to-emerald-700 px-6 text-lg font-black text-white shadow-lg shadow-emerald-700/25 transition hover:-translate-y-0.5 hover:from-green-500 hover:to-emerald-600 focus-visible:outline-emerald-500 sm:text-xl"><svg viewBox="0 0 24 24" class="size-8 fill-none stroke-current" aria-hidden="true" stroke-width="2"><circle cx="10.8" cy="10.8" r="6.8"/><path d="m16 16 5 5" stroke-linecap="round"/></svg>VIEW RESULT</button>
                        <p class="mt-5 flex items-center justify-center gap-2 text-sm font-semibold text-emerald-800 dark:text-emerald-300"><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" aria-hidden="true" stroke-width="1.8"><path d="M12 3 20 6v5c0 5-3.4 8.4-8 10-4.6-1.6-8-5-8-10V6z"/><path d="m8.5 12 2.3 2.3 4.8-5" stroke-linecap="round" stroke-linejoin="round"/></svg>Please enter a valid Roll Number to view your official result.</p>
                    </form>
                </div>
            </section>

            <section class="mt-7 grid overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-[0_16px_55px_rgb(15_23_42/0.06)] dark:border-white/10 dark:bg-white/5 sm:grid-cols-2 lg:grid-cols-4" aria-label="Result portal benefits">
                @foreach ([['bolt', 'FAST & EASY', 'Get your result in just a second'], ['shield', '100% OFFICIAL', 'Authentic & official examination result'], ['lock', 'SECURE & SAFE', 'Your data is protected and fully secure'], ['award', 'TRUSTED INSTITUTE', 'Govt. Registered Technical Institute']] as [$icon, $title, $body])
                    <article class="flex items-center gap-4 border-b border-slate-200 px-5 py-6 last:border-b-0 dark:border-white/10 sm:px-7 lg:block lg:border-b-0 lg:border-r lg:last:border-r-0 lg:text-center">
                        <span class="grid size-14 shrink-0 place-items-center rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-400">@if ($icon === 'bolt')<svg viewBox="0 0 24 24" class="size-7 fill-current" aria-hidden="true"><path d="m13.2 2-8 11h5.7L10 22l8.8-12h-5.6z"/></svg>@elseif ($icon === 'shield')<svg viewBox="0 0 24 24" class="size-7 fill-none stroke-current" aria-hidden="true" stroke-width="2"><path d="M12 3 20 6v5c0 5-3.4 8.4-8 10-4.6-1.6-8-5-8-10V6z"/><path d="m8.5 12 2.3 2.3 4.8-5" stroke-linecap="round" stroke-linejoin="round"/></svg>@elseif ($icon === 'lock')<svg viewBox="0 0 24 24" class="size-7 fill-none stroke-current" aria-hidden="true" stroke-width="2"><rect x="5" y="10" width="14" height="11" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>@else<svg viewBox="0 0 24 24" class="size-7 fill-none stroke-current" aria-hidden="true" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="m9 12-2 9 5-3 5 3-2-9"/></svg>@endif</span>
                        <div class="lg:mt-4"><h2 class="text-sm font-black text-emerald-800 dark:text-emerald-300">{{ $title }}</h2><p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $body }}</p></div>
                    </article>
                @endforeach
            </section>

            <aside class="mt-7 flex flex-col items-center gap-5 rounded-2xl border border-emerald-200 bg-white px-6 py-5 shadow-sm dark:border-emerald-400/20 dark:bg-white/5 sm:flex-row"><span class="grid size-14 shrink-0 place-items-center rounded-xl bg-emerald-600 text-white"><svg viewBox="0 0 24 24" class="size-7 fill-none stroke-current" aria-hidden="true" stroke-width="1.8"><path d="M12 3 20 6v5c0 5-3.4 8.4-8 10-4.6-1.6-8-5-8-10V6z"/><path d="m8.5 12 2.3 2.3 4.8-5" stroke-linecap="round" stroke-linejoin="round"/></svg></span><div class="flex-1 text-center sm:text-left"><h2 class="font-black text-emerald-800 dark:text-emerald-300">IMPORTANT</h2><p class="mt-1 text-sm font-medium text-slate-600 dark:text-slate-300">Make sure you enter the correct Roll Number to get your accurate result.</p></div><span class="hidden text-5xl text-emerald-600/30 sm:block" aria-hidden="true">✦</span></aside>

            <footer class="mt-auto pt-12 text-center"><a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-sm font-black text-slate-800 transition hover:text-emerald-700 dark:text-white dark:hover:text-emerald-400"><span class="h-px w-16 bg-emerald-500"></span><img src="{{ asset('images/bnyti-logo.svg') }}" alt="" class="size-10"><span class="h-px w-16 bg-emerald-500"></span></a><p class="mt-5 text-sm font-medium text-slate-600 dark:text-slate-300">© {{ date('Y') }} Bangladesh National Youth Technical Institute. All Rights Reserved.</p><p class="mt-3 text-emerald-600" aria-hidden="true">★ ★ ★</p></footer>
        </main>
    </body>
</html>

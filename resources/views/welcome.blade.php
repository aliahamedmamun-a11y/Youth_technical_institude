<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#071c2c">
        <meta
            name="description"
            content="Bangladesh National Youth Technical Institute provides practical, industry-focused technical education for a skilled future."
        >

        <title>Bangladesh National Youth Technical Institute</title>
        <link rel="icon" href="{{ asset('images/bnyti-logo.svg') }}" type="image/svg+xml">

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
    <body class="overflow-x-hidden bg-stone-50 text-slate-900 antialiased transition-colors duration-300 dark:bg-ink dark:text-white">
        <a
            href="#main-content"
            class="fixed top-3 left-3 z-[100] -translate-y-20 rounded-full bg-emerald-500 px-5 py-3 text-sm font-bold text-ink transition focus:translate-y-0"
            data-i18n="skip"
        >
            Skip to content
        </a>

        <header class="fixed inset-x-0 top-0 z-50 border-b border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-ink">
             <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                <a href="#home" class="group flex items-center gap-3">
                    <img
                        src="{{ asset('images/bnyti-logo.svg') }}"
                        alt="Logo"
                        class="h-10 w-auto sm:h-12"
                    >
                    <div class="hidden sm:block">
                        <span class="block text-2xl font-black tracking-tight text-[#03224c] dark:text-white uppercase leading-none">South Asia</span>
                        <span class="block text-[10px] font-bold tracking-[0.1em] text-slate-500 uppercase dark:text-slate-400 mt-1">National Technical Institute</span>
                    </div>
                    <div class="sm:hidden">
                        <span class="block text-xl font-black tracking-tighter text-[#03224c] dark:text-white">SOUTH ASIA</span>
                    </div>
                </a>
                <div class="flex items-center gap-4">
                    <a href="{{ route('branch-applications.create') }}" class="rounded-lg bg-[#03224c] px-5 py-2 text-xs font-black text-white uppercase tracking-widest transition hover:bg-slate-800 sm:text-sm">
                        Admission 2026
                    </a>
                    <button
                        type="button"
                        class="icon-button lg:hidden"
                        data-menu-toggle
                        aria-expanded="false"
                        aria-controls="mobile-menu"
                        aria-label="Open menu"
                    >
                        <svg data-menu-open viewBox="0 0 24 24" aria-hidden="true" class="size-6">
                            <path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/>
                        </svg>
                        <svg data-menu-close viewBox="0 0 24 24" aria-hidden="true" class="hidden size-6">
                            <path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/>
                        </svg>
                    </button>
                </div>
            </div>
            <nav class="hidden border-t border-slate-100 bg-[#03224c] lg:block dark:border-white/5">
                <div class="mx-auto flex h-14 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-8">
                        <a href="#home" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Home</a>
                        <a href="#courses" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Courses</a>
                        <a href="#about" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">About</a>
                        <a href="#branch-application-promo" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Branches</a>
                        <a href="{{ route('results.index') }}" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Results</a>
                        <a href="#latest-news-contact" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Contact</a>
                    </div>
                    <a href="{{ route('login') }}" class="rounded bg-amber-500 px-6 py-1.5 text-xs font-black text-[#03224c] uppercase transition hover:bg-amber-400">
                        Student Login
                    </a>
                </div>
            </nav>
        </header>

        <div class="mobile-menu-overlay lg:hidden" data-menu-overlay aria-hidden="true"></div>
        <aside id="mobile-menu" class="mobile-menu-drawer lg:hidden" data-mobile-menu aria-hidden="true" aria-label="Mobile navigation" inert>
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-white/10">
                    <a href="#home" class="flex min-w-0 items-center gap-3" aria-label="BNYTI home">
                        <img src="{{ asset('images/bnyti-logo.svg') }}" alt="" class="size-11 shrink-0 object-contain">
                        <span><span class="block font-black text-slate-950 dark:text-white">BNYTI</span><span class="block text-[9px] font-bold tracking-[.14em] text-slate-500 dark:text-slate-300">TECHNICAL INSTITUTE</span></span>
                    </a>
                    <button type="button" class="icon-button" data-menu-dismiss aria-label="Close navigation"><svg viewBox="0 0 24 24" aria-hidden="true" class="size-6"><path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg></button>
                </div>

                <div class="mobile-menu-content">
                    <nav aria-label="Mobile primary navigation">
                        <p class="mobile-menu-label">Explore</p>
                        <div class="space-y-1">
                            <a href="#home" class="mobile-nav-link active" data-mobile-nav-link><span class="mobile-nav-icon">H</span><span data-i18n="navHome">Home</span></a>
                            <a href="#courses" class="mobile-nav-link" data-mobile-nav-link><span class="mobile-nav-icon">C</span><span data-i18n="navCourses">Courses</span></a>
                            <a href="#about" class="mobile-nav-link" data-mobile-nav-link><span class="mobile-nav-icon">A</span><span data-i18n="navAbout">About</span></a>
                            <a href="#branch-application-promo" class="mobile-nav-link" data-mobile-nav-link><span class="mobile-nav-icon">B</span><span data-i18n="navBranches">Branches</span></a>
                        </div>

                        <p class="mobile-menu-label mt-6">Services & account</p>
                        <div class="space-y-1">
                            <a href="{{ route('results.index') }}" class="mobile-nav-link"><span class="mobile-nav-icon">R</span>Results</a>
                            <a href="{{ route('login') }}" class="mobile-nav-link"><span class="mobile-nav-icon">S</span>Staff Login</a>
                            <a href="#latest-news-contact" class="mobile-nav-link" data-mobile-nav-link><span class="mobile-nav-icon">C</span><span data-i18n="navContact">Contact</span></a>
                        </div>
                    </nav>

                    <div class="mt-6 border-t border-slate-200 pt-5 dark:border-white/10">
                        <p class="mobile-menu-label mb-3">Preferences</p>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" class="mobile-preference-button" data-locale-toggle aria-label="Switch language"><span data-locale-label>বাংলা</span><span>Language</span></button>
                            <button type="button" class="mobile-preference-button" data-theme-toggle aria-label="Toggle color theme"><svg data-theme-sun viewBox="0 0 24 24" aria-hidden="true" class="size-5"><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2M12 20v2M2 12h2m16 0h2" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg><svg data-theme-moon viewBox="0 0 24 24" aria-hidden="true" class="hidden size-5"><path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/></svg><span>Theme</span></button>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-200 bg-slate-50 p-5 dark:border-white/10 dark:bg-white/5">
                    <a href="{{ route('branch-applications.create') }}" class="mobile-menu-cta">Apply for a Branch <span aria-hidden="true">→</span></a>
                </div>
        </aside>

        <main id="main-content" class="public-page-main">
            @php
                $heroItems = $homepageItems('hero');
                $heroLead = $heroItems->first();
            @endphp
            <section id="home" class="hero-slide relative min-h-[620px] overflow-hidden bg-ink pt-[120px] text-white sm:min-h-[600px] lg:min-h-[650px] lg:pt-[120px]" data-hero-carousel>
                @foreach ($heroItems as $hero)
                    <img
                        src="{{ str_starts_with($hero->image_path, 'images/') ? asset($hero->image_path) : Storage::disk('public')->url($hero->image_path) }}"
                        alt="{{ $hero->title }}"
                        class="hero-carousel-image absolute inset-0 size-full object-cover object-center opacity-0"
                        data-hero-image
                        @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif
                    >
                @endforeach
                <div class="hero-mobile-overlay absolute inset-0 bg-[#03224c]/40"></div>
                <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(3,34,76,.6)_0%,rgba(3,34,76,.2)_50%,transparent_100%)]"></div>
                <div class="absolute inset-x-0 bottom-0 h-1 bg-amber-500"></div>

                <div class="hero-content-frame relative mx-auto flex min-h-[552px] max-w-7xl items-center px-4 pt-8 pb-24 sm:min-h-[492px] sm:px-6 sm:py-12 lg:min-h-[504px] lg:px-8">
                    <div class="hero-content reveal is-visible flex w-full max-w-[720px] flex-col items-start gap-6 sm:gap-8">
                        <h1 class="text-3xl font-black leading-[1.1] text-white uppercase sm:text-5xl lg:text-6xl">
                            {{ $heroLead?->title ?? 'Empowering South Asia\'s Tech Leaders. Building a Secure Future.' }}
                        </h1>

                        <div class="hero-actions mt-4 flex w-full flex-wrap items-center gap-4 sm:w-auto">
                            <a href="{{ $heroLead?->link_url ?? '#courses' }}" class="rounded-md bg-amber-500 px-10 py-4 text-sm font-black text-[#03224c] uppercase tracking-wider shadow-2xl transition hover:bg-amber-400">
                                <span>{{ $heroLead?->link_label ?? 'Join Course' }}</span>
                            </a>
                            <a href="#courses" class="rounded-md border-2 border-white px-10 py-4 text-sm font-black text-white uppercase tracking-wider transition hover:bg-white hover:text-[#03224c]">
                                <span>Programs</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="absolute right-4 bottom-8 hidden rounded-full border border-white/15 bg-emerald-500/70 px-4 py-3 text-sm font-black text-white shadow-2xl backdrop-blur-md sm:block lg:right-10 lg:bottom-14" aria-live="polite">
                    <span data-hero-current>1</span> / {{ $heroItems->count() }}
                </div>
                <div class="absolute bottom-7 left-1/2 flex -translate-x-1/2 items-center gap-3 sm:bottom-10" aria-hidden="true">
                    @foreach ($heroItems as $hero)
                        <span class="hero-carousel-dot {{ $loop->first ? 'is-active' : '' }}"></span>
                    @endforeach
                </div>
            </section>

            <section id="notice-bar" class="border-b border-emerald-900/10 bg-white dark:border-white/10 dark:bg-deep" aria-label="Institute notices">
                <div class="flex min-h-12 items-stretch overflow-hidden">
                    <div class="notice-label relative flex shrink-0 items-center gap-2 bg-emerald-700 py-3 pr-7 pl-4 text-[11px] font-black tracking-[0.2em] text-white sm:pl-8" aria-hidden="true">
                        <span class="size-2 rounded-full bg-white"></span>
                        <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-amber-300 opacity-75 motion-reduce:animate-none"></span><span class="relative inline-flex size-2 rounded-full bg-amber-300"></span></span>
                        <span>NOTICE</span>
                    </div>
                    <div class="min-w-0 flex-1 overflow-hidden py-3" aria-live="polite">
                        <div class="notice-track flex gap-12 whitespace-nowrap px-8 text-xs font-bold text-slate-700 motion-reduce:transform-none dark:text-slate-200">
                            @forelse ($noticeItems as $notice)
                                <a href="{{ $notice['link'] ?: '#notice-bar' }}" class="transition hover:text-emerald-700 dark:hover:text-emerald-400">{{ $notice['title'] }} <span class="mx-2 text-emerald-500" aria-hidden="true">•</span> {{ $notice['message'] }}</a>
                            @empty
                                <span>Admission for the July 2026 session is now open <span class="mx-2 text-emerald-500" aria-hidden="true">•</span> Branch applications are being accepted nationwide <span class="mx-2 text-emerald-500" aria-hidden="true">•</span> Contact us for course counselling</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            @if ($isSectionVisible('trust'))
            <section class="relative z-20 mt-6 px-3 pb-6 sm:mt-8 sm:px-5 lg:px-8" aria-label="Why choose BNYTI">
                <div class="mx-auto grid max-w-[1460px] grid-cols-2 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_4px_15px_rgba(15,23,42,.12)] dark:border-white/10 dark:bg-deep sm:grid-cols-3 lg:grid-cols-6">
                    @foreach ($homepageItems('trust') as $item)
                        @php
                            $title = $item->title;
                            $description = $item->body;
                            $icon = match ($item->icon) {
                            'shield' => 'M12 2.5v4m0 11v4m9.5-9.5h-4m-11 0h-4m16.2-6.2-2.8 2.8m-7.8 7.8-2.8 2.8m13.4 0-2.8-2.8M8.1 6.6 5.3 3.8M16.5 10a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm-6.4 9.5h3.8',
                            'lab' => 'M9.5 3h5v5.2l4.9 8.5A2.9 2.9 0 0 1 16.9 21H7.1a2.9 2.9 0 0 1-2.5-4.3l4.9-8.5V3Zm-2 11h9M8 17h8m-4-14v5',
                            'users' => 'M9.5 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm5.5 1a2.5 2.5 0 1 0 0-5m-11 12a5.5 5.5 0 0 1 11 0v2H4v-2Zm11-4a4.5 4.5 0 0 1 5 4v2h-3',
                            'handshake' => 'M8.5 13.5 12 17l3.5-3.5m-9-4 3-3a2 2 0 0 1 2.8 0l.7.7.7-.7a2 2 0 0 1 2.8 0l3 3-7 7a2 2 0 0 1-2.8 0l-7-7 3-3m1 3 2 2m7-2 2 2',
                            'verification' => 'M7 2.5h7l4 4V21H7a2 2 0 0 1-2-2V4.5a2 2 0 0 1 2-2Zm7 0v4h4M8.5 12l2 2 4-4m-6 7h6',
                            default => 'M4 7.5 12 3l8 4.5-8 4.5-8-4.5Zm3 2.2V15c3 2.3 7 2.3 10 0V9.7M20 8v6m-1 2h2',
                            };
                        @endphp
                        <article class="group flex min-h-[108px] flex-col items-center justify-center gap-1.5 border-r border-b border-slate-100 px-2.5 py-3 text-center transition-colors hover:bg-emerald-50/50 even:border-r-0 dark:border-white/10 dark:hover:bg-emerald-400/5 sm:min-h-[116px] sm:border-r sm:[&:nth-child(3n)]:border-r-0 lg:min-h-[104px] lg:border-b-0 lg:border-r lg:[&:nth-child(3n)]:border-r lg:last:border-r-0 {{ $item->stable_key === 'practical-lab' ? 'bg-[#f0fcf9] dark:bg-emerald-400/5' : '' }}">
                            <span class="grid h-8 place-items-center text-[#159b63] transition-transform duration-200 group-hover:-translate-y-0.5 dark:text-emerald-400">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="size-7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.55">
                                    <path d="{{ $icon }}" />
                                </svg>
                            </span>
                            <div class="grid gap-0.5">
                                <h2 class="text-[10px] leading-4 font-extrabold text-slate-800 dark:text-white">{{ $title }}</h2>
                                <p class="mx-auto max-w-[150px] text-[8px] leading-[1.35] font-medium text-slate-500 sm:text-[8.5px] dark:text-slate-300">{{ $description }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
            @endif

            @if ($isSectionVisible('about'))
            <section id="about" class="bg-[#e7f3f9] py-16 dark:bg-deep sm:py-20 lg:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="reveal mb-12 text-center text-3xl font-black uppercase tracking-tight text-[#03224c] dark:text-white sm:text-4xl">
                        ABOUT SOUTH ASIA NATIONAL TECHNICAL INSTITUTE
                    </h2>

                    @php $about = $aboutEntries->first(); @endphp
                    <div class="grid items-center gap-10 lg:grid-cols-[1.1fr_1fr]">
                        <div class="reveal overflow-hidden rounded-2xl shadow-xl">
                            <img
                                src="{{ $about?->image_path ? (str_starts_with($about->image_path, 'images/') ? asset($about->image_path) : Storage::disk('public')->url($about->image_path)) : asset('images/bnyti-hero-premium-2.png') }}"
                                alt="Institute Building"
                                class="w-full object-cover aspect-[4/3] lg:aspect-auto"
                                loading="lazy"
                            >
                        </div>

                        <div class="reveal" style="--reveal-delay: 150ms">
                            <div class="min-w-0">
                                <p class="text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                    {{ $about?->content ?? "Bangladesh National Youth Technical Institute (BNYTI) is a renowned technical and skills development institution in Bangladesh, committed to empowering the nation's youth with industry-relevant knowledge, practical expertise, and modern technological skills." }}
                                </p>

                                <div class="mt-8">
                                    <h3 class="text-xl font-black text-[#03224c] dark:text-white">MFU Team or SO?</h3>

                                    <div class="mt-5 flex flex-col gap-8 sm:flex-row sm:items-start">
                                        <ul class="flex-1 space-y-3">
                                            @foreach([
                                                'MF Student for Features',
                                                'M& Commercial Institutes',
                                                'MP Coeistment Assistont',
                                                'WFIS and & Accobers Program'
                                            ] as $item)
                                                <li class="flex items-center gap-3 text-slate-800 dark:text-slate-200">
                                                    <span class="size-2.5 shrink-0 rounded-full bg-[#3e5b6d] dark:bg-emerald-500"></span>
                                                    <span class="text-sm font-bold">{{ $item }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="shrink-0 w-full rounded-xl border-2 border-[#3e5b6d]/30 bg-white/40 p-5 text-center sm:w-52 dark:border-white/10 dark:bg-white/5">
                                            <h4 class="border-b-2 border-[#3e5b6d]/30 pb-2 text-lg font-black text-[#3e5b6d] dark:text-emerald-400 uppercase tracking-tighter">
                                                On-line Value
                                            </h4>
                                            <p class="mt-4 text-[10px] font-bold leading-tight text-slate-600 dark:text-slate-400">
                                                Dernorats pase nist aodaized<br>
                                                ourl of dultaaan tremp ava<br>
                                                tradition huxbet
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            @endif


            @if ($isSectionVisible('statistics'))
            <section class="bg-[#03224c] py-20 dark:bg-deep" aria-label="BNYTI achievements">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-16 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-[0.25em] text-white sm:text-4xl">Training Input</h2>
                    </div>

                    <div class="grid grid-cols-2 justify-center gap-y-12 gap-x-8 md:grid-cols-4 lg:gap-16">
                        @foreach ($homepageItems('statistics')->take(4) as $item)
                            @php
                                $borderColors = ['border-sky-400', 'border-amber-400', 'border-sky-400', 'border-amber-400'];
                                $borderColor = $borderColors[$loop->index % 4];
                            @endphp
                            <div class="flex flex-col items-center">
                                <div class="relative flex size-40 items-center justify-center rounded-full border-[6px] {{ $borderColor }} p-6 text-center transition-transform duration-300 hover:scale-105 sm:size-48 lg:size-52">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-3xl font-black text-white sm:text-4xl">{{ $item->title }}</span>
                                        <span class="mt-2 max-w-[130px] text-[10px] font-extrabold leading-tight text-slate-200 uppercase tracking-widest sm:text-11px">{{ $item->subtitle ?: $item->body }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-16 flex justify-center gap-3">
                        <span class="size-2 rounded-full bg-white/20"></span>
                        <span class="size-2 rounded-full bg-white"></span>
                        <span class="size-2 rounded-full bg-white/20"></span>
                        <span class="size-2 rounded-full bg-white/20"></span>
                    </div>
                </div>
            </section>
            @endif


            <section id="courses" class="bg-[#f0f8f7] py-16 dark:bg-ink sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-2xl font-black uppercase tracking-[0.2em] text-slate-800 dark:text-white sm:text-3xl">Popular Courses</h2>
                    </div>

                    <div class="relative group" data-course-carousel data-course-interval="5000">
                        <!-- Navigation Arrows -->
                        <div class="hidden lg:block">
                            <button type="button" class="absolute -left-5 top-1/2 z-10 flex size-10 -translate-y-1/2 items-center justify-center rounded-full bg-white text-slate-400 shadow-lg border border-slate-50 transition hover:bg-emerald-500 hover:text-white focus:outline-none dark:bg-deep dark:border-white/10 dark:text-white/60" data-course-prev aria-label="Previous courses">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                            <button type="button" class="absolute -right-5 top-1/2 z-10 flex size-10 -translate-y-1/2 items-center justify-center rounded-full bg-white text-slate-400 shadow-lg border border-slate-50 transition hover:bg-emerald-500 hover:text-white focus:outline-none dark:bg-deep dark:border-white/10 dark:text-white/60" data-course-next aria-label="Next courses">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>

                        <div class="course-carousel-track flex gap-6 overflow-x-auto scroll-smooth pb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-course-track tabindex="0" aria-label="Popular courses">
                        @forelse ($popularCourses as $course)
                            @php
                                $courseImages = ['images/bnyti-hero-premium-2.png', 'images/bnyti-hero-premium-1.png', 'images/bnyti-hero-premium-3.png', 'images/bnyti-hero-premium-1.png'];
                                $coursePositions = ['object-center', 'object-center', 'object-center', 'object-center'];
                                $courseIndex = $loop->index % 4;
                                $courseImage = $course->image_path ? Storage::disk('public')->url($course->image_path) : asset($courseImages[$courseIndex]);
                            @endphp
                            <article class="course-carousel-slide group flex w-[280px] shrink-0 snap-start flex-col rounded-[2rem] bg-white p-4 shadow-sm transition duration-300 hover:shadow-xl dark:bg-deep sm:w-[290px]" data-course-slide>
                                <div class="relative aspect-square shrink-0 overflow-hidden rounded-2xl bg-slate-100">
                                    <img
                                        src="{{ $courseImage }}"
                                        alt="{{ $course->name }}"
                                        class="size-full object-cover transition duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                </div>

                                <div class="flex flex-1 flex-col px-1 py-5">
                                    <h3 class="text-xl font-black leading-tight text-slate-900 dark:text-white">{{ $course->name }}</h3>
                                    <p class="mt-2 line-clamp-2 text-xs font-medium leading-relaxed text-slate-500 dark:text-slate-400">{{ $course->description }}</p>

                                    <!-- Star Rating -->
                                    <div class="mt-4 flex gap-0.5 text-amber-400" aria-label="5 out of 5 stars">
                                        @for ($star = 0; $star < 5; $star++)
                                            <svg viewBox="0 0 20 20" aria-hidden="true" class="size-4" fill="currentColor">
                                                <path d="m10 1.8 2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.6-4.8 2.6.9-5.4-3.9-3.8 5.4-.8L10 1.8Z" />
                                            </svg>
                                        @endfor
                                    </div>

                                    <div class="mt-6">
                                        <a href="#latest-news-contact" class="block w-full rounded-xl bg-[#f5a623] py-3 text-center text-sm font-black text-white transition hover:bg-[#e69516]">
                                            Learn More
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="w-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-sm font-semibold text-slate-500 dark:border-white/15 dark:bg-deep dark:text-slate-300">
                                Course information will be available soon.
                            </div>
                        @endforelse
                        </div>

                        <!-- Mobile controls & status -->
                        <div class="mt-4 flex items-center justify-center gap-4 lg:hidden">
                            <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 dark:border-white/15 dark:bg-deep dark:text-white" data-course-prev aria-label="Previous courses">
                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                            </button>
                            <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-course-current>1</span> of <span data-course-total>1</span></p>
                            <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 dark:border-white/15 dark:bg-deep dark:text-white" data-course-next aria-label="Next courses">
                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section id="expert-teachers" class="bg-[#e7f3f9] py-16 dark:bg-deep sm:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-16 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-tight text-[#0b2447] dark:text-white sm:text-4xl">Expert Teachers Gallery</h2>
                    </div>

                    <div class="relative group" data-teacher-carousel data-teacher-interval="5000">
                        <!-- Navigation Arrows -->
                        <div class="hidden lg:block">
                            <button type="button" class="absolute -left-10 top-1/2 z-10 flex size-12 -translate-y-1/2 items-center justify-center rounded-full bg-white text-slate-400 shadow-xl border border-slate-100 transition hover:bg-emerald-500 hover:text-white focus:outline-none dark:bg-slate-800 dark:border-white/10 dark:text-white/60" data-teacher-prev aria-label="Previous teachers">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                            <button type="button" class="absolute -right-10 top-1/2 z-10 flex size-12 -translate-y-1/2 items-center justify-center rounded-full bg-white text-slate-400 shadow-xl border border-slate-100 transition hover:bg-emerald-500 hover:text-white focus:outline-none dark:bg-slate-800 dark:border-white/10 dark:text-white/60" data-teacher-next aria-label="Next teachers">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>

                        <div class="teacher-carousel-track flex gap-6 overflow-x-auto scroll-smooth pb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-teacher-track tabindex="0" aria-label="Teacher profiles">
                            @foreach ($teacherCards as $teacher)
                                <article class="teacher-carousel-slide group flex w-[280px] shrink-0 snap-start flex-col overflow-hidden rounded-2xl bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition duration-300 hover:-translate-y-1 hover:shadow-xl dark:bg-slate-900/60 sm:w-[300px]" data-teacher-slide>
                                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-slate-100">
                                        @if ($teacher['image_path'])
                                            <img
                                                src="{{ Storage::url($teacher['image_path']) }}"
                                                alt="{{ $teacher['name'] }}"
                                                class="size-full object-cover transition duration-500 group-hover:scale-105"
                                                loading="lazy"
                                            >
                                        @else
                                            <div
                                                role="img"
                                                aria-label="{{ $teacher['name'] }}"
                                                class="size-full bg-cover bg-center bg-no-repeat transition duration-500 group-hover:scale-105"
                                                style="background-image: url('{{ asset('images/expert-teachers-sprite-v2.png') }}'); background-size: 600% auto; background-position: {{ $loop->index * 20 }}% 52%;"
                                            ></div>
                                        @endif
                                    </div>

                                    <div class="flex flex-1 flex-col p-5">
                                        <h3 class="text-lg font-black leading-tight text-[#0b2447] dark:text-white">{{ $teacher['name'] }}</h3>
                                        <p class="mt-1 text-[11px] font-bold text-slate-500 uppercase">{{ $teacher['designation'] ?? $teacher['department'] }}</p>

                                        <p class="mt-3 line-clamp-3 text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-400">
                                            Expert in {{ $teacher['department'] }} with over {{ $teacher['experience'] }} years of practical industry experience and academic excellence.
                                        </p>

                                        <div class="mt-auto flex gap-0.5 pt-5 text-amber-400" aria-label="5 out of 5 stars">
                                            @for ($star = 0; $star < 5; $star++)
                                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-4" fill="currentColor">
                                                    <path d="m10 1.8 2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.6-4.8 2.6.9-5.4-3.9-3.8 5.4-.8L10 1.8Z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Mobile & Scroll Indicators -->
                        <div class="mt-8 flex items-center justify-center gap-3">
                            <span class="size-2 rounded-full bg-[#0b2447]/20 dark:bg-white/20"></span>
                            <span class="size-2 rounded-full bg-[#0b2447] dark:bg-white"></span>
                            <span class="size-2 rounded-full bg-[#0b2447]/20 dark:bg-white/20"></span>
                            <span class="size-2 rounded-full bg-[#0b2447]/20 dark:bg-white/20"></span>
                        </div>
                    </div>
                </div>
            </section>

            <section id="branch-application-promo" class="bg-stone-50 pb-12 dark:bg-ink sm:pb-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="relative isolate overflow-hidden rounded-[1.4rem] bg-[#03224c] px-5 py-6 text-white shadow-[0_16px_40px_rgba(3,34,76,.22)] sm:px-8 sm:py-8 lg:px-9">
                        <div class="absolute inset-0 -z-10 opacity-40 [background-image:radial-gradient(circle,rgba(250,204,21,.85)_1px,transparent_1.5px)] [background-size:78px_72px]"></div>
                        <div class="absolute top-1/2 left-[58%] -z-10 size-80 -translate-x-1/2 -translate-y-1/2 rounded-full border border-emerald-300/10"></div>
                        <div class="absolute top-1/2 left-[58%] -z-10 size-[27rem] -translate-x-1/2 -translate-y-1/2 rounded-full border border-amber-300/10"></div>

                        <div class="grid items-center gap-8 lg:grid-cols-[1.18fr_.9fr_.48fr] lg:gap-7">
                            <div>
                                <p class="text-sm font-extrabold text-lime-300">Expand With BNYTI</p>
                                <h2 class="mt-1 text-3xl leading-[1.05] font-black tracking-tight sm:text-4xl">
                                    APPLY AS A BRANCH<br>
                                    ACROSS <span class="text-lime-400">BANGLADESH</span>
                                </h2>
                                <p class="mt-4 max-w-xl text-sm leading-5 text-slate-200">
                                    Join our growing network of technical education and establish an authorized BNYTI branch in your district. Together, we can empower the next generation with quality skills and career opportunities.
                                </p>

                                <div class="mt-6 grid grid-cols-2 gap-2 sm:grid-cols-3">
                                    @foreach ([
                                        ['Government Approved Training System', 'shield'],
                                        ['Complete Academic & Operational Support', 'support'],
                                        ['Standard Curriculum & Learning Resources', 'book'],
                                        ['Certificate Verification System', 'certificate'],
                                        ['Marketing & Student Admission Support', 'network'],
                                        ['Long-Term Institutional Partnership', 'partner'],
                                    ] as [$label, $icon])
                                        <div class="flex min-h-20 flex-col items-center justify-center rounded-xl border border-sky-200/25 bg-[#062a58]/80 px-2 py-2.5 text-center">
                                            <svg viewBox="0 0 24 24" aria-hidden="true" class="size-6 text-lime-300" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6">
                                                @if ($icon === 'shield')
                                                    <path d="M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Z" /><path d="m9 12 2 2 4-4" />
                                                @elseif ($icon === 'support')
                                                    <path d="M4 13v-2a8 8 0 0 1 16 0v2" /><path d="M4 12h3v6H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 1-2Zm16 0h-3v6h2a2 2 0 0 0 2-2v-2a2 2 0 0 0-1-2Z" />
                                                @elseif ($icon === 'book')
                                                    <path d="M4 5a3 3 0 0 1 3-2h5v17H7a3 3 0 0 0-3 2V5Zm16 0a3 3 0 0 0-3-2h-5v17h5a3 3 0 0 1 3 2V5Z" />
                                                @elseif ($icon === 'certificate')
                                                    <circle cx="12" cy="9" r="5" /><path d="m8.5 13-1 8 4.5-2.5 4.5 2.5-1-8" /><path d="m10 9 1.4 1.4L14 7.8" />
                                                @elseif ($icon === 'network')
                                                    <circle cx="6" cy="7" r="2" /><circle cx="18" cy="7" r="2" /><circle cx="12" cy="17" r="2" /><path d="m7.5 8.5 3 6m6-6-3 6M8 7h8" />
                                                @else
                                                    <path d="M7 20v-3a5 5 0 0 1 10 0v3M8 7a4 4 0 1 0 8 0 4 4 0 0 0-8 0Z" /><path d="m17 10 2 2 3-4" />
                                                @endif
                                            </svg>
                                            <p class="mt-2 text-[9px] leading-3 font-bold text-slate-100">{{ $label }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-6 flex flex-wrap gap-3">
                                    <a href="{{ route('branch-applications.create') }}" class="inline-flex min-h-11 items-center justify-center gap-3 rounded-xl bg-amber-300 px-6 text-sm font-black text-[#09234c] transition hover:bg-amber-200 focus:outline-none focus:ring-4 focus:ring-amber-300/30">
                                        Apply as a Branch
                                        <span aria-hidden="true">→</span>
                                    </a>
                                    <a href="#latest-news-contact" class="inline-flex min-h-11 items-center justify-center gap-3 rounded-xl border border-slate-300/35 px-6 text-sm font-bold text-white transition hover:bg-white/10 focus:outline-none focus:ring-4 focus:ring-white/15">
                                        Download Prospectus
                                        <span aria-hidden="true">↓</span>
                                    </a>
                                </div>
                            </div>

                            <div class="relative mx-auto hidden aspect-square w-full max-w-[330px] md:block">
                                <svg viewBox="0 0 300 300" role="img" aria-label="Bangladesh branch coverage map" class="size-full">
                                    <rect width="300" height="300" rx="24" fill="#03224c" />

                                    <g fill="none" stroke="#24527d" stroke-width="1.2" opacity=".65">
                                        <circle cx="150" cy="146" r="142" />
                                        <circle cx="150" cy="146" r="108" />
                                        <circle cx="150" cy="146" r="75" />
                                    </g>

                                    <g fill="none" stroke="#facc15" stroke-linecap="round" opacity=".75">
                                        <path d="M8 171C64 102 193 67 294 104" stroke-dasharray="1 9" stroke-width="2" />
                                        <path d="M19 197C92 241 224 252 291 188" stroke-dasharray="1 8" stroke-width="2" />
                                        <path d="M72 72c42 34 122 59 213 52" stroke-dasharray="1 8" stroke-width="1.7" />
                                    </g>

                                    <g fill="#facc15">
                                        <circle cx="11" cy="19" r="1.2" />
                                        <circle cx="89" cy="18" r="1.2" />
                                        <circle cx="169" cy="17" r="1.2" />
                                        <circle cx="250" cy="18" r="1.2" />
                                        <circle cx="24" cy="235" r="1.2" />
                                        <circle cx="50" cy="173" r="3" />
                                        <circle cx="279" cy="221" r="1.5" />
                                    </g>

                                    <path
                                        d="M248.6 215.7 247.7 246.7 232.6 240.1 235.4 275 223.1 252.4 220.6 230.4 212.3 209.5 194.2 184.3 154.4 182.6 158.3 200.4 144.7 224.5 126.3 215.8 120 223.6 107.8 218.9 91 215 84.3 179.4 69.3 146.8 76.6 120.8 50 109.2 59.6 93.4 86.7 77.3 55.4 54.4 70.7 25 105 43.7 125.7 45.8 129.5 75.9 170.7 81.9 210.8 81.2 235.7 88.6 215.8 125.2 196.4 127.7 183.1 152.4 206.8 174.8 213.8 147.1 225.8 147 248.6 215.7Z"
                                        fill="#198f65"
                                        stroke="#8df0b1"
                                        stroke-linejoin="round"
                                        stroke-width="3"
                                    />

                                    <g fill="none" stroke="#9ae6b4" stroke-linecap="round" opacity=".55">
                                        <path d="M111 47c21 40 17 76 29 117 10 36 3 68-9 90" />
                                        <path d="M206 91c-21 26-37 55-30 92 5 28 26 49 48 62" />
                                        <path d="M83 147c41-10 86-5 130 11" />
                                    </g>

                                    @foreach ([[99,68], [158,104], [207,106], [151,145], [108,190], [218,205]] as [$x, $y])
                                        <g transform="translate({{ $x }} {{ $y }})">
                                            <path d="M0-11c-5.8 0-10 4.3-10 10.2C-10 6.5 0 15 0 15S10 6.5 10-.8C10-6.7 5.8-11 0-11Z" fill="#facc15" />
                                            <circle cy="-1" r="3.2" fill="white" />
                                        </g>
                                    @endforeach
                                </svg>
                            </div>

                            <div class="grid grid-cols-2 gap-3 rounded-2xl border border-sky-200/25 bg-[#062a58]/80 p-4 sm:grid-cols-4 lg:grid-cols-1">
                                @foreach ([
                                    ['250+', 'Branches', 'M5 20v-6h4v6m6 0v-9h4v9M3 20h18M7 10a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm10-1a3 3 0 1 0 0-6'],
                                    ['64', 'District Coverage', 'M12 21s7-6 7-12a7 7 0 1 0-14 0c0 6 7 12 7 12Zm0-9a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z'],
                                    ['20,000+', 'Students', 'M12 3 19 6v5c0 4.7-3 8-7 10-4-2-7-5.3-7-10V6l7-3Zm-3 9 2 2 4-4'],
                                    ['150+', 'Expert Trainers', 'm12 3 2.2 4.5 5 .7-3.6 3.5.9 5-4.5-2.4-4.5 2.4.9-5-3.6-3.5 5-.7L12 3Z'],
                                ] as [$number, $label, $path])
                                    <div class="flex items-center gap-3 lg:border-b lg:border-white/10 lg:pb-3 lg:last:border-0 lg:last:pb-0">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" class="size-7 shrink-0 text-lime-300" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6">
                                            <path d="{{ $path }}" />
                                        </svg>
                                        <div>
                                            <p class="text-xl font-black leading-none text-lime-300">{{ $number }}</p>
                                            <p class="mt-1 text-[10px] leading-3 font-bold text-slate-200">{{ $label }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="institute-gallery" class="bg-[#03224c] py-16 text-white sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-[0.2em] text-white sm:text-4xl">Student Gallery</h2>
                    </div>

                    @php
                        $galleryItems = $homepageItems('gallery');
                    @endphp
                    <div class="relative group" data-gallery-carousel data-gallery-interval="5000">
                        <!-- Navigation Arrows -->
                        <div class="hidden lg:block">
                            <button type="button" class="absolute -left-8 top-1/2 z-10 flex size-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white shadow-xl border border-white/20 transition hover:bg-emerald-500 hover:text-white focus:outline-none" data-gallery-prev aria-label="Previous images">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                            <button type="button" class="absolute -right-8 top-1/2 z-10 flex size-12 -translate-y-1/2 items-center justify-center rounded-full bg-white/10 text-white shadow-xl border border-white/20 transition hover:bg-emerald-500 hover:text-white focus:outline-none" data-gallery-next aria-label="Next images">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>

                        <div class="gallery-carousel-track grid grid-cols-2 gap-2 overflow-hidden sm:grid-cols-4 sm:gap-3" data-gallery-track aria-label="Student gallery">
                        @foreach ($galleryItems->take(8) as $item)
                            @php
                                $image = $item->image_path ?: 'images/institute-gallery-1.png';
                            @endphp
                            <div class="gallery-carousel-slide aspect-[4/3] overflow-hidden rounded-lg bg-slate-800" data-gallery-slide>
                                <img
                                    src="{{ asset($image) }}"
                                    alt="{{ $item->title }}"
                                    class="size-full object-cover transition duration-500 hover:scale-110"
                                    loading="lazy"
                                >
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section id="student-success-stories" class="bg-[#f8fafc] py-16 dark:bg-ink sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-tight text-[#0b2447] dark:text-white sm:text-4xl">Student Success Stories</h2>
                        <div class="mx-auto mt-2 h-1 w-16 rounded-full bg-emerald-500"></div>
                    </div>

                    @php
                        $studentStories = $homepageItems('testimonials');
                    @endphp
                    <div class="relative group" data-student-carousel data-student-interval="5000">
                        <div class="student-carousel-track flex gap-6 overflow-x-auto scroll-smooth pb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-student-track tabindex="0" aria-label="Student success stories">
                        @foreach ($studentStories as $item)
                            @php
                                $quote = $item->body;
                                $name = $item->title;
                                $position = $item->subtitle;
                            @endphp
                            <article class="student-carousel-slide group flex w-[320px] shrink-0 snap-start overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-deep sm:w-[380px]" data-student-slide>
                                <div class="relative w-32 shrink-0 p-3 sm:w-40 sm:p-4">
                                    <div
                                        role="img"
                                        aria-label="{{ $name }}"
                                        class="aspect-[4/5] w-full overflow-hidden rounded-t-2xl rounded-b-[3.5rem] bg-slate-100 bg-cover bg-center bg-no-repeat ring-1 ring-slate-900/5 transition duration-500 group-hover:scale-105 dark:ring-white/10 sm:rounded-b-[4.5rem]"
                                        style="background-image: url('{{ asset('images/student-success-sprite.png') }}'); background-position: {{ $loop->index * 33.333 }}% 30%;"
                                    ></div>
                                </div>

                                <div class="flex flex-1 flex-col justify-center px-5 py-6">
                                    <h3 class="text-lg font-black leading-tight text-[#0b2447] dark:text-white">{{ $name }}</h3>
                                    <p class="mt-0.5 text-[11px] font-bold text-[#16a34a] dark:text-emerald-400">{{ $position }}</p>

                                    <div class="mt-4 space-y-2">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Course:</span>
                                            <span class="text-[12px] font-black text-slate-800 dark:text-slate-200 leading-none">{{ $item->metadata['course'] ?? 'Technical Training' }}</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">Outcome:</span>
                                            <span class="line-clamp-2 text-[11px] font-bold leading-snug text-slate-600 dark:text-slate-400">{{ Str::limit($quote, 55) }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-5 flex gap-0.5 text-amber-400" aria-label="5 out of 5 stars">
                                        @for ($star = 0; $star < 5; $star++)
                                            <svg viewBox="0 0 20 20" aria-hidden="true" class="size-4" fill="currentColor">
                                                <path d="m10 1.8 2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.6-4.8 2.6.9-5.4-3.9-3.8 5.4-.8L10 1.8Z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </article>
                        @endforeach
                        </div>

                        <!-- Navigation Controls -->
                        @if ($studentStories->count() > 1)
                            <div class="mt-4 flex items-center justify-center gap-4 lg:hidden">
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 dark:border-white/15 dark:bg-deep dark:text-white" data-student-prev aria-label="Previous stories">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                                </button>
                                <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-student-current>1</span> of <span data-student-total>1</span></p>
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 dark:border-white/15 dark:bg-deep dark:text-white" data-student-next aria-label="Next stories">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section id="latest-news-contact" class="bg-[#e7f3f9] py-16 dark:bg-deep sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-tight text-[#0b2447] dark:text-white sm:text-4xl">Contact Section</h2>
                    </div>

                    <div class="grid items-start gap-10 lg:grid-cols-[1.2fr_1fr_.8fr]">
                        <!-- Contact Form -->
                        <div class="rounded-2xl border-4 border-[#155e75] bg-white p-6 shadow-xl dark:bg-slate-900/60">
                            <form action="#" method="POST" class="space-y-4">
                                <input type="text" placeholder="Name" class="w-full rounded-md border border-slate-200 px-4 py-3 text-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none dark:border-white/10 dark:bg-slate-800">
                                <input type="email" placeholder="Email" class="w-full rounded-md border border-slate-200 px-4 py-3 text-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none dark:border-white/10 dark:bg-slate-800">
                                <input type="text" placeholder="Your Address" class="w-full rounded-md border border-slate-200 px-4 py-3 text-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none dark:border-white/10 dark:bg-slate-800">
                                <textarea placeholder="Message" rows="4" class="w-full rounded-md border border-slate-200 px-4 py-3 text-sm focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none dark:border-white/10 dark:bg-slate-800"></textarea>
                                <button type="submit" class="w-full rounded-md bg-[#f5a623] py-3 text-sm font-black text-white uppercase transition hover:bg-[#e69516]">Submit</button>
                            </form>
                        </div>

                        <!-- Contact Details -->
                        <div class="space-y-8 py-4">
                            <div class="flex items-start gap-4">
                                <div class="grid size-8 shrink-0 place-items-center rounded-full bg-[#0b2447] text-white">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-[#0b2447] dark:text-white">Student Address</h3>
                                    <p class="mt-1 text-xs font-bold text-slate-600 dark:text-slate-400">Haji Hossain Plaza, Demra,<br>Dhaka-1360, Bangladesh</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="grid size-8 shrink-0 place-items-center rounded-full bg-[#0b2447] text-white">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-[#0b2447] dark:text-white">Phone Number</h3>
                                    <p class="mt-1 text-xs font-bold text-slate-600 dark:text-slate-400">+880 9696-481628</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="grid size-8 shrink-0 place-items-center rounded-full bg-[#0b2447] text-white">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-[#0b2447] dark:text-white">Mobile Number</h3>
                                    <p class="mt-1 text-xs font-bold text-slate-600 dark:text-slate-400">+880 1675-870000<br>bnyti-edubd@gmail.com</p>
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="relative aspect-square w-full overflow-hidden rounded-2xl bg-white shadow-lg">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.887255866185!2d90.49969147589417!3d23.715694889785834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755b719489f6b95%3A0xc6c4f8d55d144983!2sDemra%20Bazar%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1716800000000!5m2!1sen!2sbd"
                                class="size-full border-0"
                                allowfullscreen=""
                                loading="lazy"
                            ></iframe>
                        </div>
                    </div>
                </div>
            </section>
                </div>
            </section>

            {{-- Legacy homepage sections retained temporarily for reference and excluded from rendered output.
            <section class="hidden" aria-hidden="true">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="reveal flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                        <div class="max-w-2xl">
                            <div class="eyebrow" data-i18n="programEyebrow">CAREER PROGRAMS</div>
                            <h2 class="section-title mt-5" data-i18n="programTitle">Learn the skills employers actually need.</h2>
                        </div>
                        <p class="max-w-md text-sm leading-7 text-slate-600 dark:text-slate-300" data-i18n="programBody">
                            Short, practical programs built around real tools, clear outcomes, and skills you can use from day one.
                        </p>
                    </div>

                    <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ([
                            ['01', 'Computer Office Application', 'courseOne', '3–6 Months', 'courseDurationShort', 'emerald'],
                            ['02', 'Graphics & Creative Design', 'courseTwo', '6 Months', 'courseDurationSix', 'amber'],
                            ['03', 'Electrical Installation', 'courseThree', '6 Months', 'courseDurationSix', 'cyan'],
                            ['04', 'Web Design & Development', 'courseFour', '6–12 Months', 'courseDurationLong', 'rose'],
                            ['05', 'Digital Marketing & SEO', 'courseFive', '3–6 Months', 'courseDurationShort', 'lime'],
                            ['06', 'Dress Making & Fashion', 'courseSix', '6 Months', 'courseDurationSix', 'sky'],
                        ] as [$number, $title, $titleKey, $duration, $durationKey, $tone])
                            <article class="course-card group reveal" style="--reveal-delay: {{ ($loop->index % 3) * 90 }}ms">
                                <div class="course-icon course-icon-{{ $tone }}">
                                    <span class="text-sm font-black">{{ $number }}</span>
                                </div>
                                <div class="flex flex-1 flex-col gap-4">
                                    <div>
                                        <p class="text-[11px] font-black tracking-[0.16em] text-emerald-600 uppercase dark:text-emerald-400" data-i18n="{{ $durationKey }}">{{ $duration }}</p>
                                        <h3 class="mt-2 text-xl font-black tracking-tight text-slate-950 dark:text-white" data-i18n="{{ $titleKey }}">{{ $title }}</h3>
                                    </div>
                                    <p class="text-sm leading-6 text-slate-600 dark:text-slate-400" data-i18n="courseDescription">Hands-on lessons, guided projects, and assessment focused on practical competence.</p>
                                    <a href="#latest-news-contact" class="mt-auto inline-flex items-center gap-2 text-sm font-black text-slate-900 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                        <span data-i18n="viewCourse">View program</span>
                                        <span aria-hidden="true">↗</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="hidden" aria-hidden="true">
                <div class="mx-auto grid max-w-6xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-[0.82fr_1.35fr] lg:gap-16 lg:px-8">
                    <article class="reveal mx-auto w-full max-w-[400px] overflow-hidden rounded-[1.35rem] border border-slate-200 bg-white shadow-[0_18px_45px_rgba(15,23,42,.14)] dark:border-white/10 dark:bg-ink">
                        <div class="aspect-[4/5] overflow-hidden bg-stone-100">
                            <img
                                src="{{ asset('images/principal-portrait.webp') }}"
                                alt="Portrait of Mst Salma Rahman, Principal"
                                class="size-full object-cover object-top"
                                loading="lazy"
                            >
                        </div>
                        <div class="bg-[#0b2447] px-6 py-5 text-center text-white">
                            <h3 class="text-xl font-black tracking-tight sm:text-2xl">Mst Salma Rahman</h3>
                            <p class="mt-1 text-sm font-medium text-slate-200">Principal</p>
                        </div>
                    </article>

                    <div class="reveal" style="--reveal-delay: 120ms">
                        <div class="flex items-center gap-4">
                            <h2 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl dark:text-white">
                                About <span class="text-emerald-600 dark:text-emerald-400">Us</span>
                            </h2>
                            <span class="mt-2 h-1 w-24 rounded-full bg-emerald-600 sm:w-32"></span>
                        </div>
                        <div class="mt-4 h-px w-full bg-slate-200 dark:bg-white/10"></div>

                        <div class="mt-7 flex flex-col gap-4 text-[15px] leading-7 text-slate-600 dark:text-slate-300">
                            <h3 class="font-bold text-slate-900 dark:text-white">About the Institution</h3>
                            <p>
                                Bangladesh National Youth Technical Institute (BNYTI) is a renowned technical and skills development institution in Bangladesh, committed to empowering the nation’s youth with industry-relevant knowledge, practical expertise, and modern technological skills.
                            </p>
                            <p>
                                BNYTI provides a comprehensive learning environment that combines theoretical knowledge with hands-on training, professional ethics, and practical experience. Our goal is to equip every learner with the confidence and competence required to succeed in today’s competitive world.
                            </p>
                            <p>
                                Through years of excellence and dedication, the institute has expanded its educational services across Bangladesh. Our growing branch network continues to deliver accessible, quality technical education and skills development training to students and trainees.
                            </p>
                            <p class="hidden sm:block">
                                We are dedicated to producing skilled, ethical, innovative, and competent professionals who can build sustainable careers and make a meaningful contribution to the country.
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            <section class="hidden" aria-hidden="true">
                <div class="mx-auto grid max-w-7xl items-center gap-14 px-4 sm:px-6 lg:grid-cols-2 lg:gap-20 lg:px-8">
                    <div class="reveal relative">
                        <div class="about-visual relative aspect-[4/4.2] overflow-hidden rounded-[2rem] bg-emerald-950 shadow-2xl">
                            <div class="absolute inset-0 bg-[linear-gradient(140deg,rgba(52,211,153,.18),transparent_42%),radial-gradient(circle_at_70%_25%,rgba(251,191,36,.22),transparent_25%)]"></div>
                            <svg viewBox="0 0 560 590" aria-hidden="true" class="absolute inset-0 size-full">
                                <path d="M0 450 560 325v265H0z" fill="#064e3b"/>
                                <path d="M0 495 560 370" stroke="#10b981" stroke-opacity=".35" stroke-width="4"/>
                                <rect x="50" y="65" width="340" height="230" rx="18" fill="#09293a" stroke="#34d399" stroke-opacity=".35" stroke-width="4"/>
                                <path d="M100 235v-92h45v92m35 0V107h45v128m35 0v-58h45v58" fill="none" stroke="#5eead4" stroke-width="15"/>
                                <path d="m82 251 82-60 58 30 98-99 42 32" fill="none" stroke="#fbbf24" stroke-linecap="round" stroke-linejoin="round" stroke-width="8"/>
                                <circle cx="413" cy="243" r="61" fill="#a16207"/>
                                <path d="M353 230c5-62 108-75 124-2-32-20-82-20-124 2Z" fill="#0f172a"/>
                                <path d="M312 505c11-116 51-191 109-191 65 0 105 77 119 191H312Z" fill="#fbbf24"/>
                                <path d="M378 326c20 20 63 20 83 0v69h-83v-69Z" fill="#92400e"/>
                                <path d="m346 395-98-74-25 31 105 97" fill="#d97706"/>
                                <circle cx="235" cy="337" r="20" fill="#92400e"/>
                                <path d="M100 520h380" stroke="#fff" stroke-dasharray="6 15" stroke-opacity=".2" stroke-width="3"/>
                            </svg>
                            <div class="absolute right-5 bottom-5 left-5 rounded-2xl border border-white/10 bg-ink/80 p-5 backdrop-blur">
                                <p class="text-xs font-black tracking-[0.18em] text-emerald-300" data-i18n="principalMessage">A MESSAGE FROM OUR PRINCIPAL</p>
                                <p class="mt-2 text-lg font-black text-white">Mst Salma Rahman</p>
                            </div>
                        </div>
                        <div class="absolute -top-6 -right-4 hidden size-32 place-items-center rounded-full border border-emerald-200 bg-stone-50 text-center shadow-xl sm:grid dark:border-emerald-900 dark:bg-ink">
                            <div>
                                <strong class="block text-3xl font-black text-emerald-600 dark:text-emerald-400">15+</strong>
                                <span class="text-[10px] font-bold tracking-wide text-slate-500 uppercase dark:text-slate-300" data-i18n="yearsImpact">Years of impact</span>
                            </div>
                        </div>
                    </div>

                    <div class="reveal" style="--reveal-delay: 120ms">
                        <div class="eyebrow" data-i18n="aboutEyebrow">ABOUT THE INSTITUTE</div>
                        <h2 class="section-title mt-5" data-i18n="aboutTitle">Education that moves beyond the classroom.</h2>
                        <div class="mt-7 flex flex-col gap-5 text-base leading-8 text-slate-600 dark:text-slate-300">
                            <p data-i18n="aboutBodyOne">
                                Bangladesh National Youth Technical Institute is committed to developing skilled, confident, and self-reliant people through modern technical education.
                            </p>
                            <p data-i18n="aboutBodyTwo">
                                Our programs combine foundational knowledge with hands-on practice, professional ethics, and the tools learners need to compete in a changing job market.
                            </p>
                        </div>
                        <div class="mt-8 grid gap-4 sm:grid-cols-2">
                            <div class="feature-point">
                                <span class="feature-check">✓</span>
                                <span data-i18n="aboutPointOne">Experienced instructors</span>
                            </div>
                            <div class="feature-point">
                                <span class="feature-check">✓</span>
                                <span data-i18n="aboutPointTwo">Practical lab sessions</span>
                            </div>
                            <div class="feature-point">
                                <span class="feature-check">✓</span>
                                <span data-i18n="aboutPointThree">Flexible course formats</span>
                            </div>
                            <div class="feature-point">
                                <span class="feature-check">✓</span>
                                <span data-i18n="aboutPointFour">Nationwide access</span>
                            </div>
                        </div>
                        <a href="#latest-news-contact" class="primary-button mt-9 inline-flex">
                            <span data-i18n="discoverStory">Discover our story</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </section>
            --}}
        </main>

        <footer class="bg-[#031735] text-white">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">
                    <div class="space-y-6">
                        <a href="#home" class="flex items-center gap-4">
                            <div class="grid size-14 place-items-center rounded-xl bg-white p-2">
                                <img src="{{ asset('images/bnyti-logo.svg') }}" alt="Logo" class="size-full">
                            </div>
                            <div>
                                <span class="block text-2xl font-black tracking-tight text-white uppercase leading-none">South Asia</span>
                                <span class="block text-[10px] font-bold tracking-[0.1em] text-slate-400 uppercase mt-1">National Technical Institute</span>
                            </div>
                        </a>
                        <p class="text-sm leading-relaxed text-slate-300">
                            Bangladesh National Youth Technical Institute provides practical, industry-focused technical education for a skilled future.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg font-black text-white">Quick Links</h3>
                        <div class="mt-6 grid gap-3 text-sm font-bold text-slate-400">
                            <a href="#home" class="hover:text-emerald-400 transition">Admission</a>
                            <a href="#courses" class="hover:text-emerald-400 transition">Courses</a>
                            <a href="{{ route('results.index') }}" class="hover:text-emerald-400 transition">Exam Site</a>
                            <a href="#institute-gallery" class="hover:text-emerald-400 transition">Photogallery</a>
                            <a href="#" class="hover:text-emerald-400 transition">Primary Report</a>
                            <a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Student Status</a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-black text-white">Careers</h3>
                        <div class="mt-6 grid gap-3 text-sm font-bold text-slate-400">
                            <a href="#about" class="hover:text-emerald-400 transition">General Info</a>
                            <a href="#branch-application-promo" class="hover:text-emerald-400 transition">Branches Info</a>
                            <a href="#notice-bar" class="hover:text-emerald-400 transition">Notice</a>
                            <a href="#latest-news-contact" class="hover:text-emerald-400 transition">Contact Details</a>
                            <a href="#" class="hover:text-emerald-400 transition">Careers</a>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-black text-white">Quick Marks</h3>
                        <p class="mt-6 text-sm font-bold text-slate-400">Take a look at your marks here.</p>
                        <div class="mt-6 flex items-center gap-4">
                            <a href="#" class="grid size-8 place-items-center rounded-full bg-[#1877f2] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-current"><path d="M13.5 21v-8h2.8l.4-3.1h-3.2V8c0-.9.3-1.5 1.6-1.5h1.7V3.7c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2H7.3V13h2.8v8h3.4Z"/></svg></a>
                            <a href="#" class="grid size-8 place-items-center rounded-full bg-[#1da1f2] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-current"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                            <a href="#" class="grid size-8 place-items-center rounded-full bg-[#e4405f] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-none stroke-current" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                            <a href="#" class="grid size-8 place-items-center rounded-full bg-[#ff0000] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-current"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33 2.78 2.78 0 0 0 1.94 2C5.12 19.5 12 19.5 12 19.5s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33zM9.75 15.02V8.48l5.75 3.27-5.75 3.27z"/></svg></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 py-8 text-center text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                <div class="mx-auto max-w-7xl px-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p>© {{ date('Y') }} South Asia National Technical Institute. All rights reserved.</p>
                    <p>Managed by BNYTI Technical Solutions</p>
                </div>
            </div>
        </footer>
    </body>
</html>

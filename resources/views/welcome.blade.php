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

        <header class="fixed inset-x-0 top-0 z-50 border-b border-slate-900/5 bg-stone-50/85 backdrop-blur-xl dark:border-white/10 dark:bg-ink/80">
            <div class="border-b border-slate-900/5 bg-ink text-white dark:border-white/10">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 text-[11px] font-semibold tracking-wide sm:px-6 lg:px-8">
                    <p class="flex min-w-0 items-center gap-2">
                        <span class="size-1.5 shrink-0 rounded-full bg-emerald-400 shadow-[0_0_12px_#34d399]"></span>
                        <span class="truncate" data-i18n="topMessage">Admissions are open for the July 2026 session</span>
                    </p>
                    <div class="hidden items-center gap-5 sm:flex">
                        <a href="tel:+8809696481628" class="transition hover:text-emerald-300">+880 9696-481628</a>
                        <a href="mailto:bnyti-edubd@gmail.com" class="transition hover:text-emerald-300">bnyti-edubd@gmail.com</a>
                    </div>
                </div>
            </div>

            <nav class="mx-auto flex h-[76px] max-w-7xl items-center justify-between gap-5 px-4 sm:px-6 lg:px-8" aria-label="Primary navigation">
                <a href="#home" class="group flex min-w-0 items-center gap-3" aria-label="BNYTI home">
                    <img
                        src="{{ asset('images/bnyti-logo.svg') }}"
                        alt="Bangladesh National Youth Technical Institute logo"
                        class="size-12 shrink-0 object-contain transition duration-300 group-hover:-rotate-3 sm:size-14"
                    >
                    <span class="min-w-0 sm:hidden">
                        <span class="block text-base font-black tracking-tight text-slate-950 dark:text-white">BNYTI</span>
                        <span class="block text-[9px] font-bold tracking-[0.14em] text-slate-500 dark:text-slate-300">TECHNICAL INSTITUTE</span>
                    </span>
                    <span class="hidden min-w-0 sm:block">
                        <span class="block truncate text-sm font-black tracking-tight text-slate-950 dark:text-white sm:text-[15px]">
                            <span class="text-emerald-600 dark:text-emerald-400">BANGLADESH</span>
                            <span class="text-red-600 dark:text-red-400"> NATIONAL</span>
                        </span>
                        <span class="block truncate text-[10px] font-bold tracking-[0.17em] text-slate-600 dark:text-slate-300 sm:text-[11px]">
                            YOUTH TECHNICAL INSTITUTE
                        </span>
                    </span>
                </a>

                <div class="hidden items-center gap-7 lg:flex">
                    <a href="#home" class="nav-link active" data-i18n="navHome">Home</a>
                    <a href="#courses" class="nav-link" data-i18n="navCourses">Courses</a>
                    <a href="#about" class="nav-link" data-i18n="navAbout">About</a>
                    <a href="#branch-application-promo" class="nav-link" data-i18n="navBranches">Branches</a>
                    <a href="{{ route('results.index') }}" class="nav-link">Results</a>
                    <details class="group relative">
                        <summary class="nav-link flex cursor-pointer list-none items-center gap-1">Apply Now <svg viewBox="0 0 24 24" class="size-4 transition group-open:rotate-180" aria-hidden="true"><path d="m6 9 6 6 6-6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg></summary>
                        <div class="absolute right-0 top-full z-30 mt-3 w-52 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl dark:border-white/10 dark:bg-ink">
                            <a href="{{ route('branch-applications.create') }}" class="block rounded-xl px-4 py-3 text-sm font-bold text-slate-700 transition hover:bg-emerald-50 hover:text-emerald-700 dark:text-slate-200 dark:hover:bg-emerald-500/10">Branch Registration</a>
                        </div>
                    </details>
                    <a href="{{ route('login') }}" class="nav-link">Staff Login</a>
                    <a href="#latest-news-contact" class="nav-link" data-i18n="navContact">Contact</a>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <button type="button" class="icon-button hidden lg:inline-grid" data-locale-toggle aria-label="Switch language">
                        <span class="text-xs font-black" data-locale-label>বাং</span>
                    </button>
                    <button type="button" class="icon-button hidden lg:inline-grid" data-theme-toggle aria-label="Toggle color theme">
                        <svg data-theme-sun viewBox="0 0 24 24" aria-hidden="true" class="size-5">
                            <circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/>
                        </svg>
                        <svg data-theme-moon viewBox="0 0 24 24" aria-hidden="true" class="hidden size-5">
                            <path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/>
                        </svg>
                    </button>
                    <a href="#latest-news-contact" class="hidden rounded-full bg-emerald-500 px-5 py-3 text-sm font-black text-ink shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-400 xl:inline-flex" data-i18n="getStarted">
                        Get Started
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
            <section id="home" class="hero-slide relative min-h-[620px] overflow-hidden bg-ink pt-[108px] text-white sm:min-h-[600px] lg:min-h-[620px] lg:pt-[116px]" data-hero-carousel>
                @foreach ($heroItems as $hero)
                    <img
                        src="{{ str_starts_with($hero->image_path, 'images/') ? asset($hero->image_path) : Storage::disk('public')->url($hero->image_path) }}"
                        alt="{{ $hero->title }}"
                        class="hero-carousel-image absolute inset-0 size-full object-cover object-[68%_center] opacity-0 sm:object-[58%_center]"
                        data-hero-image
                        @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif
                    >
                @endforeach
                <div class="hero-mobile-overlay absolute inset-0 bg-[linear-gradient(90deg,rgba(3,7,18,.88)_0%,rgba(3,7,18,.62)_42%,rgba(3,7,18,.38)_76%,rgba(3,7,18,.72)_100%)]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_68%,rgba(251,191,36,.24),transparent_32%),radial-gradient(circle_at_90%_12%,rgba(59,130,246,.2),transparent_28%)]"></div>
                <div class="absolute inset-x-0 bottom-0 h-1 bg-emerald-500"></div>

                <div class="hero-content-frame relative mx-auto flex min-h-[552px] max-w-7xl items-center px-4 pt-8 pb-24 sm:min-h-[492px] sm:px-6 sm:py-12 lg:min-h-[504px] lg:px-8">
                    <div class="hero-content reveal is-visible flex w-full max-w-[620px] flex-col items-start gap-5 sm:gap-8 lg:ml-12">
                        <h1 class="sr-only">{{ $heroLead?->title ?? 'Practical skills for a future without limits.' }}</h1>

                        <div class="hero-badge">
                            <span class="size-2.5 shrink-0 rounded-full bg-emerald-400 shadow-[0_0_16px_#34d399]"></span>
                            <span>{{ $heroLead?->subtitle ?? 'Bangladesh National Youth Technical Institute' }}</span>
                        </div>

                        <div class="h-1 w-28 rounded-full bg-emerald-500 shadow-[0_0_24px_rgba(16,185,129,.65)]"></div>

                        <p class="sr-only" data-i18n="heroBody">
                            {{ $heroLead?->body }}
                        </p>

                        <div class="hero-actions flex w-full flex-wrap items-center gap-3 sm:w-auto sm:gap-4">
                            <a href="{{ $heroLead?->link_url ?? '#courses' }}" class="hero-primary-button group">
                                <span>{{ $heroLead?->link_label ?? 'Get Started' }}</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="size-5 transition group-hover:translate-x-1">
                                    <path d="M5 12h14m-5-5 5 5-5 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </svg>
                            </a>
                            <a href="#latest-news-contact" class="hero-outline-button">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="size-5">
                                    <path d="M7.2 3h3l1.5 4.2-2 1.7c1.3 2.8 2.8 4.3 5.5 5.5l1.7-2 4.1 1.5v3c0 2.2-1.8 4-4 4C9.3 20.9 3 14.7 3 7a4 4 0 0 1 4.2-4Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.7"/>
                                </svg>
                                <span>Contact Us</span>
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
                        <article class="group flex min-h-[108px] flex-col items-center justify-center gap-1.5 border-r border-b border-slate-100 px-2.5 py-3 text-center transition-colors hover:bg-emerald-50/50 even:border-r-0 dark:border-white/10 dark:hover:bg-emerald-400/5 sm:min-h-[116px] sm:border-r sm:[&:nth-child(3n)]:border-r-0 lg:min-h-[104px] lg:border-b-0 lg:border-r lg:[&:nth-child(3n)]:border-r lg:last:border-r-0">
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
            <section id="about" class="overflow-hidden bg-white py-12 dark:bg-deep sm:py-16" data-about-carousel data-about-interval="10000">
                @if ($aboutEntries->isNotEmpty())
                    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                        <div class="relative overflow-hidden rounded-[1.35rem] border border-slate-200 bg-white shadow-[0_18px_45px_rgba(15,23,42,.14)] dark:border-white/10 dark:bg-ink">
                            @foreach ($aboutEntries as $about)
                                @php
                                    $aboutImage = $about->image_path ?: $about->principal_image_path;
                                @endphp
                                <article class="grid items-center gap-6 p-4 sm:gap-8 sm:p-8 lg:grid-cols-[0.82fr_1.35fr] lg:gap-10 {{ $loop->first ? '' : 'hidden' }}" data-about-slide>
                                    <div class="mx-auto w-full max-w-md overflow-hidden rounded-[1.1rem] bg-stone-100 lg:max-w-none">
                                        <img src="{{ $aboutImage ? (str_starts_with($aboutImage, 'images/') ? asset($aboutImage) : Storage::disk('public')->url($aboutImage)) : asset('images/principal-portrait.webp') }}" alt="{{ $about->about_heading }}" class="aspect-[4/4.2] w-full object-cover object-top sm:aspect-[4/4.6]" loading="lazy">
                                        @if ($about->principal_name)
                                            <div class="bg-[#0b2447] px-5 py-4 text-center text-white"><h3 class="text-lg font-black">{{ $about->principal_name }}</h3><p class="mt-1 text-xs text-slate-200">{{ $about->principal_title }}</p></div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-400">About the institute</p>
                                        <h2 class="mt-3 text-2xl font-black tracking-tight break-words text-slate-950 sm:text-4xl dark:text-white">{{ $about->about_heading }}</h2>
                                        <span class="mt-4 block h-1 w-24 rounded-full bg-emerald-600"></span>
                                        @if ($about->summary)
                                            <p class="mt-5 text-sm font-semibold leading-7 text-slate-700 dark:text-slate-200">{{ $about->summary }}</p>
                                        @endif
                                        @if ($about->content)
                                            <div class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-300">{{ $about->content }}</div>
                                        @endif
                                    </div>
                                </article>
                            @endforeach
                            @if ($aboutEntries->count() > 1)
                                <div class="flex items-center justify-between border-t border-slate-200 px-5 py-3 dark:border-white/10">
                                    <span class="text-xs font-bold text-slate-500" aria-live="polite"><span data-about-current>1</span> / {{ $aboutEntries->count() }}</span>
                                    <div class="flex items-center gap-2"><button type="button" data-about-prev class="grid size-9 place-items-center rounded-full border border-slate-200 font-black hover:bg-emerald-50" aria-label="Previous About entry">←</button><div class="flex gap-1.5" role="tablist" aria-label="About entries">@foreach ($aboutEntries as $about)<button type="button" data-about-dot="{{ $loop->index }}" class="size-2.5 rounded-full bg-slate-300 data-[active=true]:bg-emerald-600" aria-label="Show About entry {{ $loop->iteration }}" role="tab"></button>@endforeach</div><button type="button" data-about-next class="grid size-9 place-items-center rounded-full border border-slate-200 font-black hover:bg-emerald-50" aria-label="Next About entry">→</button></div>
                                </div>
                            @endif
                        </div>
                    </div>
                  @else
                     <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                         <div class="rounded-[1.35rem] border border-slate-200 bg-white p-8 text-center shadow-sm dark:border-white/10 dark:bg-ink">
                             <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-400">About the institute</p>
                             <h2 class="mt-3 text-3xl font-black tracking-tight">Education that moves beyond the classroom.</h2>
                             <p class="mx-auto mt-4 max-w-3xl whitespace-pre-line text-slate-600 dark:text-slate-300">Bangladesh National Youth Technical Institute (BNYTI) is committed to empowering young people with industry-relevant knowledge, practical expertise, and modern technological skills.</p>
                         </div>
                     </div>
                  @endif
            </section>
            @endif

            <section id="about-legacy" class="hidden" aria-hidden="true">
                @php
                    $aboutContent = $instituteProfile?->content ?? "Bangladesh National Youth Technical Institute (BNYTI) is a renowned technical and skills development institution in Bangladesh, committed to empowering the nation's youth with industry-relevant knowledge, practical expertise, and modern technological skills.\n\nBNYTI provides a comprehensive learning environment that combines theoretical knowledge with hands-on training, professional ethics, and practical experience. Our goal is to equip every learner with the confidence and competence required to succeed in today's competitive world.\n\nThrough years of excellence and dedication, the institute has expanded its educational services across Bangladesh. Our growing branch network continues to deliver accessible, quality technical education and skills development training to students and trainees.";
                    $aboutParagraphs = preg_split('/\R{2,}/', trim($aboutContent)) ?: [];
                    $principalImage = $instituteProfile?->principal_image_path;
                @endphp
                <div class="mx-auto grid max-w-6xl items-center gap-8 px-4 sm:px-6 lg:grid-cols-[0.82fr_1.35fr] lg:gap-10 lg:px-8">
                    <article class="reveal mx-auto w-full max-w-[360px] overflow-hidden rounded-[1.35rem] border border-slate-200 bg-white shadow-[0_18px_45px_rgba(15,23,42,.14)] dark:border-white/10 dark:bg-ink">
                        <div class="aspect-[4/4.6] max-h-[415px] overflow-hidden bg-stone-100">
                            <img
                                src="{{ $principalImage ? (str_starts_with($principalImage, 'images/') ? asset($principalImage) : Storage::disk('public')->url($principalImage)) : asset('images/principal-portrait.webp') }}"
                                alt="Portrait of {{ $instituteProfile?->principal_name ?? 'Mst Salma Rahman' }}, {{ $instituteProfile?->principal_title ?? 'Principal' }}"
                                class="size-full object-cover object-top"
                                loading="lazy"
                            >
                        </div>
                        <div class="bg-[#0b2447] px-6 py-5 text-center text-white">
                            <h3 class="text-xl font-black tracking-tight sm:text-2xl">{{ $instituteProfile?->principal_name ?? 'Mst Salma Rahman' }}</h3>
                            <p class="mt-1 text-sm font-medium text-slate-200">{{ $instituteProfile?->principal_title ?? 'Principal' }}</p>
                        </div>
                    </article>

                    <div class="reveal" style="--reveal-delay: 120ms">
                        <div class="flex items-center gap-4">
                            <h2 class="text-3xl font-black tracking-tight text-slate-950 sm:text-4xl dark:text-white">{{ $instituteProfile?->about_heading ?? 'About Us' }}</h2>
                            <span class="mt-2 h-1 w-24 rounded-full bg-emerald-600 sm:w-32"></span>
                        </div>
                        <div class="mt-4 h-px w-full bg-slate-200 dark:bg-white/10"></div>

                        <div class="mt-5 flex flex-col gap-3 text-sm leading-6 text-slate-600 dark:text-slate-300">
                            <h3 class="font-bold text-slate-900 dark:text-white">About the Institution</h3>
                            @if ($instituteProfile)
                                @foreach ($aboutParagraphs as $paragraph)
                                    <p>{{ $paragraph }}</p>
                                @endforeach
                            @else
                            <p>
                                Bangladesh National Youth Technical Institute (BNYTI) is a renowned technical and skills development institution in Bangladesh, committed to empowering the nation’s youth with industry-relevant knowledge, practical expertise, and modern technological skills.
                            </p>
                            <p>
                                BNYTI provides a comprehensive learning environment that combines theoretical knowledge with hands-on training, professional ethics, and practical experience. Our goal is to equip every learner with the confidence and competence required to succeed in today’s competitive world.
                            </p>
                            <p>
                                Through years of excellence and dedication, the institute has expanded its educational services across Bangladesh. Our growing branch network continues to deliver accessible, quality technical education and skills development training to students and trainees.
                            </p>
                            @endif
                        </div>

                        <a href="#latest-news-contact" class="mt-6 inline-flex min-h-11 items-center justify-center bg-slate-950 px-6 text-sm font-black tracking-wide text-white uppercase transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-200 dark:bg-emerald-500 dark:text-ink dark:hover:bg-emerald-400">
                            Read more
                        </a>
                    </div>
                </div>
            </section>

            @if ($isSectionVisible('statistics'))
            <section class="bg-white px-3 pb-7 dark:bg-deep sm:px-5 lg:px-8" aria-label="BNYTI achievements">
                <div class="mx-auto grid max-w-[1460px] grid-cols-2 overflow-hidden rounded-xl bg-[#071f3f] px-2 py-2.5 shadow-[0_5px_18px_rgba(7,31,63,.2)] sm:grid-cols-3 sm:px-3 lg:grid-cols-6 lg:px-4">
                    @foreach ($homepageItems('statistics') as $item)
                        @php
                            $value = $item->title;
                            $label = $item->subtitle ?: $item->body;
                            $icon = match ($item->icon) {
                                'students' => 'M8.5 11a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm7-1a2.75 2.75 0 1 0 0-5.5M2.5 20v-2.5a5.5 5.5 0 0 1 11 0V20h-11Zm11.5-6a4.75 4.75 0 0 1 7.5 3.9V20H17',
                                'branches' => 'M4 21V10l8-7 8 7v11M8 21v-7h8v7M6.5 8.5V4H9v2.3M3 21h18',
                                'courses' => 'M3.5 5.5c2.8-.8 5.6-.4 8.5 1.3v14c-2.9-1.7-5.7-2.1-8.5-1.3v-14Zm17 0c-2.8-.8-5.6-.4-8.5 1.3v14c2.9-1.7 5.7-2.1 8.5-1.3v-14ZM12 6.8V21',
                                'trainers' => 'M12 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM5 21v-2a7 7 0 0 1 14 0v2M18 8.5h3m-1.5-1.5v3',
                                default => 'M12 21s7-3.8 7-10V5.5L12 3 5 5.5V11c0 6.2 7 10 7 10Zm-3-10 2 2 4-4',
                            };
                        @endphp
                        <article class="flex min-h-[66px] items-center justify-center gap-2.5 px-2 py-2 sm:min-h-[70px] lg:justify-start lg:px-3">
                            <span class="grid size-8 shrink-0 place-items-center text-[#16a467]">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="size-7" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.65">
                                    <path d="{{ $icon }}" />
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <strong class="block text-[13px] leading-4 font-black text-white sm:text-sm">{{ $value }}</strong>
                                <span class="block text-[8px] leading-3 font-semibold text-slate-300 sm:text-[9px]">{{ $label }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
            @endif

            <section id="courses" class="bg-stone-50 py-12 dark:bg-ink sm:py-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="section-heading-row flex items-start justify-between gap-4 sm:items-center">
                        <div>
                            <h2 class="text-lg font-black tracking-tight text-[#0b2447] sm:text-xl dark:text-white">Popular Courses</h2>
                            <span class="mt-2 block h-0.5 w-8 rounded-full bg-emerald-500"></span>
                        </div>
                        <a href="#courses" class="section-heading-link group inline-flex shrink-0 items-center gap-1.5 text-[10px] font-bold text-slate-700 transition hover:text-emerald-600 sm:gap-2 sm:text-[11px] dark:text-slate-300 dark:hover:text-emerald-400">
                            View All Courses
                            <svg viewBox="0 0 20 20" aria-hidden="true" class="size-4 text-emerald-500 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                                <path d="M4 10h12m-4-4 4 4-4 4" />
                            </svg>
                        </a>
                    </div>

                    <div class="mt-7" data-course-carousel data-course-interval="5000">
                        <div class="course-carousel-track flex gap-5 overflow-x-auto scroll-smooth" data-course-track tabindex="0" aria-label="Popular courses">
                        @forelse ($popularCourses as $course)
                            @php
                                $courseImages = ['images/bnyti-hero-premium-2.png', 'images/bnyti-hero-premium-1.png', 'images/bnyti-hero-premium-3.png', 'images/bnyti-hero-premium-1.png'];
                                $coursePositions = ['object-[68%_center]', 'object-[58%_center]', 'object-[52%_center]', 'object-[78%_center]'];
                                $courseBadges = ['bg-amber-400', 'bg-sky-500', 'bg-pink-500', 'bg-violet-600'];
                                $courseIcons = ['M13 2 6 13h5l-1 9 8-12h-5V2Z', 'M4 4h16v12H4V4Zm4 16h8m-4-4v4', 'M4 20l4.5-1 10-10a2.1 2.1 0 0 0-3-3l-10 10L4 20Zm10-13 3 3M4 20l1-4 3 3-4 1Z', 'M8 8 4 12l4 4m8-8 4 4-4 4m-2-11-4 18'];
                                $courseIndex = $loop->index % 4;
                                $courseImage = $course->image_path ? Storage::disk('public')->url($course->image_path) : asset($courseImages[$courseIndex]);
                            @endphp
                            <article class="course-carousel-slide group flex h-full w-full shrink-0 snap-start flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-[0_3px_12px_rgba(15,23,42,.08)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(15,23,42,.13)] dark:border-white/10 dark:bg-deep" data-course-slide>
                                <div class="relative aspect-video shrink-0 overflow-hidden bg-slate-100">
                                    <img
                                        src="{{ $courseImage }}"
                                        alt="{{ $course->name }} training"
                                        class="size-full object-cover {{ $coursePositions[$courseIndex] }} transition duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                    <span class="absolute bottom-0 left-4 grid size-9 translate-y-1/2 place-items-center rounded-lg {{ $courseBadges[$courseIndex] }} text-white shadow-lg ring-4 ring-white dark:ring-deep">
                                        <svg viewBox="0 0 24 24" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                                            <path d="{{ $courseIcons[$courseIndex] }}" />
                                        </svg>
                                    </span>
                                </div>

                                <div class="flex min-h-[174px] flex-1 flex-col px-4 pt-7 pb-4">
                                    <h3 class="line-clamp-2 min-h-10 text-sm leading-5 font-extrabold text-[#0b2447] dark:text-white">{{ $course->name }}</h3>
                                    <p class="mt-2 line-clamp-2 text-[11px] leading-4 text-slate-500 dark:text-slate-400">{{ $course->description }}</p>
                                    <dl class="mt-3 grid gap-1.5 text-[11px] font-medium text-slate-600 dark:text-slate-300">
                                        <div class="flex items-center gap-1.5">
                                            <dt class="sr-only">Duration</dt>
                                            <svg viewBox="0 0 20 20" aria-hidden="true" class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.5">
                                                <circle cx="10" cy="10" r="7" />
                                                <path d="M10 6v4l2.5 1.5" />
                                            </svg>
                                            <dd>{{ $course->duration }}</dd>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <dt class="sr-only">Course overview</dt>
                                            <span class="w-3.5 text-center font-black">৳</span>
                                            <dd class="line-clamp-1">{{ Str::limit($course->description, 48) }}</dd>
                                        </div>
                                    </dl>
                                </div>
                            </article>
                        @empty
                            <div class="w-full rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-10 text-center text-sm font-semibold text-slate-500 dark:border-white/15 dark:bg-deep dark:text-slate-300">
                                Course information will be available soon.
                            </div>
                        @endforelse
                        </div>
                        @if ($popularCourses->count() > 1)
                            <div class="course-carousel-controls mt-5 items-center justify-center gap-4" aria-label="Course carousel controls">
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-course-prev aria-label="Previous courses">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                                </button>
                                <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-course-current>1</span> of <span data-course-total>1</span></p>
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-course-next aria-label="Next courses">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section id="expert-teachers" class="bg-stone-50 pb-12 dark:bg-ink sm:pb-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="section-heading-row flex items-start justify-between gap-4 sm:items-center">
                        <div>
                            <h2 class="text-lg font-black tracking-tight text-[#0b2447] sm:text-xl dark:text-white">Our Expert Teachers</h2>
                            <span class="mt-1 block h-0.5 w-6 rounded-full bg-emerald-500"></span>
                        </div>
                        <a href="#latest-news-contact" class="section-heading-link group inline-flex shrink-0 items-center gap-1.5 text-[10px] font-bold text-slate-700 transition hover:text-emerald-600 dark:text-slate-300 dark:hover:text-emerald-400">
                            View All Teachers
                            <svg viewBox="0 0 20 20" aria-hidden="true" class="size-3.5 text-emerald-500 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                                <path d="M4 10h12m-4-4 4 4-4 4" />
                            </svg>
                        </a>
                    </div>

                    <div class="mt-5" data-teacher-carousel data-teacher-interval="5000">
                    <div class="teacher-carousel-track flex gap-5 overflow-x-auto scroll-smooth" data-teacher-track tabindex="0" aria-label="Teacher profiles">
                        @foreach ($teacherCards as $teacher)
                            <article class="teacher-carousel-slide group flex h-full w-full shrink-0 snap-start flex-col overflow-hidden rounded-xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-deep" data-teacher-slide>
                                <div class="relative aspect-[4/4.6] shrink-0 overflow-hidden bg-[#2699e8]">
                                    @if ($teacher['image_path'])
                                        <img
                                            src="{{ Storage::url($teacher['image_path']) }}"
                                            alt="{{ $teacher['name'] }}"
                                            class="size-full object-cover object-top transition duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        >
                                    @else
                                        <div
                                            role="img"
                                            aria-label="{{ $teacher['name'] }}"
                                            class="size-full bg-no-repeat transition duration-500 group-hover:scale-105"
                                            style="background-image: url('{{ asset('images/expert-teachers-sprite-v2.png') }}'); background-size: 600% auto; background-position: {{ $loop->index * 20 }}% 52%;"
                                        ></div>
                                    @endif
                                </div>

                                <div class="flex flex-1 flex-col items-center px-4 py-4 text-center">
                                    <h3 class="line-clamp-2 text-sm leading-5 font-black text-slate-950 dark:text-white">{{ $teacher['name'] }}</h3>
                                    <p class="mt-1 truncate text-[11px] font-bold text-emerald-700 dark:text-emerald-400">{{ $teacher['department'] }}</p>
                                    <span class="mt-3 inline-flex max-w-full rounded-full bg-emerald-600 px-3 py-1.5 text-[9px] leading-none font-bold text-white shadow-sm">
                                        {{ $teacher['designation'] }}
                                    </span>
                                    @if ($teacher['id'])
                                        <a href="{{ route('teachers.show', $teacher['id']) }}" class="mt-3 inline-flex items-center justify-center gap-1 rounded-full border border-emerald-200 px-3 py-2 text-[11px] font-black text-emerald-700 transition hover:border-emerald-400 hover:bg-emerald-50 dark:border-emerald-400/30 dark:text-emerald-300 dark:hover:bg-emerald-400/10">
                                            আরও পড়ুন... <span aria-hidden="true" class="text-sm">→</span>
                                        </a>
                                    @else
                                        <details class="mt-3 w-full text-left">
                                            <summary class="flex cursor-pointer list-none items-center justify-center gap-1 rounded-full border border-emerald-200 px-3 py-2 text-[11px] font-black text-emerald-700 transition hover:border-emerald-400 hover:bg-emerald-50 dark:border-emerald-400/30 dark:text-emerald-300 dark:hover:bg-emerald-400/10">
                                                আরও পড়ুন... <span aria-hidden="true" class="text-sm">→</span>
                                            </summary>
                                            <p class="mt-3 rounded-xl bg-slate-50 px-3 py-3 text-left text-[11px] leading-5 text-slate-600 dark:bg-white/5 dark:text-slate-300">
                                                {{ $teacher['description'] ?: 'Our instructor brings practical guidance and industry-focused experience to every class.' }}
                                            </p>
                                        </details>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                    @if ($teacherCards->count() > 1)
                        <div class="teacher-carousel-controls mt-5 items-center justify-center gap-4" aria-label="Teacher carousel controls">
                            <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-teacher-prev aria-label="Previous teacher page">
                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                            </button>
                            <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-teacher-current>1</span> of <span data-teacher-total>1</span></p>
                            <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-teacher-next aria-label="Next teacher page">
                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                            </button>
                        </div>
                    @endif
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

            <section id="institute-gallery" class="bg-stone-50 pb-12 dark:bg-ink sm:pb-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="section-heading-row flex items-start justify-between gap-4 sm:items-center">
                        <div>
                            <h2 class="text-lg font-black tracking-tight text-[#0b2447] sm:text-xl dark:text-white">Institute Gallery</h2>
                            <span class="mt-1 block h-0.5 w-6 rounded-full bg-emerald-500"></span>
                        </div>
                        <a href="#institute-gallery" class="section-heading-link group inline-flex shrink-0 items-center gap-1.5 text-[10px] font-bold text-slate-700 transition hover:text-emerald-600 dark:text-slate-300 dark:hover:text-emerald-400">
                            View All Gallery
                            <svg viewBox="0 0 20 20" aria-hidden="true" class="size-3.5 text-emerald-500 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                                <path d="M4 10h12m-4-4 4 4-4 4" />
                            </svg>
                        </a>
                    </div>

                    @php
                        $galleryItems = $homepageItems('gallery');
                    @endphp
                    <div class="mt-4" data-gallery-carousel data-gallery-interval="5000">
                        <div class="gallery-carousel-track flex gap-3 overflow-x-auto scroll-smooth" data-gallery-track tabindex="0" aria-label="Institute gallery">
                        @foreach ($galleryItems as $item)
                            @php
                                $label = $item->title;
                                $image = $item->image_path ?: 'images/institute-gallery-1.png';
                                $panel = $item->metadata['panel'] ?? 0;
                            @endphp
                            <figure class="gallery-carousel-slide group min-w-0 shrink-0 snap-start" data-gallery-slide>
                                <div
                                    role="img"
                                    aria-label="{{ $label }}"
                                    class="aspect-5/4 overflow-hidden rounded-xl bg-slate-200 bg-no-repeat shadow-[0_3px_10px_rgba(15,23,42,.10)] ring-1 ring-slate-900/5 transition duration-300 group-hover:-translate-y-1 group-hover:shadow-lg dark:bg-slate-800 dark:ring-white/10"
                                    style="background-image: url('{{ asset($image) }}'); background-size: 400% auto; background-position: {{ $panel * 33.333 }}% 50%;"
                                ></div>
                                <figcaption class="mt-2 truncate text-center text-[9px] font-bold text-slate-700 dark:text-slate-300">{{ $label }}</figcaption>
                            </figure>
                        @endforeach
                        </div>
                        @if ($galleryItems->count() > 1)
                            <div class="gallery-carousel-controls mt-5 items-center justify-center gap-4" aria-label="Institute gallery controls">
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-gallery-prev aria-label="Previous gallery images">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                                </button>
                                <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-gallery-current>1</span> of <span data-gallery-total>1</span></p>
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-gallery-next aria-label="Next gallery images">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section id="student-success-stories" class="bg-stone-50 pb-12 dark:bg-ink sm:pb-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div>
                        <h2 class="text-lg font-black tracking-tight text-[#0b2447] sm:text-xl dark:text-white">Student Success Stories</h2>
                        <span class="mt-1.5 block h-0.5 w-8 rounded-full bg-emerald-500"></span>
                    </div>

                    @php
                        $studentStories = $homepageItems('testimonials');
                    @endphp
                    <div class="mt-5" data-student-carousel data-student-interval="5000">
                        <div class="student-carousel-track flex gap-5 overflow-x-auto scroll-smooth" data-student-track tabindex="0" aria-label="Student success stories">
                        @foreach ($studentStories as $item)
                            @php
                                $quote = $item->body;
                                $name = $item->title;
                                $position = $item->subtitle;
                            @endphp
                            <article class="student-carousel-slide relative flex h-full w-full shrink-0 snap-start flex-col overflow-hidden rounded-2xl border border-slate-100 bg-white px-5 py-5 shadow-[0_7px_24px_rgba(15,23,42,.07)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_16px_35px_rgba(15,23,42,.12)] dark:border-white/10 dark:bg-deep" data-student-slide>
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="size-7 text-emerald-600 dark:text-emerald-400" fill="currentColor">
                                    <path d="M9.2 6.4C6.2 7.8 4.5 10 4.2 13H8v5H3.1v-3.3c0-4.3 2-7.5 6.1-9.5v1.2Zm10 0c-3 1.4-4.7 3.6-5 6.6H18v5h-4.9v-3.3c0-4.3 2-7.5 6.1-9.5v1.2Z" />
                                </svg>

                                <div class="mt-1 flex flex-1 items-start gap-3">
                                    <div
                                        role="img"
                                        aria-label="{{ $name }}"
                                        class="size-14 shrink-0 rounded-full bg-slate-100 bg-no-repeat ring-2 ring-white shadow-md dark:bg-slate-800 dark:ring-deep"
                                        style="background-image: url('{{ asset('images/student-success-sprite.png') }}'); background-size: 400% auto; background-position: {{ $loop->index * 33.333 }}% 30%;"
                                    ></div>
                                    <p class="text-[11px] leading-5 font-medium text-slate-700 dark:text-slate-300">{{ $quote }}</p>
                                </div>

                                <div class="mt-4 border-t border-slate-100 pt-3 dark:border-white/10">
                                    <p class="text-[11px] font-black text-[#0b2447] dark:text-white">— {{ $name }}</p>
                                    <p class="mt-0.5 truncate text-[9px] font-medium text-slate-500 dark:text-slate-400">{{ $position }}</p>
                                    <div class="mt-2 flex gap-0.5 text-amber-400" aria-label="5 out of 5 stars">
                                        @for ($star = 0; $star < 5; $star++)
                                            <svg viewBox="0 0 20 20" aria-hidden="true" class="size-3.5" fill="currentColor">
                                                <path d="m10 1.8 2.4 4.9 5.4.8-3.9 3.8.9 5.4-4.8-2.6-4.8 2.6.9-5.4-3.9-3.8 5.4-.8L10 1.8Z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                            </article>
                        @endforeach
                        </div>
                        @if ($studentStories->count() > 1)
                            <div class="student-carousel-controls mt-5 items-center justify-center gap-4" aria-label="Student story carousel controls">
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-student-prev aria-label="Previous student stories">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                                </button>
                                <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-student-current>1</span> of <span data-student-total>1</span></p>
                                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-student-next aria-label="Next student stories">
                                    <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <section id="latest-news-contact" class="bg-stone-50 pb-12 dark:bg-ink sm:pb-16">
                <div class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6 lg:grid-cols-[1.65fr_.85fr] lg:px-8">
                    <div class="min-w-0 rounded-2xl border border-slate-100 bg-white p-5 shadow-[0_7px_24px_rgba(15,23,42,.06)] dark:border-white/10 dark:bg-deep">
                        <div class="section-heading-row flex items-start justify-between gap-4 sm:items-center">
                            <div>
                                <h2 class="text-lg font-black tracking-tight text-[#0b2447] sm:text-xl dark:text-white">Latest News &amp; Updates</h2>
                                <span class="mt-1 block h-0.5 w-6 rounded-full bg-emerald-500"></span>
                            </div>
                            <a href="{{ route('news.index') }}" class="section-heading-link group inline-flex shrink-0 items-center gap-1.5 text-[10px] font-bold text-slate-700 transition hover:text-emerald-600 dark:text-slate-300 dark:hover:text-emerald-400">
                                View All News
                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-3.5 text-emerald-500 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                                    <path d="M4 10h12m-4-4 4 4-4 4" />
                                </svg>
                            </a>
                        </div>

                        @php
                            $newsCards = ($latestNews ?? collect())->isNotEmpty() ? $latestNews : collect([
                                ['Admission Open', 'New batch admission is going on.', '26 May, 2026', 'emerald', 'megaphone', null, null],
                                ['Exam Notice', 'Final exam routine has been published.', '24 May, 2026', 'blue', 'document', null, null],
                                ['Result Published', 'Check your latest online result.', '23 May, 2026', 'rose', 'clipboard', null, null],
                                ['Workshop', 'Web Development Workshop held.', '20 May, 2026', 'sky', 'workshop', null, null],
                            ]);
                        @endphp

                        <div class="mt-4 min-w-0" data-news-carousel data-news-interval="5000">
                            <div class="overflow-hidden" data-news-viewport>
                            <div class="news-carousel-track flex w-full min-w-0 gap-3" data-news-track tabindex="0" aria-label="Latest news and updates">
                            @foreach ($newsCards as [$title, $description, $date, $tone, $icon, $imagePath, $slug])
                                <a href="{{ $slug ? route('news.show', $slug) : route('news.index') }}" class="news-carousel-slide group flex h-full w-full shrink-0 snap-start flex-col overflow-hidden rounded-xl bg-slate-50 ring-1 ring-slate-900/5 transition hover:-translate-y-0.5 hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 dark:bg-slate-900/40 dark:ring-white/10" data-news-slide>
                                    @if ($imagePath)
                                        <img src="{{ str_starts_with($imagePath, 'images/') ? asset($imagePath) : Storage::disk('public')->url($imagePath) }}" alt="" class="h-24 w-full object-cover">
                                    @else
                                    <span @class([
                                        'grid size-9 shrink-0 place-items-center rounded-lg',
                                        'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400' => $tone === 'emerald',
                                        'bg-blue-100 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400' => $tone === 'blue',
                                        'bg-rose-100 text-rose-600 dark:bg-rose-500/15 dark:text-rose-400' => $tone === 'rose',
                                        'bg-sky-100 text-sky-600 dark:bg-sky-500/15 dark:text-sky-400' => $tone === 'sky',
                                    ])>
                                        <svg viewBox="0 0 24 24" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8">
                                            @if ($icon === 'megaphone')
                                                <path d="m4 13 13-5v8L4 11v2Zm4 1 2 6h3l-1.5-5M20 10v4" />
                                            @elseif ($icon === 'document')
                                                <path d="M6 3h8l4 4v14H6V3Zm8 0v5h5M9 12h6m-6 4h6" />
                                            @elseif ($icon === 'clipboard')
                                                <path d="M8 5H5v16h14V5h-3M9 3h6v4H9V3Zm0 9 2 2 4-4m-6 8h6" />
                                            @else
                                                <path d="M4 5h16v14H4V5Zm4-2v4m8-4v4M7 11h3v3H7v-3Zm7 0h3m-3 4h3" />
                                            @endif
                                        </svg>
                                    </span>
                                    @endif
                                    <div class="min-w-0 flex-1 px-3 py-3">
                                        <h3 class="truncate text-[10px] font-black text-[#0b2447] dark:text-white">{{ $title }} <span class="text-emerald-500">•</span></h3>
                                        <p class="mt-1 line-clamp-2 text-[10px] leading-4 text-slate-500 dark:text-slate-400">{{ $description }}</p>
                                        <time class="mt-2 block text-[10px] font-bold text-slate-400">{{ $date }}</time>
                                    </div>
                                </a>
                            @endforeach
                            </div>
                            </div>
                            @if ($newsCards->count() > 1)
                                <div class="news-carousel-controls mt-5 items-center justify-center gap-4" aria-label="News carousel controls">
                                    <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-news-prev aria-label="Previous news page">
                                        <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                                    </button>
                                    <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-news-current>1</span> of <span data-news-total>1</span></p>
                                    <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-emerald-500 hover:text-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-200 disabled:cursor-not-allowed disabled:opacity-40 dark:border-white/15 dark:bg-deep dark:text-white" data-news-next aria-label="Next news page">
                                        <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                    <aside class="contact-card grid min-w-0 overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-[0_7px_24px_rgba(15,23,42,.06)] sm:grid-cols-[1fr_1.1fr] lg:grid-cols-1 xl:grid-cols-[.95fr_1.05fr] dark:border-white/10 dark:bg-deep" data-contact-card>
                        <div class="min-w-0 p-5 sm:p-6">
                            <h2 class="text-lg font-black tracking-tight text-[#0b2447] sm:text-xl dark:text-white">Contact Us</h2>
                            <p class="mt-2 text-xs leading-5 text-slate-500 dark:text-slate-400">Call, email, or visit our institute for admission and course information.</p>
                            <div class="mt-5 grid gap-2.5 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                <a href="tel:+8809696481628" class="contact-method">
                                    <span class="contact-method-icon"><svg viewBox="0 0 20 20" aria-hidden="true" class="size-4" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M5 3h3l1 4-2 1c1 2.5 2.5 4 5 5l1-2 4 1v3c0 1.1-.9 2-2 2C8.4 17 3 11.6 3 5a2 2 0 0 1 2-2Z" /></svg></span>
                                    <span class="min-w-0 break-words">{{ $contactSettings?->metadata['phone'] ?? '+880 9696-481628' }}</span>
                                </a>
                                <a href="mailto:bnyti-edubd@gmail.com" class="contact-method">
                                    <span class="contact-method-icon"><svg viewBox="0 0 20 20" aria-hidden="true" class="size-4" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M3 5h14v10H3V5Zm0 1 7 5 7-5" /></svg></span>
                                    <span class="min-w-0 [overflow-wrap:anywhere]">{{ $contactSettings?->metadata['email'] ?? 'bnyti-edubd@gmail.com' }}</span>
                                </a>
                                <p class="contact-method">
                                    <span class="contact-method-icon"><svg viewBox="0 0 20 20" aria-hidden="true" class="size-4" fill="none" stroke="currentColor" stroke-width="1.7"><path d="M10 18s6-5 6-10A6 6 0 1 0 4 8c0 5 6 10 6 10Zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" /></svg></span>
                                    <span class="min-w-0 break-words">{{ $contactSettings?->metadata['address'] ?? 'Haji Hossain Plaza, Demra Bazar Road, Dhaka-1360' }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="relative min-h-52 overflow-hidden bg-[#e7eadf] sm:min-h-full lg:min-h-52 xl:min-h-full" aria-label="Institute location map">
                            <svg viewBox="0 0 240 180" aria-hidden="true" class="absolute inset-0 size-full">
                                <rect width="240" height="180" fill="#e4e8dd" />
                                <path d="M-20 31 260 150M-10 132 180-15M50 195 250 32M-20 86 260 96" stroke="white" stroke-width="9" />
                                <path d="M-20 31 260 150M-10 132 180-15M50 195 250 32M-20 86 260 96" stroke="#d1d8ca" stroke-width="1.5" />
                                <path d="M146 48c-10 0-18 8-18 18 0 14 18 32 18 32s18-18 18-32c0-10-8-18-18-18Z" fill="#ef4444" />
                                <circle cx="146" cy="66" r="6" fill="white" />
                            </svg>
                            <div class="absolute inset-x-3 bottom-3 grid grid-cols-2 gap-2 sm:inset-x-4 sm:bottom-4">
                                <a href="tel:+8809696481628" class="contact-action bg-[#0b2447] hover:bg-slate-800">Call now</a>
                                <a href="https://maps.google.com/?q=Haji+Hossain+Plaza+Demra+Dhaka" target="_blank" rel="noopener noreferrer" class="contact-action bg-emerald-600 hover:bg-emerald-500">Directions</a>
                            </div>
                        </div>
                    </aside>
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

                        <a href="#latest-news-contact" class="mt-7 inline-flex min-h-11 items-center justify-center bg-slate-950 px-6 text-sm font-black tracking-wide text-white uppercase transition hover:bg-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-200 dark:bg-emerald-500 dark:text-ink dark:hover:bg-emerald-400">
                            Read more
                        </a>
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

        <footer class="public-page-footer bg-[#031735] text-white">
            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-12 lg:px-8">
                <div class="grid min-w-0 gap-10 xl:grid-cols-[1.15fr_2.25fr_1.4fr] xl:items-start xl:gap-12">
                    <div class="min-w-0">
                        <a href="#home" class="inline-flex items-center gap-3" aria-label="BNYTI home">
                            <img
                                src="{{ asset('images/bnyti-logo.svg') }}"
                                alt=""
                                class="brand-logo size-14 shrink-0"
                            >
                            <span class="text-xl leading-none font-black tracking-wide">
                                BNYTI
                                <span class="mt-1 block text-[8px] leading-tight font-bold tracking-[0.08em] text-slate-300">
                                    BANGLADESH NATIONAL<br>YOUTH TECHNICAL INSTITUTE
                                </span>
                            </span>
                        </a>
                        <p class="mt-4 text-xs font-semibold text-slate-300">{{ $footerSettings?->body ?? 'Skills Today, Success Tomorrow' }}</p>
                        <div class="mt-5 flex flex-wrap items-center gap-3">
                            <a href="#" class="footer-social bg-[#1877f2]" aria-label="Follow BNYTI on Facebook">
                                <svg viewBox="0 0 24 24" class="size-4 fill-current" aria-hidden="true">
                                    <path d="M13.5 21v-8h2.8l.4-3.1h-3.2V8c0-.9.3-1.5 1.6-1.5h1.7V3.7c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2H7.3V13h2.8v8h3.4Z"/>
                                </svg>
                            </a>
                            <a href="#" class="footer-social bg-[#ff0033]" aria-label="Subscribe to BNYTI on YouTube">
                                <svg viewBox="0 0 24 24" class="size-4 fill-current" aria-hidden="true">
                                    <path d="M21.6 7.2a2.8 2.8 0 0 0-2-2C17.8 4.7 12 4.7 12 4.7s-5.8 0-7.6.5a2.8 2.8 0 0 0-2 2A29 29 0 0 0 2 12a29 29 0 0 0 .4 4.8 2.8 2.8 0 0 0 2 2c1.8.5 7.6.5 7.6.5s5.8 0 7.6-.5a2.8 2.8 0 0 0 2-2A29 29 0 0 0 22 12a29 29 0 0 0-.4-4.8ZM10 15.2V8.8l5.5 3.2-5.5 3.2Z"/>
                                </svg>
                            </a>
                            <a href="#" class="footer-social bg-[#0a66c2]" aria-label="Follow BNYTI on LinkedIn">
                                <svg viewBox="0 0 24 24" class="size-4 fill-current" aria-hidden="true">
                                    <path d="M6.5 8.2H3.2V21h3.3V8.2ZM4.9 3A1.9 1.9 0 1 0 5 6.8 1.9 1.9 0 0 0 5 3Zm5 5.2V21h3.3v-6.3c0-1.7.3-3.3 2.4-3.3s2.1 1.9 2.1 3.4V21H21v-7c0-3.4-.7-6.1-4.8-6.1a4.2 4.2 0 0 0-3.8 2.1h-.1V8.2H10Z"/>
                                </svg>
                            </a>
                            <a href="#" class="footer-social bg-gradient-to-br from-[#7c3aed] via-[#ec4899] to-[#f59e0b]" aria-label="Follow BNYTI on Instagram">
                                <svg viewBox="0 0 24 24" class="size-4 fill-none stroke-current" aria-hidden="true">
                                    <rect x="3.5" y="3.5" width="17" height="17" rx="5" stroke-width="2"/>
                                    <circle cx="12" cy="12" r="4" stroke-width="2"/>
                                    <circle cx="17.5" cy="6.5" r="1" class="fill-current stroke-none"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="grid min-w-0 grid-cols-2 gap-x-6 gap-y-10 sm:grid-cols-3" data-footer-navigation>
                    <nav class="min-w-0" aria-label="Quick links">
                        <h3 class="text-sm font-bold">Quick Links</h3>
                        <div class="mt-4 grid gap-2 text-xs text-slate-300">
                            <a href="#home" class="footer-link">Home</a>
                            <a href="#about" class="footer-link">About Us</a>
                            <a href="#courses" class="footer-link">Courses</a>
                            <a href="#branch-application-promo" class="footer-link">Branches</a>
                            <a href="{{ route('login') }}" class="footer-link">Staff Login</a>
                            <a href="#latest-news-contact" class="footer-link">Contact Us</a>
                        </div>
                    </nav>

                    <nav class="min-w-0" aria-label="Student zone">
                        <h3 class="text-sm font-bold">Student Zone</h3>
                        <div class="mt-4 grid gap-2 text-xs text-slate-300">
                            <a href="{{ route('login') }}" class="footer-link">Student Portal</a>
                            <a href="{{ route('login') }}" class="footer-link">Admit Card</a>
                            <a href="{{ route('results.index') }}" class="footer-link">Results</a>
                            <a href="#latest-news-contact" class="footer-link">Certificate Verification</a>
                            <a href="#latest-news-contact" class="footer-link">Notice Board</a>
                        </div>
                    </nav>

                    <nav class="col-span-2 min-w-0 sm:col-span-1" aria-label="Resources">
                        <h3 class="text-sm font-bold">Resources</h3>
                        <div class="mt-4 grid gap-2 text-xs text-slate-300">
                            <a href="#" class="footer-link">FAQs</a>
                            <a href="#" class="footer-link">Privacy Policy</a>
                            <a href="#" class="footer-link">Terms &amp; Conditions</a>
                            <a href="#" class="footer-link">Download Prospectus</a>
                            <a href="#" class="footer-link">Sitemap</a>
                        </div>
                    </nav>
                    </div>

                    <div class="min-w-0">
                        <h3 class="text-sm font-bold">Newsletter</h3>
                        <p class="mt-4 max-w-sm text-xs leading-5 text-slate-300">
                            Subscribe to get the latest updates<br class="hidden lg:block"> and news.
                        </p>
                        <form class="mt-4 flex max-w-md flex-col gap-2 rounded-2xl border border-white/15 bg-white/5 p-2 min-[380px]:flex-row min-[380px]:rounded-full" data-footer-newsletter onsubmit="return false;">
                            <label for="footer-email" class="sr-only">Enter your email</label>
                            <input
                                id="footer-email"
                                type="email"
                                name="email"
                                placeholder="Enter your email"
                                autocomplete="email"
                                class="min-h-11 min-w-0 flex-1 border-0 bg-transparent px-3 text-sm text-white outline-none placeholder:text-slate-500 focus:ring-0"
                            >
                            <button type="submit" class="min-h-11 shrink-0 rounded-xl bg-emerald-500 px-5 py-2 text-sm font-bold text-white transition hover:bg-emerald-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-400 min-[380px]:rounded-full">
                                Subscribe
                            </button>
                        </form>
                        <p class="mt-5 text-xs text-slate-400">
                            Made with <span class="text-red-400" aria-label="love">♥</span> for Youth Empowerment
                        </p>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10">
                <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-center text-xs leading-5 text-slate-400 sm:px-6 md:flex-row md:items-center md:justify-between md:text-left lg:px-8">
                    <p>© {{ date('Y') }} Bangladesh National Youth Technical Institute. All rights reserved.</p>
                    <p>{{ $footerSettings?->body ?? 'Skills Today, Success Tomorrow' }}</p>
                </div>
            </div>
        </footer>
    </body>
</html>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, viewport-fit=cover">
        <meta name="theme-color" content="#071c2c">
        <meta
            name="description"
            content="South Asia Engineering & Technical Institute provides practical, industry-focused technical education for a skilled future."
        >

        <title>{{ config('app.name') }}</title>
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
    <body class="overflow-x-hidden bg-[#e7f3f9] text-slate-900 antialiased transition-colors duration-300 dark:bg-ink dark:text-white">
        <a
            href="#main-content"
            class="fixed top-3 left-3 z-[100] -translate-y-20 rounded-full bg-[#03224c] px-5 py-3 text-sm font-bold text-white transition focus:translate-y-0"
            data-i18n="skip"
        >
            Skip to content
        </a>

        <header class="fixed inset-x-0 top-0 z-50 border-b border-slate-200 bg-white shadow-sm dark:border-white/10 dark:bg-ink">
             <div class="mx-auto flex h-16 sm:h-20 max-w-7xl items-center justify-between px-3 sm:px-6 lg:px-8">
                <a href="#home" class="group flex items-center gap-2 sm:gap-3 min-w-0">
                    <img
                        src="{{ asset('images/Logo.png') }}"
                        alt="Logo"
                        class="h-9 w-auto shrink-0 sm:h-12"
                    >
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
                    <div class="flex items-center gap-7">
                        <a href="#home" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Home</a>
                        <a href="#courses" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Course List</a>
                        <a href="{{ route('public.verified-branches') }}" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Verified Branches</a>
                        <a href="{{ route('results.index') }}" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Result Search</a>
                        <a href="#about" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">About</a>
                        <a href="{{ route('support.index') }}" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Support Team</a>
                        <a href="#contact" class="text-xs font-bold text-white uppercase tracking-widest transition hover:text-amber-400">Contact</a>
                    </div>
                    <a href="{{ route('login') }}" class="rounded bg-amber-500 px-6 py-1.5 text-xs font-black text-[#03224c] uppercase transition hover:bg-amber-400">
                        Login
                    </a>
                </div>
            </nav>
        </header>

        <div class="mobile-menu-overlay lg:hidden" data-menu-overlay aria-hidden="true"></div>
        <aside id="mobile-menu" class="mobile-menu-drawer lg:hidden" data-mobile-menu aria-hidden="true" aria-label="Mobile navigation" inert>
                <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4 dark:border-white/10">
                    <a href="#home" class="flex min-w-0 items-center gap-2.5" aria-label="South Asia Engineering & Technical Institute home">
                        <img src="{{ asset('images/Logo.png') }}" alt="" class="size-10 shrink-0 object-contain">
                        <span class="flex flex-col min-w-0">
                            <span class="block font-black text-slate-950 dark:text-white text-base uppercase leading-tight">South Asia</span>
                            <span class="block text-[9px] font-bold tracking-[0.03em] text-slate-500 dark:text-slate-300 uppercase mt-0.5 whitespace-nowrap overflow-hidden text-ellipsis">Engineering & Technical Institute</span>
                        </span>
                    </a>
                    <button type="button" class="icon-button" data-menu-dismiss aria-label="Close navigation"><svg viewBox="0 0 24 24" aria-hidden="true" class="size-6"><path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg></button>
                </div>

                <div class="mobile-menu-content">
                    <nav aria-label="Mobile primary navigation">
                        <p class="mobile-menu-label">Explore</p>
                        <div class="space-y-1">
                            <a href="#home" class="mobile-nav-link active" data-mobile-nav-link><span class="mobile-nav-icon">H</span><span>Home</span></a>
                            <a href="#courses" class="mobile-nav-link" data-mobile-nav-link><span class="mobile-nav-icon">C</span><span>Course List</span></a>
                            <a href="{{ route('public.verified-branches') }}" class="mobile-nav-link"><span class="mobile-nav-icon">B</span><span>Verified Branches</span></a>
                            <a href="{{ route('results.index') }}" class="mobile-nav-link"><span class="mobile-nav-icon">R</span><span>Result Search</span></a>
                            <a href="#about" class="mobile-nav-link" data-mobile-nav-link><span class="mobile-nav-icon">A</span><span>About</span></a>
                        </div>

                        <p class="mobile-menu-label mt-6">Services & account</p>
                        <div class="space-y-1">
                            <a href="{{ route('login') }}" class="mobile-nav-link"><span class="mobile-nav-icon">L</span><span>Login</span></a>
                            <a href="#contact" class="mobile-nav-link" data-mobile-nav-link><span class="mobile-nav-icon">C</span><span>Contact</span></a>
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
                    @php
                        $heroFallback = asset('images/bnyti-hero-premium-' . (($loop->index % 3) + 1) . '.png');
                        if ($hero->image_path) {
                            if (str_starts_with($hero->image_path, 'http://') || str_starts_with($hero->image_path, 'https://')) {
                                $heroSrc = $hero->image_path;
                            } elseif (str_starts_with($hero->image_path, 'images/')) {
                                $heroSrc = asset($hero->image_path);
                            } else {
                                $heroSrc = asset('storage/' . $hero->image_path);
                            }
                        } else {
                            $heroSrc = $heroFallback;
                        }
                    @endphp
                    <img
                        src="{{ $heroSrc }}"
                        alt="{{ $hero->title }}"
                        class="hero-carousel-image absolute inset-0 size-full object-cover object-center opacity-0"
                        data-hero-image
                        onerror="this.onerror=null; this.src='{{ $heroFallback }}';"
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
                            <a href="{{ route('support.index') }}" class="rounded-md bg-amber-500 px-10 py-4 text-sm font-black text-[#03224c] uppercase tracking-wider shadow-2xl transition hover:bg-amber-400">
                                <span>Support Team</span>
                            </a>
                            <a href="/branch-application" class="rounded-md border-2 border-white px-10 py-4 text-sm font-black text-white uppercase tracking-wider transition hover:bg-white hover:text-[#03224c]">
                                <span>Branch Apply</span>
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

            <section id="notice-bar" class="border-b border-sky-900/10 bg-white dark:border-white/10 dark:bg-deep" aria-label="Institute notices">
                <div class="flex min-h-12 items-stretch overflow-hidden">
                    <div class="notice-label relative flex shrink-0 items-center gap-2 bg-[#03224c] py-3 pr-7 pl-4 text-[11px] font-black tracking-[0.2em] text-white sm:pl-8" aria-hidden="true">
                        <span class="size-2 rounded-full bg-white"></span>
                        <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-amber-300 opacity-75 motion-reduce:animate-none"></span><span class="relative inline-flex size-2 rounded-full bg-amber-300"></span></span>
                        <span>NOTICE</span>
                    </div>
                    <div class="min-w-0 flex-1 overflow-hidden py-3" aria-live="polite">
                        <div class="notice-track flex gap-12 whitespace-nowrap px-8 text-xs font-bold text-slate-700 motion-reduce:transform-none dark:text-slate-200">
                            @forelse ($noticeItems as $notice)
                                <a href="{{ $notice['link'] ?: '#notice-bar' }}" class="transition hover:text-sky-700 dark:hover:text-sky-400">{{ $notice['title'] }} <span class="mx-2 text-amber-500" aria-hidden="true">•</span> {{ $notice['message'] }}</a>
                            @empty
                                <span>Admission for the July 2026 session is now open <span class="mx-2 text-amber-500" aria-hidden="true">•</span> Branch applications are being accepted nationwide <span class="mx-2 text-amber-500" aria-hidden="true">•</span> Contact us for course counselling</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            @if ($isSectionVisible('trust'))
            @php
                $trustCards = [
                    [
                        'number' => '01',
                        'title' => 'Government Approved',
                        'subtitle' => 'RECOGNIZED BY THE GOVT. OF BANGLADESH',
                        'description' => 'Yes, it is a fully government-approved and recognized Institution committed to delivering exceptional academic standards.',
                        'link_url' => '#about',
                        'icon' => 'academic',
                    ],
                    [
                        'number' => '02',
                        'title' => 'Practical Lab Training',
                        'subtitle' => 'HANDS-ON TRAINING WITH MODERN TOOLS',
                        'description' => 'Equipped with advanced laboratories and modern Industry-grade instruments to ensure every student gains real practical mastery.',
                        'link_url' => '#courses',
                        'icon' => 'lab',
                    ],
                    [
                        'number' => '03',
                        'title' => 'Expert Trainers',
                        'subtitle' => 'EXPERIENCED & INDUSTRY-CERTIFIED INSTRUCTORS',
                        'description' => 'Learn directly from highly qualified, certified mentors with years of academic excellence and real-world engineering experience.',
                        'link_url' => '#support',
                        'icon' => 'instructor',
                    ],
                    [
                        'number' => '04',
                        'title' => 'Industry Partnership',
                        'subtitle' => 'COLLABORATION WITH LEADING INDUSTRIES',
                        'description' => 'Strong strategic partnerships with top national and international organizations to bridge academic learning with Industry demands.',
                        'link_url' => '#about',
                        'icon' => 'handshake',
                    ],
                    [
                        'number' => '05',
                        'title' => 'Online Verification',
                        'subtitle' => 'VERIFY YOUR CERTIFICATE ANYTIME, ANYWHERE',
                        'description' => 'Instant digital certificate and student record verification system accessible 24/7 from anywhere in the world with full authenticity.',
                        'link_url' => route('results.index'),
                        'icon' => 'verification',
                    ],
                    [
                        'number' => '06',
                        'title' => 'Career Support',
                        'subtitle' => 'INTERNSHIP, PLACEMENT & CAREER GUIDANCE',
                        'description' => 'Dedicated placement cell offering Internship opportunities, resume building, interview preparation, and direct job placement support.',
                        'link_url' => '#contact',
                        'icon' => 'briefcase',
                    ],
                ];

                $dbItems = $homepageItems('trust');
                if ($dbItems->isNotEmpty()) {
                    foreach ($dbItems->values() as $index => $item) {
                        if (isset($trustCards[$index])) {
                            if (! empty($item->title)) $trustCards[$index]['title'] = $item->title;
                            if (! empty($item->subtitle)) {
                                $trustCards[$index]['subtitle'] = mb_strtoupper($item->subtitle);
                            }
                            if (! empty($item->body)) {
                                if (strlen($item->body) > 60 || str_contains($item->body, '.')) {
                                    $trustCards[$index]['description'] = $item->body;
                                } else {
                                    $trustCards[$index]['subtitle'] = mb_strtoupper($item->body);
                                }
                            }
                        }
                    }
                }
            @endphp
            <section class="relative z-20 bg-[#f4f8fb] py-12 dark:bg-deep/80 sm:py-16 lg:py-20" aria-label="Why choose South Asia">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-10 text-center">
                        <span class="inline-flex items-center gap-2.5 rounded-full border border-slate-200/80 bg-white px-6 py-2.5 text-xs font-black uppercase tracking-widest text-slate-700 shadow-sm dark:border-white/10 dark:bg-slate-800 dark:text-slate-200">
                            <span class="size-2.5 rounded-full bg-[#03224c] dark:bg-amber-400"></span>
                            WELCOME TO OUR ACADEMIC EXCELLENCE
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 lg:gap-8">
                        @foreach ($trustCards as $card)
                            <article class="group relative flex flex-col justify-between rounded-3xl border border-slate-200/80 bg-white p-7 shadow-[0_4px_20px_rgba(15,23,42,0.03)] transition-all duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-white/10 dark:bg-slate-800/90 sm:p-8">
                                <div>
                                    <div class="mb-6 flex items-center justify-between">
                                        <div class="flex size-12 items-center justify-center rounded-2xl border border-sky-100/60 bg-sky-50 text-[#03224c] dark:border-sky-500/20 dark:bg-sky-500/10 dark:text-sky-400">
                                            @if ($card['icon'] === 'academic')
                                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                                                    <path d="M6 12v5c0 2 2 3 6 3s6-1 6-3v-5"/>
                                                </svg>
                                            @elseif ($card['icon'] === 'lab')
                                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M9 3h6m-3 0v6.5l4.5 7.5A2 2 0 0 1 14.8 20H9.2a2 2 0 0 1-1.7-3L12 9.5V3"/>
                                                </svg>
                                            @elseif ($card['icon'] === 'instructor')
                                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                            @elseif ($card['icon'] === 'handshake')
                                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                                                    <path d="M7 11.5l1.5-1.5a2 2 0 0 1 2.8 0l1.4 1.4a2 2 0 0 0 2.8 0l2.5-2.5"/>
                                                </svg>
                                            @elseif ($card['icon'] === 'verification')
                                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0 1 12 2.944a11.955 11.955 0 0 1-8.618 3.04A12.02 12.02 0 0 0 3 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                </svg>
                                            @else
                                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-black tracking-wide text-slate-500 dark:bg-slate-700/60 dark:text-slate-300">
                                            {{ $card['number'] }}
                                        </span>
                                    </div>

                                    <h3 class="mb-1.5 text-xl font-black leading-tight text-[#03224c] dark:text-white sm:text-2xl">
                                        {{ $card['title'] }}
                                    </h3>
                                    <p class="mb-4 text-[10px] font-black uppercase tracking-wider text-slate-500 dark:text-slate-400 sm:text-[11px]">
                                        {{ $card['subtitle'] }}
                                    </p>
                                    <p class="mb-6 text-xs font-medium leading-relaxed text-slate-600 dark:text-slate-300 sm:text-sm">
                                        {{ $card['description'] }}
                                    </p>
                                </div>

                                <a href="{{ $card['link_url'] }}" class="mt-auto inline-flex items-center gap-1.5 text-xs font-extrabold text-[#03224c] transition-colors group-hover:text-amber-500 dark:text-sky-400 dark:group-hover:text-amber-400">
                                    <span>Learn More</span>
                                    <svg class="size-3.5 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            @if ($isSectionVisible('about'))
            <section id="about" class="bg-[#e7f3f9] py-16 dark:bg-deep sm:py-20 lg:py-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="reveal mb-12 text-center text-3xl font-black uppercase tracking-tight text-[#03224c] dark:text-white sm:text-4xl">
                        ABOUT SOUTH ASIA ENGINEERING & TECHNICAL INSTITUTE
                    </h2>

                    @php
                        $about = $aboutEntries->first();
                        $aboutFallback = asset('images/bnyti-hero-premium-2.png');
                        if ($about?->image_path) {
                            if (str_starts_with($about->image_path, 'http://') || str_starts_with($about->image_path, 'https://')) {
                                $aboutSrc = $about->image_path;
                            } elseif (str_starts_with($about->image_path, 'images/')) {
                                $aboutSrc = asset($about->image_path);
                            } else {
                                $aboutSrc = asset('storage/' . $about->image_path);
                            }
                        } else {
                            $aboutSrc = $aboutFallback;
                        }
                    @endphp
                    <div class="grid items-center gap-10 lg:grid-cols-[1.1fr_1fr]">
                        <div class="reveal overflow-hidden rounded-2xl shadow-xl">
                            <img
                                src="{{ $aboutSrc }}"
                                alt="Institute Building"
                                class="w-full object-cover aspect-[4/3] lg:aspect-auto"
                                loading="lazy"
                                onerror="this.onerror=null; this.src='{{ $aboutFallback }}';"
                            >
                        </div>

                        <div class="reveal" style="--reveal-delay: 150ms">
                            <div class="min-w-0">
                                <p class="text-sm leading-relaxed text-slate-700 dark:text-slate-300">
                                    {{ $about?->content ?? "South Asia Engineering & Technical Institute is a renowned technical and skills development institution in Bangladesh, committed to empowering the nation's youth with industry-relevant knowledge, practical expertise, and modern technological skills." }}
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
                                                    <span class="size-2.5 shrink-0 rounded-full bg-[#03224c] dark:bg-amber-400"></span>
                                                    <span class="text-sm font-bold">{{ $item }}</span>
                                                </li>
                                            @endforeach
                                        </ul>

                                        <div class="shrink-0 w-full rounded-xl border-2 border-[#03224c]/30 bg-white/40 p-5 text-center sm:w-52 dark:border-white/10 dark:bg-white/5">
                                            <h4 class="border-b-2 border-[#03224c]/30 pb-2 text-lg font-black text-[#03224c] dark:text-amber-400 uppercase tracking-tighter">
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
            @php
                $statItems = $homepageItems('statistics');

                if ($statItems->isEmpty()) {
                    $realStudentCount = \App\Models\Student::count();
                    $realBranchCount = \App\Models\BranchApplication::query()->where('status', \App\Enums\BranchApplicationStatus::Approved)->count();
                    $realCourseCount = \App\Models\Course::query()->where('is_active', true)->count();
                    $realTeacherCount = \App\Models\Teacher::query()->where('is_active', true)->count();

                    $statItems = collect([
                        (object) [
                            'title' => ($realStudentCount > 0 ? number_format(max(20000, $realStudentCount)) . '+' : '20,000+'),
                            'subtitle' => 'STUDENTS ENROLLED',
                            'body' => 'STUDENTS ENROLLED'
                        ],
                        (object) [
                            'title' => ($realBranchCount > 0 ? max(250, $realBranchCount) . '+' : '250+'),
                            'subtitle' => 'BRANCHES ACROSS BD',
                            'body' => 'BRANCHES ACROSS BD'
                        ],
                        (object) [
                            'title' => ($realCourseCount > 0 ? max(80, $realCourseCount) . '+' : '80+'),
                            'subtitle' => 'COURSES OFFERED',
                            'body' => 'COURSES OFFERED'
                        ],
                        (object) [
                            'title' => ($realTeacherCount > 0 ? max(150, $realTeacherCount) . '+' : '150+'),
                            'subtitle' => 'EXPERT TRAINERS',
                            'body' => 'EXPERT TRAINERS'
                        ],
                    ]);
                }
            @endphp
            <section class="bg-[#03224c] py-20 dark:bg-deep" aria-label="BNYTI achievements">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-16 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-[0.25em] text-white sm:text-4xl">Our Achievements</h2>
                    </div>

                    <div class="grid grid-cols-2 justify-center gap-y-12 gap-x-8 md:grid-cols-4 lg:gap-16">
                        @foreach ($statItems->take(4) as $item)
                            @php
                                $borderColors = ['border-sky-400', 'border-amber-400', 'border-sky-400', 'border-amber-400'];
                                $borderColor = $borderColors[$loop->index % 4];
                            @endphp
                            <div class="flex flex-col items-center">
                                <div class="relative flex size-40 items-center justify-center rounded-full border-[6px] {{ $borderColor }} p-6 text-center transition-transform duration-300 hover:scale-105 sm:size-48 lg:size-52 shadow-2xl">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="text-2xl font-black text-white sm:text-3xl lg:text-4xl tracking-tight" data-stat-counter data-target-text="{{ $item->title }}">
                                            0
                                        </span>
                                        <span class="mt-2 max-w-[130px] text-[10px] font-extrabold leading-tight text-slate-200 uppercase tracking-widest sm:text-11px">
                                            {{ $item->subtitle ?: $item->body }}
                                        </span>
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


            <section id="courses" class="bg-[#e7f3f9] py-16 dark:bg-ink sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-2xl font-black uppercase tracking-[0.2em] text-slate-800 dark:text-white sm:text-3xl">Popular Courses</h2>
                    </div>

                    <div class="relative group" data-course-carousel data-course-interval="5000">
                        <!-- Navigation Arrows -->
                        <div class="hidden lg:block">
                            <button type="button" class="absolute -left-5 top-1/2 z-10 flex size-10 -translate-y-1/2 items-center justify-center rounded-full bg-white text-slate-400 shadow-lg border border-slate-50 transition hover:bg-[#03224c] hover:text-white focus:outline-none dark:bg-deep dark:border-white/10 dark:text-white/60" data-course-prev aria-label="Previous courses">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                            <button type="button" class="absolute -right-5 top-1/2 z-10 flex size-10 -translate-y-1/2 items-center justify-center rounded-full bg-white text-slate-400 shadow-lg border border-slate-50 transition hover:bg-[#03224c] hover:text-white focus:outline-none dark:bg-deep dark:border-white/10 dark:text-white/60" data-course-next aria-label="Next courses">
                                <svg viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </button>
                        </div>

                        <div class="course-carousel-track flex gap-6 overflow-x-auto scroll-smooth pb-8 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-course-track tabindex="0" aria-label="Popular courses">
                        @forelse ($popularCourses as $course)
                            @php
                                $courseImages = ['images/bnyti-hero-premium-2.png', 'images/bnyti-hero-premium-1.png', 'images/bnyti-hero-premium-3.png', 'images/bnyti-hero-premium-1.png'];
                                $coursePositions = ['object-center', 'object-center', 'object-center', 'object-center'];
                                $courseIndex = $loop->index % 4;
                                $fallbackCourseImage = asset($courseImages[$courseIndex]);

                                if ($course->image_path) {
                                    if (str_starts_with($course->image_path, 'http://') || str_starts_with($course->image_path, 'https://')) {
                                        $courseImage = $course->image_path;
                                    } elseif (str_starts_with($course->image_path, 'images/')) {
                                        $courseImage = asset($course->image_path);
                                    } else {
                                        $courseImage = asset('storage/' . $course->image_path);
                                    }
                                } else {
                                    $courseImage = $fallbackCourseImage;
                                }
                            @endphp
                            <article class="course-carousel-slide group flex w-[280px] shrink-0 snap-start flex-col rounded-[2rem] bg-white p-4 shadow-sm transition duration-300 hover:shadow-xl dark:bg-deep sm:w-[290px]" data-course-slide>
                                <div class="relative aspect-square shrink-0 overflow-hidden rounded-2xl bg-slate-100">
                                    <img
                                        src="{{ $courseImage }}"
                                        alt="{{ $course->name }}"
                                        class="size-full object-cover transition duration-500 group-hover:scale-105"
                                        loading="lazy"
                                        onerror="this.onerror=null; this.src='{{ $fallbackCourseImage }}';"
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
                                        <a href="#contact" class="block w-full rounded-xl bg-[#f5a623] py-3 text-center text-sm font-black text-white transition hover:bg-[#e69516]">
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
                            <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-[#03224c] hover:text-[#03224c] dark:border-white/15 dark:bg-deep dark:text-white" data-course-prev aria-label="Previous courses">
                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m12.5 15-5-5 5-5" /></svg>
                            </button>
                            <p class="min-w-24 text-center text-xs font-black text-slate-600 dark:text-slate-300" aria-live="polite">Page <span data-course-current>1</span> of <span data-course-total>1</span></p>
                            <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 bg-white text-slate-700 shadow-sm transition hover:border-[#03224c] hover:text-[#03224c] dark:border-white/15 dark:bg-deep dark:text-white" data-course-next aria-label="Next courses">
                                <svg viewBox="0 0 20 20" aria-hidden="true" class="size-5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="m7.5 5 5 5-5 5" /></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <section id="expert-teachers" class="bg-[#e7f3f9] py-16 dark:bg-[#0f172a] sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-2xl font-black uppercase tracking-wider text-slate-900 dark:text-white sm:text-3xl">Expert Teachers Gallery</h2>
                    </div>

                    <div class="relative group" data-teacher-carousel data-teacher-interval="5000">
                        <!-- Navigation Arrows -->
                        <div class="hidden lg:block">
                            <button type="button" class="absolute -left-6 top-[40%] z-10 flex size-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-slate-400 shadow-md backdrop-blur-sm transition hover:bg-white hover:text-slate-600 focus:outline-none dark:bg-slate-800 dark:text-white/60" data-teacher-prev aria-label="Previous teachers">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="size-5"><path d="m15 18-6-6 6-6" /></svg>
                            </button>
                            <button type="button" class="absolute -right-6 top-[40%] z-10 flex size-10 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-slate-400 shadow-md backdrop-blur-sm transition hover:bg-white hover:text-slate-600 focus:outline-none dark:bg-slate-800 dark:text-white/60" data-teacher-next aria-label="Next teachers">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="size-5"><path d="m9 18 6-6-6-6" /></svg>
                            </button>
                        </div>

                        <div class="teacher-carousel-track flex gap-5 overflow-x-auto scroll-smooth pb-10 [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-teacher-track tabindex="0" aria-label="Teacher profiles">
                            @foreach ($teacherCards as $teacher)
                                <article class="teacher-carousel-slide group flex w-[260px] shrink-0 snap-start flex-col overflow-hidden rounded-2xl bg-white p-3 shadow-[0_4px_20px_rgba(0,0,0,0.05)] transition duration-300 hover:shadow-xl dark:bg-slate-900 sm:w-[280px]" data-teacher-slide>
                                    <div class="relative aspect-[1/1.1] w-full overflow-hidden rounded-xl bg-slate-100">
                                        @if ($teacher['image_path'])
                                            @php
                                                $teacherFallback = asset('images/bnyti-hero-premium-1.png');
                                                if (str_starts_with($teacher['image_path'], 'http://') || str_starts_with($teacher['image_path'], 'https://')) {
                                                    $teacherSrc = $teacher['image_path'];
                                                } elseif (str_starts_with($teacher['image_path'], 'images/')) {
                                                    $teacherSrc = asset($teacher['image_path']);
                                                } else {
                                                    $teacherSrc = asset('storage/' . $teacher['image_path']);
                                                }
                                            @endphp
                                            <img
                                                src="{{ $teacherSrc }}"
                                                alt="{{ $teacher['name'] }}"
                                                class="size-full object-cover"
                                                loading="lazy"
                                                onerror="this.onerror=null; this.src='{{ $teacherFallback }}';"
                                            >
                                        @else
                                            <div
                                                role="img"
                                                aria-label="{{ $teacher['name'] }}"
                                                class="size-full bg-cover bg-center bg-no-repeat"
                                                style="background-image: url('{{ asset('images/expert-teachers-sprite-v2.png') }}'); background-size: 600% auto; background-position: {{ $loop->index * 20 }}% 52%;"
                                            ></div>
                                        @endif
                                    </div>

                                    <div class="flex flex-1 flex-col px-1 pt-4 pb-2">
                                        <h3 class="text-base font-black text-slate-900 dark:text-white">{{ $teacher['name'] }}</h3>
                                        <p class="mt-0.5 text-[10px] font-bold text-slate-500 uppercase tracking-tight">{{ $teacher['designation'] ?? $teacher['department'] }}</p>

                                        <p class="mt-3 line-clamp-3 text-[11px] font-medium leading-relaxed text-slate-600 dark:text-slate-400">
                                            Expert in {{ $teacher['department'] }} with over {{ $teacher['experience'] }} years of practical industry experience and academic excellence.
                                        </p>

                                        <div class="mt-4 flex gap-0.5 text-amber-400" aria-label="5 out of 5 stars">
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

                        <!-- Scroll Indicators -->
                        <div class="mt-2 flex items-center justify-center gap-2">
                            <span class="size-1.5 rounded-full bg-slate-300 dark:bg-white/10"></span>
                            <span class="size-1.5 rounded-full bg-slate-800 dark:bg-white"></span>
                            <span class="size-1.5 rounded-full bg-slate-300 dark:bg-white/10"></span>
                            <span class="size-1.5 rounded-full bg-slate-300 dark:bg-white/10"></span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- VERIFIED BRANCHES MOVED TO DEDICATED /verified-branches PAGE -->

            <!-- BRANCH APPLICATION PROMO MOVED OR HIDDEN AS REQUESTED -->

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
                                $galleryFallback = asset('images/institute-gallery-' . (($loop->index % 2) + 1) . '.png');
                                if ($item->image_path) {
                                    if (str_starts_with($item->image_path, 'http://') || str_starts_with($item->image_path, 'https://')) {
                                        $gallerySrc = $item->image_path;
                                    } elseif (str_starts_with($item->image_path, 'images/')) {
                                        $gallerySrc = asset($item->image_path);
                                    } else {
                                        $gallerySrc = asset('storage/' . $item->image_path);
                                    }
                                } else {
                                    $gallerySrc = $galleryFallback;
                                }
                            @endphp
                            <div class="gallery-carousel-slide aspect-[4/3] overflow-hidden rounded-lg bg-slate-800" data-gallery-slide>
                                <img
                                    src="{{ $gallerySrc }}"
                                    alt="{{ $item->title }}"
                                    class="size-full object-cover transition duration-500 hover:scale-110"
                                    loading="lazy"
                                    onerror="this.onerror=null; this.src='{{ $galleryFallback }}';"
                                >
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section id="student-success-stories" class="bg-[#e7f3f9] py-16 dark:bg-ink sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-tight text-[#0b2447] dark:text-white sm:text-4xl">Student Success Stories</h2>
                        <div class="mx-auto mt-2 h-1 w-16 rounded-full bg-amber-400"></div>
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
                                    <p class="mt-0.5 text-[11px] font-bold text-indigo-600 dark:text-cyan-400">{{ $position }}</p>

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

            <section id="update-notice-board" class="bg-[#e7f3f9] py-16 dark:bg-deep sm:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="mb-12 text-center">
                        <h2 class="text-3xl font-black uppercase tracking-tight text-[#0b2447] dark:text-white sm:text-4xl">Update Notice Board</h2>
                        <p class="mt-2 text-sm font-bold text-slate-600 dark:text-slate-400">Latest official announcements and academic updates from the institute.</p>
                    </div>

                    @php
                        $newsCards = ($latestNews ?? collect())->isNotEmpty() ? $latestNews : collect([
                            ['Admission Open', 'New batch admission is going on for the next session.', '26 May, 2026', 'emerald', 'megaphone', null, null],
                            ['Exam Notice', 'Final exam routine for 2026 has been published officially.', '24 May, 2026', 'blue', 'document', null, null],
                            ['Result Published', 'Check your latest online result from student portal.', '23 May, 2026', 'rose', 'clipboard', null, null],
                            ['Workshop', 'Special Web Development Workshop will be held soon.', '20 May, 2026', 'sky', 'workshop', null, null],
                        ]);
                    @endphp

                    <div class="grid items-start gap-8 lg:grid-cols-[1.6fr_1fr]">
                        <div class="grid gap-6 sm:grid-cols-2">
                             @foreach ($newsCards->take(4) as [$title, $description, $date, $tone, $icon, $imagePath, $slug])
                                <a href="{{ $slug ? route('news.show', $slug) : route('news.index') }}" class="group relative flex flex-col justify-between overflow-hidden rounded-[1.4rem] bg-white p-7 shadow-[0_8px_30px_rgba(0,0,0,0.04)] transition hover:-translate-y-1 hover:shadow-xl dark:bg-slate-900/40">
                                    <div class="absolute inset-y-0 right-0 w-1.5 bg-[#03224c] transition-all group-hover:w-2 dark:bg-emerald-500"></div>
                                    <div>
                                        <h3 class="text-[15px] font-black leading-tight text-[#0b2447] dark:text-white">{{ $title }}</h3>
                                        <p class="mt-3 text-[13px] font-medium leading-relaxed text-slate-600 dark:text-slate-400">{{ $description }}</p>
                                    </div>
                                    <div class="mt-6 flex items-center justify-between border-t border-slate-50 pt-4 dark:border-white/5">
                                        <span class="text-[12px] font-black text-indigo-600 dark:text-cyan-400">Learn more</span>
                                        <time class="text-[11px] font-bold text-slate-400">{{ $date }}</time>
                                    </div>
                                </a>
                             @endforeach
                        </div>

                        <aside class="relative overflow-hidden rounded-[2rem] bg-white p-3 shadow-2xl dark:bg-slate-900/40">
                             <div class="relative aspect-[4/3] w-full overflow-hidden rounded-[1.5rem] bg-[#e7eadf] lg:aspect-square">
                                <svg viewBox="0 0 240 180" aria-hidden="true" class="size-full">
                                    <rect width="240" height="180" fill="#e4e8dd" />
                                    <path d="M-20 31 260 150M-10 132 180-15M50 195 250 32M-20 86 260 96" stroke="white" stroke-width="9" />
                                    <path d="M-20 31 260 150M-10 132 180-15M50 195 250 32M-20 86 260 96" stroke="#d1d8ca" stroke-width="1.5" />
                                    <path d="M146 48c-10 0-18 8-18 18 0 14 18 32 18 32s18-18 18-32c0-10-8-18-18-18Z" fill="#ef4444" />
                                    <circle cx="146" cy="66" r="6" fill="white" />
                                </svg>
                                <div class="absolute inset-x-4 bottom-4">
                                    <a href="https://maps.google.com/?q=Kanchan+Bridge+Crossing+Rupganj+Narayanganj" target="_blank" rel="noopener noreferrer" class="flex w-full items-center justify-center rounded-xl bg-[#0b2447] py-3 text-xs font-black text-white shadow-lg transition hover:bg-slate-800">View Map</a>
                                </div>
                             </div>
                             <div class="px-5 py-6">
                                 <h3 class="text-lg font-black text-[#0b2447] dark:text-white">Visit Our Campus</h3>
                                 <div class="mt-4 space-y-3">
                                     <div class="flex items-start gap-3">
                                         <svg viewBox="0 0 20 20" class="mt-0.5 size-4 shrink-0 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 18s6-5 6-10A6 6 0 1 0 4 8c0 5 6 10 6 10Zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/></svg>
                                         <p class="text-[12px] font-bold text-slate-600 dark:text-slate-400">{{ $contactSettings?->metadata['address'] ?? 'Kanchan Bridge Crossing (Adj. Purbachal American City), Rupganj, Narayanganj' }}</p>
                                     </div>
                                     <div class="flex items-center gap-3">
                                         <svg viewBox="0 0 20 20" class="size-4 shrink-0 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3h3l1 4-2 1c1 2.5 2.5 4 5 5l1-2 4 1v3c0 1.1-.9 2-2 2C8.4 17 3 11.6 3 5a2 2 0 0 1 2-2Z"/></svg>
                                         <p class="text-[12px] font-bold text-slate-600 dark:text-slate-400">{{ $contactSettings?->metadata['phone'] ?? '+880 2-55000000' }}</p>
                                     </div>
                                 </div>
                             </div>
                        </aside>
                    </div>
                </div>
            </section>

            <section id="contact" class="bg-[#e7f3f9] py-16 dark:bg-ink sm:py-20">
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
                            <div class="flex items-center gap-4 pb-4 border-b border-slate-200 dark:border-white/10">
                                <a href="#" class="grid size-8 place-items-center rounded-full bg-[#1877f2] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-current"><path d="M13.5 21v-8h2.8l.4-3.1h-3.2V8c0-.9.3-1.5 1.6-1.5h1.7V3.7c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2H7.3V13h2.8v8h3.4Z"/></svg></a>
                                <a href="#" class="grid size-8 place-items-center rounded-full bg-[#1da1f2] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-current"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg></a>
                                <a href="#" class="grid size-8 place-items-center rounded-full bg-[#e4405f] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-none stroke-current" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
                                <a href="#" class="grid size-8 place-items-center rounded-full bg-[#ff0000] text-white hover:opacity-80 transition"><svg viewBox="0 0 24 24" class="size-4 fill-current"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33 2.78 2.78 0 0 0 1.94 2C5.12 19.5 12 19.5 12 19.5s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.33 29 29 0 0 0-.46-5.33zM9.75 15.02V8.48l5.75 3.27-5.75 3.27z"/></svg></a>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="grid size-8 shrink-0 place-items-center rounded-full bg-[#0b2447] text-white">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-[#0b2447] dark:text-white">Main Campus</h3>
                                    <p class="mt-1 text-xs font-bold text-slate-600 dark:text-slate-400">
                                        {{ $contactSettings?->body ?: 'Kanchan Bridge Crossing (Adj. Purbachal American City), Rupganj, Narayanganj' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="grid size-8 shrink-0 place-items-center rounded-full bg-[#0b2447] text-white">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-[#0b2447] dark:text-white">Phone & Mobile</h3>
                                    <p class="mt-1 text-xs font-bold text-slate-600 dark:text-slate-400">
                                        Mobile: {{ $contactSettings?->metadata['mobile'] ?? '01619-142266' }}<br>
                                        Phone: {{ $contactSettings?->metadata['phone'] ?? '+880 2-55000000' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="grid size-8 shrink-0 place-items-center rounded-full bg-[#0b2447] text-white">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-[#0b2447] dark:text-white">Website & Email</h3>
                                    <p class="mt-1 text-xs font-bold text-slate-600 dark:text-slate-400">
                                        Website: <a href="https://www.southasian.edu.bd" target="_blank" class="hover:text-cyan-400 transition">{{ $contactSettings?->metadata['website'] ?? 'www.southasian.edu.bd' }}</a><br>
                                        Email: <a href="mailto:southasian.edu.bd@gmail.com" class="hover:text-cyan-400 transition">{{ $contactSettings?->metadata['email'] ?? 'southasian.edu.bd@gmail.com' }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Map -->
                        <div class="relative aspect-square w-full overflow-hidden rounded-2xl bg-white shadow-lg">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3648.889!2d90.584!3d23.822!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755cb3b4b8a2133%3A0x6a1329c0a6e0df34!2sKanchan%20Bridge%2C%20Rupganj!5e0!3m2!1sen!2sbd!4v1716800000000!5m2!1sen!2sbd"
                                class="size-full border-0"
                                allowfullscreen=""
                                loading="lazy"
                            ></iframe>
                        </div>
                    </div>
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
                                South Asia Engineering & Technical Institute is a renowned technical and skills development institution in Bangladesh, committed to empowering the nation’s youth with industry-relevant knowledge, practical expertise, and modern technological skills.
                            </p>
                            <p>
                                The institute provides a comprehensive learning environment that combines theoretical knowledge with hands-on training, professional ethics, and practical experience. Our goal is to equip every learner with the confidence and competence required to succeed in today’s competitive world.
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

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const counters = document.querySelectorAll('[data-stat-counter]');
                if (!counters.length) return;

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const el = entry.target;
                            const rawText = (el.getAttribute('data-target-text') || '0').trim();

                            const numericString = rawText.replace(/[^0-9]/g, '');
                            const targetNumber = parseInt(numericString, 10);

                            if (isNaN(targetNumber) || targetNumber <= 0) {
                                el.textContent = rawText;
                                obs.unobserve(el);
                                return;
                            }

                            const suffixMatch = rawText.match(/[^0-9,]+$/);
                            const suffix = suffixMatch ? suffixMatch[0] : (rawText.includes('+') ? '+' : '');

                            const duration = 2000;
                            const startTime = performance.now();

                            function updateCounter(currentTime) {
                                const elapsedTime = currentTime - startTime;
                                const progress = Math.min(elapsedTime / duration, 1);

                                const easeOutProgress = 1 - Math.pow(1 - progress, 3);
                                const currentVal = Math.floor(easeOutProgress * targetNumber);

                                el.textContent = currentVal.toLocaleString() + suffix;

                                if (progress < 1) {
                                    requestAnimationFrame(updateCounter);
                                } else {
                                    el.textContent = targetNumber.toLocaleString() + suffix;
                                }
                            }

                            requestAnimationFrame(updateCounter);
                            obs.unobserve(el);
                        }
                    });
                }, { threshold: 0.15 });

                counters.forEach(counter => observer.observe(counter));
            });
        </script>

        <footer class="bg-[#031735] text-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 space-y-10">

                {{-- ROW 1: BRANDING & VERIFIED CERTIFICATE CARD --}}
                <div class="grid gap-8 lg:grid-cols-12 items-center border-b border-white/10 pb-10">
                    {{-- Top Left: Logo & Institute Name --}}
                    <div class="lg:col-span-6 space-y-4">
                        <a href="#home" class="inline-flex items-center gap-4">
                            <div class="grid size-14 place-items-center rounded-2xl bg-white p-2 shadow-xl ring-1 ring-white/20">
                                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="size-full object-contain">
                            </div>
                            <div>
                                <span class="block text-2xl sm:text-3xl font-black tracking-tight text-white uppercase leading-tight">South Asia</span>
                                <span class="block text-[11px] font-bold tracking-[0.15em] text-slate-200 uppercase">Engineering & Technical Institute</span>
                            </div>
                        </a>
                        <p class="text-xs sm:text-sm leading-relaxed text-slate-300 max-w-xl">
                            South Asia Engineering & Technical Institute provides practical, industry-focused technical education and skill-building for a secure, professional future.
                        </p>
                    </div>

                    {{-- Top Right: Prominent Verified Certificate Box --}}
                    <div class="lg:col-span-6">
                        <div class="rounded-2xl border border-white/20 bg-gradient-to-br from-[#071d3d] to-[#041228] p-5 sm:p-6 shadow-2xl backdrop-blur-md">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="size-9 rounded-xl bg-amber-500/20 border border-amber-400/40 flex items-center justify-center text-amber-400 shrink-0 shadow-md">
                                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm sm:text-base font-black text-white uppercase tracking-wider">Online Certificate Verification</h4>
                                    <p class="text-[10px] font-bold text-slate-400">Verify student authenticity using Roll or Reg. Number</p>
                                </div>
                            </div>
                            <form action="{{ route('results.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                                <input type="hidden" name="type" value="certificate">
                                <input type="text" name="roll_number" required placeholder="Enter Roll or Registration Number"
                                    class="flex-1 rounded-xl border border-white/15 bg-[#020b18] px-4 py-3 text-xs text-white placeholder-slate-400 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 outline-none transition shadow-inner">
                                <button type="submit" class="rounded-xl bg-amber-500 hover:bg-amber-400 text-[#03224c] font-black text-xs uppercase tracking-wider px-6 py-3 transition active:scale-95 flex items-center justify-center gap-2 shadow-lg shrink-0">
                                    <span>🔍 VERIFY</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- ROW 2: 4-COLUMN LINKS & CONTACT INFO --}}
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 text-xs">
                    {{-- Column 1: Quick Links --}}
                    <div class="space-y-4">
                        <h3 class="text-sm font-black uppercase tracking-wider text-white border-b border-white/10 pb-2">Quick Navigation</h3>
                        <ul class="space-y-2.5 font-bold text-slate-300">
                            <li><a href="#home" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Admission Info</a></li>
                            <li><a href="#courses" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Available Courses</a></li>
                            <li><a href="{{ route('results.index') }}" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Exam & Result Site</a></li>
                            <li><a href="#institute-gallery" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Photo Gallery</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Student Status</a></li>
                        </ul>
                    </div>

                    {{-- Column 2: Institutional & Notices --}}
                    <div class="space-y-4">
                        <h3 class="text-sm font-black uppercase tracking-wider text-white border-b border-white/10 pb-2">Institute & Notice</h3>
                        <ul class="space-y-2.5 font-bold text-slate-300">
                            <li><a href="#about" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> General Info</a></li>
                            <li><a href="#branch-application-promo" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Branch Information</a></li>
                            <li><a href="#notice-bar" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Latest Notice Board</a></li>
                            <li><a href="#contact" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Contact Details</a></li>
                            <li><a href="/branch-application" class="hover:text-amber-400 transition flex items-center gap-2"><span class="text-slate-400">▸</span> Apply For Branch</a></li>
                        </ul>
                    </div>

                    {{-- Column 3: Main Campus & Address --}}
                    <div class="space-y-4">
                        <h3 class="text-sm font-black uppercase tracking-wider text-white border-b border-white/10 pb-2">Main Campus</h3>
                        <p class="font-bold text-slate-300 leading-relaxed">
                            Kanchan Bridge Crossing (Adj. Purbachal American City), Rupganj, Narayanganj
                        </p>
                        <div class="space-y-1.5 font-bold text-slate-300">
                            <p>Mobile: <span class="text-white font-mono">01619-142266</span></p>
                            <p>Phone: <span class="text-white font-mono">+880 2-55000000</span></p>
                        </div>
                    </div>

                    {{-- Column 4: Online Access & Email --}}
                    <div class="space-y-4">
                        <h3 class="text-sm font-black uppercase tracking-wider text-white border-b border-white/10 pb-2">Online Portal</h3>
                        <div class="space-y-2 font-bold text-slate-300">
                            <p>Website: <a href="https://www.southasian.edu.bd" target="_blank" class="text-slate-200 hover:text-amber-400 hover:underline">www.southasian.edu.bd</a></p>
                            <p>Email: <a href="mailto:southasian.edu.bd@gmail.com" class="text-slate-200 hover:text-amber-400 hover:underline">southasian.edu.bd@gmail.com</a></p>
                        </div>
                        <div class="pt-2">
                            <span class="inline-flex items-center gap-2 rounded-xl bg-white/10 border border-white/20 px-3 py-1.5 text-[10px] font-black uppercase text-slate-200">
                                ✓ Govt. Registered Institute
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER BOTTOM BAR --}}
            <div class="border-t border-white/10 py-6 text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest bg-[#020d20]">
                <div class="mx-auto max-w-7xl px-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p>© {{ date('Y') }} South Asia Engineering & Technical Institute. All rights reserved.</p>
                    <p class="text-slate-400">Managed by Technical Solutions</p>
                </div>
            </div>
        </footer>
    </body>
</html>

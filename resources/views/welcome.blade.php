<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                        class="brand-logo size-12 shrink-0 transition duration-300 group-hover:-rotate-3 sm:size-14"
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
                    <a href="#branches" class="nav-link" data-i18n="navBranches">Branches</a>
                    <a href="#services" class="nav-link" data-i18n="navServices">Student Services</a>
                    <a href="#contact" class="nav-link" data-i18n="navContact">Contact</a>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <button type="button" class="icon-button" data-locale-toggle aria-label="Switch language">
                        <span class="text-xs font-black" data-locale-label>বাং</span>
                    </button>
                    <button type="button" class="icon-button" data-theme-toggle aria-label="Toggle color theme">
                        <svg data-theme-sun viewBox="0 0 24 24" aria-hidden="true" class="size-5">
                            <circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/>
                            <path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/>
                        </svg>
                        <svg data-theme-moon viewBox="0 0 24 24" aria-hidden="true" class="hidden size-5">
                            <path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/>
                        </svg>
                    </button>
                    <a href="#contact" class="hidden rounded-full bg-emerald-500 px-5 py-3 text-sm font-black text-ink shadow-lg shadow-emerald-500/20 transition hover:-translate-y-0.5 hover:bg-emerald-400 xl:inline-flex" data-i18n="getStarted">
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

            <div id="mobile-menu" class="border-t border-slate-900/5 bg-stone-50 px-4 py-5 shadow-2xl dark:border-white/10 dark:bg-ink lg:hidden" data-mobile-menu hidden>
                <div class="mx-auto grid max-w-7xl gap-1">
                    <a href="#home" class="mobile-nav-link" data-i18n="navHome">Home</a>
                    <a href="#courses" class="mobile-nav-link" data-i18n="navCourses">Courses</a>
                    <a href="#about" class="mobile-nav-link" data-i18n="navAbout">About</a>
                    <a href="#branches" class="mobile-nav-link" data-i18n="navBranches">Branches</a>
                    <a href="#services" class="mobile-nav-link" data-i18n="navServices">Student Services</a>
                    <a href="#contact" class="mobile-nav-link" data-i18n="navContact">Contact</a>
                    <a href="#contact" class="mt-3 inline-flex min-h-12 items-center justify-center rounded-2xl bg-emerald-500 px-5 text-sm font-black text-ink" data-i18n="getStarted">Get Started</a>
                </div>
            </div>
        </header>

        <main id="main-content">
            <section id="home" class="hero-slide relative min-h-[660px] overflow-hidden bg-ink pt-[108px] text-white sm:min-h-[720px] lg:min-h-[748px] lg:pt-[116px]" data-hero-carousel>
                @foreach ([
                    ['images/bnyti-hero-premium-1.png', 'Students learning computer and electronics skills in a modern technical lab'],
                    ['images/bnyti-hero-premium-2.png', 'Students practicing electrical and solar installation skills with safety equipment'],
                    ['images/bnyti-hero-premium-3.png', 'Students working in a creative digital design and fashion training studio'],
                ] as [$image, $alt])
                    <img
                        src="{{ asset($image) }}"
                        alt="{{ $alt }}"
                        class="hero-carousel-image absolute inset-0 size-full object-cover object-[58%_center] opacity-0"
                        data-hero-image
                        @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif
                    >
                @endforeach
                <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(3,7,18,.88)_0%,rgba(3,7,18,.62)_42%,rgba(3,7,18,.38)_76%,rgba(3,7,18,.72)_100%)]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_68%,rgba(251,191,36,.24),transparent_32%),radial-gradient(circle_at_90%_12%,rgba(59,130,246,.2),transparent_28%)]"></div>
                <div class="absolute inset-x-0 bottom-0 h-1 bg-emerald-500"></div>

                <div class="relative mx-auto flex min-h-[552px] max-w-7xl items-center px-4 py-16 sm:min-h-[604px] sm:px-6 lg:min-h-[632px] lg:px-8">
                    <div class="reveal is-visible flex w-full max-w-[620px] flex-col items-start gap-6 sm:gap-8 lg:ml-12">
                        <h1 class="sr-only">
                            <span data-i18n="heroTitleOne">Practical skills for a</span>
                            <span data-i18n="heroTitleTwo">future without limits.</span>
                        </h1>

                        <div class="hero-badge">
                            <span class="size-2.5 shrink-0 rounded-full bg-emerald-400 shadow-[0_0_16px_#34d399]"></span>
                            <span data-i18n="heroEyebrow">Bangladesh National Youth Technical Institute</span>
                        </div>

                        <div class="h-1 w-28 rounded-full bg-emerald-500 shadow-[0_0_24px_rgba(16,185,129,.65)]"></div>

                        <p class="sr-only" data-i18n="heroBody">
                            Industry-focused technical training, experienced mentors, and nationwide opportunity—designed to turn ambition into employable expertise.
                        </p>

                        <div class="flex w-full flex-col gap-4 sm:w-auto sm:flex-row sm:items-center">
                            <a href="#courses" class="hero-primary-button group">
                                <span data-i18n="getStarted">Get Started</span>
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="size-5 transition group-hover:translate-x-1">
                                    <path d="M5 12h14m-5-5 5 5-5 5" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                                </svg>
                            </a>
                            <a href="#contact" class="hero-outline-button">
                                <svg viewBox="0 0 24 24" aria-hidden="true" class="size-5">
                                    <path d="M7.2 3h3l1.5 4.2-2 1.7c1.3 2.8 2.8 4.3 5.5 5.5l1.7-2 4.1 1.5v3c0 2.2-1.8 4-4 4C9.3 20.9 3 14.7 3 7a4 4 0 0 1 4.2-4Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.7"/>
                                </svg>
                                <span data-i18n="contactUs">Contact Us</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="absolute right-4 bottom-8 hidden rounded-full border border-white/15 bg-emerald-500/70 px-4 py-3 text-sm font-black text-white shadow-2xl backdrop-blur-md sm:block lg:right-10 lg:bottom-14" aria-live="polite">
                    <span data-hero-current>1</span> / 3
                </div>
                <div class="absolute bottom-7 left-1/2 flex -translate-x-1/2 items-center gap-3 sm:bottom-10" aria-hidden="true">
                    <span class="hero-carousel-dot is-active"></span>
                    <span class="hero-carousel-dot"></span>
                    <span class="hero-carousel-dot"></span>
                </div>
            </section>

            <section class="relative z-10 border-y border-emerald-600/20 bg-white text-ink shadow-sm dark:bg-deep dark:text-white" aria-label="Latest notice">
                <div class="flex items-stretch overflow-hidden">
                    <div class="notice-label relative flex shrink-0 items-center gap-3 bg-emerald-600 py-3 pr-8 pl-4 text-xs font-black tracking-[0.22em] text-white sm:pl-8">
                        <span class="size-2 rounded-full bg-white"></span>
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex size-full animate-ping rounded-full bg-amber-300 opacity-75 motion-reduce:animate-none"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-amber-300"></span>
                        </span>
                        <span data-i18n="notice">NOTICE</span>
                    </div>
                    <div class="min-w-0 flex-1 overflow-hidden py-3">
                        <p class="notice-track whitespace-nowrap px-8 text-sm font-bold text-slate-700 motion-reduce:transform-none dark:text-slate-200" data-i18n="noticeText">
                            Admission for the July 2026 session is now open • Branch applications are being accepted nationwide • Contact us for course counselling
                        </p>
                    </div>
                </div>
            </section>

            <section class="border-b border-slate-200/80 bg-white py-8 dark:border-white/10 dark:bg-deep">
                <div class="mx-auto grid max-w-7xl grid-cols-2 gap-x-6 gap-y-8 px-4 sm:px-6 md:grid-cols-4 lg:px-8">
                    @foreach ([
                        ['01', 'Govt. aligned', 'trustOne'],
                        ['02', 'Practical training', 'trustTwo'],
                        ['03', 'Nationwide network', 'trustThree'],
                        ['04', 'Career focused', 'trustFour'],
                    ] as [$number, $label, $key])
                        <div class="flex min-w-0 items-center gap-2 sm:gap-3">
                            <span class="shrink-0 text-xs font-black text-emerald-600 dark:text-emerald-400">{{ $number }}</span>
                            <span class="h-7 w-px shrink-0 bg-slate-200 dark:bg-white/15"></span>
                            <span class="min-w-0 text-[10px] leading-4 font-bold tracking-[0.04em] text-slate-600 uppercase break-words sm:text-xs sm:tracking-wide dark:text-slate-300" data-i18n="{{ $key }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="courses" class="section-space bg-stone-50 dark:bg-ink">
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
                                    <a href="#contact" class="mt-auto inline-flex items-center gap-2 text-sm font-black text-slate-900 transition group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                        <span data-i18n="viewCourse">View program</span>
                                        <span aria-hidden="true">↗</span>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="about" class="section-space overflow-hidden bg-white dark:bg-deep">
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
                        <a href="#contact" class="primary-button mt-9 inline-flex">
                            <span data-i18n="discoverStory">Discover our story</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </section>

            <section class="relative overflow-hidden bg-emerald-500 py-14 text-ink sm:py-16">
                <div class="absolute inset-0 opacity-20 [background-image:radial-gradient(#071c2c_1px,transparent_1px)] [background-size:18px_18px]"></div>
                <div class="relative mx-auto grid max-w-7xl grid-cols-2 gap-8 px-4 sm:px-6 lg:grid-cols-4 lg:px-8">
                    @foreach ([
                        ['25,000+', 'Students trained', 'statStudents'],
                        ['250+', 'Active branches', 'statBranches'],
                        ['40+', 'Career programs', 'statPrograms'],
                        ['64', 'District reach', 'statDistricts'],
                    ] as [$value, $label, $key])
                        <div class="reveal text-center lg:text-left">
                            <strong class="block text-4xl font-black tracking-tight sm:text-5xl">{{ $value }}</strong>
                            <span class="mt-2 block text-xs font-black tracking-[0.12em] uppercase opacity-75" data-i18n="{{ $key }}">{{ $label }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            <section id="services" class="section-space bg-stone-50 dark:bg-ink">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="reveal mx-auto max-w-2xl text-center">
                        <div class="eyebrow mx-auto" data-i18n="servicesEyebrow">STUDENT SERVICES</div>
                        <h2 class="section-title mt-5" data-i18n="servicesTitle">Everything you need, in one place.</h2>
                        <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-300" data-i18n="servicesBody">
                            Clear access to essential academic services—from admission to certification.
                        </p>
                    </div>

                    <div class="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ([
                            ['Student Results', 'serviceResults', 'Check published academic and examination results.', 'serviceResultsBody', 'chart'],
                            ['Online Examination', 'serviceExam', 'Enter scheduled assessments using verified details.', 'serviceExamBody', 'exam'],
                            ['Certificate Verification', 'serviceCertificate', 'Confirm the authenticity of issued credentials.', 'serviceCertificateBody', 'badge'],
                            ['Branch Application', 'serviceBranch', 'Apply to join our nationwide training network.', 'serviceBranchBody', 'network'],
                            ['Student Admission', 'serviceAdmission', 'Start a practical learning journey with BNYTI.', 'serviceAdmissionBody', 'student'],
                            ['Download Centre', 'serviceDownload', 'Access forms, notices, cards, and documents.', 'serviceDownloadBody', 'download'],
                        ] as [$title, $titleKey, $body, $bodyKey, $icon])
                            <a href="#contact" class="service-card group reveal">
                                <span class="service-icon">
                                    @if ($icon === 'chart')
                                        <svg viewBox="0 0 24 24"><path d="M4 20V10m6 10V4m6 16v-7m4 7H2" /></svg>
                                    @elseif ($icon === 'exam')
                                        <svg viewBox="0 0 24 24"><path d="M6 4h12v16H6zM9 8h6m-6 4h6m-6 4h3" /></svg>
                                    @elseif ($icon === 'badge')
                                        <svg viewBox="0 0 24 24"><path d="M12 3a6 6 0 1 0 0 12 6 6 0 0 0 0-12Zm-3 11-1 7 4-2 4 2-1-7" /></svg>
                                    @elseif ($icon === 'network')
                                        <svg viewBox="0 0 24 24"><path d="M12 4v6m0 0H6v4m6-4h6v4M6 14a3 3 0 1 0 0 6 3 3 0 0 0 0-6Zm12 0a3 3 0 1 0 0 6 3 3 0 0 0 0-6ZM12 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z" /></svg>
                                    @elseif ($icon === 'student')
                                        <svg viewBox="0 0 24 24"><path d="m3 9 9-5 9 5-9 5-9-5Zm4 3v5c3 3 7 3 10 0v-5" /></svg>
                                    @else
                                        <svg viewBox="0 0 24 24"><path d="M12 3v12m0 0 5-5m-5 5-5-5M4 20h16" /></svg>
                                    @endif
                                </span>
                                <div>
                                    <h3 class="text-lg font-black text-slate-950 dark:text-white" data-i18n="{{ $titleKey }}">{{ $title }}</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400" data-i18n="{{ $bodyKey }}">{{ $body }}</p>
                                </div>
                                <span class="ml-auto self-center text-2xl text-slate-300 transition group-hover:translate-x-1 group-hover:text-emerald-500 dark:text-slate-600" aria-hidden="true">→</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="branches" class="section-space relative overflow-hidden bg-ink text-white">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_50%,rgba(16,185,129,.18),transparent_32%),radial-gradient(circle_at_90%_20%,rgba(6,182,212,.12),transparent_28%)]"></div>
                <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 sm:px-6 lg:grid-cols-[.8fr_1.2fr] lg:px-8">
                    <div class="reveal">
                        <div class="eyebrow border-white/15 bg-white/5 text-emerald-300" data-i18n="branchesEyebrow">NATIONWIDE NETWORK</div>
                        <h2 class="section-title mt-5 text-white" data-i18n="branchesTitle">Opportunity, closer to home.</h2>
                        <p class="mt-6 max-w-lg text-base leading-8 text-slate-300" data-i18n="branchesBody">
                            Our growing network helps learners access consistent technical education across cities, districts, and communities throughout Bangladesh.
                        </p>
                        <div class="mt-8 flex flex-wrap gap-3">
                            <a href="#contact" class="primary-button" data-i18n="findBranch">Find a branch</a>
                            <a href="#contact" class="secondary-button" data-i18n="applyBranch">Apply for a branch</a>
                        </div>
                    </div>
                    <div class="reveal" style="--reveal-delay: 140ms">
                        <div class="map-panel relative min-h-[390px] overflow-hidden rounded-[2rem] border border-white/10 bg-white/5 p-6 sm:p-10">
                            <div class="absolute inset-0 opacity-25 [background-image:linear-gradient(rgba(255,255,255,.1)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,.1)_1px,transparent_1px)] [background-size:38px_38px]"></div>
                            <svg viewBox="0 0 540 380" aria-hidden="true" class="relative mx-auto h-[330px] w-full max-w-xl">
                                <path d="M300 24c37 22 52 54 47 88l39 26-18 43 31 49-36 32-2 66-46 26-45-29-46 24-41-42-50-8-16-47 26-37-17-43 38-37 12-60 53 1 21-52 50 0Z" fill="#10b981" fill-opacity=".14" stroke="#34d399" stroke-width="3"/>
                                <path d="m190 80 165 240M145 165l230 70M180 305 353 105" stroke="#34d399" stroke-dasharray="5 10" stroke-opacity=".3" stroke-width="2"/>
                                @foreach ([[190,80], [300,68], [355,150], [235,170], [148,218], [300,250], [362,315], [200,310]] as [$x, $y])
                                    <g>
                                        <circle cx="{{ $x }}" cy="{{ $y }}" r="14" fill="#34d399" fill-opacity=".15"/>
                                        <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="#34d399"/>
                                    </g>
                                @endforeach
                            </svg>
                            <div class="absolute right-5 bottom-5 left-5 grid grid-cols-3 gap-3 rounded-2xl border border-white/10 bg-ink/80 p-4 text-center backdrop-blur">
                                <div><strong class="block text-xl text-emerald-300">8</strong><span class="text-[10px] text-slate-400" data-i18n="divisions">Divisions</span></div>
                                <div><strong class="block text-xl text-emerald-300">64</strong><span class="text-[10px] text-slate-400" data-i18n="districts">Districts</span></div>
                                <div><strong class="block text-xl text-emerald-300">250+</strong><span class="text-[10px] text-slate-400" data-i18n="centres">Centres</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="section-space bg-white dark:bg-deep">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="reveal flex flex-col gap-5 md:flex-row md:items-end md:justify-between">
                        <div class="max-w-2xl">
                            <div class="eyebrow" data-i18n="reviewsEyebrow">STUDENT STORIES</div>
                            <h2 class="section-title mt-5" data-i18n="reviewsTitle">Confidence earned through practice.</h2>
                        </div>
                        <p class="max-w-sm text-sm leading-7 text-slate-600 dark:text-slate-300" data-i18n="reviewsBody">
                            Learners share how practical training helped them take the next step.
                        </p>
                    </div>
                    <div class="mt-12 grid gap-5 lg:grid-cols-3">
                        @foreach ([
                            ['Tasnim Akter', 'Computer Office Application', 'reviewNameOne', 'reviewCourseOne', 'The classes were clear, supportive, and practical. I can now work confidently with the tools used in a modern office.', 'reviewOne', 'TA'],
                            ['Mohammad Al Rafi', 'Electrical Technology', 'reviewNameTwo', 'reviewCourseTwo', 'Learning in the lab made the difference. The instructors connected every lesson to work I may face outside the classroom.', 'reviewTwo', 'MR'],
                            ['Fahim Ahmed', 'Graphics Design', 'reviewNameThree', 'reviewCourseThree', 'Project-based learning helped me build both a portfolio and the confidence to present my work to real clients.', 'reviewThree', 'FA'],
                        ] as [$name, $course, $nameKey, $courseKey, $quote, $quoteKey, $initials])
                            <figure class="review-card reveal" style="--reveal-delay: {{ $loop->index * 90 }}ms">
                                <div class="text-5xl leading-none font-black text-emerald-500/30">“</div>
                                <blockquote class="mt-1 flex-1 text-base leading-8 text-slate-700 dark:text-slate-200" data-i18n="{{ $quoteKey }}">{{ $quote }}</blockquote>
                                <figcaption class="mt-8 flex items-center gap-4 border-t border-slate-200 pt-5 dark:border-white/10">
                                    <span class="grid size-11 place-items-center rounded-full bg-ink text-xs font-black text-emerald-300 dark:bg-emerald-400 dark:text-ink">{{ $initials }}</span>
                                    <span>
                                        <strong class="block text-sm font-black text-slate-950 dark:text-white" data-i18n="{{ $nameKey }}">{{ $name }}</strong>
                                        <span class="text-xs text-slate-500 dark:text-slate-400" data-i18n="{{ $courseKey }}">{{ $course }}</span>
                                    </span>
                                </figcaption>
                            </figure>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="contact" class="bg-stone-50 pb-20 dark:bg-ink sm:pb-24">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="cta-panel reveal relative overflow-hidden rounded-[2rem] bg-emerald-500 px-6 py-12 text-ink shadow-2xl shadow-emerald-950/10 sm:px-10 lg:px-16 lg:py-16">
                        <div class="absolute -top-20 -right-20 size-72 rounded-full border-[50px] border-ink/5"></div>
                        <div class="absolute -bottom-28 left-1/3 size-64 rounded-full border-[45px] border-white/10"></div>
                        <div class="relative grid items-center gap-10 lg:grid-cols-[1fr_auto]">
                            <div class="max-w-3xl">
                                <p class="text-xs font-black tracking-[0.18em] uppercase" data-i18n="ctaEyebrow">YOUR NEXT STEP STARTS HERE</p>
                                <h2 class="mt-4 text-balance text-4xl leading-tight font-black tracking-[-0.04em] sm:text-5xl" data-i18n="ctaTitle">Choose a skill. Create your opportunity.</h2>
                                <p class="mt-5 max-w-2xl text-base leading-7 text-emerald-950/80" data-i18n="ctaBody">
                                    Talk with our course counselling team and find the program that fits your goal.
                                </p>
                            </div>
                            <div class="flex flex-col gap-3 sm:flex-row lg:flex-col">
                                <a href="tel:+8809696481628" class="inline-flex min-h-14 items-center justify-center gap-2 rounded-full bg-ink px-7 text-sm font-black text-white transition hover:-translate-y-0.5">
                                    <span data-i18n="callCounsellor">Call a counsellor</span>
                                    <span aria-hidden="true">↗</span>
                                </a>
                                <a href="mailto:bnyti-edubd@gmail.com" class="inline-flex min-h-14 items-center justify-center rounded-full border border-ink/20 px-7 text-sm font-black transition hover:bg-white/25" data-i18n="sendEmail">
                                    Send an email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-[#04131f] text-white">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-[1.3fr_.7fr_.8fr_1.2fr] lg:px-8 lg:py-16">
                <div>
                    <a href="#home" class="flex items-center gap-3">
                        <img
                            src="{{ asset('images/bnyti-logo.svg') }}"
                            alt="Bangladesh National Youth Technical Institute logo"
                            class="brand-logo size-14 shrink-0"
                        >
                        <span class="text-sm font-black leading-tight">BANGLADESH NATIONAL<br><span class="text-[10px] tracking-[0.17em] text-emerald-300">YOUTH TECHNICAL INSTITUTE</span></span>
                    </a>
                    <p class="mt-5 max-w-sm text-sm leading-7 text-slate-400" data-i18n="footerAbout">
                        Empowering Bangladesh’s next generation through practical technical education and accessible skills development.
                    </p>
                </div>
                <div>
                    <h3 class="footer-title" data-i18n="footerExplore">Explore</h3>
                    <div class="mt-5 grid gap-3 text-sm text-slate-400">
                        <a href="#courses" class="footer-link" data-i18n="navCourses">Courses</a>
                        <a href="#about" class="footer-link" data-i18n="navAbout">About</a>
                        <a href="#branches" class="footer-link" data-i18n="navBranches">Branches</a>
                        <a href="#services" class="footer-link" data-i18n="navServices">Student Services</a>
                    </div>
                </div>
                <div>
                    <h3 class="footer-title" data-i18n="footerSupport">Support</h3>
                    <div class="mt-5 grid gap-3 text-sm text-slate-400">
                        <a href="#contact" class="footer-link" data-i18n="studentAdmission">Student admission</a>
                        <a href="#services" class="footer-link" data-i18n="resultCheck">Result checking</a>
                        <a href="#services" class="footer-link" data-i18n="certificateVerify">Certificate verification</a>
                        <a href="#contact" class="footer-link" data-i18n="branchApplication">Branch application</a>
                    </div>
                </div>
                <div>
                    <h3 class="footer-title" data-i18n="footerContact">Contact</h3>
                    <address class="mt-5 flex flex-col gap-4 text-sm leading-6 text-slate-400 not-italic">
                        <p>Haji Hossain Plaza, Demra Bazar Road<br>Demra, Dhaka-1360, Bangladesh</p>
                        <a href="tel:+8809696481628" class="footer-link">+880 9696-481628</a>
                        <a href="mailto:bnyti-edubd@gmail.com" class="footer-link">bnyti-edubd@gmail.com</a>
                    </address>
                </div>
            </div>
            <div class="border-t border-white/10">
                <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 text-xs text-slate-500 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
                    <p>© {{ date('Y') }} Bangladesh National Youth Technical Institute. <span data-i18n="rights">All rights reserved.</span></p>
                    <p data-i18n="footerLine">Skills for work. Confidence for life.</p>
                </div>
            </div>
        </footer>
    </body>
</html>

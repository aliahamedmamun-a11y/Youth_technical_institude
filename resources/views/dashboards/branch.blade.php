@php
    $homeUrl = route('home');

    $quickMenus = [
        ['title' => 'ADMISSION', 'subtitle' => 'New Admission', 'href' => route('student-registrations.create'), 'tone' => 'green', 'icon' => 'admission'],
        ['title' => 'STUDENTS', 'subtitle' => 'All Students', 'href' => route('dashboards.branch'), 'tone' => 'red', 'icon' => 'students'],
        ['title' => 'CERTIFICATES', 'subtitle' => 'Verification', 'href' => route('results.index'), 'tone' => 'green', 'icon' => 'certificate'],
        ['title' => 'BRANCHES', 'subtitle' => 'All Branches', 'href' => route('branch-applications.create'), 'tone' => 'red', 'icon' => 'branch'],
        ['title' => 'NEWS & NOTICE', 'subtitle' => 'Latest Updates', 'href' => $homeUrl.'#latest-news-contact', 'tone' => 'green', 'icon' => 'notice'],
        ['title' => 'SUPPORT', 'subtitle' => 'Help Desk', 'href' => $homeUrl.'#latest-news-contact', 'tone' => 'red', 'icon' => 'support'],
    ];

    $notices = [
        ['icon' => 'cap', 'text' => 'ভর্তি চলছে! আপনার নিকটস্থ ব্রাঞ্চে যোগাযোগ করুন'],
        ['icon' => 'form', 'text' => 'অনলাইন রেজিস্ট্রেশন চালু রয়েছে'],
        ['icon' => 'shield', 'text' => 'সার্টিফিকেট ভেরিফিকেশন এখন অনলাইনে'],
        ['icon' => 'target', 'text' => 'দক্ষতা উন্নয়নই আমাদের অঙ্গীকার'],
    ];
@endphp

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Branch Dashboard | BNYTI</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            :root {
                --branch-green: #087b3d;
                --branch-green-dark: #03592a;
                --branch-red: #d2111a;
                --branch-red-dark: #a80008;
            }

            .branch-dashboard {
                font-family: Inter, "Noto Sans Bengali", "Segoe UI", sans-serif;
            }

            .branch-canvas {
                background:
                    radial-gradient(circle at 64% 19%, rgb(8 123 61 / .08) 0 1px, transparent 1.3px) 0 0 / 7px 7px,
                    linear-gradient(145deg, #fff 0%, #f7f9fc 52%, #fff 100%);
                box-shadow: 0 20px 60px rgb(15 23 42 / .18);
            }

            .hero-grid {
                display: grid;
                grid-template-columns: minmax(0, 32fr) minmax(0, 36fr) minmax(0, 32fr);
            }



            .brand-panel {
                position: relative;
                z-index: 40;
                display: flex;
                min-height: 470px;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 20px 20px 40px;
                text-align: center;
            }

            .brand-condensed {
                font-family: Impact, "Arial Narrow", sans-serif;
                font-stretch: condensed;
            }

            .brand-bangladesh {
                color: #050505;
                font-size: clamp(40px, 3vw, 52px);
                letter-spacing: .015em;
                line-height: .92;
            }

            .brand-national {
                display: inline-block;
                margin-top: 4px;
                padding: 4px 18px 6px;
                border-radius: 7px;
                background: var(--branch-green);
                color: white;
                font-size: clamp(34px, 2.55vw, 45px);
                letter-spacing: .015em;
                line-height: .9;
            }

            .brand-institute-line {
                display: flex;
                width: min(100%, 520px);
                align-items: center;
                gap: 12px;
            }

            .brand-institute-line::before,
            .brand-institute-line::after {
                flex: 1;
                height: 2px;
                background: var(--branch-green);
                content: "";
            }

            .brand-institute-line p {
                white-space: nowrap;
                text-align: center;
                color: #050505;
                font-size: clamp(14px, 1.2vw, 21px);
                letter-spacing: .045em;
            }

            .greeting-title {
                margin-top: 12px;
                color: var(--branch-red);
                font-size: clamp(46px, 3.7vw, 60px);
                font-weight: 900;
                letter-spacing: -.055em;
                line-height: 1;
            }

            .greeting-title span:last-child {
                color: var(--branch-green);
            }

            .hero-left {
                clip-path: polygon(0 0, 37% 0, 31% 9%, 77% 18%, 93% 29%, 100% 48%, 98% 66%, 80% 100%, 0 100%);
            }

            .hero-left::before {
                content: "";
                position: absolute;
                inset: 0;
                z-index: 2;
                background:
                    linear-gradient(142deg, var(--branch-red) 0 11%, transparent 11.2%),
                    linear-gradient(145deg, transparent 0 10%, var(--branch-green) 10.2% 15%, transparent 15.2%),
                    linear-gradient(112deg, transparent 0 76%, rgb(210 17 26 / .95) 76.2% 77%, transparent 77.2%),
                    linear-gradient(112deg, transparent 0 78%, rgb(8 123 61 / .95) 78.2% 79%, transparent 79.2%);
                pointer-events: none;
            }

            .hero-left::after {
                content: "";
                position: absolute;
                inset: 42px 14px 0 30px;
                z-index: 1;
                border-radius: 55% 46% 0 0 / 18% 18% 0 0;
                background: rgb(255 255 255 / .9);
                box-shadow: 14px 0 32px rgb(15 23 42 / .1);
                transform: rotate(1deg);
            }

            .sun-badge {
                display: grid;
                width: 122px;
                height: 122px;
                place-items: center;
                border-radius: 999px;
                background: white;
                box-shadow: 0 10px 22px rgb(15 23 42 / .2), inset 0 0 0 6px rgb(255 255 255 / .9);
            }

            .greeting-badge-icon {
                font-family: "Segoe UI Emoji", "Apple Color Emoji", sans-serif;
                font-size: 68px;
                line-height: 1;
            }

            .greeting-content {
                position: relative;
                z-index: 10;
                display: flex;
                height: 100%;
                flex-direction: column;
                align-items: center;
                padding: 5% 24px 0;
                text-align: center;
            }

            .system-ribbon {
                flex: none;
                min-width: 82%;
                padding: 8px 22px;
                border: 2px solid white;
                outline: 2px solid #10231a;
                outline-offset: 3px;
                background: var(--branch-green);
                color: #07150d;
                font-size: clamp(12px, 1.02vw, 17px);
                font-weight: 900;
                letter-spacing: .05em;
                clip-path: polygon(4% 0, 96% 0, 100% 50%, 96% 100%, 4% 100%, 0 50%);
            }

            .brand-ribbon-row {
                display: flex;
                width: 100%;
                max-width: 550px;
                align-items: center;
                margin-top: 14px;
            }

            .lower-panel {
                padding: 1.6% 2.5% 1.2%;
                border-radius: 28px 28px 0 0;
                background: white;
                box-shadow: 0 -8px 24px rgb(15 23 42 / .08);
            }

            .notice-bar {
                display: flex;
                height: 74px;
                overflow: hidden;
                border: 6px solid white;
                border-radius: 22px;
                background: linear-gradient(90deg, #096c37, #025526);
                box-shadow: 0 8px 22px rgb(15 23 42 / .22);
            }

            .notice-label {
                display: flex;
                flex: none;
                align-items: center;
                gap: 12px;
                padding: 0 48px 0 32px;
                color: white;
                background: linear-gradient(90deg, var(--branch-red-dark), #e01821);
                clip-path: polygon(0 0, 86% 0, 100% 50%, 86% 100%, 0 100%);
            }

            .notice-track {
                min-width: max-content;
                animation: notice-scroll 34s linear infinite;
            }

            .notice-window:hover .notice-track {
                animation-play-state: paused;
            }

            .notice-view-all {
                display: inline-flex;
                flex: none;
                align-items: center;
                align-self: center;
                margin-right: 12px;
                padding: 8px 20px;
                border-radius: 9px;
                background: var(--branch-red);
                color: white;
                font-size: 12px;
                font-weight: 900;
                box-shadow: 0 5px 12px rgb(15 23 42 / .2);
            }

            .quick-card {
                position: relative;
                display: flex;
                min-height: 176px;
                flex-direction: column;
                align-items: center;
                padding: 75px 12px 12px;
                border: 1px solid #f1f5f9;
                border-radius: 17px;
                background: white;
                text-align: center;
                box-shadow: 0 10px 22px rgb(15 23 42 / .14);
                transition: translate .2s ease, box-shadow .2s ease;
            }

            .quick-grid {
                display: grid;
                grid-template-columns: repeat(6, minmax(0, 1fr));
                gap: 2.1%;
                margin-top: 1.7%;
            }

            .quick-icon {
                position: absolute;
                top: -8px;
                left: 50%;
                display: grid;
                width: 82px;
                height: 82px;
                translate: -50% 0;
                place-items: center;
                border: 7px solid white;
                border-radius: 999px;
                color: white;
                box-shadow: 0 8px 18px rgb(15 23 42 / .2);
            }

            .quick-card:hover {
                translate: 0 -5px;
                box-shadow: 0 16px 28px rgb(15 23 42 / .18);
            }

            .branch-footer {
                position: relative;
                display: flex;
                min-height: 47px;
                align-items: center;
                justify-content: center;
                margin-top: 1.5%;
                border-top: 1px solid #f1f5f9;
            }

            .footer-socials {
                position: absolute;
                left: 2%;
                z-index: 10;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .footer-site {
                position: absolute;
                right: 2%;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .sunrise-image {
                bottom: 0 !important;
            }

            .prayer-times-card {
                position: absolute;
                top: 7%;
                right: 4%;
                z-index: 20;
                width: 88%;
                padding: 20px 24px;
                border: 1px solid rgb(255 255 255 / .8);
                border-radius: 24px;
                background: rgb(255 255 255 / .96);
                box-shadow: 0 14px 40px rgb(15 23 42 / .12);
                backdrop-filter: blur(6px);
            }

            .prayer-times-grid {
                display: grid;
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
                margin-top: 14px;
            }

            .prayer-time-item {
                padding: 8px 10px;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                background: #f8fafc;
            }

            .prayer-time-item.is-next {
                border-color: rgb(8 123 61 / .35);
                background: #ecfdf5;
                box-shadow: 0 0 0 2px rgb(8 123 61 / .08);
            }

            .prayer-time-name {
                display: block;
                color: #64748b;
                font-size: 11px;
                font-weight: 800;
            }

            .prayer-time-value {
                display: block;
                margin-top: 2px;
                color: #0f172a;
                font-size: 14px;
                font-weight: 900;
            }

            @media (max-width: 1023px) {
                .prayer-times-card {
                    position: relative;
                    top: auto;
                    right: auto;
                    width: auto;
                    margin: 24px;
                }
            }

            @media (max-width: 639px) {
                .prayer-times-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            .footer-swoop {
                position: absolute;
                bottom: -20px;
                left: -3%;
                width: 34%;
                height: 70px;
                background: linear-gradient(90deg, var(--branch-green-dark), var(--branch-green));
                clip-path: ellipse(68% 100% at 10% 100%);
            }

            @keyframes notice-scroll {
                from { transform: translateX(0); }
                to { transform: translateX(-50%); }
            }

            @media (max-width: 1023px) {
                .branch-canvas {
                    aspect-ratio: auto;
                }

                .hero-grid {
                    display: block;
                    height: auto;
                }

                .quick-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 20px;
                    margin-top: 24px;
                }

                .hero-left {
                    clip-path: none;
                }

                .hero-left::before,
                .hero-left::after {
                    display: none;
                }
            }

            @media (min-width: 1024px) {
                .branch-canvas {
                    aspect-ratio: 1.88 / 1;
                }

                .hero-grid {
                    height: 56%;
                    min-height: 0;
                }

                .lower-panel {
                    height: 44%;
                }

                .brand-logo {
                    height: 35% !important;
                }

                .brand-panel {
                    min-height: 0;
                }

                .greeting-content {
                    align-items: flex-start;
                    padding-left: 11%;
                }
            }

            @media (max-width: 639px) {
                .quick-grid {
                    grid-template-columns: minmax(0, 1fr);
                }

                .notice-label {
                    padding-right: 38px;
                    padding-left: 18px;
                }

                .notice-view-all,
                .footer-site-label {
                    display: none;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                .notice-track {
                    animation: none;
                }

                .quick-card {
                    transition: none;
                }
            }
        </style>
    </head>

    <body class="branch-dashboard min-h-screen bg-[#edf1f5] text-slate-950 antialiased">
        <header class="fixed inset-x-0 top-0 z-50 border-b border-slate-900/5 bg-stone-50/95 backdrop-blur-xl">
            <div class="border-b border-slate-900/5 bg-ink text-white">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-2 text-[11px] font-semibold tracking-wide sm:px-6 lg:px-8">
                    <p class="flex items-center gap-2"><span class="size-1.5 rounded-full bg-emerald-400 shadow-[0_0_12px_#34d399]"></span>Branch management workspace</p>
                    <div class="hidden gap-5 sm:flex"><a href="tel:+8809696481628" class="hover:text-emerald-300">+880 9696-481628</a><a href="mailto:bnyti-edubd@gmail.com" class="hover:text-emerald-300">bnyti-edubd@gmail.com</a></div>
                </div>
            </div>

            <nav class="mx-auto flex h-[76px] max-w-7xl items-center justify-between gap-5 px-4 sm:px-6 lg:px-8" aria-label="Primary navigation">
                <a href="{{ route('home') }}#home" class="group flex min-w-0 items-center gap-3" aria-label="BNYTI home">
                    <img src="{{ asset('images/bnyti-logo.svg') }}" alt="Bangladesh National Youth Technical Institute logo" class="size-12 shrink-0 transition duration-300 group-hover:-rotate-3 sm:size-14">
                    <span class="hidden min-w-0 sm:block"><span class="block truncate text-sm font-black tracking-tight text-slate-950 sm:text-[15px]"><span class="text-emerald-600">BANGLADESH</span><span class="text-red-600"> NATIONAL</span></span><span class="block truncate text-[10px] font-bold tracking-[.17em] text-slate-600 sm:text-[11px]">YOUTH TECHNICAL INSTITUTE</span></span>
                    <span class="sm:hidden"><span class="block text-base font-black tracking-tight text-slate-950">BNYTI</span><span class="block text-[9px] font-bold tracking-[.14em] text-slate-500">TECHNICAL INSTITUTE</span></span>
                </a>

                <div class="hidden items-center gap-7 lg:flex">
                    <a href="{{ route('home') }}#home" class="nav-link active">Home</a>
                    <a href="{{ route('home') }}#courses" class="nav-link">Courses</a>
                    <a href="{{ route('home') }}#about" class="nav-link">About</a>
                    <a href="{{ route('home') }}#branch-application-promo" class="nav-link">Branches</a>
                    <a href="{{ route('results.index') }}" class="nav-link">Results</a>
                    <details class="group relative">
                        <summary class="nav-link flex cursor-pointer list-none items-center gap-1">Apply Now <svg viewBox="0 0 24 24" class="size-4 transition group-open:rotate-180" aria-hidden="true"><path d="m6 9 6 6 6-6" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg></summary>
                        <div class="absolute right-0 top-full z-50 mt-3 w-52 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl">
                            <a href="{{ route('student-registrations.create') }}" class="block rounded-xl px-4 py-3 text-sm font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">Student Registration</a>
                            <a href="{{ route('branch-applications.create') }}" class="block rounded-xl px-4 py-3 text-sm font-bold text-slate-700 hover:bg-emerald-50 hover:text-emerald-700">Branch Registration</a>
                        </div>
                    </details>
                    <a href="{{ route('home') }}#latest-news-contact" class="nav-link">Contact</a>
                </div>

                <div class="flex shrink-0 items-center gap-2">
                    <form method="POST" action="{{ route('logout') }}" class="hidden lg:block">
                        @csrf
                        <button type="submit" aria-label="Log out of the branch dashboard" class="inline-flex min-h-10 items-center gap-2 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-xs font-black text-red-700 transition hover:border-red-300 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 17l5-5-5-5M15 12H3"/><path d="M21 3v18"/></svg>
                            Logout
                        </button>
                    </form>
                    <button type="button" class="icon-button" data-theme-toggle aria-label="Toggle color theme">
                        <svg data-theme-sun viewBox="0 0 24 24" aria-hidden="true" class="size-5"><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 2v2M12 20v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l-1.42 1.42m11.3-11.3 1.42-1.42" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.8"/></svg>
                        <svg data-theme-moon viewBox="0 0 24 24" aria-hidden="true" class="hidden size-5"><path d="M20 15.1A8.5 8.5 0 0 1 8.9 4a8.5 8.5 0 1 0 11.1 11.1Z" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.8"/></svg>
                    </button>
                    <button type="button" class="icon-button lg:hidden" data-menu-toggle aria-expanded="false" aria-controls="branch-dashboard-mobile-menu" aria-label="Open menu">
                        <svg data-menu-open viewBox="0 0 24 24" aria-hidden="true" class="size-6"><path d="M4 7h16M4 12h16M4 17h16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                        <svg data-menu-close viewBox="0 0 24 24" aria-hidden="true" class="hidden size-6"><path d="m6 6 12 12M18 6 6 18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2"/></svg>
                    </button>
                </div>
            </nav>

            <div id="branch-dashboard-mobile-menu" class="border-t border-slate-900/5 bg-stone-50 px-4 py-5 shadow-2xl lg:hidden" data-mobile-menu hidden>
                <nav class="mx-auto grid max-w-7xl gap-1" aria-label="Mobile navigation">
                    <a href="{{ route('home') }}#home" class="mobile-nav-link">Home</a>
                    <a href="{{ route('home') }}#courses" class="mobile-nav-link">Courses</a>
                    <a href="{{ route('home') }}#about" class="mobile-nav-link">About</a>
                    <a href="{{ route('home') }}#branch-application-promo" class="mobile-nav-link">Branches</a>
                    <a href="{{ route('results.index') }}" class="mobile-nav-link">Results</a>
                    <p class="px-4 pt-3 text-xs font-black uppercase tracking-widest text-emerald-700">Apply Now</p>
                    <a href="{{ route('student-registrations.create') }}" class="mobile-nav-link pl-8">Student Registration</a>
                    <a href="{{ route('branch-applications.create') }}" class="mobile-nav-link pl-8">Branch Registration</a>
                    <a href="{{ route('home') }}#latest-news-contact" class="mobile-nav-link">Contact</a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-3 border-t border-slate-200 pt-3">
                        @csrf
                        <button type="submit" class="mobile-nav-link w-full text-left font-black text-red-700">Logout</button>
                    </form>
                </nav>
            </div>
        </header>

        <main class="flex min-h-screen items-center justify-center p-0 pt-[108px]">
            <div class="branch-canvas relative w-full max-w-none overflow-hidden bg-white">
                <section class="hero-grid relative min-h-[500px] overflow-hidden">
                    <div class="hero-left relative isolate min-h-[470px] overflow-hidden bg-white lg:min-h-0">
                        <img src="{{ asset('images/dashboard/sunrise.png') }}" alt="" class="sunrise-image absolute inset-x-0 bottom-0 z-[3] h-[46%] w-full object-cover object-bottom">
                        <div class="absolute inset-x-0 bottom-[34%] z-[4] h-[20%] bg-gradient-to-b from-white via-white/80 to-transparent"></div>

                        <div class="greeting-content">
                            <div class="sun-badge">
                                <span id="dashboard-greeting-badge-icon" class="greeting-badge-icon" aria-hidden="true">🌞</span>
                            </div>

                            <div class="mt-[-2px] w-full max-w-[355px] lg:ml-[4%]">
                                <span class="inline-flex rounded-[10px] bg-gradient-to-r from-[#03592a] to-[#087b3d] px-5 py-1 text-lg font-black text-white shadow-md">শুভেচ্ছা</span>
                                <h1 id="dashboard-greeting-title" class="greeting-title" aria-live="polite">
                                    <span id="dashboard-greeting-primary" class="text-[#bc0d16]">শুভ</span>
                                    <span id="dashboard-greeting-secondary" class="text-[#087b3d]">সকাল!</span>
                                </h1>

                                <div class="mx-auto my-4 flex max-w-[300px] items-center">
                                    <span class="h-[2px] flex-1 bg-gradient-to-r from-transparent to-[#d71920]"></span>
                                    <span class="mx-2 size-2 rotate-45 bg-[#d71920]"></span>
                                    <span class="size-2 rotate-45 bg-[#087b3d]"></span>
                                    <span class="h-[2px] flex-1 bg-gradient-to-r from-[#087b3d] to-transparent"></span>
                                </div>

                                <p id="dashboard-greeting-message" class="text-[18px] font-semibold leading-[1.75] text-slate-900 xl:text-[21px]" aria-live="polite">
                                    আপনার আজকের দিনটি সফল ও ফলপ্রসূ হোক।
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="brand-panel">
                        <svg viewBox="0 0 100 34" class="absolute left-5 top-8 hidden w-20 text-slate-950 lg:block" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2.2" aria-hidden="true">
                            <path d="M2 24Q9 16 16 24Q23 16 30 24"/>
                            <path d="M28 10Q35 3 42 10Q49 3 56 10"/>
                            <path d="M59 25Q66 17 73 25Q80 17 87 25"/>
                            <path d="M68 8Q73 3 78 8Q83 3 88 8"/>
                        </svg>

                        <img src="{{ asset('images/bnyti-logo.svg') }}" alt="Bangladesh National Youth Technical Institute logo" class="brand-logo">

                        <div class="brand-condensed mt-4 uppercase">
                            <p class="brand-bangladesh">Bangladesh</p>
                            <p class="brand-national">National Youth</p>
                        </div>

                        <div class="brand-institute-line mt-3">
                            <p class="font-black">TECHNICAL INSTITUTE</p>
                        </div>

                        <div class="brand-ribbon-row">
                            <span class="relative h-0.5 flex-1 bg-gradient-to-r from-transparent to-[#087b3d]"><span class="absolute right-0 top-1/2 size-2 -translate-y-1/2 rotate-45 bg-[#087b3d]"></span></span>
                            <span class="system-ribbon shadow-md">BRANCH MANAGEMENT SYSTEM</span>
                            <span class="relative h-0.5 flex-1 bg-gradient-to-l from-transparent to-[#087b3d]"><span class="absolute left-0 top-1/2 size-2 -translate-y-1/2 rotate-45 bg-[#087b3d]"></span></span>
                        </div>
                    </div>

                    <div class="relative min-h-[470px] overflow-hidden bg-gradient-to-b from-white via-white to-sky-50 lg:min-h-0">
                        <section class="prayer-times-card" aria-labelledby="prayer-times-heading">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <h2 id="prayer-times-heading" class="text-base font-black text-slate-950">Today's Prayer Times</h2>
                                    <p id="prayer-times-date" class="mt-1 text-xs font-medium text-slate-500">Dhaka, Bangladesh</p>
                                </div>
                                <div class="flex items-center gap-2 text-right">
                                    <svg viewBox="0 0 24 24" class="size-5 shrink-0 text-[#087b3d]" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9" />
                                        <path d="M12 7v5l3 2" />
                                    </svg>
                                    <div>
                                        <p id="prayer-current-time" class="whitespace-nowrap text-sm font-black leading-none text-slate-950" aria-live="polite">--:--:--</p>
                                        <p class="mt-1 text-[10px] font-bold uppercase tracking-wide text-slate-400">Dhaka Time</p>
                                    </div>
                                </div>
                            </div>

                            <div id="prayer-times-grid" class="prayer-times-grid" aria-live="polite"></div>
                            <p class="mt-3 text-[10px] font-medium text-slate-400">Live timings from Aladhan API · Dhaka, Bangladesh</p>
                        </section>

                    </div>
                </section>

                <section class="lower-panel relative z-20">
                    <div class="notice-bar">
                        <div class="notice-label">
                            <svg viewBox="0 0 24 24" class="size-9" fill="currentColor" aria-hidden="true"><path d="M3 10v4h3l5 4V6L6 10H3Zm11.5 2a4.5 4.5 0 0 0-2.5-4.03v8.06A4.5 4.5 0 0 0 14.5 12ZM12 3.23v2.06a7 7 0 0 1 0 13.42v2.06A9 9 0 0 0 12 3.23Z"/></svg>
                            <span class="text-xl font-black sm:text-2xl">নোটিশ</span>
                        </div>

                        <div class="notice-window min-w-0 flex-1 overflow-hidden">
                            <div class="notice-track flex h-full items-center">
                                @foreach (array_merge($notices, $notices) as $notice)
                                    <div class="flex shrink-0 items-center gap-3 border-r border-white/60 px-6 text-white">
                                        @if ($notice['icon'] === 'cap')
                                            <svg viewBox="0 0 24 24" class="size-7 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m2 9 10-5 10 5-10 5L2 9Z"/><path d="M6 11v5c3 3 9 3 12 0v-5M22 9v6"/></svg>
                                        @elseif ($notice['icon'] === 'shield')
                                            <svg viewBox="0 0 24 24" class="size-7 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3Z"/><path d="m9 12 2 2 4-4"/></svg>
                                        @elseif ($notice['icon'] === 'target')
                                            <svg viewBox="0 0 24 24" class="size-7 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/><path d="m15 9 6-6M17 3h4v4"/></svg>
                                        @else
                                            <svg viewBox="0 0 24 24" class="size-7 shrink-0" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 3h13v18H4z"/><path d="M8 7h5M8 11h5M8 15h3"/></svg>
                                        @endif
                                        <span class="whitespace-nowrap text-sm font-bold">{{ $notice['text'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ $homeUrl }}#latest-news-contact" class="notice-view-all">View All&nbsp; ›</a>
                    </div>

                    <div class="quick-grid">
                        @foreach ($quickMenus as $item)
                            @php
                                $isGreen = $item['tone'] === 'green';
                                $mainColor = $isGreen ? '#087b3d' : '#d2111a';
                                $darkColor = $isGreen ? '#045b2c' : '#a90008';
                            @endphp

                            <a href="{{ $item['href'] }}" class="quick-card group" style="border-bottom: 4px solid {{ $mainColor }}">
                                <span class="quick-icon" style="background: linear-gradient(145deg, {{ $mainColor }}, {{ $darkColor }});">
                                    @switch($item['icon'])
                                        @case('admission')
                                            <svg viewBox="0 0 24 24" class="size-11" fill="currentColor" aria-hidden="true"><circle cx="10" cy="7" r="4"/><path d="M3 21v-2a7 7 0 0 1 14 0v2h-3v-2a4 4 0 0 0-8 0v2H3Zm16-12v3h-3v3h3v3h3v-3h3v-3h-3V9h-3Z"/></svg>
                                            @break
                                        @case('students')
                                            <svg viewBox="0 0 24 24" class="size-11" fill="currentColor" aria-hidden="true"><circle cx="12" cy="7" r="4"/><circle cx="4.5" cy="9.5" r="3"/><circle cx="19.5" cy="9.5" r="3"/><path d="M5 20c.2-4 2.5-6 7-6s6.8 2 7 6H5ZM0 20c.1-3 1.5-5 4.5-5 1 0 1.8.2 2.5.6A7 7 0 0 0 3.5 20H0Zm24 0h-3.5a7 7 0 0 0-3.5-4.4c.7-.4 1.5-.6 2.5-.6 3 0 4.4 2 4.5 5Z"/></svg>
                                            @break
                                        @case('certificate')
                                            <svg viewBox="0 0 24 24" class="size-11" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><rect x="3" y="3" width="14" height="18" rx="1"/><path d="M7 7h6M7 11h6M15 15l6 6M18 14a3 3 0 1 1 0 6 3 3 0 0 1 0-6Z"/></svg>
                                            @break
                                        @case('branch')
                                            <svg viewBox="0 0 24 24" class="size-11" fill="currentColor" aria-hidden="true"><path d="M3 22V8l6-3v17H3Zm8 0V2l10 4v16H11ZM5 11h2v2H5v-2Zm0 4h2v2H5v-2Zm9-9h2v3h-2V6Zm4 1h2v3h-2V7Zm-4 5h2v3h-2v-3Zm4 0h2v3h-2v-3Zm-4 6h5v4h-5v-4Z"/></svg>
                                            @break
                                        @case('notice')
                                            <svg viewBox="0 0 24 24" class="size-11" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 4h18v16H3z"/><path d="M7 8h4v4H7zM14 8h4M14 12h4M7 16h11"/></svg>
                                            @break
                                        @default
                                            <svg viewBox="0 0 24 24" class="size-11" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="M4 13v-2a8 8 0 0 1 16 0v2M4 13H2v5h4v-5H4ZM20 13h2v5h-4v-5h2ZM18 20c-1 1-3 1-5 1"/></svg>
                                    @endswitch
                                </span>

                                <h3 class="text-[16px] font-black leading-tight" style="color: {{ $mainColor }}">{{ $item['title'] }}</h3>
                                <p class="mt-1 text-sm font-medium text-slate-700">{{ $item['subtitle'] }}</p>
                                <span class="mt-auto grid size-5 place-items-center rounded-full text-xs font-black text-white transition-transform group-hover:translate-x-1" style="background: {{ $mainColor }}">›</span>
                            </a>
                        @endforeach
                    </div>

                    <footer class="branch-footer">
                        <div class="footer-swoop"></div>

                        <div class="footer-socials">
                            @foreach ([['f', '#1877f2'], ['▶', '#e62117'], ['in', '#0a66c2'], ['◎', '#087b3d']] as [$text, $color])
                                <span class="grid size-8 place-items-center rounded-full border-2 border-white text-xs font-black text-white shadow" style="background: {{ $color }}">{{ $text }}</span>
                            @endforeach
                        </div>

                        <div class="flex items-center gap-4 px-[28%] text-center text-lg italic tracking-wide text-[#087b3d] sm:text-2xl">
                            <span class="hidden h-px w-16 bg-[#087b3d] xl:block"></span>
                            <span class="whitespace-nowrap font-semibold">Learn Today, Lead Tomorrow</span>
                            <span class="hidden h-px w-16 bg-[#087b3d] xl:block"></span>
                        </div>

                        <div class="footer-site text-sm font-semibold text-slate-700 sm:text-base">
                            <svg viewBox="0 0 24 24" class="size-7 text-[#087b3d]" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18M12 3a14 14 0 0 0 0 18"/></svg>
                            <span class="footer-site-label">www.bnyti.edu.bd</span>
                        </div>
                    </footer>
                </section>

            </div>
        </main>

        <script>
            (() => {
                const greetingBadgeIconElement = document.getElementById('dashboard-greeting-badge-icon');
                const greetingPrimaryElement = document.getElementById('dashboard-greeting-primary');
                const greetingSecondaryElement = document.getElementById('dashboard-greeting-secondary');
                const greetingMessageElement = document.getElementById('dashboard-greeting-message');
                const prayerDateElement = document.getElementById('prayer-times-date');
                const prayerGridElement = document.getElementById('prayer-times-grid');
                const prayerCurrentTimeElement = document.getElementById('prayer-current-time');
                const timeZone = 'Asia/Dhaka';
                let currentGreetingKey = null;
                let currentPrayerDateKey = null;
                let prayerTimings = null;
                let prayerTimesRequest = null;
                let prayerRetryAt = 0;

                const greetings = {
                    morning: { icon: '🌞', title: 'শুভ সকাল!', message: 'আপনার আজকের দিনটি সফল ও ফলপ্রসূ হোক।' },
                    afternoon: { icon: '🌤️', title: 'শুভ দুপুর!', message: 'আপনার সকল কার্যক্রম সফলভাবে সম্পন্ন হোক।' },
                    evening: { icon: '🌇', title: 'শুভ বিকেল!', message: 'নতুন উদ্যমে আপনার কাজ এগিয়ে নিন।' },
                    nightfall: { icon: '🌆', title: 'শুভ সন্ধ্যা!', message: 'শেখার প্রতিটি মুহূর্ত হোক আনন্দময়।' },
                    night: { icon: '🌙', title: 'শুভ রাত্রি!', message: 'আগামী দিনের জন্য আন্তরিক শুভকামনা।' },
                };

                const greetingKeyForHour = (hour) => {
                    if (hour >= 5 && hour < 12) {
                        return 'morning';
                    }

                    if (hour >= 12 && hour < 16) {
                        return 'afternoon';
                    }

                    if (hour >= 16 && hour < 18) {
                        return 'evening';
                    }

                    if (hour >= 18 && hour < 20) {
                        return 'nightfall';
                    }

                    return 'night';
                };

                const updateGreeting = (hour) => {
                    const key = greetingKeyForHour(hour);

                    if (key === currentGreetingKey) {
                        return;
                    }

                    const greeting = greetings[key];
                    const [primary, ...secondary] = greeting.title.split(' ');
                    greetingBadgeIconElement.textContent = greeting.icon;
                    greetingPrimaryElement.textContent = primary;
                    greetingSecondaryElement.textContent = secondary.join(' ');
                    greetingMessageElement.textContent = greeting.message;
                    currentGreetingKey = key;
                };

                const getDhakaDateParts = (now) => new Intl.DateTimeFormat('en-CA', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    timeZone,
                }).formatToParts(now).reduce((parts, part) => {
                    parts[part.type] = part.value;

                    return parts;
                }, {});

                const formatPrayerTime = (value) => {
                    const [hours, minutes] = value.match(/^\d{1,2}:\d{2}/)?.[0].split(':') ?? [];
                    const date = new Date(Date.UTC(2000, 0, 1, Number(hours), Number(minutes)));

                    return new Intl.DateTimeFormat('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true,
                        timeZone: 'UTC',
                    }).format(date);
                };

                const prayerTimeInMinutes = (value) => {
                    const [hours, minutes] = value.match(/^\d{1,2}:\d{2}/)?.[0].split(':') ?? [];

                    return Number(hours) * 60 + Number(minutes);
                };

                const currentDhakaMinutes = (now) => {
                    const parts = new Intl.DateTimeFormat('en-GB', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false,
                        timeZone,
                    }).formatToParts(now);

                    return Number(parts.find((part) => part.type === 'hour')?.value ?? 0) * 60
                        + Number(parts.find((part) => part.type === 'minute')?.value ?? 0);
                };

                const renderPrayerTimes = (now) => {
                    const entries = [
                        ['Fajr', prayerTimings.Fajr, true],
                        ['Sunrise', prayerTimings.Sunrise, false],
                        ['Dhuhr', prayerTimings.Dhuhr, true],
                        ['Asr', prayerTimings.Asr, true],
                        ['Maghrib', prayerTimings.Maghrib, true],
                        ['Isha', prayerTimings.Isha, true],
                    ];
                    const currentMinutes = currentDhakaMinutes(now);
                    const nextPrayer = entries.find(([, time, isPrayer]) => isPrayer && prayerTimeInMinutes(time) > currentMinutes)?.[0];

                    prayerGridElement.replaceChildren(...entries.map(([name, time]) => {
                        const item = document.createElement('div');
                        const nameElement = document.createElement('span');
                        const timeElement = document.createElement('span');

                        item.className = `prayer-time-item${name === nextPrayer ? ' is-next' : ''}`;
                        nameElement.className = 'prayer-time-name';
                        nameElement.textContent = `${name}${name === nextPrayer ? ' · Next' : ''}`;
                        timeElement.className = 'prayer-time-value';
                        timeElement.textContent = formatPrayerTime(time);
                        item.append(nameElement, timeElement);

                        return item;
                    }));
                };

                const showPrayerTimesUnavailable = () => {
                    prayerDateElement.textContent = 'Dhaka, Bangladesh';
                    prayerGridElement.replaceChildren();
                    const message = document.createElement('p');
                    message.className = 'col-span-full py-3 text-center text-sm font-semibold text-slate-500';
                    message.textContent = 'Prayer times are temporarily unavailable. Please try again shortly.';
                    prayerGridElement.append(message);
                };

                const fetchPrayerTimes = async (now) => {
                    const { day, month, year } = getDhakaDateParts(now);
                    const dateKey = `${day}-${month}-${year}`;
                    const cacheKey = `bnyti-prayer-times-${dateKey}`;

                    if (dateKey === currentPrayerDateKey && prayerTimings) {
                        renderPrayerTimes(now);

                        return;
                    }

                    if (prayerTimesRequest) {
                        return;
                    }

                    if (Date.now() < prayerRetryAt) {
                        return;
                    }

                    try {
                        const cachedTimings = JSON.parse(window.localStorage.getItem(cacheKey) ?? 'null');

                        if (cachedTimings) {
                            prayerTimings = cachedTimings;
                        } else {
                            prayerTimesRequest = fetch(`https://api.aladhan.com/v1/timingsByCity/${dateKey}?city=Dhaka&country=Bangladesh&method=1&school=1`, {
                                headers: { Accept: 'application/json' },
                            });
                            const response = await prayerTimesRequest;

                            if (!response.ok) {
                                throw new Error('Prayer-times service request failed.');
                            }

                            const payload = await response.json();
                            const timings = payload?.data?.timings;

                            if (!timings || !['Fajr', 'Sunrise', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'].every((name) => typeof timings[name] === 'string')) {
                                throw new Error('Prayer-times service returned incomplete data.');
                            }

                            prayerTimings = timings;
                            window.localStorage.setItem(cacheKey, JSON.stringify(timings));
                        }

                        currentPrayerDateKey = dateKey;
                        prayerDateElement.textContent = new Intl.DateTimeFormat('en-GB', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric',
                            timeZone,
                        }).format(now) + ' · Dhaka';
                        renderPrayerTimes(now);
                    } catch (error) {
                        currentPrayerDateKey = null;
                        prayerTimings = null;
                        prayerRetryAt = Date.now() + 5 * 60 * 1000;
                        showPrayerTimesUnavailable();
                    } finally {
                        prayerTimesRequest = null;
                    }
                };

                const updateClock = () => {
                    const now = new Date();
                    const hourText = new Intl.DateTimeFormat('en-GB', {
                        hour: '2-digit',
                        hour12: false,
                        timeZone,
                    }).format(now);
                    const hour = Number(hourText) === 24 ? 0 : Number(hourText);
                    updateGreeting(hour);
                    prayerCurrentTimeElement.textContent = new Intl.DateTimeFormat('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true,
                        timeZone,
                    }).format(now);
                    void fetchPrayerTimes(now);
                };

                updateClock();
                window.setInterval(updateClock, 1000);
            })();
        </script>
    </body>
</html>

@php
    $branchName = $branchName ?? 'Dhaka Main Branch';
    $branchCode = $branchCode ?? 'BNY-DHA-001';
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

            .brand-logo {
                display: block;
                width: 220px !important;
                max-width: 42% !important;
                height: 170px !important;
                object-fit: contain;
            }

            .brand-panel {
                position: relative;
                z-index: 40;
                display: flex;
                min-height: 470px;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 20px 20px 84px;
                text-align: center;
            }

            .brand-condensed {
                font-family: Impact, "Arial Narrow", sans-serif;
                font-stretch: condensed;
            }

            .brand-bangladesh {
                color: var(--branch-red);
                font-size: clamp(42px, 3.25vw, 55px);
                letter-spacing: .01em;
            }

            .brand-national {
                color: var(--branch-green);
                font-size: clamp(38px, 2.8vw, 49px);
                letter-spacing: .01em;
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
                min-width: 74%;
                padding: 8px 24px;
                background: linear-gradient(90deg, var(--branch-green), var(--branch-green-dark));
                color: white;
                font-size: clamp(13px, 1.1vw, 18px);
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

            .branch-info-card {
                position: absolute;
                top: 7%;
                right: 4%;
                z-index: 20;
                width: 88%;
                padding: 6% 7%;
                border: 1px solid rgb(255 255 255 / .8);
                border-radius: 38px;
                background: rgb(255 255 255 / .94);
                box-shadow: 0 14px 40px rgb(15 23 42 / .15);
                backdrop-filter: blur(6px);
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

            .building-image {
                position: absolute;
                right: 0;
                bottom: 0;
                left: 0;
                z-index: 10;
                width: 100%;
                height: 58%;
                object-fit: cover;
                object-position: right bottom;
            }

            .sunrise-image {
                bottom: 0 !important;
            }

            .country-flag {
                position: absolute;
                top: 31%;
                right: 5px;
                z-index: 20;
                width: 68px;
                height: 152px;
                overflow: visible;
                filter: drop-shadow(0 3px 2px rgb(15 23 42 / .12));
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
                    width: min(220px, 36%) !important;
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
        <main class="flex min-h-screen items-center justify-center p-0 sm:p-3">
            <div class="branch-canvas relative w-full max-w-[1600px] overflow-hidden bg-white sm:rounded-[26px] sm:border sm:border-slate-200">
                <section class="hero-grid relative min-h-[500px] overflow-hidden">
                    <div class="hero-left relative isolate min-h-[470px] overflow-hidden bg-white lg:min-h-0">
                        <img src="{{ asset('images/dashboard/sunrise.png') }}" alt="" class="sunrise-image absolute inset-x-0 bottom-0 z-[3] h-[46%] w-full object-cover object-bottom">
                        <div class="absolute inset-x-0 bottom-[34%] z-[4] h-[20%] bg-gradient-to-b from-white via-white/80 to-transparent"></div>

                        <div class="greeting-content">
                            <div class="sun-badge">
                                <svg viewBox="0 0 100 100" class="size-[86px]" aria-hidden="true">
                                    <g stroke="#ffbd12" stroke-linecap="round" stroke-width="5">
                                        <path d="M50 5v13M50 82v13M5 50h13M82 50h13M18 18l9 9M73 73l9 9M82 18l-9 9M27 73l-9 9"/>
                                    </g>
                                    <circle cx="50" cy="50" r="22" fill="#ffc21c"/>
                                </svg>
                            </div>

                            <div class="mt-[-2px] w-full max-w-[355px] lg:ml-[4%]">
                                <span class="inline-flex rounded-[10px] bg-gradient-to-r from-[#a90008] to-[#d71920] px-5 py-1 text-lg font-black text-white shadow-md">শুভেচ্ছা</span>
                                <h1 id="dashboard-greeting-title" class="greeting-title" aria-live="polite">
                                    <span id="dashboard-greeting-icon" class="mr-2 text-[.72em]" aria-hidden="true">🌞</span>
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

                        <img src="{{ asset('images/dashboard/bnyti-branch-logo.svg') }}" alt="BNYTI logo" class="brand-logo">

                        <div class="brand-condensed mt-2 uppercase leading-[.88]">
                            <p class="brand-bangladesh">Bangladesh</p>
                            <p class="brand-national">National Youth</p>
                        </div>

                        <div class="mt-3 flex w-full max-w-[520px] items-center gap-3">
                            <span class="h-px flex-1 bg-slate-900"></span>
                            <p class="whitespace-nowrap text-base font-black tracking-[.06em] sm:text-xl lg:text-[1.25vw] xl:text-[22px]">TECHNICAL INSTITUTE</p>
                            <span class="h-px flex-1 bg-slate-900"></span>
                        </div>

                        <div class="brand-ribbon-row">
                            <span class="relative h-0.5 flex-1 bg-gradient-to-r from-transparent to-[#087b3d]"><span class="absolute right-0 top-1/2 size-2 -translate-y-1/2 rotate-45 bg-[#d71920]"></span></span>
                            <span class="system-ribbon shadow-md">BRANCH MANAGEMENT SYSTEM</span>
                            <span class="relative h-0.5 flex-1 bg-gradient-to-l from-transparent to-[#087b3d]"><span class="absolute left-0 top-1/2 size-2 -translate-y-1/2 rotate-45 bg-[#d71920]"></span></span>
                        </div>
                    </div>

                    <div class="relative min-h-[470px] overflow-hidden bg-gradient-to-b from-white via-white to-sky-50 lg:min-h-0">
                        <div class="branch-info-card">
                            <div class="grid grid-cols-2 divide-x divide-slate-300">
                                <div class="flex items-start gap-3 pr-4">
                                    <svg viewBox="0 0 24 24" class="mt-0.5 size-10 shrink-0 text-[#087b3d]" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg>
                                    <div>
                                        <p id="dashboard-date" class="whitespace-nowrap text-base font-black sm:text-lg lg:text-[1.1vw] xl:text-[19px]"></p>
                                        <p id="dashboard-day" class="mt-1 text-sm text-slate-500"></p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 pl-5">
                                    <svg viewBox="0 0 24 24" class="mt-0.5 size-10 shrink-0 text-[#d2111a]" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 6v6l4 2"/></svg>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p id="dashboard-time" class="text-2xl font-black leading-none lg:text-[1.65vw] xl:text-[28px]"></p>
                                            <span id="dashboard-ampm" class="rounded bg-[#d2111a] px-2 py-1 text-[10px] font-black text-white"></span>
                                        </div>
                                        <p class="mt-1 text-sm text-slate-500">Local Time</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 border-t border-slate-200 pt-5">
                                <div class="flex items-start gap-4">
                                    <svg viewBox="0 0 24 24" class="size-12 shrink-0 text-[#087b3d]" fill="currentColor" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.2 7 13 7 13s7-7.8 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5.5Z"/></svg>
                                    <div>
                                        <h2 class="text-xl font-black lg:text-[1.3vw] xl:text-[22px]">{{ $branchName }}</h2>
                                        <p class="mt-1 text-sm font-medium text-slate-500">Branch Code: <span class="font-black text-[#d2111a]">{{ $branchCode }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img src="{{ asset('images/dashboard/building.png') }}" alt="BNYTI technical institute building" class="building-image">
                        <div class="absolute inset-x-0 bottom-0 z-[11] h-[20%] bg-gradient-to-t from-white/15 to-transparent"></div>
                        <svg viewBox="0 0 70 125" class="country-flag" role="img" aria-labelledby="bangladesh-flag-title">
                            <title id="bangladesh-flag-title">Bangladesh flag</title>
                            <circle cx="17" cy="5" r="3.2" fill="#5b3b20"/>
                            <path d="M17 6V121" stroke="#5b3b20" stroke-linecap="round" stroke-width="2.6"/>
                            <path d="M19 14C30 19 42 12 61 17V68C44 63 31 70 19 65Z" fill="#087b3d"/>
                            <path d="M19 14C30 19 42 12 61 17" fill="none" stroke="#069447" stroke-linecap="round" stroke-width="1.5"/>
                            <circle cx="40" cy="41" r="11.5" fill="#ed1c24"/>
                        </svg>
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

                <form method="POST" action="{{ route('logout') }}" class="absolute right-4 top-4 z-50">
                    @csrf
                    <button type="submit" aria-label="Log out of the branch dashboard" class="inline-flex min-h-11 items-center gap-2 rounded-full border border-white/30 bg-slate-950/80 px-4 py-2 text-xs font-bold text-white shadow-lg shadow-slate-950/20 backdrop-blur transition hover:bg-[#087b3d] focus:outline-none focus:ring-2 focus:ring-[#087b3d] focus:ring-offset-2">
                        <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M10 17l5-5-5-5M15 12H3"/><path d="M21 3v18"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </main>

        <script>
            (() => {
                const dateElement = document.getElementById('dashboard-date');
                const dayElement = document.getElementById('dashboard-day');
                const timeElement = document.getElementById('dashboard-time');
                const ampmElement = document.getElementById('dashboard-ampm');
                const greetingIconElement = document.getElementById('dashboard-greeting-icon');
                const greetingPrimaryElement = document.getElementById('dashboard-greeting-primary');
                const greetingSecondaryElement = document.getElementById('dashboard-greeting-secondary');
                const greetingMessageElement = document.getElementById('dashboard-greeting-message');
                const timeZone = 'Asia/Dhaka';
                let currentGreetingKey = null;

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
                    greetingIconElement.textContent = greeting.icon;
                    greetingPrimaryElement.textContent = primary;
                    greetingSecondaryElement.textContent = secondary.join(' ');
                    greetingMessageElement.textContent = greeting.message;
                    currentGreetingKey = key;
                };

                const updateClock = () => {
                    const now = new Date();
                    dateElement.textContent = new Intl.DateTimeFormat('en-GB', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric',
                        timeZone,
                    }).format(now);
                    dayElement.textContent = new Intl.DateTimeFormat('en-US', { weekday: 'long', timeZone }).format(now);

                    const hourText = new Intl.DateTimeFormat('en-GB', {
                        hour: '2-digit',
                        hour12: false,
                        timeZone,
                    }).format(now);
                    const hour = Number(hourText) === 24 ? 0 : Number(hourText);
                    updateGreeting(hour);

                    const parts = new Intl.DateTimeFormat('en-US', {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true,
                        timeZone,
                    }).formatToParts(now);

                    timeElement.textContent = `${parts.find((part) => part.type === 'hour')?.value ?? '00'}:${parts.find((part) => part.type === 'minute')?.value ?? '00'}`;
                    ampmElement.textContent = parts.find((part) => part.type === 'dayPeriod')?.value ?? '';
                };

                updateClock();
                window.setInterval(updateClock, 1000);
            })();
        </script>
    </body>
</html>

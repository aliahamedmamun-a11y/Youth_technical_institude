<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="theme-color" content="#15803d">
        <meta name="description" content="Register as a student at Bangladesh National Youth Technical Institute.">
        <title>Student Registration | BNYTI</title>
        <link rel="icon" href="{{ asset('images/bnyti-logo.svg') }}" type="image/svg+xml">
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen overflow-x-hidden bg-[#d9e7ed] text-slate-900 antialiased dark:bg-ink dark:text-white">
        <a href="#main-content" class="fixed top-3 left-3 z-[100] -translate-y-20 rounded-full bg-emerald-500 px-5 py-3 text-sm font-bold text-ink transition focus:translate-y-0">Skip to content</a>

        <main id="main-content" class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="mt-7">
                <x-student-form :courses="$courses" :action="route('student-registrations.store')" :cancel-route="route('home')" submit-label="Submit registration" declaration-required />
            </div>
        </main>

        <footer class="mt-12 border-t border-slate-300 bg-[#e1ecef] py-10 dark:bg-deep dark:border-white/10">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
                @foreach ([
                    ['Trusted & Verified', 'Government Registered', 'M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['Quality Technical Education', 'Practical & Skill Based', 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.989-2.386l-.548-.547z'],
                    ['Bright Future', 'Build Your Career', 'M13 10V3L4 14h7v7l9-11h-7z'],
                    ['Support 24/7', '+880 9696-481628', 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z']
                ] as [$title, $body, $icon])
                    <div class="flex items-center gap-4">
                        <div class="grid size-12 shrink-0 place-items-center rounded-full bg-[#8c7447] text-white shadow-lg">
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="{{ $icon }}" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div>
                            <strong class="block text-[11px] font-black uppercase tracking-wider text-[#03224c] dark:text-white">{{ $title }}</strong>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tighter">{{ $body }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-10 border-t border-slate-300 pt-8 text-center text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] dark:border-white/5">
                © {{ date('Y') }} Bangladesh National Youth Technical Institute. All rights reserved.
            </div>
        </footer>
    </body>
</html>

@props(['title', 'eyebrow', 'description'])

@php($isSuperAdmin = auth()->user()->hasRole(\App\Enums\UserRole::SuperAdmin))

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} | Bangladesh National Youth Technical Institute</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
        @if ($isSuperAdmin)
            <aside class="border-b border-slate-200 bg-white lg:fixed lg:inset-y-0 lg:left-0 lg:z-20 lg:flex lg:w-72 lg:flex-col lg:border-b-0 lg:border-r">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 lg:shrink-0 lg:px-6">
                    <a href="{{ route('dashboards.super-admin') }}" class="flex items-center gap-3">
                        <span class="grid size-11 place-items-center rounded-xl bg-blue-50"><img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="brand-logo size-8"></span>
                        <span><span class="block text-sm font-black text-blue-700">BNYTI Academy</span><span class="block text-[11px] font-bold text-slate-400">SUPER ADMIN PANEL</span></span>
                    </a>
                    <span class="rounded-lg bg-blue-50 px-2 py-1 text-xs font-black text-blue-600">SA</span>
                </div>

                <nav aria-label="Super Admin navigation" class="max-h-[calc(100vh-5.5rem)] overflow-y-auto px-3 py-4 lg:min-h-0 lg:max-h-none lg:flex-1 lg:px-4">
                    <a href="{{ route('dashboards.super-admin') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' => request()->routeIs('dashboards.super-admin'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('dashboards.super-admin')])>
                        <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg> Dashboard
                    </a>

                    <details class="group mt-5 rounded-xl" @if (request()->routeIs('super-admin.homepage.*')) open @endif>
                        <summary class="flex cursor-pointer list-none items-center justify-between rounded-xl bg-blue-50 px-3 py-3 text-sm font-black text-blue-700"><span class="flex items-center gap-3"><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="m3 11 9-8 9 8"/><path d="M5 10v10h14V10M9 20v-6h6v6"/></svg> Home</span><svg viewBox="0 0 24 24" class="size-4 transition group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></summary>
                        <div class="ml-6 grid border-l border-blue-100 py-1 pl-4 text-sm"><a href="{{ route('super-admin.homepage.items.index', 'hero') }}" @class(['rounded-lg px-2 py-2 font-bold', 'bg-blue-50 text-blue-700' => request()->route('section') === 'hero', 'text-slate-500 hover:text-blue-700' => request()->route('section') !== 'hero'])>Hero Slides</a><a href="{{ route('super-admin.homepage.items.index', 'trust') }}" @class(['rounded-lg px-2 py-2 font-bold', 'bg-blue-50 text-blue-700' => request()->route('section') === 'trust', 'text-slate-500 hover:text-blue-700' => request()->route('section') !== 'trust'])>Trust Indicators</a><a href="{{ route('super-admin.homepage.items.index', 'statistics') }}" @class(['rounded-lg px-2 py-2 font-bold', 'bg-blue-50 text-blue-700' => request()->route('section') === 'statistics', 'text-slate-500 hover:text-blue-700' => request()->route('section') !== 'statistics'])>Achievement Statistics</a><a href="{{ route('super-admin.homepage.items.index', 'branch-promotion') }}" class="py-2 text-slate-500 hover:text-blue-700">Branch Promotion</a><a href="{{ route('super-admin.homepage.items.index', 'gallery') }}" class="py-2 text-slate-500 hover:text-blue-700">Institute Gallery</a><a href="{{ route('super-admin.homepage.items.index', 'testimonials') }}" class="py-2 text-slate-500 hover:text-blue-700">Student Testimonials</a><a href="{{ route('super-admin.homepage.items.index', 'contact') }}" class="py-2 text-slate-500 hover:text-blue-700">Contact Information</a><a href="{{ route('super-admin.homepage.items.index', 'footer') }}" class="py-2 text-slate-500 hover:text-blue-700">Footer Settings</a><a href="{{ route('super-admin.courses.index') }}" class="py-2 text-slate-500 hover:text-blue-700">Popular Courses</a><a href="{{ route('super-admin.about.index') }}" class="py-2 text-slate-500 hover:text-blue-700">About Us</a><a href="{{ route('super-admin.teachers.index') }}" class="py-2 text-slate-500 hover:text-blue-700">Expert Teachers</a><a href="{{ route('super-admin.notices.index') }}" class="py-2 text-slate-500 hover:text-blue-700">Notices</a><a href="{{ route('super-admin.news.index') }}" class="py-2 text-slate-500 hover:text-blue-700">News &amp; Announcements</a></div>
                    </details>

                    <p class="px-3 pb-2 pt-5 text-[11px] font-black uppercase tracking-[0.15em] text-slate-400">People</p>
                    <a href="{{ route('super-admin.teachers.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.teachers.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.teachers.*')])>
                        <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><circle cx="12" cy="8" r="3"/><path d="M5 21c.5-4 2.8-6 7-6s6.5 2 7 6"/></svg> Teacher List
                    </a>
                    <a href="{{ route('super-admin.students.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.students.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.students.*')])>
                        <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><circle cx="12" cy="7" r="3"/><path d="M4 21c.6-4.1 3.2-6 8-6s7.4 1.9 8 6"/></svg> Student List
                    </a>
                    <a href="{{ route('super-admin.branch-applications.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.branch-applications.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.branch-applications.*')])><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="M4 21V5a2 2 0 0 1 2-2h8v18"/><path d="M14 9h6v12h-6zM8 7h2M8 11h2M8 15h2"/></svg> Branch Applications</a>
                    <a href="{{ route('super-admin.notices.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.notices.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.notices.*')])><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="m4 7 8-4 8 4-8 4-8-4Zm3 3v5c2.8 2 5.2 2 8 0v-5M20 8v7"/></svg> Notices</a>
                    <a href="{{ route('super-admin.news.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.news.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.news.*')])><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="M4 5h16v14H4z"/><path d="M7 9h10M7 13h7"/></svg> News &amp; Announcements</a>
                    <a href="{{ route('super-admin.about.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.about.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.about.*')])><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="M4 5h16v14H4z"/><path d="M8 9h8M8 13h5"/><circle cx="17" cy="16" r="2"/></svg> About Us</a>

                    <p class="px-3 pb-2 pt-5 text-[11px] font-black uppercase tracking-[0.15em] text-slate-400">Academic</p>
                    <a href="{{ route('super-admin.courses.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.courses.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.courses.*')])>
                        <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H12v17H6.5A2.5 2.5 0 0 0 4 22z"/><path d="M20 5.5A2.5 2.5 0 0 0 17.5 3H12v17h5.5a2.5 2.5 0 0 1 2.5 2z"/></svg> Department List
                    </a>
                    <a href="{{ route('super-admin.semester-setup.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.semester-setup.*') || request()->routeIs('super-admin.courses.semesters.*') || request()->routeIs('super-admin.semesters.subjects.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! (request()->routeIs('super-admin.semester-setup.*') || request()->routeIs('super-admin.courses.semesters.*') || request()->routeIs('super-admin.semesters.subjects.*'))])><span class="grid size-5 place-items-center text-xs font-black">S</span> Semester setup</a>
                    <details class="group mt-1 rounded-xl" @if (request()->routeIs('super-admin.students.documents.*') || request()->routeIs('super-admin.students.results.*') || request()->routeIs('super-admin.results.*')) open @endif>
                        <summary class="flex cursor-pointer list-none items-center justify-between rounded-xl px-3 py-3 text-sm font-bold text-slate-600 hover:bg-blue-50 hover:text-blue-700"><span class="flex items-center gap-3"><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="M6 2h8l4 4v16H6z"/><path d="M14 2v5h5"/><path d="M9 13h6M9 17h6"/></svg> Student Documents</span><svg viewBox="0 0 24 24" class="size-4 transition group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></summary>
                        <div class="ml-6 grid border-l border-blue-100 py-1 pl-4 text-sm"><a href="{{ route('super-admin.students.index') }}" class="py-2 text-slate-500 hover:text-blue-700">Student documents</a><a href="{{ route('results.index') }}" class="py-2 text-slate-500 hover:text-blue-700">Public result lookup</a></div>
                    </details>
                </nav>
                <form method="POST" action="{{ route('logout') }}" class="hidden shrink-0 border-t border-slate-100 p-4 lg:block">
                    @csrf
                    <button type="submit" aria-label="Log out of the super admin dashboard" class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 py-3 text-sm font-black text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600">
                        <svg viewBox="0 0 24 24" aria-hidden="true" class="size-5 fill-none stroke-current" stroke-width="1.8">
                            <path d="M10 5H5v14h5M14 8l4 4-4 4M8 12h10" />
                        </svg>
                        Log out
                    </button>
                </form>
            </aside>
        @endif

        <div @class(['min-h-screen', 'lg:pl-72' => $isSuperAdmin])>
            <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    <div class="min-w-0"><p class="truncate text-sm font-black text-slate-900">{{ $title }}</p><p class="hidden text-xs font-bold text-slate-400 sm:block">{{ auth()->user()->role->label() }}</p></div>
                    <form method="POST" action="{{ route('logout') }}" @class(['lg:hidden' => $isSuperAdmin])>
                        @csrf
                        <button type="submit" aria-label="Log out of the super admin dashboard" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-black text-slate-700 transition hover:border-rose-300 hover:bg-rose-50 hover:text-rose-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-600">Log out</button>
                    </form>
                </div>
            </header>
            <main class="px-4 py-8 sm:px-6 lg:px-8">
                <section class="mb-8"><p class="text-sm font-black uppercase tracking-[0.18em] text-blue-600">{{ $eyebrow }}</p><h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">{{ $title }}</h1><p class="mt-3 max-w-3xl text-base font-medium leading-7 text-slate-600">{{ $description }}</p></section>
                {{ $slot }}
            </main>
        </div>
        <style>
            details.group.mt-5 > div > a { border-radius: 0.5rem; padding-inline: 0.5rem; }
        </style>
        <script>
            document.querySelectorAll('a[href*="/super-admin/homepage/"]').forEach((link) => {
                const section = link.href.match(/homepage\/([^/]+)\/items/)?.[1];
                const current = window.location.pathname.match(/homepage\/([^/]+)\/items/)?.[1];
                if (section && current === section) {
                    link.classList.remove('text-slate-500');
                    link.classList.add('rounded-lg', 'bg-blue-50', 'px-2', 'font-bold', 'text-blue-700');
                }
            });
        </script>
    </body>
</html>

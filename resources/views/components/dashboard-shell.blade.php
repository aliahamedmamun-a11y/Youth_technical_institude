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
            <aside class="border-b border-slate-200 bg-white lg:fixed lg:inset-y-0 lg:left-0 lg:z-20 lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 lg:px-6">
                    <a href="{{ route('dashboards.super-admin') }}" class="flex items-center gap-3">
                        <span class="grid size-11 place-items-center rounded-xl bg-blue-50"><img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="brand-logo size-8"></span>
                        <span><span class="block text-sm font-black text-blue-700">BNYTI Academy</span><span class="block text-[11px] font-bold text-slate-400">SUPER ADMIN PANEL</span></span>
                    </a>
                    <span class="rounded-lg bg-blue-50 px-2 py-1 text-xs font-black text-blue-600">SA</span>
                </div>

                <nav aria-label="Super Admin navigation" class="max-h-[calc(100vh-5.5rem)] overflow-y-auto px-3 py-4 lg:px-4">
                    <a href="{{ route('dashboards.super-admin') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-600 text-white shadow-lg shadow-blue-600/20' => request()->routeIs('dashboards.super-admin'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('dashboards.super-admin')])>
                        <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg> Dashboard
                    </a>

                    <p class="px-3 pb-2 pt-5 text-[11px] font-black uppercase tracking-[0.15em] text-slate-400">People</p>
                    <a href="{{ route('super-admin.teachers.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.teachers.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.teachers.*')])>
                        <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><circle cx="12" cy="8" r="3"/><path d="M5 21c.5-4 2.8-6 7-6s6.5 2 7 6"/></svg> Teacher List
                    </a>
                    <a href="{{ route('super-admin.students.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.students.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.students.*')])>
                        <svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><circle cx="12" cy="7" r="3"/><path d="M4 21c.6-4.1 3.2-6 8-6s7.4 1.9 8 6"/></svg> Student List
                    </a>
                    <a href="{{ route('super-admin.branch-applications.index') }}" @class(['mb-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-blue-50 text-blue-700' => request()->routeIs('super-admin.branch-applications.*'), 'text-slate-600 hover:bg-blue-50 hover:text-blue-700' => ! request()->routeIs('super-admin.branch-applications.*')])><svg viewBox="0 0 24 24" class="size-5 fill-none stroke-current" stroke-width="1.8"><path d="M4 21V5a2 2 0 0 1 2-2h8v18"/><path d="M14 9h6v12h-6zM8 7h2M8 11h2M8 15h2"/></svg> Branch Applications</a>

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
                <form method="POST" action="{{ route('logout') }}" class="hidden border-t border-slate-100 p-4 lg:block">@csrf<button class="flex w-full items-center justify-center rounded-xl border border-slate-200 px-4 py-3 text-sm font-black text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-700">Logout</button></form>
            </aside>
        @endif

        <div @class(['min-h-screen', 'lg:pl-72' => $isSuperAdmin])>
            <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                    <div class="min-w-0"><p class="truncate text-sm font-black text-slate-900">{{ $title }}</p><p class="hidden text-xs font-bold text-slate-400 sm:block">{{ auth()->user()->role->label() }}</p></div>
                    <form method="POST" action="{{ route('logout') }}" @class(['lg:hidden' => $isSuperAdmin])>@csrf<button class="rounded-full border border-slate-300 px-4 py-2 text-sm font-black text-slate-700">Logout</button></form>
                </div>
            </header>
            <main class="px-4 py-8 sm:px-6 lg:px-8">
                <section class="mb-8"><p class="text-sm font-black uppercase tracking-[0.18em] text-blue-600">{{ $eyebrow }}</p><h1 class="mt-2 text-3xl font-black tracking-tight text-slate-950 sm:text-4xl">{{ $title }}</h1><p class="mt-3 max-w-3xl text-base font-medium leading-7 text-slate-600">{{ $description }}</p></section>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

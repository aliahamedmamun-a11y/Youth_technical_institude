@props(['title', 'eyebrow', 'description', 'breadcrumbs' => []])

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
            <div class="fixed inset-0 z-30 hidden bg-slate-950/45 backdrop-blur-sm lg:hidden" data-admin-overlay></div>
            <aside id="admin-sidebar" class="admin-sidebar" data-admin-sidebar aria-label="Super Admin navigation">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5">
                    <a href="{{ route('dashboards.super-admin') }}" class="flex min-w-0 items-center gap-3">
                        <span class="grid size-11 shrink-0 place-items-center rounded-xl bg-blue-50"><img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="brand-logo size-8"></span>
                        <span class="min-w-0"><span class="block truncate text-sm font-black text-blue-700">BNYTI Administration</span><span class="block text-[11px] font-bold text-slate-400">SUPER ADMIN WORKSPACE</span></span>
                    </a>
                    <button type="button" class="admin-icon-button lg:hidden" data-admin-menu-close aria-label="Close navigation">×</button>
                </div>
                <nav class="min-h-0 flex-1 overflow-y-auto px-4 py-5">
                    @foreach ($adminNavigation as $group)
                        <section class="mb-6" aria-labelledby="admin-nav-{{ Str::slug($group['label']) }}">
                            <h2 id="admin-nav-{{ Str::slug($group['label']) }}" class="px-3 pb-2 text-[10px] font-black uppercase tracking-[0.18em] text-slate-400">{{ $group['label'] }}</h2>
                            <div class="grid gap-1">
                                @foreach ($group['items'] as $item)
                                    @php($itemBadge = isset($item['badge']) ? get_defined_vars()[$item['badge']] ?? null : null)
                                    <x-admin-nav-item :item="$item" :badge="$itemBadge" />
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </nav>
                <div class="border-t border-slate-100 p-4">
                    <div class="mb-3 rounded-xl bg-slate-50 px-4 py-3"><p class="truncate text-sm font-black text-slate-800">{{ auth()->user()->name }}</p><p class="truncate text-xs font-semibold text-slate-500">{{ auth()->user()->email }}</p></div>
                    <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" aria-label="Log out of the super admin dashboard" class="admin-button admin-button--secondary w-full">Log out</button></form>
                </div>
            </aside>
        @endif

        <div @class(['min-h-screen', 'lg:pl-72' => $isSuperAdmin])>
            <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
                <div class="flex min-h-16 items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8">
                    <div class="flex min-w-0 items-center gap-3">
                        @if ($isSuperAdmin)<button type="button" class="admin-icon-button lg:hidden" data-admin-menu-open aria-controls="admin-sidebar" aria-expanded="false" aria-label="Open navigation">☰</button>@endif
                        <div class="min-w-0"><p class="truncate text-sm font-black text-slate-900">{{ $title }}</p><p class="hidden text-xs font-semibold text-slate-500 sm:block">{{ auth()->user()->role->label() }} workspace</p></div>
                    </div>
                    @isset($actions)<div class="flex flex-wrap items-center justify-end gap-2">{{ $actions }}</div>@endisset
                </div>
            </header>
            <main class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                @if (session('status'))<div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-800" role="status">{{ session('status') }}</div>@endif
                @if ($errors->any())<div class="mb-6 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900" role="alert"><p class="font-black">Please correct the following:</p><ul class="mt-2 list-disc space-y-1 pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <section class="mb-7">
                    @if ($breadcrumbs)<nav aria-label="Breadcrumb" class="mb-3 flex flex-wrap gap-2 text-xs font-bold text-slate-500">@foreach($breadcrumbs as $label => $url)@if($url)<a href="{{ $url }}" class="hover:text-blue-700">{{ $label }}</a><span aria-hidden="true">/</span>@else<span aria-current="page">{{ $label }}</span>@endif @endforeach</nav>@endif
                    <p class="text-xs font-black uppercase tracking-[0.17em] text-blue-700">{{ $eyebrow }}</p>
                    <h1 class="mt-2 text-2xl font-black tracking-tight text-slate-950 sm:text-3xl">{{ $title }}</h1>
                    <p class="mt-2 max-w-3xl text-sm font-medium leading-6 text-slate-600 sm:text-base">{{ $description }}</p>
                </section>
                <div data-admin-workspace>{{ $slot }}</div>
            </main>
        </div>
        <x-admin-confirm-dialog />
    </body>
</html>

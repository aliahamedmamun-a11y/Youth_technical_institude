<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} | Bangladesh National Youth Technical Institute</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-stone-50 text-slate-900 antialiased">
        <header class="border-b border-slate-200 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="{{ route('dashboard') }}" class="flex min-w-0 items-center gap-3">
                    <img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="brand-logo size-11">
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-black text-slate-950">Bangladesh National Youth Technical Institute</span>
                        <span class="block text-xs font-bold tracking-[0.16em] text-emerald-700">{{ auth()->user()->role->label() }}</span>
                    </span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-black text-slate-700 transition hover:border-emerald-500 hover:text-emerald-700">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <section class="mb-8">
                <p class="text-sm font-black uppercase tracking-[0.18em] text-emerald-700">{{ $eyebrow }}</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight text-slate-950">{{ $title }}</h1>
                <p class="mt-3 max-w-3xl text-base font-medium leading-7 text-slate-600">{{ $description }}</p>
            </section>

            <section class="grid gap-4 md:grid-cols-3">
                @foreach ($cards as $card)
                    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5">
                        <p class="text-xs font-black uppercase tracking-[0.16em] text-emerald-700">{{ $card['label'] }}</p>
                        <h2 class="mt-3 text-xl font-black text-slate-950">{{ $card['title'] }}</h2>
                        <p class="mt-3 text-sm font-medium leading-6 text-slate-600">{{ $card['body'] }}</p>
                    </article>
                @endforeach
            </section>
        </main>
    </body>
</html>

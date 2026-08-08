<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $about->about_heading }} | BNYTI</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-stone-50 text-slate-900 dark:bg-ink dark:text-white">
        <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6 sm:py-14">
            <a href="{{ route('home') }}#about" class="font-black text-emerald-700 dark:text-emerald-400">← Back to About Us</a>
            <article class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-900/5 dark:border-white/10 dark:bg-deep">
                @php
                    $aboutImage = $about->image_path ?: $about->principal_image_path;
                @endphp
                @if ($aboutImage)
                    <img src="{{ str_starts_with($aboutImage, 'images/') ? asset($aboutImage) : Storage::disk('public')->url($aboutImage) }}" alt="{{ $about->about_heading }}" class="h-64 w-full object-cover sm:h-80">
                @endif
                <div class="p-7 sm:p-10">
                    <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-400">About the institute</p>
                    <h1 class="mt-3 text-3xl font-black tracking-tight sm:text-5xl">{{ $about->about_heading }}</h1>
                    <p class="mt-5 text-lg leading-8 text-slate-600 dark:text-slate-300">{{ $about->summary }}</p>
                    <div class="mt-8 space-y-5 whitespace-pre-line text-base leading-8 text-slate-700 dark:text-slate-300">{{ $about->content }}</div>
                    @if ($about->principal_name)
                        <div class="mt-9 border-t border-slate-200 pt-6 dark:border-white/10"><p class="text-sm font-black">{{ $about->principal_name }}</p><p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $about->principal_title }}</p></div>
                    @endif
                </div>
            </article>
        </main>
    </body>
</html>

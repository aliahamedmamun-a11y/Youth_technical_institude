<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} | {{ config('app.name') }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#031d38] text-slate-100 font-sans min-h-screen flex flex-col antialiased">

    <!-- HEADER / NAVIGATION BAR -->
    <header class="border-b border-white/10 bg-[#071c2c]/90 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="size-10 sm:size-12 object-contain group-hover:scale-105 transition-all">
                <div>
                    <h1 class="text-sm sm:text-base font-black text-white uppercase tracking-tight leading-tight">
                        {{ config('app.name') }}
                    </h1>
                    <p class="text-[10px] sm:text-xs text-emerald-400 font-bold uppercase tracking-widest">
                        Government Approved Training Center
                    </p>
                </div>
            </a>

            <a href="{{ route('news.index') }}" class="rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-200 transition">
                ← Back to News List
            </a>
        </div>
    </header>

    <!-- MAIN ARTICLE CONTAINER -->
    <main class="flex-grow max-w-4xl w-full mx-auto px-4 sm:px-6 py-10 sm:py-16 space-y-8">

        <!-- ARTICLE HEADER -->
        <div class="space-y-4 text-center sm:text-left border-b border-white/10 pb-6">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                <span class="rounded-full bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 text-[11px] font-black uppercase tracking-wider text-emerald-400">
                    Official Announcement
                </span>
                <span class="text-xs text-slate-400 font-bold">
                    📅 Published: {{ $news->published_at?->format('F d, Y') ?? 'Recently' }}
                </span>
            </div>

            <h1 class="text-2xl sm:text-4xl font-black text-white leading-tight uppercase tracking-tight">
                {{ $news->title }}
            </h1>
        </div>

        <!-- ARTICLE FEATURED IMAGE -->
        @if($news->image_path)
            @php
                $imageSrc = str_starts_with($news->image_path, 'http') ? $news->image_path : asset('storage/' . $news->image_path);
            @endphp
            <div class="rounded-3xl border border-white/10 bg-[#0e1828] overflow-hidden shadow-2xl">
                <img src="{{ $imageSrc }}" alt="{{ $news->title }}" class="w-full max-h-[450px] object-cover">
            </div>
        @endif

        <!-- ARTICLE CONTENT -->
        <article class="rounded-3xl border border-white/10 bg-[#0e1828] p-6 sm:p-10 shadow-2xl space-y-6 leading-relaxed text-slate-200 text-sm sm:text-base">
            @if($news->excerpt)
                <p class="text-base sm:text-lg font-bold text-emerald-300 border-l-4 border-emerald-500 pl-4 py-1 italic bg-emerald-500/5 rounded-r-xl">
                    {{ $news->excerpt }}
                </p>
            @endif

            <div class="prose prose-invert max-w-none space-y-4">
                {!! nl2br(e($news->content)) !!}
            </div>
        </article>

        <!-- FOOTER NAVIGATION BUTTON -->
        <div class="pt-4 flex justify-between items-center">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-[#0e1828] hover:bg-[#152338] px-6 py-3 text-xs font-black uppercase tracking-wider text-emerald-400 transition shadow-lg">
                ← Back to All News
            </a>
        </div>

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-white/10 bg-[#021326] py-6 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </footer>

</body>
</html>

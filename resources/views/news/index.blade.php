<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News & Updates | {{ config('app.name') }}</title>
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

            <a href="{{ route('home') }}" class="rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 px-4 py-2 text-xs font-bold uppercase tracking-wider text-slate-200 transition">
                ← Back to Home
            </a>
        </div>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16 space-y-10">

        <!-- TITLE & DESCRIPTION -->
        <div class="text-center space-y-3">
            <span class="inline-block rounded-full bg-emerald-500/10 border border-emerald-500/30 px-4 py-1 text-xs font-black uppercase tracking-widest text-emerald-400">
                📢 Notice & News Updates
            </span>
            <h1 class="text-2xl sm:text-4xl font-black text-white uppercase tracking-tight">
                Latest News & Events
            </h1>
            <p class="text-xs sm:text-sm text-slate-400 max-w-2xl mx-auto">
                Stay up to date with official announcements, exam notices, course updates, and news from Bangladesh National Youth Technical Institute.
            </p>
        </div>

        <!-- NEWS GRID -->
        @if($news->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($news as $item)
                    @php
                        $imageSrc = $item->image_path
                            ? (str_starts_with($item->image_path, 'http') ? $item->image_path : asset('storage/' . $item->image_path))
                            : asset('images/institute-gallery-1.png');
                    @endphp
                    <article class="flex flex-col rounded-3xl border border-white/10 bg-[#0e1828] overflow-hidden shadow-2xl transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500/40">
                        <div class="relative h-48 sm:h-52 overflow-hidden bg-[#071c2c]">
                            <img src="{{ $imageSrc }}" alt="{{ $item->title }}" class="size-full object-cover transition-transform duration-500 hover:scale-105" onerror="this.onerror=null; this.src='{{ asset('images/institute-gallery-1.png') }}';">
                            <span class="absolute top-3 left-3 rounded-full bg-slate-900/80 backdrop-blur-md px-3 py-1 text-[10px] font-bold text-emerald-400 border border-white/10">
                                {{ $item->published_at?->format('d M, Y') ?? 'Recently' }}
                            </span>
                        </div>

                        <div class="p-6 flex flex-col flex-grow justify-between space-y-4">
                            <div class="space-y-2">
                                <h2 class="text-base sm:text-lg font-black text-white hover:text-emerald-400 transition-colors line-clamp-2 leading-snug">
                                    <a href="{{ route('news.show', $item->slug) }}">
                                        {{ $item->title }}
                                    </a>
                                </h2>
                                <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed">
                                    {{ $item->excerpt ?: Str::limit(strip_tags($item->content), 120) }}
                                </p>
                            </div>

                            <a href="{{ route('news.show', $item->slug) }}" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-wider text-emerald-400 hover:text-emerald-300 transition-all group pt-2 border-t border-white/5">
                                Read Full Article
                                <svg class="size-4 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="pt-6">
                {{ $news->links() }}
            </div>
        @else
            <div class="rounded-3xl border border-white/10 bg-[#0e1828] p-12 text-center space-y-4">
                <div class="size-16 mx-auto rounded-full bg-slate-800 flex items-center justify-center text-slate-400">
                    📰
                </div>
                <h3 class="text-lg font-bold text-white uppercase">No News Published Yet</h3>
                <p class="text-xs text-slate-400">Please check back later for new announcements and updates.</p>
            </div>
        @endif

    </main>

    <!-- FOOTER -->
    <footer class="border-t border-white/10 bg-[#021326] py-6 text-center text-xs text-slate-500">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </footer>

</body>
</html>

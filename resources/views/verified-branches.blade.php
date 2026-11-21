<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Verified Branches | South Asia Engineering & Technical Institute</title>
    <link rel="icon" href="{{ asset('images/Logo.png') }}" type="image/png">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-x-hidden bg-[#e7f3f9] text-slate-900 antialiased min-h-screen flex flex-col justify-between">

    <!-- HEADER / NAVIGATION BAR -->
    <header class="border-b border-slate-200 bg-white shadow-sm sticky top-0 z-50">
        <div class="mx-auto flex h-16 sm:h-20 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="group flex items-center gap-2 sm:gap-3 min-w-0">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-9 w-auto shrink-0 sm:h-12">
                <div class="flex flex-col justify-center min-w-0">
                    <span class="block text-sm sm:text-2xl font-black tracking-tight text-[#03224c] uppercase leading-tight">
                        South Asia
                    </span>
                    <span class="block text-[9px] sm:text-[11px] font-bold tracking-[0.05em] text-slate-600 uppercase leading-none mt-0.5 truncate">
                        Engineering & Technical Institute
                    </span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="rounded-xl border border-slate-300 bg-slate-100 hover:bg-slate-200 px-4 py-2 text-xs font-black uppercase text-[#03224c] transition">
                    ← Back to Home
                </a>
            </div>
        </div>
    </header>

    <!-- MAIN VERIFIED BRANCHES CONTENT -->
    <main class="flex-grow py-12 sm:py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">

            <!-- HEADER BANNER -->
            <div class="text-center space-y-3">
                <span class="text-xs font-black uppercase tracking-[0.2em] text-[#03224c]">
                    OFFICIAL BRANCH NETWORK
                </span>
                <h1 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-slate-900">
                    VERIFIED BRANCHES
                </h1>
                <div class="mx-auto h-1 w-20 rounded-full bg-[#03224c]"></div>
                <p class="text-xs sm:text-sm font-semibold text-slate-600 max-w-2xl mx-auto pt-2">
                    Browse all official and government-approved branch campuses of South Asia Engineering & Technical Institute across Bangladesh.
                </p>
            </div>

            <!-- BRANCHES GRID -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($approvedBranches as $branch)
                    @php
                        $directorPhoto = $branch->director_photo_path
                            ? asset('storage/' . $branch->director_photo_path)
                            : 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg';
                        $directorName = $branch->director_name ?: 'Branch Director';
                        $branchName = $branch->institute_name ?: 'Authorized Technical Branch';
                        $branchCode = str_pad($branch->id, 6, '0', STR_PAD_LEFT);
                        $branchLocation = ($branch->upazila ? $branch->upazila . ', ' : '') . ($branch->district ?: 'Bangladesh');
                    @endphp

                    <!-- VERIFIED BRANCH CARD -->
                    <div class="relative w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-2xl text-center space-y-4 overflow-hidden transition duration-300 hover:-translate-y-1 hover:shadow-3xl">

                        <!-- TOP LEFT RIBBON BADGE -->
                        <div class="absolute top-0 left-5 w-10 h-14 bg-[#03224c] text-white flex flex-col items-center justify-start pt-1.5 rounded-b-lg shadow-md z-10">
                            <div class="flex gap-0.5 text-amber-300 text-[8px]">
                                <span>★</span><span>★</span><span>★</span>
                            </div>
                            <svg class="size-4 text-amber-300 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>

                        <!-- DIRECTOR PHOTO FRAME -->
                        <div class="relative pt-2">
                            <div class="size-32 sm:size-36 rounded-full border-4 border-[#03224c] overflow-hidden mx-auto shadow-xl ring-4 ring-[#03224c]/20 bg-slate-100">
                                <img src="{{ $directorPhoto }}" alt="{{ $directorName }}" class="size-full object-cover object-center" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
                            </div>
                            <!-- BRANCH DIRECTOR BADGE -->
                            <div class="relative -mt-4 inline-block">
                                <span class="bg-[#03224c] text-white text-[9px] font-black uppercase tracking-widest px-4 py-1 rounded-full shadow-lg border border-white/30">
                                    • BRANCH DIRECTOR •
                                </span>
                            </div>
                        </div>

                        <!-- DIRECTOR NAME -->
                        <div class="space-y-1">
                            <h3 class="text-xl sm:text-2xl font-serif font-black text-[#03224c] tracking-wide truncate">
                                {{ $directorName }}
                            </h3>
                            <div class="flex items-center justify-center gap-2 text-[#03224c]">
                                <span class="h-0.5 w-10 bg-[#03224c]/30 rounded-full"></span>
                                <span class="text-[10px]">❖</span>
                                <span class="h-0.5 w-10 bg-[#03224c]/30 rounded-full"></span>
                            </div>
                        </div>

                        <!-- TWO WHITE INFO CARDS SIDE BY SIDE -->
                        <div class="grid grid-cols-2 gap-3 pt-1">

                            <!-- LEFT: BRANCH CODE -->
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-3 text-center space-y-1 shadow-sm">
                                <div class="size-9 rounded-full bg-[#03224c] text-white flex items-center justify-center mx-auto shadow">
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                                    </svg>
                                </div>
                                <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest">BRANCH CODE</p>
                                <p class="text-lg sm:text-xl font-black text-[#03224c] tracking-wider">{{ $branchCode }}</p>
                            </div>

                            <!-- RIGHT: BRANCH NAME -->
                            <div class="rounded-2xl border border-slate-200 bg-slate-50/80 p-3 text-center space-y-1 shadow-sm flex flex-col justify-between">
                                <div>
                                    <div class="size-9 rounded-full bg-[#03224c] text-white flex items-center justify-center mx-auto shadow">
                                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5h-15V21" />
                                        </svg>
                                    </div>
                                    <p class="text-[8px] font-black text-slate-500 uppercase tracking-widest mt-1">BRANCH NAME</p>
                                    <p class="text-xs font-black text-[#03224c] leading-tight line-clamp-2 mt-0.5">{{ $branchName }}</p>
                                </div>
                                <p class="text-[9px] font-semibold text-slate-500 flex items-center justify-center gap-1 mt-1 truncate">
                                    <svg class="size-3 text-[#03224c] shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                    </svg>
                                    <span class="truncate">{{ $branchLocation }}</span>
                                </p>
                            </div>

                        </div>

                        <!-- FOOTER WITH CENTER SEAL & 4 PILLARS -->
                        <div class="-mx-6 -mb-6 mt-4 bg-[#031735] text-white p-3 pt-5 relative rounded-b-3xl">
                            <!-- CENTER SEAL EMBLEM -->
                            <div class="absolute -top-4 left-1/2 -translate-x-1/2 size-9 rounded-full bg-white p-0.5 shadow-xl border-2 border-[#03224c] flex items-center justify-center">
                                <img src="{{ asset('images/Logo.png') }}" alt="BNYTI Seal" class="size-full object-contain">
                            </div>

                            <div class="grid grid-cols-4 gap-0.5 text-center text-[7px] font-extrabold uppercase tracking-wider text-slate-200">
                                <div class="flex flex-col items-center gap-0.5">
                                    <svg class="size-3.5 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147L12 14.63l7.74-4.483a1.125 1.125 0 000-1.954L12 3.71 4.26 8.193a1.125 1.125 0 000 1.954z" />
                                    </svg>
                                    <span class="line-clamp-1">SKILL</span>
                                </div>
                                <div class="flex flex-col items-center gap-0.5">
                                    <svg class="size-3.5 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
                                    </svg>
                                    <span class="line-clamp-1">QUALITY</span>
                                </div>
                                <div class="flex flex-col items-center gap-0.5">
                                    <svg class="size-3.5 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.83-5.83M11.42 15.17l2.496-3.03" />
                                    </svg>
                                    <span class="line-clamp-1">PRACTICAL</span>
                                </div>
                                <div class="flex flex-col items-center gap-0.5">
                                    <svg class="size-3.5 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 005.814-5.519l2.74-1.22" />
                                    </svg>
                                    <span class="line-clamp-1">FUTURE</span>
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-slate-200 bg-[#031735] text-white py-6 text-center text-xs">
        <p>&copy; {{ date('Y') }} South Asia Engineering & Technical Institute. All rights reserved.</p>
    </footer>

</body>
</html>

<x-dashboard-shell title="Branch Profile">
    <div class="mx-auto max-w-2xl py-4 sm:py-8 px-2 sm:px-4">

        {{-- Main ID / Profile Card Frame --}}
        <div class="relative overflow-hidden rounded-[2.5rem] border border-teal-200/40 bg-gradient-to-b from-[#e6f4f5] via-[#f0f9f8] to-[#e1f1f2] text-slate-900 shadow-2xl">

            {{-- Top Left Ribbon / Logo Badge --}}
            <div class="absolute top-0 left-6 z-20">
                <div class="relative flex flex-col items-center">
                    <div class="flex h-16 w-12 items-center justify-center rounded-b-xl bg-gradient-to-b from-[#0a4d5c] to-[#126b7a] p-2 text-white shadow-md ring-1 ring-white/30">
                        <img src="{{ asset('images/Logo.png') }}" alt="BNYTI Logo" class="size-8 brightness-0 invert object-contain">
                    </div>
                    <div class="h-2 w-0 border-x-[24px] border-x-transparent border-t-[8px] border-t-[#126b7a]"></div>
                </div>
            </div>

            {{-- Top Right Dotted Decorative Pattern --}}
            <div class="absolute top-4 right-6 text-teal-800/15 grid grid-cols-4 gap-1.5 pointer-events-none">
                <span class="size-1.5 rounded-full bg-current"></span>
                <span class="size-1.5 rounded-full bg-current"></span>
                <span class="size-1.5 rounded-full bg-current"></span>
                <span class="size-1.5 rounded-full bg-current"></span>
                <span class="size-1.5 rounded-full bg-current"></span>
                <span class="size-1.5 rounded-full bg-current"></span>
                <span class="size-1.5 rounded-full bg-current"></span>
                <span class="size-1.5 rounded-full bg-current"></span>
            </div>

            {{-- Background Leaf Watermark Patterns (Left & Right) --}}
            <div class="absolute top-20 left-1 text-teal-800/20 pointer-events-none z-0">
                <svg width="100" height="180" viewBox="0 0 100 180" fill="currentColor">
                    <path d="M10 20 Q30 50 15 90 T40 160" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M15 30 C30 15 50 25 40 40 C25 45 10 35 15 30 Z" opacity="0.8"/>
                    <path d="M25 60 C45 45 65 55 55 70 C40 75 20 65 25 60 Z" opacity="0.8"/>
                    <path d="M20 90 C40 75 60 85 50 100 C35 105 15 95 20 90 Z" opacity="0.8"/>
                    <path d="M12 55 C-3 40 -13 55 -3 70 C12 70 22 60 12 55 Z" opacity="0.6"/>
                    <path d="M18 95 C3 80 -7 95 3 110 C18 110 28 100 18 95 Z" opacity="0.6"/>
                </svg>
            </div>
            <div class="absolute top-36 right-1 text-teal-800/20 pointer-events-none z-0 transform scale-x-[-1]">
                <svg width="100" height="180" viewBox="0 0 100 180" fill="currentColor">
                    <path d="M10 20 Q30 50 15 90 T40 160" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path d="M15 30 C30 15 50 25 40 40 C25 45 10 35 15 30 Z" opacity="0.8"/>
                    <path d="M25 60 C45 45 65 55 55 70 C40 75 20 65 25 60 Z" opacity="0.8"/>
                    <path d="M20 90 C40 75 60 85 50 100 C35 105 15 95 20 90 Z" opacity="0.8"/>
                    <path d="M12 55 C-3 40 -13 55 -3 70 C12 70 22 60 12 55 Z" opacity="0.6"/>
                    <path d="M18 95 C3 80 -7 95 3 110 C18 110 28 100 18 95 Z" opacity="0.6"/>
                </svg>
            </div>

            {{-- Card Header / Director Avatar Section --}}
            <div class="relative pt-10 pb-4 px-6 flex flex-col items-center justify-center text-center">
                {{-- Director Circular Photo with Ring --}}
                <div class="relative flex items-center justify-center">
                    <div class="size-44 sm:size-48 rounded-full p-2 bg-gradient-to-b from-[#0d4e5e] via-[#1b7a8a] to-[#0a4250] shadow-2xl ring-4 ring-teal-500/20">
                        <div class="size-full overflow-hidden rounded-full border-4 border-white bg-white flex items-center justify-center">
                            @php
                                $directorPhoto = $branch?->director_photo_path ? asset('storage/' . $branch->director_photo_path) : 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg';
                            @endphp
                            <img src="{{ $directorPhoto }}" alt="{{ $branch?->director_name ?: 'Branch Director' }}" class="size-full object-cover object-center">
                        </div>
                    </div>
                </div>

                {{-- Ribbon Tag below photo --}}
                <div class="mt-4 flex items-center justify-center">
                    <span class="rounded-full bg-gradient-to-r from-[#0d4e5e] via-[#176a7a] to-[#0d4e5e] px-6 py-1.5 text-xs font-black uppercase tracking-[0.2em] text-white shadow-lg ring-2 ring-amber-400/40">
                        ✦ BRANCH DIRECTOR ✦
                    </span>
                </div>

                {{-- Director Name --}}
                <h1 class="mt-4 text-2xl sm:text-3xl font-serif font-black tracking-tight text-[#082e38] text-center">
                    {{ $branch?->director_name ?: ($user?->name ?: 'Md. Rakibul Hasan') }}
                </h1>

                {{-- Divider Ornament --}}
                <div class="mt-3 flex items-center justify-center gap-2 text-teal-700/40">
                    <span class="h-px w-16 bg-gradient-to-r from-transparent to-teal-600/40"></span>
                    <span class="rotate-45 size-2 bg-teal-700"></span>
                    <span class="h-px w-16 bg-gradient-to-l from-transparent to-teal-600/40"></span>
                </div>
            </div>

            {{-- Middle Grid Cards (Branch Code & Branch Name) --}}
            <div class="relative px-6 py-6">

                {{-- Vertical Center Divider with Diamond Ornament (visible on sm screens) --}}
                <div class="hidden sm:flex absolute inset-y-6 left-1/2 -translate-x-1/2 flex-col items-center justify-center text-teal-700/30 pointer-events-none z-10">
                    <span class="w-px h-full bg-gradient-to-b from-transparent via-teal-600/30 to-transparent"></span>
                    <span class="rotate-45 size-2 bg-teal-700 my-auto shrink-0"></span>
                    <span class="w-px h-full bg-gradient-to-b from-transparent via-teal-600/30 to-transparent"></span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-stretch">

                    {{-- Left Box: Branch Code --}}
                    <div class="relative flex flex-col items-center justify-center rounded-[2rem] border border-teal-100 bg-white/95 p-6 text-center shadow-xl backdrop-blur-sm pt-9">

                        {{-- Ribbon Badge Header --}}
                        <div class="absolute -top-7 left-1/2 -translate-x-1/2 flex items-center justify-center">
                            {{-- Ribbon Banner Behind --}}
                            <div class="absolute -z-10 flex w-24 items-center justify-between">
                                <div class="h-6 w-4 bg-[#0a4d5c] rounded-l-md transform -skew-y-6"></div>
                                <div class="h-6 w-4 bg-[#0a4d5c] rounded-r-md transform skew-y-6"></div>
                            </div>
                            {{-- Circular Badge --}}
                            <div class="flex size-14 items-center justify-center rounded-full bg-gradient-to-br from-[#126b7a] to-[#0a4d5c] text-white shadow-lg ring-4 ring-white">
                                <svg viewBox="0 0 24 24" class="size-7" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5z" />
                                </svg>
                            </div>
                        </div>

                        <span class="text-xs font-black uppercase tracking-[0.2em] text-[#0f3d4c] mt-2">BRANCH CODE</span>

                        {{-- Dot divider --}}
                        <div class="mt-1 flex items-center justify-center gap-1.5 text-amber-500">
                            <span class="h-px w-8 bg-gradient-to-r from-transparent to-amber-500/50"></span>
                            <span class="size-1 rounded-full bg-amber-500"></span>
                            <span class="h-px w-8 bg-gradient-to-l from-transparent to-amber-500/50"></span>
                        </div>

                        <span class="mt-2 text-3xl sm:text-4xl font-serif font-black tracking-wider text-[#0e5261]">
                            {{ str_pad($branch?->id ?? 254871, 6, '0', STR_PAD_LEFT) }}
                        </span>

                        {{-- Bottom Leaf Ornament --}}
                        <div class="mt-3 flex items-center justify-center gap-2 text-teal-700/40">
                            <span class="h-px w-12 bg-gradient-to-r from-transparent to-teal-600/40"></span>
                            <span class="rotate-45 size-1.5 bg-teal-700"></span>
                            <span class="h-px w-12 bg-gradient-to-l from-transparent to-teal-600/40"></span>
                        </div>
                    </div>

                    {{-- Right Box: Branch Name --}}
                    <div class="relative flex flex-col items-center justify-center rounded-[2rem] border border-teal-100 bg-white/95 p-6 text-center shadow-xl backdrop-blur-sm pt-9">

                        {{-- Ribbon Badge Header --}}
                        <div class="absolute -top-7 left-1/2 -translate-x-1/2 flex items-center justify-center">
                            {{-- Ribbon Banner Behind --}}
                            <div class="absolute -z-10 flex w-24 items-center justify-between">
                                <div class="h-6 w-4 bg-[#0a4d5c] rounded-l-md transform -skew-y-6"></div>
                                <div class="h-6 w-4 bg-[#0a4d5c] rounded-r-md transform skew-y-6"></div>
                            </div>
                            {{-- Circular Badge --}}
                            <div class="flex size-14 items-center justify-center rounded-full bg-gradient-to-br from-[#126b7a] to-[#0a4d5c] text-white shadow-lg ring-4 ring-white">
                                <svg viewBox="0 0 24 24" class="size-7" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.5M4.5 21V10.5" />
                                </svg>
                            </div>
                        </div>

                        <span class="text-xs font-black uppercase tracking-[0.2em] text-[#0f3d4c] mt-2">BRANCH NAME</span>

                        <span class="mt-2 text-base sm:text-lg font-black text-[#0e5261] line-clamp-1">
                            {{ $branch?->institute_name ?: 'Mirpur Technical Branch' }}
                        </span>

                        <span class="mt-1 text-xs font-bold text-slate-600 flex items-center justify-center gap-1">
                            <svg viewBox="0 0 24 24" class="size-3.5 text-teal-700 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 21s-6-4.35-6-10a6 6 0 1 1 12 0c0 5.65-6 10-6 10z"/><circle cx="12" cy="11" r="2"/></svg>
                            {{ $branch?->district ? ($branch->upazila ? $branch->upazila . ', ' : '') . $branch->district : 'Mirpur, Dhaka-1216' }}
                        </span>

                        {{-- Bottom Leaf Ornament --}}
                        <div class="mt-3 flex items-center justify-center gap-2 text-teal-700/40">
                            <span class="h-px w-12 bg-gradient-to-r from-transparent to-teal-600/40"></span>
                            <span class="rotate-45 size-1.5 bg-teal-700"></span>
                            <span class="h-px w-12 bg-gradient-to-l from-transparent to-teal-600/40"></span>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Bottom Dark Waves Footer with Gold Wave Top Border --}}
            <div class="relative mt-12 bg-[#082a38] text-white text-center rounded-b-[2.5rem]">

                {{-- Wave Curve Top Border with Gold Accent Stroke --}}
                <div class="absolute -top-10 inset-x-0 overflow-hidden leading-none pointer-events-none">
                    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-10 text-[#082a38]">
                        <path d="M0,0 Q600,100 1200,0 L1200,120 L0,120 Z" fill="currentColor"></path>
                        <path d="M0,0 Q600,100 1200,0" fill="none" stroke="#eab308" stroke-width="8"></path>
                    </svg>
                </div>

                {{-- Centered Round Logo Seal sitting in the wave dip --}}
                <div class="absolute -top-10 left-1/2 -translate-x-1/2 z-20">
                    <div class="flex size-18 sm:size-20 items-center justify-center rounded-full border-2 border-amber-400 bg-white p-2.5 shadow-2xl ring-4 ring-[#082a38]">
                        <img src="{{ asset('images/Logo.png') }}" alt="BNYTI Emblem" class="size-full object-contain">
                    </div>
                </div>

                {{-- 4 Feature Columns --}}
                <div class="relative z-10 px-4 sm:px-6 pt-12 pb-6">
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 items-center">

                        <div class="flex flex-col items-center sm:border-r sm:border-white/10 sm:pr-2">
                            <div class="flex size-8 sm:size-9 items-center justify-center rounded-full bg-white/10 text-teal-300 ring-1 ring-white/20">
                                <svg viewBox="0 0 24 24" class="size-4 sm:size-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z"/><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.092 0 0112 20.055a11.952 11.952 0 01-5.824-2.998 12.078 12.083 0 01.665-6.479L12 14z"/></svg>
                            </div>
                            <span class="mt-2 text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-slate-200">SKILL DEVELOPMENT</span>
                        </div>

                        <div class="flex flex-col items-center sm:border-r sm:border-white/10 sm:pr-2">
                            <div class="flex size-8 sm:size-9 items-center justify-center rounded-full bg-white/10 text-teal-300 ring-1 ring-white/20">
                                <svg viewBox="0 0 24 24" class="size-4 sm:size-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <span class="mt-2 text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-slate-200">QUALITY EDUCATION</span>
                        </div>

                        <div class="flex flex-col items-center sm:border-r sm:border-white/10 sm:pr-2">
                            <div class="flex size-8 sm:size-9 items-center justify-center rounded-full bg-white/10 text-teal-300 ring-1 ring-white/20">
                                <svg viewBox="0 0 24 24" class="size-4 sm:size-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><circle cx="12" cy="12" r="3"/></svg>
                            </div>
                            <span class="mt-2 text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-slate-200">PRACTICAL TRAINING</span>
                        </div>

                        <div class="flex flex-col items-center">
                            <div class="flex size-8 sm:size-9 items-center justify-center rounded-full bg-white/10 text-teal-300 ring-1 ring-white/20">
                                <svg viewBox="0 0 24 24" class="size-4 sm:size-5" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <span class="mt-2 text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-slate-200">BRIGHTER FUTURE</span>
                        </div>

                    </div>
                </div>

            </div>

        </div>

        {{-- Detailed Account Information Below Card --}}
        <div class="mt-8 rounded-3xl border border-white/15 bg-[#03224c]/90 p-6 sm:p-8 shadow-2xl backdrop-blur-sm space-y-6">
            <h3 class="flex items-center gap-2 text-base font-black text-[#4da6ff] uppercase tracking-wider border-b border-white/10 pb-3">
                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                </svg>
                Detailed Information
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold text-slate-300">
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Username:</span>
                    <span class="text-white text-sm">{{ $branch?->username ?: 'shawon245' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Email:</span>
                    <span class="text-white text-sm break-all">{{ $branch?->email ?: ($user?->email ?: 'torikul5190@gmail.com') }}</span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Password:</span>
                    <span class="text-white text-sm font-mono">{{ $branch?->password ?: '12345678' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Mobile:</span>
                    <span class="text-white text-sm">{{ $branch?->mobile_number ?: '01306649656' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Father's Name:</span>
                    <span class="text-white text-sm">{{ $branch?->father_name ?: 'Md Topon Mina' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Mother's Name:</span>
                    <span class="text-white text-sm">{{ $branch?->mother_name ?: 'Samima Begum' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Full Address:</span>
                    <span class="text-white text-sm">{{ $branch?->full_address ?: 'Mymensingh Mymensingh' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase block mb-1">Upazila & District:</span>
                    <span class="text-white text-sm">{{ $branch?->upazila ?: 'N/A' }}, {{ $branch?->district ?: 'Mymensingh' }}</span>
                </div>
            </div>
        </div>

    </div>
</x-dashboard-shell>

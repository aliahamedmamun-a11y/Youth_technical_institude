<x-dashboard-shell title="User Profile">
    <div class="mx-auto max-w-4xl py-6">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/90 p-8 sm:p-10 shadow-2xl backdrop-blur-sm space-y-8">

            {{-- Title --}}
            <h1 class="text-3xl sm:text-4xl font-black text-[#4da6ff] uppercase tracking-tight text-center">
                User Profile
            </h1>

            {{-- Institute Header --}}
            <div class="flex flex-col items-center justify-center space-y-2 border-b border-white/10 pb-6 text-center">
                <div class="flex items-center gap-3 text-emerald-400">
                    <svg viewBox="0 0 24 24" class="size-7" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <h2 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-white">
                        {{ $branch?->institute_name ?: 'Digital Skills Institute (DSI)' }}
                    </h2>
                </div>
                <div class="inline-flex items-center gap-2 rounded-full bg-pink-500/20 border border-pink-500/30 px-4 py-1 text-xs font-black text-pink-400">
                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="4" width="18" height="16" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                    </svg>
                    <span>ID: {{ str_pad($branch?->id ?? 1207, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>

            {{-- Grid Section --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">

                {{-- Left: Director Photo & Name --}}
                <div class="flex flex-col items-center text-center space-y-4 md:border-r md:border-white/10 md:pr-6">
                    <div class="size-36 sm:size-40 rounded-3xl overflow-hidden border-2 border-blue-500/50 bg-[#071c2c] shadow-2xl flex items-center justify-center ring-4 ring-blue-500/10">
                        @php
                            $directorPhoto = $branch?->director_photo_path ? asset('storage/' . $branch->director_photo_path) : 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg';
                        @endphp
                        <img src="{{ $directorPhoto }}" alt="{{ $branch?->director_name ?: 'Director Photo' }}" class="size-full object-cover">
                    </div>
                    <div class="flex items-center gap-2 text-white font-black text-base uppercase">
                        <svg viewBox="0 0 24 24" class="size-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>{{ $branch?->director_name ?: ($user?->name ?: 'Md Torikul Islam Shawon') }}</span>
                    </div>
                </div>

                {{-- Right: Personal Info & Address --}}
                <div class="md:col-span-2 space-y-8">

                    {{-- Personal Information --}}
                    <div class="space-y-4">
                        <h3 class="flex items-center gap-2 text-sm font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-2">
                            <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/>
                            </svg>
                            Personal Information
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold text-slate-300">
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Username:</span>
                                <span class="text-white">{{ $branch?->username ?: 'shawon245' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Email:</span>
                                <span class="text-white break-all">{{ $branch?->email ?: ($user?->email ?: 'torikul5190@gmail.com') }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Password:</span>
                                <span class="text-white font-mono">{{ $branch?->password ?: '12345678' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Mobile:</span>
                                <span class="text-white">{{ $branch?->mobile_number ?: '01306649656' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Father's Name:</span>
                                <span class="text-white">{{ $branch?->father_name ?: 'Md Topon Mina' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Mother's Name:</span>
                                <span class="text-white">{{ $branch?->mother_name ?: 'Samima Begum' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Address Details --}}
                    <div class="space-y-4">
                        <h3 class="flex items-center gap-2 text-sm font-black text-emerald-400 uppercase tracking-wider border-b border-white/10 pb-2">
                            <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            Address Details
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold text-slate-300">
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Address:</span>
                                <span class="text-white">{{ $branch?->full_address ?: 'Mymensingh Mymensingh' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Post Office:</span>
                                <span class="text-white">{{ $branch?->post_office ?: 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">Upazila:</span>
                                <span class="text-white">{{ $branch?->upazila ?: 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="text-slate-500 uppercase block mb-1">District:</span>
                                <span class="text-white">{{ $branch?->district ?: 'Mymensingh' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-dashboard-shell>

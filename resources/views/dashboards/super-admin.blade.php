<x-dashboard-shell title="User Profile">
    <div class="mx-auto max-w-5xl">
        <div class="rounded-3xl border border-white/20 bg-[#071c2c]/50 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
            <h1 class="text-center text-4xl font-black tracking-tight text-[#4da6ff] uppercase lg:text-5xl">User Profile</h1>

            <div class="mt-12 grid gap-12 lg:grid-cols-[280px_1fr]">
                {{-- Left Column: Logo/Avatar --}}
                <div class="flex flex-col items-center">
                    <div class="relative group">
                         <div class="absolute -inset-1 rounded-3xl bg-gradient-to-tr from-blue-600 to-indigo-600 opacity-75 blur transition duration-500 group-hover:opacity-100"></div>
                         <div class="relative flex size-56 items-center justify-center rounded-3xl bg-[#071c2c] p-6 shadow-2xl">
                            <img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNTEI Logo" class="w-full brightness-0 invert">
                         </div>
                    </div>
                    <div class="mt-6 flex items-center gap-2 text-2xl font-black text-[#4da6ff]">
                        <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>Admin</span>
                    </div>
                </div>

                {{-- Right Column: Details --}}
                <div class="space-y-10">
                    {{-- Header Info --}}
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 text-xl font-black text-[#ff4d94]">
                            <svg viewBox="0 0 24 24" class="size-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M3 21h18M3 10h18M5 10V7a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3v3M4 21V10m16 11V10M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"/>
                            </svg>
                            <h2 class="uppercase tracking-wide">Bangladesh Technical Training Institute</h2>
                        </div>
                        <div class="flex items-center gap-3 text-lg font-black text-[#ff4d94]">
                            <svg viewBox="0 0 24 24" class="size-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5">
                                <rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h10M7 16h6"/>
                            </svg>
                            <span>ID: 198305</span>
                        </div>
                    </div>

                    {{-- Personal Information --}}
                    <div>
                        <div class="flex items-center gap-3 text-lg font-black text-[#4da6ff] border-b border-white/10 pb-2">
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            <h3 class="uppercase tracking-widest">Personal Information</h3>
                        </div>
                        <div class="mt-6 grid gap-x-8 gap-y-5 sm:grid-cols-2">
                            <div class="flex items-center gap-3">
                                <svg viewBox="0 0 24 24" class="size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <span class="text-sm font-bold text-slate-400">Username:</span>
                                <span class="text-sm font-black text-white">jibyh</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg viewBox="0 0 24 24" class="size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                                <span class="text-sm font-bold text-slate-400">Email:</span>
                                <span class="text-sm font-black text-white">sogekeha@mailinator.com</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg viewBox="0 0 24 24" class="size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                <span class="text-sm font-bold text-slate-400">Password:</span>
                                <span class="text-sm font-black text-white">Pa$$w0rd!</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg viewBox="0 0 24 24" class="size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                <span class="text-sm font-bold text-slate-400">Mobile:</span>
                                <span class="text-sm font-black text-white">413</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg viewBox="0 0 24 24" class="size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                <span class="text-sm font-bold text-slate-400">Father's Name:</span>
                                <span class="text-sm font-black text-white">Kelsey Charles</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <svg viewBox="0 0 24 24" class="size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                <span class="text-sm font-bold text-slate-400">Mother's Name:</span>
                                <span class="text-sm font-black text-white">Leonard Bruce</span>
                            </div>
                        </div>
                    </div>

                    {{-- Address Details --}}
                    <div>
                        <div class="flex items-center gap-3 text-lg font-black text-[#4da6ff] border-b border-white/10 pb-2">
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <h3 class="uppercase tracking-widest">Address Details</h3>
                        </div>
                        <div class="mt-6 grid gap-x-8 gap-y-5 sm:grid-cols-2">
                            <div class="flex items-start gap-3">
                                <svg viewBox="0 0 24 24" class="mt-0.5 size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                <div>
                                    <span class="text-sm font-bold text-slate-400">Address:</span>
                                    <span class="ml-2 text-sm font-black text-white">Esse cupiditate fac</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg viewBox="0 0 24 24" class="mt-0.5 size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/></svg>
                                <div>
                                    <span class="text-sm font-bold text-slate-400">Post Office:</span>
                                    <span class="ml-2 text-sm font-black text-white">Excepteur veniam qu</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg viewBox="0 0 24 24" class="mt-0.5 size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <div>
                                    <span class="text-sm font-bold text-slate-400">Upazila:</span>
                                    <span class="ml-2 text-sm font-black text-white">Unde illo voluptatem</span>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg viewBox="0 0 24 24" class="mt-0.5 size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
                                <div>
                                    <span class="text-sm font-bold text-slate-400">District:</span>
                                    <span class="ml-2 text-sm font-black text-white">Quis doloremque quo</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-shell>

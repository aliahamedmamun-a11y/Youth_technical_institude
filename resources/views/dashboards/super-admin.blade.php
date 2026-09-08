<x-dashboard-shell title="Dashboard">

    <div class="mb-8">
        <h1 class="text-2xl font-black text-[#071c2c]">Welcome, Admin!</h1>
    </div>

    {{-- Statistics Overview --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        {{-- Students --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Students</p>
                    <h3 class="mt-2 text-2xl font-black text-[#071c2c]">{{ number_format($statistics['students']) }}</h3>
                </div>
                <div class="grid size-10 place-items-center rounded-xl bg-violet-50 text-violet-600 transition-colors group-hover:bg-violet-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="mt-5 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                <div class="h-full w-2/3 bg-violet-500"></div>
            </div>
            <p class="mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-tight">Total Enrolled</p>
        </div>

        {{-- Teachers --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Teachers</p>
                    <h3 class="mt-2 text-2xl font-black text-[#071c2c]">{{ number_format($statistics['teachers']) }}</h3>
                </div>
                <div class="grid size-10 place-items-center rounded-xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <div class="mt-5 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                <div class="h-full w-1/2 bg-emerald-500"></div>
            </div>
            <p class="mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-tight">Faculty Members</p>
        </div>

        {{-- Courses --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Active Courses</p>
                    <h3 class="mt-2 text-2xl font-black text-[#071c2c]">{{ number_format($statistics['courses']) }}</h3>
                </div>
                <div class="grid size-10 place-items-center rounded-xl bg-sky-50 text-sky-600 transition-colors group-hover:bg-sky-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </div>
            </div>
            <div class="mt-5">
                <svg viewBox="0 0 100 20" class="h-6 w-full text-sky-500" preserveAspectRatio="none">
                    <path d="M0 20 Q 25 0, 50 15 T 100 5" fill="none" stroke="currentColor" stroke-width="2" vector-effect="non-scaling-stroke" />
                </svg>
            </div>
            <p class="mt-1 text-[10px] font-bold text-slate-400 uppercase tracking-tight">Live Programs</p>
        </div>

        {{-- Pending Branches --}}
        <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Pending Approvals</p>
                    <h3 class="mt-2 text-2xl font-black text-[#071c2c]">{{ number_format($statistics['pendingBranches']) }}</h3>
                </div>
                <div class="grid size-10 place-items-center rounded-xl bg-amber-50 text-amber-600 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                </div>
            </div>
            <div class="mt-5 flex items-center gap-2">
                <div class="size-2 rounded-full bg-amber-500 animate-pulse"></div>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-tight">Requires Attention</p>
            </div>
            <div class="mt-2 h-1 w-full overflow-hidden rounded-full bg-slate-100">
                <div class="h-full bg-amber-500" style="width: {{ min(100, $statistics['pendingBranches'] * 20) }}%"></div>
            </div>
        </div>
    </div>

    {{-- Main Action Area --}}
    <div class="mt-8 grid gap-6 lg:grid-cols-[1fr_0.6fr]">
        {{-- Branch Approvals Panel --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4 border-b border-slate-100 pb-4">
                <div>
                    <h2 class="text-lg font-black text-[#071c2c]">Branch Approvals</h2>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-tight mt-1">Recent applications awaiting review</p>
                </div>
                <a href="{{ route('super-admin.branch-applications.index', ['status' => 'pending']) }}" class="rounded-lg bg-blue-50 px-4 py-2 text-[11px] font-black uppercase tracking-widest text-blue-700 transition hover:bg-blue-100">
                    View All
                </a>
            </div>

            <div class="mt-4 divide-y divide-slate-50">
                @forelse ($pendingApplications as $application)
                    <div class="flex items-center justify-between gap-4 py-4 group">
                        <div class="flex items-center gap-4">
                            <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-slate-50 text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-500 transition-colors">
                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-black text-slate-900">{{ $application->institute_name }}</p>
                                <p class="text-xs font-bold text-slate-500">{{ $application->director_name }} · {{ $application->district }}</p>
                            </div>
                        </div>
                        <a href="{{ route('super-admin.branch-applications.show', $application) }}" class="rounded-lg border border-slate-200 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-slate-600 transition hover:border-blue-500 hover:text-blue-700">
                            Review
                        </a>
                    </div>
                @empty
                    <div class="py-12 text-center">
                        <p class="text-sm font-bold text-slate-400">No pending applications found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Activity Panel --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-black text-[#071c2c]">Recent Activity</h2>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-tight mt-1">Latest system updates</p>

            <div class="mt-6 space-y-6">
                @foreach($recentActivity as $activity)
                    <div class="relative flex gap-4">
                        <div class="absolute left-[11px] top-6 h-full w-px bg-slate-100"></div>
                        <div class="relative z-10 grid size-6 shrink-0 place-items-center rounded-full bg-white ring-2 ring-slate-100">
                            <div class="size-2 rounded-full bg-blue-500"></div>
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[10px] font-black uppercase tracking-widest text-blue-600">{{ $activity['type'] }}</p>
                            <a href="{{ $activity['url'] }}" class="mt-1 block truncate text-sm font-bold text-slate-900 hover:text-blue-600 transition-colors">
                                {{ $activity['label'] }}
                            </a>
                            <p class="mt-1 text-[10px] font-bold text-slate-400">{{ $activity['date']->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Common Tasks Section --}}
    <div class="mt-12">
        <h2 class="text-lg font-black text-[#071c2c]">Common Tasks</h2>
        <p class="text-xs font-bold text-slate-500 uppercase tracking-tight mt-1">Quick shortcuts for daily operations</p>

        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            @foreach([
                ['Register Student', route('super-admin.students.create'), 'violet'],
                ['Add Teacher', route('super-admin.teachers.create'), 'emerald'],
                ['New Course', route('super-admin.courses.create'), 'sky'],
                ['Add Notice', route('super-admin.notices.create'), 'amber'],
                ['Update Gallery', route('super-admin.homepage.items.index', ['type' => 'gallery']), 'rose'],
                ['Profile Info', route('super-admin.about.index'), 'slate']
            ] as [$label, $url, $tone])
                <a href="{{ $url }}" class="group flex flex-col items-center justify-center gap-3 rounded-2xl border border-slate-200 bg-white p-6 transition-all hover:-translate-y-1 hover:shadow-lg">
                    <div class="grid size-12 place-items-center rounded-2xl bg-{{ $tone }}-50 text-{{ $tone }}-600 transition-colors group-hover:bg-{{ $tone }}-600 group-hover:text-white shadow-sm">
                        @if($label == 'Register Student') <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="16" y1="11" x2="22" y2="11"/></svg>
                        @elseif($label == 'Add Teacher') <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        @elseif($label == 'New Course') <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                        @elseif($label == 'Add Notice') <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        @elseif($label == 'Update Gallery') <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        @else <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        @endif
                    </div>
                    <span class="text-[11px] font-black uppercase tracking-widest text-slate-900">{{ $label }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Bottom Management Cards --}}
    <div class="mt-12 grid gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-black text-[#071c2c] uppercase tracking-wider">Add User</h3>
            <p class="text-xs font-bold text-slate-500 mt-1">Quickly create new admin or staff accounts</p>
            <div class="mt-6 flex items-center justify-between gap-4">
                <div class="flex-1 rounded-xl bg-violet-600 px-4 py-2.5 text-[11px] font-black uppercase tracking-widest text-white shadow-lg shadow-violet-500/20 text-center">
                    New Account
                </div>
                <button class="grid size-10 shrink-0 place-items-center rounded-xl bg-violet-100 text-violet-600 transition-transform hover:scale-105 active:scale-95">
                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="3">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                </button>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-black text-[#071c2c] uppercase tracking-wider">Database Status</h3>
            <p class="text-xs font-bold text-slate-500 mt-1">System connectivity and synchronization</p>
            <div class="mt-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <div class="size-3 rounded-full bg-emerald-500 ring-4 ring-emerald-500/20"></div>
                    <span class="text-xs font-black text-slate-700 uppercase tracking-widest">Healthy</span>
                </div>
                <button class="rounded-lg bg-slate-50 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-slate-600 border border-slate-200">
                    Refresh
                </button>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <h3 class="text-sm font-black text-[#071c2c] uppercase tracking-wider">Quick Search</h3>
            <p class="text-xs font-bold text-slate-500 mt-1">Find any student or record instantly</p>
            <div class="mt-4 relative">
                <input type="text" placeholder="Roll or Name..." class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2 text-xs font-bold outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                <svg viewBox="0 0 24 24" class="absolute right-3 top-2 size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
        </div>
    </div>

</x-dashboard-shell>

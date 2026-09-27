<x-dashboard-shell title="Branch Students Admin">
    <div class="mx-auto max-w-[1800px]">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-6 sm:p-8 shadow-2xl backdrop-blur-sm lg:p-10 space-y-8">

            <!-- Title & Subtitle -->
            <div class="text-center space-y-2">
                <h1 class="text-3xl font-black tracking-tight text-[#4da6ff] uppercase sm:text-4xl lg:text-5xl">
                    Branch Students Admin
                </h1>
                <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">
                    Select a branch below to view and manage all students registered under that branch
                </p>
            </div>

            <!-- Search Bar -->
            <div class="mx-auto max-w-2xl">
                <form method="GET" action="{{ route('super-admin.students.index') }}" class="relative">
                    <input type="hidden" name="show_branches" value="1">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search by Branch Name, ID or Director..."
                        class="w-full rounded-2xl border border-white/10 bg-[#071c2c]/70 py-4 pl-12 pr-6 text-sm text-white placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-xl">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                </form>
            </div>

            <!-- Branch Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($branches as $branch)
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/80 p-6 shadow-xl flex flex-col justify-between gap-6 transition-all hover:border-blue-500/50 hover:bg-[#071c2c] group">

                        <div class="space-y-4">
                            <!-- Branch Header Info -->
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-12 rounded-xl border border-white/10 bg-slate-800/80 overflow-hidden flex-none">
                                        <img src="{{ $branch->institute_photo_path ? asset('storage/' . $branch->institute_photo_path) : asset('images/placeholder-institute.png') }}" class="size-full object-cover">
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-black uppercase text-blue-400 tracking-wider block">
                                            Branch ID: {{ str_pad($branch->id, 6, '0', STR_PAD_LEFT) }}
                                        </span>
                                        <h3 class="text-base font-black text-white uppercase group-hover:text-blue-300 transition-colors line-clamp-1">
                                            {{ $branch->institute_name }}
                                        </h3>
                                    </div>
                                </div>

                                <!-- Student Count Badge -->
                                <span class="rounded-full bg-emerald-500/20 border border-emerald-500/30 px-3 py-1 text-xs font-black text-emerald-400 whitespace-nowrap">
                                    {{ $branch->student_count }} Students
                                </span>
                            </div>

                            <!-- Details List -->
                            <div class="space-y-1.5 text-xs text-slate-300 font-bold border-t border-white/5 pt-3">
                                <p><span class="text-slate-500 uppercase">Director:</span> {{ $branch->director_name }}</p>
                                <p><span class="text-slate-500 uppercase">Location:</span> {{ $branch->upazila }}, {{ $branch->district }}</p>
                                <p><span class="text-slate-500 uppercase">Mobile:</span> {{ $branch->mobile_number }}</p>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('super-admin.students.index', ['branch_id' => $branch->id]) }}"
                           class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white py-3 px-4 text-xs font-black uppercase tracking-wider shadow-lg transition-all active:scale-95">
                            <span>View Branch Students ({{ $branch->student_count }})</span>
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                            </svg>
                        </a>

                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 font-bold">
                        No branches found matching your query.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($branches->hasPages())
                <div class="mt-8">
                    {{ $branches->links() }}
                </div>
            @endif

        </div>
    </div>
</x-dashboard-shell>

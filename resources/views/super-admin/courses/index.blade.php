<x-dashboard-shell title="Course Management" eyebrow="Academic Management" description="Manage all courses and departments offered by the institute.">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>
        <div class="absolute -left-20 bottom-0 size-80 rounded-full bg-emerald-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-10">
            {{-- Header Section --}}
            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-black text-white uppercase tracking-[0.3em] drop-shadow-2xl">
                        Course <span class="text-blue-500">Inventory</span>
                    </h1>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-500">Bangladesh National Youth Technical Institute</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <div class="flex h-16 items-center gap-4 rounded-2xl bg-[#0f2d44]/50 px-6 border border-white/5 backdrop-blur-md shadow-xl">
                        <div class="size-2 rounded-full bg-blue-500 animate-pulse shadow-[0_0_10px_rgba(59,130,246,0.5)]"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Total Programs</p>
                            <p class="text-xl font-black text-white">{{ $courses->total() }}</p>
                        </div>
                    </div>
                    <div class="flex h-16 items-center gap-4 rounded-2xl bg-[#0f2d44]/50 px-6 border border-white/5 backdrop-blur-md shadow-xl">
                        <div class="size-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Active Courses</p>
                            <p class="text-xl font-black text-white">{{ $courses->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.courses.create') }}"
                        class="inline-flex h-16 items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 px-8 text-sm font-black uppercase tracking-widest text-white shadow-2xl shadow-blue-600/30 hover:from-blue-500 hover:to-indigo-600 hover:-translate-y-1 transition-all active:scale-95">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Create Course
                    </a>
                </div>
            </div>

            {{-- Search & Filters --}}
            <div class="rounded-[2rem] bg-[#0f2d44]/30 p-4 border border-white/5 backdrop-blur-sm shadow-inner">
                <form method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1 group">
                        <input type="text" name="search" value="{{ $search }}"
                            class="w-full rounded-xl border border-white/5 bg-[#071c2c]/50 py-4 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all"
                            placeholder="Search by course name or description...">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 group-hover:text-blue-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <select name="status" onchange="this.form.submit()"
                        class="rounded-xl border border-white/5 bg-[#071c2c]/50 px-6 py-4 text-xs font-black text-slate-300 uppercase tracking-widest outline-none focus:border-blue-500 transition-all">
                        <option value="">All Status</option>
                        <option value="active" @selected($selectedStatus === 'active')>Active Only</option>
                        <option value="inactive" @selected($selectedStatus === 'inactive')>Inactive Only</option>
                    </select>
                </form>
            </div>

            {{-- Course Table --}}
            <div class="overflow-hidden rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 shadow-2xl backdrop-blur-2xl">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left text-[11px] font-black uppercase tracking-wider text-slate-300">
                        <thead>
                            <tr class="bg-[#071c2c]/90 text-slate-400 border-b border-white/5">
                                <th class="px-8 py-8">PREVIEW</th>
                                <th class="px-8 py-8">COURSE INFORMATION</th>
                                <th class="px-8 py-8">DURATION</th>
                                <th class="px-8 py-8 text-center">ENROLMENT</th>
                                <th class="px-8 py-8 text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($courses as $course)
                                <tr class="hover:bg-white/[0.03] transition-all duration-500 group">
                                    <td class="px-8 py-6">
                                        <div class="relative size-20 overflow-hidden rounded-[1.25rem] border-2 border-slate-700 bg-slate-800 shadow-2xl group-hover:border-blue-500 transition-all duration-700">
                                            @if($course->image_path)
                                                <img src="{{ asset('storage/' . $course->image_path) }}" class="h-full w-full object-cover group-hover:scale-125 transition-transform duration-700">
                                            @else
                                                <div class="flex size-full items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900 text-slate-600">
                                                    <svg viewBox="0 0 24 24" class="size-10 opacity-30" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#071c2c]/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="space-y-2">
                                            <p class="text-base font-black text-white group-hover:text-blue-400 transition-colors tracking-tight">{{ $course->name }}</p>
                                            <div class="flex items-center gap-3">
                                                <span class="text-[9px] font-bold text-slate-500 normal-case tracking-normal max-w-xs line-clamp-1">{{ $course->description ?: 'No detailed description available.' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="inline-flex items-center gap-2 rounded-xl bg-indigo-500/10 px-4 py-2 border border-indigo-500/20 text-indigo-400">
                                            <svg class="size-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <span class="text-[10px] font-black">{{ $course->duration }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @if($course->is_active)
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-4 py-1.5 text-[9px] font-black text-emerald-500 border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.1)]">
                                                    <span class="size-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                                                    OPEN
                                                </span>
                                            </div>
                                        @else
                                            <span class="inline-flex items-center gap-2 rounded-full bg-rose-500/10 px-4 py-1.5 text-[9px] font-black text-rose-500 border border-rose-500/20">
                                                <span class="size-1.5 rounded-full bg-rose-500 opacity-50"></span>
                                                CLOSED
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center justify-center gap-6">
                                            <a href="{{ route('super-admin.courses.edit', $course) }}"
                                                class="group/btn flex items-center gap-2 text-[10px] font-black text-blue-500 hover:text-blue-400 transition-all">
                                                <span class="grid size-8 place-items-center rounded-lg bg-blue-500/10 border border-blue-500/20 group-hover/btn:bg-blue-500 group-hover/btn:text-white transition-all">
                                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </span>
                                                EDIT
                                            </a>
                                            <form action="{{ route('super-admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('WARNING: Are you sure you want to delete this course?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="group/btn flex items-center gap-2 text-[10px] font-black text-pink-600 hover:text-pink-500 transition-all">
                                                    <span class="grid size-8 place-items-center rounded-lg bg-pink-500/10 border border-pink-500/20 group-hover/btn:bg-pink-600 group-hover/btn:text-white transition-all">
                                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </span>
                                                    DELETE
                                                </button>
                                            </form>
                                            <a href="{{ route('super-admin.courses.semesters.index', $course) }}"
                                                class="group/btn flex items-center gap-2 text-[10px] font-black text-emerald-500 hover:text-emerald-400 transition-all">
                                                <span class="grid size-8 place-items-center rounded-lg bg-emerald-500/10 border border-emerald-500/20 group-hover/btn:bg-emerald-500 group-hover/btn:text-white transition-all">
                                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </span>
                                                MANAGE
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-32 text-center">
                                        <div class="flex flex-col items-center gap-6 opacity-30">
                                            <svg class="size-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <p class="text-lg font-black uppercase tracking-[0.2em]">Inventory is Empty</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Enhanced Pagination Footer --}}
                <div class="bg-[#071c2c]/80 px-8 py-10 border-t border-white/5 backdrop-blur-md">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="flex -space-x-3">
                                @foreach($courses->take(5) as $course)
                                    <div class="size-10 overflow-hidden rounded-full border-2 border-[#071c2c] bg-slate-800 shadow-xl">
                                        <img src="{{ $course->image_path ? asset('storage/' . $course->image_path) : asset('images/placeholder-avatar.png') }}" class="h-full w-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                                Displaying <span class="text-white">{{ $courses->count() }}</span> of <span class="text-blue-500">{{ $courses->total() }}</span> Programs
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            {{ $courses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-shell>

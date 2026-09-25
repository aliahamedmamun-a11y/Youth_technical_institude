<x-dashboard-shell title="Teaching Staff Directory" eyebrow="People & Branches" description="Manage and monitor all teaching staff and their departmental assignments.">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>
        <div class="absolute -left-20 bottom-0 size-80 rounded-full bg-emerald-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-10">
            {{-- Header Section --}}
            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-black text-white uppercase tracking-[0.3em] drop-shadow-2xl">
                        Faculty <span class="text-emerald-500">Directory</span>
                    </h1>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-500">Bangladesh National Youth Technical Institute</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <div class="flex h-16 items-center gap-4 rounded-2xl bg-[#0f2d44]/50 px-6 border border-white/5 backdrop-blur-md shadow-xl">
                        <div class="size-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Total Staff</p>
                            <p class="text-xl font-black text-white">{{ $teachers->total() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.teachers.create') }}"
                        class="inline-flex h-16 items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-emerald-600 to-green-700 px-8 text-sm font-black uppercase tracking-widest text-white shadow-2xl shadow-emerald-600/30 hover:from-emerald-500 hover:to-green-600 hover:-translate-y-1 transition-all active:scale-95">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Add New Teacher
                    </a>
                </div>
            </div>

            {{-- Search & Filters --}}
            <div class="rounded-[2rem] bg-[#0f2d44]/30 p-4 border border-white/5 backdrop-blur-sm shadow-inner">
                <form method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1 group">
                        <input type="text" name="search" value="{{ $search }}"
                            class="w-full rounded-xl border border-white/5 bg-[#071c2c]/50 py-4 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition-all"
                            placeholder="Search by name, employee number, or designation...">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 group-hover:text-emerald-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Teacher Table --}}
            <div class="overflow-hidden rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 shadow-2xl backdrop-blur-2xl">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left text-[11px] font-black uppercase tracking-wider text-slate-300">
                        <thead>
                            <tr class="bg-[#071c2c]/90 text-slate-400 border-b border-white/5">
                                <th class="px-8 py-8 text-center">PICTURE</th>
                                <th class="px-8 py-8">TEACHER DETAILS</th>
                                <th class="px-8 py-8">ID NUMBER</th>
                                <th class="px-8 py-8">DESIGNATION</th>
                                <th class="px-8 py-8 text-center">STATUS</th>
                                <th class="px-8 py-8 text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($teachers as $teacher)
                                <tr class="hover:bg-white/[0.03] transition-all duration-500 group">
                                    <td class="px-8 py-6">
                                        <div class="relative mx-auto size-16 overflow-hidden rounded-full border-2 border-slate-700 bg-slate-800 shadow-2xl group-hover:border-emerald-500 transition-all duration-700">
                                            @if($teacher->image_path)
                                                <img src="{{ asset('storage/' . $teacher->image_path) }}" class="h-full w-full object-cover group-hover:scale-125 transition-transform duration-700">
                                            @else
                                                <div class="flex size-full items-center justify-center text-slate-600">
                                                    <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="space-y-1">
                                            <p class="text-sm font-black text-white group-hover:text-emerald-400 transition-colors tracking-tight">{{ $teacher->name }}</p>
                                            <p class="text-[10px] text-slate-500 tracking-normal normal-case font-bold">{{ $teacher->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="font-mono text-emerald-400">{{ $teacher->employee_number }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="space-y-1">
                                            <p class="text-white font-bold">{{ $teacher->designation }}</p>
                                            <p class="text-[9px] text-slate-500">{{ $teacher->department ?: 'N/A' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @if($teacher->is_active)
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-3 py-1 text-[9px] font-black text-emerald-500 border border-emerald-500/20">
                                                ACTIVE
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-500/10 px-3 py-1 text-[9px] font-black text-slate-400 border border-slate-500/20">
                                                INACTIVE
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center justify-center gap-6">
                                            <a href="{{ route('super-admin.teachers.edit', $teacher) }}"
                                                class="group/btn flex items-center gap-2 text-[10px] font-black text-blue-500 hover:text-blue-400 transition-all">
                                                <span class="grid size-8 place-items-center rounded-lg bg-blue-500/10 border border-blue-500/20 group-hover/btn:bg-blue-500 group-hover/btn:text-white transition-all">
                                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </span>
                                                EDIT
                                            </a>
                                            <form action="{{ route('super-admin.teachers.destroy', $teacher) }}" method="POST" onsubmit="return confirm('Delete this teacher record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="group/btn flex items-center gap-2 text-[10px] font-black text-pink-600 hover:text-pink-500 transition-all">
                                                    <span class="grid size-8 place-items-center rounded-lg bg-pink-500/10 border border-pink-500/20 group-hover/btn:bg-pink-600 group-hover/btn:text-white transition-all">
                                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </span>
                                                    DELETE
                                                </button>
                                            </form>
                                            <a href="{{ route('super-admin.teachers.show', $teacher) }}"
                                                class="group/btn flex items-center gap-2 text-[10px] font-black text-emerald-500 hover:text-emerald-400 transition-all">
                                                <span class="grid size-8 place-items-center rounded-lg bg-emerald-500/10 border border-emerald-500/20 group-hover/btn:bg-emerald-500 group-hover/btn:text-white transition-all">
                                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </span>
                                                VIEW
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-32 text-center text-slate-500 uppercase tracking-widest font-black opacity-30">
                                        No teachers found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-[#071c2c]/80 px-8 py-10 border-t border-white/5 backdrop-blur-md">
                    <div class="flex items-center justify-between">
                        <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest">
                            Showing <span class="text-white">{{ $teachers->count() }}</span> Faculty Members
                        </p>
                        {{ $teachers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-shell>

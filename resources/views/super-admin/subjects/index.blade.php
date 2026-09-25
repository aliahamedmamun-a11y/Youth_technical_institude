<x-dashboard-shell :title="$semester->name.' · Curriculum Subjects'" eyebrow="Academic Architecture" :description="$semester->course->name.' · Manage subject codes, credit weightage, and sorting order.'" :breadcrumbs="['Semester Setup' => route('super-admin.semester-setup.index'), $semester->course->name => route('super-admin.courses.semesters.index', $semester->course), $semester->name => null]">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-8">
            {{-- Header --}}
            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="text-center lg:text-left">
                    <h1 class="text-2xl font-black text-white uppercase tracking-[0.2em] drop-shadow-lg">
                        {{ $semester->name }} <span class="text-blue-500">Subjects</span>
                    </h1>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-500">{{ $semester->course->name }} Curriculum</p>
                </div>

                <a href="{{ route('super-admin.semesters.subjects.create', $semester) }}"
                    class="inline-flex h-14 items-center justify-center gap-3 rounded-2xl bg-blue-600 px-8 text-xs font-black uppercase tracking-widest text-white shadow-xl shadow-blue-600/20 hover:bg-blue-500 hover:-translate-y-0.5 transition-all active:scale-95">
                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                    Add Subject
                </a>
            </div>

            {{-- Subjects Table --}}
            <div class="overflow-hidden rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 shadow-2xl backdrop-blur-2xl">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left text-[11px] font-black uppercase tracking-wider text-slate-300">
                        <thead>
                            <tr class="bg-[#071c2c]/90 text-slate-400 border-b border-white/5">
                                <th class="px-8 py-8">SUBJECT CODE</th>
                                <th class="px-8 py-8">SUBJECT TITLE</th>
                                <th class="px-8 py-8 text-center">CREDITS</th>
                                <th class="px-8 py-8 text-center">SORT ORDER</th>
                                <th class="px-8 py-8 text-center">STATUS</th>
                                <th class="px-8 py-8 text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($subjects as $subject)
                                <tr class="hover:bg-white/[0.03] transition-all duration-500 group">
                                    <td class="px-8 py-6">
                                        <span class="font-mono text-emerald-400 tracking-widest">{{ $subject->code }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        <p class="text-sm font-black text-white group-hover:text-blue-400 transition-colors">{{ $subject->title }}</p>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <span class="inline-flex items-center justify-center size-8 rounded-lg bg-[#071c2c] border border-white/5 text-indigo-400">
                                            {{ $subject->credit }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 text-center text-slate-500">
                                        {{ $subject->sort_order }}
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        @if($subject->is_active)
                                            <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-[9px] font-black text-emerald-500 border border-emerald-500/20">ACTIVE</span>
                                        @else
                                            <span class="rounded-full bg-rose-500/10 px-3 py-1 text-[9px] font-black text-rose-500 border border-rose-500/20">INACTIVE</span>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center justify-center gap-6">
                                            <a href="{{ route('super-admin.semesters.subjects.edit', [$semester, $subject]) }}"
                                                class="group/btn flex items-center gap-2 text-[10px] font-black text-blue-500 hover:text-blue-400 transition-all">
                                                <span class="grid size-8 place-items-center rounded-lg bg-blue-500/10 border border-blue-500/20 group-hover/btn:bg-blue-500 group-hover/btn:text-white transition-all">
                                                    <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </span>
                                                EDIT
                                            </a>
                                            <form action="{{ route('super-admin.semesters.subjects.destroy', [$semester, $subject]) }}" method="POST" onsubmit="return confirm('Delete this subject?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="group/btn flex items-center gap-2 text-[10px] font-black text-pink-600 hover:text-pink-500 transition-all">
                                                    <span class="grid size-8 place-items-center rounded-lg bg-pink-500/10 border border-pink-500/20 group-hover/btn:bg-pink-600 group-hover/btn:text-white transition-all">
                                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                    </span>
                                                    DELETE
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-32 text-center text-slate-500 uppercase tracking-widest font-black opacity-30">
                                        No subjects found in this semester.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-[#071c2c]/80 px-8 py-10 border-t border-white/5 backdrop-blur-md">
                    <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest">
                        Total Subjects: <span class="text-white">{{ $subjects->count() }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-shell>

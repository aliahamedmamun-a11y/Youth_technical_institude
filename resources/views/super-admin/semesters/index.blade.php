<x-dashboard-shell :title="$course->name.' · Semester Structure'" eyebrow="Academic Architecture" description="Configure the semester progression and manage specific subjects for this program." :breadcrumbs="['Semester Setup' => route('super-admin.semester-setup.index'), $course->name => null]">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-8">
            {{-- Header --}}
            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="text-center lg:text-left">
                    <h1 class="text-2xl font-black text-white uppercase tracking-[0.2em] drop-shadow-lg">
                        {{ $course->name }} <span class="text-blue-500">Semesters</span>
                    </h1>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-500">{{ $course->duration }} Program Structure</p>
                </div>

                <a href="{{ route('super-admin.courses.semesters.create', $course) }}"
                    class="inline-flex h-14 items-center justify-center gap-3 rounded-2xl bg-blue-600 px-8 text-xs font-black uppercase tracking-widest text-white shadow-xl shadow-blue-600/20 hover:bg-blue-500 hover:-translate-y-0.5 transition-all active:scale-95">
                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3"><path d="M12 4v16m8-8H4"/></svg>
                    New Semester
                </a>
            </div>

            {{-- Semesters Grid --}}
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse($semesters as $semester)
                    <article class="group relative overflow-hidden rounded-[2rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-xl transition-all duration-500 hover:border-emerald-500/30">
                        <div class="flex items-start justify-between mb-6">
                            <div class="space-y-1">
                                <h2 class="text-lg font-black text-white group-hover:text-emerald-400 transition-colors uppercase tracking-tight">{{ $semester->name }}</h2>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Order: {{ $semester->sort_order }}</p>
                            </div>
                            @if($semester->is_active)
                                <span class="rounded-full bg-emerald-500/10 px-3 py-1 text-[9px] font-black text-emerald-500 border border-emerald-500/20">ACTIVE</span>
                            @else
                                <span class="rounded-full bg-slate-500/10 px-3 py-1 text-[9px] font-black text-slate-400 border border-slate-500/20">INACTIVE</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 py-4 px-4 rounded-2xl bg-[#071c2c]/50 border border-white/5 mb-8">
                            <div class="grid size-10 place-items-center rounded-lg bg-emerald-500/10 text-emerald-500 shadow-inner">
                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div>
                                <p class="text-[14px] font-black text-white">{{ $semester->subjects_count }}</p>
                                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Curriculum Subjects</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <a href="{{ route('super-admin.semesters.subjects.index', $semester) }}"
                                class="flex-1 inline-flex h-10 items-center justify-center rounded-xl bg-emerald-600 px-4 text-[10px] font-black uppercase text-white hover:bg-emerald-500 transition-all">
                                Subjects
                            </a>
                            <a href="{{ route('super-admin.courses.semesters.edit', [$course, $semester]) }}"
                                class="inline-flex size-10 items-center justify-center rounded-xl bg-blue-600/10 text-blue-500 border border-blue-500/20 hover:bg-blue-600 hover:text-white transition-all">
                                <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <form action="{{ route('super-admin.courses.semesters.destroy', [$course, $semester]) }}" method="POST" onsubmit="return confirm('Delete this semester and all its subjects?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex size-10 items-center justify-center rounded-xl bg-pink-600/10 text-pink-500 border border-pink-500/20 hover:bg-pink-600 hover:text-white transition-all">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <p class="text-sm font-black uppercase tracking-widest text-slate-500">No semesters defined for this course yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-shell>

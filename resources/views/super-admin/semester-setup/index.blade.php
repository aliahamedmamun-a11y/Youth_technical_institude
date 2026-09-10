<x-dashboard-shell title="Academic Architecture" eyebrow="Academic Setup" description="Select a course to define its semesters and curriculum subjects.">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>
        <div class="absolute -left-20 bottom-0 size-80 rounded-full bg-indigo-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-10">
            {{-- Header Section --}}
            <div class="text-center space-y-6 pt-6">
                <h1 class="text-2xl font-black text-white uppercase tracking-[0.25em] drop-shadow-lg">Semester & Subject <span class="text-blue-500">Setup</span></h1>
                <p class="mx-auto max-w-2xl text-xs font-bold uppercase tracking-widest text-slate-500 leading-relaxed">Choose a department or course from the inventory below to manage its academic structure, individual semesters, and subject lists.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($courses as $course)
                    <article class="group relative overflow-hidden rounded-[2rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:border-blue-500/30 hover:bg-[#0f2d44]/60">
                        <div class="absolute -right-6 -top-6 size-24 rounded-full bg-blue-500/5 transition-transform duration-700 group-hover:scale-[3]"></div>

                        <div class="relative z-10 flex flex-col h-full">
                            <div class="mb-6 grid size-14 place-items-center rounded-2xl bg-[#071c2c] text-blue-500 shadow-xl ring-1 ring-white/5">
                                <svg viewBox="0 0 24 24" class="size-7" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            </div>

                            <h2 class="text-lg font-black text-white group-hover:text-blue-400 transition-colors uppercase tracking-tight">{{ $course->name }}</h2>
                            <p class="mt-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $course->duration }} Program</p>

                            <div class="mt-8 flex items-center justify-between border-t border-white/5 pt-6">
                                <div class="space-y-1">
                                    <p class="text-[9px] font-black text-slate-500 uppercase">Configured</p>
                                    <p class="text-sm font-black text-emerald-500">{{ $course->semesters_count }} Semesters</p>
                                </div>
                                <a href="{{ route('super-admin.courses.semesters.index', $course) }}"
                                    class="inline-flex size-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-600/20 hover:bg-blue-500 transition-all active:scale-90">
                                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="3"><path d="M5 12h14m-7-7 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full rounded-[2.5rem] border border-dashed border-slate-700 p-20 text-center backdrop-blur-md">
                        <div class="mx-auto mb-6 grid size-20 place-items-center rounded-full bg-slate-800 text-slate-600">
                            <svg viewBox="0 0 24 24" class="size-10" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 4v16m8-8H4"></path></svg>
                        </div>
                        <p class="text-sm font-black uppercase tracking-widest text-slate-500">No active courses found. Please <a href="{{ route('super-admin.courses.create') }}" class="text-blue-500 hover:underline">create a course</a> first.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-shell>

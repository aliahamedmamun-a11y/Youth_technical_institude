<x-dashboard-shell title="AllTableAdminPost">
    <div class="mx-auto max-w-[1600px] space-y-10">
        {{-- Header Section --}}
        <div class="text-center">
            <h1 class="text-5xl font-black text-[#6cb2eb] uppercase tracking-tight" style="color: #6366f1;">Notice Board Push</h1>
            <p class="mt-4 text-sm font-bold text-slate-500 uppercase tracking-widest">
                প্রশাসকের কাছে প্রেরিত নোটিশ বা বার্তাগুলি এখানে দেখুন, সম্পাদনা করুন এবং পরিচালনা করুন।
            </p>
        </div>

        {{-- Grid of Notices --}}
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($suggestions as $notice)
                <article class="group relative flex flex-col rounded-[2.5rem] border border-white/10 bg-[#1e293b]/60 p-8 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:-translate-y-2 hover:border-indigo-500/30" style="background-color: #2d3748;">
                    <div class="flex-1 space-y-6">
                        {{-- Content --}}
                        <div class="space-y-4">
                            <h2 class="text-lg font-bold leading-relaxed text-slate-300">
                                {{ $notice->name ?: 'সাধারণ বিজ্ঞপ্তি' }}
                            </h2>

                            <div class="h-px w-full bg-white/5"></div>

                            <p class="text-sm font-medium leading-relaxed text-slate-400">
                                <span class="font-black text-indigo-400">বার্তা:</span>
                                <span class="break-all">{{ $notice->suggestion }}</span>
                            </p>
                        </div>
                    </div>

                    {{-- Action Button --}}
                    <div class="mt-10">
                        <form action="{{ route('super-admin.subject-suggestions.destroy', $notice) }}" method="POST" onsubmit="return confirm('Delete this notice?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 py-3 text-sm font-black text-white shadow-xl transition hover:bg-red-500 active:scale-95">
                                <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                (Delete)
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-32 text-center">
                    <p class="text-lg font-black text-slate-600 uppercase tracking-[0.3em]">No notices posted yet.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard-shell>

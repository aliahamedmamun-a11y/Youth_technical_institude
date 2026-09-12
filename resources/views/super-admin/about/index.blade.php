<x-dashboard-shell title="About Us Management" eyebrow="Website Content" description="Manage the institute stories and leadership information shown publicly.">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>
        <div class="absolute -left-20 bottom-0 size-80 rounded-full bg-indigo-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-10">
            {{-- Header Section --}}
            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-black text-white uppercase tracking-[0.3em] drop-shadow-2xl">
                        About Us <span class="text-blue-500">Manager</span>
                    </h1>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-500">Institute Profile Management</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <div class="flex h-16 items-center gap-4 rounded-2xl bg-[#0f2d44]/50 px-6 border border-white/5 backdrop-blur-md shadow-xl">
                        <div class="size-2 rounded-full bg-blue-500 animate-pulse"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Total Entries</p>
                            <p class="text-xl font-black text-white">{{ $abouts->total() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.about.create') }}"
                        class="inline-flex h-16 items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 px-8 text-sm font-black uppercase tracking-widest text-white shadow-2xl shadow-blue-600/30 hover:from-blue-500 hover:to-indigo-600 hover:-translate-y-1 transition-all active:scale-95">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Add Entry
                    </a>
                </div>
            </div>

            {{-- Search & Filters --}}
            <div class="rounded-[2rem] bg-[#0f2d44]/30 p-4 border border-white/5 backdrop-blur-sm shadow-inner">
                <form method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1 group">
                        <input type="text" name="search" value="{{ $search }}"
                            class="w-full rounded-xl border border-white/5 bg-[#071c2c]/50 py-4 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all"
                            placeholder="Search headings or summaries...">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 group-hover:text-blue-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <select name="status" onchange="this.form.submit()"
                        class="rounded-xl border border-white/5 bg-[#071c2c]/50 px-6 py-4 text-xs font-black text-slate-300 uppercase tracking-widest outline-none focus:border-blue-500 transition-all">
                        <option value="">All Status</option>
                        <option value="published" @selected($selectedStatus === 'published')>Published</option>
                        <option value="draft" @selected($selectedStatus === 'draft')>Drafts</option>
                    </select>
                </form>
            </div>

            {{-- Grid of Entries --}}
            @if($abouts->isEmpty())
                <div class="rounded-[2.5rem] border border-dashed border-slate-700 p-24 text-center backdrop-blur-md">
                    <p class="text-sm font-black uppercase tracking-widest text-slate-500">No about entries found.</p>
                </div>
            @else
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($abouts as $about)
                        <article class="group relative overflow-hidden rounded-[2rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-xl transition-all duration-500 hover:border-blue-500/30">
                            <div class="flex items-start gap-4">
                                @if($about->image_path)
                                    <div class="size-20 shrink-0 overflow-hidden rounded-2xl border-2 border-white/5 bg-slate-800">
                                        <img src="{{ Storage::disk('public')->url($about->image_path) }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h2 class="text-base font-black text-white group-hover:text-blue-400 transition-colors uppercase tracking-tight line-clamp-2">{{ $about->about_heading }}</h2>
                                    <div class="mt-2 flex items-center gap-3">
                                        @if($about->is_published)
                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-[8px] font-black text-emerald-500 border border-emerald-500/20 uppercase tracking-widest">Live</span>
                                        @else
                                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-500/10 px-3 py-1 text-[8px] font-black text-slate-400 border border-slate-500/20 uppercase tracking-widest">Draft</span>
                                        @endif
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Order: {{ $about->sort_order }}</span>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-6 text-xs leading-6 text-slate-400 line-clamp-3 font-medium">{{ $about->summary }}</p>

                            <div class="mt-8 flex items-center gap-3 border-t border-white/5 pt-6">
                                <a href="{{ route('super-admin.about.edit', $about) }}"
                                    class="flex-1 inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-[10px] font-black uppercase text-white hover:bg-blue-500 transition-all shadow-lg active:scale-95">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('super-admin.about.publish', $about) }}" class="flex-1">
                                    @csrf @method('PATCH')
                                    <button class="w-full inline-flex h-11 items-center justify-center rounded-xl bg-white/5 px-4 text-[10px] font-black uppercase text-slate-300 border border-white/10 hover:bg-white/10 transition-all active:scale-95">
                                        {{ $about->is_published ? 'Unpublish' : 'Publish' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('super-admin.about.destroy', $about) }}" onsubmit="return confirm('Delete this entry?')" class="shrink-0">
                                    @csrf @method('DELETE')
                                    <button class="grid size-11 place-items-center rounded-xl bg-pink-600/10 text-pink-500 border border-pink-500/20 hover:bg-pink-600 hover:text-white transition-all active:scale-95">
                                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-10">{{ $abouts->links() }}</div>
            @endif
        </div>
    </div>
</x-dashboard-shell>

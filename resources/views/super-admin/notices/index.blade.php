<x-dashboard-shell title="Notice Board" eyebrow="Notifications" description="Manage and publish official announcements for the public notice board.">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-amber-600/10 blur-[100px]"></div>
        <div class="absolute -left-20 bottom-0 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-10">
            {{-- Header Section --}}
            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-black text-white uppercase tracking-[0.3em] drop-shadow-2xl">
                        Notice <span class="text-amber-500">Board</span>
                    </h1>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-500">Official Announcements & Notifications</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <div class="flex h-16 items-center gap-4 rounded-2xl bg-[#0f2d44]/50 px-6 border border-white/5 backdrop-blur-md shadow-xl">
                        <div class="size-2 rounded-full bg-amber-500 animate-ping"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Active Notices</p>
                            <p class="text-xl font-black text-white">{{ $notices->where('is_published', true)->count() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.notices.create') }}"
                        class="inline-flex h-16 items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-amber-500 to-orange-600 px-8 text-sm font-black uppercase tracking-widest text-[#03224c] shadow-2xl shadow-amber-500/20 hover:from-amber-400 hover:to-orange-500 hover:-translate-y-1 transition-all active:scale-95">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Post Notice
                    </a>
                </div>
            </div>

            {{-- Search & Filters --}}
            <div class="rounded-[2rem] bg-[#0f2d44]/30 p-4 border border-white/5 backdrop-blur-sm shadow-inner">
                <form method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1 group">
                        <input type="text" name="search" value="{{ $search }}"
                            class="w-full rounded-xl border border-white/5 bg-[#071c2c]/50 py-4 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition-all"
                            placeholder="Search notices by title or content...">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500 group-hover:text-amber-500 transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    <select name="status" onchange="this.form.submit()"
                        class="rounded-xl border border-white/5 bg-[#071c2c]/50 px-6 py-4 text-xs font-black text-slate-300 uppercase tracking-widest outline-none focus:border-amber-500 transition-all">
                        <option value="">All Notices</option>
                        <option value="published" @selected($selectedStatus === 'published')>Published</option>
                        <option value="draft" @selected($selectedStatus === 'draft')>Drafts</option>
                    </select>
                </form>
            </div>

            {{-- Notices List --}}
            @if($notices->isEmpty())
                <div class="rounded-[2.5rem] border border-dashed border-slate-700 p-24 text-center backdrop-blur-md">
                    <p class="text-sm font-black uppercase tracking-widest text-slate-500">No official notices have been posted yet.</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($notices as $notice)
                        <article class="group relative overflow-hidden rounded-[2rem] border border-white/5 bg-[#0f2d44]/40 p-8 shadow-2xl backdrop-blur-xl transition-all duration-500 hover:border-amber-500/30">
                            {{-- Status Badge --}}
                            <div class="absolute top-6 right-8">
                                @if($notice->is_published)
                                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-[9px] font-black text-emerald-500 border border-emerald-500/20 uppercase tracking-widest">
                                        <span class="size-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,1)]"></span>
                                        Live
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-2 rounded-full bg-slate-500/10 px-3 py-1 text-[9px] font-black text-slate-400 border border-slate-500/20 uppercase tracking-widest">
                                        <span class="size-1.5 rounded-full bg-slate-500"></span>
                                        Draft
                                    </span>
                                @endif
                            </div>

                            {{-- Notice Content --}}
                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-amber-500">
                                        <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80">Official Announcement</span>
                                    </div>
                                    <h2 class="text-xl font-black text-white group-hover:text-amber-400 transition-colors uppercase tracking-tight line-clamp-2 leading-none pt-2">{{ $notice->title }}</h2>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $notice->author?->name ?: 'System' }} · {{ $notice->published_at?->format('d M Y, h:i A') ?: 'Not published' }}</p>
                                </div>

                                <div class="h-px w-full bg-white/5"></div>

                                <p class="text-sm leading-7 text-slate-400 line-clamp-4 font-medium">{{ $notice->message }}</p>

                                <div class="flex items-center gap-3 pt-2">
                                    <a href="{{ route('super-admin.notices.edit', $notice) }}"
                                        class="flex-1 inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-[10px] font-black uppercase text-white hover:bg-blue-500 transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                                        <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('super-admin.notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Permanently delete this notice?')">
                                        @csrf @method('DELETE')
                                        <button class="grid size-11 place-items-center rounded-xl bg-pink-600/10 text-pink-500 border border-pink-500/20 hover:bg-pink-600 hover:text-white transition-all active:scale-95">
                                            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-10">{{ $notices->links() }}</div>
            @endif
        </div>
    </div>
</x-dashboard-shell>

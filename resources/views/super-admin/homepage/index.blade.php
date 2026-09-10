<x-dashboard-shell :title="$section->label" eyebrow="Website Management" description="Manage the visual media and content shown on the public homepage.">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        {{-- Decorative background glow --}}
        <div class="absolute -right-20 -top-20 size-80 rounded-full bg-blue-600/10 blur-[100px]"></div>
        <div class="absolute -left-20 bottom-0 size-80 rounded-full bg-amber-600/10 blur-[100px]"></div>

        <div class="relative mx-auto max-w-[1600px] space-y-10">
            {{-- Header Section --}}
            <div class="flex flex-col items-center justify-between gap-6 lg:flex-row">
                <div class="text-center lg:text-left">
                    <h1 class="text-3xl font-black text-white uppercase tracking-[0.3em] drop-shadow-2xl">
                        {{ $section->label }} <span class="text-blue-500">Manager</span>
                    </h1>
                    <p class="mt-2 text-xs font-bold uppercase tracking-widest text-slate-500">Website Content Management System</p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <div class="flex h-16 items-center gap-4 rounded-2xl bg-[#0f2d44]/50 px-6 border border-white/5 backdrop-blur-md shadow-xl">
                        <div class="size-2 rounded-full bg-blue-500 animate-pulse"></div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">Current Section</p>
                            <p class="text-sm font-black text-white">{{ $section->label }}</p>
                        </div>
                    </div>
                    <a href="{{ route('super-admin.homepage.items.create', $section->key) }}"
                        class="inline-flex h-16 items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-700 px-8 text-sm font-black uppercase tracking-widest text-white shadow-2xl shadow-blue-600/30 hover:from-blue-500 hover:to-indigo-600 hover:-translate-y-1 transition-all active:scale-95">
                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                        Add New Item
                    </a>
                </div>
            </div>

            {{-- Section Controls --}}
            <div class="rounded-[2rem] bg-[#0f2d44]/30 p-6 border border-white/5 backdrop-blur-sm shadow-inner">
                <form class="flex flex-col md:flex-row items-center justify-between gap-8" method="POST" action="{{ route('super-admin.homepage.sections.update', $section) }}">
                    @csrf @method('PATCH')
                    <div class="flex flex-wrap items-center gap-6">
                        <label class="group relative flex cursor-pointer items-center gap-4 rounded-2xl bg-[#071c2c]/50 px-6 py-4 transition hover:bg-[#071c2c] ring-1 ring-white/5">
                            <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300 peer-checked:bg-blue-600">
                                <input type="hidden" name="is_visible" value="0">
                                <input type="checkbox" name="is_visible" value="1" @checked($section->is_visible) class="peer sr-only" onchange="this.form.submit()">
                                <div class="size-4 rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></div>
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-white">Section Visibility</p>
                                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Show this section on homepage</p>
                            </div>
                        </label>
                        <div class="flex items-center gap-4">
                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Order:</span>
                            <input class="w-20 rounded-xl border border-white/5 bg-[#071c2c]/50 px-4 py-3 text-sm font-black text-white outline-none focus:border-blue-500 transition-all"
                                type="number" name="sort_order" value="{{ $section->sort_order }}" min="0">
                        </div>
                    </div>
                    <button class="w-full md:w-auto rounded-xl bg-white/5 px-8 py-4 text-[10px] font-black uppercase tracking-widest text-slate-300 hover:bg-white/10 transition-all border border-white/5">Update Settings</button>
                </form>
            </div>

            {{-- Grid of Items --}}
            @if($items->isEmpty())
                <div class="rounded-[2.5rem] border border-dashed border-slate-700 p-24 text-center backdrop-blur-md">
                    <p class="text-sm font-black uppercase tracking-widest text-slate-500">No content found in this gallery yet.</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach($items as $item)
                        <article class="group relative overflow-hidden rounded-[2rem] border border-white/5 bg-[#0f2d44]/40 p-4 shadow-2xl backdrop-blur-xl transition-all duration-500 hover:border-blue-500/30">
                            <div class="relative aspect-square overflow-hidden rounded-[1.5rem] bg-slate-800 shadow-inner">
                                @if($item->image_path)
                                    <img src="{{ str_starts_with($item->image_path, 'images/') ? asset($item->image_path) : Storage::disk('public')->url($item->image_path) }}"
                                        class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="flex size-full items-center justify-center text-slate-700">
                                        <svg viewBox="0 0 24 24" class="size-16" fill="none" stroke="currentColor" stroke-width="1"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif

                                {{-- Overlay --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-[#071c2c] via-[#071c2c]/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity"></div>

                                {{-- Actions floating --}}
                                <div class="absolute top-4 right-4 flex flex-col gap-2 translate-x-12 opacity-0 group-hover:translate-x-0 group-hover:opacity-100 transition-all duration-300">
                                    <a href="{{ route('super-admin.homepage.items.edit', $item) }}"
                                        class="grid size-10 place-items-center rounded-xl bg-blue-600 text-white shadow-lg hover:bg-blue-500 transition-all">
                                        <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('super-admin.homepage.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this gallery item?')">
                                        @csrf @method('DELETE')
                                        <button class="grid size-10 place-items-center rounded-xl bg-pink-600 text-white shadow-lg hover:bg-pink-500 transition-all">
                                            <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="absolute bottom-4 left-4 right-4">
                                    <h2 class="text-sm font-black text-white uppercase tracking-wider line-clamp-1 group-hover:text-blue-400 transition-colors">{{ $item->title ?: 'Untitled Gallery Item' }}</h2>
                                    <div class="mt-2 flex items-center justify-between">
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Order: {{ $item->sort_order }}</span>
                                        @if($item->is_published)
                                            <span class="size-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                                        @else
                                            <span class="size-1.5 rounded-full bg-slate-600"></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <div class="mt-10">{{ $items->links() }}</div>
            @endif
        </div>
    </div>
</x-dashboard-shell>

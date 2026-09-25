<x-dashboard-shell :title="$section->label">
    @if($section->key === 'testimonials')
        <div class="mx-auto max-w-[1600px] space-y-10">
            {{-- Header --}}
            <div class="text-center">
                <h1 class="text-4xl font-black text-[#4da6ff] uppercase tracking-tight">Manage Student Reviews</h1>
                <div class="mx-auto mt-4 h-1.5 w-24 rounded-full bg-blue-600"></div>
            </div>

            {{-- Grid of Reviews --}}
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($items as $item)
                    <article class="group relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-[#0f2d44]/60 p-8 shadow-2xl transition-all duration-500 hover:-translate-y-2 hover:border-blue-500/30">
                        {{-- Delete Button (Top Right) --}}
                        <form action="{{ route('super-admin.homepage.items.destroy', $item) }}" method="POST" class="absolute right-6 top-6 z-10" onsubmit="return confirm('Delete this review?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="grid size-10 place-items-center rounded-xl bg-red-600/10 text-red-500 transition-all hover:bg-red-600 hover:text-white active:scale-95 shadow-lg">
                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                            </button>
                        </form>

                        {{-- Card Header: User Info --}}
                        <div class="flex items-center gap-5">
                            <div class="relative">
                                <div class="size-16 overflow-hidden rounded-xl border-2 border-white/5 bg-slate-800 shadow-xl">
                                    <img src="{{ $item->image_path ? (str_starts_with($item->image_path, 'images/') ? asset($item->image_path) : Storage::disk('public')->url($item->image_path)) : asset('images/placeholder-avatar.png') }}"
                                        class="size-full object-cover">
                                </div>
                                <div class="absolute -bottom-1 -right-1 size-3 rounded-full bg-emerald-500 ring-4 ring-[#0f2d44]"></div>
                            </div>
                            <div>
                                <h2 class="text-lg font-black text-white uppercase tracking-tight line-clamp-1">{{ $item->title }}</h2>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                                    <svg viewBox="0 0 24 24" class="mr-1 inline size-3" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="16" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    {{ $item->created_at->format('m/d/Y') }}
                                </p>
                            </div>
                        </div>

                        {{-- Card Body: Quote --}}
                        <div class="mt-8 min-h-[160px] rounded-3xl bg-[#071c2c]/40 p-6 ring-1 ring-white/5">
                            <p class="text-[13px] font-medium leading-relaxed text-slate-300">
                                <span class="text-2xl font-black text-blue-500/50">"</span>
                                {{ $item->body }}
                                <span class="text-2xl font-black text-blue-500/50">"</span>
                            </p>
                        </div>

                        {{-- Card Footer --}}
                        <div class="mt-8 flex items-center justify-between border-t border-white/5 pt-6">
                            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-500 uppercase">
                                <svg viewBox="0 0 24 24" class="size-3" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $item->created_at->format('h:i A') }}
                            </div>
                            <span class="text-[10px] font-black text-blue-500 uppercase tracking-[0.2em]">Verified Review</span>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($items->hasPages())
                <div class="mt-10"> {{ $items->links() }} </div>
            @endif
        </div>
    @else
        <div class="mx-auto max-w-4xl space-y-10">
            {{-- Integrated Upload Form for Banners/Items --}}
            <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">
                <h2 class="mb-8 flex items-center gap-3 text-xl font-black text-white uppercase tracking-widest">
                    <svg viewBox="0 0 24 24" class="size-6 text-amber-500" fill="none" stroke="currentColor" stroke-width="2.5">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    Add {{ $section->label }}
                </h2>

                <form action="{{ route('super-admin.homepage.items.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="section" value="{{ $section->key }}">
                    <input type="hidden" name="stable_key" value="{{ $section->key . '-' . time() }}">
                    <input type="hidden" name="is_published" value="1">

                    <div class="rounded-xl bg-[#071c2c]/80 p-8 border border-white/10">
                        <div class="flex flex-col items-center gap-6">
                            <div class="flex items-center gap-4">
                                <label class="cursor-pointer rounded-full bg-emerald-600 px-6 py-2 text-xs font-black text-white transition hover:bg-emerald-500 shadow-lg">
                                    Choose File
                                    <input type="file" name="image" class="hidden" required onchange="updateFileName(this)">
                                </label>
                                <span id="file-name-display" class="text-sm font-bold text-slate-400">No file chosen</span>
                            </div>
                            <button type="submit" class="w-full rounded-xl bg-emerald-600 py-3.5 text-sm font-black text-white uppercase tracking-widest transition hover:bg-emerald-500 active:scale-95 shadow-lg">
                                Upload Image
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- List View for Banners/Other Items --}}
            <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">
                <h2 class="mb-8 flex items-center gap-3 text-lg font-black text-white uppercase tracking-widest">
                    <span class="size-2 rounded-full bg-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.8)]"></span>
                    All Live {{ $section->label }}
                </h2>

                <div class="space-y-4">
                    @forelse($items as $item)
                        <div class="flex items-center justify-between rounded-2xl border border-white/5 bg-[#071c2c]/30 p-4 transition-colors hover:bg-white/5">
                            <div class="flex items-center gap-6">
                                <div class="h-20 w-32 overflow-hidden rounded-xl border border-white/10 bg-slate-800 shadow-xl">
                                    <img src="{{ $item->image_path ? (str_starts_with($item->image_path, 'images/') ? asset($item->image_path) : Storage::disk('public')->url($item->image_path)) : asset('images/placeholder-avatar.png') }}" class="size-full object-cover">
                                </div>
                                <p class="text-sm font-black text-white uppercase tracking-widest">{{ $item->title ?: 'Untitled' }}</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('super-admin.homepage.items.edit', $item) }}" class="rounded-lg bg-blue-600 px-6 py-2 text-xs font-black uppercase text-white shadow-lg transition hover:bg-blue-500">Edit</a>
                                <form action="{{ route('super-admin.homepage.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-[#ff4d94] px-6 py-2 text-xs font-black uppercase text-white shadow-lg transition hover:bg-[#ff1a75]">Delete</button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-10 text-center text-sm font-bold text-slate-500"> No items found. </div>
                    @endforelse
                </div>
            </div>
        </div>
    @endif

    <script>
        function updateFileName(input) {
            const display = document.getElementById('file-name-display');
            if (input.files && input.files[0]) { display.textContent = input.files[0].name; }
            else { display.textContent = 'No file chosen'; }
        }
    </script>
</x-dashboard-shell>

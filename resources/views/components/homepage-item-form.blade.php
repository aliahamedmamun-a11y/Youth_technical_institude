@props(['item', 'section', 'action', 'method' => 'POST', 'submitLabel'])

@php
    $inputClass = 'w-full rounded-2xl border border-white/10 bg-[#0f2d44] py-4 px-6 text-sm text-white placeholder-slate-500 shadow-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all';
    $labelClass = 'block text-[11px] font-black uppercase tracking-widest text-[#6cb2eb] mb-2';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
    class="space-y-8 rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-2xl sm:p-10 ring-1 ring-white/10">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <input type="hidden" name="section" value="{{ $section->key }}">

    <div class="grid gap-8 md:grid-cols-2">
        <div>
            <label class="{{ $labelClass }}">Stable Reference Key *</label>
            <input name="stable_key" value="{{ old('stable_key', $item->stable_key) }}" required maxlength="100"
                placeholder="e.g. hero-slide-1 / gallery-img-1" class="{{ $inputClass }}">
            @error('stable_key') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">Title</label>
            <input name="title" value="{{ old('title', $item->title) }}" maxlength="255"
                placeholder="Display title for this item" class="{{ $inputClass }}">
            @error('title') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid gap-8 md:grid-cols-2">
        <div>
            <label class="{{ $labelClass }}">Subtitle / Caption</label>
            <input name="subtitle" value="{{ old('subtitle', $item->subtitle) }}" maxlength="255"
                placeholder="Secondary descriptive text" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">Sort Order</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}"
                class="{{ $inputClass }}">
        </div>
    </div>

    <div>
        <label class="{{ $labelClass }}">Description / Body Content</label>
        <textarea name="body" rows="4" maxlength="5000"
            placeholder="Detailed content or additional information..."
            class="{{ $inputClass }} resize-none">{{ old('body', $item->body) }}</textarea>
    </div>

    <div class="grid gap-8 md:grid-cols-2">
        <div>
            <label class="{{ $labelClass }}">Link Label (Button Text)</label>
            <input name="link_label" value="{{ old('link_label', $item->link_label) }}" maxlength="100"
                placeholder="e.g. Read More / Join Now" class="{{ $inputClass }}">
        </div>
        <div>
            <label class="{{ $labelClass }}">Link Destination URL</label>
            <input name="link_url" value="{{ old('link_url', $item->link_url) }}" maxlength="2048"
                placeholder="e.g. #contact / https://..." class="{{ $inputClass }}">
        </div>
    </div>

    <div class="grid gap-8 md:grid-cols-2">
        <div>
            <label class="{{ $labelClass }}">Media Image</label>
            <div class="relative group aspect-video rounded-2xl border-2 border-dashed border-white/10 bg-[#071c2c]/50 flex flex-col items-center justify-center p-4 transition-all hover:border-blue-500/50 cursor-pointer overflow-hidden">
                @if ($item->image_path)
                    <img id="item-preview" src="{{ str_starts_with($item->image_path, 'images/') ? asset($item->image_path) : Storage::disk('public')->url($item->image_path) }}"
                        class="absolute inset-0 h-full w-full object-cover opacity-40 group-hover:opacity-60 transition-all duration-500">
                @else
                    <img id="item-preview" src="#" class="absolute inset-0 h-full w-full object-cover hidden opacity-40 group-hover:opacity-60 transition-all duration-500">
                @endif

                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="mb-3 rounded-full bg-blue-500/10 p-4 text-blue-500 shadow-xl ring-1 ring-white/10">
                        <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black uppercase text-white">Upload New Media</p>
                    <p class="mt-1 text-[9px] font-bold text-[#6cb2eb]/60 uppercase tracking-tight">JPG / PNG / WebP · Max 5MB</p>
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                    class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewItemImage(this)">
            </div>
            @error('image') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col justify-end gap-6">
            <label class="group relative flex cursor-pointer items-center gap-4 rounded-2xl border border-white/5 bg-[#071c2c]/50 p-6 transition hover:bg-[#071c2c]">
                <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300 peer-checked:bg-emerald-600">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item->is_published))
                        class="peer sr-only">
                    <div class="size-4 rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></div>
                </div>
                <div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-white">Publishing Status</p>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Visible on the public website</p>
                </div>
            </label>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('super-admin.homepage.items.index', $section->key) }}"
                    class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl border border-white/10 bg-white/5 px-8 text-[12px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl bg-blue-600 px-8 text-[12px] font-black uppercase tracking-widest text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500 active:scale-95">
                    {{ $submitLabel }}
                </button>
            </div>
        </div>
    </div>
</form>

<script>
    function previewItemImage(input) {
        const preview = document.getElementById('item-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                preview.classList.add('opacity-40');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

@props(['about', 'action', 'method' => 'POST', 'submitLabel'])

@php
    $inputClass = 'w-full rounded-2xl border border-white/10 bg-[#0f2d44] py-4 px-6 text-sm text-white placeholder-slate-500 shadow-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all';
    $labelClass = 'block text-[11px] font-black uppercase tracking-widest text-[#6cb2eb] mb-2';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
    class="space-y-8 rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-2xl sm:p-10 ring-1 ring-white/10">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    <div class="grid gap-8 md:grid-cols-2">
        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Heading *</label>
            <input name="about_heading" value="{{ old('about_heading', $about->about_heading) }}" required maxlength="255" placeholder="Enter heading" class="{{ $inputClass }}">
            @error('about_heading')<span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">URL slug (optional)</label>
            <input name="slug" value="{{ old('slug', $about->slug) }}" maxlength="255" placeholder="Generated from heading if empty" class="{{ $inputClass }}">
            @error('slug')<span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">Display order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $about->sort_order ?? 0) }}" min="0" required class="{{ $inputClass }}">
        </div>

        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Summary *</label>
            <textarea name="summary" rows="3" required maxlength="500" placeholder="Brief summary" class="{{ $inputClass }} resize-none">{{ old('summary', $about->summary) }}</textarea>
            @error('summary')<span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span>@enderror
        </div>

        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Full content *</label>
            <textarea name="content" rows="10" required maxlength="10000" placeholder="Detailed content" class="{{ $inputClass }} resize-none leading-6">{{ old('content', $about->content) }}</textarea>
            <span class="mt-2 block text-[9px] font-bold text-slate-500 uppercase tracking-tight">Use blank lines to separate paragraphs.</span>
            @error('content')<span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span>@enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">Principal name</label>
            <input name="principal_name" value="{{ old('principal_name', $about->principal_name) }}" maxlength="255" placeholder="Principal name" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">Principal title</label>
            <input name="principal_title" value="{{ old('principal_title', $about->principal_title) }}" maxlength="255" placeholder="Principal title" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">Entry image</label>
            <div class="relative group aspect-video rounded-2xl border-2 border-dashed border-white/10 bg-[#071c2c]/50 flex flex-col items-center justify-center p-4 transition-all hover:border-blue-500/50 cursor-pointer overflow-hidden">
                @if ($about->image_path)
                    <img id="about-preview" src="{{ Storage::disk('public')->url($about->image_path) }}"
                        class="absolute inset-0 h-full w-full object-cover opacity-40 group-hover:opacity-60 transition-all duration-500">
                @else
                    <img id="about-preview" src="#" class="absolute inset-0 h-full w-full object-cover hidden opacity-40 group-hover:opacity-60 transition-all duration-500">
                @endif

                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="mb-3 rounded-full bg-blue-500/10 p-4 text-blue-500 shadow-xl ring-1 ring-white/10">
                        <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black uppercase text-white">Upload Image</p>
                    <p class="mt-1 text-[9px] font-bold text-[#6cb2eb]/60 uppercase tracking-tight">JPG / PNG / WebP · Max 5MB</p>
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewAboutImage(this)">
            </div>
            @error('image')<span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span>@enderror
        </div>

        <div class="flex flex-col justify-end gap-6">
            <label class="group relative flex cursor-pointer items-center gap-4 rounded-2xl border border-white/5 bg-[#071c2c]/50 p-6 transition hover:bg-[#071c2c]">
                <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300 peer-checked:bg-emerald-600">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $about->is_published ?? true)) class="peer sr-only">
                    <div class="size-4 rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></div>
                </div>
                <div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-white">Public Status</p>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Visible on the homepage</p>
                </div>
            </label>

            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('super-admin.about.index') }}" class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl border border-white/10 bg-white/5 px-8 text-[12px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">Cancel</a>
                <button type="submit" class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl bg-blue-600 px-8 text-[12px] font-black uppercase tracking-widest text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500 active:scale-95">{{ $submitLabel }}</button>
            </div>
        </div>
    </div>
</form>

<script>
    function previewAboutImage(input) {
        const preview = document.getElementById('about-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

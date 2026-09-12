<x-dashboard-shell title="Edit {{ $section->label }}">
    @if($section->key === 'testimonials')
        <div class="mx-auto max-w-2xl">
            <div class="rounded-[2.5rem] border border-white/20 bg-[#03224c] p-10 shadow-2xl backdrop-blur-sm lg:p-14">
                {{-- Header --}}
                <div class="mb-10 text-center">
                    <h1 class="text-4xl font-black text-white uppercase tracking-tight">Edit Review</h1>
                    <p class="mt-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#6cb2eb]">Update student experience</p>
                </div>

                <form action="{{ route('super-admin.homepage.items.update', $item) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="section" value="{{ $section->key }}">
                    <input type="hidden" name="stable_key" value="{{ $item->stable_key }}">
                    <input type="hidden" name="is_published" value="{{ $item->is_published }}">

                    {{-- Profile Photo Upload --}}
                    <div class="flex flex-col items-center">
                        <label for="review-photo" class="group relative flex size-32 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/10 bg-[#071c2c]/50 transition hover:border-blue-500/50">
                            <img id="review-photo-preview" src="{{ $item->image_path ? (str_starts_with($item->image_path, 'images/') ? asset($item->image_path) : Storage::disk('public')->url($item->image_path)) : '#' }}"
                                class="absolute inset-0 {{ $item->image_path ? '' : 'hidden' }} size-full rounded-2xl object-cover">
                            <div id="review-photo-placeholder" class="{{ $item->image_path ? 'hidden' : 'flex' }} flex flex-col items-center gap-2 text-slate-500">
                                <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                            </div>
                            <input type="file" name="image" id="review-photo" class="hidden" onchange="previewReviewPhoto(this)">
                        </label>
                        <p class="mt-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Change Profile Photo</p>
                        @error('image') <span class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Name Input --}}
                    <div>
                        <label class="mb-3 block text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">Your Name</label>
                        <input type="text" name="title" value="{{ old('title', $item->title) }}" required placeholder="Ex: John Doe"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-4 px-6 text-sm text-white placeholder-slate-600 focus:border-blue-500 outline-none transition-all">
                        @error('title') <span class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Suggestion/Body Input --}}
                    <div>
                        <label class="mb-3 block text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">Your Suggestion</label>
                        <textarea name="body" rows="6" required placeholder="What do you think about our system?"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-4 px-6 text-sm text-white placeholder-slate-600 focus:border-blue-500 outline-none transition-all resize-none">{{ old('body', $item->body) }}</textarea>
                        @error('body') <span class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-6">
                        <button type="submit" class="flex w-full items-center justify-center gap-3 rounded-2xl bg-blue-600 py-4 text-sm font-black text-white uppercase tracking-[0.2em] shadow-xl transition hover:bg-blue-500 active:scale-95">
                            Update Review
                            <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3">
                                <path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function previewReviewPhoto(input) {
                const preview = document.getElementById('review-photo-preview');
                const placeholder = document.getElementById('review-photo-placeholder');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @else
        <div class="mx-auto max-w-4xl py-6">
            <x-homepage-item-form :item="$item" :section="$section" :action="route('super-admin.homepage.items.update', $item)" method="PUT" submit-label="Save changes" />
        </div>
    @endif
</x-dashboard-shell>

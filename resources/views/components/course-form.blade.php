@props(['course' => null, 'action', 'method' => 'POST', 'submitLabel'])

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

    <div class="grid gap-8 md:grid-cols-2">
        <div>
            <label class="{{ $labelClass }}">Department / Course Name *</label>
            <input name="name" value="{{ old('name', $course?->name) }}" required maxlength="255"
                placeholder="Enter course name" class="{{ $inputClass }}">
            @error('name') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">Duration *</label>
            <input name="duration" value="{{ old('duration', $course?->duration) }}" required maxlength="100"
                placeholder="e.g. 6 Months" class="{{ $inputClass }}">
            @error('duration') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>
    </div>

    <div>
        <label class="{{ $labelClass }}">Course Description</label>
        <textarea name="description" rows="5" maxlength="5000"
            placeholder="Provide a brief overview of the course curriculum..."
            class="{{ $inputClass }} resize-none">{{ old('description', $course?->description) }}</textarea>
        @error('description') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
    </div>

    <div class="grid gap-8 md:grid-cols-2">
        <div>
            <label class="{{ $labelClass }}">Course Image</label>
            <div class="relative group aspect-[16/9] rounded-2xl border-2 border-dashed border-white/10 bg-[#071c2c]/50 flex flex-col items-center justify-center p-6 transition-all hover:border-blue-500/50 cursor-pointer overflow-hidden">
                @if ($course?->image_path)
                    <img id="course-preview" src="{{ Storage::disk('public')->url($course->image_path) }}"
                        class="absolute inset-0 h-full w-full object-cover opacity-40 group-hover:opacity-60 transition-all duration-500">
                @else
                    <img id="course-preview" src="#" class="absolute inset-0 h-full w-full object-cover hidden opacity-40 group-hover:opacity-60 transition-all duration-500">
                @endif

                <div class="relative z-10 flex flex-col items-center text-center">
                    <div class="mb-3 rounded-full bg-blue-500/10 p-4 text-blue-500 shadow-xl ring-1 ring-white/10">
                        <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-white">Upload Header Image</p>
                    <p class="mt-1 text-[9px] font-bold text-[#6cb2eb]/60 uppercase tracking-tight">JPG / PNG / WebP · Max 2MB</p>
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                    class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewImage(this)">
            </div>
            @error('image') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col justify-end">
            <label class="group relative flex cursor-pointer items-center gap-4 rounded-2xl border border-white/5 bg-[#071c2c]/50 p-6 transition hover:bg-[#071c2c]">
                <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300 peer-checked:bg-blue-600">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $course?->is_active ?? true))
                        class="peer sr-only">
                    <div class="size-4 rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></div>
                </div>
                <div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-white">Available for Enrolment</p>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Show this course in registration forms</p>
                </div>
            </label>
        </div>
    </div>

    <div class="flex flex-col justify-center gap-4 pt-6 sm:flex-row">
        <a href="{{ route('super-admin.courses.index') }}"
            class="inline-flex min-h-[55px] items-center justify-center rounded-xl border border-white/10 bg-white/5 px-12 text-[12px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex min-h-[55px] items-center justify-center rounded-xl bg-blue-600 px-12 text-[12px] font-black uppercase tracking-widest text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500 active:scale-95">
            {{ $submitLabel }}
        </button>
    </div>
</form>

<script>
    function previewImage(input) {
        const preview = document.getElementById('course-preview');
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

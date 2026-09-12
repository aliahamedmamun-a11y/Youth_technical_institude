@props(['course' => null, 'action', 'method' => 'POST', 'submitLabel'])

@php
    $inputClass = 'w-full rounded-lg border border-white/10 bg-[#071c2c]/50 py-3 px-4 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all';
    $labelClass = 'flex items-center gap-2 text-sm font-black text-[#4da6ff] mb-2';
    $iconClass = 'size-4 text-[#ff4d94]';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
    class="mx-auto max-w-3xl rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <h2 class="mb-10 text-center text-3xl font-black tracking-tight text-[#4da6ff]">
        {{ $course ? 'Edit Course' : 'Add New Course' }}
    </h2>

    <div class="space-y-6">
        {{-- Course ID --}}
        <div>
            <label class="{{ $labelClass }}">
                <svg viewBox="0 0 24 24" class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                Course ID
            </label>
            <input name="course_id" value="{{ old('course_id', $course?->course_id) }}"
                placeholder="e.g., CS101" class="{{ $inputClass }}">
            @error('course_id') <span class="mt-1 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        {{-- Course Name --}}
        <div>
            <label class="{{ $labelClass }}">
                <svg viewBox="0 0 24 24" class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Course Name
            </label>
            <input name="name" value="{{ old('name', $course?->name) }}"
                placeholder="e.g., Introduction to Computer Science" class="{{ $inputClass }}">
            @error('name') <span class="mt-1 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        {{-- Description --}}
        <div>
            <label class="{{ $labelClass }}">
                <svg viewBox="0 0 24 24" class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                Description
            </label>
            <textarea name="description" rows="4"
                placeholder="Provide a brief description of the course."
                class="{{ $inputClass }} resize-none">{{ old('description', $course?->description) }}</textarea>
            @error('description') <span class="mt-1 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        {{-- Price --}}
        <div>
            <label class="{{ $labelClass }}">
                <span class="text-[#ff4d94] font-black">$</span>
                Price
            </label>
            <input type="number" step="0.01" name="price" value="{{ old('price', $course?->price) }}"
                placeholder="e.g., 49.99" class="{{ $inputClass }}">
            @error('price') <span class="mt-1 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        {{-- Duration (Optional but kept as part of previous schema) --}}
        <div>
            <label class="{{ $labelClass }}">
                <svg viewBox="0 0 24 24" class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Duration
            </label>
            <input name="duration" value="{{ old('duration', $course?->duration) }}"
                placeholder="e.g., 6 Months" class="{{ $inputClass }}">
            @error('duration') <span class="mt-1 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        {{-- Course Image --}}
        <div>
            <label class="{{ $labelClass }}">
                <svg viewBox="0 0 24 24" class="{{ $iconClass }}" fill="none" stroke="currentColor" stroke-width="2.5">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                Course Image
            </label>

            <div class="rounded-xl bg-[#071c2c]/80 p-6 text-center border border-white/10">
                <h3 class="mb-6 text-2xl font-black text-[#4da6ff]">Upload Photo</h3>

                <div class="flex flex-col items-center gap-6">
                    <div class="flex items-center gap-4">
                        <label class="cursor-pointer rounded-full bg-blue-600 px-6 py-2 text-xs font-black text-white transition hover:bg-blue-500">
                            Choose File
                            <input type="file" name="image" class="hidden" onchange="updateFileName(this)">
                        </label>
                        <span id="file-name" class="text-xs font-bold text-slate-400">No file chosen</span>
                    </div>

                    <button type="button" class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#4338ca] py-3 text-sm font-black text-white transition hover:bg-[#4f46e5]">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Upload Photo
                    </button>
                </div>

                @if($course?->image_path)
                    <div class="mt-4">
                        <img src="{{ Storage::disk('public')->url($course->image_path) }}" class="mx-auto h-32 rounded-lg object-cover">
                    </div>
                @endif
            </div>
            @error('image') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        {{-- Status Toggle --}}
        <div class="flex items-center gap-4 pt-4">
            <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $course?->is_active ?? true))
                    id="is_active" class="peer sr-only">
                <label for="is_active" class="size-4 cursor-pointer rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></label>
            </div>
            <label for="is_active" class="text-xs font-black uppercase tracking-widest text-white cursor-pointer">Course Active</label>
        </div>
    </div>

    <div class="mt-12">
        <button type="submit"
            class="w-full rounded-xl bg-blue-600 py-4 text-sm font-black text-white uppercase tracking-widest transition hover:bg-blue-500 active:scale-95 shadow-lg shadow-blue-600/20">
            {{ $course ? 'Update Course' : 'Add Course' }}
        </button>
    </div>
</form>

<script>
    function updateFileName(input) {
        const fileName = document.getElementById('file-name');
        if (input.files && input.files[0]) {
            fileName.textContent = input.files[0].name;
        } else {
            fileName.textContent = 'No file chosen';
        }
    }
</script>

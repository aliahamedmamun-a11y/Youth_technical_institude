@props(['teacher' => null, 'action', 'method' => 'POST', 'submitLabel'])

@php
    $inputClass = 'w-full rounded-2xl border border-white/10 bg-[#0f2d44] py-4 px-6 text-sm text-white placeholder-slate-500 shadow-2xl focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 focus:outline-none transition-all';
    $labelClass = 'block text-[11px] font-black uppercase tracking-widest text-[#6cb2eb] mb-2';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data"
    class="space-y-8 rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-2xl sm:p-10 ring-1 ring-white/10">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-8 md:grid-cols-2">
        @foreach (['name' => 'Full Name *', 'employee_number' => 'Employee/Staff ID *', 'email' => 'Email Address', 'phone' => 'Phone Number *', 'designation' => 'Job Designation *', 'department' => 'Assigned Department', 'qualification' => 'Education Qualification'] as $field => $label)
            <div>
                <label class="{{ $labelClass }}">{{ $label }}</label>
                <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" value="{{ old($field, $teacher?->{$field}) }}"
                    @required(in_array($field, ['name', 'employee_number', 'phone', 'designation']))
                    placeholder="Enter {{ strtolower($label) }}" class="{{ $inputClass }}">
                @error($field) <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
            </div>
        @endforeach

        <div>
            <label class="{{ $labelClass }}">Joining Date</label>
            <input type="date" name="joined_at" value="{{ old('joined_at', $teacher?->joined_at?->format('Y-m-d')) }}"
                class="{{ $inputClass }}">
        </div>

        <div class="md:col-span-2">
            <label class="{{ $labelClass }}">Professional Profile / Description</label>
            <textarea name="description" rows="4" maxlength="2000"
                placeholder="Add a short professional biography for the public teacher card..."
                class="{{ $inputClass }} resize-none">{{ old('description', $teacher?->description) }}</textarea>
            <p class="mt-2 text-[9px] font-bold text-slate-500 uppercase tracking-tight">Optional, up to 2,000 characters.</p>
            @error('description') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">Teacher Photo</label>
            <div class="relative group aspect-square size-40 rounded-2xl border-2 border-dashed border-white/10 bg-[#071c2c]/50 flex flex-col items-center justify-center p-4 transition-all hover:border-emerald-500/50 cursor-pointer overflow-hidden">
                @if ($teacher?->image_path)
                    <img id="teacher-preview" src="{{ Storage::disk('public')->url($teacher->image_path) }}"
                        class="absolute inset-0 h-full w-full object-cover opacity-60 group-hover:opacity-80 transition-all">
                @else
                    <img id="teacher-preview" src="#" class="absolute inset-0 h-full w-full object-cover hidden opacity-60 group-hover:opacity-80 transition-all">
                @endif

                <div class="relative z-10 flex flex-col items-center text-center">
                    <svg viewBox="0 0 24 24" class="size-8 text-emerald-500 mb-2" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                        <circle cx="12" cy="13" r="3" />
                    </svg>
                    <span class="text-[9px] font-black uppercase text-white">Upload Photo</span>
                </div>
                <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                    class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewTeacherImage(this)">
            </div>
            @error('image') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col justify-end">
            <label class="group relative flex cursor-pointer items-center gap-4 rounded-2xl border border-white/5 bg-[#071c2c]/50 p-6 transition hover:bg-[#071c2c]">
                <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300 peer-checked:bg-emerald-600">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $teacher?->is_active ?? true))
                        class="peer sr-only">
                    <div class="size-4 rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></div>
                </div>
                <div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-white">Active Status</p>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Currently teaching at the institute</p>
                </div>
            </label>
        </div>
    </div>

    <div class="flex flex-col justify-center gap-4 pt-6 sm:flex-row">
        <a href="{{ route('super-admin.teachers.index') }}"
            class="inline-flex min-h-[55px] items-center justify-center rounded-xl border border-white/10 bg-white/5 px-12 text-[12px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex min-h-[55px] items-center justify-center rounded-xl bg-emerald-600 px-12 text-[12px] font-black uppercase tracking-widest text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-500 active:scale-95">
            {{ $submitLabel }}
        </button>
    </div>
</form>

<script>
    function previewTeacherImage(input) {
        const preview = document.getElementById('teacher-preview');
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

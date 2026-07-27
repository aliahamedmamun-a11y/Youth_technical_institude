@props(['course' => null, 'action', 'method' => 'POST', 'submitLabel'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        <label class="grid gap-2 text-sm font-bold text-slate-700">
            Course name
            <input name="name" value="{{ old('name', $course?->name) }}" required maxlength="255" class="rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">
            @error('name') <span class="text-sm font-medium text-rose-600">{{ $message }}</span> @enderror
        </label>

        <label class="grid gap-2 text-sm font-bold text-slate-700">
            Course code
            <input name="code" value="{{ old('code', $course?->code) }}" required maxlength="50" class="rounded-xl border border-slate-300 px-4 py-3 uppercase outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">
            @error('code') <span class="text-sm font-medium text-rose-600">{{ $message }}</span> @enderror
        </label>

        <label class="grid gap-2 text-sm font-bold text-slate-700">
            Duration
            <input name="duration" value="{{ old('duration', $course?->duration) }}" required maxlength="100" placeholder="e.g. 6 Months" class="rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">
            @error('duration') <span class="text-sm font-medium text-rose-600">{{ $message }}</span> @enderror
        </label>

        <label class="flex items-center gap-3 self-end rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $course?->is_active ?? true)) class="size-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
            Available for enrolment
        </label>
    </div>

    <label class="grid gap-2 text-sm font-bold text-slate-700">
        Description <span class="font-medium text-slate-400">(optional)</span>
        <textarea name="description" rows="5" maxlength="5000" class="rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">{{ old('description', $course?->description) }}</textarea>
        @error('description') <span class="text-sm font-medium text-rose-600">{{ $message }}</span> @enderror
    </label>

    <label class="grid gap-2 text-sm font-bold text-slate-700">
        Course image <span class="font-medium text-slate-400">(JPG, PNG, or WebP, up to 2 MB)</span>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm font-medium file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">
        @error('image') <span class="text-sm font-medium text-rose-600">{{ $message }}</span> @enderror
        @if ($course?->image_path)
            <img src="{{ Storage::disk('public')->url($course->image_path) }}" alt="Current image for {{ $course->name }}" class="mt-2 h-32 w-52 rounded-xl object-cover">
        @endif
    </label>

    <div class="flex flex-wrap justify-end gap-3">
        <a href="{{ route('super-admin.courses.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-black text-slate-700 transition hover:border-slate-400">Cancel</a>
        <button type="submit" class="rounded-full bg-emerald-700 px-5 py-3 text-sm font-black text-white transition hover:bg-emerald-800">{{ $submitLabel }}</button>
    </div>
</form>

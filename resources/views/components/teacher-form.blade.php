@props(['teacher' => null, 'action', 'method' => 'POST', 'submitLabel'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid gap-6 md:grid-cols-2">
        @foreach (['name' => 'Teacher name', 'employee_number' => 'Employee number', 'email' => 'Email', 'phone' => 'Phone', 'designation' => 'Designation', 'department' => 'Department', 'qualification' => 'Qualification'] as $field => $label)
            <label class="grid gap-2 text-sm font-bold text-slate-700">
                {{ $label }}
                <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" value="{{ old($field, $teacher?->{$field}) }}" @required(in_array($field, ['name', 'employee_number', 'phone', 'designation'])) class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">
                @error($field)<span class="text-rose-600">{{ $message }}</span>@enderror
            </label>
        @endforeach

        <label class="grid gap-2 text-sm font-bold text-slate-700 md:col-span-2">
            Teacher description
            <textarea name="description" rows="4" maxlength="2000" placeholder="Add a short professional profile for the public teacher card" class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">{{ old('description', $teacher?->description) }}</textarea>
            <span class="text-xs font-medium text-slate-400">Optional, up to 2,000 characters.</span>
            @error('description')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>

        <label class="grid gap-2 text-sm font-bold text-slate-700">
            Joining date
            <input type="date" name="joined_at" value="{{ old('joined_at', $teacher?->joined_at?->format('Y-m-d')) }}" class="rounded-xl border border-slate-300 px-4 py-3">
        </label>
        <label class="flex items-center gap-3 self-end rounded-xl border border-slate-200 px-4 py-3 font-bold">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $teacher?->is_active ?? true)) class="size-5 text-emerald-600">
            Active teacher
        </label>
    </div>

    <label class="grid gap-2 text-sm font-bold text-slate-700">
        Teacher photo <span class="font-medium text-slate-400">(white background required; JPG, PNG, or WebP, up to 2 MB)</span>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">
        @error('image')<span class="text-rose-600">{{ $message }}</span>@enderror
        @if ($teacher?->image_path)
            <img src="{{ Storage::disk('public')->url($teacher->image_path) }}" alt="Current photo for {{ $teacher->name }}" class="mt-2 size-28 rounded-xl object-cover">
        @endif
    </label>

    <div class="flex justify-end gap-3">
        <a href="{{ route('super-admin.teachers.index') }}" class="rounded-full border border-slate-300 px-5 py-3 font-black">Cancel</a>
        <button class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white">{{ $submitLabel }}</button>
    </div>
</form>

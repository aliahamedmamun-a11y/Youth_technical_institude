@props(['course', 'semester' => null, 'action', 'method' => 'POST'])
@php($inputClass = 'w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm')
<form method="POST" action="{{ $action }}" class="grid gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:grid-cols-3">
    @csrf @if ($method !== 'POST') @method($method) @endif
    <input type="hidden" name="course_id" value="{{ $course->id }}">
    <label class="grid gap-2 text-sm font-bold text-slate-700 sm:col-span-2">Semester name<input name="name" required value="{{ old('name', $semester?->name) }}" class="{{ $inputClass }}">@error('name')<span class="text-rose-600">{{ $message }}</span>@enderror</label>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Order<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $semester?->sort_order ?? 0) }}" class="{{ $inputClass }}"></label>
    <label class="flex items-center gap-2 text-sm font-bold text-slate-700"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $semester?->is_active ?? true))> Active semester</label>
    <div class="flex gap-3 sm:col-span-3"><a href="{{ route('super-admin.courses.semesters.index', $course) }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Cancel</a><button class="rounded-full bg-blue-600 px-5 py-3 font-black text-white">Save semester</button></div>
</form>

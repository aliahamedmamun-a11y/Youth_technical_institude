@props(['semester', 'subject' => null, 'action', 'method' => 'POST'])
@php($inputClass = 'w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm')
<form method="POST" action="{{ $action }}" class="grid gap-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:grid-cols-2">
    @csrf @if ($method !== 'POST') @method($method) @endif
    <input type="hidden" name="semester_id" value="{{ $semester->id }}">
    <label class="grid gap-2 text-sm font-bold text-slate-700">Subject code<input name="code" required value="{{ old('code', $subject?->code) }}" class="{{ $inputClass }}">@error('code')<span class="text-rose-600">{{ $message }}</span>@enderror</label>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Subject title<input name="title" required value="{{ old('title', $subject?->title) }}" class="{{ $inputClass }}">@error('title')<span class="text-rose-600">{{ $message }}</span>@enderror</label>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Credit<input type="number" name="credit" required min="0.5" max="20" step="0.5" value="{{ old('credit', $subject?->credit) }}" class="{{ $inputClass }}"></label>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Order<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $subject?->sort_order ?? 0) }}" class="{{ $inputClass }}"></label>
    <label class="flex items-center gap-2 text-sm font-bold text-slate-700"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $subject?->is_active ?? true))> Active subject</label>
    <div class="flex gap-3 sm:col-span-2"><a href="{{ route('super-admin.semesters.subjects.index', $semester) }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Cancel</a><button class="rounded-full bg-blue-600 px-5 py-3 font-black text-white">Save subject</button></div>
</form>

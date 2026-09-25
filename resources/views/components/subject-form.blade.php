@props(['semester', 'subject' => null, 'action', 'method' => 'POST'])

@php
    $inputClass = 'w-full rounded-2xl border border-white/10 bg-[#0f2d44] py-4 px-6 text-sm text-white placeholder-slate-500 shadow-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all';
    $labelClass = 'block text-[11px] font-black uppercase tracking-widest text-[#6cb2eb] mb-2';
@endphp

<form method="POST" action="{{ $action }}"
    class="space-y-8 rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-2xl sm:p-10 ring-1 ring-white/10">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <input type="hidden" name="semester_id" value="{{ $semester->id }}">

    <div class="grid gap-8 md:grid-cols-2">
        <div>
            <label class="{{ $labelClass }}">Subject Code *</label>
            <input name="code" value="{{ old('code', $subject?->code) }}" required maxlength="20"
                placeholder="e.g. COMP-101" class="{{ $inputClass }} font-mono tracking-widest uppercase">
            @error('code') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">Subject Title *</label>
            <input name="title" value="{{ old('title', $subject?->title) }}" required maxlength="255"
                placeholder="e.g. Introduction to Programming" class="{{ $inputClass }}">
            @error('title') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="{{ $labelClass }}">Credit Weightage *</label>
            <input type="number" name="credit" required min="0.5" max="20" step="0.5"
                value="{{ old('credit', $subject?->credit) }}" class="{{ $inputClass }}">
        </div>

        <div>
            <label class="{{ $labelClass }}">Display Sort Order</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $subject?->sort_order ?? 0) }}"
                class="{{ $inputClass }}">
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-6 border-t border-white/5 pt-8">
        <label class="group relative flex cursor-pointer items-center gap-4 rounded-2xl border border-white/5 bg-[#071c2c]/50 px-8 py-5 transition hover:bg-[#071c2c]">
            <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300 peer-checked:bg-emerald-600">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $subject?->is_active ?? true))
                    class="peer sr-only">
                <div class="size-4 rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></div>
            </div>
            <div>
                <p class="text-[11px] font-black uppercase tracking-widest text-white">Active Status</p>
                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Enable this subject for examinations</p>
            </div>
        </label>

        <div class="flex items-center gap-4 w-full md:w-auto">
            <a href="{{ route('super-admin.semesters.subjects.index', $semester) }}"
                class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl border border-white/10 bg-white/5 px-10 text-[12px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
                Cancel
            </a>
            <button type="submit"
                class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl bg-blue-600 px-10 text-[12px] font-black uppercase tracking-widest text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-500 active:scale-95">
                Save Subject
            </button>
        </div>
    </div>
</form>

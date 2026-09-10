@props(['notice', 'action', 'method' => 'POST', 'submitLabel'])

@php
    $inputClass = 'w-full rounded-2xl border border-white/10 bg-[#0f2d44] py-4 px-6 text-sm text-white placeholder-slate-500 shadow-2xl focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 focus:outline-none transition-all';
    $labelClass = 'block text-[11px] font-black uppercase tracking-widest text-[#6cb2eb] mb-2';
@endphp

<form method="POST" action="{{ $action }}"
    class="space-y-8 rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 p-6 shadow-2xl backdrop-blur-2xl sm:p-10 ring-1 ring-white/10">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label class="{{ $labelClass }}">Notice Title *</label>
        <input name="title" value="{{ old('title', $notice->title) }}" required maxlength="255"
            placeholder="e.g. Admission for July 2026 Session" class="{{ $inputClass }}">
        @error('title') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="{{ $labelClass }}">Announcement Message *</label>
        <textarea name="message" rows="5" required maxlength="1000"
            placeholder="Write the detailed notice content here..."
            class="{{ $inputClass }} resize-none">{{ old('message', $notice->message) }}</textarea>
        @error('message') <span class="mt-2 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="{{ $labelClass }}">External Link / URL (Optional)</label>
        <input type="url" name="link" value="{{ old('link', $notice->link) }}"
            placeholder="https://example.com/more-info" class="{{ $inputClass }}">
        <p class="mt-2 text-[9px] font-bold text-slate-500 uppercase tracking-tight">Add a link if this notice points to a specific document or page.</p>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-6 border-t border-white/5 pt-8">
        <label class="group relative flex cursor-pointer items-center gap-4 rounded-2xl border border-white/5 bg-[#071c2c]/50 px-8 py-5 transition hover:bg-[#071c2c]">
            <div class="flex h-6 w-11 shrink-0 items-center rounded-full bg-slate-700 p-1 transition duration-300 peer-checked:bg-amber-500">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $notice->is_published))
                    class="peer sr-only">
                <div class="size-4 rounded-full bg-white shadow-sm transition duration-300 peer-checked:translate-x-5"></div>
            </div>
            <div>
                <p class="text-[11px] font-black uppercase tracking-widest text-white">Publish Notice</p>
                <p class="text-[9px] font-bold text-slate-500 uppercase tracking-tight">Make this announcement visible on the website</p>
            </div>
        </label>

        <div class="flex items-center gap-4 w-full md:w-auto">
            <a href="{{ route('super-admin.notices.index') }}"
                class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl border border-white/10 bg-white/5 px-10 text-[12px] font-black uppercase tracking-widest text-slate-300 transition hover:bg-white/10">
                Cancel
            </a>
            <button type="submit"
                class="flex-1 inline-flex min-h-[55px] items-center justify-center rounded-xl bg-amber-500 px-10 text-[12px] font-black uppercase tracking-widest text-[#03224c] shadow-lg shadow-amber-600/20 transition hover:bg-amber-400 active:scale-95">
                {{ $submitLabel }}
            </button>
        </div>
    </div>
</form>

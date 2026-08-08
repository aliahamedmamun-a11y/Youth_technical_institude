@props(['notice', 'action', 'method' => 'POST', 'submitLabel'])

<form method="POST" action="{{ $action }}" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <label class="block font-bold text-slate-700">Title<input name="title" value="{{ old('title', $notice->title) }}" required maxlength="255" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label>
    <label class="block font-bold text-slate-700">Message<textarea name="message" rows="4" required maxlength="1000" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3">{{ old('message', $notice->message) }}</textarea></label>
    <label class="block font-bold text-slate-700">Optional link<input type="url" name="link" value="{{ old('link', $notice->link) }}" placeholder="https://example.com" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label>
    <label class="flex items-center gap-3 font-bold text-slate-700"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $notice->is_published))> Publish notice</label>
    <button class="rounded-full bg-emerald-700 px-6 py-3 font-black text-white">{{ $submitLabel }}</button>
</form>

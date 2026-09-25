@props(['item', 'section', 'action', 'method' => 'POST', 'submitLabel'])
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf @if($method !== 'POST') @method($method) @endif
    <input type="hidden" name="section" value="{{ $section->key }}">
    <label class="block font-bold text-slate-700">Stable key<input name="stable_key" value="{{ old('stable_key', $item->stable_key) }}" required maxlength="100" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label>
    <label class="block font-bold text-slate-700">Title<input name="title" value="{{ old('title', $item->title) }}" maxlength="255" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label>
    <label class="block font-bold text-slate-700">Subtitle<input name="subtitle" value="{{ old('subtitle', $item->subtitle) }}" maxlength="255" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label>
    <label class="block font-bold text-slate-700">Body<textarea name="body" rows="6" maxlength="5000" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3">{{ old('body', $item->body) }}</textarea></label>
    <div class="grid gap-5 sm:grid-cols-2"><label class="block font-bold text-slate-700">Icon<input name="icon" value="{{ old('icon', $item->icon) }}" maxlength="100" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label><label class="block font-bold text-slate-700">Sort order<input type="number" name="sort_order" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}" required class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label></div>
    <div class="grid gap-5 sm:grid-cols-2"><label class="block font-bold text-slate-700">Link label<input name="link_label" value="{{ old('link_label', $item->link_label) }}" maxlength="100" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label><label class="block font-bold text-slate-700">Link URL<input name="link_url" value="{{ old('link_url', $item->link_url) }}" maxlength="2048" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label></div>
    <label class="block font-bold text-slate-700">Image <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="mt-2 block rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm"></label>
    @if($item->image_path)<img src="{{ str_starts_with($item->image_path, 'images/') ? asset($item->image_path) : Storage::disk('public')->url($item->image_path) }}" alt="Current image" class="size-28 rounded-xl object-cover">@endif
    <label class="flex items-center gap-3 font-bold text-slate-700"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item->is_published))> Published</label>
    <button class="rounded-full bg-emerald-700 px-6 py-3 font-black text-white">{{ $submitLabel }}</button>
</form>

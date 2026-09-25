@props(['news', 'action', 'method' => 'POST', 'submitLabel'])
<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
    @csrf @if($method !== 'POST') @method($method) @endif
    <label class="block font-bold text-slate-700">Title<input name="title" value="{{ old('title', $news->title) }}" required class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3"></label>
    <label class="block font-bold text-slate-700">Excerpt<textarea name="excerpt" rows="2" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3">{{ old('excerpt', $news->excerpt) }}</textarea></label>
    <label class="block font-bold text-slate-700">Content<textarea name="content" rows="10" required class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3">{{ old('content', $news->content) }}</textarea></label>
    <label class="block font-bold text-slate-700">Featured image <span class="text-xs font-medium text-slate-400">(JPG, PNG, or WebP up to 25 MB)</span><input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="mt-2 block rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm"></label>
    @if($news->image_path)<div><p class="text-sm font-bold text-slate-700">Current image</p><img src="{{ Storage::disk('public')->url($news->image_path) }}" alt="Current image for {{ $news->title }}" class="mt-2 h-32 w-48 rounded-xl object-cover"></div>@endif
    <label class="flex items-center gap-3 font-bold text-slate-700"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $news->is_published))> Publish now</label>
    <button class="rounded-full bg-emerald-700 px-6 py-3 font-black text-white">{{ $submitLabel }}</button>
</form>

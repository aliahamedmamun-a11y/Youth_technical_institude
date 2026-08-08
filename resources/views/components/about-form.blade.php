@props(['about', 'action', 'method' => 'POST', 'submitLabel'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="max-w-4xl space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div class="grid gap-6 sm:grid-cols-2">
        <label class="grid gap-2 text-sm font-bold text-slate-700 sm:col-span-2">Heading
            <input name="about_heading" value="{{ old('about_heading', $about->about_heading) }}" required maxlength="255" class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
            @error('about_heading')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700 sm:col-span-2">URL slug <span class="font-medium text-slate-400">(optional)</span>
            <input name="slug" value="{{ old('slug', $about->slug) }}" maxlength="255" placeholder="Generated from heading if empty" class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
            @error('slug')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700 sm:col-span-2">Summary
            <textarea name="summary" rows="3" required maxlength="500" class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-4 focus:ring-blue-100">{{ old('summary', $about->summary) }}</textarea>
            @error('summary')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700 sm:col-span-2">Full content
            <textarea name="content" rows="10" required maxlength="10000" class="rounded-xl border border-slate-300 px-4 py-3 leading-6 focus:border-blue-600 focus:ring-4 focus:ring-blue-100">{{ old('content', $about->content) }}</textarea>
            <span class="text-xs font-medium text-slate-400">Use blank lines to separate paragraphs.</span>
            @error('content')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Principal name
            <input name="principal_name" value="{{ old('principal_name', $about->principal_name) }}" maxlength="255" class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Principal title
            <input name="principal_title" value="{{ old('principal_title', $about->principal_title) }}" maxlength="255" class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Display order
            <input type="number" name="sort_order" value="{{ old('sort_order', $about->sort_order ?? 0) }}" min="0" required class="rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Entry image <span class="font-medium text-slate-400">(up to 5 MB)</span>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">
            @error('image')<span class="text-rose-600">{{ $message }}</span>@enderror
            @if ($about->image_path)
                <img src="{{ Storage::disk('public')->url($about->image_path) }}" alt="Current About entry image" class="mt-2 size-24 rounded-xl object-cover">
            @endif
        </label>
    </div>
    <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700">
        <input type="hidden" name="is_published" value="0">
        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $about->is_published ?? true)) class="size-5 text-blue-600">
        Published on the homepage
    </label>
    <div class="flex justify-end gap-3">
        <a href="{{ route('super-admin.about.index') }}" class="rounded-full border border-slate-300 px-5 py-3 font-black">Cancel</a>
        <button class="rounded-full bg-blue-600 px-6 py-3 font-black text-white">{{ $submitLabel }}</button>
    </div>
</form>

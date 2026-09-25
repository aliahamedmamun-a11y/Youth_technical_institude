<x-dashboard-shell title="Institute Profile" eyebrow="Website content" description="Update the About Us section and principal information shown on the public homepage.">
    @if (session('status'))
        <div class="mb-6 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('super-admin.institute-profile.update') }}" enctype="multipart/form-data" class="max-w-4xl space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
        @csrf
        @method('PUT')

        <div class="grid gap-6 sm:grid-cols-2">
            <label class="grid gap-2 text-sm font-bold text-slate-700 sm:col-span-2">
                About heading
                <input name="about_heading" value="{{ old('about_heading', $profile->about_heading) }}" required maxlength="255" class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                @error('about_heading')<span class="text-rose-600">{{ $message }}</span>@enderror
            </label>

            <label class="grid gap-2 text-sm font-bold text-slate-700 sm:col-span-2">
                About content
                <textarea name="content" rows="10" required maxlength="10000" placeholder="Separate paragraphs with a blank line" class="rounded-xl border border-slate-300 px-4 py-3 leading-6 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100">{{ old('content', $profile->content) }}</textarea>
                <span class="text-xs font-medium text-slate-400">Use a blank line between paragraphs.</span>
                @error('content')<span class="text-rose-600">{{ $message }}</span>@enderror
            </label>

            <label class="grid gap-2 text-sm font-bold text-slate-700">
                Principal name
                <input name="principal_name" value="{{ old('principal_name', $profile->principal_name) }}" required maxlength="255" class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                @error('principal_name')<span class="text-rose-600">{{ $message }}</span>@enderror
            </label>
            <label class="grid gap-2 text-sm font-bold text-slate-700">
                Principal title
                <input name="principal_title" value="{{ old('principal_title', $profile->principal_title) }}" required maxlength="255" class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100">
                @error('principal_title')<span class="text-rose-600">{{ $message }}</span>@enderror
            </label>
        </div>

        <label class="grid gap-2 text-sm font-bold text-slate-700">
            Principal image <span class="font-medium text-slate-400">(JPG, PNG, or WebP, up to 5 MB)</span>
            <input type="file" name="principal_image" accept="image/jpeg,image/png,image/webp" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">
            @error('principal_image')<span class="text-rose-600">{{ $message }}</span>@enderror
            @if ($profile->principal_image_path)
                <img src="{{ str_starts_with($profile->principal_image_path, 'images/') ? asset($profile->principal_image_path) : Storage::disk('public')->url($profile->principal_image_path) }}" alt="Current principal portrait" class="mt-2 size-28 rounded-xl object-cover">
            @endif
        </label>

        <label class="flex items-center gap-3 rounded-xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $profile->is_active ?? true)) class="size-5 text-blue-600">
            Show this profile on the homepage
        </label>

        <div class="flex justify-end">
            <button class="rounded-full bg-blue-600 px-6 py-3 font-black text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700">Save profile</button>
        </div>
    </form>
</x-dashboard-shell>

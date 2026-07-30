<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Branch Register | BNYTI</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6">
            <a href="{{ url('/') }}" class="text-sm font-black text-blue-700">← Back to BNYTI</a>
            <section class="mt-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-xl shadow-slate-900/5 sm:p-10">
                <p class="text-sm font-black uppercase tracking-[.16em] text-blue-600">Branch registration</p>
                <h1 class="mt-3 text-3xl font-black">Register your institute branch</h1>
                <p class="mt-3 text-slate-600">Submit the director and institute details for Super Admin review.</p>
                @if (session('status'))<div class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 font-bold text-emerald-800">{{ session('status') }}</div>@endif
                <form method="POST" action="{{ route('branch-applications.store') }}" enctype="multipart/form-data" data-location-form data-branch-location-form data-upazilas='@json(config("bangladesh.upazilas"))' data-old-upazila="{{ old('upazila') }}" data-old-post-office="{{ old('post_office') }}" class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2">
                    @csrf
                    @foreach (['director_name' => 'Director name', 'father_name' => "Father's name", 'mother_name' => "Mother's name", 'institute_name' => 'Institute name', 'district' => 'District', 'upazila' => 'Upazila', 'post_office' => 'Post office', 'email' => 'E-mail', 'username' => 'Username', 'mobile_number' => 'Mobile number'] as $field => $label)
                        <label class="grid gap-2 text-sm font-bold">{{ $label }}@if ($field === 'district')<select name="district" data-district-select required class="rounded-xl border border-slate-300 bg-white px-4 py-3"><option value="">Select district</option>@foreach (config('bangladesh.districts') as $district)<option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>@endforeach</select>@elseif ($field === 'upazila')<select name="upazila" data-upazila-select required disabled class="rounded-xl border border-slate-300 bg-white px-4 py-3"><option value="">Select district first</option></select>@elseif ($field === 'post_office')<select name="post_office" data-post-office-select required disabled class="rounded-xl border border-slate-300 bg-white px-4 py-3"><option value="">Select upazila first</option></select>@else<input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" value="{{ old($field) }}" required class="rounded-xl border border-slate-300 px-4 py-3">@endif @error($field)<span class="text-rose-600">{{ $message }}</span>@enderror</label>
                    @endforeach
                    <label class="grid gap-2 text-sm font-bold">Sex<select name="sex" required class="rounded-xl border border-slate-300 px-4 py-3"><option value="">Select sex</option>@foreach(['Male','Female','Other'] as $sex)<option value="{{ $sex }}" @selected(old('sex') === $sex)>{{ $sex }}</option>@endforeach</select></label>
                    <label class="grid gap-2 text-sm font-bold">Password<input type="password" name="password" required minlength="8" class="rounded-xl border border-slate-300 px-4 py-3">@error('password')<span class="text-rose-600">{{ $message }}</span>@enderror</label>
                    <label class="grid gap-2 text-sm font-bold">Confirm password<input type="password" name="password_confirmation" required minlength="8" class="rounded-xl border border-slate-300 px-4 py-3"></label>
                    @foreach(['director_signature' => 'Director signature', 'nid_photo' => 'NID photo', 'director_photo' => 'Director photo'] as $field => $label)
                        <label class="grid gap-2 text-sm font-bold">{{ $label }}<input type="file" name="{{ $field }}" required accept="image/jpeg,image/png,image/webp" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">@error($field)<span class="text-rose-600">{{ $message }}</span>@enderror</label>
                    @endforeach
                    <label class="grid gap-2 text-sm font-bold md:col-span-2 lg:col-span-2">Full address<textarea name="full_address" rows="3" required class="rounded-xl border border-slate-300 px-4 py-3">{{ old('full_address') }}</textarea></label>
                    <div class="md:col-span-2 lg:col-span-2"><button class="rounded-full bg-blue-600 px-6 py-3 font-black text-white">Submit branch registration</button></div>
                </form>
            </section>
        </main>
    </body>
</html>

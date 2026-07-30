@props(['student' => null, 'courses', 'action', 'method' => 'POST', 'submitLabel', 'cancelRoute' => null])

@php
    $inputClass = 'rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100';
    $selectClass = $inputClass.' bg-white';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-location-form data-upazilas='@json(config("bangladesh.upazilas"))' data-old-upazila="{{ old('upazila', $student?->upazila) }}" class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div class="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
        @foreach (['name' => 'Name', 'father_name' => "Father's name", 'mother_name' => "Mother's name", 'passport_nid_number' => 'Passport / NID number', 'phone' => 'Phone number', 'education_qualification' => 'Education qualification', 'duration' => 'Duration', 'session' => 'Session'] as $field => $label)
            <label class="grid gap-2 text-sm font-bold text-slate-700">{{ $label }}
                <input name="{{ $field }}" value="{{ old($field, $student?->{$field}) }}" required class="{{ $inputClass }}">
                @error($field)<span class="text-rose-600">{{ $message }}</span>@enderror
            </label>
        @endforeach

        <label class="grid gap-2 text-sm font-bold text-slate-700">District
            <select name="district" data-district-select required class="{{ $selectClass }}"><option value="">Select district</option>@foreach (config('bangladesh.districts') as $district)<option value="{{ $district }}" @selected(old('district', $student?->district) === $district)>{{ $district }}</option>@endforeach</select>
            @error('district')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Upazila
            <select name="upazila" data-upazila-select required disabled class="{{ $selectClass }}"><option value="">Select district first</option></select>
            @error('upazila')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Date of birth
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student?->date_of_birth?->format('Y-m-d')) }}" required class="{{ $inputClass }}">
            @error('date_of_birth')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Course name
            <select name="course_id" required class="{{ $selectClass }}"><option value="">Select a course</option>@foreach ($courses as $course)<option value="{{ $course->id }}" @selected(old('course_id', $student?->course_id) == $course->id)>{{ $course->name }} ({{ $course->code }})</option>@endforeach</select>
            @error('course_id')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Sex
            <select name="gender" required class="{{ $selectClass }}"><option value="">Select sex</option>@foreach (['Male', 'Female', 'Other'] as $sex)<option value="{{ $sex }}" @selected(old('gender', $student?->gender) === $sex)>{{ $sex }}</option>@endforeach</select>
            @error('gender')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Join date
            <input type="date" name="admitted_at" required value="{{ old('admitted_at', $student?->admitted_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="{{ $inputClass }}">
            @error('admitted_at')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Expire date
            <input type="date" name="expire_date" required value="{{ old('expire_date', $student?->expire_date?->format('Y-m-d')) }}" class="{{ $inputClass }}">
            @error('expire_date')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
    </div>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Full address<textarea name="address" rows="3" required class="{{ $inputClass }}">{{ old('address', $student?->address) }}</textarea>@error('address')<span class="text-rose-600">{{ $message }}</span>@enderror</label>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Photo <span class="font-medium text-slate-400">(JPG, PNG, or WebP, up to 2 MB)</span><input type="file" name="image" accept="image/jpeg,image/png,image/webp" @required(! $student?->image_path) class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">@error('image')<span class="text-rose-600">{{ $message }}</span>@enderror @if($student?->image_path)<img src="{{ Storage::disk('public')->url($student->image_path) }}" alt="Current photo for {{ $student->name }}" class="mt-2 size-28 rounded-xl object-cover">@endif</label>
    <div class="flex justify-end gap-3"><a href="{{ $cancelRoute ?? route('super-admin.students.index') }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Cancel</a><button class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white">{{ $submitLabel }}</button></div>
</form>

@props(['student' => null, 'courses', 'action', 'method' => 'POST', 'submitLabel'])

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div class="grid gap-6 md:grid-cols-2">
        @foreach (['name' => 'Student name', 'registration_number' => 'Registration number', 'roll_number' => 'Roll number', 'father_name' => "Father's name", 'mother_name' => "Mother's name", 'phone' => 'Phone number', 'email' => 'Email address'] as $field => $label)
            <label class="grid gap-2 text-sm font-bold text-slate-700">{{ $label }}
                <input type="{{ $field === 'email' ? 'email' : 'text' }}" name="{{ $field }}" value="{{ old($field, $student?->{$field}) }}" @required(in_array($field, ['name', 'registration_number', 'phone'])) class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100">
                @error($field)<span class="text-rose-600">{{ $message }}</span>@enderror
            </label>
        @endforeach
        <label class="grid gap-2 text-sm font-bold text-slate-700">Course
            <select name="course_id" required class="rounded-xl border border-slate-300 px-4 py-3 outline-none focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100"><option value="">Select a course</option>@foreach ($courses as $course)<option value="{{ $course->id }}" @selected(old('course_id', $student?->course_id) == $course->id)>{{ $course->name }} ({{ $course->code }})</option>@endforeach</select>
            @error('course_id')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Gender
            <select name="gender" class="rounded-xl border border-slate-300 px-4 py-3"><option value="">Not specified</option>@foreach (['Male', 'Female', 'Other'] as $gender)<option value="{{ $gender }}" @selected(old('gender', $student?->gender) === $gender)>{{ $gender }}</option>@endforeach</select>
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Date of birth<input type="date" name="date_of_birth" value="{{ old('date_of_birth', $student?->date_of_birth?->format('Y-m-d')) }}" class="rounded-xl border border-slate-300 px-4 py-3"></label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Admission date<input type="date" name="admitted_at" required value="{{ old('admitted_at', $student?->admitted_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="rounded-xl border border-slate-300 px-4 py-3"></label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Result status<select name="result_status" required class="rounded-xl border border-slate-300 px-4 py-3">@foreach (['Pending', 'Passed', 'Failed'] as $status)<option value="{{ $status }}" @selected(old('result_status', $student?->result_status ?? 'Pending') === $status)>{{ $status }}</option>@endforeach</select></label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Grade<input name="grade" maxlength="10" value="{{ old('grade', $student?->grade) }}" class="rounded-xl border border-slate-300 px-4 py-3"></label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">Score (%)<input type="number" name="score" min="0" max="100" step="0.01" value="{{ old('score', $student?->score) }}" class="rounded-xl border border-slate-300 px-4 py-3"></label>
    </div>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Address<textarea name="address" rows="3" class="rounded-xl border border-slate-300 px-4 py-3">{{ old('address', $student?->address) }}</textarea></label>
    <label class="grid gap-2 text-sm font-bold text-slate-700">Student photo <span class="font-medium text-slate-400">(JPG, PNG, or WebP, up to 2 MB)</span><input type="file" name="image" accept="image/jpeg,image/png,image/webp" class="rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:font-bold file:text-blue-700">@error('image')<span class="text-rose-600">{{ $message }}</span>@enderror @if($student?->image_path)<img src="{{ Storage::disk('public')->url($student->image_path) }}" alt="Current photo for {{ $student->name }}" class="mt-2 size-28 rounded-xl object-cover">@endif</label>
    <div class="flex justify-end gap-3"><a href="{{ route('super-admin.students.index') }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Cancel</a><button class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white">{{ $submitLabel }}</button></div>
</form>

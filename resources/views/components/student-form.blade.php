@props([
    'student' => null,
    'courses',
    'action',
    'method' => 'POST',
    'submitLabel',
    'cancelRoute' => null,
    'declarationRequired' => false,
])

@php
    $inputClass = 'w-full rounded-lg border border-white/10 bg-[#071c2c]/50 py-3 px-4 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all';
    $selectClass = $inputClass . ' appearance-none cursor-pointer';
    $labelClass = 'block text-sm font-bold text-slate-400 mb-2';
@endphp

<div class="space-y-6" data-student-registration-container>
    {{-- Main Form Section --}}
    <div class="mx-auto max-w-4xl rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
        <h2 class="mb-10 text-center text-3xl font-black tracking-tight text-[#4da6ff] uppercase">
            {{ $student ? 'Edit Student Information' : 'Student Registration' }}
        </h2>

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-location-form
            data-upazilas='@json(config('bangladesh.upazilas'))' data-old-upazila="{{ old('upazila', $student?->upazila) }}"
            class="space-y-8" id="registration-form">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif

            {{-- Avatar / Photo --}}
            <div class="flex flex-col items-center gap-6">
                <div class="relative group">
                    <div class="size-40 overflow-hidden rounded-full bg-[#03224c] ring-4 ring-white/10 shadow-2xl">
                        <img id="photo-preview" src="{{ $student?->image_path ? Storage::disk('public')->url($student->image_path) : asset('images/placeholder-avatar.png') }}"
                            class="size-full object-cover">
                    </div>
                    <input type="file" name="image" id="student-photo-input" class="hidden" onchange="previewStudentPhoto(this)">
                </div>
                <button type="button" onclick="document.getElementById('student-photo-input').click()"
                    class="rounded-xl bg-[#4338ca] px-8 py-2.5 text-sm font-black text-white transition hover:bg-[#4f46e5] shadow-lg shadow-indigo-900/40">
                    Change Image
                </button>
                @error('image') <span class="text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
            </div>

            <div class="grid gap-x-10 gap-y-6 sm:grid-cols-2">
                {{-- Student Name --}}
                <div>
                    <label class="{{ $labelClass }}">Student Name</label>
                    <input name="name" id="field-name" value="{{ old('name', $student?->name) }}" placeholder="Enter student name" class="{{ $inputClass }}">
                </div>

                {{-- Father Name --}}
                <div>
                    <label class="{{ $labelClass }}">Father Name</label>
                    <input name="father_name" id="field-father-name" value="{{ old('father_name', $student?->father_name) }}" placeholder="Enter father's name" class="{{ $inputClass }}">
                </div>

                {{-- Mother Name --}}
                <div>
                    <label class="{{ $labelClass }}">Mother Name</label>
                    <input name="mother_name" id="field-mother-name" value="{{ old('mother_name', $student?->mother_name) }}" placeholder="Enter mother's name" class="{{ $inputClass }}">
                </div>

                {{-- Dob --}}
                <div>
                    <label class="{{ $labelClass }}">Dob</label>
                    <input type="date" name="date_of_birth" id="field-dob" value="{{ old('date_of_birth', $student?->date_of_birth?->format('Y-m-d')) }}" class="{{ $inputClass }}">
                </div>

                {{-- Gender --}}
                <div>
                    <label class="{{ $labelClass }}">Gender</label>
                    <select name="gender" id="field-gender" class="{{ $selectClass }}">
                        <option value="">Select Gender</option>
                        @foreach (['Male', 'Female', 'Other'] as $sex)
                            <option value="{{ $sex }}" @selected(old('gender', $student?->gender) === $sex)>{{ $sex }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Passport (ID Number) --}}
                <div>
                    <label class="{{ $labelClass }}">Passport</label>
                    <input name="passport_nid_number" id="field-doc-number" value="{{ old('passport_nid_number', $student?->passport_nid_number) }}" placeholder="Enter ID number" class="{{ $inputClass }}">
                </div>

                {{-- Guardian Phone --}}
                <div>
                    <label class="{{ $labelClass }}">Guardian Phone</label>
                    <input type="tel" name="phone" id="field-phone" value="{{ old('phone', $student?->phone) }}" placeholder="Enter phone number" class="{{ $inputClass }}">
                </div>

                {{-- Student Address --}}
                <div>
                    <label class="{{ $labelClass }}">Student Address</label>
                    <input name="address" id="field-address" value="{{ old('address', $student?->address) }}" placeholder="Enter address" class="{{ $inputClass }}">
                </div>

                {{-- District --}}
                <div>
                    <label class="{{ $labelClass }}">District</label>
                    <select name="district" id="field-district" data-district-select class="{{ $selectClass }}">
                        <option value="">Select district</option>
                        @foreach (config('bangladesh.districts') as $district)
                            <option value="{{ $district }}" @selected(old('district', $student?->district) === $district)>{{ $district }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Thana --}}
                <div>
                    <label class="{{ $labelClass }}">Thana</label>
                    <select name="upazila" id="field-upazila" data-upazila-select disabled class="{{ $selectClass }}">
                        <option value="">No upazilas found</option>
                    </select>
                </div>

                {{-- Search Course --}}
                <div>
                    <label class="{{ $labelClass }}">Search Course</label>
                    <select name="course_id" id="field-course" class="{{ $selectClass }}">
                        <option value="">Select course</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id', $student?->course_id) == $course->id)>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Duration --}}
                <div>
                    <label class="{{ $labelClass }}">Duration</label>
                    <select name="duration" id="field-duration" class="{{ $selectClass }}">
                        <option value="">Select duration</option>
                        <option value="3 Months" @selected(old('duration', $student?->duration) === '3 Months')>3 Months</option>
                        <option value="6 Months" @selected(old('duration', $student?->duration) === '6 Months')>6 Months</option>
                    </select>
                </div>

                {{-- Session --}}
                <div>
                    <label class="{{ $labelClass }}">Session</label>
                    <input name="session" value="{{ old('session', $student?->session) }}" placeholder="Enter session" class="{{ $inputClass }}">
                </div>

                {{-- Education Qualification --}}
                <div>
                    <label class="{{ $labelClass }}">Education Qualification</label>
                    <input name="education_qualification" value="{{ old('education_qualification', $student?->education_qualification) }}" placeholder="Enter qualification" class="{{ $inputClass }}">
                </div>
            </div>

            <div class="mt-12 flex justify-center">
                <button type="submit"
                    class="w-full sm:w-80 rounded-xl bg-blue-600 py-4 text-sm font-black text-white uppercase tracking-widest transition hover:bg-blue-500 active:scale-95 shadow-lg shadow-blue-600/20">
                    {{ $student ? 'Save Changes' : 'Complete Registration' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewStudentPhoto(input) {
        const preview = document.getElementById('photo-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

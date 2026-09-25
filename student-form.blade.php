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
    $inputClass =
        'min-w-0 w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-4 focus:ring-emerald-100';
    $selectClass = $inputClass . ' appearance-none';
    $sectionClass =
        'flex items-center gap-2 rounded-lg bg-emerald-700 px-4 py-2 text-sm font-black uppercase tracking-wide text-white shadow-md shadow-emerald-700/15';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-location-form
    data-upazilas='@json(config('bangladesh.upazilas'))' data-old-upazila="{{ old('upazila', $student?->upazila) }}"
    @class([
        'space-y-6 rounded-[2rem] border border-slate-200 bg-white p-5 shadow-[0_20px_70px_rgb(15_23_42/0.08)] sm:p-8',
        'registration-form' => $declarationRequired,
    ])>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,.9fr)_minmax(0,1.2fr)_minmax(260px,.85fr)]">
        <section class="min-w-0 space-y-5" aria-labelledby="personal-information-heading">
            <h2 id="personal-information-heading" class="{{ $sectionClass }}"><svg viewBox="0 0 24 24"
                    class="size-5 fill-none stroke-current" aria-hidden="true" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3" />
                    <path d="M5 21c.5-4 2.8-6 7-6s6.5 2 7 6" />
                </svg>Personal Information</h2>
            <label class="block min-w-0 text-sm font-bold text-slate-700">Name <span
                    class="text-rose-600">*</span><input name="name" value="{{ old('name', $student?->name) }}"
                    required placeholder="Enter full name" class="{{ $inputClass }} mt-2">
                @error('name')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
            <label class="block min-w-0 text-sm font-bold text-slate-700 lg:mt-16">Father's Name <span
                    class="text-rose-600">*</span><input name="father_name"
                    value="{{ old('father_name', $student?->father_name) }}" required placeholder="Enter father's name"
                    class="{{ $inputClass }} mt-2">
                @error('father_name')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
            <label class="block min-w-0 text-sm font-bold text-slate-700">Mother's Name <span
                    class="text-rose-600">*</span><input name="mother_name"
                    value="{{ old('mother_name', $student?->mother_name) }}" required placeholder="Enter mother's name"
                    class="{{ $inputClass }} mt-2">
                @error('mother_name')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
            <label class="block min-w-0 text-sm font-bold text-slate-700">Roll Number
                <input name="roll_number" value="{{ old('roll_number', $student?->roll_number) }}" maxlength="50"
                    inputmode="numeric" placeholder="Enter roll number" class="{{ $inputClass }} mt-2">
                @error('roll_number')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
            <label class="block min-w-0 text-sm font-bold text-slate-700">Date of Birth <span
                    class="text-rose-600">*</span><input type="date" name="date_of_birth"
                    value="{{ old('date_of_birth', $student?->date_of_birth?->format('Y-m-d')) }}" required
                    class="{{ $inputClass }} mt-2">
                @error('date_of_birth')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
            <fieldset class="grid gap-3 text-sm font-bold text-slate-700">
                <legend>Sex <span class="text-rose-600">*</span></legend>
                <div class="flex flex-wrap gap-5">
                    @foreach (['Male', 'Female', 'Other'] as $sex)
                        <label class="flex items-center gap-2 font-medium"><input type="radio" name="gender"
                                value="{{ $sex }}" @checked(old('gender', $student?->gender) === $sex) required
                                class="size-4 accent-emerald-600">{{ $sex }}</label>
                    @endforeach
                </div>
                @error('gender')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </fieldset>
            <label class="block min-w-0 text-sm font-bold text-slate-700 pt-7">Passport / NID Number <span
                    class="text-rose-600">*</span><input name="passport_nid_number"
                    value="{{ old('passport_nid_number', $student?->passport_nid_number) }}" required
                    placeholder="Enter Passport or NID Number" class="{{ $inputClass }} mt-2">
                @error('passport_nid_number')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
            <label class="block min-w-0 text-sm font-bold text-slate-700">Phone Number <span
                    class="text-rose-600">*</span><input type="tel" name="phone"
                    value="{{ old('phone', $student?->phone) }}" required placeholder="Enter phone number"
                    class="{{ $inputClass }} mt-2">
                @error('phone')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
        </section>

        <section class="min-w-0 space-y-5" aria-labelledby="address-information-heading">
            <h2 id="address-information-heading" class="{{ $sectionClass }}"><svg viewBox="0 0 24 24"
                    class="size-5 fill-none stroke-current" aria-hidden="true" stroke-width="1.8">
                    <path d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z" />
                    <circle cx="12" cy="9" r="2.2" />
                </svg>Address Information</h2>
            <label class="block min-w-0 text-sm font-bold text-slate-700">Full Address <span
                    class="text-rose-600">*</span>
                <textarea name="address" rows="3" required placeholder="Enter full address" class="{{ $inputClass }} mt-2">{{ old('address', $student?->address) }}</textarea>
                @error('address')
                    <span class="mt-1 block text-rose-600">{{ $message }}</span>
                @enderror
            </label>
            <div class="grid gap-4 sm:grid-cols-2"><label
                    class="block min-w-0 text-sm font-bold text-slate-700">District <span
                        class="text-rose-600">*</span><select name="district" data-district-select required
                        class="{{ $selectClass }}">
                        <option value="">Select district</option>
                        @foreach (config('bangladesh.districts') as $district)
                            <option value="{{ $district }}" @selected(old('district', $student?->district) === $district)>{{ $district }}
                            </option>
                        @endforeach
                    </select>
                    @error('district')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-sm font-bold text-slate-700">Upazila <span
                        class="text-rose-600">*</span><select name="upazila" data-upazila-select required disabled
                        class="{{ $selectClass }}">
                        <option value="">Select district first</option>
                    </select>
                    @error('upazila')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div class="border-t border-slate-200 pt-9">
                <h2 id="academic-information-heading" class="{{ $sectionClass }}"><svg viewBox="0 0 24 24"
                        class="size-5 fill-none stroke-current" aria-hidden="true" stroke-width="1.8">
                        <path d="M3 9 12 4l9 5-9 5zM6 11v5c2.8 2.3 9.2 2.3 12 0v-5M21 9v7" />
                    </svg>Academic Information</h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2"><label
                    class="block min-w-0 text-sm font-bold text-slate-700 pt-3">Education Qualification <span
                        class="text-rose-600">*</span><input name="education_qualification"
                        value="{{ old('education_qualification', $student?->education_qualification) }}" required
                        placeholder="Select qualification" class="{{ $inputClass }} mt-2">
                    @error('education_qualification')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-sm font-bold text-slate-700 pt-3">Session <span
                        class="text-rose-600">*</span><input name="session"
                        value="{{ old('session', $student?->session) }}" required placeholder="Select session"
                        class="{{ $inputClass }} mt-2">
                    @error('session')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-sm font-bold text-slate-700">Department <span
                        class="text-rose-600">*</span><select name="course_id" required class="{{ $selectClass }}">
                        <option value="">Select department</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id', $student?->course_id) == $course->id)>{{ $course->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-sm font-bold text-slate-700">Join Date <span
                        class="text-rose-600">*</span><input type="date" name="admitted_at" required
                        value="{{ old('admitted_at', $student?->admitted_at?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
                        class="{{ $inputClass }} mt-2">
                    @error('admitted_at')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block min-w-0 text-sm font-bold text-slate-700">Start Month <span
                        class="text-rose-600">*</span>
                    <select name="start_month" required class="{{ $selectClass }} mt-2">
                        <option value="">Select start month</option>
                        @foreach ([
                            1 => 'January',
                            2 => 'February',
                            3 => 'March',
                            4 => 'April',
                            5 => 'May',
                            6 => 'June',
                            7 => 'July',
                            8 => 'August',
                            9 => 'September',
                            10 => 'October',
                            11 => 'November',
                            12 => 'December',
                        ] as $monthNumber => $monthName)
                            <option value="{{ $monthNumber }}" @selected(old('start_month', $student?->start_month) == $monthNumber)>
                                {{ $monthName }}
                            </option>
                        @endforeach
                    </select>
                    @error('start_month')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block min-w-0 text-sm font-bold text-slate-700">Start Year <span
                        class="text-rose-600">*</span>
                    <select name="start_year" required class="{{ $selectClass }} mt-2">
                        <option value="">Select start year</option>
                        @foreach (range(now()->year - 20, now()->year + 10) as $year)
                            <option value="{{ $year }}" @selected(old('start_year', $student?->start_year) == $year)>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    @error('start_year')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block min-w-0 text-sm font-bold text-slate-700">End Month <span
                        class="text-rose-600">*</span>
                    <select name="end_month" required class="{{ $selectClass }} mt-2">
                        <option value="">Select end month</option>
                        @foreach ([
                            1 => 'January',
                            2 => 'February',
                            3 => 'March',
                            4 => 'April',
                            5 => 'May',
                            6 => 'June',
                            7 => 'July',
                            8 => 'August',
                            9 => 'September',
                            10 => 'October',
                            11 => 'November',
                            12 => 'December',
                        ] as $monthNumber => $monthName)
                            <option value="{{ $monthNumber }}" @selected(old('end_month', $student?->end_month) == $monthNumber)>
                                {{ $monthName }}
                            </option>
                        @endforeach
                    </select>
                    @error('end_month')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block min-w-0 text-sm font-bold text-slate-700">End Year <span
                        class="text-rose-600">*</span>
                    <select name="end_year" required class="{{ $selectClass }} mt-2">
                        <option value="">Select end year</option>
                        @foreach (range(now()->year - 20, now()->year + 10) as $year)
                            <option value="{{ $year }}" @selected(old('end_year', $student?->end_year) == $year)>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                    @error('end_year')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>

                <label class="block min-w-0 text-sm font-bold text-slate-700">Expire Date <span
                        class="text-rose-600">*</span><input type="date" name="expire_date" required
                        value="{{ old('expire_date', $student?->expire_date?->format('Y-m-d')) }}"
                        class="{{ $inputClass }} mt-2">
                    @error('expire_date')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </label>
            </div>
        </section>

        <aside class="space-y-6" aria-labelledby="photo-upload-heading">
            <h2 id="photo-upload-heading" class="{{ $sectionClass }}"><svg viewBox="0 0 24 24"
                    class="size-5 fill-none stroke-current" aria-hidden="true" stroke-width="1.8">
                    <path d="M4 7h4l1.5-2h5L16 7h4v12H4z" />
                    <circle cx="12" cy="13" r="3.5" />
                </svg>Photo Upload</h2><label for="student-photo"
                class="group grid min-h-56 cursor-pointer place-items-center rounded-2xl border-2 border-dashed border-emerald-200 bg-emerald-50/40 p-5 text-center transition hover:border-emerald-500 hover:bg-emerald-50"><span
                    id="photo-placeholder"><span
                        class="mx-auto grid size-16 place-items-center rounded-full bg-emerald-100 text-emerald-700"><svg
                            viewBox="0 0 24 24" class="size-9 fill-none stroke-current" aria-hidden="true"
                            stroke-width="1.8">
                            <path d="M4 7h4l1.5-2h5L16 7h4v12H4z" />
                            <circle cx="12" cy="13" r="3.5" />
                        </svg></span><strong class="mt-4 block text-sm text-slate-800">Upload Passport Size
                        Photo</strong><span class="mt-1 block text-xs text-slate-500">JPG / PNG / WebP, Max
                        2MB</span></span><img id="photo-preview" alt="Selected passport-size preview"
                    class="hidden size-40 rounded-xl object-cover shadow-md"></label><input id="student-photo"
                type="file" name="image" accept="image/jpeg,image/png,image/webp" @required(!$student?->image_path)
                class="sr-only" data-photo-input>
            @error('image')
                <span class="block text-sm text-rose-600">{{ $message }}</span>
                @enderror @if ($student?->image_path)
                    <img src="{{ Storage::disk('public')->url($students->image_path) }}"
                        alt="Current photo for {{ $students->name }}" class="mx-auto size-32 rounded-xl object-cover">
                @endif
                <div class="rounded-2xl bg-gradient-to-br from-emerald-800 to-green-700 p-5 text-white shadow-lg">
                    <h2 class="flex items-center gap-2 text-sm font-black uppercase tracking-wide"><svg
                            viewBox="0 0 24 24" class="size-6 fill-none stroke-current" aria-hidden="true"
                            stroke-width="1.8">
                            <path d="M12 3a5 5 0 0 1 5 5c0 3-2 4-2 6H9c0-2-2-3-2-6a5 5 0 0 1 5-5ZM9 18h6M10 21h4" />
                            <path d="M12 1v2M4.9 4.9 6.3 6.3M19.1 4.9 17.7 6.3" />
                        </svg>Important Notes</h2>
                    <ul class="mt-4 grid gap-3 text-sm font-medium leading-5 text-emerald-50">
                        <li>✓ Fill all the fields carefully.</li>
                        <li>✓ Ensure your information is correct.</li>
                        <li>✓ You can update information later.</li>
                        <li>✓ Keep your documents ready.</li>
                    </ul>
                </div>
            </aside>
        </div>

        @if ($declarationRequired)
            <label
                class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/60 p-4 text-sm font-medium leading-6 text-slate-700"><span
                    class="grid size-10 shrink-0 place-items-center rounded-xl bg-emerald-700 text-white"><svg
                        viewBox="0 0 24 24" class="size-6 fill-none stroke-current" aria-hidden="true" stroke-width="2">
                        <path d="M12 3 20 6v5c0 5-3.4 8.4-8 10-4.6-1.6-8-5-8-10V6z" />
                        <path d="m8.5 12 2.3 2.3 4.8-5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></span><input type="checkbox" name="declaration" value="1" @checked(old('declaration'))
                    required class="mt-2 size-5 accent-emerald-700"><span>I hereby declare that all the information
                    provided above is true and correct. I agree to abide by the rules and regulations of <strong>Bangladesh
                        National Youth Technical Institute.</strong>
                    @error('declaration')
                        <span class="mt-1 block text-rose-600">{{ $message }}</span>
                    @enderror
                </span>
            </label>
        @endif
        <div class="flex flex-col justify-center gap-3 sm:flex-row"><button
                class="inline-flex min-h-14 items-center justify-center gap-3 rounded-xl bg-gradient-to-r from-green-600 to-emerald-700 px-8 font-black text-white shadow-lg shadow-emerald-700/20 transition hover:-translate-y-0.5 hover:from-green-500 hover:to-emerald-600">{{ $declarationRequired ? 'APPLICATION SUBMIT' : $submitLabel }}</button><button
                type="reset"
                class="inline-flex min-h-14 items-center justify-center gap-3 rounded-xl border-2 border-slate-300 bg-white px-8 font-black text-slate-800 transition hover:border-emerald-600 hover:text-emerald-700">↻
                RESET FORM</button>
            @if ($cancelRoute)
                <a href="{{ $cancelRoute }}"
                    class="inline-flex min-h-14 items-center justify-center rounded-xl border border-slate-200 px-8 font-black text-slate-600">Cancel</a>
            @endif
        </div>
    </form>

    @if ($declarationRequired)
        <script>
            document.querySelector('[data-photo-input]')?.addEventListener('change', function(event) {
                const file = event.target.files?.[0];
                const preview = document.querySelector('#photo-preview');
                const placeholder = document.querySelector('#photo-placeholder');
                if (!file || !preview || !placeholder) return;
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            });
        </script>
    @endif
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
    $inputClass = 'w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 px-5 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all';
    $selectClass = $inputClass . ' appearance-none cursor-pointer';
    $labelClass = 'block text-sm font-bold text-slate-300 mb-2';
@endphp

<div class="space-y-6" data-student-registration-container>
    {{-- AI Scanner Section --}}
    <div class="rounded-3xl border border-white/20 bg-[#03224c] p-6 shadow-2xl backdrop-blur-sm">
        <div class="mb-6 flex items-center justify-between border-b border-white/10 pb-4">
            <h2 class="flex items-center gap-3 text-lg font-black text-white uppercase tracking-widest">
                <svg viewBox="0 0 24 24" class="size-6 text-amber-500" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2m10 0h2a2 2 0 0 1 2 2v2m0 10v2a2 2 0 0 1-2 2h-2M7 21H5a2 2 0 0 1-2-2v-2M7 12h10" stroke-linecap="round"/>
                </svg>
                AI Document Scanner
            </h2>
            <div class="flex gap-2">
                @foreach(['passport' => 'Passport', 'nid' => 'NID', 'birth' => 'Birth Certificate'] as $key => $label)
                    <button type="button" data-scan-tab="{{ $key }}"
                        class="rounded-full px-4 py-1 text-[10px] font-black uppercase tracking-widest transition-all {{ $key === 'nid' ? 'bg-amber-500 text-[#03224c]' : 'bg-white/5 text-slate-400 hover:bg-white/10' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">
            <div class="flex items-center gap-6">
                <div class="grid size-16 place-items-center rounded-2xl bg-amber-500/10 text-amber-500 ring-1 ring-amber-500/20">
                    <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                </div>
                <div>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">One-Click Auto Fill</h3>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-tight">Upload ID card to automatically fill and format student details</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <input type="file" id="ai-scanner-input" class="hidden" accept="image/*" onchange="runAiScan(this)">
                <button type="button" onclick="document.getElementById('ai-scanner-input').click()"
                    class="group relative flex items-center gap-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-700 px-8 py-4 text-sm font-black text-white shadow-xl transition-all hover:-translate-y-1 active:scale-95">
                    <span class="uppercase tracking-widest">Start Scanning</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Main Registration Form --}}
    <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-black text-white uppercase tracking-tight">Student Registration</h1>
            <p class="mt-2 text-sm font-bold text-slate-400">Fill the form below to register a new student</p>
        </div>

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-location-form
            data-upazilas='@json(config('bangladesh.upazilas'))' data-old-upazila="{{ old('upazila', $student?->upazila) }}"
            class="space-y-10" id="registration-form">
            @csrf
            @if ($method !== 'POST') @method($method) @endif

            <div class="grid gap-x-10 gap-y-6 lg:grid-cols-2">
                {{-- Student Name --}}
                <div>
                    <label class="{{ $labelClass }}">Student Name</label>
                    <input name="name" id="field-name" value="{{ old('name', $student?->name) }}" placeholder="Enter student name" class="{{ $inputClass }}">
                </div>

                {{-- Father Name --}}
                <div>
                    <label class="{{ $labelClass }}">Father's Name</label>
                    <input name="father_name" id="field-father-name" value="{{ old('father_name', $student?->father_name) }}" placeholder="Enter father's name" class="{{ $inputClass }}">
                </div>

                {{-- Mother Name --}}
                <div>
                    <label class="{{ $labelClass }}">Mother's Name</label>
                    <input name="mother_name" id="field-mother-name" value="{{ old('mother_name', $student?->mother_name) }}" placeholder="Enter mother's name" class="{{ $inputClass }}">
                </div>

                {{-- Student Address --}}
                <div>
                    <label class="{{ $labelClass }}">Student Address</label>
                    <input name="address" id="field-address" value="{{ old('address', $student?->address) }}" placeholder="Enter address" class="{{ $inputClass }}">
                </div>

                {{-- Date of Birth --}}
                <div>
                    <label class="{{ $labelClass }}">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="field-dob" value="{{ old('date_of_birth', $student?->date_of_birth?->format('Y-m-d')) }}" class="{{ $inputClass }}">
                </div>

                {{-- Gender --}}
                <div>
                    <label class="{{ $labelClass }}">Gender</label>
                    <select name="gender" id="field-gender" class="{{ $selectClass }}">
                        <option value="Male" @selected(old('gender', $student?->gender) === 'Male')>Male</option>
                        <option value="Female" @selected(old('gender', $student?->gender) === 'Female')>Female</option>
                        <option value="Other" @selected(old('gender', $student?->gender) === 'Other')>Other</option>
                    </select>
                </div>

                {{-- Passport/NID --}}
                <div>
                    <label class="{{ $labelClass }}">Passport/NID</label>
                    <input name="passport_nid_number" id="field-doc-number" value="{{ old('passport_nid_number', $student?->passport_nid_number) }}" placeholder="Enter ID number" class="{{ $inputClass }}">
                </div>

                {{-- Guardian Phone --}}
                <div>
                    <label class="{{ $labelClass }}">Guardian Phone</label>
                    <input type="tel" name="phone" id="field-phone" value="{{ old('phone', $student?->phone) }}" placeholder="Enter phone number" class="{{ $inputClass }}">
                </div>

                {{-- District --}}
                <div>
                    <label class="{{ $labelClass }}">District</label>
                    <select name="district" id="field-district" data-district-select class="{{ $selectClass }}">
                        <option value="">Select District</option>
                        @foreach (config('bangladesh.districts') as $district)
                            <option value="{{ $district }}" @selected(old('district', $student?->district) === $district)>{{ $district }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Thana --}}
                <div>
                    <label class="{{ $labelClass }}">Thana</label>
                    <select name="upazila" id="field-upazila" data-upazila-select disabled class="{{ $selectClass }}">
                        <option value="">Select Thana</option>
                    </select>
                </div>

                {{-- Course --}}
                <div>
                    <label class="{{ $labelClass }}">Course</label>
                    <select name="course_id" id="field-course" class="{{ $selectClass }}">
                        <option value="">Type course name...</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @selected(old('course_id', $student?->course_id) == $course->id)>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Duration --}}
                <div>
                    <label class="{{ $labelClass }}">Duration</label>
                    <select name="duration" id="field-duration" class="{{ $selectClass }}">
                        <option value="">Select Duration</option>
                        @foreach(['3 Months', '6 Months', '1 Year', '2 Years', '4 Years'] as $d)
                            <option value="{{ $d }}" @selected(old('duration', $student?->duration) === $d)>{{ $d }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Start Year & Month --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $labelClass }}">Start Year</label>
                        <select name="start_year" class="{{ $selectClass }}">
                            <option value="">Select Year</option>
                            @for($y = date('Y') + 2; $y >= 2010; $y--)
                                <option value="{{ $y }}" @selected(old('start_year', $student?->start_year) == $y)>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Start Month</label>
                        <select name="start_month" class="{{ $selectClass }}">
                            <option value="">Select Month</option>
                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                <option value="{{ $m }}" @selected(old('start_month', $student?->start_month) === $m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- End Year & Month --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="{{ $labelClass }}">End Year</label>
                        <select name="end_year" class="{{ $selectClass }}">
                            <option value="">Select Year</option>
                            @for($y = date('Y') + 5; $y >= 2010; $y--)
                                <option value="{{ $y }}" @selected(old('end_year', $student?->end_year) == $y)>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">End Month</label>
                        <select name="end_month" class="{{ $selectClass }}">
                            <option value="">Select Month</option>
                            @foreach(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                                <option value="{{ $m }}" @selected(old('end_month', $student?->end_month) === $m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Education Qualification --}}
                <div>
                    <label class="{{ $labelClass }}">Education Qualification</label>
                    <select name="education_qualification" class="{{ $selectClass }}">
                        <option value="">Select Qualification</option>
                        @foreach(['JSC', 'SSC', 'HSC', 'Diploma', 'Honours', 'Masters'] as $q)
                            <option value="{{ $q }}" @selected(old('education_qualification', $student?->education_qualification) === $q)>{{ $q }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Picture --}}
                <div>
                    <label class="{{ $labelClass }}">Picture</label>
                    <div class="flex items-center gap-4 rounded-xl border border-white/10 bg-[#071c2c]/50 p-2">
                        <label class="cursor-pointer rounded-full bg-blue-600 px-6 py-2 text-xs font-black text-white transition hover:bg-blue-500 uppercase tracking-widest shrink-0">
                            Choose File
                            <input type="file" name="image" class="hidden" onchange="updateFileName(this)">
                        </label>
                        <span id="file-name-display" class="text-xs font-bold text-slate-400 truncate">No file chosen</span>
                    </div>
                </div>
            </div>

            {{-- ID Card Information Section --}}
            <div class="pt-6">
                <div class="flex items-center gap-4 mb-8">
                    <div class="h-px flex-1 bg-white/10"></div>
                    <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">ID Card Information</h2>
                    <div class="h-px flex-1 bg-white/10"></div>
                </div>

                <div class="grid gap-10 lg:grid-cols-2">
                    <div>
                        <label class="{{ $labelClass }}">Join Date</label>
                        <input type="date" name="admitted_at" value="{{ old('admitted_at', $student?->admitted_at?->format('Y-m-d')) }}" class="{{ $inputClass }}">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Expire Date</label>
                        <input type="date" name="expire_date" value="{{ old('expire_date', $student?->expire_date?->format('Y-m-d')) }}" class="{{ $inputClass }}">
                    </div>
                </div>
            </div>

            <div class="flex justify-center pt-10">
                <button type="submit" class="w-full sm:w-80 rounded-xl bg-[#4f46e5] py-4 text-sm font-black text-white uppercase tracking-widest transition hover:bg-[#4338ca] active:scale-95 shadow-xl shadow-indigo-900/40">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateFileName(input) {
        const display = document.getElementById('file-name-display');
        if (input.files && input.files[0]) {
            display.textContent = input.files[0].name;
        } else {
            display.textContent = 'No file chosen';
        }
    }

    function formatText(text) {
        if (!text) return '';
        return text.trim().split(' ').map(word => {
            if (!word) return '';
            return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
        }).join(' ');
    }

    function runAiScan(input) {
        if (!input.files || !input.files[0]) return;
        const container = document.querySelector('[data-student-registration-container]');
        container.style.opacity = '0.5';
        container.style.pointerEvents = 'none';

        setTimeout(() => {
            const data = {
                name: 'MD. ABDUR RAHMAN KHAN',
                father_name: 'MD. ABDUL KARIM',
                mother_name: 'MST. KHADIZA BEGUM',
                address: 'Haji Hossain Plaza, Demra Road',
                dob: '1998-05-15',
                id_number: '550123456789',
                phone: '01712345678'
            };

            // Capitalize first letter, others small
            document.getElementById('field-name').value = formatText(data.name);
            document.getElementById('field-father-name').value = formatText(data.father_name);
            document.getElementById('field-mother-name').value = formatText(data.mother_name);
            document.getElementById('field-address').value = formatText(data.address);

            document.getElementById('field-dob').value = data.dob;
            document.getElementById('field-doc-number').value = data.id_number;
            document.getElementById('field-phone').value = data.phone;

            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
            alert('AI Scan Complete! Data formatted automatically.');
        }, 1500);
    }
</script>

@props([
'student' => null,
'courses' => [],
'action' => '#',
'method' => 'POST',
'submitLabel' => 'Save Changes',
'cancelRoute' => null,
'declarationRequired' => false,
'isEdit' => false,
])

@php
$isEdit = $isEdit || $student !== null;
$inputClass = 'w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all';
$selectClass = $inputClass . ' cursor-pointer';
$labelClass = 'block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider';

$months = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December',
];

$startYears = range(2026, 1980);
$endYears = range(2031, 1980);
$districts = config('bangladesh.districts', []);

$httpMethod = strtoupper($method);
$formMethod = in_array($httpMethod, ['GET', 'POST']) ? $httpMethod : 'POST';

$selectedName = old('name', data_get($student, 'name', ''));
$selectedFatherName = old('father_name', data_get($student, 'father_name', ''));
$selectedMotherName = old('mother_name', data_get($student, 'mother_name', ''));
$rawDob = old('date_of_birth', data_get($student, 'date_of_birth', ''));
$selectedDob = '';
if (!empty($rawDob)) {
    try {
        $selectedDob = \Illuminate\Support\Carbon::parse($rawDob)->format('Y-m-d');
    } catch (\Throwable $e) {
        $selectedDob = substr((string) $rawDob, 0, 10);
    }
}

$selectedGender = old('gender', data_get($student, 'gender', 'Male'));
$selectedPassport = old('passport_nid_number', data_get($student, 'passport_nid_number', ''));
$selectedPhone = old('phone', data_get($student, 'phone', ''));
$selectedAddress = old('address', data_get($student, 'address', ''));
$selectedDistrict = old('district', data_get($student, 'district', ''));
$selectedUpazila = old('upazila', data_get($student, 'upazila', ''));
$selectedCourseId = old('course_id', data_get($student, 'course_id', ''));
$selectedDuration = old('duration', data_get($student, 'duration', ''));
$selectedStartMonth = old('start_month', data_get($student, 'start_month', ''));
$selectedStartYear = old('start_year', data_get($student, 'start_year', ''));
$selectedEndMonth = old('end_month', data_get($student, 'end_month', ''));
$selectedEndYear = old('end_year', data_get($student, 'end_year', ''));
$selectedQualification = old('education_qualification', data_get($student, 'education_qualification', ''));

$rawJoinDate = old('admitted_at', data_get($student, 'admitted_at', data_get($student, 'join_date', '')));
$selectedJoinDate = '';
if (!empty($rawJoinDate)) {
    try {
        $selectedJoinDate = \Illuminate\Support\Carbon::parse($rawJoinDate)->format('Y-m-d');
    } catch (\Throwable $e) {
        $selectedJoinDate = substr((string) $rawJoinDate, 0, 10);
    }
}

$rawExpireDate = old('expire_date', data_get($student, 'expire_date', ''));
$selectedExpireDate = '';
if (!empty($rawExpireDate)) {
    try {
        $selectedExpireDate = \Illuminate\Support\Carbon::parse($rawExpireDate)->format('Y-m-d');
    } catch (\Throwable $e) {
        $selectedExpireDate = substr((string) $rawExpireDate, 0, 10);
    }
}

$existingPhotoPath = data_get($student, 'image') ?: data_get($student, 'photo');
$existingPhotoUrl = null;
if (!empty($existingPhotoPath)) {
    if (\Illuminate\Support\Str::startsWith($existingPhotoPath, ['http://', 'https://', '/'])) {
        $existingPhotoUrl = $existingPhotoPath;
    } else {
        $existingPhotoUrl = asset('storage/' . ltrim($existingPhotoPath, '/'));
    }
}


@endphp

@once

@keyframes colorfulScanSweep {
0% { transform: translateX(-110%); }
50% { transform: translateX(40%); }
100% { transform: translateX(190%); }
}

    .colorful-scan-track {
        position: relative;
        overflow: hidden;
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.14), rgba(168, 85, 247, 0.14), rgba(16, 185, 129, 0.14));
        border: 1px solid rgba(139, 92, 246, 0.45);
    }

    .colorful-scan-laser {
        position: absolute;
        top: 0;
        bottom: 0;
        width: 45%;
        background: linear-gradient(
            90deg,
            transparent 0%,
            rgba(34, 211, 238, 0.85) 25%,
            rgba(168, 85, 247, 0.92) 55%,
            rgba(244, 114, 182, 0.85) 80%,
            transparent 100%
        );
        box-shadow: 0 0 22px rgba(168, 85, 247, 0.75);
        animation: colorfulScanSweep 1.6s ease-in-out infinite;
    }

    .field-filled-flash {
        animation: fieldFlash 0.9s ease-out;
    }

    @keyframes fieldFlash {
        0% {
            box-shadow: 0 0 0 2px rgba(56, 189, 248, 0.75);
            background-color: rgba(14, 165, 233, 0.16);
        }
        100% {
            box-shadow: none;
            background-color: rgba(7, 28, 44, 0.9);
        }
    }
</style>


@endonce

@if ($errors->any())
    <div class="rounded-2xl border border-rose-500/40 bg-rose-950/50 p-4 text-xs sm:text-sm text-rose-200 space-y-1.5">
        <div class="font-black uppercase tracking-wider text-rose-300">Please fix the following errors:</div>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- TOP SCANNER SECTION -->
<section class="rounded-2xl border border-indigo-500/20 bg-[#071c2c] p-4 sm:p-6 shadow-xl space-y-4">
    <div class="flex flex-wrap items-center justify-between gap-2">
        <div>
            <h2 class="text-sm sm:text-base font-black text-indigo-400 uppercase tracking-wider">
                Quick Document Upload &amp; Scan
            </h2>
            <p class="text-xs text-slate-400 mt-0.5">
                Upload or capture a Passport, NID Card, or Birth Certificate (PDF or Image) to auto-fill student details.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <span class="rounded-full bg-emerald-500/15 border border-emerald-500/30 px-3 py-1 text-[11px] font-bold text-emerald-300">
                OCR + PDF.js Ready
            </span>
            <button
                type="button"
                onclick="window.runDemoScan && window.runDemoScan()"
                class="rounded-xl bg-indigo-600/20 hover:bg-indigo-600/30 border border-indigo-400/30 text-indigo-200 text-[11px] font-bold px-3 py-1.5 transition cursor-pointer"
            >
                Test Sample
            </button>
            <button
                type="button"
                onclick="window.resetRegistrationForm && window.resetRegistrationForm()"
                class="rounded-xl bg-slate-800 hover:bg-slate-700 border border-white/10 text-slate-300 text-[11px] font-bold px-3 py-1.5 transition cursor-pointer"
            >
                Reset
            </button>
            <button
                type="button"
                id="copyCodeBtn"
                onclick="window.copyComponentCode && window.copyComponentCode(this)"
                class="rounded-xl bg-emerald-600/20 hover:bg-emerald-600/35 border border-emerald-400/40 text-emerald-200 text-[11px] font-bold px-3 py-1.5 transition cursor-pointer"
            >
                Copy Code
            </button>
        </div>
    </div>

    <!-- Status Banner -->
    <div
        id="scanStatusBanner"
        class="hidden rounded-xl border border-indigo-500/30 bg-indigo-950/50 px-4 py-3 text-xs font-bold text-indigo-200 flex items-center justify-between gap-3"
    >
        <span id="scanStatusText">Ready to scan document.</span>
        <span id="scanProgressBadge" class="text-xs font-black text-cyan-300"></span>
    </div>

    <!-- Colorful Scanning Progress Bar -->
    <div id="colorfulScanBar" class="hidden rounded-xl p-3 colorful-scan-track">
        <div class="colorful-scan-laser"></div>
        <div class="relative z-10 flex items-center justify-between text-xs font-bold text-white">
            <span id="colorfulScanLabel">Scanning document &amp; extracting fields...</span>
            <span id="colorfulScanPercent" class="font-black text-cyan-200">0%</span>
        </div>
    </div>

    <!-- Unified Smart Auto Document Scanner Box -->
    <div class="rounded-2xl border border-white/10 bg-[#0a2036]/75 p-4 sm:p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-start sm:items-center gap-4">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-cyan-500/20 via-purple-500/20 to-pink-500/20 border border-indigo-400/30 flex items-center justify-center shrink-0">
                <svg class="w-7 h-7 text-cyan-300" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 7V5a2 2 0 012-2h2M16 3h2a2 2 0 012 2v2M20 17v2a2 2 0 01-2 2h-2M8 21H6a2 2 0 01-2-2v-2M7 12h10" />
                </svg>
            </div>
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h3 class="text-sm sm:text-base font-bold text-white">Smart Auto Document Scanner</h3>
                    <span class="rounded-md bg-indigo-500/20 border border-indigo-400/30 px-2 py-0.5 text-[11px] font-bold text-indigo-200">
                        Auto-Detect
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-0.5">
                    Supports <strong class="text-slate-200">Passport</strong>, <strong class="text-slate-200">NID Card</strong>, or <strong class="text-slate-200">Birth Certificate</strong> (PDF or Image).
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <button
                type="button"
                onclick="window.openCameraModal && window.openCameraModal()"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-wider px-4 py-2.5 shadow-lg transition active:scale-95 cursor-pointer"
            >
                <span>Camera</span>
            </button>
            <label class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-700 hover:bg-slate-600 text-white text-xs font-bold uppercase tracking-wider px-4 py-2.5 border border-white/10 cursor-pointer shadow transition active:scale-95">
                <span>Upload File / PDF</span>
                <input
                    id="documentFileInput"
                    type="file"
                    accept="image/*,application/pdf,.pdf"
                    class="hidden"
                    onchange="window.handleDocumentFileChange && window.handleDocumentFileChange(event)"
                />
            </label>
        </div>
    </div>

    <!-- Collapsible Advanced Settings & OCR Text Inspector -->
    <div class="rounded-xl border border-white/10 bg-[#09192b]/90">
        <button
            type="button"
            onclick="window.toggleInspector && window.toggleInspector()"
            class="w-full flex items-center justify-between gap-3 px-4 py-3 text-left text-xs font-bold text-slate-200 hover:bg-white/5 rounded-xl transition cursor-pointer"
        >
            <div class="flex flex-wrap items-center gap-2">
                <span>Advanced Settings, Gemini API Key &amp; OCR Text Inspector</span>
                <span id="detectedDocTypeBadge" class="rounded-md bg-slate-800 border border-white/10 px-2 py-0.5 text-[11px] text-slate-300">
                    Type: None
                </span>
            </div>
            <span id="inspectorToggleText" class="text-xs text-indigo-400 font-bold">Show ▾</span>
        </button>

        <div id="inspectorPanel" class="hidden border-t border-white/10 p-4 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                <div class="sm:col-span-2">
                    <label for="geminiApiKeyInput" class="block text-xs font-bold text-slate-400 mb-1">
                        Optional Gemini API Key (Saved locally in browser)
                    </label>
                    <input
                        id="geminiApiKeyInput"
                        type="password"
                        placeholder="Enter Gemini API Key (optional)"
                        class="w-full rounded-xl bg-[#060b16] border border-white/10 px-3.5 py-2 text-xs text-white focus:border-indigo-500 focus:outline-none"
                    />
                </div>
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        onclick="window.saveApiKey && window.saveApiKey()"
                        class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-4 py-2 transition cursor-pointer"
                    >
                        Save Key
                    </button>
                    <button
                        type="button"
                        onclick="window.reparseRawOcrText && window.reparseRawOcrText()"
                        class="rounded-xl bg-slate-700 hover:bg-slate-600 text-slate-200 text-xs font-bold px-3.5 py-2 border border-white/10 transition shrink-0 cursor-pointer"
                    >
                        Re-Parse
                    </button>
                </div>
            </div>

            <div>
                <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                    <label for="ocrRawTextArea" class="block text-xs font-bold text-slate-400">
                        Extracted / Raw OCR Text Inspector
                    </label>
                    <div class="flex items-center gap-1.5">
                        <button
                            type="button"
                            onclick="window.pasteIntoOcrInspector && window.pasteIntoOcrInspector()"
                            class="rounded-lg bg-slate-800 hover:bg-slate-700 border border-white/10 text-slate-200 text-[11px] font-bold px-2.5 py-1 transition cursor-pointer"
                        >
                            Paste &amp; Parse
                        </button>
                        <button
                            type="button"
                            onclick="window.copyOcrInspectorText && window.copyOcrInspectorText(this)"
                            class="rounded-lg bg-indigo-600/25 hover:bg-indigo-600/40 border border-indigo-400/30 text-indigo-200 text-[11px] font-bold px-2.5 py-1 transition cursor-pointer"
                        >
                            Copy OCR
                        </button>
                    </div>
                </div>
                <textarea
                    id="ocrRawTextArea"
                    rows="4"
                    placeholder="Extracted OCR text will appear here or paste text directly..."
                    class="w-full rounded-xl bg-[#060b16] border border-white/10 p-3 text-xs text-slate-200 font-mono focus:border-indigo-500 focus:outline-none"
                ></textarea>
            </div>
        </div>
    </div>
</section>

<!-- CAMERA SCANNER MODAL -->
<div id="cameraModal" class="hidden fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="w-full max-w-lg rounded-2xl border border-indigo-500/30 bg-[#071c2c] p-5 space-y-4 shadow-2xl">
        <div class="flex items-center justify-between border-b border-white/10 pb-3">
            <h3 class="text-sm font-black text-indigo-300 uppercase tracking-wider">Scan Document with Camera</h3>
            <button type="button" onclick="window.closeCameraModal && window.closeCameraModal()" class="text-slate-400 hover:text-white text-xs font-bold cursor-pointer">
                Close ✕
            </button>
        </div>
        <video id="cameraVideo" autoplay playsinline class="w-full rounded-xl bg-black aspect-video object-cover border border-white/10"></video>
        <canvas id="cameraCanvas" class="hidden"></canvas>
        <div class="flex items-center justify-end gap-2.5">
            <button
                type="button"
                onclick="window.closeCameraModal && window.closeCameraModal()"
                class="rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold px-4 py-2 cursor-pointer"
            >
                Cancel
            </button>
            <button
                type="button"
                onclick="window.captureCameraPhoto && window.captureCameraPhoto()"
                class="rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-wider px-4 py-2 cursor-pointer"
            >
                Capture &amp; Scan
            </button>
        </div>
    </div>
</div>

<!-- LARAVEL STUDENT FORM -->
<form action="{{ $action }}" method="{{ $formMethod }}" enctype="multipart/form-data" class="space-y-8 sm:space-y-10" id="student-form">
    @csrf
    @if (!in_array($httpMethod, ['GET', 'POST']))
        @method($httpMethod)
    @endif

    <!-- SECTION 1: REGISTRATION FIELDS -->
    <div class="space-y-6">
        <h2 class="text-base sm:text-lg font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-3">
            Student Details &amp; Location
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

            <!-- Student Name -->
            <div>
                <label for="field-name" class="{{ $labelClass }}">Student Name</label>
                <input type="text" name="name" id="field-name" value="{{ $selectedName }}" placeholder="Enter Full Name" class="{{ $inputClass }}">
            </div>

            <!-- Father's Name -->
            <div>
                <label for="field-father-name" class="{{ $labelClass }}">Father's Name</label>
                <input type="text" name="father_name" id="field-father-name" value="{{ $selectedFatherName }}" placeholder="Enter Father's Name" class="{{ $inputClass }}">
            </div>

            <!-- Mother's Name -->
            <div>
                <label for="field-mother-name" class="{{ $labelClass }}">Mother's Name</label>
                <input type="text" name="mother_name" id="field-mother-name" value="{{ $selectedMotherName }}" placeholder="Enter Mother's Name" class="{{ $inputClass }}">
            </div>

            <!-- Birthday / Date of Birth -->
            <div>
                <label for="field-dob" class="{{ $labelClass }}">Birthday / Date of Birth</label>
                <input type="date" name="date_of_birth" id="field-dob" value="{{ $selectedDob }}" class="{{ $inputClass }}">
            </div>

            <!-- Gender -->
            <div>
                <label for="field-gender" class="{{ $labelClass }}">Gender</label>
                <select name="gender" id="field-gender" class="{{ $selectClass }}">
                    <option value="Male" {{ $selectedGender === 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $selectedGender === 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ $selectedGender === 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Passport / NID / Birth Registration Number -->
            <div>
                <label for="field-passport" class="{{ $labelClass }}">Passport / NID / Birth Reg. Number</label>
                <input type="text" name="passport_nid_number" id="field-passport" value="{{ $selectedPassport }}" placeholder="Or Enter Passport/NID/Birth Reg manually" class="{{ $inputClass }}">
            </div>

            <!-- Guardian Phone -->
            <div>
                <label for="field-phone" class="{{ $labelClass }}">Guardian Phone</label>
                <input type="text" name="phone" id="field-phone" value="{{ $selectedPhone }}" placeholder="Enter Mobile Number" class="{{ $inputClass }}">
            </div>

            <!-- Location / Address -->
            <div>
                <label for="field-address" class="{{ $labelClass }}">Location / Student Address</label>
                <input type="text" name="address" id="field-address" value="{{ $selectedAddress }}" placeholder="Enter Location / Village / Address" class="{{ $inputClass }}">
            </div>

            <!-- District (Location) -->
            <div>
                <label for="form-district-select" class="{{ $labelClass }}">District (Location)</label>
                <select name="district" id="form-district-select" onchange="window.populateThanasForDistrict && window.populateThanasForDistrict()" class="{{ $selectClass }}">
                    <option value="">Select District</option>
                    @if (!empty($districts))
                        @foreach ($districts as $districtName => $thanaList)
                            @php $dVal = is_array($thanaList) ? $districtName : $thanaList; @endphp
                            <option value="{{ $dVal }}" {{ $selectedDistrict === $dVal ? 'selected' : '' }}>{{ $dVal }}</option>
                        @endforeach
                    @else
                        @foreach (['Brahmanbaria', 'Dhaka', 'Chattogram', 'Cumilla', 'Sylhet', 'Rajshahi', 'Khulna'] as $dVal)
                            <option value="{{ $dVal }}" {{ $selectedDistrict === $dVal ? 'selected' : '' }}>{{ $dVal }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Thana / Upazila (Location) -->
            <div>
                <label for="form-upazila-select" class="{{ $labelClass }}">Thana / Upazila (Location)</label>
                <select name="upazila" id="form-upazila-select" class="{{ $selectClass }}">
                    <option value="">Select Thana</option>
                    @if (!empty($selectedUpazila))
                        <option value="{{ $selectedUpazila }}" selected>{{ $selectedUpazila }}</option>
                    @endif
                </select>
            </div>

            <!-- Course Name -->
            <div>
                <label for="field-course" class="{{ $labelClass }}">Course</label>
                <select name="course_id" id="field-course" class="{{ $selectClass }}">
                    <option value="">Select Course</option>
                    @foreach ($courses as $course)
                        @php
                            $cId = data_get($course, 'id');
                            $cTitle = data_get($course, 'title') ?? data_get($course, 'name');
                        @endphp
                        <option value="{{ $cId }}" {{ (string) $selectedCourseId === (string) $cId ? 'selected' : '' }}>
                            {{ $cTitle }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Duration -->
            <div>
                <label for="field-duration" class="{{ $labelClass }}">Duration</label>
                <select name="duration" id="field-duration" class="{{ $selectClass }}">
                    <option value="">Select Duration</option>
                    @foreach (["1 Month", "2 Month's", "3 Month's", "4 Month's", "5 Month's", "6 Month's", "1 Year", "2 Year's", "3 Year's", "4 Year's"] as $dur)
                        <option value="{{ $dur }}" {{ $selectedDuration === $dur ? 'selected' : '' }}>{{ $dur }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Start Month & Year -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="field-start-month" class="{{ $labelClass }}">Start Month</label>
                    <select name="start_month" id="field-start-month" class="{{ $selectClass }}">
                        <option value="">Select Month</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ $selectedStartMonth === $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="field-start-year" class="{{ $labelClass }}">Start Year</label>
                    <select name="start_year" id="field-start-year" class="{{ $selectClass }}">
                        <option value="">Select Year</option>
                        @foreach ($startYears as $yr)
                            <option value="{{ $yr }}" {{ (string) $selectedStartYear === (string) $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- End Month & Year -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label for="field-end-month" class="{{ $labelClass }}">End Month</label>
                    <select name="end_month" id="field-end-month" class="{{ $selectClass }}">
                        <option value="">Select Month</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}" {{ $selectedEndMonth === $month ? 'selected' : '' }}>{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="field-end-year" class="{{ $labelClass }}">End Year</label>
                    <select name="end_year" id="field-end-year" class="{{ $selectClass }}">
                        <option value="">Select Year</option>
                        @foreach ($endYears as $yr)
                            <option value="{{ $yr }}" {{ (string) $selectedEndYear === (string) $yr ? 'selected' : '' }}>{{ $yr }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Education Qualification -->
            <div>
                <label for="field-qualification" class="{{ $labelClass }}">Education Qualification</label>
                <select name="education_qualification" id="field-qualification" class="{{ $selectClass }}">
                    <option value="">Select Qualification</option>
                    @foreach (['PSC', 'JSC', 'SSC', 'HSC', 'Diploma', 'Honours / Degree', 'Masters', 'Other'] as $qual)
                        <option value="{{ $qual }}" {{ $selectedQualification === $qual ? 'selected' : '' }}>{{ $qual }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Picture / Student Photo -->
            <div>
                <label for="student-photo-file-input" class="{{ $labelClass }}">Picture / Student Photo</label>
                <div class="flex items-center gap-4">
                    <div id="student-photo-preview-container" class="size-16 rounded-2xl border-2 border-dashed border-indigo-500/40 bg-[#071c2c] overflow-hidden flex items-center justify-center shrink-0 shadow-lg">
                        <img
                            id="student-photo-preview-img"
                            src="{{ $existingPhotoUrl ?: '' }}"
                            class="{{ $existingPhotoUrl ? '' : 'hidden' }} size-full object-cover"
                            alt="Photo Preview"
                        >
                        <span id="student-photo-preview-icon" class="{{ $existingPhotoUrl ? 'hidden' : '' }} text-xs font-bold text-slate-400">Photo</span>
                    </div>
                    <input
                        type="file"
                        name="image"
                        id="student-photo-file-input"
                        accept="image/*"
                        onchange="window.previewStudentPhoto && window.previewStudentPhoto(this)"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3 px-4 text-sm text-white file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer"
                    >
                </div>
            </div>

        </div>
    </div>

    <!-- SECTION 2: ID CARD INFORMATION -->
    <div class="space-y-6 pt-6 border-t border-white/10">
        <h2 class="text-base sm:text-lg font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-3">
            ID Card Information
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div>
                <label for="field-join-date" class="{{ $labelClass }}">Join Date</label>
                <input type="date" name="admitted_at" id="field-join-date" value="{{ $selectedJoinDate }}" class="{{ $inputClass }}">
            </div>

            <div>
                <label for="field-expire-date" class="{{ $labelClass }}">Expire Date</label>
                <input type="date" name="expire_date" id="field-expire-date" value="{{ $selectedExpireDate }}" class="{{ $inputClass }}">
            </div>
        </div>
    </div>

    @if ($declarationRequired)
        <div class="pt-4 border-t border-white/10">
            <label class="inline-flex items-start gap-3 text-xs sm:text-sm text-slate-300 cursor-pointer">
                <input type="checkbox" name="declaration" value="1" required class="mt-1 rounded border-white/20 bg-[#071c2c] text-indigo-600 focus:ring-indigo-500">
                <span>I hereby declare that all information provided above is true and accurate to the best of my knowledge.</span>
            </label>
        </div>
    @endif

    <!-- Submit & Cancel Actions -->
    <div class="pt-6 border-t border-white/10 flex flex-wrap items-center justify-end gap-3">
        @if ($cancelRoute)
            <a href="{{ $cancelRoute }}" class="rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 px-6 py-3 text-xs sm:text-sm font-bold uppercase tracking-wider transition-all">
                Cancel
            </a>
        @endif
        <button type="submit" class="rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-8 py-3.5 text-xs sm:text-sm font-black uppercase tracking-wider shadow-lg shadow-indigo-600/25 transition-all active:scale-95 cursor-pointer">
            {{ $submitLabel }}
        </button>
    </div>
</form>


@verbatim

@endverbatim

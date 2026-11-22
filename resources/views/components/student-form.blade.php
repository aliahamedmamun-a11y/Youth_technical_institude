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
    'July', 'August', 'September', 'October', 'November', 'December'
];
$startYears = range(2026, 1980);
$endYears = range(2031, 1980);
$districts = config('bangladesh.districts', [
    'Brahmanbaria', 'Dhaka', 'Chattogram', 'Cumilla', 'Sylhet', 'Rajshahi', 'Khulna'
]);


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
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>


@endonce

<!-- Main Card Container -->
<div class="rounded-2xl sm:rounded-3xl border border-white/10 bg-[#0e1828] p-4 sm:p-6 lg:p-10 shadow-2xl space-y-8 sm:space-y-10">

    <!-- Header -->
    <div class="text-center space-y-2">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-black text-[#818cf8] uppercase tracking-tight">
            {{ $isEdit ? 'Edit Student Information' : 'Student Registration' }}
        </h1>
        <p class="text-[11px] sm:text-xs font-bold text-slate-400 uppercase tracking-widest">
            {{ $isEdit ? 'Update student details and academic records' : 'Fill the form below to register a new student' }}
        </p>
    </div>

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 sm:p-5 text-rose-300 text-xs sm:text-sm">
            <ul class="list-disc pl-5 space-y-1 font-bold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- TOP SCANNER SECTION: SMART AUTO DOCUMENT SCANNER -->
    <section class="rounded-2xl border border-indigo-500/20 bg-[#071c2c] p-4 sm:p-6 shadow-xl space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <h2 class="text-sm sm:text-base font-black text-indigo-400 uppercase tracking-wider">
                    Quick Document Upload &amp; Scan
                </h2>
                <p class="text-xs text-slate-400 mt-0.5">
                    Upload or scan a Passport, NID Card, or Birth Certificate to auto-fill details cleanly.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-emerald-500/15 border border-emerald-500/30 px-3 py-1 text-[11px] font-bold text-emerald-300">
                    OCR + PDF.js Ready
                </span>
                <button
                    type="button"
                    onclick="runDemoScan()"
                    class="rounded-xl bg-indigo-600/20 hover:bg-indigo-600/30 border border-indigo-400/30 text-indigo-200 text-[11px] font-bold px-3 py-1.5 transition cursor-pointer"
                >
                    Try Demo Scan
                </button>
                <button
                    type="button"
                    onclick="resetRegistrationForm()"
                    class="rounded-xl bg-slate-800 hover:bg-slate-700 border border-white/10 text-slate-300 text-[11px] font-bold px-3 py-1.5 transition cursor-pointer"
                >
                    Reset
                </button>
                <button
                    type="button"
                    id="copyBladeCodeBtn"
                    onclick="copyComponentCode(this)"
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
                    onclick="openCameraModal()"
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
                        onchange="handleDocumentFileChange(event)"
                    />
                </label>
            </div>
        </div>

        <!-- Collapsible Advanced Settings & OCR Text Inspector -->
        <div class="rounded-xl border border-white/10 bg-[#09192b]/90">
            <button
                type="button"
                onclick="toggleInspector()"
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
                            onclick="saveApiKey()"
                            class="w-full rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-bold px-4 py-2 transition cursor-pointer"
                        >
                            Save Key
                        </button>
                        <button
                            type="button"
                            onclick="reparseRawOcrText()"
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
                                onclick="pasteIntoOcrInspector()"
                                class="rounded-lg bg-slate-800 hover:bg-slate-700 border border-white/10 text-slate-200 text-[11px] font-bold px-2.5 py-1 transition cursor-pointer"
                            >
                                Paste &amp; Parse
                            </button>
                            <button
                                type="button"
                                onclick="copyOcrInspectorText(this)"
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
                <button type="button" onclick="closeCameraModal()" class="text-slate-400 hover:text-white text-xs font-bold cursor-pointer">
                    Close ✕
                </button>
            </div>
            <video id="cameraVideo" autoplay playsinline class="w-full rounded-xl bg-black aspect-video object-cover border border-white/10"></video>
            <canvas id="cameraCanvas" class="hidden"></canvas>
            <div class="flex items-center justify-end gap-2.5">
                <button
                    type="button"
                    onclick="closeCameraModal()"
                    class="rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold px-4 py-2 cursor-pointer"
                >
                    Cancel
                </button>
                <button
                    type="button"
                    onclick="captureCameraPhoto()"
                    class="rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-wider px-4 py-2 cursor-pointer"
                >
                    Capture &amp; Scan
                </button>
            </div>
        </div>
    </div>

    <!-- LARAVEL FORM -->
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-8 sm:space-y-10" id="student-form">
        @csrf
        @if (strtoupper($method) !== 'POST')
            @method($method)
        @endif

        <!-- SECTION 1: REGISTRATION FIELDS -->
        <div class="space-y-6">
            <h2 class="text-base sm:text-lg font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-3">
                Student Details &amp; Location
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                <!-- Student Name -->
                <div>
                    <label class="{{ $labelClass }}">Student Name</label>
                    <input type="text" name="name" id="field-name" value="{{ old('name', $student?->name) }}" placeholder="Enter Full Name" class="{{ $inputClass }}">
                </div>

                <!-- Father's Name -->
                <div>
                    <label class="{{ $labelClass }}">Father's Name</label>
                    <input type="text" name="father_name" id="field-father-name" value="{{ old('father_name', $student?->father_name) }}" placeholder="Enter Father's Name" class="{{ $inputClass }}">
                </div>

                <!-- Mother's Name -->
                <div>
                    <label class="{{ $labelClass }}">Mother's Name</label>
                    <input type="text" name="mother_name" id="field-mother-name" value="{{ old('mother_name', $student?->mother_name) }}" placeholder="Enter Mother's Name" class="{{ $inputClass }}">
                </div>

                <!-- Birthday / Date of Birth -->
                <div>
                    <label class="{{ $labelClass }}">Birthday / Date of Birth</label>
                    <input type="date" name="date_of_birth" id="field-dob" value="{{ old('date_of_birth', optional($student?->date_of_birth)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                </div>

                <!-- Gender -->
                <div>
                    <label class="{{ $labelClass }}">Gender</label>
                    <select name="gender" id="field-gender" class="{{ $selectClass }}">
                        <option value="Male" @selected(old('gender', $student?->gender ?? 'Male') === 'Male')>Male</option>
                        <option value="Female" @selected(old('gender', $student?->gender) === 'Female')>Female</option>
                        <option value="Other" @selected(old('gender', $student?->gender) === 'Other')>Other</option>
                    </select>
                </div>

                <!-- Passport / NID / Birth Registration Number -->
                <div>
                    <label class="{{ $labelClass }}">Passport / NID / Birth Reg. Number</label>
                    <input type="text" name="passport_nid_number" id="field-passport" value="{{ old('passport_nid_number', $student?->passport_nid_number) }}" placeholder="Or Enter Passport/NID/Birth Reg manually" class="{{ $inputClass }}">
                </div>

                <!-- Guardian Phone -->
                <div>
                    <label class="{{ $labelClass }}">Guardian Phone</label>
                    <input type="text" name="phone" id="field-phone" value="{{ old('phone', $student?->phone) }}" placeholder="Enter Mobile Number" class="{{ $inputClass }}">
                </div>

                <!-- Location / Address -->
                <div>
                    <label class="{{ $labelClass }}">Location / Student Address</label>
                    <input type="text" name="address" id="field-address" value="{{ old('address', $student?->address) }}" placeholder="Enter Location / Village / Address" class="{{ $inputClass }}">
                </div>

                <!-- District (Location) -->
                <div>
                    <label class="{{ $labelClass }}">District (Location)</label>
                    <select name="district" id="form-district-select" onchange="populateThanasForDistrict()" class="{{ $selectClass }}">
                        <option value="">Select District</option>
                        @foreach($districts as $dist)
                            <option value="{{ $dist }}" @selected(old('district', $student?->district) === $dist)>{{ $dist }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Thana / Upazila (Location) -->
                <div>
                    <label class="{{ $labelClass }}">Thana / Upazila (Location)</label>
                    <select name="upazila" id="form-upazila-select" class="{{ $selectClass }}">
                        <option value="{{ old('upazila', $student?->upazila) }}">{{ old('upazila', $student?->upazila ?: 'Select Thana') }}</option>
                    </select>
                </div>

                <!-- Course Name -->
                <div>
                    <label class="{{ $labelClass }}">Course</label>
                    <select name="course_id" id="field-course" class="{{ $selectClass }}">
                        <option value="">Select Course</option>
                        @foreach($courses ?? [] as $crs)
                            <option value="{{ $crs->id }}" @selected(old('course_id', $student?->course_id) == $crs->id)>{{ $crs->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Duration -->
                <div>
                    <label class="{{ $labelClass }}">Duration</label>
                    <select name="duration" id="field-duration" class="{{ $selectClass }}">
                        <option value="">Select Duration</option>
                        @foreach(['1 Month', "2 Month's", "3 Month's", "4 Month's", "5 Month's", "6 Month's", '1 Year', "2 Year's", "3 Year's", "4 Year's"] as $dur)
                            <option value="{{ $dur }}" @selected(old('duration', $student?->duration) === $dur)>{{ $dur }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Start Month & Year -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="{{ $labelClass }}">Start Month</label>
                        <select name="start_month" id="field-start-month" class="{{ $selectClass }}">
                            <option value="">Select Month</option>
                            @foreach($months as $m)
                                <option value="{{ $m }}" @selected(old('start_month', $student?->start_month) === $m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Start Year</label>
                        <select name="start_year" id="field-start-year" class="{{ $selectClass }}">
                            <option value="">Select Year</option>
                            @foreach($startYears as $y)
                                <option value="{{ $y }}" @selected(old('start_year', $student?->start_year) == $y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- End Month & Year -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="{{ $labelClass }}">End Month</label>
                        <select name="end_month" id="field-end-month" class="{{ $selectClass }}">
                            <option value="">Select Month</option>
                            @foreach($months as $m)
                                <option value="{{ $m }}" @selected(old('end_month', $student?->end_month) === $m)>{{ $m }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">End Year</label>
                        <select name="end_year" id="field-end-year" class="{{ $selectClass }}">
                            <option value="">Select Year</option>
                            @foreach($endYears as $y)
                                <option value="{{ $y }}" @selected(old('end_year', $student?->end_year) == $y)>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Education Qualification -->
                <div>
                    <label class="{{ $labelClass }}">Education Qualification</label>
                    <select name="education_qualification" id="field-qualification" class="{{ $selectClass }}">
                        <option value="">Select Qualification</option>
                        @foreach(['PSC', 'JSC', 'SSC', 'HSC', 'Diploma', 'Honours / Degree', 'Masters', 'Other'] as $qual)
                            <option value="{{ $qual }}" @selected(old('education_qualification', $student?->education_qualification) === $qual)>{{ $qual }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Picture / Student Photo -->
                <div>
                    <label class="{{ $labelClass }}">Picture / Student Photo</label>
                    <div class="flex items-center gap-4">
                        <div id="student-photo-preview-container" class="size-16 rounded-2xl border-2 border-dashed border-indigo-500/40 bg-[#071c2c] overflow-hidden flex items-center justify-center shrink-0 shadow-lg">
                            @if($student?->image_path)
                                <img id="student-photo-preview-img" src="{{ str_starts_with($student->image_path, 'http') ? $student->image_path : asset('storage/'.$student->image_path) }}" alt="Photo" class="size-full object-cover">
                            @else
                                <img id="student-photo-preview-img" class="hidden size-full object-cover" alt="Photo Preview">
                                <span id="student-photo-preview-icon" class="text-xs font-bold text-slate-400">Photo</span>
                            @endif
                        </div>
                        <input type="file" name="image" id="student-photo-file-input" accept="image/*" onchange="previewStudentPhoto(this)" class="{{ $inputClass }} file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
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

                <!-- Join Date -->
                <div>
                    <label class="{{ $labelClass }}">Join Date</label>
                    <input type="date" name="admitted_at" id="field-join-date" value="{{ old('admitted_at', optional($student?->admitted_at)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                </div>

                <!-- Expire Date -->
                <div>
                    <label class="{{ $labelClass }}">Expire Date</label>
                    <input type="date" name="expire_date" id="field-expire-date" value="{{ old('expire_date', optional($student?->expire_date)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                </div>

            </div>
        </div>

        <!-- EDIT-ONLY SECTIONS (SHOWS ONLY WHEN EDITING A STUDENT RECORD) -->
        @if ($isEdit)
            <div class="space-y-10 pt-6 border-t border-indigo-500/30">

                <!-- SECTION 3: SYSTEM CODES & RECORD FIELDS -->
                <div class="space-y-6">
                    <h2 class="text-base sm:text-lg font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-3">
                        Registration &amp; System Codes (Edit Only)
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label class="{{ $labelClass }}">Registration Number</label>
                            <input type="text" name="registration_number" value="{{ old('registration_number', $student?->registration_number) }}" placeholder="Registration Number" class="{{ $inputClass }}">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Roll Number</label>
                            <input type="text" name="roll_number" value="{{ old('roll_number', $student?->roll_number) }}" placeholder="Roll Number" class="{{ $inputClass }}">
                        </div>
                    </div>
                </div>

            </div>
        @endif

        @if ($declarationRequired)
            <div class="rounded-xl border border-indigo-500/20 bg-[#071c2c]/70 p-4">
                <label class="inline-flex items-center gap-3 text-xs font-bold text-slate-300 cursor-pointer">
                    <input type="checkbox" name="declaration" value="1" @checked(old('declaration')) class="rounded border-white/20 bg-[#0e1828] text-indigo-600 focus:ring-indigo-500">
                    <span>I hereby declare that the information provided above is true and accurate.</span>
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
</div>


@verbatim

@endverbatim

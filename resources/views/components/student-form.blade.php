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
    $districts = config('bangladesh.districts', []);
@endphp

<div class="space-y-6" data-student-registration-container>

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
        @if(isset($errors) && $errors->any())
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 sm:p-5 text-rose-300 text-xs sm:text-sm">
                <ul class="list-disc pl-5 space-y-1 font-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- SECTION: BIOMETRIC AND DOCUMENT SCAN -->
        <div class="rounded-2xl border border-indigo-500/20 bg-[#071c2c] p-4 sm:p-6 shadow-xl space-y-6">
            <h3 class="text-center text-xs sm:text-sm font-black text-indigo-400 uppercase tracking-wider flex items-center justify-center gap-2">
                Biometric and Document Scan
            </h3>

            <!-- Alert banner for scanner status -->
            <div id="scan-status-alert" class="hidden rounded-xl bg-indigo-500/10 border border-indigo-500/30 p-3 text-center text-xs font-bold text-indigo-300">
                <span id="scan-status-msg"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">

                <!-- 1. PASSPORT SCANNER -->
                <div class="flex flex-col items-center justify-between p-4 sm:p-5 rounded-xl border border-white/5 bg-[#0a2036]/60 text-center space-y-4">
                    <div id="box-preview-passport" class="relative w-full h-32 rounded-xl border border-white/10 bg-[#0f2d48] overflow-hidden flex items-center justify-center p-2 shadow-inner">
                        <div class="flex items-center gap-2">
                            <div class="size-10 rounded-full bg-slate-700/60 border border-slate-500/30 flex items-center justify-center text-slate-300 text-xs font-bold">ID</div>
                            <div class="space-y-1 text-[9px] font-mono text-slate-300">
                                <div class="w-16 h-1.5 bg-slate-600/80 rounded"></div>
                                <div class="w-12 h-1.5 bg-slate-600/60 rounded"></div>
                                <div class="w-14 h-1.5 bg-slate-600/60 rounded"></div>
                            </div>
                        </div>
                        <div class="absolute inset-x-0 top-1/2 h-0.5 bg-rose-500 shadow-[0_0_12px_#f43f5e] animate-pulse"></div>
                    </div>

                    <div class="space-y-2 w-full">
                        <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wide">Passport Scanner</h4>
                        <div class="grid grid-cols-2 gap-2 w-full">
                            <button type="button" onclick="window.openDocumentScanner('Passport')" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-2.5 py-2.5 text-[11px] font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span id="btn-text-passport">Camera</span>
                            </button>
                            <label for="file-input-passport" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-2.5 py-2.5 text-[11px] font-bold uppercase tracking-wider cursor-pointer shadow transition-all active:scale-95">
                                📁 File/PDF
                                <input type="file" id="file-input-passport" accept="image/*,application/pdf,.pdf" class="sr-only" onchange="window.handleDocumentFileChange(this, 'Passport')">
                            </label>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">Place Passport Page in View (Image or PDF).</p>
                    </div>
                </div>

                <!-- 2. NID CARD SCANNER -->
                <div class="flex flex-col items-center justify-between p-4 sm:p-5 rounded-xl border border-white/5 bg-[#0a2036]/60 text-center space-y-4">
                    <div id="box-preview-nid" class="relative w-full h-32 rounded-xl border border-white/10 bg-[#0f2d48] overflow-hidden flex items-center justify-center p-2 shadow-inner">
                        <div class="flex items-center gap-2">
                            <div class="size-10 rounded bg-cyan-700/40 border border-cyan-500/30 flex items-center justify-center text-cyan-300 text-xs font-bold">NID</div>
                            <div class="space-y-1 text-[9px] font-mono text-slate-300">
                                <div class="w-16 h-1.5 bg-cyan-600/80 rounded"></div>
                                <div class="w-12 h-1.5 bg-cyan-600/60 rounded"></div>
                                <div class="w-14 h-1.5 bg-cyan-600/60 rounded"></div>
                            </div>
                        </div>
                        <div class="absolute inset-x-0 top-1/2 h-0.5 bg-cyan-400 shadow-[0_0_12px_#22d3ee] animate-pulse"></div>
                    </div>

                    <div class="space-y-2 w-full">
                        <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wide">NID Card Scanner</h4>
                        <div class="grid grid-cols-2 gap-2 w-full">
                            <button type="button" onclick="window.openDocumentScanner('NID Card')" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white px-2.5 py-2.5 text-[11px] font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span id="btn-text-nid">Camera</span>
                            </button>
                            <label for="file-input-nid" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-2.5 py-2.5 text-[11px] font-bold uppercase tracking-wider cursor-pointer shadow transition-all active:scale-95">
                                📁 File/PDF
                                <input type="file" id="file-input-nid" accept="image/*,application/pdf,.pdf" class="sr-only" onchange="window.handleDocumentFileChange(this, 'NID Card')">
                            </label>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">Place NID Card Data Page in View (Image or PDF).</p>
                    </div>
                </div>

                <!-- 3. BIRTH REGISTRATION CERTIFICATE SCANNER -->
                <div class="flex flex-col items-center justify-between p-4 sm:p-5 rounded-xl border border-white/5 bg-[#0a2036]/60 text-center space-y-4">
                    <div id="box-preview-birth" class="relative w-full h-32 rounded-xl border border-white/10 bg-[#0f2d48] overflow-hidden flex items-center justify-center p-2 shadow-inner">
                        <div class="flex items-center gap-2">
                            <div class="size-10 rounded bg-violet-700/40 border border-violet-500/30 flex items-center justify-center text-violet-300 text-xs font-bold">BR</div>
                            <div class="space-y-1 text-[9px] font-mono text-slate-300">
                                <div class="w-16 h-1.5 bg-violet-500/80 rounded"></div>
                                <div class="w-12 h-1.5 bg-violet-500/60 rounded"></div>
                                <div class="w-14 h-1.5 bg-violet-500/60 rounded"></div>
                            </div>
                        </div>
                        <div class="absolute inset-x-0 top-1/2 h-0.5 bg-violet-400 shadow-[0_0_12px_#c084fc] animate-pulse"></div>
                    </div>

                    <div class="space-y-2 w-full">
                        <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wide">Birth Registration Scanner</h4>
                        <div class="grid grid-cols-2 gap-2 w-full">
                            <button type="button" onclick="window.openDocumentScanner('Birth Registration')" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-violet-600 hover:bg-violet-500 text-white px-2.5 py-2.5 text-[11px] font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span id="btn-text-birth">Camera</span>
                            </button>
                            <label for="file-input-birth" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-2.5 py-2.5 text-[11px] font-bold uppercase tracking-wider cursor-pointer shadow transition-all active:scale-95">
                                📁 File/PDF
                                <input type="file" id="file-input-birth" accept="image/*,application/pdf,.pdf" class="sr-only" onchange="window.handleDocumentFileChange(this, 'Birth Registration')">
                            </label>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">Place Birth Certificate in View (Image or PDF).</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- CAMERA SCANNER MODAL -->
        <div id="doc-camera-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
            <div class="w-full max-w-lg rounded-2xl border border-indigo-500/30 bg-[#071c2c] p-5 shadow-2xl space-y-4 relative">
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="size-3 rounded-full bg-rose-500 animate-ping"></span>
                        <h3 id="camera-modal-title" class="text-sm font-black text-indigo-300 uppercase tracking-wider">
                            Live Scanner
                        </h3>
                    </div>
                    <button type="button" onclick="window.closeDocCameraModal()" class="rounded-lg bg-white/10 px-2.5 py-1 text-slate-300 hover:bg-white/20 hover:text-white transition-all cursor-pointer">
                        ✕
                    </button>
                </div>

                <div class="relative w-full h-64 sm:h-80 rounded-xl overflow-hidden bg-black border border-white/10 shadow-inner flex items-center justify-center">
                    <video id="camera-feed" autoplay playsinline class="size-full object-cover"></video>
                    <canvas id="camera-canvas" class="hidden"></canvas>

                    <div class="absolute inset-0 pointer-events-none border-2 border-indigo-500/40 rounded-xl flex items-center justify-center">
                        <div class="w-5/6 h-3/4 border-2 border-dashed border-indigo-400/80 rounded-lg relative">
                            <div class="w-full h-0.5 bg-indigo-400 shadow-[0_0_15px_#818cf8] animate-pulse absolute top-1/2"></div>
                        </div>
                    </div>

                    <p id="camera-loading-text" class="absolute text-xs font-bold text-slate-300 bg-slate-900/80 px-3 py-1.5 rounded-lg border border-white/10">
                        Initializing Camera...
                    </p>
                </div>

                <div class="flex items-center justify-between gap-3 pt-2">
                    <button type="button" onclick="window.switchCameraFacing()" class="inline-flex items-center gap-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-slate-200 px-3.5 py-2.5 text-xs font-bold uppercase transition-all cursor-pointer">
                        Flip
                    </button>

                    <button type="button" onclick="window.captureCameraPhoto()" class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 text-xs font-black uppercase tracking-wider shadow-lg transition-all active:scale-95 cursor-pointer">
                        Capture & Scan
                    </button>

                    <button type="button" onclick="window.triggerFileFallbackFromModal()" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-3.5 py-2.5 text-xs font-bold uppercase transition-all cursor-pointer">
                        Upload
                    </button>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-8 sm:space-y-10" id="student-form">
            @csrf
            @if (strtoupper($method) !== 'POST') @method($method) @endif

            <!-- SECTION 1: REGISTRATION FIELDS -->
            <div class="space-y-6">
                <h2 class="text-base sm:text-lg font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-3">
                    Student Details & Location
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="{{ $labelClass }}">Student Name</label>
                        <input type="text" name="name" id="field-name" value="{{ old('name', $student?->name) }}" placeholder="Enter Full Name" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Father's Name</label>
                        <input type="text" name="father_name" id="field-father-name" value="{{ old('father_name', $student?->father_name) }}" placeholder="Enter Father's Name" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Mother's Name</label>
                        <input type="text" name="mother_name" id="field-mother-name" value="{{ old('mother_name', $student?->mother_name) }}" placeholder="Enter Mother's Name" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Birthday / Date of Birth</label>
                        <input type="date" name="date_of_birth" id="field-dob" value="{{ old('date_of_birth', optional($student?->date_of_birth)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Gender</label>
                        <select name="gender" id="field-gender" class="{{ $selectClass }}">
                            <option value="Male" @selected(old('gender', $student?->gender ?? 'Male') === 'Male')>Male</option>
                            <option value="Female" @selected(old('gender', $student?->gender) === 'Female')>Female</option>
                            <option value="Other" @selected(old('gender', $student?->gender) === 'Other')>Other</option>
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Passport / NID / Birth Reg. Number</label>
                        <input type="text" name="passport_nid_number" id="field-passport" value="{{ old('passport_nid_number', $student?->passport_nid_number) }}" placeholder="Or Enter Passport/NID/Birth Reg manually" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Guardian Phone</label>
                        <input type="text" name="phone" id="field-phone" value="{{ old('phone', $student?->phone) }}" placeholder="Enter Mobile Number" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Location / Student Address</label>
                        <input type="text" name="address" id="field-address" value="{{ old('address', $student?->address) }}" placeholder="Enter Location / Village / Address" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">District (Location)</label>
                        <select name="district" id="form-district-select" class="{{ $selectClass }}">
                            <option value="">Select District</option>
                            @foreach($districts as $dist)
                                <option value="{{ $dist }}" @selected(old('district', $student?->district) === $dist)>{{ $dist }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Thana / Upazila (Location)</label>
                        <select name="upazila" id="form-upazila-select" class="{{ $selectClass }}">
                            <option value="{{ old('upazila', $student?->upazila) }}">{{ old('upazila', $student?->upazila ?: 'Select Thana') }}</option>
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Course</label>
                        <select name="course_id" class="{{ $selectClass }}">
                            <option value="">Select Course</option>
                            @foreach($courses ?? [] as $crs)
                                <option value="{{ $crs->id }}" @selected(old('course_id', $student?->course_id) == $crs->id)>{{ $crs->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Duration</label>
                        <select name="duration" class="{{ $selectClass }}">
                            <option value="">Select Duration</option>
                            @foreach(['1 Month', "2 Month's", "3 Month's", "4 Month's", "5 Month's", "6 Month's", '1 Year', "2 Year's", "3 Year's", "4 Year's"] as $dur)
                                <option value="{{ $dur }}" @selected(old('duration', $student?->duration) === $dur)>{{ $dur }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="{{ $labelClass }}">Start Month</label>
                            <select name="start_month" class="{{ $selectClass }}">
                                <option value="">Select Month</option>
                                @foreach($months as $m)
                                    <option value="{{ $m }}" @selected(old('start_month', $student?->start_month) === $m)>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Start Year</label>
                            <select name="start_year" class="{{ $selectClass }}">
                                <option value="">Select Year</option>
                                @foreach($startYears as $y)
                                    <option value="{{ $y }}" @selected(old('start_year', $student?->start_year) == $y)>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="{{ $labelClass }}">End Month</label>
                            <select name="end_month" class="{{ $selectClass }}">
                                <option value="">Select Month</option>
                                @foreach($months as $m)
                                    <option value="{{ $m }}" @selected(old('end_month', $student?->end_month) === $m)>{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">End Year</label>
                            <select name="end_year" class="{{ $selectClass }}">
                                <option value="">Select Year</option>
                                @foreach($endYears as $y)
                                    <option value="{{ $y }}" @selected(old('end_year', $student?->end_year) == $y)>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Education Qualification</label>
                        <select name="education_qualification" class="{{ $selectClass }}">
                            <option value="">Select Qualification</option>
                            @foreach(['PSC', 'JSC', 'SSC', 'HSC', 'Diploma', 'Honours / Degree', 'Masters', 'Other'] as $qual)
                                <option value="{{ $qual }}" @selected(old('education_qualification', $student?->education_qualification) === $qual)>{{ $qual }}</option>
                            @endforeach
                        </select>
                    </div>

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
                            <input type="file" name="image" id="student-photo-file-input" accept="image/*" onchange="window.previewStudentPhoto(this)" class="{{ $inputClass }} file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
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
                        <label class="{{ $labelClass }}">Join Date</label>
                        <input type="date" name="admitted_at" value="{{ old('admitted_at', optional($student?->admitted_at)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                    </div>
                    <div>
                        <label class="{{ $labelClass }}">Expire Date</label>
                        <input type="date" name="expire_date" value="{{ old('expire_date', optional($student?->expire_date)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/10">
                @if($cancelRoute)
                    <a href="{{ $cancelRoute }}" class="rounded-xl bg-white/10 hover:bg-white/20 px-5 py-3 text-xs font-bold uppercase text-slate-300 transition-all">
                        Cancel
                    </a>
                @endif
                <button type="submit" class="rounded-xl bg-indigo-600 hover:bg-indigo-500 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-lg transition-all cursor-pointer">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    let activeDocType = null;
    let cameraStream = null;
    let facingMode = 'environment';

    const blockedNamePatterns = [
        /\bnational\s*id\b/i,
        /\bemergency\s*contact\b/i,
        /\bnid\s*data\b/i,
        /\bsurname\b/i,
        /\bgiven\s*name\b/i,
        /\bpassport\s*no\b/i,
        /\bdate\s*of\s*birth\b/i,
        /\bnationality\b/i,
        /\bauthority\b/i,
        /\bdocument\s*no\b/i,
        /naidataandemergencycontact/i
    ];

    function setScanStatus(msg, isError = false) {
        const box = document.getElementById('scan-status-alert');
        const txt = document.getElementById('scan-status-msg');
        if (!box || !txt) return;
        box.classList.remove('hidden', 'border-rose-500/30', 'bg-rose-500/10', 'text-rose-300', 'border-indigo-500/30', 'bg-indigo-500/10', 'text-indigo-300');
        if (isError) {
            box.classList.add('border-rose-500/30', 'bg-rose-500/10', 'text-rose-300');
        } else {
            box.classList.add('border-indigo-500/30', 'bg-indigo-500/10', 'text-indigo-300');
        }
        txt.textContent = msg;
    }

    function updatePreviewBox(docType, dataUrl) {
        const map = {
            'Passport': 'box-preview-passport',
            'NID Card': 'box-preview-nid',
            'Birth Registration': 'box-preview-birth'
        };
        const el = document.getElementById(map[docType]);
        if (!el || !dataUrl) return;
        el.innerHTML = `<img src="${dataUrl}" alt="${docType}" class="size-full object-contain rounded-lg">`;
    }

    function cleanAddressText(rawAddr) {
        if (!rawAddr) return '';
        let cleaned = rawAddr
            .replace(/\s+/g, ' ')
            .replace(/,\s*,+/g, ', ')
            .replace(/\b([A-Za-z])\s+([A-Za-z])\s*$/g, '')
            .replace(/\s+[-–]\s*$/, '')
            .trim();
        cleaned = cleaned.replace(/\b([A-Za-z]+),\s*\1\b/gi, '$1');
        return cleaned;
    }

    function isValidPersonName(candidate) {
        if (!candidate) return false;
        const s = candidate.trim();
        if (s.length < 3 || s.length > 70) return false;
        if (/\d/.test(s)) return false;
        if (blockedNamePatterns.some((rx) => rx.test(s))) return false;
        const words = s.split(/\s+/).filter(Boolean);
        return words.length >= 1 && words.length <= 6;
    }

    function parsePassportMRZ(text) {
        const lines = text
            .split(/\r?\n/)
            .map((l) => l.replace(/\s+/g, '').toUpperCase())
            .filter((l) => l.includes('<') && l.length >= 25);

        let name = '';
        let passportNo = '';
        let dob = '';

        const mrz1 = lines.find((l) => l.startsWith('P<') || l.includes('<<'));
        if (mrz1) {
            const afterCountry = mrz1.replace(/^P<[A-Z<]{3}/, '');
            const parts = afterCountry.split('<<');
            const surname = (parts[0] || '').replace(/<+/g, ' ').trim();
            const givenNames = (parts[1] || '').replace(/<+/g, ' ').trim();
            const full = `${givenNames} ${surname}`.trim();
            if (isValidPersonName(full)) {
                name = full.replace(/\b\w+/g, (w) => w.charAt(0) + w.slice(1).toLowerCase());
            }
        }

        const mrz2 = lines.find((l) => l !== mrz1 && /[A-Z0-9<]{20,}/.test(l));
        if (mrz2) {
            const passMatch = mrz2.match(/^([A-Z0-9<]{7,9})</);
            if (passMatch) {
                passportNo = passMatch[1].replace(/<+$/, '');
            }
            const dobMatch = mrz2.match(/^[A-Z0-9<]{9,13}[MF<](\d{6})[0-9<][MF<]/);
            if (dobMatch) {
                const yymmdd = dobMatch[1];
                const yy = parseInt(yymmdd.slice(0, 2), 10);
                const mm = yymmdd.slice(2, 4);
                const dd = yymmdd.slice(4, 6);
                const currentYY = 26;
                const yyyy = yy <= currentYY ? `20${yymmdd.slice(0, 2)}` : `19${yymmdd.slice(0, 2)}`;
                dob = `${yyyy}-${mm}-${dd}`;
            }
        }

        return { name, passportNo, dob };
    }

    function parseDocumentText(rawText, docType) {
        const lines = rawText
            .split(/\r?\n/)
            .map((l) => l.trim())
            .filter(Boolean);

        const result = {
            name: '',
            father_name: '',
            mother_name: '',
            date_of_birth: '',
            passport_nid_number: '',
            phone: '',
            address: '',
            district: ''
        };

        const phoneMatch = rawText.match(/(?:\+?88)?01[3-9]\d{8}/);
        if (phoneMatch) {
            result.phone = phoneMatch[0].replace(/^\+?88/, '');
        }

        const dobMatch = rawText.match(/\b(\d{2})[\/\-](\d{2})[\/\-](\d{4})\b/) || rawText.match(/\b(\d{4})[\/\-](\d{2})[\/\-](\d{2})\b/);
        if (dobMatch) {
            if (dobMatch[1].length === 4) {
                result.date_of_birth = `${dobMatch[1]}-${dobMatch[2]}-${dobMatch[3]}`;
            } else {
                const day = parseInt(dobMatch[1], 10);
                const month = parseInt(dobMatch[2], 10);
                const year = dobMatch[3];
                if (month >= 1 && month <= 12 && day >= 1 && day <= 31) {
                    result.date_of_birth = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                }
            }
        }

        for (let i = 0; i < lines.length; i++) {
            const line = lines[i];
            const nextLine = lines[i + 1] || '';

            if (/^(?:name|full\s*name|student\s*name)\s*[:\-]?\s*(.*)$/i.test(line)) {
                const m = line.match(/^(?:name|full\s*name|student\s*name)\s*[:\-]?\s*(.*)$/i);
                const val = (m && m[1]) ? m[1].trim() : nextLine;
                if (isValidPersonName(val)) result.name = val;
            }

            if (/^(?:father(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i.test(line)) {
                const m = line.match(/^(?:father(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i);
                const val = (m && m[1]) ? m[1].trim() : nextLine;
                if (isValidPersonName(val)) result.father_name = val;
            }

            if (/^(?:mother(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i.test(line)) {
                const m = line.match(/^(?:mother(?:'s)?\s*name)\s*[:\-]?\s*(.*)$/i);
                const val = (m && m[1]) ? m[1].trim() : nextLine;
                if (isValidPersonName(val)) result.mother_name = val;
            }

            if (/(?:address|location|vill|village|post|upazila|zila|district)/i.test(line) && line.length > 10) {
                const addrVal = line.replace(/^(?:address|location)\s*[:\-]?\s*/i, '');
                if (!result.address || addrVal.length > result.address.length) {
                    result.address = cleanAddressText(addrVal);
                }
            }
        }

        if (docType === 'Passport') {
            const mrz = parsePassportMRZ(rawText);
            if (mrz.name) result.name = mrz.name;
            if (mrz.passportNo) result.passport_nid_number = mrz.passportNo;
            if (mrz.dob) result.date_of_birth = mrz.dob;
        }

        if (!result.passport_nid_number) {
            const passNo = rawText.match(/\b[A-Z]{1,2}\d{7,8}\b/);
            const nidNo = rawText.match(/\b(?:\d{10}|\d{13}|\d{17})\b/);
            if (docType === 'Passport' && passNo) {
                result.passport_nid_number = passNo[0];
            } else if (nidNo) {
                result.passport_nid_number = nidNo[0];
            } else if (passNo) {
                result.passport_nid_number = passNo[0];
            }
        }

        const distSelect = document.getElementById('form-district-select');
        if (distSelect) {
            const options = Array.from(distSelect.options).map((o) => o.value).filter(Boolean);
            const matchedDist = options.find((d) => new RegExp(`\\b${d}\\b`, 'i').test(rawText));
            if (matchedDist) {
                result.district = matchedDist;
            }
        }

        return result;
    }

    function applyParsedDataToForm(data, docType) {
        if (data.name && isValidPersonName(data.name)) {
            const el = document.getElementById('field-name');
            if (el) el.value = data.name;
        }
        if (data.father_name && isValidPersonName(data.father_name)) {
            const el = document.getElementById('field-father-name');
            if (el) el.value = data.father_name;
        }
        if (data.mother_name && isValidPersonName(data.mother_name)) {
            const el = document.getElementById('field-mother-name');
            if (el) el.value = data.mother_name;
        }
        if (data.date_of_birth) {
            const el = document.getElementById('field-dob');
            if (el) el.value = data.date_of_birth;
        }
        if (data.passport_nid_number) {
            const el = document.getElementById('field-passport');
            if (el) el.value = data.passport_nid_number;
        }
        if (data.phone) {
            const el = document.getElementById('field-phone');
            if (el) el.value = data.phone;
        }
        if (data.address) {
            const el = document.getElementById('field-address');
            if (el) el.value = cleanAddressText(data.address);
        }
        if (data.district) {
            const distEl = document.getElementById('form-district-select');
            if (distEl) {
                distEl.value = data.district;
                distEl.dispatchEvent(new Event('change'));
            }
        }

        if (docType === 'Passport' && (!data.father_name || !data.mother_name)) {
            setScanStatus('Passport scanned. Note: Father/Mother names are usually not printed on Passport bio pages—scan NID or Birth Certificate if needed.');
        } else {
            setScanStatus(`${docType} scanned and form fields updated.`);
        }
    }

    function loadScriptOnce(src) {
        return new Promise((resolve, reject) => {
            const existing = document.querySelector(`script[src="${src}"]`);
            if (existing) {
                if (existing.dataset.loaded === 'true') return resolve();
                existing.addEventListener('load', () => resolve(), { once: true });
                existing.addEventListener('error', reject, { once: true });
                return;
            }
            const s = document.createElement('script');
            s.src = src;
            s.async = true;
            s.onload = () => {
                s.dataset.loaded = 'true';
                resolve();
            };
            s.onerror = reject;
            document.head.appendChild(s);
        });
    }

    async function ensureOcrLibs() {
        if (!window.pdfjsLib) {
            await loadScriptOnce('https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js');
        }
        if (window.pdfjsLib && !pdfjsLib.GlobalWorkerOptions.workerSrc) {
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
        }
        if (!window.Tesseract) {
            await loadScriptOnce('https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js');
        }
    }

    async function pdfFileToDataUrl(file) {
        await ensureOcrLibs();
        const arrayBuffer = await file.arrayBuffer();
        const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
        const page = await pdf.getPage(1);
        const viewport = page.getViewport({ scale: 2.0 });
        const canvas = document.createElement('canvas');
        canvas.width = viewport.width;
        canvas.height = viewport.height;
        const ctx = canvas.getContext('2d');
        await page.render({ canvasContext: ctx, viewport }).promise;
        return canvas.toDataURL('image/png');
    }

    async function runOcrOnImageDataUrl(dataUrl, docType) {
        setScanStatus(`Loading OCR & scanning ${docType}...`);
        await ensureOcrLibs();
        const { data } = await Tesseract.recognize(dataUrl, 'eng');
        const parsed = parseDocumentText(data.text || '', docType);
        applyParsedDataToForm(parsed, docType);
    }

    window.handleDocumentFileChange = async function (input, docType) {
        const file = input.files && input.files[0];
        if (!file) return;

        try {
            let dataUrl = '';
            if (file.type === 'application/pdf' || /\.pdf$/i.test(file.name)) {
                setScanStatus(`Rendering PDF page for ${docType}...`);
                dataUrl = await pdfFileToDataUrl(file);
            } else {
                dataUrl = await new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            }

            updatePreviewBox(docType, dataUrl);
            await runOcrOnImageDataUrl(dataUrl, docType);
        } catch (err) {
            console.error(err);
            setScanStatus(`Failed to process ${docType} file: ${err.message || err}`, true);
        } finally {
            input.value = '';
        }
    };

    window.openDocumentScanner = async function (docType) {
        activeDocType = docType;
        const modal = document.getElementById('doc-camera-modal');
        const title = document.getElementById('camera-modal-title');
        const loading = document.getElementById('camera-loading-text');
        const video = document.getElementById('camera-feed');

        if (title) title.textContent = `${docType} Live Scanner`;
        if (loading) {
            loading.textContent = 'Initializing Camera...';
            loading.classList.remove('hidden');
        }
        if (modal) modal.classList.remove('hidden');

        try {
            if (cameraStream) {
                cameraStream.getTracks().forEach((t) => t.stop());
            }
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode },
                audio: false
            });
            if (video) {
                video.srcObject = cameraStream;
                video.onloadedmetadata = () => {
                    if (loading) loading.classList.add('hidden');
                };
            }
        } catch (err) {
            console.error(err);
            if (loading) loading.textContent = 'Camera unavailable. Use Upload button.';
        }
    };

    window.closeDocCameraModal = function () {
        const modal = document.getElementById('doc-camera-modal');
        if (modal) modal.classList.add('hidden');
        if (cameraStream) {
            cameraStream.getTracks().forEach((t) => t.stop());
            cameraStream = null;
        }
    };

    window.switchCameraFacing = async function () {
        facingMode = facingMode === 'environment' ? 'user' : 'environment';
        if (activeDocType) {
            await window.openDocumentScanner(activeDocType);
        }
    };

    window.captureCameraPhoto = async function () {
        const video = document.getElementById('camera-feed');
        const canvas = document.getElementById('camera-canvas');
        if (!video || !canvas || !activeDocType) return;

        canvas.width = video.videoWidth || 1280;
        canvas.height = video.videoHeight || 720;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/png');
        const docType = activeDocType;
        window.closeDocCameraModal();
        updatePreviewBox(docType, dataUrl);
        await runOcrOnImageDataUrl(dataUrl, docType);
    };

    window.triggerFileFallbackFromModal = function () {
        const docType = activeDocType;
        window.closeDocCameraModal();
        const inputMap = {
            'Passport': 'file-input-passport',
            'NID Card': 'file-input-nid',
            'Birth Registration': 'file-input-birth'
        };
        const input = document.getElementById(inputMap[docType]);
        if (input) input.click();
    };

    window.previewStudentPhoto = function (input) {
        const file = input.files && input.files[0];
        const img = document.getElementById('student-photo-preview-img');
        const icon = document.getElementById('student-photo-preview-icon');
        if (!file || !img) return;

        const reader = new FileReader();
        reader.onload = (e) => {
            img.src = e.target.result;
            img.classList.remove('hidden');
            if (icon) icon.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    };
})();
</script>

@props([
    'student' => null,
    'courses',
    'action',
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
        @if($errors->any())
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 sm:p-5 text-rose-300 text-xs sm:text-sm">
                <ul class="list-disc pl-5 space-y-1 font-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- SECTION: BIOMETRIC AND DOCUMENT SCAN (PASSPORT, NID & BIRTH CERTIFICATE SCANNERS) -->
        <div class="rounded-2xl border border-indigo-500/20 bg-[#071c2c] p-4 sm:p-6 shadow-xl space-y-6">
            <h3 class="text-center text-xs sm:text-sm font-black text-indigo-400 uppercase tracking-wider flex items-center justify-center gap-2">
                <svg class="size-5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                </svg>
                Biometric and Document Scan
            </h3>

            <!-- Alert banner for scanner status -->
            <div id="scan-status-alert" class="hidden rounded-xl bg-indigo-500/10 border border-indigo-500/30 p-3 text-center text-xs font-bold text-indigo-300">
                <span id="scan-status-msg"></span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">

                <!-- 1. PASSPORT SCANNER -->
                <div class="flex flex-col items-center justify-between p-4 sm:p-5 rounded-xl border border-white/5 bg-[#0a2036]/60 text-center space-y-4">
                    <div id="box-preview-passport" class="relative w-full h-32 rounded-xl border border-white/10 bg-[#0f2d48] overflow-hidden flex items-center justify-center p-2 group shadow-inner">
                        <div class="flex items-center gap-2">
                            <div class="size-10 rounded-full bg-slate-700/60 border border-slate-500/30 flex items-center justify-center text-slate-400">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>
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
                            <button type="button" onclick="openDocumentScanner('Passport')" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-2.5 py-2.5 text-[11px] font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                </svg>
                                <span id="btn-text-passport">Camera</span>
                            </button>
                            <label for="file-input-passport" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-2.5 py-2.5 text-[11px] font-bold uppercase tracking-wider cursor-pointer shadow transition-all active:scale-95">
                                📁 File/PDF
                                <input type="file" id="file-input-passport" accept="image/*,application/pdf,.pdf" class="sr-only" onchange="handleDocumentFileChange(this, 'Passport')">
                            </label>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">Place Passport Page in View (Image or PDF).</p>
                    </div>
                </div>

                <!-- 2. NID CARD SCANNER -->
                <div class="flex flex-col items-center justify-between p-4 sm:p-5 rounded-xl border border-white/5 bg-[#0a2036]/60 text-center space-y-4">
                    <div id="box-preview-nid" class="relative w-full h-32 rounded-xl border border-white/10 bg-[#0f2d48] overflow-hidden flex items-center justify-center p-2 group shadow-inner">
                        <div class="flex items-center gap-2">
                            <div class="size-10 rounded bg-cyan-700/40 border border-cyan-500/30 flex items-center justify-center text-cyan-300">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zM7.5 15a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                                </svg>
                            </div>
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
                            <button type="button" onclick="openDocumentScanner('NID Card')" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white px-2.5 py-2.5 text-[11px] font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zM7.5 15a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" />
                                </svg>
                                <span id="btn-text-nid">Camera</span>
                            </button>
                            <label for="file-input-nid" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-2.5 py-2.5 text-[11px] font-bold uppercase tracking-wider cursor-pointer shadow transition-all active:scale-95">
                                📁 File/PDF
                                <input type="file" id="file-input-nid" accept="image/*,application/pdf,.pdf" class="sr-only" onchange="handleDocumentFileChange(this, 'NID Card')">
                            </label>
                        </div>
                        <p class="text-[11px] text-slate-400 font-medium">Place NID Card Data Page in View (Image or PDF).</p>
                    </div>
                </div>

                <!-- 3. BIRTH REGISTRATION CERTIFICATE SCANNER -->
                <div class="flex flex-col items-center justify-between p-4 sm:p-5 rounded-xl border border-white/5 bg-[#0a2036]/60 text-center space-y-4">
                    <div id="box-preview-birth" class="relative w-full h-32 rounded-xl border border-white/10 bg-[#0f2d48] overflow-hidden flex items-center justify-center p-2 group shadow-inner">
                        <div class="flex items-center gap-2">
                            <div class="size-10 rounded bg-violet-700/40 border border-violet-500/30 flex items-center justify-center text-violet-300">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.75 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                            </div>
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
                            <button type="button" onclick="openDocumentScanner('Birth Registration')" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-violet-600 hover:bg-violet-500 text-white px-2.5 py-2.5 text-[11px] font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span id="btn-text-birth">Camera</span>
                            </button>
                            <label for="file-input-birth" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-2.5 py-2.5 text-[11px] font-bold uppercase tracking-wider cursor-pointer shadow transition-all active:scale-95">
                                📁 File/PDF
                                <input type="file" id="file-input-birth" accept="image/*,application/pdf,.pdf" class="sr-only" onchange="handleDocumentFileChange(this, 'Birth Registration')">
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

                <!-- Modal Header -->
                <div class="flex items-center justify-between border-b border-white/10 pb-3">
                    <div class="flex items-center gap-2">
                        <span class="size-3 rounded-full bg-rose-500 animate-ping"></span>
                        <h3 id="camera-modal-title" class="text-sm font-black text-indigo-300 uppercase tracking-wider">
                            Live Scanner
                        </h3>
                    </div>
                    <button type="button" onclick="closeDocCameraModal()" class="rounded-lg bg-white/10 p-2 text-slate-300 hover:bg-white/20 hover:text-white transition-all">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Camera Viewfinder -->
                <div class="relative w-full h-64 sm:h-80 rounded-xl overflow-hidden bg-black border border-white/10 shadow-inner flex items-center justify-center">
                    <video id="camera-feed" autoplay playsinline class="size-full object-cover"></video>
                    <canvas id="camera-canvas" class="hidden"></canvas>

                    <!-- Scanning Overlay -->
                    <div class="absolute inset-0 pointer-events-none border-2 border-indigo-500/40 rounded-xl flex items-center justify-center">
                        <div class="w-5/6 h-3/4 border-2 border-dashed border-indigo-400/80 rounded-lg relative">
                            <!-- Corner target brackets -->
                            <div class="absolute -top-1 -left-1 size-4 border-t-2 border-l-2 border-indigo-400"></div>
                            <div class="absolute -top-1 -right-1 size-4 border-t-2 border-r-2 border-indigo-400"></div>
                            <div class="absolute -bottom-1 -left-1 size-4 border-b-2 border-l-2 border-indigo-400"></div>
                            <div class="absolute -bottom-1 -right-1 size-4 border-b-2 border-r-2 border-indigo-400"></div>
                            <!-- Laser line -->
                            <div class="w-full h-0.5 bg-indigo-400 shadow-[0_0_15px_#818cf8] animate-pulse absolute top-1/2"></div>
                        </div>
                    </div>

                    <p id="camera-loading-text" class="absolute text-xs font-bold text-slate-300 bg-slate-900/80 px-3 py-1.5 rounded-lg border border-white/10">
                        Initializing Camera...
                    </p>
                </div>

                <!-- Camera Action Controls -->
                <div class="flex items-center justify-between gap-3 pt-2">
                    <button type="button" onclick="switchCameraFacing()" class="inline-flex items-center gap-1.5 rounded-xl bg-white/10 hover:bg-white/20 text-slate-200 px-3.5 py-2.5 text-xs font-bold uppercase transition-all">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M160 224s-32-64-32-96a96 96 0 11192 0c0 32-32 96-32 96s-32-64-32-96a32 32 0 10-64 0c0 32-32 96-32 96z" />
                        </svg>
                        Flip
                    </button>

                    <button type="button" onclick="captureCameraPhoto()" class="flex-1 inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-5 py-3 text-xs font-black uppercase tracking-wider shadow-lg transition-all active:scale-95">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="9" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        Capture & Scan
                    </button>

                    <button type="button" onclick="triggerFileFallbackFromModal()" class="inline-flex items-center gap-1.5 rounded-xl bg-slate-700 hover:bg-slate-600 text-white px-3.5 py-2.5 text-xs font-bold uppercase transition-all">
                        Upload
                    </button>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="space-y-8 sm:space-y-10" id="student-form">
            @csrf
            @if ($method !== 'POST') @method($method) @endif

            <!-- SECTION 1: REGISTRATION FIELDS -->
            <div class="space-y-6">
                <h2 class="text-base sm:text-lg font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-3">
                    Student Details & Location
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
                        <select name="district" id="form-district-select" class="{{ $selectClass }}">
                            <option value="">Select District</option>
                            @foreach(config('bangladesh.districts') as $dist)
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
                        <select name="course_id" class="{{ $selectClass }}">
                            <option value="">Select Course</option>
                            @foreach($courses ?? [] as $crs)
                                <option value="{{ $crs->id }}" @selected(old('course_id', $student?->course_id) == $crs->id)>{{ $crs->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="{{ $labelClass }}">Duration</label>
                        <select name="duration" class="{{ $selectClass }}">
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

                    <!-- End Month & Year -->
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

                    <!-- Education Qualification -->
                    <div>
                        <label class="{{ $labelClass }}">Education Qualification</label>
                        <select name="education_qualification" class="{{ $selectClass }}">
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
                        <input type="date" name="admitted_at" value="{{ old('admitted_at', optional($student?->admitted_at)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                    </div>

                    <!-- Expire Date -->
                    <div>
                        <label class="{{ $labelClass }}">Expire Date</label>
                        <input type="date" name="expire_date" value="{{ old('expire_date', optional($student?->expire_date)->format('Y-m-d')) }}" class="{{ $inputClass }}">
                    </div>

                </div>
            </div>

            <!-- EDIT-ONLY SECTIONS (SHOWS ONLY WHEN EDITING A STUDENT RECORD) -->
            @if ($isEdit)
                <div class="space-y-10 pt-6 border-t border-indigo-500/30">

                    <!-- SECTION 3: SYSTEM CODES & RECORD FIELDS -->
                    <div class="space-y-6">
                        <h2 class="text-base sm:text-lg font-black text-indigo-400 uppercase tracking-wider border-b border-white/10 pb-3">
                            Registration & System Codes (Edit Only)
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                            <!-- Branch ID -->
                            <div>
                                <label class="{{ $labelClass }}">Branch ID</label>
                                <input type="text" name="branch_id" value="{{ old('branch_id', $student?->branch_id) }}" placeholder="Branch Code" class="{{ $inputClass }}">
                            </div>

                            <!-- Student Registration Number -->
                            <div>
                                <label class="{{ $labelClass }}">Student Registration Number</label>
                                <input type="text" name="registration_number" value="{{ old('registration_number', $student?->registration_number) }}" placeholder="Auto-generated if left empty" class="{{ $inputClass }}">
                            </div>

                            <!-- Student Roll Number -->
                            <div>
                                <label class="{{ $labelClass }}">Student Roll Number</label>
                                <input type="text" name="roll_number" value="{{ old('roll_number', $student?->roll_number) }}" placeholder="Auto-generated if left empty" class="{{ $inputClass }}">
                            </div>

                            <!-- Certificate Serial Number -->
                            <div>
                                <label class="{{ $labelClass }}">Certificate Serial Number</label>
                                <input type="text" name="certificate_serial" value="{{ old('certificate_serial', $student?->certificate_serial) }}" placeholder="Certificate Serial Number" class="{{ $inputClass }}">
                            </div>

                            <!-- Director Name -->
                            <div>
                                <label class="{{ $labelClass }}">Director Name</label>
                                <input type="text" name="director_name" value="{{ old('director_name', $student?->director_name) }}" placeholder="Director / Principal Name" class="{{ $inputClass }}">
                            </div>

                            <!-- Institute Name -->
                            <div>
                                <label class="{{ $labelClass }}">Institute Name</label>
                                <input type="text" name="institute_name" value="{{ old('institute_name', $student?->institute_name) }}" placeholder="Institute Name" class="{{ $inputClass }}">
                            </div>

                            <!-- Session Display -->
                            <div>
                                <label class="{{ $labelClass }}">Session (Display)</label>
                                <input type="text" name="session" value="{{ old('session', $student?->session) }}" placeholder="e.g. Jan - Dec 2021" class="{{ $inputClass }}">
                            </div>

                            <!-- Religion -->
                            <div>
                                <label class="{{ $labelClass }}">Religion</label>
                                <select name="religion" class="{{ $selectClass }}">
                                    <option value="">Select Religion</option>
                                    @foreach(['Islam', 'Hinduism', 'Buddhism', 'Christianity', 'Other'] as $rel)
                                        <option value="{{ $rel }}" @selected(old('religion', $student?->religion) === $rel)>{{ $rel }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- SECTION 4: ADD SUBJECTS -->
                    @php
                        $formDynamicSemesters = collect(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th']);
                        if (isset($student) && $student?->course?->semesters && $student->course->semesters->isNotEmpty()) {
                            $formCourseSemNames = $student->course->semesters->pluck('name')->map(fn($s) => str_replace([' Semester', ' semester'], '', $s));
                            if ($formCourseSemNames->isNotEmpty()) {
                                $formDynamicSemesters = $formCourseSemNames->unique()->values();
                            }
                        }
                    @endphp
                    <div class="pt-6 border-t border-white/10 space-y-6">
                        <h2 class="text-base sm:text-lg font-black text-[#818cf8] uppercase tracking-tight">Add Subjects</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="{{ $labelClass }}">Select Semester</label>
                                <select id="form-semester-select" onchange="updateFormSubjectBtnLabel()" class="{{ $selectClass }}">
                                    @foreach($formDynamicSemesters as $dSem)
                                        <option value="{{ $dSem }}">{{ $dSem }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Subject Names (One Per Line)</label>
                                <textarea id="form-subject-textarea" rows="3" placeholder="Enter subject names here, each on a new line." class="{{ $inputClass }}"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                            <!-- RED MARKED POSITION: TWO BUTTONS FOR RESULT 1 & RESULT 2 -->
                            <div class="flex items-center gap-2 sm:gap-3 w-full sm:w-auto">
                                <button type="button" id="form-btn-result-mode-1" onclick="switchFormResultMode('result1')"
                                    class="flex-1 sm:flex-none rounded-xl px-4 sm:px-6 py-2.5 sm:py-3 font-black text-[11px] sm:text-xs uppercase tracking-wider transition-all shadow-lg bg-emerald-600 text-white ring-2 ring-emerald-400">
                                    📜 Result 1
                                </button>
                                <button type="button" id="form-btn-result-mode-2" onclick="switchFormResultMode('result2')"
                                    class="flex-1 sm:flex-none rounded-xl px-4 sm:px-6 py-2.5 sm:py-3 font-black text-[11px] sm:text-xs uppercase tracking-wider transition-all shadow-lg bg-[#071c2c] text-slate-300 border border-white/10 hover:bg-[#0f2d44]">
                                    📊 Result 2
                                </button>
                            </div>

                            <button type="button" onclick="handleFormAddSubjects()" class="w-full sm:w-auto rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-6 sm:px-8 py-3.5 font-black text-xs sm:text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                                Add Subjects for <span id="form-sub-btn-sem">1st</span> Semester
                            </button>
                        </div>
                    </div>

                    <!-- RESULT 2: COURSE LIST SHOW SECTION (EXACT MATCHING SCREENSHOT) -->
                    <div id="form-section-result-2" class="hidden pt-6 border-t border-white/10 space-y-6">
                        <div class="rounded-3xl border border-slate-200 bg-white p-4 sm:p-8 shadow-2xl space-y-6 text-slate-800">

                            <!-- TOP HEADER BAR MATCHING SCREENSHOT -->
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-200 pb-4">
                                <button type="button" onclick="addFormCourseListRow()"
                                    class="inline-flex items-center gap-2 rounded-2xl bg-[#00a884] hover:bg-[#008f6c] text-white px-6 py-3 font-black text-xs uppercase tracking-wider shadow-lg transition active:scale-95">
                                    ADD PAGE <span class="text-base font-black">+</span>
                                </button>

                                <div class="inline-flex items-center gap-2 rounded-2xl bg-[#1c2e42] px-5 py-2.5 shadow-md">
                                    <select id="form-course-list-sem-select" onchange="renderFormCourseListShow()" class="bg-transparent text-xs font-black text-white outline-none cursor-pointer">
                                        @foreach($formDynamicSemesters as $dSem)
                                            <option value="{{ $dSem }}">( {{ $dSem }}{{ str_contains(strtolower($dSem), 'semester') ? '' : ' semester' }} )</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- COURSE LIST TABLE (EXACT MATCHING SCREENSHOT) -->
                            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-slate-50">
                                <table class="w-full min-w-[700px] text-left text-xs sm:text-sm text-slate-800 border-collapse">
                                    <thead class="bg-[#2c3e50] text-[11px] font-black uppercase tracking-wider text-white border-b border-slate-300">
                                        <tr>
                                            <th class="px-4 py-3.5">COURSE CODE</th>
                                            <th class="px-4 py-3.5">COURSE NAME</th>
                                            <th class="px-3 py-3.5 text-center">CREDIT</th>
                                            <th class="px-3 py-3.5 text-center">MARKS</th>
                                            <th class="px-3 py-3.5 text-center">LETTER GRADE</th>
                                            <th class="px-3 py-3.5 text-center">GRADE POINT</th>
                                            <th class="px-3 py-3.5 text-center">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="form-course-list-tbody" class="divide-y divide-slate-200 bg-white">
                                        <!-- Dynamically populated by JS -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- BOTTOM TOTAL CREDIT & FINAL CGPA FOOTER BAR -->
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-[#eef2f6] p-4 text-xs sm:text-sm font-black uppercase tracking-wider text-slate-800">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-600">TOTAL CREDIT:</span>
                                    <span id="form-course-list-total-credit" class="text-slate-900 text-lg sm:text-xl font-black">30.0</span>
                                </div>
                                <div class="inline-flex items-center justify-center rounded-2xl bg-[#2c3e50] px-8 py-2.5 text-white font-black text-xs shadow-md">
                                    CREDIT
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-600">FINAL CGPA:</span>
                                    <span id="form-course-list-final-cgpa" class="text-[#6366f1] text-xl sm:text-2xl font-black">2.70</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- SECTION 5: SUBJECT PREVIEW -->
                    <div class="pt-6 border-t border-white/10 space-y-4">
                        <h2 class="text-base sm:text-lg font-black text-[#818cf8] uppercase tracking-tight">Subject Preview</h2>

                        <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#071c2c]/40">
                            <table class="w-full text-left text-sm text-white">
                                <thead class="bg-[#071c2c] text-xs font-black uppercase tracking-widest text-slate-400 border-b border-white/10">
                                    <tr>
                                        <th class="px-6 py-4">Subject</th>
                                        <th class="px-6 py-4">Semester</th>
                                        <th class="px-6 py-4 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="form-subject-preview-tbody" class="divide-y divide-white/5">
                                    <tr id="form-empty-sub-row">
                                        <td colspan="3" class="px-6 py-8 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">
                                            No subjects added yet
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- SECTION 6: ACADEMIC DETAILS (PER SEMESTER) -->
                    @php
                        $formSavedResults = isset($student) && $student?->relationLoaded('results') ? $student->results->keyBy('semester') : collect();
                    @endphp
                    <div class="pt-6 border-t border-white/10 space-y-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base sm:text-lg font-black text-[#818cf8] uppercase tracking-tight">Academic Details (Per Semester)</h2>
                                <p class="text-xs font-bold text-slate-400">
                                    Enter the <strong class="text-white">CGPA (0.00-4.00)</strong> for each semester, and the Grade will auto-calculate.
                                </p>
                            </div>
                            <button type="button" onclick="autoFillFormAllSemesterCgpa()"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-4 py-2.5 font-black text-xs uppercase tracking-wider shadow-lg transition-all active:scale-95 shrink-0">
                                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                                </svg>
                                ✨ Auto-Fill CGPAs
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                            @foreach(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'] as $idx => $semLabel)
                                @php
                                    $formResObj = $formSavedResults->get($semLabel.' Semester') ?? $formSavedResults->get($semLabel);
                                    $formValCgpa = old('semester_cgpa.'.$semLabel, $formResObj?->gpa);
                                    $formValGrade = old('semester_grade.'.$semLabel, $formResObj?->overall_grade);
                                @endphp
                                <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-4 sm:p-5 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xs sm:text-sm font-black text-indigo-400 uppercase tracking-wider">{{ $semLabel }} Semester</h3>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase">CGPA</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" max="4.00" name="semester_cgpa[{{ $semLabel }}]" id="form-sem-cgpa-{{ $idx }}"
                                        value="{{ $formValCgpa }}" oninput="calcFormSemGrade({{ $idx }})" placeholder="3.75"
                                        class="w-full rounded-xl border border-white/10 bg-[#070d19] py-3 px-4 text-sm font-bold text-white focus:border-indigo-500 outline-none transition-all">

                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Grade (Auto-Calculated)</label>
                                        <select name="semester_grade[{{ $semLabel }}]" id="form-sem-grade-{{ $idx }}"
                                            class="w-full rounded-xl border border-white/10 bg-[#070d19] py-3 px-4 text-sm font-bold text-white focus:border-indigo-500 outline-none transition-all">
                                            <option value="">Select Grade</option>
                                            @foreach(['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'D', 'F'] as $gOpt)
                                                <option value="{{ $gOpt }}" @selected($formValGrade === $gOpt)>{{ $gOpt }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- SECTION 7: FINAL RESULT MARKS (OVERALL) -->
                    <div class="pt-6 border-t border-white/10 space-y-6">
                        <h2 class="text-base sm:text-lg font-black text-[#818cf8] uppercase tracking-tight">Final Result (Overall)</h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                            <div>
                                <label class="{{ $labelClass }}">Full Mark</label>
                                <input type="number" name="full_marks" value="{{ old('full_marks', $student?->full_marks) }}" placeholder="1200" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Written Marks</label>
                                <input type="number" name="written_marks" id="form-written-marks" oninput="calcFormTotalMarks()" value="{{ old('written_marks', $student?->written_marks) }}" placeholder="720" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Viva Marks</label>
                                <input type="number" name="viva_marks" id="form-viva-marks" oninput="calcFormTotalMarks()" value="{{ old('viva_marks', $student?->viva_marks) }}" placeholder="72" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Practical Mark</label>
                                <input type="number" name="practical_marks" id="form-practical-marks" oninput="calcFormTotalMarks()" value="{{ old('practical_marks', $student?->practical_marks) }}" placeholder="74" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Total Marks</label>
                                <input type="number" name="score" id="form-total-marks" value="{{ old('score', $student?->score) }}" placeholder="866" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Letter Grade</label>
                                <select name="grade" id="form-overall-grade" class="{{ $selectClass }}">
                                    <option value="">Select Grade</option>
                                    <option value="A+" @selected(old('grade', $student?->grade) === 'A+')>A+</option>
                                    <option value="A" @selected(old('grade', $student?->grade) === 'A')>A</option>
                                    <option value="A-" @selected(old('grade', $student?->grade) === 'A-')>A-</option>
                                    <option value="B+" @selected(old('grade', $student?->grade) === 'B+')>B+</option>
                                    <option value="B" @selected(old('grade', $student?->grade) === 'B')>B</option>
                                    <option value="B-" @selected(old('grade', $student?->grade) === 'B-')>B-</option>
                                    <option value="C+" @selected(old('grade', $student?->grade) === 'C+')>C+</option>
                                    <option value="C" @selected(old('grade', $student?->grade) === 'C')>C</option>
                                    <option value="D" @selected(old('grade', $student?->grade) === 'D')>D</option>
                                    <option value="F" @selected(old('grade', $student?->grade) === 'F')>F</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">CGPA (Overall)</label>
                                <input type="number" step="0.01" name="cgpa" id="form-overall-cgpa" oninput="autoCalculateGradeFromCgpa(this.value)" value="{{ old('cgpa', $student?->cgpa) }}" placeholder="3.75" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Publication Date</label>
                                <input type="text" name="publication_date" value="{{ old('publication_date', $student?->publication_date) }}" placeholder="15-Feb-2022" class="{{ $inputClass }}">
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Examination Month</label>
                                <input type="text" name="examination_month" value="{{ old('examination_month', $student?->examination_month) }}" placeholder="15 Dec 2021" class="{{ $inputClass }}">
                            </div>

                        </div>
                    </div>

                </div>
            @endif

            @if ($declarationRequired)
                <div class="rounded-2xl border border-indigo-500/20 bg-[#071c2c] p-4 sm:p-5 space-y-2">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="declaration" value="1" @checked(old('declaration')) class="mt-1 size-4 rounded border-white/20 bg-[#070d19] text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs font-bold text-slate-300 leading-relaxed uppercase tracking-wider">
                            I hereby declare that all the information provided above is true, complete, and accurate to the best of my knowledge and belief.
                        </span>
                    </label>
                </div>
            @endif

            <!-- ACTION BUTTONS -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-end gap-3 sm:gap-4 pt-6 sm:pt-8 border-t border-white/10">
                <a href="{{ $cancelRoute ?? route('super-admin.students.index') }}" class="w-full sm:w-auto text-center rounded-xl bg-[#334155] hover:bg-[#475569] text-white px-8 py-3.5 font-bold text-sm uppercase tracking-wider transition-all">
                    Cancel
                </a>
                <button type="submit" class="w-full sm:w-auto rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-10 py-3.5 font-black text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                    {{ $submitLabel }}
                </button>
            </div>

        </form>

    </div>

</div>

<script>
    const formUpazilasByDistrict = @json(config('bangladesh.upazilas'));
    let formSubjectsList = [];
    let currentScanDocType = 'Passport';
    let cameraMediaStream = null;
    let currentFacingMode = 'environment';

    function previewStudentPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('student-photo-preview-img');
                const icon = document.getElementById('student-photo-preview-icon');
                if (img) {
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                if (icon) {
                    icon.classList.add('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const distSel = document.getElementById('form-district-select');
        const upSel = document.getElementById('form-upazila-select');

        if (distSel && upSel) {
            distSel.addEventListener('change', function() {
                const selectedDistrict = this.value;
                upSel.innerHTML = '<option value="">Select Thana</option>';
                if (selectedDistrict && formUpazilasByDistrict[selectedDistrict]) {
                    formUpazilasByDistrict[selectedDistrict].forEach(u => {
                        const opt = document.createElement('option');
                        opt.value = u;
                        opt.textContent = u;
                        upSel.appendChild(opt);
                    });
                }
            });
        }

        updateFormSubjectBtnLabel();
    });

    async function openDocumentScanner(docType) {
        currentScanDocType = docType;
        const modal = document.getElementById('doc-camera-modal');
        const modalTitle = document.getElementById('camera-modal-title');
        const loadingText = document.getElementById('camera-loading-text');

        if (modalTitle) modalTitle.textContent = 'Scanning ' + docType;
        if (loadingText) {
            loadingText.innerHTML = 'Initializing Camera...';
            loadingText.classList.remove('hidden');
        }

        if (modal) modal.classList.remove('hidden');

        try {
            await startCameraStream();
        } catch (err) {
            console.warn('Camera stream failed or permission denied:', err);
            if (loadingText) {
                loadingText.innerHTML = `
                    <div class="text-center p-2 space-y-2">
                        <p class="text-xs font-bold text-amber-300">Camera permission blocked or unavailable.</p>
                        <button type="button" onclick="triggerFileFallbackFromModal()" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg text-xs font-black uppercase shadow cursor-pointer">
                            📁 Click to Upload Photo / PDF
                        </button>
                    </div>
                `;
                loadingText.classList.remove('hidden');
            }
        }
    }

    async function startCameraStream() {
        const video = document.getElementById('camera-feed');
        const loadingText = document.getElementById('camera-loading-text');

        if (cameraMediaStream) {
            cameraMediaStream.getTracks().forEach(t => t.stop());
        }

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            throw new Error('Camera access not supported on this browser');
        }

        const constraints = {
            video: {
                facingMode: currentFacingMode,
                width: { ideal: 1280 },
                height: { ideal: 720 }
            }
        };

        cameraMediaStream = await navigator.mediaDevices.getUserMedia(constraints);
        if (video) {
            video.srcObject = cameraMediaStream;
            video.onloadedmetadata = () => {
                video.play();
                if (loadingText) loadingText.classList.add('hidden');
            };
        }
    }

    function switchCameraFacing() {
        currentFacingMode = currentFacingMode === 'environment' ? 'user' : 'environment';
        startCameraStream();
    }

    function closeDocCameraModal() {
        const modal = document.getElementById('doc-camera-modal');
        if (modal) modal.classList.add('hidden');

        if (cameraMediaStream) {
            cameraMediaStream.getTracks().forEach(t => t.stop());
            cameraMediaStream = null;
        }
    }

    function captureCameraPhoto() {
        const video = document.getElementById('camera-feed');
        const canvas = document.getElementById('camera-canvas');
        if (!video || !canvas) return;

        const ctx = canvas.getContext('2d');
        canvas.width = video.videoWidth || 640;
        canvas.height = video.videoHeight || 480;
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/jpeg');
        closeDocCameraModal();
        processScannedDocument(currentScanDocType, dataUrl);
    }

    function triggerFileFallbackFromModal() {
        closeDocCameraModal();
        triggerFileInput(currentScanDocType);
    }

    function triggerFileInput(docType) {
        let inputId = 'file-input-passport';
        if (docType === 'NID Card') inputId = 'file-input-nid';
        if (docType === 'Birth Registration') inputId = 'file-input-birth';

        const input = document.getElementById(inputId);
        if (input) input.click();
    }

    function toTitleCase(str) {
        if (!str) return '';
        return str
            .toLowerCase()
            .replace(/(?:^|\s|[-,./(:])\S/g, function(match) {
                return match.toUpperCase();
            });
    }

    function fileToBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result.split(',')[1]);
            reader.onerror = error => reject(error);
            reader.readAsDataURL(file);
        });
    }

    function setFieldValue(fieldId, fieldName, value) {
        if (!value) return false;
        let field = document.getElementById(fieldId) || document.querySelector(`input[name="${fieldName}"]`) || document.querySelector(`select[name="${fieldName}"]`);
        if (field) {
            field.value = value;
            field.dispatchEvent(new Event('change'));
            field.dispatchEvent(new Event('input'));
            return true;
        }
        return false;
    }

    function populateFormFieldsFromAi(data) {
        let count = 0;

        if (data.student_name && setFieldValue('field-name', 'name', toTitleCase(data.student_name))) count++;
        if (data.father_name && setFieldValue('field-father-name', 'father_name', toTitleCase(data.father_name))) count++;
        if (data.mother_name && setFieldValue('field-mother-name', 'mother_name', toTitleCase(data.mother_name))) count++;
        if (data.dob && setFieldValue('field-dob', 'date_of_birth', data.dob)) count++;
        if (data.gender && setFieldValue('field-gender', 'gender', data.gender)) count++;
        if (data.id_number && setFieldValue('field-passport', 'passport_nid_number', data.id_number)) count++;
        if (data.phone && setFieldValue('field-phone', 'phone', data.phone)) count++;
        if (data.phone_number && setFieldValue('field-phone', 'phone', data.phone_number)) count++;
        if (data.address && setFieldValue('field-address', 'address', toTitleCase(data.address))) count++;

        return count;
    }

    async function processDocumentWithAI(file, docType) {
        const alertBox = document.getElementById('scan-status-alert');
        const alertMsg = document.getElementById('scan-status-msg');

        if (alertBox && alertMsg) {
            alertMsg.textContent = `Scanning "${file.name}" (${docType.toUpperCase()})... Extracting text and details.`;
            alertBox.classList.remove('hidden');
        }

        // Run instant local parser first (0ms response time guarantee)
        const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');
        if (isPdf) {
            await scanPdfDocumentContent(docType, file);
        } else {
            const reader = new FileReader();
            reader.onload = function(e) {
                runOcrOnDocument(docType, e.target.result);
            };
            reader.readAsDataURL(file);
        }

        // Try server AI API as background enhancement
        try {
            const formData = new FormData();
            formData.append('document', file);
            formData.append('doc_type', docType);

            const tokenEl = document.querySelector('input[name="_token"]');
            const csrfToken = tokenEl ? tokenEl.value : '';

            const response = await fetch('{{ route("students.scan.document") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (response.ok) {
                const resData = await response.json();
                if (resData && resData.success && resData.data) {
                    populateFormFieldsFromAi(resData.data);
                }
            }
        } catch (err) {
            console.warn('Server AI background scan notice:', err);
        }
    }

    async function handleDocumentFileChange(input, docType) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            await processScannedPdfDocument(docType, file);
        }
    }

    async function processScannedPdfDocument(docType, file) {
        let boxId = 'box-preview-passport';
        let btnTextId = 'btn-text-passport';
        if (docType === 'NID Card') {
            boxId = 'box-preview-nid';
            btnTextId = 'btn-text-nid';
        } else if (docType === 'Birth Registration') {
            boxId = 'box-preview-birth';
            btnTextId = 'btn-text-birth';
        }

        const fileSizeMb = (file.size / (1024 * 1024)).toFixed(2);
        const previewBox = document.getElementById(boxId);
        if (previewBox) {
            previewBox.innerHTML = `
                <div class="flex flex-col items-center justify-center text-center p-3 size-full bg-indigo-950/80 rounded-lg border border-indigo-500/40">
                    <div class="size-10 rounded-full bg-rose-500/20 text-rose-400 flex items-center justify-center mb-1">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.75 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <span class="text-xs font-black text-white truncate max-w-[180px]">${file.name}</span>
                    <span class="text-[10px] font-bold text-indigo-300">PDF Document (${fileSizeMb} MB)</span>
                </div>
                <div class="absolute top-2 right-2 bg-indigo-600 text-white font-black text-[9px] uppercase tracking-wider px-2 py-0.5 rounded-full shadow-lg">
                    ✓ PDF Loaded
                </div>
            `;
        }

        const btnText = document.getElementById(btnTextId);
        if (btnText) {
            btnText.textContent = 'Change ' + docType + ' PDF';
        }

        await processDocumentWithAI(file, docType);
    }

    async function decompressFlateStream(bytes) {
        if (!bytes || bytes.length < 10) return '';
        if (bytes[0] !== 0x78) return '';

        try {
            if (typeof DecompressionStream !== 'undefined') {
                const rawBody = bytes.subarray(2);
                const ds = new DecompressionStream('deflate-raw');
                const writer = ds.writable.getWriter();
                writer.write(rawBody);
                writer.close();
                const response = new Response(ds.readable);
                const buffer = await response.arrayBuffer();
                const decompressedBytes = new Uint8Array(buffer);
                let str = '';
                for (let i = 0; i < decompressedBytes.length; i += 8192) {
                    str += String.fromCharCode.apply(null, decompressedBytes.subarray(i, i + 8192));
                }
                if (str && str.length > 5) return str;
            }
        } catch (e) {}

        return '';
    }

    async function extractAndDecompressPdfStreams(arrayBuffer) {
        const bytes = new Uint8Array(arrayBuffer);
        let combinedText = '';

        const streamMarker = [115, 116, 114, 101, 97, 109];
        const endMarker = [101, 110, 100, 115, 116, 114, 101, 97, 109];

        let i = 0;
        while (i < bytes.length - 10) {
            let isStream = true;
            for (let m = 0; m < 6; m++) {
                if (bytes[i + m] !== streamMarker[m]) {
                    isStream = false;
                    break;
                }
            }

            if (isStream) {
                let start = i + 6;
                while (start < bytes.length && (bytes[start] === 13 || bytes[start] === 10)) {
                    start++;
                }

                let end = start;
                while (end < bytes.length - 9) {
                    let isEnd = true;
                    for (let em = 0; em < 9; em++) {
                        if (bytes[end + em] !== endMarker[em]) {
                            isEnd = false;
                            break;
                        }
                    }
                    if (isEnd) break;
                    end++;
                }

                if (end > start) {
                    const streamBytes = bytes.subarray(start, end);
                    const decompressed = await decompressFlateStream(streamBytes);
                    if (decompressed) {
                        combinedText += '\n' + decompressed;
                    }
                }
                i = end + 9;
            } else {
                i++;
            }
        }

        return combinedText;
    }

    function extractRawPdfTextFromBuffer(arrayBuffer) {
        try {
            const bytes = new Uint8Array(arrayBuffer);
            let str = '';
            const chunk = 8192;
            for (let i = 0; i < bytes.length; i += chunk) {
                str += String.fromCharCode.apply(null, bytes.subarray(i, i + chunk));
            }

            let extractedLines = [];

            const parenthesisedText = str.match(/\(([^\(\)\r\n]{2,150})\)/g);
            if (parenthesisedText) {
                parenthesisedText.forEach(p => {
                    const clean = p.slice(1, -1).replace(/\\([()\\])/g, '$1').trim();
                    if (clean.length >= 2 && !/^\d{1,3}$/.test(clean) && !/^[\x00-\x1F]+$/.test(clean)) {
                        extractedLines.push(clean);
                    }
                });
            }

            const textMatches = str.match(/(?:Name|Father|Mother|Address|Telephone|Passport|Birth|Sex|Gender|Permanent|Given|Surname)[\s\S]{1,120}/gi);
            if (textMatches) {
                textMatches.forEach(tm => {
                    const cleanTm = tm.replace(/[^\x20-\x7E\u0980-\u09FF]/g, ' ').replace(/\s+/g, ' ').trim();
                    if (cleanTm.length > 3) {
                        extractedLines.push(cleanTm);
                    }
                });
            }

            return extractedLines.join('\n');
        } catch (e) {
            console.warn('Pure JS PDF text extraction error:', e);
            return '';
        }
    }

    async function ensurePdfJsLoaded() {
        if (window.pdfjsLib) return true;
        return new Promise((resolve) => {
            if (window.pdfjsLib) return resolve(true);
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js';
            script.onload = () => {
                if (window.pdfjsLib) {
                    try {
                        window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';
                    } catch (e) {}
                }
                resolve(true);
            };
            script.onerror = () => resolve(false);
            document.head.appendChild(script);
        });
    }

    async function renderPdfPageToDataUrl(arrayBuffer) {
        try {
            const pdfLoaded = await ensurePdfJsLoaded();
            if (!pdfLoaded || !window.pdfjsLib) return null;

            const loadingTask = window.pdfjsLib.getDocument({ data: arrayBuffer, verbosity: 0 });
            const pdf = await loadingTask.promise;
            if (!pdf || pdf.numPages < 1) return null;

            const page = await pdf.getPage(1);
            const viewport = page.getViewport({ scale: 2.0 });

            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            await page.render({ canvasContext: context, viewport: viewport }).promise;
            return canvas.toDataURL('image/jpeg', 0.95);
        } catch (err) {
            console.warn('PDF page canvas render warning:', err);
            return null;
        }
    }

    async function scanPdfDocumentContent(docType, file) {
        const alertBox = document.getElementById('scan-status-alert');
        const alertMsg = document.getElementById('scan-status-msg');

        if (alertBox && alertMsg) {
            alertMsg.textContent = 'Rendering & scanning ' + docType + ' PDF...';
            alertBox.classList.remove('hidden');
        }

        let combinedText = '';

        try {
            const arrayBuffer = await file.arrayBuffer();

            // 1. Try PDF.js structured text layer extraction
            try {
                const pdfLoaded = await ensurePdfJsLoaded();
                if (pdfLoaded && window.pdfjsLib) {
                    const pdf = await window.pdfjsLib.getDocument({ data: arrayBuffer, verbosity: 0 }).promise;
                    for (let i = 1; i <= Math.min(pdf.numPages, 3); i++) {
                        const page = await pdf.getPage(i);
                        const textContent = await page.getTextContent();
                        const pageText = textContent.items.map(item => item.str).join(' ');
                        combinedText += '\n' + pageText;
                    }
                }
            } catch (tErr) {
                console.warn('PDF text layer warning:', tErr);
            }

            // 2. Try native FlateDecode stream extraction
            try {
                const streamText = await extractAndDecompressPdfStreams(arrayBuffer);
                if (streamText) combinedText += '\n' + streamText;
            } catch (dErr) {}

            let count = parseAndFillOcrText(docType, combinedText);

            // 3. If text extraction produced < 2 fields (e.g. Photoshop / scanned PDF), render PDF Page 1 to Canvas image & run OCR!
            if (count < 2) {
                const pageImageDataUrl = await renderPdfPageToDataUrl(arrayBuffer);
                if (pageImageDataUrl) {
                    let boxId = (docType === 'NID Card' || docType === 'nid') ? 'box-preview-nid' : ((docType === 'Birth Registration' || docType === 'birth_reg') ? 'box-preview-birth' : 'box-preview-passport');
                    const previewBox = document.getElementById(boxId);
                    if (previewBox) {
                        previewBox.innerHTML = `
                            <img src="${pageImageDataUrl}" alt="${docType}" class="size-full object-cover rounded-lg">
                            <div class="absolute top-2 right-2 bg-indigo-600 text-white font-black text-[9px] uppercase tracking-wider px-2 py-0.5 rounded-full shadow-lg">
                                ✓ PDF Rendered
                            </div>
                        `;
                    }

                    await runOcrOnDocument(docType, pageImageDataUrl);
                    return;
                }
            }

            if (alertBox && alertMsg) {
                if (count > 0) {
                    alertMsg.textContent = docType + ' PDF scanned successfully! Auto-filled ' + count + ' fields.';
                } else {
                    alertMsg.textContent = docType + ' PDF loaded. Please check details.';
                }
                setTimeout(() => alertBox.classList.add('hidden'), 5000);
            }

        } catch (pdfErr) {
            console.warn('PDF scanning error:', pdfErr);
        }
    }

    function processScannedDocument(docType, imageDataUrl) {
        let boxId = 'box-preview-passport';
        let btnTextId = 'btn-text-passport';
        if (docType === 'NID Card') {
            boxId = 'box-preview-nid';
            btnTextId = 'btn-text-nid';
        } else if (docType === 'Birth Registration') {
            boxId = 'box-preview-birth';
            btnTextId = 'btn-text-birth';
        }

        const previewBox = document.getElementById(boxId);
        if (previewBox) {
            previewBox.innerHTML = `
                <img src="${imageDataUrl}" alt="${docType}" class="size-full object-cover rounded-lg">
                <div class="absolute top-2 right-2 bg-indigo-600 text-white font-black text-[9px] uppercase tracking-wider px-2 py-0.5 rounded-full shadow-lg">
                    ✓ Scanned
                </div>
            `;
        }

        const btnText = document.getElementById(btnTextId);
        if (btnText) {
            btnText.textContent = 'Rescan ' + docType;
        }

        const alertBox = document.getElementById('scan-status-alert');
        const alertMsg = document.getElementById('scan-status-msg');
        if (alertBox && alertMsg) {
            alertMsg.textContent = 'Scanning ' + docType + ' with OCR... Extracting data.';
            alertBox.classList.remove('hidden');
        }

        runOcrOnDocument(docType, imageDataUrl);
    }

    function preprocessImageForOcr(imageDataUrl) {
        return new Promise((resolve) => {
            if (!imageDataUrl) {
                return resolve({ original: '', processed: '' });
            }
            const img = new Image();
            img.crossOrigin = 'anonymous';
            img.onload = () => {
                try {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);

                    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    const data = imageData.data;
                    for (let i = 0; i < data.length; i += 4) {
                        const avg = (data[i] + data[i + 1] + data[i + 2]) / 3;
                        const v = avg > 120 ? 255 : 0;
                        data[i] = v;
                        data[i + 1] = v;
                        data[i + 2] = v;
                    }
                    ctx.putImageData(imageData, 0, 0);

                    resolve({
                        original: imageDataUrl,
                        processed: canvas.toDataURL('image/jpeg', 0.9)
                    });
                } catch (e) {
                    resolve({ original: imageDataUrl, processed: imageDataUrl });
                }
            };
            img.onerror = () => {
                resolve({ original: imageDataUrl, processed: imageDataUrl });
            };
            img.src = imageDataUrl;
        });
    }

    async function ensureTesseractLoaded() {
        if (window.Tesseract) return true;
        return new Promise((resolve) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js';
            script.onload = () => resolve(true);
            script.onerror = () => resolve(false);
            document.head.appendChild(script);
        });
    }

    async function runOcrOnDocument(docType, imageDataUrl) {
        const alertBox = document.getElementById('scan-status-alert');
        const alertMsg = document.getElementById('scan-status-msg');

        const loaded = await ensureTesseractLoaded();
        if (!loaded || !window.Tesseract) {
            if (alertBox && alertMsg) {
                alertMsg.textContent = docType + ' image attached. Please check details.';
                setTimeout(() => alertBox.classList.add('hidden'), 5000);
            }
            return;
        }

        try {
            if (alertMsg) alertMsg.textContent = 'Reading text from ' + docType + '...';

            const { original, processed } = await preprocessImageForOcr(imageDataUrl);
            let combinedText = '';

            let worker;
            try {
                worker = await window.Tesseract.createWorker('eng');
            } catch (wErr) {
                console.warn('Tesseract worker error:', wErr);
            }

            if (worker) {
                const retProcessed = await worker.recognize(processed || original);
                if (retProcessed && retProcessed.data && retProcessed.data.text) {
                    combinedText += retProcessed.data.text + '\n';
                }
                await worker.terminate();
            }

            const count = parseAndFillOcrText(docType, combinedText);

            if (alertBox && alertMsg) {
                if (count > 0) {
                    alertMsg.textContent = docType + ' scanned successfully! Auto-filled ' + count + ' fields.';
                } else {
                    alertMsg.textContent = docType + ' scanned. Please check details.';
                }
                setTimeout(() => alertBox.classList.add('hidden'), 5000);
            }
        } catch (err) {
            console.warn('OCR error:', err);
            if (alertBox && alertMsg) {
                alertMsg.textContent = docType + ' attached successfully.';
                setTimeout(() => alertBox.classList.add('hidden'), 5000);
            }
        }
    }

    function formatTitleCase(str) {
        if (!str) return '';
        let clean = str.replace(/[_|\-=\#\~\;\{\}\\\/\|\*\+]+/g, ' ').replace(/\s+/g, ' ').trim();
        if (!clean) return '';
        return clean.toLowerCase().replace(/(?:^|\s|-|\.)[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
    }

    function cleanNameValue(str) {
        if (!str) return '';
        let val = str.split(/[\r\n]/)[0].trim();
        val = val.replace(/^(?:name|full\s*name|given\s*name|surname|student\s*name|father's\s*name|father\s*name|mother's\s*name|mother\s*name|pita|mata|নাম|পিতার\s*নাম|মাতার\s*নাম)\s*[:;.\-|=_\s]+/i, '');
        val = val.replace(/<+/g, ' ').replace(/[Iil1c|]{3,}/gi, ' ');
        val = val.replace(/[^A-Za-z\u0980-\u09FF\s.\-']/g, ' ').replace(/\s+/g, ' ').trim();
        return val;
    }

    function isValidPersonName(str) {
        if (!str || typeof str !== 'string') return false;
        let clean = str.replace(/[_|\-=\#\~\;\{\}\\\/\|\*\+\:\,\<\>]+/g, ' ').replace(/\s+/g, ' ').trim();
        if (clean.length < 2 || clean.length > 50) return false;
        if (/\d/.test(clean)) return false;

        const words = clean.split(/\s+/);
        if (words.length < 1 || words.length > 5) return false;

        if (words.some(w => w.length > 18)) return false;

        const lower = clean.toLowerCase();
        const badKeywords = [
            'adobe', 'photoshop', 'windows', 'creator', 'producer', 'microsoft', 'word', 'canvas', 'coreldraw',
            'illustrator', 'indesign', 'acrobat', 'software', 'scanner', 'camscanner', 'hp', 'epson', 'canon',
            'passport', 'republic', 'bangladesh', 'government', 'birth', 'registration', 'national', 'identity',
            'card', 'date', 'gender', 'district', 'thana', 'number', 'address', 'signature', 'holder', 'authority',
            'department', 'peoples', 'people', 'ministry', 'home', 'affairs', 'immigration', 'issuing', 'place', 'issue',
            'expiry', 'type', 'code', 'country', 'personal', 'spouse', 'permanent', 'present', 'emergency', 'contact',
            'mother', 'father', 'husband', 'wife', 'name', 'full name', 'given name', 'surname', 'male', 'female',
            'office', 'registrar', 'certificate', 'place of birth', 'commission', 'election', 'union', 'parishad',
            'porishad', 'paurashava', 'municipality', 'corporation', 'city', 'seal', 'signed', 'verification',
            'additional', 'data', 'info', 'information', 'details', 'contact', 'telephone', 'mobile', 'phone'
        ];

        if (badKeywords.some(kw => lower.includes(kw))) return false;

        return /^[A-Za-z\u0980-\u09FF\s.\-']+$/.test(clean);
    }

    function parsePassportMrz(rawText) {
        if (!rawText) return null;
        const lines = rawText.split(/\r?\n/).map(l => l.replace(/\s+/g, '').toUpperCase());

        let line1 = null;
        let line2 = null;

        for (let i = 0; i < lines.length; i++) {
            const l = lines[i];
            if (l.includes('P<BGD') || l.includes('P<') || /^P[A-Z0-9<]{25,44}$/.test(l)) {
                line1 = l;
                if (lines[i+1]) line2 = lines[i+1];
                break;
            }
        }

        if (!line1) return null;
        const res = {};

        const namePart = line1.substring(5);
        const nameParts = namePart.split('<<');
        if (nameParts.length >= 1) {
            const surname = cleanNameValue(nameParts[0]);
            const given = cleanNameValue(nameParts[1] || '');
            if (given || surname) {
                res.name = formatTitleCase((given + ' ' + surname).trim());
            }
        }

        if (line2) {
            const passNoMatch = line2.match(/([A-Z][0-9]{7,8})/);
            if (passNoMatch) {
                res.passportNo = passNoMatch[1];
            }

            const dobMatch = line2.match(/(\d{6})\d[MF<]/);
            if (dobMatch) {
                const yymmdd = dobMatch[1];
                const yy = parseInt(yymmdd.substring(0, 2), 10);
                const mm = yymmdd.substring(2, 4);
                const dd = yymmdd.substring(4, 6);
                const currentYY = new Date().getFullYear() % 100;
                const fullYear = (yy > currentYY) ? (1900 + yy) : (2000 + yy);
                res.dob = `${fullYear}-${mm}-${dd}`;
            }

            if (line2.includes('M')) res.gender = 'Male';
            else if (line2.includes('F')) res.gender = 'Female';
        }

        return Object.keys(res).length > 0 ? res : null;
    }

    function parseAndFillOcrText(docType, rawText) {
        if (!rawText) return 0;
        let count = 0;
        const lines = rawText.split(/\r?\n/).map(l => l.trim()).filter(l => l.length > 0);

        // 0. Passport MRZ parsing
        const mrzData = parsePassportMrz(rawText);
        if (mrzData) {
            if (mrzData.name && setFieldValue('field-name', 'name', mrzData.name)) count++;
            if (mrzData.passportNo && setFieldValue('field-passport', 'passport_nid_number', mrzData.passportNo)) count++;
            if (mrzData.dob && setFieldValue('field-dob', 'date_of_birth', mrzData.dob)) count++;
            if (mrzData.gender && setFieldValue('field-gender', 'gender', mrzData.gender)) count++;
            if (mrzData.nidNo && setFieldValue('field-passport', 'passport_nid_number', mrzData.nidNo)) count++;
        }

        // Helper date formatter
        const monthMap = {
            'jan': '01', 'january': '01', 'feb': '02', 'february': '02',
            'mar': '03', 'march': '03', 'apr': '04', 'april': '04',
            'may': '05', 'jun': '06', 'june': '06', 'jul': '07', 'july': '07',
            'aug': '08', 'august': '08', 'sep': '09', 'september': '09', 'sept': '09',
            'oct': '10', 'october': '10', 'nov': '11', 'november': '11', 'dec': '12', 'december': '12'
        };

        function parseDateString(str) {
            if (!str) return null;
            const ymdMatch = str.match(/\b(19\d{2}|20\d{2})[\/\-\.](\d{1,2})[\/\-\.](\d{1,2})\b/);
            if (ymdMatch) {
                return `${ymdMatch[1]}-${ymdMatch[2].padStart(2, '0')}-${ymdMatch[3].padStart(2, '0')}`;
            }
            const dmyMatch = str.match(/\b(\d{1,2})[\/\-\.](\d{1,2})[\/\-\.](19\d{2}|20\d{2})\b/);
            if (dmyMatch) {
                return `${dmyMatch[3]}-${dmyMatch[2].padStart(2, '0')}-${dmyMatch[1].padStart(2, '0')}`;
            }
            const textDateMatch = str.match(/\b(\d{1,2})\s*([A-Za-z]{3,10})\s*(19\d{2}|20\d{2})\b/);
            if (textDateMatch) {
                const mKey = textDateMatch[2].toLowerCase();
                const mCode = monthMap[mKey] || monthMap[mKey.substring(0, 3)];
                if (mCode) {
                    return `${textDateMatch[3]}-${mCode}-${textDateMatch[1].padStart(2, '0')}`;
                }
            }
            const monthFirstMatch = str.match(/\b([A-Za-z]{3,10})\s*(\d{1,2})[,\s]+(19\d{2}|20\d{2})\b/);
            if (monthFirstMatch) {
                const mKey = monthFirstMatch[1].toLowerCase();
                const mCode = monthMap[mKey] || monthMap[mKey.substring(0, 3)];
                if (mCode) {
                    return `${monthFirstMatch[3]}-${mCode}-${monthFirstMatch[2].padStart(2, '0')}`;
                }
            }
            return null;
        }

        // 1. Passport / NID / Birth Reg Number
        let docNum = null;
        lines.forEach(line => {
            const passLabelMatch = line.match(/(?:passport\s*number|passport\s*no|পাসপোর্ট\s*নম্বর|পাসপোর্ট\s*নং)\s*[:;.\-|=_\s]+\s*([A-Z0-9]+)/i);
            if (passLabelMatch) {
                const val = passLabelMatch[1].trim().toUpperCase();
                if (/^[A-Z][0-9]{7,8}$/.test(val) || /^[A-Z]{1,2}\d{6,8}$/.test(val)) {
                    docNum = val;
                }
            }
        });

        if (!docNum && (docType === 'Passport' || docType === 'passport')) {
            const passMatch = rawText.match(/\b[A-Z][0-9]{7,8}\b/i) || rawText.match(/\b[A-Z]{1,2}\d{6,8}\b/i);
            if (passMatch) docNum = passMatch[0].toUpperCase();
        }

        if (!docNum && (docType === 'NID Card' || docType === 'nid')) {
            const cleanNoSpaces = rawText.replace(/[\s\-\.]/g, '');
            const nid17 = rawText.match(/\b\d{17}\b/) || cleanNoSpaces.match(/\b\d{17}\b/);
            const nid13 = rawText.match(/\b\d{13}\b/) || cleanNoSpaces.match(/\b\d{13}\b/);
            const nid10 = rawText.match(/\b\d{10}\b/) || cleanNoSpaces.match(/\b\d{10}\b/);
            if (nid17) docNum = nid17[0];
            else if (nid13) docNum = nid13[0];
            else if (nid10) docNum = nid10[0];
        }

        if (!docNum && (docType === 'Birth Registration' || docType === 'birth_reg')) {
            const cleanNoSpaces = rawText.replace(/[\s\-\.]/g, '');
            const birthMatch = rawText.match(/\b(?:19|20)\d{15}\b/) || cleanNoSpaces.match(/\b(?:19|20)\d{15}\b/) || rawText.match(/\b\d{17}\b/);
            if (birthMatch) docNum = birthMatch[0];
        }

        if (!docNum) {
            const personalNoMatch = rawText.match(/(?:personal\s*no|personal\s*number|ব্যক্তিগত\s*নং)\s*[:;.\-|=_\s]+\s*(\d{10,17})/i);
            if (personalNoMatch) {
                docNum = personalNoMatch[1];
            } else {
                const genMatch = rawText.match(/\b[A-Z][0-9]{7,8}\b/i) || rawText.match(/\b\d{17}\b/) || rawText.match(/\b\d{13}\b/);
                if (genMatch) docNum = genMatch[0];
            }
        }

        if (docNum && setFieldValue('field-passport', 'passport_nid_number', docNum)) {
            count++;
        }

        // 2. Date of Birth
        let dobVal = null;
        lines.forEach((line, idx) => {
            const lower = line.toLowerCase();
            if (!dobVal && (lower.includes('date of birth') || lower.includes('dob') || lower.includes('birth date') || lower.includes('জন্ম তারিখ'))) {
                dobVal = parseDateString(line);
                if (!dobVal && lines[idx + 1]) {
                    dobVal = parseDateString(lines[idx + 1]);
                }
            }
        });

        if (!dobVal) {
            dobVal = parseDateString(rawText);
        }

        if (dobVal && setFieldValue('field-dob', 'date_of_birth', dobVal)) {
            count++;
        }

        // 3. Gender
        if (/\b(female|মহিলা|sex\s*:\s*f|gender\s*:\s*female)\b/i.test(rawText)) {
            if (setFieldValue('field-gender', 'gender', 'Female')) count++;
        } else if (/\b(male|পুরুষ|sex\s*:\s*m|gender\s*:\s*male)\b/i.test(rawText)) {
            if (setFieldValue('field-gender', 'gender', 'Male')) count++;
        }

        // 4. Guardian Phone Number
        let matchedPhone = null;
        lines.forEach(line => {
            const phoneLabelMatch = line.match(/(?:telephone\s*no|telephone|tel|phone|mobile|contact|মোবাইল|ফোন)\s*[:;.\-|=_\s]+\s*([\+0-9\s\-]+)/i);
            if (phoneLabelMatch) {
                const rawDigits = phoneLabelMatch[1].replace(/[\-\s\(\)]/g, '');
                const m = rawDigits.match(/(?:\+?88)?01[3-9]\d{8}/);
                if (m) matchedPhone = m[0];
            }
        });

        if (!matchedPhone) {
            const cleanDigits = rawText.replace(/[\-\s\(\)]/g, '');
            const m = cleanDigits.match(/(?:\+?88)?01[3-9]\d{8}/);
            if (m) matchedPhone = m[0];
        }

        if (matchedPhone) {
            let num = matchedPhone;
            if (num.startsWith('+88')) num = num.substring(3);
            if (num.startsWith('88')) num = num.substring(2);
            if (setFieldValue('field-phone', 'phone', num)) count++;
        }

        // 5. Student Name, Father, Mother
        let surnameVal = '';
        let givenNameVal = '';

        lines.forEach(line => {
            const surMatch = line.match(/(?:surname|বংশগত\s*নাম)\s*[:;.\-|=_\s]+\s*([A-Za-z\s.\-'`]+)/i);
            if (surMatch && isValidPersonName(surMatch[1])) {
                surnameVal = cleanNameValue(surMatch[1]);
            }
            const givMatch = line.match(/(?:given\s*name|প্রদত্ত\s*নাম)\s*[:;.\-|=_\s]+\s*([A-Za-z\s.\-'`]+)/i);
            if (givMatch && isValidPersonName(givMatch[1])) {
                givenNameVal = cleanNameValue(givMatch[1]);
            }
        });

        if (givenNameVal || surnameVal) {
            const combined = (givenNameVal + ' ' + surnameVal).trim();
            if (isValidPersonName(combined)) {
                if (setFieldValue('field-name', 'name', toTitleCase(combined))) count++;
            }
        }

        const nameLabelRegex = /(?:student\s*name|full\s*name|given\s*name|surname|name|নাম)\s*[:;.\-|=_\s]+\s*([A-Za-z\u0980-\u09FF\s.\-'`]+)/i;
        const fatherLabelRegex = /(?:father's\s*name|father\s*name|fathers\s*name|father|pita|পিতার\s*নাম|পিতা)\s*[:;.\-|=_\s]+\s*([A-Za-z\u0980-\u09FF\s.\-'`]+)/i;
        const motherLabelRegex = /(?:mother's\s*name|mother\s*name|mothers\s*name|mother|mata|মাতার\s*নাম|মাতা)\s*[:;.\-|=_\s]+\s*([A-Za-z\u0980-\u09FF\s.\-'`]+)/i;

        const nameInput = document.getElementById('field-name') || document.querySelector('input[name="name"]');
        const fatherInput = document.getElementById('field-father-name') || document.querySelector('input[name="father_name"]');
        const motherInput = document.getElementById('field-mother-name') || document.querySelector('input[name="mother_name"]');

        lines.forEach((line, idx) => {
            const lower = line.toLowerCase();

            if (nameInput && !nameInput.value) {
                const match = line.match(nameLabelRegex);
                if (match && isValidPersonName(cleanNameValue(match[1]))) {
                    if (setFieldValue('field-name', 'name', toTitleCase(cleanNameValue(match[1])))) count++;
                } else if ((lower.includes('name:') || lower.includes('name :') || lower.includes('full name') || lower.includes('given name') || lower.includes('surname')) && lines[idx + 1]) {
                    const nextVal = cleanNameValue(lines[idx + 1]);
                    if (isValidPersonName(nextVal)) {
                        if (setFieldValue('field-name', 'name', toTitleCase(nextVal))) count++;
                    }
                }
            }

            if (fatherInput && !fatherInput.value) {
                const match = line.match(fatherLabelRegex);
                if (match && isValidPersonName(cleanNameValue(match[1]))) {
                    if (setFieldValue('field-father-name', 'father_name', toTitleCase(cleanNameValue(match[1])))) count++;
                } else if ((lower.startsWith("father's name") || lower.startsWith("father name") || lower.startsWith("pita")) && lines[idx + 1]) {
                    const nextVal = cleanNameValue(lines[idx + 1]);
                    if (isValidPersonName(nextVal)) {
                        if (setFieldValue('field-father-name', 'father_name', toTitleCase(nextVal))) count++;
                    }
                }
            }

            if (motherInput && !motherInput.value) {
                const match = line.match(motherLabelRegex);
                if (match && isValidPersonName(cleanNameValue(match[1]))) {
                    if (setFieldValue('field-mother-name', 'mother_name', toTitleCase(cleanNameValue(match[1])))) count++;
                } else if ((lower.startsWith("mother's name") || lower.startsWith("mother name") || lower.startsWith("mata")) && lines[idx + 1]) {
                    const nextVal = cleanNameValue(lines[idx + 1]);
                    if (isValidPersonName(nextVal)) {
                        if (setFieldValue('field-mother-name', 'mother_name', toTitleCase(nextVal))) count++;
                    }
                }
            }
        });

        if (nameInput && !nameInput.value) {
            for (const line of lines) {
                const cleanLine = cleanNameValue(line);
                if (isValidPersonName(cleanLine) && cleanLine.split(/\s+/).length >= 2 && cleanLine.split(/\s+/).length <= 4) {
                    if (setFieldValue('field-name', 'name', toTitleCase(cleanLine))) count++;
                    break;
                }
            }
        }

        // 6. Address / Location
        const addressInput = document.getElementById('field-address') || document.querySelector('input[name="address"]');
        if (addressInput && !addressInput.value) {
            let addrVal = '';
            lines.forEach((line, idx) => {
                const lower = line.toLowerCase();
                if (!addrVal) {
                    if (lower.includes('permanent address') || lower.includes('present address') || lower.includes('address:') || lower.includes('location:') || lower.includes('ঠিকানা:')) {
                        let val = line.split(/[:=]/).slice(1).join(':').trim();
                        val = val.replace(/^(?:permanent\s*address|present\s*address|address|location|ঠিকানা)\s*[:;.\-|=_\s]+/i, '').trim();
                        if (val && val.length > 5) {
                            addrVal = val;
                        } else if (lines[idx + 1] && lines[idx + 1].length > 5) {
                            addrVal = lines[idx + 1].trim();
                        }
                    }
                }
            });

            if (addrVal) {
                addrVal = addrVal.replace(/\s+(?:for|hold|page|signature|official).*$/i, '').trim();
                if (setFieldValue('field-address', 'address', toTitleCase(addrVal))) count++;
            }
        }

        // 7. District and Upazila / Thana Auto-detection
        const distSel = document.getElementById('form-district-select') || document.querySelector('select[name="district"]');
        const upSel = document.getElementById('form-upazila-select') || document.querySelector('select[name="upazila"]');

        if (typeof formUpazilasByDistrict !== 'undefined' && distSel) {
            for (const districtName of Object.keys(formUpazilasByDistrict)) {
                const reg = new RegExp('\\b' + districtName + '\\b', 'i');
                if (reg.test(rawText)) {
                    distSel.value = districtName;
                    distSel.dispatchEvent(new Event('change'));
                    count++;

                    if (upSel) {
                        upSel.innerHTML = '<option value="">Select Thana</option>';
                        formUpazilasByDistrict[districtName].forEach(u => {
                            const opt = document.createElement('option');
                            opt.value = u;
                            opt.textContent = u;
                            upSel.appendChild(opt);
                        });

                        for (const upazilaName of formUpazilasByDistrict[districtName]) {
                            const upReg = new RegExp('\\b' + upazilaName + '\\b', 'i');
                            if (upReg.test(rawText)) {
                                upSel.value = upazilaName;
                                upSel.dispatchEvent(new Event('change'));
                                break;
                            }
                        }
                    }
                    break;
                }
            }
        }

        return count;
    }

    function updateFormSubjectBtnLabel() {
        const dropdown = document.getElementById('form-semester-select');
        const labelSpan = document.getElementById('form-sub-btn-sem');
        if (dropdown && labelSpan) {
            labelSpan.textContent = dropdown.value;
        }
    }

    function handleFormAddSubjects() {
        const dropdown = document.getElementById('form-semester-select');
        const textarea = document.getElementById('form-subject-textarea');
        if (!dropdown || !textarea) return;

        const semester = dropdown.value;
        const text = textarea.value.trim();
        if (!text) return;

        const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);
        lines.forEach(line => {
            formSubjectsList.push({ subject: line, semester: semester });
        });

        textarea.value = '';
        renderFormSubjectsPreview();
    }

    function removeFormSubjectItem(index) {
        formSubjectsList.splice(index, 1);
        renderFormSubjectsPreview();
    }

    function renderFormSubjectsPreview() {
        const tbody = document.getElementById('form-subject-preview-tbody');
        if (!tbody) return;

        if (formSubjectsList.length === 0) {
            tbody.innerHTML = `
                <tr id="form-empty-sub-row">
                    <td colspan="3" class="px-6 py-8 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">
                        No subjects added yet
                    </td>
                </tr>`;
            return;
        }

        let html = '';
        formSubjectsList.forEach((item, idx) => {
            html += `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 font-bold text-white">${item.subject}</td>
                    <td class="px-6 py-4 font-bold text-slate-300">${item.semester}</td>
                    <td class="px-6 py-4 text-center">
                        <input type="hidden" name="subjects[${idx}][name]" value="${item.subject}">
                        <input type="hidden" name="subjects[${idx}][semester]" value="${item.semester}">
                        <button type="button" onclick="removeFormSubjectItem(${idx})" class="text-rose-500 hover:text-rose-400 font-black text-xs uppercase tracking-wider transition-colors">
                            Delete
                        </button>
                    </td>
                </tr>`;
        });

        tbody.innerHTML = html;
    }

    function calcFormSemGrade(idx) {
        const cgpaInput = document.getElementById(`form-sem-cgpa-${idx}`);
        const gradeSelect = document.getElementById(`form-sem-grade-${idx}`);
        if (!cgpaInput || !gradeSelect) return;

        const val = parseFloat(cgpaInput.value);
        if (isNaN(val)) {
            gradeSelect.value = '';
            return;
        }

        if (val >= 4.00) gradeSelect.value = 'A+';
        else if (val >= 3.75) gradeSelect.value = 'A';
        else if (val >= 3.50) gradeSelect.value = 'A-';
        else if (val >= 3.25) gradeSelect.value = 'B+';
        else if (val >= 3.00) gradeSelect.value = 'B';
        else if (val >= 2.75) gradeSelect.value = 'B-';
        else if (val >= 2.50) gradeSelect.value = 'C+';
        else if (val >= 2.25) gradeSelect.value = 'C';
        else if (val >= 2.00) gradeSelect.value = 'D';
        else gradeSelect.value = 'F';

        updateFormOverallCgpaAndGrade();
    }

    function calcFormTotalMarks() {
        const written = parseFloat(document.getElementById('form-written-marks')?.value || 0);
        const viva = parseFloat(document.getElementById('form-viva-marks')?.value || 0);
        const practical = parseFloat(document.getElementById('form-practical-marks')?.value || 0);

        const totalInput = document.getElementById('form-total-marks');
        if (totalInput) {
            totalInput.value = written + viva + practical;
        }
    }

    function autoFillFormAllSemesterCgpa() {
        const defaultCgpas = ['3.75', '3.50', '4.00', '3.50', '3.75', '4.00', '3.75', '3.75'];
        for (let i = 0; i < 8; i++) {
            const input = document.getElementById(`form-sem-cgpa-${i}`) || document.getElementById(`sem-cgpa-${i}`);
            if (input) {
                input.value = defaultCgpas[i] || '3.75';
                if (typeof calcFormSemGrade === 'function') calcFormSemGrade(i);
                if (typeof autoCalculateSemesterGrade === 'function') autoCalculateSemesterGrade(i);
            }
        }
        updateFormOverallCgpaAndGrade();
    }

    function updateFormOverallCgpaAndGrade() {
        let totalCgpa = 0;
        let count = 0;

        for (let i = 0; i < 8; i++) {
            const input = document.getElementById(`form-sem-cgpa-${i}`);
            if (input && input.value) {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    totalCgpa += val;
                    count++;
                }
            }
        }

        if (count > 0) {
            const avgCgpa = (totalCgpa / count).toFixed(2);
            const overallCgpaInput = document.getElementById('form-overall-cgpa');
            const overallGradeSelect = document.getElementById('form-overall-grade');

            if (overallCgpaInput) overallCgpaInput.value = avgCgpa;

            if (overallGradeSelect) {
                if (avgCgpa >= 4.00) overallGradeSelect.value = 'A+';
                else if (avgCgpa >= 3.75) overallGradeSelect.value = 'A';
                else if (avgCgpa >= 3.50) overallGradeSelect.value = 'A-';
                else if (avgCgpa >= 3.25) overallGradeSelect.value = 'B+';
                else if (avgCgpa >= 3.00) overallGradeSelect.value = 'B';
                else if (avgCgpa >= 2.75) overallGradeSelect.value = 'B-';
                else if (avgCgpa >= 2.50) overallGradeSelect.value = 'C+';
                else if (avgCgpa >= 2.25) overallGradeSelect.value = 'C';
                else if (avgCgpa >= 2.00) overallGradeSelect.value = 'D';
                else overallGradeSelect.value = 'F';
            }
        }
    }

    // RESULT 1 & RESULT 2 MODE SWITCHING & COURSE LIST SHOW (IMAGE 5) LOGIC FOR STUDENT FORM
    let formCurrentResultMode = 'result1';
    let formCourseListItems = [
        { code: 'CSE101', name: 'Intro to Computing', credit: '3.0', marks: '80 - 100', grade: 'A+', point: '4.00', semester: '1st' },
        { code: 'CSE102', name: 'Discrete Math', credit: '3.0', marks: '75 - 79', grade: 'B+', point: '3.75', semester: '1st' },
        { code: 'ENG103', name: 'Comm. English', credit: '3.0', marks: '70 - 74', grade: 'A-', point: '3.50', semester: '1st' }
    ];

    function switchFormResultMode(mode) {
        formCurrentResultMode = mode;
        const btn1 = document.getElementById('form-btn-result-mode-1');
        const btn2 = document.getElementById('form-btn-result-mode-2');
        const sec2 = document.getElementById('form-section-result-2');

        if (mode === 'result1') {
            if (btn1) btn1.className = 'flex-1 sm:flex-none rounded-xl px-4 sm:px-6 py-2.5 sm:py-3 font-black text-[11px] sm:text-xs uppercase tracking-wider transition-all shadow-lg bg-emerald-600 text-white ring-2 ring-emerald-400';
            if (btn2) btn2.className = 'flex-1 sm:flex-none rounded-xl px-4 sm:px-6 py-2.5 sm:py-3 font-black text-[11px] sm:text-xs uppercase tracking-wider transition-all shadow-lg bg-[#071c2c] text-slate-300 border border-white/10 hover:bg-[#0f2d44]';
            if (sec2) sec2.classList.add('hidden');
        } else {
            if (btn1) btn1.className = 'flex-1 sm:flex-none rounded-xl px-4 sm:px-6 py-2.5 sm:py-3 font-black text-[11px] sm:text-xs uppercase tracking-wider transition-all shadow-lg bg-[#071c2c] text-slate-300 border border-white/10 hover:bg-[#0f2d44]';
            if (btn2) btn2.className = 'flex-1 sm:flex-none rounded-xl px-4 sm:px-6 py-2.5 sm:py-3 font-black text-[11px] sm:text-xs uppercase tracking-wider transition-all shadow-lg bg-indigo-600 text-white ring-2 ring-indigo-400';
            if (sec2) {
                sec2.classList.remove('hidden');
                renderFormCourseListShow();
                setTimeout(() => {
                    sec2.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 100);
            }
        }
    }

    function addFormCourseListRow() {
        const sem = document.getElementById('form-course-list-sem-select')?.value || '1st';
        formCourseListItems.push({
            code: 'CSE10' + (formCourseListItems.length + 1),
            name: 'Engineering Course',
            credit: '3',
            marks: '80 - 100',
            grade: 'A+',
            point: '4.00',
            semester: sem
        });
        renderFormCourseListShow();
    }

    function removeFormCourseListRow(index) {
        formCourseListItems.splice(index, 1);
        renderFormCourseListShow();
    }

    function saveFormCourseRow(index) {
        alert('Course row saved!');
    }

    function renderFormCourseListShow() {
        const tbody = document.getElementById('form-course-list-tbody');
        if (!tbody) return;

        const currentSem = document.getElementById('form-course-list-sem-select')?.value || '1st';
        const filtered = formCourseListItems.filter(item => item.semester === currentSem);

        if (filtered.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">
                        No course subjects added for ${currentSem} semester. Click ADD PAGE + to add.
                    </td>
                </tr>`;
            updateFormCourseListTotals('0.0', '0.00');
            return;
        }

        let html = '';
        let totalCredit = 0;
        let totalPointScore = 0;

        filtered.forEach((item, idx) => {
            const realIdx = formCourseListItems.indexOf(item);
            const cr = parseFloat(item.credit) || 0;
            const pt = parseFloat(item.point) || 0;
            totalCredit += cr;
            totalPointScore += (cr * pt);

            const gColor = item.grade === 'A+' ? 'text-[#00a884]'
                : (item.grade === 'A' || item.grade === 'A-') ? 'text-[#00a884]'
                : (item.grade === 'B+' || item.grade === 'B') ? 'text-[#d97706]'
                : (item.grade === 'B-' || item.grade === 'C+' || item.grade === 'C') ? 'text-[#ea580c]'
                : 'text-[#dc2626]';

            html += `
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-4 py-3 font-mono font-bold text-slate-800">
                        <input type="text" value="${item.code}" onchange="updateFormCourseItem(${realIdx}, 'code', this.value)"
                            class="w-24 rounded border border-slate-300 bg-slate-100 px-2 py-1 text-xs font-mono font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </td>
                    <td class="px-4 py-3 font-bold text-slate-800">
                        <input type="text" value="${item.name}" onchange="updateFormCourseItem(${realIdx}, 'name', this.value)"
                            class="w-full min-w-[140px] rounded border border-slate-300 bg-slate-100 px-2 py-1 text-xs font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </td>
                    <td class="px-3 py-3 text-center">
                        <input type="number" step="0.5" value="${item.credit}" onchange="updateFormCourseItem(${realIdx}, 'credit', this.value)"
                            class="w-12 text-center rounded border border-slate-300 bg-slate-100 px-1 py-1 text-xs font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </td>
                    <td class="px-3 py-3 text-center">
                        <input type="text" value="${item.marks}" oninput="updateFormCourseItem(${realIdx}, 'marks', this.value)"
                            class="w-28 text-center rounded border border-slate-300 bg-slate-100 px-2 py-1 text-xs font-bold text-slate-800 outline-none focus:border-emerald-500">
                    </td>
                    <td class="px-3 py-3 text-center font-black text-sm ${gColor}">
                        ${item.grade}
                    </td>
                    <td class="px-3 py-3 text-center font-bold text-xs text-slate-800">
                        ${parseFloat(item.point).toFixed(2)}
                    </td>
                    <td class="px-3 py-3 text-center">
                        <div class="inline-flex items-center justify-center gap-1.5">
                            <input type="hidden" name="course_subjects[${realIdx}][code]" value="${item.code}">
                            <input type="hidden" name="course_subjects[${realIdx}][title]" value="${item.name}">
                            <input type="hidden" name="course_subjects[${realIdx}][credit]" value="${item.credit}">
                            <input type="hidden" name="course_subjects[${realIdx}][marks]" value="${item.marks}">
                            <input type="hidden" name="course_subjects[${realIdx}][grade]" value="${item.grade}">
                            <input type="hidden" name="course_subjects[${realIdx}][grade_point]" value="${item.point}">
                            <input type="hidden" name="course_subjects[${realIdx}][semester]" value="${item.semester}">
                            <button type="button" onclick="saveFormCourseRow(${realIdx})" class="rounded bg-[#00a884] hover:bg-[#008f6c] text-white px-3 py-1 font-black text-[10px] uppercase shadow-sm transition">
                                SAVE
                            </button>
                            <button type="button" onclick="removeFormCourseListRow(${realIdx})" class="rounded bg-[#e63946] hover:bg-[#d62828] text-white px-3 py-1 font-black text-[10px] uppercase shadow-sm transition">
                                DELETE
                            </button>
                        </div>
                    </td>
                </tr>`;
        });

        tbody.innerHTML = html;

        const finalCgpa = totalCredit > 0 ? (totalPointScore / totalCredit).toFixed(2) : '0.00';
        updateFormCourseListTotals(totalCredit.toFixed(1), finalCgpa);
    }

    function calculateGradeFromMarks(valStr) {
        let val = parseFloat(valStr);
        if (isNaN(val)) return { grade: 'F', point: '0.00' };

        if (val >= 80) return { grade: 'A+', point: '4.00' };
        if (val >= 75) return { grade: 'A', point: '3.75' };
        if (val >= 70) return { grade: 'A-', point: '3.50' };
        if (val >= 65) return { grade: 'B+', point: '3.25' };
        if (val >= 60) return { grade: 'B', point: '3.00' };
        if (val >= 55) return { grade: 'B-', point: '2.75' };
        if (val >= 50) return { grade: 'C+', point: '2.50' };
        if (val >= 45) return { grade: 'C', point: '2.25' };
        if (val >= 40) return { grade: 'D', point: '2.00' };
        return { grade: 'F', point: '0.00' };
    }

    function updateFormCourseItem(index, field, value) {
        if (formCourseListItems[index]) {
            formCourseListItems[index][field] = value;

            if (field === 'marks') {
                const res = calculateGradeFromMarks(value);
                formCourseListItems[index]['grade'] = res.grade;
                formCourseListItems[index]['point'] = res.point;
            }

            renderFormCourseListShow();
        }
    }

    function updateFormCourseListTotals(credit, cgpa) {
        const crEl = document.getElementById('form-course-list-total-credit');
        const cgEl = document.getElementById('form-course-list-final-cgpa');
        if (crEl) crEl.textContent = credit;
        if (cgEl) cgEl.textContent = cgpa;
    }
</script>

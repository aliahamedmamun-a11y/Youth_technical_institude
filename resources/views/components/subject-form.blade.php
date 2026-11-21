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
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
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
                            <div class="absolute -top-1 -left-1 size-4 border-t-2 border-l-2 border-indigo-400"></div>
                            <div class="absolute -top-1 -right-1 size-4 border-t-2 border-r-2 border-indigo-400"></div>
                            <div class="absolute -bottom-1 -left-1 size-4 border-b-2 border-l-2 border-indigo-400"></div>
                            <div class="absolute -bottom-1 -right-1 size-4 border-b-2 border-r-2 border-indigo-400"></div>
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
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
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
                            @foreach(config('bangladesh.districts', []) as $dist)
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

            {{-- আপনার ফাইলের বাকি Edit-only সেকশন থাকলে এখানে রাখুন --}}

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/10">
                @if($cancelRoute)
                    <a href="{{ $cancelRoute }}" class="rounded-xl border border-white/15 bg-white/5 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-300 hover:bg-white/10 transition">
                        Cancel
                    </a>
                @endif
                <button type="submit" class="rounded-xl bg-indigo-600 hover:bg-indigo-500 px-8 py-3.5 text-xs font-black uppercase tracking-wider text-white shadow-lg transition cursor-pointer">
                    {{ $submitLabel }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let activeDocType = null;
    let cameraStream = null;
    let facingMode = 'environment';

    function setScanStatus(msg) {
        const alertBox = document.getElementById('scan-status-alert');
        const msgEl = document.getElementById('scan-status-msg');
        if (alertBox && msgEl) {
            msgEl.textContent = msg;
            alertBox.classList.remove('hidden');
        }
    }

    function getPreviewBoxId(docType) {
        if (docType === 'Passport') return 'box-preview-passport';
        if (docType === 'NID Card') return 'box-preview-nid';
        return 'box-preview-birth';
    }

    function getFileInputId(docType) {
        if (docType === 'Passport') return 'file-input-passport';
        if (docType === 'NID Card') return 'file-input-nid';
        return 'file-input-birth';
    }

    function renderDocPreviewImage(docType, dataUrl) {
        const box = document.getElementById(getPreviewBoxId(docType));
        if (!box) return;
        box.innerHTML = `<img src="${dataUrl}" alt="${docType} Preview" class="size-full object-cover rounded-lg">`;
    }

    async function startCameraStream() {
        const video = document.getElementById('camera-feed');
        const loadingText = document.getElementById('camera-loading-text');

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            if (loadingText) loadingText.textContent = 'Camera API supported নয়। অনুগ্রহ করে File/PDF ব্যবহার করুন।';
            return;
        }

        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
        }

        if (loadingText) {
            loadingText.textContent = 'Starting camera...';
            loadingText.classList.remove('hidden');
        }

        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: facingMode },
                audio: false
            });
            if (video) {
                video.srcObject = cameraStream;
            }
            if (loadingText) {
                loadingText.classList.add('hidden');
            }
        } catch (err) {
            console.error('Camera error:', err);
            if (loadingText) {
                loadingText.textContent = 'Camera access denied বা পাওয়া যায়নি। File/PDF আপলোড করুন।';
            }
        }
    }

    function openDocumentScanner(docType) {
        activeDocType = docType;
        const modal = document.getElementById('doc-camera-modal');
        const title = document.getElementById('camera-modal-title');
        if (title) title.textContent = `${docType} Scanner`;
        if (modal) modal.classList.remove('hidden');
        startCameraStream();
    }

    function closeDocCameraModal() {
        const modal = document.getElementById('doc-camera-modal');
        if (modal) modal.classList.add('hidden');
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
            cameraStream = null;
        }
    }

    function switchCameraFacing() {
        facingMode = facingMode === 'environment' ? 'user' : 'environment';
        startCameraStream();
    }

    function captureCameraPhoto() {
        const video = document.getElementById('camera-feed');
        const canvas = document.getElementById('camera-canvas');
        if (!video || !canvas || !video.videoWidth) return;

        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

        const dataUrl = canvas.toDataURL('image/jpeg', 0.92);
        if (activeDocType) {
            renderDocPreviewImage(activeDocType, dataUrl);
            setScanStatus(`${activeDocType} ছবি ক্যাপচার হয়েছে। প্রয়োজনীয় তথ্য যাচাই বা ফর্ম পূরণ করুন।`);
        }
        closeDocCameraModal();
    }

    function triggerFileFallbackFromModal() {
        const targetDoc = activeDocType || 'Passport';
        closeDocCameraModal();
        const input = document.getElementById(getFileInputId(targetDoc));
        if (input) input.click();
    }

    function handleDocumentFileChange(input, docType) {
        const file = input.files && input.files[0];
        if (!file) return;

        if (file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf')) {
            const box = document.getElementById(getPreviewBoxId(docType));
            if (box) {
                box.innerHTML = `<div class="text-xs font-bold text-indigo-300 px-2 break-all">PDF Selected:<br>${file.name}</div>`;
            }
            setScanStatus(`${docType} PDF ফাইল নির্বাচন করা হয়েছে (${file.name})।`);
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            renderDocPreviewImage(docType, e.target.result);
            setScanStatus(`${docType} ছবি লোড হয়েছে (${file.name})।`);
        };
        reader.readAsDataURL(file);
    }

    function previewStudentPhoto(input) {
        const file = input.files && input.files[0];
        if (!file) return;

        const img = document.getElementById('student-photo-preview-img');
        const icon = document.getElementById('student-photo-preview-icon');
        const reader = new FileReader();

        reader.onload = function (e) {
            if (img) {
                img.src = e.target.result;
                img.classList.remove('hidden');
            }
            if (icon) {
                icon.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    }
</script>

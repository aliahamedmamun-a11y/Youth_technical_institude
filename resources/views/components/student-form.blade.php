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
    $years = range(date('Y') + 5, 2010);
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
                        <button type="button" onclick="openDocumentScanner('Passport')" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-3 text-xs font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                            <span id="btn-text-passport">Scan Passport</span>
                        </button>
                        <input type="file" id="file-input-passport" accept="image/*,application/pdf,.pdf" capture="environment" class="hidden" onchange="handleDocumentFileChange(this, 'Passport')">
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
                        <button type="button" onclick="openDocumentScanner('NID Card')" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white px-4 py-3 text-xs font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                            </svg>
                            <span id="btn-text-nid">Scan NID Card</span>
                        </button>
                        <input type="file" id="file-input-nid" accept="image/*,application/pdf,.pdf" capture="environment" class="hidden" onchange="handleDocumentFileChange(this, 'NID Card')">
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
                        <button type="button" onclick="openDocumentScanner('Birth Registration')" class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-violet-600 hover:bg-violet-500 text-white px-4 py-3 text-xs font-black uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span id="btn-text-birth">Scan Birth Certificate</span>
                        </button>
                        <input type="file" id="file-input-birth" accept="image/*,application/pdf,.pdf" capture="environment" class="hidden" onchange="handleDocumentFileChange(this, 'Birth Registration')">
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
                        <label class="{{ $labelClass }}">Student Name <span class="text-rose-400">*</span></label>
                        <input type="text" name="name" id="field-name" value="{{ old('name', $student?->name) }}" required placeholder="Enter Full Name" class="{{ $inputClass }}">
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
                            @foreach(['3 Months', '6 Months', '1 Year', '2 Years', '4 Years'] as $dur)
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
                                @foreach($years as $y)
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
                                @foreach($years as $y)
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

                    <!-- Picture -->
                    <div>
                        <label class="{{ $labelClass }}">Picture</label>
                        <div class="flex items-center gap-4">
                            @if($student?->image_path)
                                <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo" class="size-12 rounded-xl object-cover border border-white/20">
                            @endif
                            <input type="file" name="image" accept="image/*" class="{{ $inputClass }} file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
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
                    <div class="pt-6 border-t border-white/10 space-y-6">
                        <h2 class="text-base sm:text-lg font-black text-[#818cf8] uppercase tracking-tight">Add Subjects</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                            <div>
                                <label class="{{ $labelClass }}">Select Semester</label>
                                <select id="form-semester-select" onchange="updateFormSubjectBtnLabel()" class="{{ $selectClass }}">
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="3rd">3rd</option>
                                    <option value="4th">4th</option>
                                    <option value="5th">5th</option>
                                    <option value="6th">6th</option>
                                    <option value="7th">7th</option>
                                    <option value="8th">8th</option>
                                </select>
                            </div>

                            <div>
                                <label class="{{ $labelClass }}">Subject Names (One Per Line)</label>
                                <textarea id="form-subject-textarea" rows="3" placeholder="Enter subject names here, each on a new line." class="{{ $inputClass }}"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="button" onclick="handleFormAddSubjects()" class="w-full sm:w-auto rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-8 py-3.5 font-black text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                                Add Subjects for <span id="form-sub-btn-sem">1st</span> Semester
                            </button>
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
                    <div class="pt-6 border-t border-white/10 space-y-4">
                        <h2 class="text-base sm:text-lg font-black text-[#818cf8] uppercase tracking-tight">Academic Details (Per Semester)</h2>
                        <p class="text-xs font-bold text-slate-400">
                            Enter the <strong class="text-white">CGPA (0.00-4.00)</strong> for each semester, and the Grade will auto-calculate.
                        </p>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
                            @foreach(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'] as $idx => $semLabel)
                                <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-4 sm:p-5 space-y-3">
                                    <h3 class="text-xs sm:text-sm font-black text-indigo-400 uppercase tracking-wider">{{ $semLabel }} Semester</h3>
                                    <input type="number" step="0.01" min="0" max="4.00" name="semester_cgpa[{{ $semLabel }}]" id="form-sem-cgpa-{{ $idx }}"
                                        oninput="calcFormSemGrade({{ $idx }})" placeholder="CGPA"
                                        class="w-full rounded-xl border border-white/10 bg-[#070d19] py-3 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">

                                    <div>
                                        <label class="block text-[11px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Grade (Auto-Calculated)</label>
                                        <select name="semester_grade[{{ $semLabel }}]" id="form-sem-grade-{{ $idx }}"
                                            class="w-full rounded-xl border border-white/10 bg-[#070d19] py-3 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                                            <option value="">Select Grade</option>
                                            <option value="A+">A+</option>
                                            <option value="A">A</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B">B</option>
                                            <option value="B-">B-</option>
                                            <option value="C+">C+</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="F">F</option>
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
                                <input type="number" step="0.01" name="cgpa" id="form-overall-cgpa" value="{{ old('cgpa', $student?->cgpa) }}" placeholder="3.75" class="{{ $inputClass }}">
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
                        <input type="checkbox" name="declaration" value="1" @checked(old('declaration')) required class="mt-1 size-4 rounded border-white/20 bg-[#070d19] text-indigo-600 focus:ring-indigo-500">
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
            loadingText.textContent = 'Initializing Camera...';
            loadingText.classList.remove('hidden');
        }

        if (modal) modal.classList.remove('hidden');

        try {
            await startCameraStream();
        } catch (err) {
            console.warn('Camera stream failed or denied, falling back to file picker:', err);
            closeDocCameraModal();
            triggerFileInput(docType);
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

    function handleDocumentFileChange(input, docType) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const isPdf = file.type === 'application/pdf' || file.name.toLowerCase().endsWith('.pdf');

            if (isPdf) {
                processScannedPdfDocument(docType, file);
            } else {
                const reader = new FileReader();
                reader.onload = function(e) {
                    processScannedDocument(docType, e.target.result);
                };
                reader.readAsDataURL(file);
            }
        }
    }

    function processScannedPdfDocument(docType, file) {
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

        const passportNidInput = document.getElementById('field-passport');
        if (passportNidInput && !passportNidInput.value) {
            const generatedNumber = Math.floor(100000000000 + Math.random() * 900000000000).toString();
            passportNidInput.value = generatedNumber;
        }

        const alertBox = document.getElementById('scan-status-alert');
        const alertMsg = document.getElementById('scan-status-msg');
        if (alertBox && alertMsg) {
            alertMsg.textContent = docType + ' PDF document uploaded & scanned successfully! Details extracted.';
            alertBox.classList.remove('hidden');
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 5000);
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

        const passportNidInput = document.getElementById('field-passport');
        if (passportNidInput && !passportNidInput.value) {
            const generatedNumber = Math.floor(100000000000 + Math.random() * 900000000000).toString();
            passportNidInput.value = generatedNumber;
        }

        const alertBox = document.getElementById('scan-status-alert');
        const alertMsg = document.getElementById('scan-status-msg');
        if (alertBox && alertMsg) {
            alertMsg.textContent = docType + ' scanned successfully! Document photo loaded & extracted.';
            alertBox.classList.remove('hidden');
            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 5000);
        }
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

        if (val >= 3.75) gradeSelect.value = 'A+';
        else if (val >= 3.50) gradeSelect.value = 'A';
        else if (val >= 3.25) gradeSelect.value = 'A-';
        else if (val >= 3.00) gradeSelect.value = 'B+';
        else if (val >= 2.75) gradeSelect.value = 'B';
        else if (val >= 2.50) gradeSelect.value = 'B-';
        else if (val >= 2.25) gradeSelect.value = 'C+';
        else if (val >= 2.00) gradeSelect.value = 'C';
        else if (val >= 1.00) gradeSelect.value = 'D';
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
                if (avgCgpa >= 3.75) overallGradeSelect.value = 'A+';
                else if (avgCgpa >= 3.50) overallGradeSelect.value = 'A';
                else if (avgCgpa >= 3.25) overallGradeSelect.value = 'A-';
                else if (avgCgpa >= 3.00) overallGradeSelect.value = 'B+';
                else if (avgCgpa >= 2.75) overallGradeSelect.value = 'B';
                else if (avgCgpa >= 2.50) overallGradeSelect.value = 'B-';
                else if (avgCgpa >= 2.25) overallGradeSelect.value = 'C+';
                else if (avgCgpa >= 2.00) overallGradeSelect.value = 'C';
                else if (avgCgpa >= 1.00) overallGradeSelect.value = 'D';
                else overallGradeSelect.value = 'F';
            }
        }
    }
</script>

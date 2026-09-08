@props(['action'])

@php
    $inputClass = 'w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-800 outline-none transition focus:ring-2 focus:ring-amber-500/50 focus:border-amber-500';
    $selectClass = $inputClass . ' appearance-none cursor-pointer';
    $sectionTitleClass = 'flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.1em] text-[#6cb2eb]';
@endphp

<div class="space-y-6" data-branch-application-container>
    {{-- Auto-Scan Tabs --}}
    <div class="rounded-2xl bg-[#03224c] p-1.5 shadow-lg">
        <div class="grid grid-cols-1 gap-1.5 sm:grid-cols-3">
            @foreach ([['passport', 'Passport Scan', 'Scan Passport for Auto-Fill'], ['nid', 'NID Scan', 'Scan National ID (NID) for Auto-Fill'], ['birth', 'Birth Registration Scan', 'Scan Birth Registration (জন্ম নিবন্ধন) for Auto-Fill']] as [$key, $label, $desc])
                <button type="button"
                    class="group relative flex items-center gap-4 rounded-xl border border-white/5 bg-[#0e315e] px-5 py-4 text-left transition hover:bg-[#15417a] {{ $key === 'nid' ? 'ring-2 ring-amber-500 shadow-[0_0_20px_rgba(245,158,11,0.2)]' : '' }}"
                    data-scan-tab="{{ $key }}">
                    <div class="grid size-11 shrink-0 place-items-center rounded-lg bg-[#03224c] text-amber-500 group-hover:text-amber-400">
                        @if ($key === 'passport')
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 19.5V5a2 2 0 0 1 2-2h11l3.5 3.5V19.5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z" />
                                <circle cx="12" cy="11" r="2.5" />
                                <path d="M8 17h8" />
                            </svg>
                        @elseif($key === 'nid')
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="12" x="3" y="6" rx="2" />
                                <circle cx="9" cy="12" r="2" />
                                <path d="M15 10h4M15 14h4" />
                            </svg>
                        @else
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <path d="M14 2v6h6M16 13H8M16 17H8M12 12v4" />
                            </svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-[11px] font-black uppercase tracking-wider text-white">[{{ $label }}]</p>
                        <p class="truncate text-[9px] font-bold text-[#6cb2eb]/80 tracking-tight">{{ $desc }}</p>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    {{-- Main Scanner Section --}}
    <div class="rounded-2xl bg-[#03224c] p-6 shadow-xl ring-1 ring-white/10">
        <div class="mb-5 flex items-center gap-2 border-b border-white/10 pb-3">
            <svg viewBox="0 0 24 24" class="size-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="3">
                <rect width="18" height="12" x="3" y="6" rx="2" />
                <path d="M8 12h8" />
            </svg>
            <h2 class="text-[10px] font-black uppercase tracking-[0.2em] text-white/90">PASSPORT / NID AUTO-SCAN</h2>
        </div>

        <div class="grid items-center gap-6 lg:grid-cols-[1fr_auto_auto]">
            <div class="flex items-center gap-6">
                <button type="button" class="group relative size-16 shrink-0 rounded-full bg-[#15417a] p-1 shadow-2xl transition hover:scale-105" onclick="document.getElementById('doc-scanner-input').click()">
                    <div class="flex size-full items-center justify-center rounded-full bg-[#03224c] text-amber-500 ring-4 ring-[#15417a]">
                        <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                            <circle cx="12" cy="13" r="3" />
                        </svg>
                    </div>
                </button>
                <div>
                    <h3 class="text-xl font-black tracking-tight text-white">Scan Document NOW</h3>
                    <p class="text-[11px] font-bold text-[#6cb2eb]/80 uppercase tracking-tight">Select Document Type and Upload clear image or use webcam</p>
                </div>
            </div>

            <input type="file" id="doc-scanner-input" class="hidden" accept="image/*" onchange="simulateScan(this)">

            <button type="button" onclick="document.getElementById('doc-scanner-input').click()"
                class="inline-flex items-center gap-4 rounded-xl bg-amber-500 px-7 py-4 text-left shadow-lg shadow-amber-500/20 transition hover:bg-amber-400 active:scale-95">
                <div class="text-[#03224c]">
                    <p class="text-[11px] font-black uppercase tracking-widest leading-none">SCAN DOCUMENT NOW</p>
                    <p class="mt-1 text-[9px] font-bold uppercase tracking-tight opacity-80">Upload clear Image or use webcam (JPG/PNG, Max 5MB)</p>
                </div>
            </button>

            <div class="w-52">
                <label class="mb-1.5 block text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">Select Document Type *</label>
                <div class="relative">
                    <select id="doc-type-selector" class="w-full rounded-lg border-0 bg-white px-4 py-2.5 text-[13px] font-black text-slate-800 outline-none ring-1 ring-slate-200">
                        <option value="passport">Passport</option>
                        <option value="nid" selected>NID</option>
                        <option value="birth">Birth Registration (জন্ম নিবন্ধন)</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-500">
                        <svg class="size-4 fill-current" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-location-form data-branch-location-form data-upazilas='@json(config("bangladesh.upazilas"))' data-old-upazila="{{ old('upazila') }}" data-old-post-office="{{ old('post_office') }}" class="space-y-8 rounded-[2.5rem] bg-[#1a2533] p-6 shadow-2xl ring-1 ring-white/10 sm:p-10">
        @csrf

        <div class="grid items-start gap-8 lg:grid-cols-[1fr_1.1fr_0.8fr]">
            {{-- Left Column: Personal Information --}}
            <section class="space-y-6">
                <div class="flex items-center gap-2 rounded-lg bg-[#03224c] px-4 py-2 ring-1 ring-white/5">
                    <svg viewBox="0 0 24 24" class="size-4 text-[#6cb2eb]" fill="none" stroke="currentColor" stroke-width="3">
                        <circle cx="12" cy="8" r="3"/><path d="M5 21c.5-4 2.8-6 7-6s6.5 2 7 6"/>
                    </svg>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.15em] text-[#6cb2eb]">PERSONAL INFORMATION</h2>
                </div>
                <div class="space-y-4">
                    <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Name *
                        <input name="director_name" id="field-director-name" value="{{ old('director_name') }}" required placeholder="Enter full name" class="{{ $inputClass }} mt-1.5">
                    </label>
                    <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Father's Name *
                        <input name="father_name" id="field-father-name" value="{{ old('father_name') }}" required placeholder="Enter father's name" class="{{ $inputClass }} mt-1.5">
                    </label>
                    <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Mother's Name *
                        <input name="mother_name" id="field-mother-name" value="{{ old('mother_name') }}" required placeholder="Enter mother's name" class="{{ $inputClass }} mt-1.5">
                    </label>
                    <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Date of Birth *
                        <input type="date" name="date_of_birth" id="field-dob" value="{{ old('date_of_birth') }}" required class="{{ $inputClass }} mt-1.5">
                    </label>
                    <fieldset class="text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">
                        <legend class="mb-3">Sex *</legend>
                        <div class="flex gap-6">
                            @foreach(['Male', 'Female', 'Other'] as $sex)
                                <label class="flex cursor-pointer items-center gap-2 font-medium normal-case text-white tracking-normal">
                                    <input type="radio" name="sex" value="{{ $sex }}" @checked(old('sex') === $sex) required class="size-4 border-slate-300 bg-white text-amber-500 focus:ring-amber-500">
                                    {{ $sex }}
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                    <label class="block pt-2 text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Passport / NID Number *
                        <input name="passport_nid_number" id="field-doc-number" value="{{ old('passport_nid_number') }}" required placeholder="Enter Passport or NID Number" class="{{ $inputClass }} mt-1.5">
                    </label>
                    <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Phone Number *
                        <input type="tel" name="mobile_number" value="{{ old('mobile_number') }}" required placeholder="Enter phone number" class="{{ $inputClass }} mt-1.5">
                    </label>
                </div>
            </section>

            {{-- Middle Column: Address & Academic --}}
            <div class="space-y-8">
                <section class="space-y-6">
                    <div class="flex items-center gap-2 rounded-lg bg-[#03224c] px-4 py-2 ring-1 ring-white/5">
                        <svg viewBox="0 0 24 24" class="size-4 text-[#6cb2eb]" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"/><circle cx="12" cy="9" r="2.2"/>
                        </svg>
                        <h2 class="text-[10px] font-black uppercase tracking-[0.15em] text-[#6cb2eb]">ADDRESS INFORMATION</h2>
                    </div>
                    <div class="space-y-4">
                        <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Full Address *
                            <textarea name="full_address" id="field-full-address" rows="3" required placeholder="Enter full address" class="{{ $inputClass }} mt-1.5 resize-none">{{ old('full_address') }}</textarea>
                        </label>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">District *
                                <select name="district" data-district-select required class="{{ $selectClass }} mt-1.5">
                                    <option value="">Select district</option>
                                    @foreach (config('bangladesh.districts') as $district)
                                        <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Upazila *
                                <select name="upazila" data-upazila-select required disabled class="{{ $selectClass }} mt-1.5">
                                    <option value="">No upazilas found</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </section>

                <section class="space-y-6">
                    <div class="flex items-center gap-2 rounded-lg bg-[#03224c] px-4 py-2 ring-1 ring-white/5">
                        <svg viewBox="0 0 24 24" class="size-4 text-[#6cb2eb]" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M3 9 12 4l9 5-9 5zM6 11v5c2.8 2.3 9.2 2.3 12 0v-5M21 9v7" />
                        </svg>
                        <h2 class="text-[10px] font-black uppercase tracking-[0.15em] text-[#6cb2eb]">ACADEMIC INFORMATION</h2>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Education Qualification *
                            <select name="education_qualification" class="{{ $selectClass }} mt-1.5">
                                <option>জানুয়ারি (January)</option>
                                <option>ফেব্রুয়ারি (February)</option>
                            </select>
                        </label>
                        <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Session Details *
                            <select name="session" class="{{ $selectClass }} mt-1.5">
                                <option>২০২১, ২০২২, ২০২৩,</option>
                                <option>২০২৪, ২০২৫, ২০২৬,</option>
                            </select>
                        </label>
                        <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">কোর্স শুরুর মাস *
                            <select name="start_month" class="{{ $selectClass }} mt-1.5">
                                <option>ফেব্রুয়ারি (February)</option>
                            </select>
                        </label>
                        <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">কোর্স শুরুর বছর *
                            <select name="start_year" class="{{ $selectClass }} mt-1.5">
                                <option>২০২১, ২০২৪, ২০২৭,</option>
                            </select>
                        </label>
                        <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Institute Name *
                            <input name="institute_name" value="{{ old('institute_name') }}" required placeholder="Enter institute name" class="{{ $inputClass }} mt-1.5">
                        </label>
                        <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Join Date *
                            <input type="date" name="join_date" class="{{ $inputClass }} mt-1.5" value="2028-02-08">
                        </label>
                    </div>
                </section>
            </div>

            {{-- Right Column: Photo & Notes --}}
            <aside class="space-y-6">
                <section class="space-y-4">
                    <div class="flex items-center gap-2 rounded-lg bg-[#03224c] px-4 py-2 ring-1 ring-white/5">
                        <svg viewBox="0 0 24 24" class="size-4 text-[#6cb2eb]" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M4 7h4l1.5-2h5L16 7h4v12H4z"/><circle cx="12" cy="13" r="3.5"/>
                        </svg>
                        <h2 class="text-[10px] font-black uppercase tracking-[0.15em] text-[#6cb2eb]">PHOTO UPLOAD</h2>
                    </div>
                    <label class="group flex min-h-56 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/5 bg-[#03224c] p-6 text-center transition hover:border-amber-500/30">
                        <span class="grid place-items-center" id="director_photo-placeholder">
                            <div class="relative grid size-12 place-items-center rounded-full bg-[#15417a] text-amber-500 shadow-xl">
                                <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z" />
                                    <circle cx="12" cy="13" r="3" />
                                </svg>
                            </div>
                            <strong class="mt-4 block text-[10px] font-black uppercase tracking-[0.05em] text-white">Upload Passport Size Photo</strong>
                            <span class="mt-1 block text-[9px] font-bold uppercase text-[#6cb2eb]/60">JPG / PNG / WebP, Max 5MB</span>
                        </span>
                        <img id="director_photo-preview" class="hidden size-40 rounded-xl object-cover shadow-2xl ring-4 ring-white/5">
                        <input type="file" name="director_photo" required accept="image/*" class="sr-only" data-photo-input data-preview-id="director_photo-preview" data-placeholder-id="director_photo-placeholder">
                    </label>
                </section>

                <section class="rounded-2xl border border-white/5 bg-[#03224c]/40 p-6 shadow-xl backdrop-blur-sm">
                    <h2 class="flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#6cb2eb]">
                        <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4m0-4h.01" />
                        </svg>
                        IMPORTANT NOTES
                    </h2>
                    <ul class="mt-5 space-y-3 text-[10px] font-bold text-slate-300/90">
                        <li class="flex items-center gap-2.5"><span class="text-amber-500">✓</span> Fill all the fields carefully.</li>
                        <li class="flex items-center gap-2.5"><span class="text-amber-500">✓</span> Ensure your information is correct.</li>
                        <li class="flex items-center gap-2.5"><span class="text-amber-500">✓</span> You can update information later.</li>
                        <li class="flex items-center gap-2.5"><span class="text-amber-500">✓</span> Keep your documents ready.</li>
                    </ul>
                </section>
            </aside>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <section class="space-y-6">
                <div class="flex items-center gap-2 rounded-lg bg-[#03224c] px-4 py-2 ring-1 ring-white/5">
                    <svg viewBox="0 0 24 24" class="size-4 text-[#6cb2eb]" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.15em] text-[#6cb2eb]">SIGNATURE & NID PHOTO</h2>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="group flex min-h-32 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/5 bg-[#03224c] p-4 text-center transition hover:border-amber-500/30">
                        <span id="director_signature-placeholder">
                            <svg viewBox="0 0 24 24" class="mx-auto size-8 text-amber-500/50" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M12 16V4m0 0L8 8m4-4 4 4M5 14v5h14v-5"/>
                            </svg>
                            <strong class="mt-2 block text-[10px] font-black uppercase text-white">Director Signature</strong>
                        </span>
                        <img id="director_signature-preview" class="hidden size-20 object-contain">
                        <input type="file" name="director_signature" required accept="image/*" class="sr-only" data-photo-input data-preview-id="director_signature-preview" data-placeholder-id="director_signature-placeholder">
                    </label>
                    <label class="group flex min-h-32 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/5 bg-[#03224c] p-4 text-center transition hover:border-amber-500/30">
                        <span id="nid_photo-placeholder">
                            <svg viewBox="0 0 24 24" class="mx-auto size-8 text-amber-500/50" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect width="18" height="12" x="3" y="6" rx="2" /><path d="M8 12h8" />
                            </svg>
                            <strong class="mt-2 block text-[10px] font-black uppercase text-white">NID Photo</strong>
                        </span>
                        <img id="nid_photo-preview" class="hidden size-20 object-contain">
                        <input type="file" name="nid_photo" required accept="image/*" class="sr-only" data-photo-input data-preview-id="nid_photo-preview" data-placeholder-id="nid_photo-placeholder">
                    </label>
                </div>
            </section>
            <section class="space-y-6">
                <div class="flex items-center gap-2 rounded-lg bg-[#03224c] px-4 py-2 ring-1 ring-white/5">
                    <svg viewBox="0 0 24 24" class="size-4 text-[#6cb2eb]" fill="none" stroke="currentColor" stroke-width="3">
                        <rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.15em] text-[#6cb2eb]">LOGIN CREDENTIALS</h2>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Username *
                        <input name="username" value="{{ old('username') }}" required placeholder="Choose username" class="{{ $inputClass }} mt-1.5">
                    </label>
                    <label class="block text-[11px] font-bold text-[#6cb2eb] uppercase tracking-wider">Password *
                        <input type="password" name="password" required minlength="8" placeholder="Minimum 8 characters" class="{{ $inputClass }} mt-1.5">
                    </label>
                </div>
            </section>
        </div>

        <label class="group flex cursor-pointer items-start gap-4 rounded-2xl border border-white/5 bg-[#03224c]/30 p-5 transition hover:bg-[#03224c]/50">
            <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-cyan-900/30 text-[#6cb2eb]">
                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
            </div>
            <div class="flex items-start gap-3 pt-1">
                <input type="checkbox" name="declaration" value="1" required class="mt-1 size-4 rounded border-slate-300 bg-white text-amber-500 focus:ring-amber-500 focus:ring-offset-[#1a2533]">
                <p class="text-[11px] font-bold leading-relaxed text-slate-400">
                    I hereby declare that all the information provided above is true and correct. I agree to abide by the rules and regulations of <span class="text-white">Bangladesh National Youth Technical Institute.</span>
                </p>
            </div>
        </label>

        <div class="flex flex-col justify-center gap-4 pt-4 sm:flex-row">
            <button class="inline-flex min-h-[55px] items-center justify-center gap-3 rounded-lg bg-amber-500 px-12 text-[14px] font-black uppercase tracking-widest text-[#03224c] shadow-lg shadow-amber-500/20 transition hover:bg-amber-400 active:scale-95">
                APPLICATION SUBMIT
            </button>
            <button type="reset" class="inline-flex min-h-[55px] items-center justify-center gap-3 rounded-lg bg-[#b89552] px-12 text-[14px] font-black uppercase tracking-widest text-white transition hover:opacity-90">
                <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="3">
                    <path d="M21 12a9 9 0 1 1-9-9c2.5 0 4.7 1 6.3 2.7L21 8m0 0h-5m5 0v-5" />
                </svg>
                RESET FORM
            </button>
            <a href="/" class="inline-flex min-h-[55px] items-center justify-center rounded-lg border border-slate-400 bg-slate-400/10 px-12 text-[14px] font-black uppercase tracking-widest text-slate-200 transition hover:bg-slate-400/20">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    function simulateScan(input) {
        if (!input.files || !input.files[0]) return;

        const container = document.querySelector('[data-branch-application-container]');
        container.classList.add('opacity-50', 'pointer-events-none');

        setTimeout(() => {
            const data = {
                director_name: 'MD. ABDUR RAHMAN',
                father_name: 'MD. ABDUL KARIM',
                mother_name: 'MST. KHADIZA BEGUM',
                dob: '1985-10-12',
                doc_number: '5501234567',
                full_address: '123, Green Road, Dhanmondi, Dhaka - 1205'
            };

            document.getElementById('field-director-name').value = data.director_name;
            document.getElementById('field-father-name').value = data.father_name;
            document.getElementById('field-mother-name').value = data.mother_name;
            document.getElementById('field-dob').value = data.dob;
            document.getElementById('field-doc-number').value = data.doc_number;
            document.getElementById('field-full-address').value = data.full_address;

            container.classList.remove('opacity-50', 'pointer-events-none');
            alert('Scan Complete! Data auto-filled.');
        }, 1500);
    }

    document.querySelectorAll('[data-scan-tab]').forEach(tab => {
        tab.addEventListener('click', () => {
            const type = tab.dataset.scanTab;
            document.getElementById('doc-type-selector').value = type;

            // Highlight active tab
            document.querySelectorAll('[data-scan-tab]').forEach(t => {
                t.classList.remove('ring-2', 'ring-amber-500', 'shadow-[0_0_20px_rgba(245,158,11,0.2)]');
            });
            tab.classList.add('ring-2', 'ring-amber-500', 'shadow-[0_0_20px_rgba(245,158,11,0.2)]');
        });
    });

    document.querySelectorAll('[data-photo-input]').forEach(input => {
        input.addEventListener('change', function(event) {
            const file = event.target.files?.[0];
            const previewId = this.dataset.previewId;
            const placeholderId = this.dataset.placeholderId;
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);

            if (!file || !preview || !placeholder) return;

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        });
    });
</script>

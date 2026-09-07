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
        'min-w-0 w-full rounded-lg border-0 bg-[#2d3d52] px-4 py-2.5 text-sm font-medium text-white shadow-inner outline-none transition placeholder:text-slate-500 focus:ring-2 focus:ring-amber-500/50';
    $selectClass = $inputClass . ' appearance-none';
    $sectionClass =
        'flex items-center gap-2 text-[11px] font-black uppercase tracking-[0.15em] text-cyan-400';
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" data-location-form
    data-upazilas='@json(config('bangladesh.upazilas'))' data-old-upazila="{{ old('upazila', $student?->upazila) }}"
    @class([
        'space-y-8 rounded-3xl bg-[#1a2533] p-6 shadow-2xl ring-1 ring-white/10 sm:p-10',
        'registration-form' => $declarationRequired,
    ])>
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    {{-- Auto-Scan Section --}}
    <div class="space-y-4">
        <div class="grid grid-cols-3 gap-3">
            @foreach([
                ['passport', 'Passport Scan', 'Scan Passport for Auto-Fill'],
                ['nid', 'NID Scan', 'Scan National ID (NID) for Auto-Fill'],
                ['birth', 'Birth Registration Scan', 'Scan Birth Registration (জন্ম নিবন্ধন) for Auto-Fill']
            ] as [$key, $label, $desc])
                <button type="button" class="group relative flex items-center gap-3 rounded-xl border border-white/10 bg-[#253447] p-3 text-left transition hover:border-amber-500/50 hover:bg-[#2d3d52]">
                    <div class="grid size-10 shrink-0 place-items-center rounded-lg bg-[#1a2533] text-amber-500 shadow-lg group-hover:scale-110 transition-transform">
                        @if($key === 'passport')
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19.5V5a2 2 0 0 1 2-2h11l3.5 3.5V19.5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2z"/><circle cx="12" cy="11" r="3"/><path d="M7 17h10"/></svg>
                        @elseif($key === 'nid')
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="1.8"><rect width="18" height="12" x="3" y="6" rx="2"/><circle cx="9" cy="12" r="2"/><path d="M15 10h4M15 14h4"/></svg>
                        @else
                            <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-black text-white/90 uppercase tracking-wider">[{{ $label }}]</p>
                        <p class="truncate text-[9px] font-bold text-slate-400">{{ $desc }}</p>
                    </div>
                    @if($key === 'birth')
                        <div class="absolute -top-1 -right-1 size-3 animate-pulse rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.6)]"></div>
                    @endif
                </button>
            @endforeach
        </div>

        <div class="rounded-2xl bg-[#0f1721] p-6 shadow-inner ring-1 ring-white/5">
             <div class="flex items-center gap-3 border-b border-white/5 pb-4 mb-6">
                 <svg viewBox="0 0 24 24" class="size-4 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="12" x="3" y="6" rx="2"/><path d="M8 12h8"/></svg>
                 <h2 class="text-xs font-black text-amber-500 uppercase tracking-widest">PASSPORT / NID AUTO-SCAN</h2>
             </div>

             <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto_auto]">
                 <div class="flex items-center gap-6">
                     <div class="relative group cursor-pointer">
                         <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 opacity-25 blur transition group-hover:opacity-50"></div>
                         <div class="relative grid size-16 place-items-center rounded-full bg-[#1a2533] text-amber-500 shadow-2xl transition group-hover:scale-105">
                             <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                         </div>
                     </div>
                     <div>
                         <h3 class="text-lg font-black text-white">Scan Document NOW</h3>
                         <p class="text-xs font-bold text-slate-500 uppercase tracking-tighter mt-1">Select Document Type and Upload clear image or use webcam</p>
                     </div>
                 </div>

                 <button type="button" class="group flex items-center gap-4 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 px-6 py-4 shadow-[0_10px_30px_rgba(245,158,11,0.2)] transition hover:scale-[1.02] active:scale-95">
                     <div class="grid size-10 place-items-center rounded-lg bg-black/10 text-white">
                         <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 16V4m0 0L8 8m4-4 4 4M5 14v5h14v-5"/></svg>
                     </div>
                     <div class="text-left">
                         <p class="text-xs font-black text-white uppercase tracking-wider leading-none">SCAN DOCUMENT NOW</p>
                         <p class="mt-1 text-[9px] font-bold text-white/70 uppercase">Upload clear Image or use webcam (JPG/PNG, Max 5MB)</p>
                     </div>
                 </button>

                 <div class="min-w-40">
                     <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Select Document Type *</label>
                     <select class="w-full rounded-lg border-0 bg-[#2d3d52] px-4 py-3 text-sm font-black text-white outline-none ring-1 ring-white/10 transition focus:ring-2 focus:ring-amber-500">
                         <option>Passport</option>
                         <option selected>NID</option>
                         <option>Birth Registration</option>
                     </select>
                 </div>
             </div>
        </div>
    </div>

    <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,.9fr)_minmax(0,1.2fr)_minmax(260px,.85fr)] pt-4">
        <section class="min-w-0 space-y-6" aria-labelledby="personal-information-heading">
            <h2 id="personal-information-heading" class="{{ $sectionClass }}">
                <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="8" r="3"/><path d="M5 21c.5-4 2.8-6 7-6s6.5 2 7 6"/></svg>
                PERSONAL INFORMATION
            </h2>
            <div class="space-y-4">
                <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Name *
                    <input name="name" value="{{ old('name', $student?->name) }}"
                        required placeholder="Enter full name" class="{{ $inputClass }} mt-1.5">
                    @error('name')
                        <span class="mt-1 block text-[10px] font-bold text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Father's Name *
                    <input name="father_name"
                        value="{{ old('father_name', $student?->father_name) }}" required placeholder="Enter father's name"
                        class="{{ $inputClass }} mt-1.5">
                    @error('father_name')
                        <span class="mt-1 block text-[10px] font-bold text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mother's Name *
                    <input name="mother_name"
                        value="{{ old('mother_name', $student?->mother_name) }}" required placeholder="Enter mother's name"
                        class="{{ $inputClass }} mt-1.5">
                    @error('mother_name')
                        <span class="mt-1 block text-[10px] font-bold text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Date of Birth *
                    <input type="date" name="date_of_birth"
                        value="{{ old('date_of_birth', $student?->date_of_birth?->format('Y-m-d')) }}" required
                        class="{{ $inputClass }} mt-1.5 text-slate-400">
                    @error('date_of_birth')
                        <span class="mt-1 block text-[10px] font-bold text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
                <fieldset class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    <legend class="mb-2">Sex *</legend>
                    <div class="flex flex-wrap gap-6">
                        @foreach (['Male', 'Female', 'Other'] as $sex)
                            <label class="flex items-center gap-2 cursor-pointer text-white lowercase first-letter:uppercase tracking-normal font-medium">
                                <input type="radio" name="gender"
                                    value="{{ $sex }}" @checked(old('gender', $student?->gender) === $sex) required
                                    class="size-4 bg-[#2d3d52] border-0 text-amber-500 focus:ring-offset-[#1a2533] focus:ring-amber-500">
                                {{ $sex }}
                            </label>
                        @endforeach
                    </div>
                </fieldset>
                <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider pt-2">Passport / NID Number *
                    <input name="passport_nid_number"
                        value="{{ old('passport_nid_number', $student?->passport_nid_number) }}" required
                        placeholder="Enter Passport or NID Number" class="{{ $inputClass }} mt-1.5">
                    @error('passport_nid_number')
                        <span class="mt-1 block text-[10px] font-bold text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
                <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Phone Number *
                    <input type="tel" name="phone"
                        value="{{ old('phone', $student?->phone) }}" required placeholder="Enter phone number"
                        class="{{ $inputClass }} mt-1.5">
                    @error('phone')
                        <span class="mt-1 block text-[10px] font-bold text-rose-500">{{ $message }}</span>
                    @enderror
                </label>
            </div>
        </section>

        <div class="space-y-8">
            <section class="min-w-0 space-y-6" aria-labelledby="address-information-heading">
                <h2 id="address-information-heading" class="{{ $sectionClass }}">
                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"/><circle cx="12" cy="9" r="2.2"/></svg>
                    ADDRESS INFORMATION
                </h2>
                <div class="space-y-4">
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Full Address *
                        <textarea name="address" rows="3" required placeholder="Enter full address" class="{{ $inputClass }} mt-1.5">{{ old('address', $student?->address) }}</textarea>
                        @error('address')
                            <span class="mt-1 block text-[10px] font-bold text-rose-500">{{ $message }}</span>
                        @enderror
                    </label>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">District *
                            <select name="district" data-district-select required class="{{ $selectClass }} mt-1.5">
                                <option value="">Select district</option>
                                @foreach (config('bangladesh.districts') as $district)
                                    <option value="{{ $district }}" @selected(old('district', $student?->district) === $district)>{{ $district }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Upazila *
                            <select name="upazila" data-upazila-select required disabled class="{{ $selectClass }} mt-1.5">
                                <option value="">No upazilas found</option>
                            </select>
                        </label>
                    </div>
                </div>
            </section>

            <section class="min-w-0 space-y-6" aria-labelledby="academic-information-heading">
                <h2 id="academic-information-heading" class="{{ $sectionClass }}">
                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 9 12 4l9 5-9 5zM6 11v5c2.8 2.3 9.2 2.3 12 0v-5M21 9v7"/></svg>
                    ACADEMIC INFORMATION
                </h2>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Education Qualification *
                        <select name="education_qualification" required class="{{ $selectClass }} mt-1.5">
                            <option selected>জানুয়ারি (January)</option>
                        </select>
                    </label>
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Session Details *
                        <select name="session" required class="{{ $selectClass }} mt-1.5">
                            <option selected>২০২১, ২০২২, ২০২৩,</option>
                        </select>
                    </label>
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">কোর্স শুরুর মাস *
                        <select name="start_month" required class="{{ $selectClass }} mt-1.5">
                            <option selected>ফেব্রুয়ারি (February)</option>
                        </select>
                    </label>
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">কোর্স শুরুর বছর *
                        <select name="start_year" required class="{{ $selectClass }} mt-1.5">
                            <option selected>২০২১, ২০২৪, ২০২৭,</option>
                        </select>
                    </label>
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Department *
                        <select name="course_id" required class="{{ $selectClass }} mt-1.5">
                            <option value="">Select department</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" @selected(old('course_id', $student?->course_id) == $course->id)>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Join Date *
                        <input type="date" name="admitted_at" required value="2028-02-08" class="{{ $inputClass }} mt-1.5 text-slate-400">
                    </label>
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Duration *
                        <select name="duration" required class="{{ $selectClass }} mt-1.5">
                            <option>Select duration</option>
                        </select>
                    </label>
                    <label class="block min-w-0 text-[11px] font-bold text-slate-400 uppercase tracking-wider">Expire Date *
                        <input type="date" name="expire_date" required class="{{ $inputClass }} mt-1.5 text-slate-400">
                    </label>
                </div>
            </section>
        </div>

        <aside class="space-y-6">
            <section class="space-y-4">
                <h2 class="{{ $sectionClass }}">
                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 7h4l1.5-2h5L16 7h4v12H4z"/><circle cx="12" cy="13" r="3.5"/></svg>
                    PHOTO UPLOAD
                </h2>
                <label for="student-photo" class="group flex min-h-48 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-white/10 bg-[#0f1721] p-5 text-center transition hover:border-amber-500/50 hover:bg-[#1a2533]">
                    <span id="photo-placeholder" class="grid place-items-center">
                        <div class="relative grid size-14 place-items-center rounded-full bg-[#2d3d52] text-amber-500 shadow-xl transition group-hover:scale-105">
                             <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></svg>
                        </div>
                        <strong class="mt-4 block text-[10px] font-black text-white uppercase tracking-wider">Upload Passport Size Photo</strong>
                        <span class="mt-1 block text-[9px] font-bold text-slate-500 uppercase">JPG / PNG / WebP, Max 5MB</span>
                    </span>
                    <img id="photo-preview" class="hidden size-32 rounded-xl object-cover shadow-2xl ring-2 ring-white/10">
                </label>
                <input id="student-photo" type="file" name="image" accept="image/jpeg,image/png,image/webp" @required(!$student?->image_path) class="sr-only" data-photo-input>
            </section>

            <section class="rounded-2xl border border-white/10 bg-[#253447] p-6 shadow-xl ring-1 ring-white/5">
                <h2 class="flex items-center gap-2 text-[11px] font-black text-cyan-400 uppercase tracking-widest">
                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4m0-4h.01"/></svg>
                    IMPORTANT NOTES
                </h2>
                <ul class="mt-5 space-y-3 text-[10px] font-bold text-slate-300">
                    <li class="flex items-center gap-2"><span class="text-amber-500">✓</span> Fill all the fields carefully.</li>
                    <li class="flex items-center gap-2"><span class="text-amber-500">✓</span> Ensure your information is correct.</li>
                    <li class="flex items-center gap-2"><span class="text-amber-500">✓</span> You can update information later.</li>
                    <li class="flex items-center gap-2"><span class="text-amber-500">✓</span> Keep your documents ready.</li>
                </ul>
            </section>
        </aside>
    </div>

    @if ($declarationRequired)
        <label class="group flex cursor-pointer items-start gap-4 rounded-2xl border border-white/10 bg-[#0f1721] p-5 transition hover:bg-[#1a2533]">
            <div class="grid size-10 shrink-0 place-items-center rounded-xl bg-cyan-950/50 text-cyan-400 group-hover:bg-cyan-900 group-hover:text-cyan-300 transition-colors">
                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div class="flex items-start gap-3 pt-1">
                <input type="checkbox" name="declaration" value="1" @checked(old('declaration')) required class="mt-1 size-4 rounded border-0 bg-[#2d3d52] text-amber-500 focus:ring-offset-[#0f1721] focus:ring-amber-500">
                <p class="text-[11px] font-bold leading-relaxed text-slate-400">
                    I hereby declare that all the information provided above is true and correct. I agree to abide by the rules and regulations of <span class="text-white">South Asia Engineering & Technical Institute.</span>
                </p>
            </div>
        </label>
    @endif

    <div class="flex flex-col justify-center gap-4 pt-4 sm:flex-row">
        <button class="inline-flex min-h-12 items-center justify-center gap-3 rounded-lg bg-gradient-to-br from-amber-500 to-orange-600 px-10 text-xs font-black text-white shadow-[0_10px_30px_rgba(245,158,11,0.2)] transition hover:scale-[1.02] active:scale-95 uppercase tracking-widest">
            APPLICATION SUBMIT
        </button>
        <button type="reset" class="inline-flex min-h-12 items-center justify-center gap-3 rounded-lg bg-[#3d4d5e] px-10 text-xs font-black text-white transition hover:bg-[#4a5b6d] uppercase tracking-widest">
            :: RESET FORM
        </button>
        @if ($cancelRoute)
            <a href="{{ $cancelRoute }}" class="inline-flex min-h-12 items-center justify-center rounded-lg border border-white/10 px-10 text-xs font-black text-slate-400 hover:text-white transition uppercase tracking-widest">
                Cancel
            </a>
        @endif
    </div>
</form>

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

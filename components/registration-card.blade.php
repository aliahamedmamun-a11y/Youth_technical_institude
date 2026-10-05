@props([
    'student',
    'serial',
    'instituteCode',
    'instituteName' => 'Bangladesh Technical Training Institute',
    'qrCode' => null,
    'qrUrl' => null,
    'printedAt' => null,
])

@vite(['resources/css/app.css', 'resources/css/registration-card.css', 'resources/js/app.js'])

<main class="registration-card-screen">
    <h1 class="sr-only">Registration Card for {{ $student->name }}</h1>

    <div class="registration-card-frame">
        <article class="registration-card" aria-label="Registration card for {{ $student->name }}">
            {{-- Background registration card template containing layout and static borders/text --}}
            <img class="registration-card__template" src="{{ asset('images/registration-card-template.png') }}" alt="Registration Card Background">

            {{-- Dynamic Serial No overlay --}}
            <div class="rc-field rc-field--serial">
                {{ $serial ?? '036564' }}
            </div>

            {{-- Top Right Photo and QR Code Overlay --}}
            <aside class="rc-meta-right">
                <figure class="registration-card__photo">
                    @if ($student->image_path)
                        <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo of {{ $student->name }}">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-[8px] text-slate-400">
                            NO PHOTO
                        </div>
                    @endif
                </figure>

                @if($qrCode)
                    <div class="registration-card__qr">
                        <img src="{{ $qrCode }}" alt="QR Verification">
                    </div>
                @endif
            </aside>

            {{-- Main Data Rows Overlays --}}
            <div class="registration-card__data-box">
                <div class="rc-row">
                    <span class="rc-label">Registration Number</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->registration_number ?? '50936900' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Name of Student</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->name }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Father's Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->father_name ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Mother's Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->mother_name ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Gender</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->gender ?? 'Male' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Institute Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->institute_name ?? $instituteName }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Student Thana</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->upazila ?? $student->thana ?? 'Madarganj' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Student District</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->district ?? 'Jamalpur' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Course Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->course?->name ?? 'Diploma in Electrician' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Course Duration</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->duration ?? $student->course?->duration ?? "4 Year's" }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Session</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->session ?? '2020 - 2023' }}</span>
                </div>
            </div>
        </article>
    </div>

    <nav class="registration-card-actions print:hidden" aria-label="Registration card actions">
        <button type="button" data-print-document onclick="window.print()" class="rounded-full bg-blue-800 px-5 py-3 font-black text-white transition hover:bg-blue-700 cursor-pointer">
            Print registration card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

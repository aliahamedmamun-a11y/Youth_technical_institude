@props([
    'student',
    'serial',
    'instituteCode',
    'instituteName',
    'qrCode',
    'qrUrl',
    'printedAt',
])

@vite(['resources/css/app.css', 'resources/css/registration-card.css', 'resources/js/app.js'])

<main class="registration-card-screen">
    <h1 class="sr-only">Registration Card for {{ $student->name }}</h1>

    <div class="registration-card-frame">
        <article class="registration-card" aria-label="Registration card for {{ $student->name }}">
            <img class="registration-card__template" src="{{ asset('images/registration-card-template.png') }}" alt="">

            <div class="registration-card__header">
                <p class="registration-card__approved">Approved by Govt. of The People's Republic of Bangladesh</p>
                <h2 class="registration-card__title-en">Bangladesh National Technical Education Institute</h2>
                <h2 class="registration-card__title-bn">বাংলাদেশ জাতীয় কারিগরি শিক্ষা ইনস্টিটিউট</h2>
                <div class="registration-card__badge-wrapper">
                    <span class="registration-card__badge">Registration Card</span>
                </div>
                <h3 class="registration-card__course-title">{{ $student->course?->name ?? '—' }}</h3>
            </div>

            <div class="registration-card__logo">
                <img src="{{ asset('images/Logo.png') }}" alt="BNTEI Logo">
            </div>

            <p class="registration-card__serial"><span>Serial No.</span> <span class="registration-card__serial-number">{{ $serial }}</span></p>

            <dl class="registration-card__details" aria-label="Student registration information">
                <div><dt>Registration Number</dt><dd>{{ $student->registration_number ?? '—' }}</dd></div>
                <div><dt>Name of Student</dt><dd>{{ $student->name ?? '—' }}</dd></div>
                <div><dt>Father's Name</dt><dd>{{ $student->father_name ?? '—' }}</dd></div>
                <div><dt>Mother's Name</dt><dd>{{ $student->mother_name ?? '—' }}</dd></div>
                <div><dt>Gender</dt><dd>{{ $student->gender ?? '—' }}</dd></div>
                <div><dt>Institute Name</dt><dd>{{ $instituteName }}</dd></div>
                <div><dt>Student Thana</dt><dd>{{ $student->upazila ?? '—' }}</dd></div>
                <div><dt>Student District</dt><dd>{{ $student->district ?? '—' }}</dd></div>
                <div><dt>Course Name</dt><dd>{{ $student->course?->name ?? '—' }}</dd></div>
                <div><dt>Course Duration</dt><dd>{{ $student->duration ?? $student->course?->duration ?? '—' }}</dd></div>
                <div><dt>Session</dt><dd>{{ $student->session ?? '—' }}</dd></div>
            </dl>

            <div class="registration-card__right-side">
                <figure class="registration-card__photo">
                    @if ($student->image_path)
                        <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo of {{ $student->name }}">
                    @else
                        <div class="registration-card__photo-placeholder" aria-label="Student photo not available">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" />
                            </svg>
                        </div>
                    @endif
                </figure>

                <div class="registration-card__qr">
                    <img src="{{ $qrCode }}" alt="QR code for {{ $qrUrl }}">
                </div>
            </div>

            <div class="registration-card__signatures">
                <div class="registration-card__sig-student">
                    <div class="registration-card__sig-line"></div>
                    <p>Signature of the Student</p>
                </div>
                <div class="registration-card__sig-head">
                    <div class="registration-card__sig-placeholder">Saiful</div>
                    <div class="registration-card__sig-line"></div>
                    <p>Signature of Head of the Institute</p>
                </div>
                <div class="registration-card__sig-secretary">
                    <div class="registration-card__sig-placeholder">Jahid</div>
                    <p class="registration-card__sig-name">Deputy Secretary</p>
                    <p>(Registration)</p>
                </div>
            </div>

            <div class="registration-card__notes">
                <p>1. This registration card is valid for Six Months.</p>
                <p>2. For all communications with the board, institute code, registration number and session is to be mentioned.</p>
            </div>
        </article>
    </div>

    <nav class="registration-card-actions print:hidden" aria-label="Registration card actions">
        <button type="button" data-print-document class="rounded-full bg-blue-800 px-5 py-3 font-black text-white transition hover:bg-blue-700">
            Print registration card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

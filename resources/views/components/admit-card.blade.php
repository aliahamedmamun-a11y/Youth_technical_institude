@props([
    'student',
    'serial',
    'instituteCode',
    'instituteName',
    'examineeType',
    'qrCode',
    'qrUrl',
    'printedAt',
])

@vite(['resources/css/app.css', 'resources/css/admit-card.css', 'resources/js/app.js'])

<main class="admit-card-screen">
    <h1 class="sr-only">Admit Card for {{ $student->name }}</h1>

    <div class="admit-card-frame">
        <article class="admit-card" aria-label="Admit card for {{ $student->name }}">
            <img class="admit-card__template" src="{{ asset('images/admit-card-template.png') }}" alt="">

            <div class="admit-card__header">
                <p class="admit-card__approved">Approved by Govt. of The People's Republic of Bangladesh</p>
                <h2 class="admit-card__title-en">Bangladesh National Technical Education Institute</h2>
                <h2 class="admit-card__title-bn">বাংলাদেশ জাতীয় কারিগরি শিক্ষা ইনস্টিটিউট</h2>
                <div class="admit-card__badge-wrapper">
                    <span class="admit-card__badge">Admit Card</span>
                </div>
            </div>

            <div class="admit-card__logo">
                <img src="{{ asset('images/Logo.png') }}" alt="BNTEI Logo">
                <p>www.bntei.com</p>
            </div>

            <p class="admit-card__serial"><span>Serial No.</span> <span class="admit-card__serial-number">{{ $serial }}</span></p>

            <dl class="admit-card__student-details" aria-label="Student information">
                <div><dt>Name of the Institute</dt><dd>{{ $instituteName }}</dd></div>
                <div><dt>Name of the Student</dt><dd>{{ $student->name }}</dd></div>
                <div><dt>Father's Name</dt><dd>{{ $student->father_name ?? '—' }}</dd></div>
                <div><dt>Mother's Name</dt><dd>{{ $student->mother_name ?? '—' }}</dd></div>
                <div><dt>Date of Birth</dt><dd>{{ $student->date_of_birth?->format('Y-m-d') ?? '—' }}</dd></div>
                <div><dt>Session</dt><dd>{{ $student->session ?? '—' }}</dd></div>
                <div><dt>Subject Name</dt><dd>{{ $student->course?->name ?? '—' }}</dd></div>
            </dl>

            <figure class="admit-card__photo">
                @if ($student->image_path)
                    <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo of {{ $student->name }}">
                @else
                    <div class="admit-card__photo-placeholder" aria-label="Student photo not available">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" />
                        </svg>
                        <span>No photo</span>
                    </div>
                @endif
            </figure>

            <dl class="admit-card__exam-details" aria-label="Examination information">
                <div class="admit-card__exam-number"><dt>Roll.No</dt><dd>{{ $student->roll_number ?? '—' }}</dd></div>
                <div class="admit-card__exam-number"><dt>Reg.No</dt><dd>{{ $student->registration_number ?? '—' }}</dd></div>
                <div><dt>Sex</dt><dd>{{ $student->gender ?? '—' }}</dd></div>
                <div class="admit-card__examinee-type"><dt>Type of the Examinee</dt><dd>{{ $examineeType }}</dd></div>
            </dl>

            <div class="admit-card__directions">
                <h3>Directions:</h3>
                <ol>
                    <li>The Examinee must bring the Registration Card along with the Admit Card in the examination hall.</li>
                    <li>The examinee must sign in the attendance sheet otherwise examinee will be treated as absent.</li>
                </ol>
            </div>

            <a class="admit-card__qr" href="{{ $qrUrl }}" aria-label="Open institute website">
                <img src="{{ $qrCode }}" alt="QR code for {{ $qrUrl }}">
                <span>Scan to Verify</span>
            </a>

            <div class="admit-card__signature">
                <div class="admit-card__signature-placeholder">Saiful</div>
                <div class="admit-card__signature-line"></div>
                <p>Controller of Examinations</p>
                <p>Bangladesh National Technical Education Institute</p>
            </div>

            <p class="admit-card__printing-date">Printing Date: {{ $printedAt->format('j M Y') }}</p>
        </article>
    </div>

    <nav class="admit-card-actions print:hidden" aria-label="Admit card actions">
        <button type="button" data-print-document class="rounded-full bg-blue-800 px-5 py-3 font-black text-white transition hover:bg-blue-700">
            Print admit card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

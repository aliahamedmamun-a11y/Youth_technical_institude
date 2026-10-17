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

            <p class="admit-card__serial"><span class="sr-only">Serial No.</span>{{ $serial }}</p>

            <dl class="admit-card__student-details" aria-label="Student information">
                <div><dt class="sr-only">Name of the Institute</dt><dd>{{ $student->branch?->name ?? $student->institute_name ?? $instituteName }}</dd></div>
                <div><dt class="sr-only">Name of the Student</dt><dd>{{ $student->name }}</dd></div>
                <div><dt class="sr-only">Father's Name</dt><dd>{{ $student->father_name ?? '—' }}</dd></div>
                <div><dt class="sr-only">Mother's Name</dt><dd>{{ $student->mother_name ?? '—' }}</dd></div>
                <div><dt class="sr-only">Date of Birth</dt><dd>{{ $student->date_of_birth?->format('d M Y') ?? '—' }}</dd></div>
                <div><dt class="sr-only">Session</dt><dd>{{ $student->session ?? '—' }}</dd></div>
            </dl>

            <div class="admit-card__subject-name">
                <span class="sr-only">Subject Name</span>{{ $student->course?->name ?? '—' }}
            </div>

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
                <div class="admit-card__exam-number admit-card__exam-roll"><dt class="sr-only">Roll.No</dt><dd>{{ $student->roll_number ?? '—' }}</dd></div>
                <div class="admit-card__exam-number admit-card__exam-reg"><dt class="sr-only">Reg.No</dt><dd>{{ $student->registration_number ?? '—' }}</dd></div>
                <div class="admit-card__exam-gender"><dt class="sr-only">Sex</dt><dd>{{ $student->gender ?? '—' }}</dd></div>
                <div class="admit-card__examinee-type"><dt class="sr-only">Type of the Examinee</dt><dd>{{ $examineeType }}</dd></div>
            </dl>

            <a class="admit-card__qr" href="{{ $qrUrl }}" aria-label="Open institute website">
                <img src="{{ $qrCode }}" alt="QR code for {{ $qrUrl }}">
                <span>Scan to Verify</span>
            </a>

            <p class="admit-card__printing-date">Printing Date: {{ $printedAt->format('j M Y') }}</p>
        </article>
    </div>

    <nav class="admit-card-actions print:hidden" aria-label="Admit card actions">
        <button type="button" data-print-document class="rounded-full bg-blue-800 px-5 py-3 font-black text-white transition hover:bg-blue-700 cursor-pointer">
            Print admit card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('[data-print-document]').forEach(btn => {
                btn.addEventListener('click', function () {
                    let styleTag = document.getElementById('print-orientation-style');
                    if (!styleTag) {
                        styleTag = document.createElement('style');
                        styleTag.id = 'print-orientation-style';
                        document.head.appendChild(styleTag);
                    }
                    styleTag.textContent = '@page { size: landscape; margin: 0; } @media print { @page { size: landscape; margin: 0; } html, body, .admit-card-screen, .admit-card-frame, .admit-card { width: 100% !important; height: 100% !important; margin: 0 !important; padding: 0 !important; overflow: hidden !important; } }';

                    setTimeout(() => window.print(), 100);
                });
            });
        });
    </script>
</main>

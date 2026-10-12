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
            <img class="admit-card__template" src="{{ asset('images/admit-card-template.png') }}" alt="Admit Card Template">

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
                @if ($student->image_path && file_exists(public_path('storage/'.$student->image_path)))
                    <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo of {{ $student->name }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="admit-card__photo-placeholder" style="display:none;" aria-label="Student photo not available">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Passport Photo</span>
                    </div>
                @else
                    <div class="admit-card__photo-placeholder" aria-label="Student photo not available">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <span>Passport Photo</span>
                    </div>
                @endif
            </figure>

            <!-- Right side examination values aligned directly into template boxes with bold/deep font -->
            <div class="admit-card__exam-roll"><span class="sr-only">Roll.No</span>{{ $student->roll_number ?? '—' }}</div>
            <div class="admit-card__exam-reg"><span class="sr-only">Reg.No</span>{{ $student->registration_number ?? '—' }}</div>
            <div class="admit-card__exam-gender"><span class="sr-only">Sex</span>{{ $student->gender ?? 'Male' }}</div>
            <div class="admit-card__examinee-type"><span class="sr-only">Type of the Examinee</span>{{ $examineeType ?? 'Regular' }}</div>

            <a class="admit-card__qr" href="{{ $qrUrl }}" aria-label="Open institute website">
                <img src="{{ $qrCode }}" alt="QR code for {{ $qrUrl }}">
                <span>Scan to Verify</span>
            </a>

            <p class="admit-card__printing-date">Printing Date: {{ $printedAt->format('j M Y') }}</p>
        </article>
    </div>

    <nav class="admit-card-actions print:hidden" aria-label="Admit card actions">
        <button type="button" data-print-document class="rounded-xl bg-[#03224c] hover:bg-slate-800 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-slate-700">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            Print Admit Card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back to student
        </a>
    </nav>
</main>

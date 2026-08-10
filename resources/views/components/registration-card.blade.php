@props([
    'student',
    'serial',
    'instituteCode',
    'instituteName',
    'qrCode',
    'qrUrl',
])

@vite(['resources/css/app.css', 'resources/css/registration-card.css', 'resources/js/app.js'])

<main class="registration-card-screen">
    <h1 class="sr-only">Registration Card for {{ $student->name }}</h1>

    <div class="registration-card-frame">
        <article class="registration-card" aria-label="Registration card for {{ $student->name }}">
            <img class="registration-card__template" src="{{ asset('images/registration-card-template.png') }}" alt="">

            <h2 class="registration-card__course">{{ $student->course?->name ?? '—' }}</h2>
            <p class="registration-card__serial"><span>Serial:</span> {{ $serial }}</p>

            <dl class="registration-card__details" aria-label="Student registration information">
                <div><dt>Reg Number</dt><dd>{{ $student->registration_number ?? '—' }}</dd></div>
                <div><dt>Student Name</dt><dd>{{ $student->name ?? '—' }}</dd></div>
                <div><dt>Father's Name</dt><dd>{{ $student->father_name ?? '—' }}</dd></div>
                <div><dt>Mother's Name</dt><dd>{{ $student->mother_name ?? '—' }}</dd></div>
                <div><dt>Date of Birth</dt><dd>{{ $student->date_of_birth?->format('d M Y') ?? '—' }}</dd></div>
                <div><dt>Sex</dt><dd>{{ $student->gender ?? '—' }}</dd></div>
                <div><dt>Institute Name</dt><dd>{{ $instituteName }}</dd></div>
                <div><dt>Institute Code</dt><dd>{{ $instituteCode }}</dd></div>
                <div><dt>Upazilla/Thana</dt><dd>{{ $student->upazila ?? '—' }}</dd></div>
                <div><dt>District</dt><dd>{{ $student->district ?? '—' }}</dd></div>
                <div><dt>Subject Name</dt><dd>{{ $student->course?->name ?? '—' }}</dd></div>
                <div><dt>Session</dt><dd>{{ $student->session ?? '—' }}</dd></div>
                <div><dt>Duration</dt><dd>{{ $student->duration ?? $student->course?->duration ?? '—' }}</dd></div>
            </dl>

            <figure class="registration-card__photo">
                @if ($student->image_path)
                    <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo of {{ $student->name }}">
                @else
                    <div class="registration-card__photo-placeholder" aria-label="Student photo not available">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" />
                        </svg>
                        <span>No photo</span>
                    </div>
                @endif
            </figure>

            <a class="registration-card__qr" href="{{ $qrUrl }}" aria-label="Open institute website">
                <img src="{{ $qrCode }}" alt="QR code for {{ $qrUrl }}">
            </a>
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

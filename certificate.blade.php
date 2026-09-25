@props([
    'student',
    'latestResult' => null,
    'cumulativeGpa' => null,
    'certificateSerial' => null,
])

@php
    $certificateGpa = $cumulativeGpa ?? $latestResult?->gpa;
@endphp

@vite(['resources/css/app.css', 'resources/css/certificate.css', 'resources/js/app.js'])

<main class="certificate-screen">
    <h1 class="sr-only">Certificate for {{ $student->name }}</h1>

    <div class="certificate-frame">
        <article class="certificate-document" aria-label="Certificate for {{ $student->name }}">
            <img class="certificate-template" src="{{ asset('images/certificate-template.png') }}" alt="">

            <span class="certificate-data certificate-data--serial">{{ $certificateSerial ?? '—' }}</span>
            <span class="certificate-data certificate-data--registration">{{ $student->registration_number ?? '—' }}</span>
            <span class="certificate-data certificate-data--session">{{ $latestResult?->session ?? $student->session ?? '—' }}</span>
            <span class="certificate-data certificate-data--student">{{ $student->name }}</span>
            <span class="certificate-data certificate-data--father">{{ $student->father_name ?? '—' }}</span>
            <span class="certificate-data certificate-data--mother">{{ $student->mother_name ?? '—' }}</span>
            <span class="certificate-data certificate-data--course">{{ $student->course?->name ?? '—' }}</span>
            <span class="certificate-data certificate-data--roll">{{ $student->roll_number ?? '—' }}</span>
            <span class="certificate-data certificate-data--semester">{{ $latestResult?->semester ?? '—' }}</span>
            <span class="certificate-data certificate-data--month">{{ $latestResult?->published_at?->format('F Y') ?? '—' }}</span>
            <span class="certificate-data certificate-data--gpa">{{ $certificateGpa !== null ? number_format((float) $certificateGpa, 2) : '—' }}</span>
            <span class="certificate-data certificate-data--date">{{ $latestResult?->published_at?->format('d/m/Y') ?? '—' }}</span>
        </article>
    </div>

    <nav class="certificate-actions print:hidden" aria-label="Certificate actions">
        <button type="button" data-print-document class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white transition hover:bg-emerald-600">
            Print certificate
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

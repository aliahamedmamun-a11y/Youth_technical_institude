@props([
    'student',
    'latestResult' => null,
    'cumulativeGpa' => null,
    'certificateSerial' => null,
    'qrCode' => null,
    'qrUrl' => null,
])

@php
    $certificateGpa = $cumulativeGpa ?? $latestResult?->gpa;
@endphp

@vite(['resources/css/app.css', 'resources/css/certificate.css', 'resources/js/app.js'])

<main class="certificate-screen">
    <h1 class="sr-only">Certificate for {{ $student->name }}</h1>

    <div class="certificate-frame">
        <article class="certificate-document" aria-label="Certificate for {{ $student->name }}">
            {{-- Background certificate template containing pre-printed text and borders --}}
            <img class="certificate-template" src="{{ asset('images/certificate-template.png') }}" alt="Certificate Template Background">

            {{-- QR Code Layer --}}
            @if($qrCode)
                <div class="cert-qr-code">
                    <img src="{{ $qrCode }}" alt="Verification QR Code" class="w-full h-full">
                </div>
            @endif

            {{-- Dynamic Values precisely overlaying the lines --}}
            <div class="cert-field cert-field--serial" aria-label="Serial Number">
                {{ $certificateSerial ?? '036564' }}
            </div>

            <div class="cert-field cert-field--reg-no" aria-label="Registration Number">
                {{ $student->registration_number ?? '50936900' }}
            </div>

            <div class="cert-field cert-field--session" aria-label="Session">
                {{ $latestResult?->session ?? $student->session ?? '2020 - 2023' }}
            </div>

            <div class="cert-field cert-field--name" aria-label="Student Name">
                {{ $student->name }}
            </div>

            <div class="cert-field cert-field--father" aria-label="Father's Name">
                {{ $student->father_name ?? '—' }}
            </div>

            <div class="cert-field cert-field--mother" aria-label="Mother's Name">
                {{ $student->mother_name ?? '—' }}
            </div>

            <div class="cert-field cert-field--institute" aria-label="Institute Name">
                {{ $student->institute_name ?? 'Bangladesh Technical Training Institute' }}
            </div>

            <div class="cert-field cert-field--roll" aria-label="Roll Number">
                {{ $student->roll_number ?? '906912' }}
            </div>

            <div class="cert-field cert-field--course" aria-label="Course Name">
                {{ $student->course?->name ?? 'Diploma in Electrician' }}
            </div>

            <div class="cert-field cert-field--exam-held" aria-label="Examination Held Month/Year">
                {{ $latestResult?->published_at?->format('M Y') ?? 'Dec 2023' }}
            </div>

            <div class="cert-field cert-field--cgpa" aria-label="Secured CGPA">
                {{ $certificateGpa !== null ? number_format((float) $certificateGpa, 2) : '3.75' }}
            </div>

            <div class="cert-field cert-field--publication-date" aria-label="Date of Publication of Result">
                {{ $latestResult?->published_at?->format('d-M-Y') ?? '15-Feb-2024' }}
            </div>
        </article>
    </div>

    <nav class="certificate-actions print:hidden">
        <button type="button" data-print-document onclick="window.print()" class="rounded-full bg-emerald-700 px-8 py-3 font-black text-white transition hover:bg-emerald-600 cursor-pointer">
            Print Certificate
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-8 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back
        </a>
    </nav>
</main>

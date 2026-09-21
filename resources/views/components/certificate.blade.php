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
            {{-- Template Image provides the background and dotted lines --}}
            <img class="certificate-template" src="{{ asset('images/certificate-template.png') }}" alt="">

            {{-- QR Code in the designated left box --}}
            @if($qrCode)
                <div class="cert-qr-code">
                    <img src="{{ $qrCode }}" alt="QR Verification" class="w-full h-full">
                </div>
            @endif

            {{-- Student Photo --}}
            @if($student->image_path)
                <div class="cert-student-photo">
                    <img src="{{ asset('storage/' . $student->image_path) }}" alt="{{ $student->name }}">
                </div>
            @endif

            {{-- Top Meta Data --}}
            <div class="cert-field cert-field--serial">
                {{ $certificateSerial ?? '036564' }}
            </div>

            <div class="cert-field cert-field--reg-no">
                {{ $student->registration_number ?? '50936900' }}
            </div>

            <div class="cert-field cert-field--session">
                {{ $latestResult?->session ?? $student->session ?? '2020 - 2023' }}
            </div>

            {{-- Main Body Content - Cursive Values --}}
            <div class="cert-field cert-field--name">
                {{ $student->name }}
            </div>

            <div class="cert-field cert-field--father">
                {{ $student->father_name ?? '—' }}
            </div>

            <div class="cert-field cert-field--mother">
                {{ $student->mother_name ?? '—' }}
            </div>

            <div class="cert-field cert-field--institute">
                {{ $student->institute_name ?? 'Bangladesh Technical Training Institute' }}
            </div>

            <div class="cert-field cert-field--roll">
                {{ $student->roll_number ?? '906912' }}
            </div>

            <div class="cert-field cert-field--course">
                {{ $student->course?->name ?? 'Diploma in Electrician' }}
            </div>

            <div class="cert-field cert-field--exam-held">
                {{ $latestResult?->published_at?->format('d M Y') ?? '15 Dec 2023' }}
            </div>

            <div class="cert-field cert-field--cgpa">
                {{ $certificateGpa !== null ? number_format((float) $certificateGpa, 2) : '3.75' }}
            </div>

            {{-- Result Publication Date --}}
            <div class="cert-field cert-field--publication-date">
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

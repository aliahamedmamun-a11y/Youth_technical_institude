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
            <img class="certificate-template" src="{{ asset('images/certificate-template.png') }}" alt="">

            <header class="certificate-header">
                <h2 class="certificate-title">Bangladesh National Technical Education Institute</h2>
                <p class="certificate-approved">Approved by Govt. Of The People's Republic of Bangladesh</p>
                <p class="certificate-web">www.bntei.com</p>
                <h3 class="certificate-type">CERTIFICATE</h3>
            </header>

            <aside class="certificate-left-panel">
                <div class="certificate-incorporation">
                    {{-- Placeholder for Incorporation Certificate image --}}
                    <div class="certificate-inc-image">
                        <img src="{{ asset('images/Reg-Admit-pad-04.png') }}" alt="Incorporation">
                    </div>
                </div>

                <div class="certificate-qr-main">
                    @if($qrCode)
                        <img src="{{ $qrCode }}" alt="QR Code">
                    @endif
                </div>

                <div class="certificate-grading">
                    <p class="grading-title">Grading System</p>
                    <table>
                        <tr><th>80 or Above</th><th>A+</th><th>4.00</th></tr>
                        <tr><th>75 - Below 80</th><th>A</th><th>3.75</th></tr>
                        <tr><th>70 - Below 75</th><th>A-</th><th>3.50</th></tr>
                        <tr><th>65 - Below 70</th><th>B+</th><th>3.25</th></tr>
                        <tr><th>60 - Below 65</th><th>B</th><th>3.00</th></tr>
                        <tr><th>55 - Below 60</th><th>B-</th><th>2.75</th></tr>
                        <tr><th>50 - Below 55</th><th>C+</th><th>2.50</th></tr>
                    </table>
                </div>
                <p class="certificate-result-date">Date of Publication of Result: <span>{{ $latestResult?->published_at?->format('d-M-Y') ?? '15-Feb-2024' }}</span></p>
            </aside>

            <div class="certificate-main-content">
                <div class="certificate-crest">
                    <img src="{{ asset('images/Logo.png') }}" alt="BNTEI Crest">
                </div>

                <div class="certificate-qr-top">
                    @if($qrCode)
                        <img src="{{ $qrCode }}" alt="QR Code">
                    @endif
                </div>

                <div class="certificate-top-meta">
                    <p class="cert-serial">Serial No: <span>{{ $certificateSerial ?? '036564' }}</span></p>
                    <div class="cert-right-meta">
                        <p>Reg No:.......................<span>{{ $student->registration_number ?? '50936900' }}</span></p>
                        <p>Session:......................<span>{{ $latestResult?->session ?? $student->session ?? '2020 - 2023' }}</span></p>
                    </div>
                </div>

                <div class="certificate-body">
                    <p class="cert-row">This is to certify that............<span class="cert-value cert-value--name">{{ $student->name }}</span></p>
                    <p class="cert-row">Son/Daughter of...............<span class="cert-value">{{ $student->father_name ?? '—' }}</span><span class="cert-label">(Father)</span></p>
                    <p class="cert-row">and.....................................<span class="cert-value">{{ $student->mother_name ?? '—' }}</span><span class="cert-label">(Mother)</span></p>
                    <p class="cert-row">of........................................<span class="cert-value">{{ $student->institute_name ?? 'Bangladesh Technical Training Institute' }}</span></p>
                    <p class="cert-row">bearing Roll No...........<span class="cert-value">{{ $student->roll_number ?? '906912' }}</span>..........duly passed the..........<span class="cert-value">{{ $student->course?->name ?? 'Diploma in Electrician' }}</span></p>
                    <p class="cert-row">Course Examination held in the month of......<span class="cert-value">{{ $latestResult?->published_at?->format('d M Y') ?? '15 Dec 2023' }}</span>......and he/she Secured CGPA......<span class="cert-value">{{ $certificateGpa !== null ? number_format((float) $certificateGpa, 2) : '3.75' }}</span></p>
                    <p class="cert-row cert-row--last">on the scale of 4.00 at Under the "Education Program" Bangladesh National Technical Education Institute.</p>
                </div>

                <div class="certificate-footer-sigs">
                    <div class="sig-checked">
                        <div class="sig-image">Jahid</div>
                        <div class="sig-line"></div>
                        <p>Checked By</p>
                    </div>
                    <div class="sig-controller">
                        <div class="sig-image">Saiful</div>
                        <div class="sig-line"></div>
                        <p>Deputy Controller of Examinations</p>
                    </div>
                </div>
            </div>
        </article>
        <p class="certificate-footer-note">Note: This Certificate is issued without any alteration or erasure</p>
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

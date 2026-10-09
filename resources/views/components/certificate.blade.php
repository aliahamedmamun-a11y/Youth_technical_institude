@props([
    'student',
    'latestResult' => null,
    'cumulativeGpa' => null,
    'certificateSerial' => null,
    'qrCode' => null,
    'template' => null,
])

@php
    $tpl = request()->query('tpl', $template ?? '2');
    $certificateGpa = $cumulativeGpa ?? $latestResult?->gpa ?? $student->cgpa ?? '3.75';
    $resultVerificationUrl = $latestResult?->verification_token
        ? route('results.show', $latestResult->verification_token)
        : route('results.index', ['roll_number' => $student->roll_number]);

    $verificationQr = $qrCode ?? (app(\App\Services\QrCodeService::class)->dataUri($resultVerificationUrl));
    $templateImage = $tpl == '1' ? asset('images/certificate-template.png') : asset('images/Certificate-2.png');
@endphp

@vite(['resources/css/app.css', 'resources/css/certificate.css', 'resources/js/app.js'])

<main class="certificate-screen">
    <h1 class="sr-only">Certificate for {{ $student->name }}</h1>

    <!-- TEMPLATE SWITCHER TOGGLE (PRINT HIDDEN) -->
    <div class="print:hidden mb-2 flex items-center justify-center gap-3">
        <div class="inline-flex rounded-2xl bg-slate-900/90 p-1.5 border border-white/20 shadow-2xl backdrop-blur-md">
            <a href="?tpl=2" @class([
                'rounded-xl px-5 py-2.5 text-xs font-black uppercase tracking-wider transition-all shadow-md',
                'bg-emerald-500 text-slate-950 shadow-lg ring-2 ring-emerald-300' => $tpl == '2',
                'text-slate-300 hover:text-white hover:bg-white/10' => $tpl != '2'
            ])>
                📜 Certificate 2 (Gold Border)
            </a>
            <a href="?tpl=1" @class([
                'rounded-xl px-5 py-2.5 text-xs font-black uppercase tracking-wider transition-all shadow-md',
                'bg-emerald-500 text-slate-950 shadow-lg ring-2 ring-emerald-300' => $tpl == '1',
                'text-slate-300 hover:text-white hover:bg-white/10' => $tpl != '1'
            ])>
                📜 Certificate 1 (Classic)
            </a>
        </div>
    </div>

    <div class="certificate-frame">
        <article class="certificate-document {{ $tpl == '1' ? 'certificate-document--tpl1' : 'certificate-document--tpl2' }}" aria-label="Certificate for {{ $student->name }}">
            <img class="certificate-template" src="{{ $templateImage }}" alt="Certificate Template">

            <span class="certificate-data certificate-data--serial">{{ $certificateSerial ?? sprintf('%06d', $student->id) }}</span>
            <span class="certificate-data certificate-data--registration">{{ $student->registration_number ?? '—' }}</span>
            <span class="certificate-data certificate-data--session">{{ $latestResult?->session ?? $student->session ?? '2024 - 2025' }}</span>
            <span class="certificate-data certificate-data--student">{{ $student->name }}</span>
            <span class="certificate-data certificate-data--father">{{ $student->father_name ?? '—' }}</span>
            <span class="certificate-data certificate-data--mother">{{ $student->mother_name ?? '—' }}</span>
            <span class="certificate-data certificate-data--course">{{ $student->course?->name ?? 'Computer Science & Engineering' }}</span>
            <span class="certificate-data certificate-data--roll">{{ $student->roll_number ?? '—' }}</span>
            <span class="certificate-data certificate-data--semester">{{ $latestResult?->semester ?? '1st Semester' }}</span>
            <span class="certificate-data certificate-data--month">{{ $latestResult?->examination_month ?? optional($latestResult?->published_at ?? $student->created_at)->format('F Y') ?? 'July 2025' }}</span>
            <span class="certificate-data certificate-data--gpa">{{ number_format((float) $certificateGpa, 2) }}</span>
            <span class="certificate-data certificate-data--date">{{ $student->publication_date ?: optional($latestResult?->published_at ?? $student->created_at)->format('d/m/Y') ?? '31/07/2025' }}</span>

            @if ($verificationQr)
                <div class="cert-qr-code">
                    <a href="{{ $resultVerificationUrl }}" target="_blank" title="Scan or click to view result">
                        <img src="{{ $verificationQr }}" alt="Scan to view result">
                    </a>
                </div>
            @endif
        </article>
    </div>

    <nav class="certificate-actions print:hidden" aria-label="Certificate actions">
        <button type="button" data-print-document onclick="window.print()" class="rounded-xl bg-[#03224c] hover:bg-slate-800 px-8 py-3 text-xs font-black uppercase text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            Print Certificate
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-8 py-3 text-xs font-black uppercase text-slate-700 transition">
            Back to student
        </a>
    </nav>
</main>

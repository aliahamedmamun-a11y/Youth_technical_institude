@props([
    'student',
    'latestResult' => null,
    'cumulativeGpa' => null,
    'certificateSerial' => null,
    'qrCode' => null,
    'template' => null,
])

@php
    $tpl = (string) request()->query('tpl', $template ?? '2');
    $certificateGpa = $cumulativeGpa ?? $latestResult?->gpa ?? $student->cgpa ?? '3.75';
    $resultVerificationUrl = $latestResult?->verification_token
        ? route('results.show', $latestResult->verification_token)
        : route('results.index', ['roll_number' => $student->roll_number]);

    $verificationQr = $qrCode ?? (app(\App\Services\QrCodeService::class)->dataUri($resultVerificationUrl));
    $templateImage = match ($tpl) {
        '1' => asset('images/certificate-template1.png'),
        default => asset('images/certificate-template.png'),
    };

    $formattedSerial = $certificateSerial
        ? (str_starts_with($certificateSerial, 'CERT-') ? $certificateSerial : 'CERT-'.$certificateSerial)
        : sprintf('CERT-%06d', $latestResult?->id ?? $student->id);
@endphp

@vite(['resources/css/app.css', 'resources/css/certificate.css', 'resources/js/app.js'])

<main class="certificate-screen">
    <h1 class="sr-only">Certificate for {{ $student->name }}</h1>

    <!-- TEMPLATE SWITCHER & VIEW TOGGLE (PRINT HIDDEN) -->
    <div class="print:hidden mb-4 flex flex-wrap items-center justify-center gap-3">
        <!-- Certificate Template Switcher -->
        <div class="inline-flex rounded-2xl bg-slate-900/90 p-1.5 border border-white/20 shadow-2xl backdrop-blur-md">
            <a href="?tpl=1" @class([
                'rounded-xl px-4 py-2 text-xs font-black uppercase tracking-wider transition-all shadow-md flex items-center gap-2',
                'bg-emerald-500 text-slate-950 shadow-lg ring-2 ring-emerald-300' => $tpl === '1',
                'text-slate-300 hover:text-white hover:bg-white/10' => $tpl !== '1'
            ])>
                📜 Certificate 1 (Classic Green)
            </a>
            <a href="?tpl=2" @class([
                'rounded-xl px-4 py-2 text-xs font-black uppercase tracking-wider transition-all shadow-md flex items-center gap-2',
                'bg-emerald-500 text-slate-950 shadow-lg ring-2 ring-emerald-300' => $tpl === '2',
                'text-slate-300 hover:text-white hover:bg-white/10' => $tpl !== '2'
            ])>
                📜 Certificate 2 (Gold Border)
            </a>
        </div>

        <!-- View Mode Switcher -->
        <div class="inline-flex rounded-2xl bg-slate-900/90 p-1.5 border border-white/20 shadow-2xl backdrop-blur-md">
            <button type="button" data-certificate-view="full" class="certificate-view-btn rounded-xl px-4 py-2 text-xs font-bold transition bg-emerald-500 text-slate-950 shadow-md">
                🖼️ Full Template
            </button>
            <button type="button" data-certificate-view="data-only" class="certificate-view-btn rounded-xl px-4 py-2 text-xs font-bold transition text-slate-300 hover:text-white">
                📝 Data Only
            </button>
        </div>
    </div>

    <!-- CERTIFICATE FRAME -->
    <div class="certificate-frame">
        <article class="certificate-document {{ $tpl === '1' ? 'certificate-document--tpl1' : 'certificate-document--tpl2' }}" aria-label="Certificate for {{ $student->name }}">
            <img class="certificate-template" src="{{ $templateImage }}" alt="Certificate Template">

            <span class="certificate-data certificate-data--serial">{{ $formattedSerial }}</span>
            <span class="certificate-data certificate-data--registration">{{ $student->registration_number ?? '—' }}</span>
            <span class="certificate-data certificate-data--session">{{ $latestResult?->session ?? $student->session ?? '2024 - 2025' }}</span>
            <span class="certificate-data certificate-data--student">{{ $student->name }}</span>
            <span class="certificate-data certificate-data--father">{{ $student->father_name ?? '—' }}</span>
            <span class="certificate-data certificate-data--mother">{{ $student->mother_name ?? '—' }}</span>
            <span class="certificate-data certificate-data--institute">{{ $student->branch?->name ?? $student->institute_name ?? 'Bangladesh National Youth Technical Institute' }}</span>
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

    <!-- PRINT ACTIONS NAVBAR -->
    <nav class="certificate-actions print:hidden mt-6 flex flex-wrap items-center justify-center gap-3" aria-label="Certificate actions">
        <button type="button" data-print-certificate="full" class="rounded-xl bg-[#03224c] hover:bg-slate-800 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-slate-700">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            🖨️ Print with Template (টেমপ্লেট সহ)
        </button>

        <button type="button" data-print-certificate="data-only" class="rounded-xl bg-amber-600 hover:bg-amber-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-amber-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            📄 Print Only Student Data (শুধুমাত্র ডাটা)
        </button>

        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back to student
        </a>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const doc = document.querySelector('.certificate-document');
            const frame = document.querySelector('.certificate-frame');
            const viewBtns = document.querySelectorAll('.certificate-view-btn');

            function setPrintMode(mode) {
                if (mode === 'data-only') {
                    doc?.classList.add('print-data-only');
                    frame?.classList.add('print-data-only');
                } else {
                    doc?.classList.remove('print-data-only');
                    frame?.classList.remove('print-data-only');
                }

                viewBtns.forEach(btn => {
                    if (btn.dataset.certificateView === mode) {
                        btn.classList.add('bg-emerald-500', 'text-slate-950');
                        btn.classList.remove('text-slate-300');
                    } else {
                        btn.classList.remove('bg-emerald-500', 'text-slate-950');
                        btn.classList.add('text-slate-300');
                    }
                });
            }

            document.querySelectorAll('[data-certificate-view]').forEach(btn => {
                btn.addEventListener('click', function () {
                    setPrintMode(this.dataset.certificateView);
                });
            });

            document.querySelectorAll('[data-print-certificate]').forEach(btn => {
                btn.addEventListener('click', function () {
                    const mode = this.dataset.printCertificate;
                    setPrintMode(mode);
                    setTimeout(() => window.print(), 100);
                });
            });
        });
    </script>
</main>


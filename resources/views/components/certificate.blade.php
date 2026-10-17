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
            <span class="certificate-data certificate-data--institute">{{ $student->branch?->name ?? $student->institute_name ?? 'South Asia Engineering & Technical Institute' }}</span>
            <span class="certificate-data certificate-data--course">{{ $student->course?->name ?? 'Computer Science & Engineering' }}</span>
            <span class="certificate-data certificate-data--roll">{{ $student->roll_number ?? '—' }}</span>
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
        <button type="button" data-download-certificate="full" class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-emerald-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            📥 Download PDF (টেমপ্লেট সহ)
        </button>

        <button type="button" data-download-certificate="data-only" class="rounded-xl bg-amber-600 hover:bg-amber-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-amber-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            📄 Download Data Only (শুধুমাত্র ডাটা)
        </button>

        <button type="button" data-print-certificate="full" class="rounded-xl bg-[#03224c] hover:bg-slate-800 px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-200 shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-slate-700">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            🖨️ Print
        </button>

        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back to student
        </a>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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

            function downloadPDF(mode, btnElement) {
                setPrintMode(mode);

                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>Generating PDF...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `Certificate_${cleanName}_${mode}.pdf`;

                const opt = {
                    margin: 0,
                    filename: filename,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: {
                        scale: 3,
                        useCORS: true,
                        logging: false,
                        letterRendering: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'landscape'
                    }
                };

                if (typeof html2pdf !== 'undefined') {
                    html2pdf().set(opt).from(doc).save().then(() => {
                        btnElement.innerHTML = originalHTML;
                        btnElement.disabled = false;
                    }).catch(err => {
                        console.error('PDF error:', err);
                        btnElement.innerHTML = originalHTML;
                        btnElement.disabled = false;
                        window.print();
                    });
                } else {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                    window.print();
                }
            }

            document.querySelectorAll('[data-certificate-view]').forEach(btn => {
                btn.addEventListener('click', function () {
                    setPrintMode(this.dataset.certificateView);
                });
            });

            document.querySelectorAll('[data-download-certificate]').forEach(btn => {
                btn.addEventListener('click', function () {
                    downloadPDF(this.dataset.downloadCertificate, this);
                });
            });

            document.querySelectorAll('[data-print-certificate]').forEach(btn => {
                btn.addEventListener('click', function () {
                    const mode = this.dataset.printCertificate;
                    setPrintMode(mode);

                    let styleTag = document.getElementById('print-orientation-style');
                    if (!styleTag) {
                        styleTag = document.createElement('style');
                        styleTag.id = 'print-orientation-style';
                        document.head.appendChild(styleTag);
                    }
                    styleTag.textContent = '@page { size: landscape; margin: 0; } @media print { @page { size: landscape; margin: 0; } html, body, .certificate-screen, .certificate-frame, .certificate-document { width: 100% !important; height: 100% !important; margin: 0 !important; padding: 0 !important; overflow: hidden !important; } }';

                    setTimeout(() => window.print(), 100);
                });
            });
        });
    </script>
</main>


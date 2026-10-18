@props([
    'student',
    'latestResult' => null,
    'cumulativeGpa' => null,
])

@php
    $testimonialGrade = $latestResult?->overall_grade ?? $student->grade ?? 'A+';
    $testimonialGpa = $cumulativeGpa ?? $latestResult?->gpa ?? $student->cgpa ?? '3.75';

    $branchApp = $student->branch_application
        ?? \App\Models\BranchApplication::query()
            ->where('id', (int) $student->branch_id)
            ->orWhere('username', $student->branch_id)
            ->orWhere('institute_name', $student->branch_id)
            ->orWhere('institute_name', $student->institute_name)
            ->first();

    $headSignatureUrl = $branchApp?->director_signature_path
        ? asset('storage/' . $branchApp->director_signature_path)
        : null;
@endphp

@vite(['resources/css/app.css', 'resources/css/testimonial.css', 'resources/js/app.js'])

<main class="testimonial-screen">
    <h1 class="sr-only">Testimonial for {{ $student->name }}</h1>

    <!-- VIEW TOGGLE (PRINT HIDDEN) -->
    <div class="print:hidden mb-4 flex flex-wrap items-center justify-center gap-3">
        <div class="inline-flex rounded-2xl bg-slate-900/90 p-1.5 border border-white/20 shadow-2xl backdrop-blur-md">
            <button type="button" data-testimonial-view="full" class="testimonial-view-btn rounded-xl px-4 py-2 text-xs font-bold transition bg-amber-500 text-slate-950 shadow-md">
                🖼️ Full Template
            </button>
            <button type="button" data-testimonial-view="data-only" class="testimonial-view-btn rounded-xl px-4 py-2 text-xs font-bold transition text-slate-300 hover:text-white">
                📝 Data Only
            </button>
        </div>
    </div>

    <div class="testimonial-frame">
        <article class="testimonial-document" aria-label="Testimonial for {{ $student->name }}">
            <img class="testimonial-template" src="{{ asset('images/testimonial-template.png') }}" alt="Testimonial Template">

            <span class="testimonial-data testimonial-data--student">{{ $student->name }}</span>
            <span class="testimonial-data testimonial-data--father">{{ $student->father_name ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--institute">{{ $student->branch?->name ?? $student->institute_name ?? 'South Asia Engineering & Technical Institute' }}</span>
            <span class="testimonial-data testimonial-data--grade">{{ $testimonialGrade }}</span>
            <span class="testimonial-data testimonial-data--gpa">{{ $testimonialGpa !== null ? number_format((float) $testimonialGpa, 2) : '—' }}</span>
            <span class="testimonial-data testimonial-data--roll">{{ $student->roll_number ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--registration">{{ $student->registration_number ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--session">{{ $latestResult?->session ?? $student->session ?? '2024-2025' }}</span>
            <span class="testimonial-data testimonial-data--date">{{ $latestResult?->published_at?->format('d/m/Y') ?? $student->publication_date ?? now()->format('d/m/Y') }}</span>

            @if ($headSignatureUrl)
                <div class="testimonial-head-signature">
                    <img src="{{ $headSignatureUrl }}" alt="Branch Signature">
                </div>
            @endif
        </article>
    </div>

    <!-- PRINT & DOWNLOAD ACTIONS NAVBAR -->
    <nav class="testimonial-actions print:hidden mt-6 flex flex-wrap items-center justify-center gap-3" aria-label="Testimonial actions">
        <button type="button" data-download-certificate="full" class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-emerald-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            📥 Download PDF (সরাসরি পিডিএফ ডাউনলোড)
        </button>

        <button type="button" data-download-certificate="data-only" class="rounded-xl bg-amber-600 hover:bg-amber-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-amber-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
            </svg>
            📄 PDF (শুধুমাত্র ডাটা)
        </button>

        <button type="button" data-download-image="full" class="rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-blue-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            🖼️ Download Image (ছবি)
        </button>

        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back to student
        </a>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const doc = document.querySelector('.testimonial-document');
            const frame = document.querySelector('.testimonial-frame');
            const viewBtns = document.querySelectorAll('.testimonial-view-btn');

            function setPrintMode(mode) {
                if (mode === 'data-only') {
                    doc?.classList.add('print-data-only');
                    frame?.classList.add('print-data-only');
                } else {
                    doc?.classList.remove('print-data-only');
                    frame?.classList.remove('print-data-only');
                }

                viewBtns.forEach(btn => {
                    if (btn.dataset.testimonialView === mode) {
                        btn.classList.add('bg-amber-500', 'text-slate-950');
                        btn.classList.remove('text-slate-300');
                    } else {
                        btn.classList.remove('bg-amber-500', 'text-slate-950');
                        btn.classList.add('text-slate-300');
                    }
                });
            }

            function fallbackJsPDF(element, filename, finish) {
                if (typeof html2canvas !== 'undefined') {
                    html2canvas(element, {
                        scale: 4,
                        useCORS: true,
                        allowTaint: true,
                        logging: false
                    }).then(canvas => {
                        const imgData = canvas.toDataURL('image/png', 1.0);
                        const jsPDF = window.jspdf ? window.jspdf.jsPDF : null;
                        if (jsPDF) {
                            const pdf = new jsPDF('landscape', 'mm', 'a4', true);
                            pdf.addImage(imgData, 'PNG', 0, 0, 297, 210, undefined, 'FAST');
                            pdf.save(filename);
                        }
                        finish();
                    }).catch(err => {
                        console.error('jsPDF fallback error:', err);
                        finish();
                    });
                } else {
                    finish();
                }
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
                    <span>High-HD PDF তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `Testimonial_${cleanName}_${mode}.pdf`;

                const finish = () => {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                };

                const opt = {
                    margin: 0,
                    filename: filename,
                    image: { type: 'png' },
                    html2canvas: {
                        scale: 4,
                        useCORS: true,
                        allowTaint: true,
                        logging: false,
                        letterRendering: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a4',
                        orientation: 'landscape',
                        compress: false
                    }
                };

                if (typeof html2pdf !== 'undefined') {
                    html2pdf().set(opt).from(doc).save().then(finish).catch(err => {
                        console.error('html2pdf error:', err);
                        fallbackJsPDF(doc, filename, finish);
                    });
                } else {
                    fallbackJsPDF(doc, filename, finish);
                }
            }

            function downloadImage(mode, btnElement) {
                setPrintMode(mode);

                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>HD ছবি তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `Testimonial_${cleanName}_${mode}.png`;

                if (typeof html2canvas !== 'undefined') {
                    html2canvas(doc, {
                        scale: 4,
                        useCORS: true,
                        allowTaint: true,
                        logging: false,
                        backgroundColor: mode === 'data-only' ? null : '#ffffe9'
                    }).then(canvas => {
                        const imageUri = canvas.toDataURL('image/png', 1.0);
                        const link = document.createElement('a');
                        link.download = filename;
                        link.href = imageUri;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        btnElement.innerHTML = originalHTML;
                        btnElement.disabled = false;
                    }).catch(err => {
                        console.error('Image error:', err);
                        btnElement.innerHTML = originalHTML;
                        btnElement.disabled = false;
                    });
                } else {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                }
            }

            document.querySelectorAll('[data-testimonial-view]').forEach(btn => {
                btn.addEventListener('click', function () {
                    setPrintMode(this.dataset.testimonialView);
                });
            });

            document.querySelectorAll('[data-download-image]').forEach(btn => {
                btn.addEventListener('click', function () {
                    downloadImage(this.dataset.downloadImage, this);
                });
            });

            document.querySelectorAll('[data-download-certificate]').forEach(btn => {
                btn.addEventListener('click', function () {
                    downloadPDF(this.dataset.downloadCertificate, this);
                });
            });
        });
    </script>
</main>

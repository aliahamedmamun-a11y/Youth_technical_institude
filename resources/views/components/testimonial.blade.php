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
        <button type="button" data-download-image="full" class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-emerald-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            🖼️ Download Image (সরাসরি ছবি গ্যালাড়িতে)
        </button>

        <button type="button" data-print-testimonial="full" class="rounded-xl bg-[#03224c] hover:bg-slate-800 px-5 py-3 text-xs font-bold uppercase tracking-wider text-slate-200 shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-slate-700">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            🖨️ Print
        </button>

        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back to student
        </a>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
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

            function downloadImage(mode, btnElement) {
                setPrintMode(mode);

                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>ছবি তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `Testimonial_${cleanName}_${mode}.png`;

                if (typeof html2canvas !== 'undefined') {
                    html2canvas(doc, {
                        scale: 3,
                        useCORS: true,
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

            document.querySelectorAll('[data-print-testimonial]').forEach(btn => {
                btn.addEventListener('click', function () {
                    const mode = this.dataset.printTestimonial;
                    setPrintMode(mode);

                    let styleTag = document.getElementById('print-orientation-style');
                    if (!styleTag) {
                        styleTag = document.createElement('style');
                        styleTag.id = 'print-orientation-style';
                        document.head.appendChild(styleTag);
                    }
                    styleTag.textContent = '@page { size: landscape; margin: 0; } @media print { @page { size: landscape; margin: 0; } html, body, .testimonial-screen, .testimonial-frame, .testimonial-document { width: 100% !important; height: 100% !important; margin: 0 !important; padding: 0 !important; overflow: hidden !important; } }';

                    setTimeout(() => window.print(), 100);
                });
            });
        });
    </script>
</main>

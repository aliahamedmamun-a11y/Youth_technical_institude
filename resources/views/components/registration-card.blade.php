@props([
    'student',
    'serial',
    'instituteCode',
    'instituteName' => null,
    'qrCode' => null,
    'qrUrl' => null,
    'printedAt' => null,
    'isPublic' => false,
])

@php
    $branchApp = $student->branch_application ?? \App\Models\BranchApplication::query()
        ->where('id', (int) $student->branch_id)
        ->orWhere('username', $student->branch_id)
        ->orWhere('institute_name', $student->branch_id)
        ->orWhere('institute_name', $student->institute_name)
        ->first();

    $headSignatureUrl = $branchApp?->director_signature_path
        ? asset('storage/' . $branchApp->director_signature_path)
        : null;

    $studentPhotoUrl = null;
    if ($student->image_path) {
        if (str_starts_with($student->image_path, 'http://') || str_starts_with($student->image_path, 'https://')) {
            $studentPhotoUrl = $student->image_path;
        } elseif (str_starts_with($student->image_path, 'images/')) {
            $studentPhotoUrl = asset($student->image_path);
        } else {
            $studentPhotoUrl = asset('storage/' . ltrim($student->image_path, '/'));
        }
    }
@endphp

@vite(['resources/css/app.css', 'resources/css/registration-card.css', 'resources/js/app.js'])

<main class="registration-card-screen">
    <h1 class="sr-only">Registration Card for {{ $student->name }}</h1>

    <div class="registration-card-frame">
        <article class="registration-card" aria-label="Registration card for {{ $student->name }}">
            {{-- Background registration card template containing layout and static borders/text --}}
            <img class="registration-card__template" src="{{ asset('images/registration-card-template.png') }}" alt="Registration Card Background">

            {{-- Dynamic Serial No overlay --}}
            <div class="rc-field rc-field--serial">
                {{ $serial ?? sprintf('%06d', $student->id) }}
            </div>

            {{-- Top Right Photo and QR Code Overlay --}}
            <aside class="rc-meta-right">
                <figure class="registration-card__photo">
                    @if ($studentPhotoUrl)
                        <img src="{{ $studentPhotoUrl }}" alt="Photo of {{ $student->name }}" crossorigin="anonymous" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-slate-100 flex items-center justify-center text-[8px] text-slate-400\'>NO PHOTO</div>';">
                    @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-[8px] text-slate-400">
                            NO PHOTO
                        </div>
                    @endif
                </figure>

                @if($qrCode)
                    <div class="registration-card__qr">
                        <img src="{{ $qrCode }}" alt="QR Verification">
                    </div>
                @endif
            </aside>

            {{-- Main Data Rows Overlays --}}
            <div class="registration-card__data-box">
                <div class="rc-row">
                    <span class="rc-label">Registration Number</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->registration_number ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Name of Student</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->name }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Father's Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->father_name ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Mother's Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->mother_name ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Gender</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->gender ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Institute Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->institute_name ?? $student->branch?->name ?? $instituteName ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Student Thana</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->upazila ?? $student->thana ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Student District</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->district ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Course Name</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->course?->name ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Course Duration</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->duration ?? $student->course?->duration ?? '—' }}</span>
                </div>
                <div class="rc-row">
                    <span class="rc-label">Session</span><span class="rc-sep">:</span>
                    <span class="rc-val">{{ $student->session ?? '—' }}</span>
                </div>
            </div>

            @if ($headSignatureUrl)
                <div class="rc-head-signature">
                    <img src="{{ $headSignatureUrl }}" alt="Signature of Head of Institute" crossorigin="anonymous">
                </div>
            @endif
        </article>
    </div>

    <nav class="registration-card-actions print:hidden mt-6 flex flex-wrap items-center justify-center gap-3" aria-label="Registration card actions">
        <button type="button" data-download-pdf class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-emerald-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            📥 Download PDF (সরাসরি পিডিএফ ডাউনলোড)
        </button>

        <button type="button" data-download-image class="rounded-xl bg-blue-600 hover:bg-blue-700 px-6 py-3 text-xs font-black uppercase tracking-wider text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2 border border-blue-500">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
            </svg>
            🖼️ Download Image (ছবি)
        </button>

        @if (! $isPublic)
            <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
                Back to student
            </a>
        @endif
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const doc = document.querySelector('.registration-card');
            const studentName = @json($student->name ?? 'Student');
            const cleanName = studentName.replace(/[^a-zA-Z0-9]+/g, '_').replace(/^_+|_+$/g, '') || 'Student';

            function oklchToRgb(colorValue) {
                if (!colorValue || !colorValue.includes('oklch')) return colorValue;

                const temp = document.createElement('span');
                temp.style.color = colorValue;
                temp.style.display = 'none';
                document.body.appendChild(temp);
                const resolved = getComputedStyle(temp).color;
                document.body.removeChild(temp);
                return resolved && !resolved.includes('oklch') ? resolved : 'rgb(15, 23, 42)';
            }

            function sanitizeOklchStyles(rootEl) {
                const elements = [rootEl, ...rootEl.querySelectorAll('*')];
                const backups = [];
                const propsToCheck = [
                    'color',
                    'backgroundColor',
                    'borderColor',
                    'borderTopColor',
                    'borderRightColor',
                    'borderBottomColor',
                    'borderLeftColor',
                    'outlineColor',
                    'fill',
                    'stroke'
                ];

                elements.forEach((el) => {
                    const computed = getComputedStyle(el);
                    const savedInline = {};

                    propsToCheck.forEach((prop) => {
                        const val = computed[prop];
                        if (val && val.includes('oklch')) {
                            savedInline[prop] = el.style[prop];
                            el.style[prop] = oklchToRgb(val);
                        }
                    });

                    if (computed.boxShadow && computed.boxShadow.includes('oklch')) {
                        savedInline.boxShadow = el.style.boxShadow;
                        el.style.boxShadow = 'none';
                    }

                    if (Object.keys(savedInline).length > 0) {
                        backups.push({ el, savedInline });
                    }
                });

                return function restoreStyles() {
                    backups.forEach(({ el, savedInline }) => {
                        Object.keys(savedInline).forEach((prop) => {
                            el.style[prop] = savedInline[prop];
                        });
                    });
                };
            }

            async function renderCardCanvas(scaleValue = 3) {
                if (typeof html2canvas === 'undefined') {
                    throw new Error('html2canvas is not loaded');
                }

                const restore = sanitizeOklchStyles(doc);
                try {
                    return await html2canvas(doc, {
                        scale: scaleValue,
                        useCORS: true,
                        allowTaint: false,
                        logging: false,
                        backgroundColor: '#ffffff'
                    });
                } finally {
                    restore();
                }
            }

            function fallbackJsPDF(filename, finish) {
                renderCardCanvas(3).then(canvas => {
                    const imgData = canvas.toDataURL('image/png', 1.0);
                    const jsPDF = window.jspdf ? window.jspdf.jsPDF : (window.jsPDF ? window.jsPDF : null);
                    if (jsPDF) {
                        const pdf = new jsPDF('portrait', 'mm', 'a4', false);
                        pdf.addImage(imgData, 'PNG', 0, 0, 210, 297, undefined, 'NONE');
                        pdf.save(filename);
                    }
                    finish();
                }).catch(err => {
                    console.error('PDF fallback error:', err);
                    finish();
                });
            }

            async function downloadPDF(btnElement) {
                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>PDF তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const filename = `RegistrationCard_${cleanName}.pdf`;

                const finish = () => {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                };

                const restore = sanitizeOklchStyles(doc);

                try {
                    const opt = {
                        margin: 0,
                        filename: filename,
                        image: { type: 'png', quality: 1.0 },
                        html2canvas: {
                            scale: 3,
                            useCORS: true,
                            allowTaint: false,
                            logging: false,
                            letterRendering: true
                        },
                        jsPDF: {
                            unit: 'mm',
                            format: 'a4',
                            orientation: 'portrait',
                            compress: false
                        }
                    };

                    if (typeof html2pdf !== 'undefined') {
                        await html2pdf().set(opt).from(doc).save();
                        restore();
                        finish();
                    } else {
                        restore();
                        fallbackJsPDF(filename, finish);
                    }
                } catch (err) {
                    restore();
                    console.error('html2pdf error:', err);
                    fallbackJsPDF(filename, finish);
                }
            }

            async function downloadImage(btnElement) {
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

                const filename = `RegistrationCard_${cleanName}.png`;

                try {
                    const canvas = await renderCardCanvas(3);
                    const imageUri = canvas.toDataURL('image/png', 1.0);
                    const link = document.createElement('a');
                    link.download = filename;
                    link.href = imageUri;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } catch (err) {
                    console.error('Image error:', err);
                } finally {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                }
            }

            document.querySelectorAll('[data-download-pdf]').forEach(btn => {
                btn.addEventListener('click', function () { downloadPDF(this); });
            });

            document.querySelectorAll('[data-download-image]').forEach(btn => {
                btn.addEventListener('click', function () { downloadImage(this); });
            });
        });
    </script>
</main>

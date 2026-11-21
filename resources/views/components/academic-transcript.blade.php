@props([
    'student',
    'pages',
    'cumulativeGpa' => null,
    'letterGrade' => null,
    'instituteName' => null,
    'gradingScale' => [],
    'isPublic' => false,
])

@php
    $transcriptImagePath = public_path('images/academic-transcript-template.png');
    $transcriptTemplateUrl = asset('images/academic-transcript-template.png');
    if (file_exists($transcriptImagePath)) {
        $transcriptTemplateUrl .= '?v=' . filemtime($transcriptImagePath);
    }

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

@vite(['resources/css/app.css', 'resources/css/academic-transcript.css', 'resources/js/app.js'])

<main class="transcript-screen">
    <h1 class="sr-only">Academic transcript for {{ $student->name }}</h1>

    <div class="transcript-stack">
        @foreach ($pages as $page)
            @php($result = $page['result'])

            <article class="transcript-page" data-transcript-page aria-label="Academic transcript page {{ $loop->iteration }} of {{ $loop->count }} for {{ $student->name }}">
                {{-- Background high-quality clean template image --}}
                <img class="transcript-template" src="{{ $transcriptTemplateUrl }}" alt="" crossorigin="anonymous" loading="eager">

                {{-- Dynamic Serial No Overlay --}}
                <div class="ts-field ts-field--serial">
                    Serial No: {{ str_replace('TRANS-', '', $page['serial'] ?? sprintf('%06d', $student->id)) }}
                </div>

                {{-- Dynamic Semester Name Header Overlay --}}
                <div class="ts-field ts-field--semester">
                    {{ $page['semesterName'] ?? $result?->semester ?? '—' }}
                </div>

                {{-- Student Information Left-Aligned Dynamic Rows --}}
                <div class="transcript-student-info-box">
                    <div class="ts-row"><span class="ts-label">Name of Student</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->name }}</span></div>
                    <div class="ts-row"><span class="ts-label">Father's Name</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->father_name ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Mother's Name</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->mother_name ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Roll No</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->roll_number ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Registration No</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->registration_number ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Institution</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->institute_name ?? $student->branch?->name ?? $instituteName ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Technology</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->course?->name ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Course Duration</span><span class="ts-sep">:</span><span class="ts-val">{{ $student->duration ?? $student->course?->duration ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Session</span><span class="ts-sep">:</span><span class="ts-val">{{ $result?->session ?? $student->session ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Credit</span><span class="ts-sep">:</span><span class="ts-val">{{ $page['totalCredits'] ?? $result?->total_credit ?? '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Final CGPA</span><span class="ts-sep">:</span><span class="ts-val">{{ $cumulativeGpa !== null ? number_format((float) $cumulativeGpa, 2) : '—' }}</span></div>
                    <div class="ts-row"><span class="ts-label">Letter Grade</span><span class="ts-sep">:</span><span class="ts-val">{{ $letterGrade ?? $student->grade ?? '—' }}</span></div>
                </div>

                {{-- Main Content Academic Subjects Table Overlay - Clean Masked Table --}}
                <div class="transcript-main-table-container">
                    <table class="ts-table" aria-label="Subjects and Marks">
                        <thead>
                            <tr>
                                <th style="width: 17%;">Subjects<br>Code</th>
                                <th style="width: 49%;">Subjects Name</th>
                                <th style="width: 11%;">Credit<br>Hours</th>
                                <th style="width: 11%;">Letter<br>Grade</th>
                                <th style="width: 12%;">Grade<br>Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($rowIndex = 0; $rowIndex < 7; $rowIndex++)
                                @php($subject = $page['subjects']->get($rowIndex))
                                <tr data-transcript-subject-row>
                                    <td>{{ $subject?->code ?? '' }}</td>
                                    <td style="text-align: left; padding-left: 14px;">{{ $subject?->title ?? '' }}</td>
                                    <td>{{ $subject ? number_format((float) $subject->credit, 0) : '' }}</td>
                                    <td>{{ $subject?->grade ?? '' }}</td>
                                    <td>{{ $subject?->grade_point !== null ? number_format((float) $subject->grade_point, 2) : '' }}</td>
                                </tr>
                            @endfor

                            {{-- Semester Summary Statistics Rows --}}
                            <tr class="ts-summary-row">
                                <td colspan="3" style="text-align: right; padding-right: 14px; font-weight: 800;">{{ $page['semesterName'] ?? $result?->semester ?? '1st Semester' }} GPA</td>
                                <td colspan="2" style="font-weight: 800; color: #000000; text-align: center;">{{ $result?->gpa !== null ? number_format((float) $result->gpa, 2) : ($cumulativeGpa !== null ? number_format((float) $cumulativeGpa, 2) : '—') }}</td>
                            </tr>
                            <tr class="ts-summary-row">
                                <td colspan="3" style="text-align: right; padding-right: 14px; font-weight: 800;">Result</td>
                                <td colspan="2" style="font-weight: 800; color: #000000; text-align: center;">{{ $page['outcome'] ?? ($result?->status === 'published' ? 'Passed' : ($result?->status ?? '—')) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Footer Verification QR Code Layer --}}
                @if($page['verificationQrCode'] ?? $student->qr_code)
                    <div class="ts-field ts-footer-qr">
                        <img src="{{ $page['verificationQrCode'] ?? $student->qr_code }}" alt="Verification QR Code">
                    </div>
                @endif

                <div class="ts-footer-note">
                    N.B.: Scan QR code to verify.
                </div>

                @if ($headSignatureUrl)
                    <div class="ts-head-signature">
                        <img src="{{ $headSignatureUrl }}" alt="Branch Signature">
                    </div>
                @endif
            </article>
        @endforeach
    </div>

    <nav class="transcript-actions print:hidden mt-6 flex flex-wrap items-center justify-center gap-3" aria-label="Academic transcript actions">
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const doc = document.querySelector('.transcript-stack');

            async function prepareDocForCapture() {
                if (doc) {
                    const imgs = doc.querySelectorAll('img');
                    const promises = Array.from(imgs).map(img => {
                        if (img.complete) return Promise.resolve();
                        return new Promise(resolve => {
                            img.onload = resolve;
                            img.onerror = resolve;
                        });
                    });
                    await Promise.all(promises);
                }
                await new Promise(resolve => setTimeout(resolve, 150));
            }

            async function generateTranscriptPDF(filename, finish) {
                const pages = document.querySelectorAll('[data-transcript-page]');
                const jsPDF = window.jspdf ? window.jspdf.jsPDF : null;

                if (!pages.length || !jsPDF || typeof html2canvas === 'undefined') {
                    window.print();
                    finish();
                    return;
                }

                await prepareDocForCapture();

                try {
                    const pdf = new jsPDF({
                        orientation: 'portrait',
                        unit: 'mm',
                        format: 'a4',
                        compress: false
                    });

                    for (let i = 0; i < pages.length; i++) {
                        const page = pages[i];
                        const canvas = await html2canvas(page, {
                            scale: 5,
                            useCORS: true,
                            allowTaint: true,
                            logging: false,
                            dpi: 300
                        });

                        const imgData = canvas.toDataURL('image/png');

                        if (i > 0) {
                            pdf.addPage('a4', 'portrait');
                        }

                        pdf.addImage(imgData, 'PNG', 0, 0, 210, 297, undefined, 'NONE');
                    }

                    pdf.save(filename);
                } catch (err) {
                    console.error('PDF generation error:', err);
                    window.print();
                } finally {
                    finish();
                }
            }

            const downloadPdfBtn = document.querySelector('[data-download-pdf]');
            if (downloadPdfBtn) {
                downloadPdfBtn.addEventListener('click', async function () {
                    const originalText = downloadPdfBtn.innerHTML;
                    downloadPdfBtn.innerHTML = `
                        <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span>Ultra HD PDF তৈরি হচ্ছে...</span>
                    `;
                    downloadPdfBtn.disabled = true;

                    const studentName = '{{ Str::slug($student->name) }}' || 'student';
                    const filename = `academic-transcript-${studentName}.pdf`;

                    await generateTranscriptPDF(filename, () => {
                        downloadPdfBtn.innerHTML = originalText;
                        downloadPdfBtn.disabled = false;
                    });
                });
            }

            const downloadImgBtn = document.querySelector('[data-download-image]');
            if (downloadImgBtn) {
                downloadImgBtn.addEventListener('click', async function () {
                    const originalText = downloadImgBtn.innerHTML;
                    downloadImgBtn.innerHTML = `
                        <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        <span>Ultra HD ছবি তৈরি হচ্ছে...</span>
                    `;
                    downloadImgBtn.disabled = true;

                    await prepareDocForCapture();

                    const studentName = '{{ Str::slug($student->name) }}' || 'student';

                    if (typeof html2canvas !== 'undefined') {
                        const firstPage = document.querySelector('[data-transcript-page]') || doc;
                        html2canvas(firstPage, {
                            scale: 5,
                            useCORS: true,
                            allowTaint: true,
                            logging: false,
                            dpi: 300
                        }).then(canvas => {
                            const link = document.createElement('a');
                            link.download = `academic-transcript-${studentName}.png`;
                            link.href = canvas.toDataURL('image/png');
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);

                            downloadImgBtn.innerHTML = originalText;
                            downloadImgBtn.disabled = false;
                        }).catch(err => {
                            console.error('Image generation error:', err);
                            downloadImgBtn.innerHTML = originalText;
                            downloadImgBtn.disabled = false;
                        });
                    } else {
                        downloadImgBtn.innerHTML = originalText;
                        downloadImgBtn.disabled = false;
                    }
                });
            }
        });
    </script>
</main>

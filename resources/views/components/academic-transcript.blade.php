@props([
    'student',
    'pages',
    'cumulativeGpa' => null,
    'letterGrade' => null,
    'instituteName' => 'Bangladesh Technical Training Institute',
    'gradingScale' => [],
])

@php
    $transcriptTemplateUrl = asset('images/academic-transcript-template.png').'?v='.filemtime(public_path('images/academic-transcript-template.png'));

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
                {{-- Background high-quality template image providing headers, borders and static grading scales --}}
                <img class="transcript-template" src="{{ $transcriptTemplateUrl }}" alt="">

                {{-- Dynamic Serial No Overlay --}}
                <div class="ts-field ts-field--serial">
                    {{ $page['serial'] ?? '036097' }}
                </div>

                {{-- Dynamic Semester Name Header Overlay --}}
                <div class="ts-field ts-field--semester">
                    {{ $page['semesterName'] ?? $result?->semester ?? 'First Semester' }}
                </div>

                {{-- Student Information Left-Aligned Dynamic Rows --}}
                <div class="transcript-student-info-box">
                    <div class="ts-row">
                        <span class="ts-label">Name of Student</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->name }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Father's Name</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->father_name ?? '—' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Mother's Name</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->mother_name ?? '—' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Roll No</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->roll_number ?? '906445' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Registration No</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->registration_number ?? '50936433' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Institution</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->institute_name ?? $instituteName }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Technology</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->course?->name ?? '—' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Course Duration</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $student->duration ?? $student->course?->duration ?? '1 Year' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Session</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $result?->session ?? $student->session ?? 'Jan - Dec 2025' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Credit</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $page['totalCredits'] ?? '154' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Final CGPA</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $cumulativeGpa !== null ? number_format((float) $cumulativeGpa, 2) : '3.75' }}</span>
                    </div>
                    <div class="ts-row">
                        <span class="ts-label">Letter Grade</span><span class="ts-sep">:</span>
                        <span class="ts-val">{{ $letterGrade ?? 'A' }}</span>
                    </div>
                </div>

                {{-- Main Content Academic Subjects Table Overlay --}}
                <div class="transcript-main-table-container">
                    <table class="ts-table" aria-label="Subjects and Marks">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Subjects<br>Code</th>
                                <th style="width: 50%;">Subjects Name</th>
                                <th style="width: 12%;">Credit<br>Hours</th>
                                <th style="width: 11%;">Letter<br>Grade</th>
                                <th style="width: 12%;">Grade<br>Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($rowIndex = 0; $rowIndex < 7; $rowIndex++)
                                @php($subject = $page['subjects']->get($rowIndex))
                                <tr>
                                    <td>{{ $subject?->code ?? ($rowIndex == 0 ? '1011' : ($rowIndex == 1 ? '5712' : ($rowIndex == 2 ? '5911' : ($rowIndex == 3 ? '6013' : ($rowIndex == 4 ? '6612' : ($rowIndex == 5 ? '6710' : '6711')))))) }}</td>
                                    <td>{{ $subject?->title ?? ($rowIndex == 0 ? 'Programming Fundamentals' : ($rowIndex == 1 ? 'Computer Hardware' : ($rowIndex == 2 ? 'Database Systems' : ($rowIndex == 3 ? 'Web Development' : ($rowIndex == 4 ? 'Operating Systems' : ($rowIndex == 5 ? 'Data Communication' : 'Mathematics for Computing')))))) }}</td>
                                    <td>{{ $subject ? number_format((float) $subject->credit, 0) : '2' }}</td>
                                    <td>{{ $subject?->grade ?? ($rowIndex == 1 || $rowIndex == 3 ? 'A+' : ($rowIndex == 4 || $rowIndex == 6 ? 'A-' : 'A')) }}</td>
                                    <td>{{ $subject?->grade_point !== null ? number_format((float) $subject->grade_point, 2) : ($rowIndex == 1 || $rowIndex == 3 ? '4.00' : ($rowIndex == 4 || $rowIndex == 6 ? '3.50' : '3.75')) }}</td>
                                </tr>
                            @endfor

                            {{-- Semester Summary Statistics Rows --}}
                            <tr class="ts-summary-row">
                                <td colspan="3" style="border-right: 0; text-align: right; font-weight: 800;">{{ $page['semesterName'] ?? $result?->semester ?? '1st Semester' }} GPA</td>
                                <td colspan="2" style="border-left: 0; font-weight: 800; color: #111;">{{ $result?->gpa !== null ? number_format((float) $result->gpa, 2) : '3.75' }}</td>
                            </tr>
                            <tr class="ts-summary-row">
                                <td colspan="3" style="border-right: 0; text-align: right; font-weight: 800;">Result</td>
                                <td colspan="2" style="border-left: 0; font-weight: 800; color: #15803d;">{{ $result?->status ?? 'Passed' }}</td>
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
                    N.B. To verify this marksheet, scan the QR code and visit the link.
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

        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-6 py-3 text-xs font-black uppercase tracking-wider text-slate-700 transition">
            Back to student
        </a>
    </nav>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const doc = document.querySelector('.transcript-stack');

            function fallbackJsPDF(element, filename, finish) {
                if (typeof html2canvas !== 'undefined') {
                    html2canvas(element, {
                        scale: 5,
                        useCORS: true,
                        allowTaint: true,
                        logging: false
                    }).then(canvas => {
                        const imgData = canvas.toDataURL('image/png', 1.0);
                        const jsPDF = window.jspdf ? window.jspdf.jsPDF : null;
                        if (jsPDF) {
                            const pdf = new jsPDF('portrait', 'mm', 'a4', false);
                            pdf.addImage(imgData, 'PNG', 0, 0, 210, 297, undefined, 'NONE');
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

            function downloadPDF(btnElement) {
                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>Ultra 4K PDF তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `AcademicTranscript_${cleanName}.pdf`;

                const finish = () => {
                    btnElement.innerHTML = originalHTML;
                    btnElement.disabled = false;
                };

                const opt = {
                    margin: 0,
                    filename: filename,
                    image: { type: 'png' },
                    html2canvas: { scale: 5, useCORS: true, allowTaint: true, logging: false },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait', compress: false }
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

            function downloadImage(btnElement) {
                if (!doc) return;

                const originalHTML = btnElement.innerHTML;
                btnElement.innerHTML = `
                    <svg class="size-4 animate-spin inline-block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    <span>4K HD ছবি তৈরি হচ্ছে...</span>
                `;
                btnElement.disabled = true;

                const studentName = "{{ addslashes($student->name) }}";
                const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
                const filename = `AcademicTranscript_${cleanName}.png`;

                if (typeof html2canvas !== 'undefined') {
                    html2canvas(doc, { scale: 5, useCORS: true, allowTaint: true, logging: false }).then(canvas => {
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

            document.querySelectorAll('[data-download-pdf]').forEach(btn => {
                btn.addEventListener('click', function () { downloadPDF(this); });
            });

            document.querySelectorAll('[data-download-image]').forEach(btn => {
                btn.addEventListener('click', function () { downloadImage(this); });
            });
        });
    </script>
</main>

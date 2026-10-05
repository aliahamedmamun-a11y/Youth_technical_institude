@props([
    'student',
    'pages',
    'cumulativeGpa' => null,
    'letterGrade' => null,
    'instituteName' => 'Bangladesh Technical Training Institute',
    'gradingScale' => [],
])

@php($transcriptTemplateUrl = asset('images/academic-transcript-template.png').'?v='.filemtime(public_path('images/academic-transcript-template.png')))

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
                    {{ $result?->semester ?? 'First Semester' }}
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
                                <th style="width: 15%;">Subjects Code</th>
                                <th style="width: 50%;">Subjects Name</th>
                                <th style="width: 12%;">Credit Hours</th>
                                <th style="width: 11%;">Letter Grade</th>
                                <th style="width: 12%;">Grade Points</th>
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
                                <td colspan="3" style="border-right: 0; text-align: right; font-weight: 800;">{{ $result?->semester ?? '1st Semester' }} GPA</td>
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
            </article>
        @endforeach
    </div>

    <nav class="transcript-actions print:hidden" aria-label="Academic transcript actions">
        <button type="button" data-print-document onclick="window.print()" class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white transition hover:bg-emerald-600 cursor-pointer">
            Print transcript
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

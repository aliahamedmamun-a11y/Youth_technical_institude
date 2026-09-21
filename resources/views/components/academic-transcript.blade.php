@props([
    'student',
    'pages',
    'cumulativeGpa' => null,
    'letterGrade' => null,
    'instituteName',
    'gradingScale',
])

@php($transcriptTemplateUrl = asset('images/academic-transcript-template.png').'?v='.filemtime(public_path('images/academic-transcript-template.png')))

@vite(['resources/css/app.css', 'resources/css/academic-transcript.css', 'resources/js/app.js'])

<main class="transcript-screen">
    <h1 class="sr-only">Academic transcript for {{ $student->name }}</h1>

    <div class="transcript-stack">
        @foreach ($pages as $page)
            @php($result = $page['result'])

            <article class="transcript-page" data-transcript-page aria-label="Academic transcript page {{ $loop->iteration }} of {{ $loop->count }} for {{ $student->name }}">
                <img class="transcript-template" src="{{ $transcriptTemplateUrl }}" alt="">

                <header class="transcript-header">
                    <h2 class="transcript-institute-title">Bangladesh National Technical Education Institute</h2>
                    <p class="transcript-approved">Approved by Govt. of The People's Republic of Bangladesh</p>
                    <p class="transcript-web">www.bntei.com</p>
                    <div class="transcript-badge-wrapper">
                        <span class="transcript-badge">Academic Transcript</span>
                    </div>
                </header>

                <div class="transcript-crest">
                    <img src="{{ asset('images/Logo.png') }}" alt="BNTEI Crest">
                </div>

                <div class="transcript-qr-top">
                    @if($page['verificationQrCode'])
                        <img src="{{ $page['verificationQrCode'] }}" alt="QR Code">
                    @endif
                </div>

                <p class="transcript-serial"><span>Serial No:</span> <span class="transcript-serial-number">{{ $page['serial'] ?? '036564' }}</span></p>

                <table class="transcript-grading-scale" aria-label="Grading system">
                    <thead>
                        <tr><th colspan="3">Grading System</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($gradingScale as $gradeBand)
                            <tr>
                                <td>{{ $gradeBand['range'] }}</td>
                                <td>{{ $gradeBand['grade'] }}</td>
                                <td>{{ number_format($gradeBand['grade_point'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="transcript-student-info">
                    <dl class="transcript-details-left">
                        <div><dt>Name of Student</dt><dd>: {{ $student->name }}</dd></div>
                        <div><dt>Father's Name</dt><dd>: {{ $student->father_name ?? '—' }}</dd></div>
                        <div><dt>Mother's Name</dt><dd>: {{ $student->mother_name ?? '—' }}</dd></div>
                        <div><dt>Institution</dt><dd>: {{ $instituteName }}</dd></div>
                        <div><dt>Technology</dt><dd>: {{ $student->course?->name ?? '—' }}</dd></div>
                        <div><dt>Final CGPA</dt><dd>: {{ $cumulativeGpa !== null ? number_format((float) $cumulativeGpa, 2) : '—' }}</dd></div>
                    </dl>
                    <dl class="transcript-details-right">
                        <div><dt>Roll No</dt><dd>: {{ $student->roll_number ?? '—' }}</dd></div>
                        <div><dt>Registration No</dt><dd>: {{ $student->registration_number ?? '—' }}</dd></div>
                        <div><dt>Course Duration</dt><dd>: {{ $student->duration ?? $student->course?->duration ?? '—' }}</dd></div>
                        <div><dt>Session</dt><dd>: {{ $result?->session ?? $student->session ?? '—' }}</dd></div>
                        <div><dt>Earned Credit</dt><dd>: 0.00</dd></div>
                        <div><dt>Letter Grade</dt><dd>: {{ $letterGrade ?? '—' }}</dd></div>
                    </dl>
                </div>

                <div class="transcript-tables-container">
                    {{-- This container would hold the 8 semester tables in 2 columns as per the image --}}
                    {{-- For now, rendering the current page's results as one of those tables --}}
                    @if ($result)
                        <div class="transcript-semester-table">
                            <div class="semester-header">
                                <span>{{ $result->semester }}</span>
                                <span>GPA: {{ number_format((float) $result->gpa, 2) }}</span>
                                <span>Grade: {{ $result->overall_grade }}</span>
                            </div>
                            <table class="transcript-subject-values">
                                <thead>
                                    <tr>
                                        <th>Sub Code</th>
                                        <th>Subject Name</th>
                                        <th>Credit</th>
                                        <th>Grade</th>
                                        <th>Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($rowIndex = 0; $rowIndex < 6; $rowIndex++)
                                        @php($subject = $page['subjects']->get($rowIndex))
                                        <tr>
                                            <td>{{ $subject?->code }}</td>
                                            <td>{{ $subject?->title }}</td>
                                            <td>{{ $subject ? number_format((float) $subject->credit, 2) : '' }}</td>
                                            <td>{{ $subject?->grade }}</td>
                                            <td>{{ $subject?->grade_point !== null ? number_format((float) $subject->grade_point, 2) : '' }}</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                <footer class="transcript-footer">
                    <div class="footer-qr">
                        @if($page['verificationQrCode'])
                            <img src="{{ $page['verificationQrCode'] }}" alt="QR Code">
                        @endif
                        <p>Result Published: {{ $result?->published_at?->format('d-M-Y') ?? '15-Feb-2024' }}</p>
                    </div>
                    <div class="footer-sigs">
                        <div class="sig-compared">
                            <div class="sig-placeholder">Jahid</div>
                            <div class="sig-line"></div>
                            <p>Compared By</p>
                        </div>
                        <div class="sig-controller">
                            <div class="sig-placeholder">Saiful</div>
                            <div class="sig-line"></div>
                            <p>Controller of Examinations</p>
                            <p class="sig-inst">Bangladesh National Technical Education Institute</p>
                        </div>
                    </div>
                </footer>
                <div class="transcript-verification-note">
                    For verification please visit BNTEI website: www.bntei.com
                </div>
            </article>
        @endforeach
    </div>

    <nav class="transcript-actions print:hidden" aria-label="Academic transcript actions">
        <button type="button" data-print-document class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white transition hover:bg-emerald-600">
            Print transcript
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

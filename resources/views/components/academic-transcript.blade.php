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

                <p class="transcript-serial"><span>Serial No:</span> {{ $page['serial'] ?? '—' }}</p>

                <h2 class="transcript-semester">
                    {{ $result?->semester ?? 'No Published Result' }}{{ $page['isContinuation'] ? ' (Cont.)' : '' }}
                </h2>

                <table class="transcript-grading-scale" aria-label="Grading system">
                    <caption>Grading System</caption>
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

                <dl class="transcript-student-values" aria-label="Student and academic information">
                    <div><dt>Name of Student</dt><dd>{{ $student->name ?? '—' }}</dd></div>
                    <div><dt>Father's Name</dt><dd>{{ $student->father_name ?? '—' }}</dd></div>
                    <div><dt>Mother's Name</dt><dd>{{ $student->mother_name ?? '—' }}</dd></div>
                    <div><dt>Roll No</dt><dd>{{ $student->roll_number ?? '—' }}</dd></div>
                    <div><dt>Registration No</dt><dd>{{ $student->registration_number ?? '—' }}</dd></div>
                    <div><dt>Institution</dt><dd>{{ $instituteName }}</dd></div>
                    <div><dt>Technology</dt><dd>{{ $student->course?->name ?? '—' }}</dd></div>
                    <div><dt>Course Duration</dt><dd>{{ $student->duration ?? $student->course?->duration ?? '—' }}</dd></div>
                    <div><dt>Session</dt><dd>{{ $result?->session ?? $student->session ?? '—' }}</dd></div>
                    <div><dt>Final CGPA</dt><dd>{{ $cumulativeGpa !== null ? number_format((float) $cumulativeGpa, 2) : '—' }}</dd></div>
                    <div><dt>Letter Grade</dt><dd>{{ $letterGrade ?? '—' }}</dd></div>
                </dl>

                @if ($result)
                    <table class="transcript-subject-values">
                        <caption class="sr-only">Subjects for {{ $result->semester }}</caption>
                        <thead>
                            <tr>
                                <th scope="col">Subjects<br>Code</th>
                                <th scope="col">Subjects Name</th>
                                <th scope="col">Credit<br>Hours</th>
                                <th scope="col">Letter<br>Grade</th>
                                <th scope="col">Grade<br>Points</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($rowIndex = 0; $rowIndex < 7; $rowIndex++)
                                @php($subject = $page['subjects']->get($rowIndex))
                                <tr data-transcript-subject-row>
                                    <td>{{ $subject?->code }}</td>
                                    <td>{{ $subject?->title }}</td>
                                    <td>{{ $subject ? number_format((float) $subject->credit, 2) : '' }}</td>
                                    <td>{{ $subject?->grade }}</td>
                                    <td>{{ $subject?->grade_point !== null ? number_format((float) $subject->grade_point, 2) : '' }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                    @if ($page['isSemesterFinal'])
                        <dl class="transcript-semester-summary" aria-label="Semester result summary">
                            <div>
                                <dt>{{ $result->semester }} GPA</dt>
                                <dd>{{ $result->gpa !== null ? number_format((float) $result->gpa, 2) : '—' }}</dd>
                            </div>
                            <div>
                                <dt>Result</dt>
                                <dd>{{ $page['outcome'] ?? '—' }}</dd>
                            </div>
                        </dl>
                    @endif

                    @if ($page['verificationQrCode'] && $page['verificationUrl'])
                        <a class="transcript-verification" href="{{ $page['verificationUrl'] }}" aria-label="Verify {{ $result->semester }} result">
                            <img src="{{ $page['verificationQrCode'] }}" alt="Verification QR code">
                            <span>Scan the QR code to verify this marksheet.</span>
                            <small>{{ $page['verificationReference'] }}</small>
                        </a>
                    @endif
                @else
                    <section class="transcript-no-results">
                        <p>No published results available</p>
                    </section>
                @endif
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

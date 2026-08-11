@props([
    'student',
    'pages',
    'cumulativeGpa' => null,
    'letterGrade' => null,
    'instituteName',
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

                <p class="transcript-serial">{{ $page['serial'] ?? '—' }}</p>

                <h2 class="transcript-semester">
                    {{ $result?->semester ?? 'No Published Result' }}{{ $page['isContinuation'] ? ' (Cont.)' : '' }}
                </h2>

                <dl class="transcript-student-values" aria-label="Student and academic information">
                    <div><dt class="sr-only">Name of Student</dt><dd>{{ $student->name ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Father's Name</dt><dd>{{ $student->father_name ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Mother's Name</dt><dd>{{ $student->mother_name ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Roll Number</dt><dd>{{ $student->roll_number ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Registration Number</dt><dd>{{ $student->registration_number ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Institution</dt><dd>{{ $instituteName }}</dd></div>
                    <div><dt class="sr-only">Technology</dt><dd>{{ $student->course?->name ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Course Duration</dt><dd>{{ $student->duration ?? $student->course?->duration ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Session</dt><dd>{{ $result?->session ?? $student->session ?? '—' }}</dd></div>
                    <div><dt class="sr-only">Final CGPA</dt><dd>{{ $cumulativeGpa !== null ? number_format((float) $cumulativeGpa, 2) : '—' }}</dd></div>
                    <div><dt class="sr-only">Letter Grade</dt><dd>{{ $letterGrade ?? '—' }}</dd></div>
                </dl>

                @if ($result)
                    <table class="transcript-subject-values">
                        <caption class="sr-only">Subjects for {{ $result->semester }}</caption>
                        <tbody>
                            @foreach ($page['subjects'] as $subject)
                                <tr>
                                    <td>{{ $subject->code ?? '—' }}</td>
                                    <td>{{ $subject->title ?? '—' }}</td>
                                    <td>{{ number_format((float) $subject->credit, 2) }}</td>
                                    <td>{{ $subject->grade ?? '—' }}</td>
                                    <td>{{ $subject->grade_point !== null ? number_format((float) $subject->grade_point, 2) : '—' }}</td>
                                </tr>
                            @endforeach
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

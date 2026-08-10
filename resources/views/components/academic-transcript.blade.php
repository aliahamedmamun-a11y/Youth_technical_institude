@props([
    'student',
    'pages',
    'cumulativeGpa' => null,
    'totalCredit' => 0,
    'creditEarned' => 0,
    'verificationQrCode' => null,
    'verificationUrl' => null,
    'verificationReference' => null,
])

@vite(['resources/css/app.css', 'resources/css/academic-transcript.css', 'resources/js/app.js'])

<main class="transcript-screen">
    <h1 class="sr-only">Academic transcript for {{ $student->name }}</h1>

    <div class="transcript-stack">
        @foreach ($pages as $page)
            @php
                $result = $page['result'];
                $isFinalPage = $loop->last;
            @endphp

            <article class="transcript-page" data-transcript-page aria-label="Academic transcript page {{ $loop->iteration }} of {{ $loop->count }} for {{ $student->name }}">
                <img class="transcript-template" src="{{ asset('images/academic-transcript-template.png') }}" alt="">

                <div class="transcript-content">
                    <section class="transcript-student-details" aria-label="Student details">
                        <div><span>Student</span><strong>{{ $student->name }}</strong></div>
                        <div><span>Registration No.</span><strong>{{ $student->registration_number ?? '—' }}</strong></div>
                        <div><span>Course</span><strong>{{ $student->course?->name ?? '—' }}</strong></div>
                        <div><span>Roll No.</span><strong>{{ $student->roll_number ?? '—' }}</strong></div>
                    </section>

                    @if ($result)
                        <section class="transcript-result">
                            <header class="transcript-result-header">
                                <div>
                                    <h2>{{ $result->semester }}</h2>
                                    @if ($page['isContinuation'])
                                        <p>Continuation</p>
                                    @endif
                                </div>
                                <p>Session: <strong>{{ $result->session }}</strong></p>
                            </header>

                            <table class="transcript-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Code</th>
                                        <th scope="col">Subject</th>
                                        <th scope="col">Credit</th>
                                        <th scope="col">Marks</th>
                                        <th scope="col">Grade</th>
                                        <th scope="col">Grade Point</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($page['subjects'] as $subject)
                                        <tr>
                                            <td>{{ $subject->code }}</td>
                                            <td>{{ $subject->title }}</td>
                                            <td>{{ number_format((float) $subject->credit, 2) }}</td>
                                            <td>{{ $subject->marks !== null ? number_format((float) $subject->marks, 2) : '—' }}</td>
                                            <td>{{ $subject->grade ?? '—' }}</td>
                                            <td>{{ $subject->grade_point !== null ? number_format((float) $subject->grade_point, 2) : '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="transcript-empty-row">No subjects recorded for this semester.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            @if ($page['isSemesterFinal'])
                                <div class="transcript-semester-summary">
                                    <span>Total Credit: <strong>{{ number_format((float) $result->total_credit, 2) }}</strong></span>
                                    <span>Credit Earned: <strong>{{ number_format((float) $result->credit_earned, 2) }}</strong></span>
                                    <span>GPA: <strong>{{ $result->gpa !== null ? number_format((float) $result->gpa, 2) : '—' }}</strong></span>
                                    <span>Grade: <strong>{{ $result->overall_grade ?? '—' }}</strong></span>
                                </div>
                            @endif
                        </section>
                    @else
                        <section class="transcript-no-results">
                            <p>No published results available</p>
                            <span>Published semester results will appear here when they are available.</span>
                        </section>
                    @endif

                    <footer class="transcript-footer">
                        @if ($isFinalPage && $result)
                            <div class="transcript-cumulative-summary">
                                <span>Total Credits <strong>{{ number_format((float) $totalCredit, 2) }}</strong></span>
                                <span>Credits Earned <strong>{{ number_format((float) $creditEarned, 2) }}</strong></span>
                                <span>CGPA <strong>{{ $cumulativeGpa !== null ? number_format((float) $cumulativeGpa, 2) : '—' }}</strong></span>
                            </div>

                            @if ($verificationQrCode)
                                <div class="transcript-verification">
                                    <img src="{{ $verificationQrCode }}" alt="Scan to verify this academic transcript">
                                    <div>
                                        <strong>Online Verification</strong>
                                        <span>{{ $verificationReference }}</span>
                                        <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <p class="transcript-page-number">Page {{ $loop->iteration }} of {{ $loop->count }}</p>
                    </footer>
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

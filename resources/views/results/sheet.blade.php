<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result Sheet | {{ $result->student->name }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page { size: A4 portrait; margin: 10mm; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; color: #000 !important; }
            .result-sheet { box-shadow: none !important; border: 1px solid #cbd5e1 !important; width: 100% !important; max-width: 100% !important; margin: 0 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 font-sans antialiased min-h-screen py-6">

<main class="mx-auto max-w-5xl px-4">

    <!-- NO PRINT TOOLBAR & STYLE TOGGLE -->
    <div class="no-print mb-6 flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-md">
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ $adminPreview ? route('super-admin.students.results.index', $result->student) : route('results.index') }}" class="rounded-xl border border-slate-300 bg-slate-100 hover:bg-slate-200 px-4 py-2 text-xs font-black uppercase text-slate-700 transition">
                ← Back
            </a>

            <!-- VIEW STYLE TOGGLE BUTTONS -->
            <div class="inline-flex rounded-xl bg-slate-100 p-1 border border-slate-200">
                <a href="?style=all" @class([
                    'rounded-lg px-3 py-1.5 text-xs font-bold transition',
                    'bg-indigo-600 text-white shadow' => ($viewStyle ?? 'all') === 'all' || ($viewStyle ?? 'all') === 'transcript',
                    'text-slate-600 hover:text-slate-900' => ($viewStyle ?? 'all') !== 'all' && ($viewStyle ?? 'all') !== 'transcript'
                ])>
                    📜 Subject Transcript (Style 1)
                </a>
                <a href="?style=summary" @class([
                    'rounded-lg px-3 py-1.5 text-xs font-bold transition',
                    'bg-indigo-600 text-white shadow' => ($viewStyle ?? 'all') === 'summary' || ($viewStyle ?? 'all') === 'style2',
                    'text-slate-600 hover:text-slate-900' => ($viewStyle ?? 'all') !== 'summary' && ($viewStyle ?? 'all') !== 'style2'
                ])>
                    📊 Semester & Course Summary (Style 2)
                </a>
                <a href="?style=single" @class([
                    'rounded-lg px-3 py-1.5 text-xs font-bold transition',
                    'bg-indigo-600 text-white shadow' => ($viewStyle ?? 'all') === 'single',
                    'text-slate-600 hover:text-slate-900' => ($viewStyle ?? 'all') !== 'single'
                ])>
                    📄 Single Semester
                </a>
            </div>
        </div>

        <button onclick="window.print()" class="rounded-xl bg-slate-900 hover:bg-slate-800 px-5 py-2.5 text-xs font-black uppercase text-white shadow-lg transition active:scale-95 flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            Print Result Sheet
        </button>
    </div>

    <!-- MAIN RESULT SHEET DOCUMENT -->
    <article class="result-sheet mx-auto max-w-4xl border border-slate-300 bg-white shadow-2xl rounded-sm p-6 space-y-4">

        <!-- HEADER -->
        <header class="grid grid-cols-[80px_1fr_80px] items-center gap-4 border-b border-slate-300 pb-4">
            <img src="{{ asset('images/Logo.png') }}" alt="BNYTI Logo" class="size-16 object-contain mx-auto">

            <div class="text-center space-y-0.5">
                <p class="text-[8px] font-bold uppercase tracking-[.2em] text-slate-500">Government of the People's Republic of Bangladesh</p>
                <h1 class="text-sm sm:text-lg font-black uppercase tracking-wide text-slate-900">South Asia Engineering & Technical Institute</h1>
                <p class="text-base sm:text-xl font-black tracking-[.15em] text-slate-900 border-t border-slate-200 pt-1 mt-1 inline-block px-4">RESULT SHEET</p>
            </div>

            @if ($result->student->image_path)
                <img src="{{ str_starts_with($result->student->image_path, 'http') ? $result->student->image_path : Storage::disk('public')->url($result->student->image_path) }}" alt="Student photo" class="size-16 rounded border border-slate-300 object-cover mx-auto shadow-sm">
            @else
                <div class="size-16 rounded border border-dashed border-slate-300 bg-slate-50 flex items-center justify-center text-slate-400 text-[10px] mx-auto">Photo</div>
            @endif
        </header>

        <!-- STUDENT INFORMATION GRID -->
        <section class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-1.5 border border-slate-300 bg-slate-50/50 p-3 text-[11px] rounded">
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Name of Student</span>: <strong class="text-slate-900">{{ $result->student->name }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Roll</span>: <strong class="text-slate-900">{{ $result->student->roll_number ?? '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Father's Name</span>: <strong>{{ $result->student->father_name ?? '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Registration No</span>: <strong>{{ $result->student->registration_number ?? '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Mother's Name</span>: <strong>{{ $result->student->mother_name ?? '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Subject name</span>: <strong>{{ $result->student->course?->name ?? '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Date of Birth</span>: <strong>{{ optional($result->student->date_of_birth)->format('d/m/Y') ?? '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Nid/ Passport No</span>: <strong>{{ $result->student->passport_nid_number ?: '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">Institute Name</span>: <strong>{{ $result->student->director_name ?: 'South Asia Engineering & Technical Institute' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] border-b border-slate-200/80 py-1"><span class="font-bold text-slate-600">CGPA</span>: <strong class="text-indigo-700">{{ $cumulativeGpa ?? $result->student->cgpa ?? $result->gpa ?? '—' }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] py-1"><span class="font-bold text-slate-600">Session</span>: <strong>{{ $result->student->session ?: $result->session }}</strong></div>
            <div class="grid grid-cols-[120px_1fr] py-1"><span class="font-bold text-slate-600">Overall Grade</span>: <strong class="text-emerald-700">{{ $result->student->grade ?: $result->overall_grade ?: 'A' }}</strong></div>
        </section>

        @php
            $currentStyle = $viewStyle ?? 'all';
            $isSummaryStyle = $currentStyle === 'summary' || $currentStyle === 'style2';
            $isSingleStyle = $currentStyle === 'single';
            $isFullTranscript = !$isSummaryStyle && !$isSingleStyle;

            $resultSets = $isFullTranscript ? ($allResults ?? collect([$result])) : collect([$result]);
        @endphp

        @if ($isSummaryStyle)
            <!-- STYLE 2: SEMESTER WISE RESULTS & COURSE WISE MARKS TABLES (NEW SCREENSHOT FORMAT) -->
            <div class="space-y-5 pt-2">

                <!-- Table 1: Semester Wise Results -->
                <div class="space-y-1">
                    <h3 class="text-center text-xs font-bold text-slate-800 uppercase tracking-wide">Semester Wise Results</h3>
                    <div class="overflow-hidden border border-slate-900 rounded">
                        <table class="w-full text-center text-[11px] border-collapse">
                            <thead class="bg-slate-200/80 border-b border-slate-900 font-bold text-slate-900">
                                <tr>
                                    <th class="border-r border-slate-900 px-3 py-1.5 w-1/3">Semester</th>
                                    <th class="border-r border-slate-900 px-3 py-1.5 w-1/3">Grade</th>
                                    <th class="px-3 py-1.5 w-1/3">CGPA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-300">
                                @php
                                    $semList = [
                                        '1st Semester' => ['A', '3.75'],
                                        '2nd Semester' => ['A+', '4.00'],
                                        '3rd Semester' => ['A+', '4.00'],
                                        '4th Semester' => ['A', '3.75'],
                                        '5th Semester' => ['A-', '3.50'],
                                        '6th Semester' => ['A-', '3.50'],
                                        '7th Semester' => ['A', '3.75'],
                                        '8th Semester' => ['A', '3.75'],
                                    ];

                                    if (isset($allResults) && $allResults->count() > 0) {
                                        foreach ($allResults as $resRecord) {
                                            $semName = $resRecord->semester;
                                            if (!str_contains(strtolower($semName), 'semester')) {
                                                $semName .= ' Semester';
                                            }
                                            $semList[$semName] = [
                                                $resRecord->overall_grade ?? 'A',
                                                number_format((float)($resRecord->gpa ?? 3.75), 2)
                                            ];
                                        }
                                    }
                                @endphp
                                @foreach ($semList as $sName => $sData)
                                    <tr class="hover:bg-slate-50">
                                        <td class="border-r border-slate-300 px-3 py-1.5 font-medium text-slate-800">{{ $sName }}</td>
                                        <td class="border-r border-slate-300 px-3 py-1.5 font-bold text-indigo-800">{{ $sData[0] }}</td>
                                        <td class="px-3 py-1.5 font-bold text-slate-800">{{ $sData[1] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table 2: Course Wise Grade/Marks -->
                <div class="space-y-1">
                    <h3 class="text-center text-xs font-bold text-slate-800 uppercase tracking-wide">Course Wise Grade/Marks</h3>
                    <div class="overflow-hidden border border-slate-900 rounded">
                        <table class="w-full text-center text-[11px] border-collapse">
                            <thead class="bg-slate-200/80 border-b border-slate-900 font-bold text-slate-900">
                                <tr>
                                    <th class="border-r border-slate-900 px-2 py-1.5">Written</th>
                                    <th class="border-r border-slate-900 px-2 py-1.5">Practical</th>
                                    <th class="border-r border-slate-900 px-2 py-1.5">Viva</th>
                                    <th class="border-r border-slate-900 px-2 py-1.5">Total</th>
                                    <th class="border-r border-slate-900 px-2 py-1.5">Full Mark</th>
                                    <th class="border-r border-slate-900 px-2 py-1.5">CGPA</th>
                                    <th class="px-2 py-1.5">Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $st = $result->student;
                                    $written = $st?->written_marks ?? 3320;
                                    $practical = $st?->practical_marks ?? 270;
                                    $viva = $st?->viva_marks ?? 250;
                                    $total = $st?->score ?? ($written + $practical + $viva) ?: 3840;
                                    $fullMark = $st?->full_marks ?? 4800;
                                    $cgpaVal = $st?->cgpa ?? $cumulativeGpa ?? $result->gpa ?? 3.75;
                                    $gradeVal = $st?->grade ?? $result->overall_grade ?? 'A';
                                @endphp
                                <tr class="font-bold text-slate-900">
                                    <td class="border-r border-slate-300 px-2 py-2">{{ $written }}</td>
                                    <td class="border-r border-slate-300 px-2 py-2">{{ $practical }}</td>
                                    <td class="border-r border-slate-300 px-2 py-2">{{ $viva }}</td>
                                    <td class="border-r border-slate-300 px-2 py-2 text-indigo-900">{{ $total }}</td>
                                    <td class="border-r border-slate-300 px-2 py-2">{{ $fullMark }}</td>
                                    <td class="border-r border-slate-300 px-2 py-2 text-emerald-800">{{ number_format((float)$cgpaVal, 2) }}</td>
                                    <td class="px-2 py-2 text-emerald-800">{{ $gradeVal }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        @else
            <!-- STYLE 1 / STYLE 3: SUBJECT-WISE SEMESTER RESULTS GRID -->
            <div @class([
                'grid gap-3 pt-2',
                'grid-cols-1 md:grid-cols-2' => $isFullTranscript && $resultSets->count() > 1,
                'grid-cols-1' => !$isFullTranscript || $resultSets->count() <= 1
            ])>
                @foreach ($resultSets as $semesterResult)
                    <section class="min-w-0 break-inside-avoid">
                        <div class="overflow-hidden border border-slate-300 rounded shadow-sm">
                            <h2 class="bg-slate-100 border-b border-slate-300 py-1.5 text-center text-[10px] font-black uppercase tracking-[.18em] text-slate-800">
                                {{ $semesterResult->semester }}
                            </h2>
                            <table class="w-full text-[10px]">
                                <thead class="bg-slate-50 border-b border-slate-200">
                                    <tr>
                                        <th class="border-r border-slate-200 px-2 py-1.5 text-left font-bold text-slate-600">CODE</th>
                                        <th class="border-r border-slate-200 px-2 py-1.5 text-left font-bold text-slate-600">TITLE</th>
                                        <th class="border-r border-slate-200 px-2 py-1.5 text-center font-bold text-slate-600">CR</th>
                                        <th class="border-r border-slate-200 px-2 py-1.5 text-center font-bold text-slate-600">GRADE</th>
                                        <th class="px-2 py-1.5 text-center font-bold text-slate-600">CGPA</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse ($semesterResult->subjects as $subject)
                                        <tr>
                                            <td class="border-r border-slate-200 px-2 py-1 font-mono text-slate-700">{{ $subject->code }}</td>
                                            <td class="border-r border-slate-200 px-2 py-1 font-medium text-slate-900">{{ $subject->title }}</td>
                                            <td class="border-r border-slate-200 px-2 py-1 text-center font-bold text-slate-700">{{ $subject->credit }}</td>
                                            <td class="border-r border-slate-200 px-2 py-1 text-center font-black text-indigo-700">{{ $subject->grade ?? '—' }}</td>
                                            <td class="px-2 py-1 text-center font-bold text-slate-700">{{ $subject->grade_point ?? '—' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-2 py-3 text-center text-slate-400">No subject marks recorded</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-slate-50 border-t border-slate-300">
                                    <tr>
                                        <td colspan="2" class="px-2 py-1.5 font-bold text-slate-700">TOTAL CREDIT: {{ $semesterResult->total_credit }}</td>
                                        <td colspan="3" class="px-2 py-1.5 text-right font-bold text-slate-700">GPA: {{ $semesterResult->gpa ?? '—' }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>
                @endforeach
            </div>
        @endif

        <!-- SUMMARY FOOTER -->
        <footer class="pt-4 border-t border-slate-300 space-y-4">

            @if ($isFullTranscript)
                <!-- FULL ACADEMIC TRANSCRIPT SUMMARY BOXES -->
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-2 text-center text-[10px] font-black uppercase tracking-wider">
                    <div class="p-2 border border-slate-300 rounded bg-slate-50">
                        <span class="block text-[8px] text-slate-500">TOTAL SEMESTER</span>
                        <span class="text-sm font-black text-slate-900">{{ $resultSets->count() }}</span>
                    </div>
                    <div class="p-2 border border-slate-300 rounded bg-slate-50">
                        <span class="block text-[8px] text-slate-500">TOTAL CREDIT</span>
                        <span class="text-sm font-black text-slate-900">{{ $resultSets->sum('total_credit') }}</span>
                    </div>
                    <div class="p-2 border border-slate-300 rounded bg-slate-50">
                        <span class="block text-[8px] text-slate-500">TOTAL CREDIT EARNED</span>
                        <span class="text-sm font-black text-slate-900">{{ $resultSets->sum('credit_earned') }}</span>
                    </div>
                    <div class="p-2 border border-slate-300 rounded bg-slate-50">
                        <span class="block text-[8px] text-slate-500">CGPA</span>
                        <span class="text-sm font-black text-emerald-700">{{ $cumulativeGpa ?? $result->gpa ?? '—' }}</span>
                    </div>
                    <div class="p-2 border border-slate-300 rounded bg-slate-50 col-span-2 sm:col-span-1">
                        <span class="block text-[8px] text-slate-500">OVERALL GRADE</span>
                        <span class="text-sm font-black text-indigo-700">{{ $result->overall_grade ?? 'A' }}</span>
                    </div>
                </div>
            @elseif (!$isSummaryStyle)
                <!-- SINGLE SEMESTER SUMMARY LINE -->
                <div class="flex flex-wrap items-center justify-between gap-4 p-2.5 border border-slate-300 rounded bg-slate-50 text-[10px] font-black uppercase tracking-wider">
                    <span>TOTAL CREDIT: {{ $result->total_credit }}</span>
                    <span>CREDIT EARNED: {{ $result->credit_earned }}</span>
                    <span>CGPA: <strong class="text-emerald-700 text-xs">{{ $result->gpa ?? '—' }}</strong></span>
                </div>
            @endif

            <div class="flex flex-wrap items-end justify-between gap-6 pt-2">
                <!-- NOTE & PUBLISHED DATE -->
                <div class="space-y-3 text-[9px] text-slate-600 max-w-md">
                    <div>
                        <p class="font-bold text-slate-800">Note:</p>
                        <ul class="list-disc pl-3 space-y-0.5">
                            <li>This result sheet is computer generated.</li>
                            <li>No signature is required.</li>
                            <li>Any discrepancy should be reported to the institute authority.</li>
                            <li>Scan the QR code to verify this result.</li>
                        </ul>
                    </div>

                    <div class="inline-flex items-center gap-2 border border-slate-300 rounded px-3 py-1 bg-slate-50 text-[10px]">
                        <svg class="size-3.5 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        <span class="font-bold">Published On:</span>
                        <span>{{ $result->student->publication_date ?: optional($result->published_at ?? $result->created_at)->format('d F Y') }}</span>
                    </div>
                </div>

                <!-- SIGNATURE & QR CODE -->
                <div class="flex items-end gap-6">
                    <div class="text-center">
                        <div class="h-8 border-b border-slate-400 w-32 mx-auto flex items-end justify-center pb-1">
                            <span class="font-serif italic text-xs font-bold text-indigo-900">G. A. Mamun</span>
                        </div>
                        <p class="text-[9px] font-bold text-slate-700 mt-1">Controller of Examinations</p>
                        <p class="text-[8px] text-slate-500">South Asia Engineering & Technical Institute</p>
                    </div>

                    <div class="text-center">
                        <img src="{{ ($qrCodes ?? collect())->get($result->id, $qrCode) }}" alt="Scan to verify result" class="mx-auto size-20 border border-slate-200 p-1 rounded">
                        <p class="mt-1 text-[8px] font-bold text-slate-500 uppercase tracking-wider">SCAN TO VERIFY</p>
                    </div>
                </div>
            </div>

        </footer>

    </article>

</main>

</body>
</html>

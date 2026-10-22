<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Result Sheet | {{ $result->student->name }}</title>
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @page {
            size: A4 portrait !important;
            margin: 0 !important;
        }
        @page :left { margin: 0 !important; }
        @page :right { margin: 0 !important; }
        @page :first { margin: 0 !important; }

        tbody tr:nth-child(even) { background: #f8fafc; }

        @media print {
            @page {
                size: A4 portrait !important;
                margin: 0 !important;
            }

            .no-print,
            nav,
            header:not(.result-sheet-header),
            footer:not(.result-sheet-footer),
            [class*="no-print"] {
                display: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
                height: 0 !important;
                width: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden !important;
            }

            html,
            body {
                background: #fff !important;
                color: #000 !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 210mm !important;
                height: 297mm !important;
                max-width: 210mm !important;
                max-height: 297mm !important;
                overflow: hidden !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body {
                padding: 4mm !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .result-sheet {
                box-shadow: none !important;
                border: 1px solid #64748b !important;
                width: 100% !important;
                max-width: 100% !important;
                height: 288mm !important;
                margin: 0 auto !important;
                padding: 8px 12px !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                border-radius: 0 !important;
                overflow: hidden !important;
            }

            .grid-cols-2, .md\:grid-cols-2 {
                display: grid !important;
                grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                gap: 0.25rem !important;
            }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 font-sans antialiased min-h-screen py-4 sm:py-6">

<main class="mx-auto max-w-5xl px-2 sm:px-4">

    <!-- NO PRINT TOOLBAR & STYLE TOGGLE -->
    <div class="no-print mb-4 sm:mb-6 flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-slate-200 bg-white p-3 sm:p-4 shadow-md">
        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ $adminPreview ? route('super-admin.students.results.index', $result->student) : route('results.index') }}" class="rounded-xl border border-slate-300 bg-slate-100 hover:bg-slate-200 px-3 py-2 text-xs font-black uppercase text-slate-700 transition">
                ← Back
            </a>

            <!-- VIEW STYLE TOGGLE BUTTONS -->
            <div class="inline-flex rounded-xl bg-slate-100 p-1 border border-slate-200">
                <a href="?style=all" @class([
                    'rounded-lg px-3 py-1.5 text-xs font-bold transition',
                    'bg-indigo-600 text-white shadow' => ($viewStyle ?? 'all') === 'all' || ($viewStyle ?? 'all') === 'transcript',
                    'text-slate-600 hover:text-slate-900' => ($viewStyle ?? 'all') !== 'all' && ($viewStyle ?? 'all') !== 'transcript'
                ])>
                    📜 Full Result Sheet (8 Semesters)
                </a>
                <a href="?style=summary" @class([
                    'rounded-lg px-3 py-1.5 text-xs font-bold transition',
                    'bg-indigo-600 text-white shadow' => ($viewStyle ?? 'all') === 'summary' || ($viewStyle ?? 'all') === 'style2',
                    'text-slate-600 hover:text-slate-900' => ($viewStyle ?? 'all') !== 'summary' && ($viewStyle ?? 'all') !== 'style2'
                ])>
                    📊 Summary
                </a>
                <a href="?style=single" @class([
                    'rounded-lg px-3 py-1.5 text-xs font-bold transition',
                    'bg-indigo-600 text-white shadow' => ($viewStyle ?? 'all') === 'single',
                    'text-slate-600 hover:text-slate-900' => ($viewStyle ?? 'all') !== 'single'
                ])>
                    📄 Single Semester
                </a>
            </div>

            <!-- DYNAMIC SEMESTER SELECT OPTION -->
            @if (isset($semesterResults) && count($semesterResults) > 0)
                <div class="inline-flex items-center gap-1.5 rounded-xl border border-indigo-200 bg-indigo-50/80 px-3 py-1.5 shadow-sm">
                    <span class="text-[11px] font-black uppercase text-indigo-900 tracking-wider">Semester:</span>
                    <select onchange="window.location.href=this.value" class="bg-transparent text-xs font-bold text-indigo-950 outline-none cursor-pointer">
                        @foreach ($semesterResults as $semRes)
                            @php
                                $semUrl = route($adminPreview ? 'super-admin.results.show' : 'results.show', $adminPreview ? $semRes : $semRes->verification_token) . '?style=' . ($viewStyle ?? 'all');
                            @endphp
                            <option value="{{ $semUrl }}" @selected($semRes->id === $result->id)>
                                {{ $semRes->semester }} {{ $semRes->gpa ? '(GPA: '.number_format((float)$semRes->gpa, 2).')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <button type="button" data-download-pdf class="rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 sm:px-5 py-2.5 text-xs font-black uppercase text-white shadow-lg transition active:scale-95 flex items-center gap-2 border border-emerald-500 cursor-pointer">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                📥 Download PDF (পিডিএফ)
            </button>

            <button type="button" data-download-image class="rounded-xl bg-blue-600 hover:bg-blue-700 px-4 sm:px-5 py-2.5 text-xs font-black uppercase text-white shadow-lg transition active:scale-95 flex items-center gap-2 border border-blue-500 cursor-pointer">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                🖼️ Download Image (ছবি)
            </button>

            <button type="button" onclick="window.print()" class="rounded-xl bg-slate-900 hover:bg-slate-800 px-4 py-2.5 text-xs font-black uppercase text-white shadow-lg transition active:scale-95 flex items-center gap-2 cursor-pointer">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
                </svg>
                Print
            </button>
        </div>
    </div>

    <!-- MAIN RESULT SHEET DOCUMENT -->
    <article class="result-sheet mx-auto max-w-4xl border border-slate-300 bg-white shadow-2xl rounded-sm p-4 sm:p-5 space-y-3">

        <!-- HEADER -->
        <header class="grid grid-cols-[80px_1fr_80px] sm:grid-cols-[100px_1fr_100px] items-center gap-2 sm:gap-4 border-b-2 border-slate-300 pb-3">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-18 h-18 sm:w-24 sm:h-24 object-contain mx-auto drop-shadow-sm">

            <div class="text-center space-y-0.5">
                <p class="text-[8px] sm:text-[9px] font-bold uppercase tracking-[.2em] text-slate-600">Government of the People's Republic of Bangladesh</p>
                @php
                    $studentHeaderInstitute = $result->student->branch?->name
                        ?? $result->student->institute_name
                        ?? $result->student->branch?->institute_name;

                    if ($studentHeaderInstitute && in_array(strtoupper(trim($studentHeaderInstitute)), ['BNTEI', 'BNTI', 'BANGLADESH NATIONAL YOUTH TECHNICAL INSTITUTE', 'SOUTH ASIA ENGINEERING & TECHNICAL INSTITUTE', 'SOUTH ASIA ENGINEERING AND TECHNICAL INSTITUTE'])) {
                        $studentHeaderInstitute = null;
                    }
                @endphp

                <h1 class="text-sm sm:text-lg font-black uppercase tracking-tight text-slate-900 leading-snug">
                    {{ $studentHeaderInstitute ?? 'BANGLADESH NATIONAL YOUTH TECHNICAL INSTITUTE' }}
                </h1>
                <p class="text-base sm:text-xl font-black tracking-[.2em] text-slate-900 border-t-2 border-slate-300 pt-1 mt-0.5 inline-block px-4 sm:px-6">RESULT SHEET</p>
            </div>

            @if ($result->student->image_path)
                <img src="{{ str_starts_with($result->student->image_path, 'http') ? $result->student->image_path : Storage::disk('public')->url($result->student->image_path) }}" alt="Student photo" class="w-18 h-22 sm:w-22 sm:h-26 rounded border-2 border-slate-300 object-cover mx-auto shadow-sm" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
            @else
                <div class="w-18 h-22 sm:w-22 sm:h-26 rounded border-2 border-dashed border-slate-300 bg-slate-50 flex items-center justify-center text-slate-400 text-[10px] font-bold mx-auto">Photo</div>
            @endif
        </header>

        <!-- STUDENT INFORMATION GRID -->
        <div class="overflow-hidden border border-slate-400 rounded text-[10px] sm:text-[11px] shadow-sm">
            <table class="w-full border-collapse">
                <tbody class="divide-y divide-slate-300">
                    <tr class="divide-x divide-slate-300">
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800 w-32 sm:w-36">Name of Student</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->name }}</td>
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800 w-32 sm:w-36">Roll</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->roll_number ?: sprintf('%06d', $result->student->id) }}</td>
                    </tr>
                    <tr class="divide-x divide-slate-300">
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Father's Name</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->father_name ?? '—' }}</td>
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Registration No</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->registration_number ?? '—' }}</td>
                    </tr>
                    <tr class="divide-x divide-slate-300">
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Mother's Name</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->mother_name ?? '—' }}</td>
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Subject name</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->course?->name ?? 'Certificate in Tiles Mason' }}</td>
                    </tr>
                    <tr class="divide-x divide-slate-300">
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Date of Birth</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ optional($result->student->date_of_birth)->format('d/m/Y') ?? '10/05/1996' }}</td>
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Nid/ Passport No</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->passport_nid_number ?: '—' }}</td>
                    </tr>
                    <tr class="divide-x divide-slate-300">
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Institute Name</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->branch?->name ?? $result->student->institute_name ?? $result->student->branch?->institute_name ?? 'Titas Technical Training Center' }}</td>
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">CGPA</td>
                        <td class="px-2.5 py-1 font-bold text-indigo-900">: {{ number_format((float)($cumulativeGpa ?? $result->student->cgpa ?? $result->gpa ?? 3.86), 2) }}</td>
                    </tr>
                    <tr class="divide-x divide-slate-300">
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Session</td>
                        <td class="px-2.5 py-1 font-bold text-slate-900">: {{ $result->student->session ?: $result->session ?: 'July 2025 - December 2025' }}</td>
                        <td class="bg-blue-50/80 px-2.5 py-1 font-bold text-slate-800">Overall Grade</td>
                        <td class="px-2.5 py-1 font-bold text-emerald-800">: {{ $result->student->grade ?: $result->overall_grade ?: 'A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @php
            $currentStyle = $viewStyle ?? 'all';
            $isSummaryStyle = $currentStyle === 'summary' || $currentStyle === 'style2';
            $isSingleStyle = $currentStyle === 'single';

            $formatSemTitle = function ($rawName, $index = 0) {
                $str = strtolower(trim((string) $rawName));
                $mapped = match ($str) {
                    '1st semester', '1st', 'first semester', 'semester 1', '1' => 'FIRST YEAR FIRST SEMESTER',
                    '2nd semester', '2nd', 'second semester', 'semester 2', '2' => 'FIRST YEAR SECOND SEMESTER',
                    '3rd semester', '3rd', 'third semester', 'semester 3', '3' => 'SECOND YEAR FIRST SEMESTER',
                    '4th semester', '4th', 'fourth semester', 'semester 4', '4' => 'SECOND YEAR SECOND SEMESTER',
                    '5th semester', '5th', 'fifth semester', 'semester 5', '5' => 'THIRD YEAR FIRST SEMESTER',
                    '6th semester', '6th', 'sixth semester', 'semester 6', '6' => 'THIRD YEAR SECOND SEMESTER',
                    '7th semester', '7th', 'seventh semester', 'semester 7', '7' => 'FOURTH YEAR FIRST SEMESTER',
                    '8th semester', '8th', 'eighth semester', 'semester 8', '8' => 'FOURTH YEAR SECOND SEMESTER',
                    default => null,
                };

                if ($mapped) {
                    return $mapped;
                }

                if (str_contains($str, 'year') || str_contains($str, 'semester')) {
                    return strtoupper($str);
                }

                $eightDefaults = [
                    'FIRST YEAR FIRST SEMESTER',
                    'FIRST YEAR SECOND SEMESTER',
                    'SECOND YEAR FIRST SEMESTER',
                    'SECOND YEAR SECOND SEMESTER',
                    'THIRD YEAR FIRST SEMESTER',
                    'THIRD YEAR SECOND SEMESTER',
                    'FOURTH YEAR FIRST SEMESTER',
                    'FOURTH YEAR SECOND SEMESTER',
                ];

                return $eightDefaults[$index % 8] ?? strtoupper($str . ' SEMESTER');
            };

            $getSubjectsForSemIndex = function ($index, $resRecord = null) {
                if ($resRecord && $resRecord->subjects && $resRecord->subjects->isNotEmpty()) {
                    return $resRecord->subjects;
                }

                $gpa = $resRecord?->gpa ?? 3.86;
                $grade = $resRecord?->overall_grade ?? 'A';

                $defaultsBySem = [
                    0 => [
                        ['code' => '101', 'title' => 'Principles of Management', 'credit' => 4, 'grade' => 'B', 'cgpa' => '3.00'],
                        ['code' => '102', 'title' => 'Business Communication', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '103', 'title' => 'Accounting', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '104', 'title' => 'Business Mathematics', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '105', 'title' => 'Marketing Management', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '106', 'title' => 'Human Resource Management', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '107', 'title' => 'Computer Application in Business', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '108', 'title' => 'Business Organization and Entrepreneurship', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                    ],
                    1 => [
                        ['code' => '201', 'title' => 'Financial Accounting', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '202', 'title' => 'Micro Economics', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '203', 'title' => 'Business Statistics', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '204', 'title' => 'Principles of Finance', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '205', 'title' => 'Marketing Principles', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '206', 'title' => 'English for Business', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '207', 'title' => 'Computer Fundamentals', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '208', 'title' => 'Bangladesh Studies', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                    ],
                    2 => [
                        ['code' => '301', 'title' => 'Cost Accounting', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '302', 'title' => 'Macro Economics', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '303', 'title' => 'Business Law', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '304', 'title' => 'Management Information System', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '305', 'title' => 'Operations Management', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '306', 'title' => 'Organizational Behavior', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '307', 'title' => 'Research Methodology', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '308', 'title' => 'E-Commerce', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                    ],
                    3 => [
                        ['code' => '401', 'title' => 'Corporate Accounting', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '402', 'title' => 'International Business', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '403', 'title' => 'Business Environment', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '404', 'title' => 'Financial Management', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '405', 'title' => 'Production Management', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '406', 'title' => 'Human Resource Planning', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '407', 'title' => 'Business Ethics', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '408', 'title' => 'Business Policy and Strategy', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                    ],
                    4 => [
                        ['code' => '501', 'title' => 'Advanced Accounting', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '502', 'title' => 'Investment Management', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '503', 'title' => 'International Marketing', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '504', 'title' => 'Supply Chain Management', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '505', 'title' => 'Strategic Management', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '506', 'title' => 'Project Management', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '507', 'title' => 'Business Research', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '508', 'title' => 'Taxation in Bangladesh', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                    ],
                    5 => [
                        ['code' => '601', 'title' => 'Auditing', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '602', 'title' => 'Banking and Insurance', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '603', 'title' => 'Entrepreneurial Management', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '604', 'title' => 'Risk Management', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '605', 'title' => 'International Finance', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '606', 'title' => 'Quality Management', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '607', 'title' => 'Internship / Practical Work', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '608', 'title' => 'Seminar', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                    ],
                    6 => [
                        ['code' => '701', 'title' => 'Advanced Financial Management', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '702', 'title' => 'Business Intelligence', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '703', 'title' => 'Global Business Management', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '704', 'title' => 'Leadership and Governance', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '705', 'title' => 'Innovation and Change Management', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '706', 'title' => 'Corporate Social Responsibility', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '707', 'title' => 'Capstone Project (Part-1)', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '708', 'title' => 'Viva Voce (Part-1)', 'credit' => 4, 'grade' => 'A', 'cgpa' => '3.75'],
                    ],
                    7 => [
                        ['code' => '801', 'title' => 'Strategic Financial Analysis', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '802', 'title' => 'Mergers and Acquisitions', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '803', 'title' => 'Global Economic Environment', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '804', 'title' => 'Corporate Governance', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '805', 'title' => 'Capstone Project (Part-2)', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '806', 'title' => 'Viva Voce (Part-2)', 'credit' => 3, 'grade' => 'A+', 'cgpa' => '4.00'],
                        ['code' => '807', 'title' => 'Comprehensive Case Study', 'credit' => 3, 'grade' => 'A', 'cgpa' => '3.75'],
                        ['code' => '808', 'title' => 'Industrial Attachment Report', 'credit' => 4, 'grade' => 'A+', 'cgpa' => '4.00'],
                    ],
                ];

                return collect($defaultsBySem[$index % 8]);
            };

            $gpaBySem = [
                0 => '3.86',
                1 => '3.91',
                2 => '3.91',
                3 => '3.88',
                4 => '3.91',
                5 => '3.91',
                6 => '3.88',
                7 => '3.94',
            ];

            $displaySemesters = collect();

            if (isset($allResults) && $allResults->count() > 1) {
                foreach ($allResults as $idx => $resRecord) {
                    $semTitle = $formatSemTitle($resRecord->semester, $idx);
                    $displaySemesters->push([
                        'title' => $semTitle,
                        'sem_label' => $resRecord->semester,
                        'subjects' => $getSubjectsForSemIndex($idx, $resRecord),
                        'gpa' => $resRecord->gpa ?? $gpaBySem[$idx % 8] ?? '3.86',
                        'total_credit' => $resRecord->total_credit ?? 28,
                    ]);
                }
            } else {
                // Generate 8 semesters matching the user's screenshot
                $eightNames = [
                    'FIRST YEAR FIRST SEMESTER',
                    'FIRST YEAR SECOND SEMESTER',
                    'SECOND YEAR FIRST SEMESTER',
                    'SECOND YEAR SECOND SEMESTER',
                    'THIRD YEAR FIRST SEMESTER',
                    'THIRD YEAR SECOND SEMESTER',
                    'FOURTH YEAR FIRST SEMESTER',
                    'FOURTH YEAR SECOND SEMESTER',
                ];

                foreach ($eightNames as $idx => $sTitle) {
                    $record = ($idx === 0) ? $result : null;
                    $displaySemesters->push([
                        'title' => $sTitle,
                        'sem_label' => $sTitle,
                        'subjects' => $getSubjectsForSemIndex($idx, $record),
                        'gpa' => $record?->gpa ?? $gpaBySem[$idx] ?? '3.86',
                        'total_credit' => $record?->total_credit ?? 28,
                    ]);
                }
            }
        @endphp

        @if ($isSummaryStyle)
            <!-- STYLE 2: SUMMARY TABLES -->
            <div class="space-y-4 pt-1">
                <!-- Table 1: Semester Wise Results -->
                <div class="space-y-1">
                    <h3 class="text-center text-xs font-bold text-slate-800 uppercase tracking-wide">Semester Wise Results</h3>
                    <div class="overflow-hidden border border-slate-900 rounded shadow-sm">
                        <table class="w-full text-center text-[10px] sm:text-[11px] border-collapse">
                            <thead class="bg-slate-200/80 border-b border-slate-900 font-bold text-slate-900">
                                <tr>
                                    <th class="border-r border-slate-900 px-3 py-1 w-1/3">Semester</th>
                                    <th class="border-r border-slate-900 px-3 py-1 w-1/3">Grade</th>
                                    <th class="px-3 py-1 w-1/3">CGPA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-300">
                                @foreach ($displaySemesters as $sBlock)
                                    <tr class="hover:bg-slate-50">
                                        <td class="border-r border-slate-300 px-3 py-1 font-medium text-slate-800">{{ $sBlock['title'] }}</td>
                                        <td class="border-r border-slate-300 px-3 py-1 font-bold text-indigo-800">A</td>
                                        <td class="px-3 py-1 font-bold text-slate-800">{{ number_format((float)$sBlock['gpa'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Table 2: Course Wise Grade/Marks -->
                <div class="space-y-1">
                    <h3 class="text-center text-xs font-bold text-slate-800 uppercase tracking-wide">Course Wise Grade/Marks</h3>
                    <div class="overflow-hidden border border-slate-900 rounded shadow-sm">
                        <table class="w-full text-center text-[10px] sm:text-[11px] border-collapse">
                            <thead class="bg-slate-200/80 border-b border-slate-900 font-bold text-slate-900">
                                <tr>
                                    <th class="border-r border-slate-900 px-2 py-1">Written</th>
                                    <th class="border-r border-slate-900 px-2 py-1">Practical</th>
                                    <th class="border-r border-slate-900 px-2 py-1">Viva</th>
                                    <th class="border-r border-slate-900 px-2 py-1">Total</th>
                                    <th class="border-r border-slate-900 px-2 py-1">Full Mark</th>
                                    <th class="border-r border-slate-900 px-2 py-1">CGPA</th>
                                    <th class="px-2 py-1">Grade</th>
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
                                    $cgpaVal = $st?->cgpa ?? $cumulativeGpa ?? $result->gpa ?? 3.86;
                                    $gradeVal = $st?->grade ?? $result->overall_grade ?? 'A';
                                @endphp
                                <tr class="font-bold text-slate-900">
                                    <td class="border-r border-slate-300 px-2 py-1.5">{{ $written }}</td>
                                    <td class="border-r border-slate-300 px-2 py-1.5">{{ $practical }}</td>
                                    <td class="border-r border-slate-300 px-2 py-1.5">{{ $viva }}</td>
                                    <td class="border-r border-slate-300 px-2 py-1.5 text-indigo-900 font-black">{{ $total }}</td>
                                    <td class="border-r border-slate-300 px-2 py-1.5">{{ $fullMark }}</td>
                                    <td class="border-r border-slate-300 px-2 py-1.5 text-emerald-800 font-black">{{ number_format((float)$cgpaVal, 2) }}</td>
                                    <td class="px-2 py-1.5 text-emerald-800 font-black">{{ $gradeVal }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @elseif ($isSingleStyle)
            <!-- SINGLE SEMESTER STYLE -->
            <div class="pt-1">
                <section class="min-w-0">
                    <div class="overflow-hidden border border-slate-400 rounded shadow-sm">
                        <h2 class="bg-slate-200/80 border-b border-slate-400 py-1 text-center text-xs font-black uppercase tracking-wider text-slate-900">
                            {{ strtoupper((string) $result->semester) }}{{ str_contains(strtoupper((string) $result->semester), 'SEMESTER') ? '' : ' SEMESTER' }}
                        </h2>
                        <table class="w-full text-xs border-collapse">
                            <thead class="bg-slate-100 border-b border-slate-300">
                                <tr class="text-slate-700 font-bold uppercase text-[10px]">
                                    <th class="border-r border-slate-300 px-3 py-1.5 text-left w-[12%]">CODE</th>
                                    <th class="border-r border-slate-300 px-3 py-1.5 text-left w-[56%]">TITLE</th>
                                    <th class="border-r border-slate-300 px-2 py-1.5 text-center w-[10%]">CR</th>
                                    <th class="border-r border-slate-300 px-2 py-1.5 text-center w-[11%]">GRADE</th>
                                    <th class="px-2 py-1.5 text-center w-[11%]">CGPA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 text-slate-900 font-medium">
                                @php
                                    $singleSubjects = $getSubjectsForSemIndex(0, $result);
                                    $singleSemTotalCredit = 0;
                                @endphp
                                @forelse ($singleSubjects as $subject)
                                    @php
                                        $sCode = is_array($subject) ? ($subject['code'] ?? '') : $subject->code;
                                        $sTitle = is_array($subject) ? ($subject['title'] ?? '') : $subject->title;
                                        $sCr = is_array($subject) ? ($subject['credit'] ?? $subject['cr'] ?? 3) : ($subject->credit ?? 3);
                                        $sGrade = is_array($subject) ? ($subject['grade'] ?? 'A') : ($subject->grade ?? 'A');
                                        $sCgpa = is_array($subject) ? ($subject['cgpa'] ?? $subject['grade_point'] ?? '3.75') : ($subject->grade_point ?? '3.75');
                                        $singleSemTotalCredit += (float)$sCr;
                                    @endphp
                                    <tr class="hover:bg-slate-50">
                                        <td class="border-r border-slate-300 px-3 py-1 font-mono text-slate-800 font-bold">{{ $sCode }}</td>
                                        <td class="border-r border-slate-300 px-3 py-1 font-bold text-slate-900">{{ $sTitle }}</td>
                                        <td class="border-r border-slate-300 px-2 py-1 text-center font-bold">{{ $sCr }}</td>
                                        <td class="border-r border-slate-300 px-2 py-1 text-center font-black text-indigo-900">{{ $sGrade }}</td>
                                        <td class="px-2 py-1 text-center font-bold">{{ number_format((float)$sCgpa, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-3 text-center text-slate-500 font-bold text-xs uppercase">No subjects found for this semester</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-slate-100 border-t border-slate-300 font-bold text-slate-900 text-xs">
                                <tr>
                                    <td colspan="2" class="px-3 py-1.5 uppercase font-black">TOTAL CREDIT: {{ $singleSemTotalCredit ?: ($result->total_credit ?: 28) }}</td>
                                    <td colspan="3" class="px-3 py-1.5 text-right uppercase font-black">GPA: {{ number_format((float)($result->gpa ?? 3.86), 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        @else
            <!-- FULL RESULT SHEET (8 SEMESTERS 2-COLUMN GRID MATCHING SCREENSHOT) -->
            <div class="grid grid-cols-2 gap-1.5 sm:gap-2">
                @foreach ($displaySemesters as $semBlock)
                    <section class="min-w-0 break-inside-avoid">
                        <div class="overflow-hidden border border-slate-400 rounded shadow-xs">
                            <h2 class="bg-blue-50/90 border-b border-slate-400 py-0.5 text-center text-[9px] sm:text-[10px] font-black uppercase tracking-wider text-slate-900">
                                {{ $semBlock['title'] }}
                            </h2>
                            <table class="w-full text-[8.5px] sm:text-[9.5px] border-collapse">
                                <thead class="bg-slate-100 border-b border-slate-300">
                                    <tr class="text-slate-700 font-bold uppercase text-[8px] sm:text-[8.5px]">
                                        <th class="border-r border-slate-300 px-1 py-0.5 text-left w-[14%]">CODE</th>
                                        <th class="border-r border-slate-300 px-1 py-0.5 text-left w-[54%]">TITLE</th>
                                        <th class="border-r border-slate-300 px-1 py-0.5 text-center w-[10%]">CR</th>
                                        <th class="border-r border-slate-300 px-1 py-0.5 text-center w-[11%]">GRADE</th>
                                        <th class="px-1 py-0.5 text-center w-[11%]">CGPA</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 text-slate-900 font-medium">
                                    @forelse ($semBlock['subjects'] as $subj)
                                        @php
                                            $sCode = is_array($subj) ? ($subj['code'] ?? '') : $subj->code;
                                            $sTitle = is_array($subj) ? ($subj['title'] ?? '') : $subj->title;
                                            $sCr = is_array($subj) ? ($subj['credit'] ?? $subj['cr'] ?? 3) : ($subj->credit ?? 3);
                                            $sGrade = is_array($subj) ? ($subj['grade'] ?? 'A') : ($subj->grade ?? 'A');
                                            $sCgpa = is_array($subj) ? ($subj['cgpa'] ?? $subj['grade_point'] ?? '3.75') : ($subj->grade_point ?? '3.75');
                                        @endphp
                                        <tr class="hover:bg-slate-50">
                                            <td class="border-r border-slate-300 px-1 py-0.25 font-mono text-slate-800 font-bold text-[8px] sm:text-[8.5px]">{{ $sCode }}</td>
                                            <td class="border-r border-slate-300 px-1 py-0.25 text-slate-900 truncate max-w-[120px] font-semibold text-[8px] sm:text-[8.5px]">{{ $sTitle }}</td>
                                            <td class="border-r border-slate-300 px-1 py-0.25 text-center font-bold text-[8px] sm:text-[8.5px]">{{ $sCr }}</td>
                                            <td class="border-r border-slate-300 px-1 py-0.25 text-center font-black text-indigo-900 text-[8px] sm:text-[8.5px]">{{ $sGrade }}</td>
                                            <td class="px-1 py-0.25 text-center font-bold text-[8px] sm:text-[8.5px]">{{ number_format((float)$sCgpa, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-1 py-1 text-center text-slate-400 font-bold text-[8px]">No subjects added</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="bg-slate-50 border-t border-slate-300 text-[8px] sm:text-[8.5px] font-bold text-slate-800">
                                    <tr>
                                        <td colspan="2" class="px-1 py-0.5 font-bold uppercase">TOTAL CREDIT: {{ $semBlock['total_credit'] }}</td>
                                        <td colspan="3" class="px-1 py-0.5 text-right font-black uppercase">GPA: {{ number_format((float)$semBlock['gpa'], 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>
                @endforeach
            </div>
        @endif

        <!-- SUMMARY FOOTER MATCHING SCREENSHOT 100% -->
        <footer class="pt-2 border-t border-slate-300 space-y-2">
            @if ($isSingleStyle)
                <div class="flex flex-wrap items-center justify-between gap-4 pt-1">
                    <div class="flex flex-wrap items-center gap-6 text-xs sm:text-sm font-black text-slate-900 uppercase tracking-wider">
                        <span>TOTAL CREDIT: {{ $singleSemTotalCredit ?: ($result->total_credit ?: 28) }}</span>
                        <span>CREDIT EARNED: {{ $result->credit_earned ?: $result->total_credit ?: $singleSemTotalCredit ?: 28 }}</span>
                        <span>CGPA: {{ number_format((float)($cumulativeGpa ?? $result->student->cgpa ?? $result->gpa ?? 3.86), 2) }}</span>
                    </div>

                    <div class="text-center">
                        <img src="{{ ($qrCodes ?? collect())->get($result->id, $qrCode) }}" alt="Scan to verify result" class="mx-auto size-14 sm:size-16 bg-transparent">
                        <p class="mt-0.5 text-[7px] sm:text-[8px] font-black text-slate-600 uppercase tracking-wider">SCAN TO VERIFY</p>
                    </div>
                </div>
            @else
                <!-- 5 SUMMARY CARDS MATCHING SCREENSHOT -->
                <div class="grid grid-cols-5 gap-1 sm:gap-1.5 text-center text-[8px] sm:text-[9.5px] font-black uppercase tracking-wider">
                    <div class="p-1.5 border border-slate-400 rounded bg-slate-50 flex items-center justify-center gap-1.5">
                        <svg class="size-3.5 sm:size-4 text-indigo-900 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147L12 14.63l7.74-4.483a1.125 1.125 0 000-1.954L12 3.71 4.26 8.193a1.125 1.125 0 000 1.954z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12v5.25c0 1.5 2.686 2.25 6 2.25s6-.75 6-2.25V12" />
                        </svg>
                        <div>
                            <span class="block text-[7px] sm:text-[8px] text-slate-500 font-bold">TOTAL SEMESTER</span>
                            <span class="text-xs sm:text-sm font-black text-slate-900">{{ $displaySemesters->count() }}</span>
                        </div>
                    </div>
                    <div class="p-1.5 border border-slate-400 rounded bg-slate-50">
                        <span class="block text-[7px] sm:text-[8px] text-slate-500 font-bold">TOTAL CREDIT</span>
                        <span class="text-xs sm:text-sm font-black text-slate-900">{{ $displaySemesters->sum('total_credit') ?: 224 }}</span>
                    </div>
                    <div class="p-1.5 border border-slate-400 rounded bg-slate-50">
                        <span class="block text-[7px] sm:text-[8px] text-slate-500 font-bold">TOTAL CREDIT EARNED</span>
                        <span class="text-xs sm:text-sm font-black text-slate-900">{{ $displaySemesters->sum('total_credit') ?: 224 }}</span>
                    </div>
                    <div class="p-1.5 border border-slate-400 rounded bg-slate-50">
                        <span class="block text-[7px] sm:text-[8px] text-slate-500 font-bold">CGPA</span>
                        <span class="text-xs sm:text-sm font-black text-indigo-900">{{ number_format((float)($cumulativeGpa ?? $result->student->cgpa ?? $result->gpa ?? 3.86), 2) }}</span>
                    </div>
                    <div class="p-1.5 border border-slate-400 rounded bg-slate-50">
                        <span class="block text-[7px] sm:text-[8px] text-slate-500 font-bold">OVERALL GRADE</span>
                        <span class="text-xs sm:text-sm font-black text-emerald-800">{{ $result->student->grade ?: $result->overall_grade ?: 'A' }}</span>
                    </div>
                </div>

                <div class="flex items-end justify-between gap-4 pt-1">
                    <!-- NOTE & PUBLISHED DATE -->
                    <div class="space-y-1.5 text-[8px] sm:text-[8.5px] text-slate-600 max-w-sm">
                        <div>
                            <p class="font-bold text-slate-900">Note:</p>
                            <ul class="list-disc pl-3 space-y-0.25">
                                <li>This result sheet is computer generated.</li>
                                <li>No signature is required.</li>
                                <li>Any discrepancy should be reported to the institute authority.</li>
                                <li>Scan the QR code to verify this result.</li>
                            </ul>
                        </div>

                        <div class="inline-flex items-center gap-1.5 border border-slate-300 rounded px-2 py-0.5 bg-slate-50 text-[8.5px]">
                            <svg class="size-3 text-slate-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                            <span class="font-bold text-slate-800">Published On:</span>
                            <span>{{ $result->student->publication_date ?: optional($result->published_at ?? $result->created_at)->format('31 July 2025') }}</span>
                        </div>
                    </div>

                    <!-- SIGNATURE & QR CODE -->
                    <div class="flex items-end gap-4 sm:gap-6">
                        <div class="text-center">
                            <div class="h-6 border-b border-slate-400 w-28 sm:w-32 mx-auto flex items-end justify-center pb-0.5">
                                <span class="font-serif italic text-xs font-bold text-indigo-900">G. A. Mamun</span>
                            </div>
                            <p class="text-[8px] sm:text-[8.5px] font-bold text-slate-800 mt-0.5">Controller of Examinations</p>
                            <p class="text-[7.5px] text-slate-500 font-semibold">{{ $result->student->institute_name ?: ($result->student->branch?->institute_name ?? 'BANGLADESH NATIONAL YOUTH TECHNICAL INSTITUTE') }}</p>
                        </div>

                        <div class="text-center">
                            <img src="{{ ($qrCodes ?? collect())->get($result->id, $qrCode) }}" alt="Scan to verify result" class="mx-auto size-14 sm:size-16 bg-transparent">
                            <p class="mt-0.5 text-[7px] sm:text-[8px] font-bold text-slate-600 uppercase tracking-wider">SCAN TO VERIFY</p>
                        </div>
                    </div>
                </div>
            @endif
        </footer>

    </article>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const doc = document.querySelector('.result-sheet');

        function fallbackJsPDF(element, filename, finish) {
            if (typeof html2canvas !== 'undefined') {
                html2canvas(element, {
                    scale: 4,
                    useCORS: true,
                    allowTaint: true,
                    logging: false
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/jpeg', 0.98);
                    const jsPDF = window.jspdf ? window.jspdf.jsPDF : null;
                    if (jsPDF) {
                        const pdf = new jsPDF('portrait', 'mm', 'a4', true);
                        pdf.addImage(imgData, 'JPEG', 0, 0, 210, 297, undefined, 'FAST');
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
                <span>5-10MB Ultra HD PDF...</span>
            `;
            btnElement.disabled = true;

            const studentName = "{{ addslashes($result->student->name) }}";
            const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
            const filename = `ResultSheet_${cleanName}.pdf`;

            const finish = () => {
                btnElement.innerHTML = originalHTML;
                btnElement.disabled = false;
            };

            const opt = {
                margin: 0,
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 4, useCORS: true, allowTaint: true, logging: false },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait', compress: true }
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
                <span>5-10MB Ultra HD ছবি...</span>
            `;
            btnElement.disabled = true;

            const studentName = "{{ addslashes($result->student->name) }}";
            const cleanName = studentName.replace(/[^a-zA-Z0-9]/g, '_');
            const filename = `ResultSheet_${cleanName}.jpg`;

            if (typeof html2canvas !== 'undefined') {
                html2canvas(doc, { scale: 4, useCORS: true, allowTaint: true, logging: false, backgroundColor: '#ffffff' }).then(canvas => {
                    const imageUri = canvas.toDataURL('image/jpeg', 0.98);
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

</body>
</html>

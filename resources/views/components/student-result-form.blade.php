@props(['student' => null, 'result' => null, 'semesters' => collect(), 'action', 'method' => 'POST', 'submitLabel'])

@php
    $studentObj = $result?->student ?? $student;
    $selectedSemesterId = old('semester_id', $result?->semester_id ?? $semesters->first()?->id);
    $selectedSemester = $semesters->firstWhere('id', (int) $selectedSemesterId);

    $existingSubjects = $result?->subjects?->values();

    if ($existingSubjects && $existingSubjects->isNotEmpty()) {
        $subjects = $existingSubjects;
    } else {
        $configured = $selectedSemester?->subjects?->where('is_active', true)->values();

        if ($configured && $configured->isNotEmpty()) {
            $subjects = $configured;
        } else {
            $semName = strtolower($result?->semester ?? '1st Semester');
            $gpaVal = $result?->gpa ?? $studentObj?->cgpa ?? 3.75;
            $gradeVal = $result?->overall_grade ?? $studentObj?->grade ?? 'A';

            if (str_contains($semName, '2nd') || str_contains($semName, 'second')) {
                $defaultList = [
                    ['code' => '2011', 'title' => 'Object Oriented Programming', 'credit' => 2, 'marks' => 80, 'grade' => 'A', 'grade_point' => 3.75],
                    ['code' => '2012', 'title' => 'Data Structures & Algorithms', 'credit' => 2, 'marks' => 85, 'grade' => 'A+', 'grade_point' => 4.00],
                    ['code' => '2013', 'title' => 'Digital Logic Design', 'credit' => 2, 'marks' => 80, 'grade' => 'A', 'grade_point' => 3.75],
                    ['code' => '2014', 'title' => 'Computer Architecture', 'credit' => 2, 'marks' => 85, 'grade' => 'A+', 'grade_point' => 4.00],
                    ['code' => '2015', 'title' => 'Discrete Mathematics', 'credit' => 2, 'marks' => 75, 'grade' => 'A-', 'grade_point' => 3.50],
                    ['code' => '2016', 'title' => 'Software Engineering', 'credit' => 2, 'marks' => 80, 'grade' => 'A', 'grade_point' => 3.75],
                    ['code' => '2017', 'title' => 'Technical Communication', 'credit' => 2, 'marks' => 75, 'grade' => 'A-', 'grade_point' => 3.50],
                ];
            } else {
                $defaultList = [
                    ['code' => '1011', 'title' => 'Programming Fundamentals', 'credit' => 2, 'marks' => 80, 'grade' => 'A', 'grade_point' => 3.75],
                    ['code' => '5712', 'title' => 'Computer Hardware', 'credit' => 2, 'marks' => 85, 'grade' => 'A+', 'grade_point' => 4.00],
                    ['code' => '5911', 'title' => 'Database Systems', 'credit' => 2, 'marks' => 80, 'grade' => 'A', 'grade_point' => 3.75],
                    ['code' => '6013', 'title' => 'Web Development', 'credit' => 2, 'marks' => 85, 'grade' => 'A+', 'grade_point' => 4.00],
                    ['code' => '6612', 'title' => 'Operating Systems', 'credit' => 2, 'marks' => 75, 'grade' => 'A-', 'grade_point' => 3.50],
                    ['code' => '6710', 'title' => 'Data Communication', 'credit' => 2, 'marks' => 80, 'grade' => 'A', 'grade_point' => 3.75],
                    ['code' => '6711', 'title' => 'Mathematics for Computing', 'credit' => 2, 'marks' => 75, 'grade' => 'A-', 'grade_point' => 3.50],
                ];
            }

            $subjects = collect($defaultList)->map(fn($item) => (object) $item);
        }
    }

    $inputClass = 'w-full rounded-xl border border-slate-300 bg-white text-slate-900 px-3 py-2.5 text-sm outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100';
    $semesterSubjects = $semesters->mapWithKeys(fn ($semester): array => [$semester->id => $semester->subjects->where('is_active', true)->values()->map(fn ($subject): array => ['code' => $subject->code, 'title' => $subject->title, 'credit' => $subject->credit])->all()])->all();

    $allDynamicSuggestions = \App\Models\Subject::query()
        ->where('is_active', true)
        ->get(['code', 'title', 'credit'])
        ->unique('title')
        ->values();
@endphp

<datalist id="global-subject-suggestions">
    @foreach ($allDynamicSuggestions as $s)
        <option value="{{ $s->title }}" data-code="{{ $s->code }}" data-credit="{{ $s->credit }}">{{ $s->code }} - {{ $s->title }} ({{ $s->credit }} Cr)</option>
    @endforeach
</datalist>

<form method="POST" action="{{ $action }}" data-result-form data-semester-subjects="{{ json_encode($semesterSubjects) }}" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    @if ($studentObj)<input type="hidden" name="student_id" value="{{ $studentObj->id }}">@endif
    <div class="grid gap-5 md:grid-cols-3">
        <label class="grid gap-2 text-sm font-bold text-slate-700 md:col-span-2">
            Semester
            <select name="semester_id" data-result-semester class="{{ $inputClass }} bg-white">
                <option value="">Manual / legacy result</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}" @selected((int) $selectedSemesterId === $semester->id)>{{ $semester->name }}</option>
                @endforeach
            </select>
            @error('semester_id')<span class="text-rose-600">{{ $message }}</span>@enderror
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">
            Session
            <input name="session" required value="{{ old('session', $result?->session ?? $studentObj?->session ?? now()->year) }}" class="{{ $inputClass }}">
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700">
            Publication Status (পাবলিশ / হাইড)
            <select name="status" required class="{{ $inputClass }} bg-white font-bold">
                <option value="published" @selected(old('status', $result?->status ?? 'published') === 'published') class="text-emerald-700 font-bold">
                    🌐 Published (প্রকাশিত - পাবলিকলি দেখাবে)
                </option>
                <option value="draft" @selected(old('status', $result?->status) === 'draft') class="text-amber-700 font-bold">
                    🔒 Hide / Draft (লুকানো/ড্রাফট - পাবলিকলি দেখাবে না)
                </option>
            </select>
        </label>
        <label class="grid gap-2 text-sm font-bold text-slate-700 md:col-span-3">
            Semester Title / Label
            <input name="semester" value="{{ old('semester', $result?->semester ?? '1st Semester') }}" class="{{ $inputClass }}">
        </label>
    </div>
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-lg font-black text-slate-950">Subject Results</h2>
            <p class="text-sm text-slate-500">Configured code, title, and credit are preloaded. Enter marks and grade points for each subject.</p>
        </div>
        <button type="button" data-add-result-subject class="rounded-full bg-blue-50 px-4 py-2 text-sm font-black text-blue-700 hover:bg-blue-100 transition">
            + Add Subject
        </button>
    </div>
    <div class="overflow-x-auto rounded-xl border border-slate-200">
        <table class="w-full min-w-[900px] text-left text-sm">
            <thead class="bg-slate-50 text-xs font-black uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-3 py-3">Code</th>
                    <th class="px-3 py-3">Title</th>
                    <th class="px-3 py-3">Credit</th>
                    <th class="px-3 py-3">Marks</th>
                    <th class="px-3 py-3">Grade</th>
                    <th class="px-3 py-3">Grade Point</th>
                    <th class="px-3 py-3"></th>
                </tr>
            </thead>
            <tbody data-result-subjects>
                @foreach ($subjects as $index => $subject)
                    <tr data-result-subject-row>
                        <td class="px-3 py-2"><input name="subjects[{{ $index }}][code]" required value="{{ old("subjects.$index.code", $subject?->code) }}" class="{{ $inputClass }}"></td>
                        <td class="px-3 py-2"><input name="subjects[{{ $index }}][title]" list="global-subject-suggestions" required value="{{ old("subjects.$index.title", $subject?->title) }}" class="{{ $inputClass }}"></td>
                        <td class="px-3 py-2"><input type="number" name="subjects[{{ $index }}][credit]" required min="0.5" max="20" step="0.5" value="{{ old("subjects.$index.credit", $subject?->credit ?? 2) }}" class="{{ $inputClass }}"></td>
                        <td class="px-3 py-2"><input type="number" name="subjects[{{ $index }}][marks]" min="0" max="100" step="0.01" value="{{ old("subjects.$index.marks", $subject?->marks ?? 80) }}" class="{{ $inputClass }}"></td>
                        <td class="px-3 py-2"><input name="subjects[{{ $index }}][grade]" required value="{{ old("subjects.$index.grade", $subject?->grade ?? 'A') }}" class="{{ $inputClass }}"></td>
                        <td class="px-3 py-2"><input type="number" name="subjects[{{ $index }}][grade_point]" required min="0" max="4" step="0.01" value="{{ old("subjects.$index.grade_point", $subject?->grade_point ?? 3.75) }}" class="{{ $inputClass }}"></td>
                        <td class="px-3 py-2 text-right"><button type="button" data-remove-result-subject class="font-black text-rose-600 hover:text-rose-800">Remove</button></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-end gap-3">
        <a href="{{ $studentObj ? route('super-admin.students.results.index', $studentObj) : route('super-admin.students.index') }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700 hover:bg-slate-50 transition">
            Cancel
        </a>
        <button class="rounded-full bg-blue-600 hover:bg-blue-700 px-6 py-3 font-black text-white shadow-lg transition">
            {{ $submitLabel }}
        </button>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('[data-result-form]');
        if (form) {
            form.addEventListener('input', (e) => {
                if (e.target.matches('input[name*="[title]"]')) {
                    const val = e.target.value;
                    const datalist = document.getElementById('global-subject-suggestions');
                    if (datalist && val) {
                        const option = Array.from(datalist.options).find(o => o.value.toLowerCase() === val.toLowerCase());
                        if (option) {
                            const tr = e.target.closest('tr');
                            if (tr) {
                                const codeInput = tr.querySelector('input[name*="[code]"]');
                                const creditInput = tr.querySelector('input[name*="[credit]"]');
                                if (codeInput && option.dataset.code) codeInput.value = option.dataset.code;
                                if (creditInput && option.dataset.credit) creditInput.value = option.dataset.credit;
                            }
                        }
                    }
                }
            });
        }
    });
</script>

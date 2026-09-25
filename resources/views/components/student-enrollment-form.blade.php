@props(['student', 'semesters', 'enrollment' => null, 'action', 'method' => 'POST'])
<form method="POST" action="{{ $action }}" class="space-y-6 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" data-semester-form>
    @csrf @if ($method !== 'POST') @method($method) @endif
    @if (! $enrollment)<label class="grid gap-2 text-sm font-bold text-slate-700">Semester<select name="semester_id" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5" data-semester-select><option value="">Select semester</option>@foreach ($semesters as $semester)<option value="{{ $semester->id }}">{{ $semester->name }}</option>@endforeach</select></label>@endif
    <div><h2 class="text-lg font-black">Assigned subjects</h2><p class="mt-1 text-sm text-slate-500">All active subjects are selected by default. Remove optional subjects if needed.</p><div class="mt-4 grid gap-3 sm:grid-cols-2" data-subject-list>@foreach ($semesters as $semester) @foreach ($semester->subjects as $subject)<label data-semester-id="{{ $semester->id }}" class="flex items-start gap-3 rounded-xl border border-slate-200 p-4"><input type="checkbox" name="subjects[]" value="{{ $subject->id }}" @checked($enrollment ? $enrollment->subjects->contains('subject_id', $subject->id) : $loop->parent->first) class="mt-1 size-4"><span><strong class="block">{{ $subject->code }} · {{ $subject->title }}</strong><span class="text-sm text-slate-500">{{ $subject->credit }} credit</span></span></label>@endforeach @endforeach</div></div>
    <div class="flex gap-3"><a href="{{ route('super-admin.students.semester-enrollments.index', $student) }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Cancel</a><button class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white">{{ $enrollment ? 'Save subjects' : 'Assign semester' }}</button></div>
</form>
@if (! $enrollment)
<script>
    document.querySelector('[data-semester-select]').addEventListener('change', function () {
        document.querySelectorAll('[data-subject-list] [data-semester-id]').forEach(function (subject) {
            const visible = subject.dataset.semesterId === this.value;
            subject.hidden = ! visible;
            subject.querySelector('input').disabled = ! visible;
            if (visible) subject.querySelector('input').checked = true;
        }, this);
    });
    document.querySelector('[data-semester-select]').dispatchEvent(new Event('change'));
</script>
@endif

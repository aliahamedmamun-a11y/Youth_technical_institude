<x-dashboard-shell :title="$student->name.' Results'" eyebrow="Academic Management" description="Review, publish, edit, hide, and print this student’s results." :breadcrumbs="['Students' => route('super-admin.students.index'), $student->name => route('super-admin.students.show', $student), 'Results' => null]">
    <x-slot:actions><a href="{{ route('super-admin.students.results.create', $student) }}" class="admin-button admin-button--primary">Add result</a></x-slot:actions>
    <x-admin-filter-bar :status="$selectedStatus" :statuses="['published' => 'Published', 'draft' => 'Draft (Hidden)']" />
    <div class="grid gap-4">
        @forelse($results as $result)
            <article class="admin-panel">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-black text-slate-950">{{ $result->semester }}</h2>
                        <p class="mt-1 text-sm text-slate-500">Session {{ $result->session }} · {{ $result->subjects->count() }} subjects</p>
                    </div>
                    <x-admin-status :status="$result->status" />
                </div>
                <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    @foreach(['Total credit' => $result->total_credit, 'Credit earned' => $result->credit_earned, 'GPA' => $result->gpa ?? '—', 'Grade' => $result->overall_grade ?? '—'] as $label => $value)
                        <div>
                            <p class="text-xs font-black uppercase text-slate-500">{{ $label }}</p>
                            <p class="mt-1 font-black text-slate-900">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 flex flex-wrap items-center gap-2">
                    <a href="{{ route('super-admin.results.show', $result) }}" class="admin-button admin-button--primary">Preview and print</a>
                    <a href="{{ route('super-admin.results.edit', $result) }}" class="admin-button admin-button--secondary">Edit</a>

                    @if ($result->status === 'published')
                        <form method="POST" action="{{ route('super-admin.results.toggle-status', $result) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="draft">
                            <button class="admin-button bg-amber-500 text-slate-950 hover:bg-amber-400 font-black">Hide</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('super-admin.results.toggle-status', $result) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="published">
                            <button class="admin-button bg-emerald-600 text-white hover:bg-emerald-700 font-black">Publish</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('super-admin.results.destroy', $result) }}" data-confirm="Delete this result and its subject marks?" data-confirm-title="Delete result">
                        @csrf @method('DELETE')
                        <button class="admin-button admin-button--danger">Delete</button>
                    </form>
                </div>
            </article>
        @empty
            <div class="admin-panel">
                <x-admin-empty-state title="No results found" description="Add a result or clear the filter." action-label="Add result" :action-url="route('super-admin.students.results.create', $student)" />
            </div>
        @endforelse
    </div>
</x-dashboard-shell>

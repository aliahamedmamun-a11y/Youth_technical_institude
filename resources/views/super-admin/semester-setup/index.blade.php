<x-dashboard-shell title="Semester Setup" eyebrow="Academic" description="Choose a course to configure its semesters and subjects.">
    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($courses as $course)
            <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="mt-2 text-lg font-black text-slate-950">{{ $course->name }}</h2>
                <p class="mt-2 text-sm text-slate-500">{{ $course->semesters_count }} configured semesters</p>
                <a href="{{ route('super-admin.courses.semesters.index', $course) }}" class="mt-5 inline-flex rounded-full bg-blue-600 px-4 py-2.5 text-sm font-black text-white">Manage semesters</a>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-500 md:col-span-2 xl:col-span-3">Create a course first, then configure its semesters.</div>
        @endforelse
    </div>
</x-dashboard-shell>

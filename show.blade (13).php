<x-dashboard-shell :title="$course->name" eyebrow="Department details" :description="$course->description ?: 'No department description has been added.'">
    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
        @if ($course->image_path)
            <img src="{{ Storage::disk('public')->url($course->image_path) }}" alt="{{ $course->name }}" class="mb-8 h-56 w-full rounded-2xl object-cover sm:h-72">
        @endif
        <dl class="grid gap-6 sm:grid-cols-3">
            <div><dt class="text-xs font-black uppercase tracking-[0.14em] text-slate-500">Duration</dt><dd class="mt-2 text-lg font-black text-slate-950">{{ $course->duration }}</dd></div>
            <div><dt class="text-xs font-black uppercase tracking-[0.14em] text-slate-500">Availability</dt><dd class="mt-2 text-lg font-black {{ $course->is_active ? 'text-emerald-700' : 'text-slate-500' }}">{{ $course->is_active ? 'Active' : 'Inactive' }}</dd></div>
        </dl>
        <div class="mt-8 flex gap-3"><a href="{{ route('super-admin.courses.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-black text-slate-700">Back</a><a href="{{ route('super-admin.courses.edit', $course) }}" class="rounded-full bg-emerald-700 px-5 py-3 text-sm font-black text-white">Edit course</a></div>
    </article>
</x-dashboard-shell>

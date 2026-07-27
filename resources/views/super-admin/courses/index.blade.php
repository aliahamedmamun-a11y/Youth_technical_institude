<x-dashboard-shell title="Course Management" eyebrow="Academic management" description="Create and maintain the courses offered across the institute.">
    <div class="mb-6 flex justify-end">
        <a href="{{ route('super-admin.courses.create') }}" class="rounded-full bg-emerald-700 px-5 py-3 text-sm font-black text-white transition hover:bg-emerald-800">Add course</a>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 font-bold text-emerald-800" role="status">{{ session('status') }}</div>
    @endif

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-lg shadow-slate-900/5">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[720px] text-left">
                <thead class="border-b border-slate-200 bg-slate-50 text-xs font-black uppercase tracking-[0.14em] text-slate-500">
                    <tr><th class="px-6 py-4">Image</th><th class="px-6 py-4">Course</th><th class="px-6 py-4">Code</th><th class="px-6 py-4">Duration</th><th class="px-6 py-4">Status</th><th class="px-6 py-4 text-right">Actions</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($courses as $course)
                        <tr class="text-sm font-medium text-slate-700">
                            <td class="px-6 py-4">@if ($course->image_path)<img src="{{ Storage::disk('public')->url($course->image_path) }}" alt="{{ $course->name }}" class="size-12 rounded-xl object-cover">@else<span class="grid size-12 place-items-center rounded-xl bg-slate-100 text-xs font-black text-slate-400">No image</span>@endif</td>
                            <td class="px-6 py-4 font-black text-slate-950">{{ $course->name }}</td>
                            <td class="px-6 py-4">{{ $course->code }}</td>
                            <td class="px-6 py-4">{{ $course->duration }}</td>
                            <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-black {{ $course->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">{{ $course->is_active ? 'Active' : 'Inactive' }}</span></td>
                            <td class="px-6 py-4"><div class="flex justify-end gap-3"><a href="{{ route('super-admin.courses.show', $course) }}" class="font-black text-slate-600 hover:text-emerald-700">View</a><a href="{{ route('super-admin.courses.edit', $course) }}" class="font-black text-emerald-700 hover:text-emerald-900">Edit</a><form method="POST" action="{{ route('super-admin.courses.destroy', $course) }}">@csrf @method('DELETE') <button type="submit" class="font-black text-rose-700 hover:text-rose-900">Delete</button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-12 text-center font-medium text-slate-500">No courses have been created yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $courses->links() }}</div>
</x-dashboard-shell>

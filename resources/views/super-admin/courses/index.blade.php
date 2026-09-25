<x-dashboard-shell title="Remove Courses">
    <div class="mx-auto max-w-6xl">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
            {{-- Centered Header --}}
            <div class="mb-10 text-center">
                <h1 class="flex items-center justify-center gap-4 text-4xl font-black text-[#ff4d94] uppercase tracking-tight lg:text-5xl">
                    <svg viewBox="0 0 24 24" class="size-10 text-[#4da6ff]" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Remove Courses
                </h1>
            </div>

            {{-- Centered Search Bar --}}
            <div class="mx-auto mb-10 max-w-2xl">
                <form method="GET" class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search for a course..."
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                            <th class="px-6 py-4">Course Name</th>
                            <th class="px-6 py-4">Course ID</th>
                            <th class="px-6 py-4">Price</th>
                            <th class="px-6 py-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($courses as $course)
                            <tr class="group transition-colors hover:bg-white/5">
                                <td class="px-6 py-5 text-sm font-bold text-white">{{ $course->name }}</td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $course->course_id ?: '---' }}</td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                    <span class="text-[#4da6ff] mr-1">$</span>{{ $course->price ?: '0.00' }}
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-center gap-6">
                                        {{-- Edit Action --}}
                                        <a href="{{ route('super-admin.courses.edit', $course) }}" class="text-[#4da6ff] transition hover:scale-110 active:scale-95" title="Edit Course">
                                            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </a>

                                        {{-- Delete Action --}}
                                        <form action="{{ route('super-admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Delete this course?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[#ff4d94] transition hover:scale-110 active:scale-95" title="Remove Course">
                                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                    No courses found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($courses->hasPages())
                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard-shell>

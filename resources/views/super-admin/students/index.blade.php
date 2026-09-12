<x-dashboard-shell title="Student Information Table">
    <div class="mx-auto max-w-7xl">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">

            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black tracking-tight text-white uppercase">Student Information Table</h1>
            </div>

            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-6 py-4">Student Address</th>
                                <th class="px-6 py-4">District</th>
                                <th class="px-6 py-4">Thana</th>
                                <th class="px-6 py-4">Search Course</th>
                                <th class="px-6 py-4">Duration</th>
                                <th class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($students as $student)
                                <tr class="group transition-colors hover:bg-white/5">
                                    <td class="px-6 py-5 text-sm font-bold text-white">{{ $student->address }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->district }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->upazila }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->course?->name ?: 'N/A' }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->duration }}</td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-6">
                                            {{-- Admit Card (PDF Trigger) --}}
                                            <a href="{{ route('super-admin.students.documents.show', [$student, 'admit-card']) }}"
                                               onclick="downloadPdf(event, this.href)"
                                               class="text-blue-400 transition hover:scale-110 active:scale-95"
                                               title="Download Admit Card">
                                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                            </a>

                                            {{-- NID (PDF Trigger) --}}
                                            <a href="{{ route('super-admin.students.documents.show', [$student, 'registration-card']) }}"
                                               onclick="downloadPdf(event, this.href)"
                                               class="text-emerald-400 transition hover:scale-110 active:scale-95"
                                               title="Download NID/Registration">
                                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <rect width="18" height="12" x="3" y="6" rx="2" /><circle cx="9" cy="12" r="2" /><path d="M15 10h4M15 14h4" /></svg>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('super-admin.students.edit', $student) }}" class="text-[#ff4d94] transition hover:scale-110 active:scale-95" title="Edit Student">
                                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                        No student records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($students->hasPages())
                <div class="mt-8">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        function downloadPdf(event, url) {
            event.preventDefault();
            const win = window.open(url, '_blank');
            win.onload = function() {
                win.print();
            };
        }
    </script>
</x-dashboard-shell>

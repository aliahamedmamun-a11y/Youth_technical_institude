<x-dashboard-shell title="Student Information Table">
    <div class="mx-auto max-w-[1600px]">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">

            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black tracking-tight text-white uppercase lg:text-4xl">Student Information Table</h1>
            </div>

            {{-- Centered Search Bar --}}
            <div class="mx-auto mb-10 max-w-2xl">
                <form method="GET" class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search by Roll Number..."
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-6 py-4">DOB</th>
                                <th class="px-6 py-4">GENDER</th>
                                <th class="px-6 py-4">PASSPORT</th>
                                <th class="px-6 py-4">GUARDIAN PHONE</th>
                                <th class="px-6 py-4">STUDENT ADDRESS</th>
                                <th class="px-6 py-4">DISTRICT</th>
                                <th class="px-6 py-4">THANA</th>
                                <th class="px-6 py-4">SEARCH COURSE</th>
                                <th class="px-6 py-4">DURATION</th>
                                <th class="px-6 py-4">SESSION</th>
                                <th class="px-6 py-4">EDUCATION QUALIFICATION</th>
                                <th class="px-6 py-4">EXAMINATION MONTH</th>
                                <th class="px-6 py-4">PUBLICATION DATE</th>
                                <th class="px-6 py-4">TOTAL MARKS</th>
                                <th class="px-6 py-4">ID CARD</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($students as $student)
                                <tr class="group transition-colors hover:bg-white/5">
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->date_of_birth?->format('Y-m-d') }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->gender }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->passport_nid_number }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->phone }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-white">{{ $student->address }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->district }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->upazila }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->course?->name }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->duration }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->session }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->education_qualification }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->end_month }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->admitted_at?->format('d M Y') }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">{{ $student->score }}</td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'student-id']) }}" class="text-blue-400 hover:underline">View ID</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                        No student records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Custom Styled Pagination --}}
            <div class="mt-10 flex flex-col items-center justify-between gap-6 sm:flex-row">
                <div class="rounded-2xl bg-[#071c2c] px-6 py-4 shadow-xl">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">
                        Showing <span class="text-white">{{ $students->firstItem() }} to {{ $students->lastItem() }}</span>
                    </p>
                    <p class="mt-1 text-[9px] font-black text-blue-500 uppercase tracking-[0.2em]">Total: {{ $students->total() }}</p>
                </div>

                <div class="flex items-center gap-4">
                    <button class="rounded-xl bg-[#071c2c] px-6 py-3 text-xs font-black text-slate-400 shadow-lg">Page {{ $students->currentPage() }}</button>

                    <div class="flex items-center gap-2">
                        @if($students->onFirstPage())
                            <span class="grid size-10 place-items-center rounded-xl bg-[#071c2c] text-slate-700">«</span>
                        @else
                            <a href="{{ $students->previousPageUrl() }}" class="grid size-10 place-items-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20 hover:bg-blue-500 transition-all">«</a>
                        @endif

                        <div class="flex h-10 items-center rounded-xl bg-[#071c2c] px-6 text-sm font-black text-white ring-1 ring-white/10">
                            {{ $students->currentPage() }} / {{ $students->lastPage() }}
                        </div>

                        @if($students->hasMorePages())
                            <a href="{{ $students->nextPageUrl() }}" class="grid size-10 place-items-center rounded-xl bg-blue-600 text-white shadow-lg shadow-blue-900/20 hover:bg-blue-500 transition-all">»</a>
                        @else
                            <span class="grid size-10 place-items-center rounded-xl bg-[#071c2c] text-slate-700">»</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-shell>

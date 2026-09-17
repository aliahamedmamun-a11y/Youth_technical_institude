<x-dashboard-shell title="Student Information Table">
    <div class="mx-auto max-w-full px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-6 shadow-2xl backdrop-blur-sm lg:p-8">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-black tracking-tight text-white uppercase">Student Information Table</h1>
            </div>

            {{-- Search Bar --}}
            <div class="mx-auto mb-8 max-w-2xl">
                <form method="GET" class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search by Roll Number..."
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/60 py-3.5 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/40 shadow-inner">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[9px] font-black uppercase tracking-widest text-slate-400">
                                <th class="px-3 py-4">PICTURE</th>
                                <th class="px-3 py-4">ACTIONS</th>
                                <th class="px-3 py-4 text-center">ADMIT-CARD</th>
                                <th class="px-3 py-4 text-center">REGISTRATION</th>
                                <th class="px-3 py-4 text-center">CERTIFICATE</th>
                                <th class="px-3 py-4 text-center">TRANSCRIPT</th>
                                <th class="px-3 py-4 text-center">TRANSCRIPTONE</th>
                                <th class="px-3 py-4 text-center">TRANSCRIPTTWO</th>
                                <th class="px-3 py-4 text-center">NIDCARD</th>
                                <th class="px-3 py-4 text-center text-[#ff4d94]">CERT STATUS</th>
                                <th class="px-3 py-4 text-center">TRANS STATUS</th>
                                <th class="px-3 py-4 text-center">TRANS-ONE STATUS</th>
                                <th class="px-3 py-4 text-center">BRANCH PERM</th>
                                <th class="px-3 py-4 text-center">DELETE SCORE</th>
                                <th class="px-3 py-4">STUDENT ID</th>
                                <th class="px-3 py-4">STUDENT REGISTRATION NUMBER</th>
                                <th class="px-3 py-4">STUDENT ROLL NUMBER</th>
                                <th class="px-3 py-4">STUDENT NAME</th>
                                <th class="px-3 py-4">FATHER NAME</th>
                                <th class="px-3 py-4">MOTHER NAME</th>
                                <th class="px-3 py-4">DOB</th>
                                <th class="px-3 py-4">GENDER</th>
                                <th class="px-3 py-4">PASSPORT</th>
                                <th class="px-3 py-4">RELIGION</th>
                                <th class="px-3 py-4">GUARDIAN PHONE</th>
                                <th class="px-3 py-4">STUDENT ADDRESS</th>
                                <th class="px-3 py-4">DISTRICT</th>
                                <th class="px-3 py-4">THANA</th>
                                <th class="px-3 py-4">SEARCH COURSE</th>
                                <th class="px-3 py-4">DURATION</th>
                                <th class="px-3 py-4">SESSION</th>
                                <th class="px-3 py-4">EDUCATION QUALIFICATION</th>
                                <th class="px-3 py-4">INSTITUTE</th>
                                <th class="px-3 py-4">ISSUE DATE</th>
                                <th class="px-3 py-4">EXPIRE DATE</th>
                                <th class="px-3 py-4">DIRECTOR NAME</th>
                                <th class="px-3 py-4">CREATED AT</th>
                                <th class="px-3 py-4">EXAMINATION MONTH</th>
                                <th class="px-3 py-4">PUBLICATION DATE</th>
                                <th class="px-3 py-4">TOTAL MARKS</th>
                                <th class="px-3 py-4 text-center">ID CARD</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($students as $student)
                                <tr class="group transition-colors hover:bg-white/5 text-[10px] font-bold text-slate-400">
                                    {{-- PICTURE --}}
                                    <td class="px-3 py-4">
                                        <div class="size-10 overflow-hidden rounded-md border border-white/10 bg-slate-800 shadow-lg">
                                            @if($student->image_path)
                                                <img src="{{ Storage::disk('public')->url($student->image_path) }}" alt="{{ $student->name }}" class="size-full object-cover">
                                            @else
                                                <div class="flex size-full items-center justify-center text-[8px] text-slate-600">No Img</div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="px-3 py-4">
                                        <div class="flex items-center gap-2 text-[8px] font-black uppercase">
                                            <a href="{{ route('super-admin.students.edit', $student) }}" class="text-blue-500 hover:text-blue-400">EDIT</a>
                                            <form action="{{ route('super-admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Delete student record?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-500">DELETE</button>
                                            </form>
                                            <a href="{{ route('super-admin.students.show', $student) }}" class="text-emerald-500 hover:text-emerald-400">UPDATE</a>
                                        </div>
                                    </td>

                                    {{-- ADMIT-CARD --}}
                                    <td class="px-3 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'admit-card']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-md bg-[#ff0000] px-3 py-1.5 text-[9px] font-black text-white shadow-lg transition hover:bg-red-700">
                                            Admit-Card
                                        </a>
                                    </td>

                                    {{-- REGISTRATION --}}
                                    <td class="px-3 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'registration-card']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-md bg-[#007bff] px-3 py-1.5 text-[9px] font-black text-white shadow-lg transition hover:bg-blue-700">
                                            Registration Card
                                        </a>
                                    </td>

                                    {{-- CERTIFICATE --}}
                                    <td class="px-3 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'certificate']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-md bg-[#28a745] px-3 py-1.5 text-[9px] font-black text-white shadow-lg transition hover:bg-green-700">
                                            Certificate
                                        </a>
                                    </td>

                                    {{-- TRANSCRIPT --}}
                                    <td class="px-3 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'transcript']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-md bg-[#198754] px-3 py-1.5 text-[9px] font-black text-white shadow-lg transition hover:bg-green-800">
                                            Certificate One
                                        </a>
                                    </td>

                                    {{-- TRANSCRIPTONE --}}
                                    <td class="px-3 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'transcript']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-md bg-[#6c757d] px-3 py-1.5 text-[9px] font-black text-white shadow-lg transition hover:bg-slate-600">
                                            Transcript
                                        </a>
                                    </td>

                                    {{-- TRANSCRIPTTWO --}}
                                    <td class="px-3 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'transcript']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-md bg-[#17a2b8] px-3 py-1.5 text-[9px] font-black text-white shadow-lg transition hover:bg-cyan-700">
                                            TranscriptOne
                                        </a>
                                    </td>

                                    {{-- NIDCARD --}}
                                    <td class="px-3 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'registration-card']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-md bg-[#17a2b8] px-3 py-1.5 text-[9px] font-black text-white shadow-lg transition hover:bg-cyan-700">
                                            TranscriptTwo
                                        </a>
                                    </td>

                                    {{-- CERT STATUS (NIDCard) --}}
                                    <td class="px-3 py-4 text-center">
                                        <button class="inline-block rounded-md bg-[#a855f7] px-4 py-1.5 text-[9px] font-black text-white shadow-lg uppercase">
                                            NIDCard
                                        </button>
                                    </td>

                                    {{-- STATUS BUTTONS --}}
                                    @foreach(['TRANS STATUS', 'TRANS-ONE STATUS', 'BRANCH PERM', 'DELETE SCORE'] as $stat)
                                        <td class="px-3 py-4 text-center">
                                            <button class="inline-block rounded-md bg-[#a855f7] px-3 py-1.5 text-[8px] font-black text-white shadow-sm uppercase opacity-80">
                                                NOT ALLOWED
                                            </button>
                                        </td>
                                    @endforeach

                                    {{-- Info Columns --}}
                                    <td class="px-3 py-4"><span class="rounded bg-slate-800 px-2 py-0.5 text-slate-500">N/A</span></td>
                                    <td class="px-3 py-4 text-slate-300">{{ $student->registration_number }}</td>
                                    <td class="px-3 py-4 text-slate-300">{{ $student->roll_number ?: 'N/A' }}</td>
                                    <td class="px-3 py-4 text-white uppercase">{{ $student->name }}</td>
                                    <td class="px-3 py-4 uppercase">{{ $student->father_name ?: 'N/A' }}</td>
                                    <td class="px-3 py-4 uppercase">{{ $student->mother_name ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $student->date_of_birth?->format('Y-m-d') ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $student->gender ?: 'N/A' }}</td>
                                    <td class="px-3 py-4 text-slate-500">N/A</td> {{-- PASSPORT placeholder --}}
                                    <td class="px-3 py-4">{{ $student->religion ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $student->phone }}</td>
                                    <td class="px-3 py-4 max-w-[200px] truncate text-slate-500">{{ $student->address }}</td>
                                    <td class="px-3 py-4">{{ $student->district ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $student->upazila ?: 'N/A' }}</td>
                                    <td class="px-3 py-4 text-[#6cb2eb]">{{ $student->course?->name ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $student->duration ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $student->session ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">{{ $student->education_qualification ?: 'N/A' }}</td>
                                    <td class="px-3 py-4">BNYTI Institute</td> {{-- INSTITUTE placeholder --}}
                                    <td class="px-3 py-4">{{ $student->admitted_at?->format('Y-m-d') ?: 'N/A' }}</td>
                                    <td class="px-3 py-4 text-rose-500">{{ $student->expire_date?->format('Y-m-d') ?: 'N/A' }}</td>
                                    <td class="px-3 py-4 text-slate-500">Admin</td> {{-- DIRECTOR placeholder --}}
                                    <td class="px-3 py-4 text-slate-600">{{ $student->created_at?->format('Y-m-d H:i') }}</td>
                                    <td class="px-3 py-4 text-slate-500">N/A</td> {{-- EXAMINATION MONTH placeholder --}}
                                    <td class="px-3 py-4 text-slate-500">N/A</td> {{-- PUBLICATION DATE placeholder --}}
                                    <td class="px-3 py-4 text-slate-500">0</td>   {{-- TOTAL MARKS placeholder --}}

                                    {{-- ID CARD (at the end as per image 6) --}}
                                    <td class="px-3 py-4 text-center">
                                        <button class="inline-block rounded-md bg-[#a855f7] px-3 py-1.5 text-[8px] font-black text-white shadow-sm uppercase opacity-80">
                                            NOT ALLOWED
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="41" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                        No student records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Custom Pagination Footer from Images --}}
            <div class="mt-8 flex flex-col items-center justify-between gap-6 sm:flex-row">
                <div class="flex items-center gap-4">
                    <div class="flex h-10 items-center gap-3 rounded-full bg-black/30 px-6 ring-1 ring-white/10">
                        <span class="relative flex size-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex size-2 rounded-full bg-blue-500"></span>
                        </span>
                        <p class="text-[11px] font-black text-white">Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }}</p>
                    </div>
                    <div class="flex h-8 items-center rounded-full bg-blue-600/20 px-4 ring-1 ring-blue-500/30">
                        <p class="text-[10px] font-black uppercase tracking-widest text-blue-400">TOTAL: {{ $students->total() }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="rounded-lg bg-white/5 px-4 py-2 text-[10px] font-black text-slate-400 ring-1 ring-white/10">
                        Page {{ $students->currentPage() }}
                    </div>

                    <div class="flex items-center overflow-hidden rounded-xl bg-black/40 p-1 ring-1 ring-white/10">
                        <a href="{{ $students->previousPageUrl() }}"
                           class="flex size-9 items-center justify-center rounded-lg text-white transition hover:bg-white/10 @if($students->onFirstPage()) opacity-30 pointer-events-none @endif">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="3"><path d="M15 18l-6-6 6-6"/></svg>
                        </a>
                        <div class="flex h-9 items-center px-6 text-[12px] font-black text-white border-x border-white/5">
                            {{ $students->currentPage() }} / {{ $students->lastPage() }}
                        </div>
                        <a href="{{ $students->nextPageUrl() }}"
                           class="flex size-9 items-center justify-center rounded-lg text-white transition hover:bg-white/10 @if(!$students->hasMorePages()) opacity-30 pointer-events-none @endif">
                            <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="3"><path d="M9 18l6-6-6-6"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function downloadPdf(event, url) {
            event.preventDefault();
            const win = window.open(url, '_blank');
            win.onload = function() {
                setTimeout(() => {
                    win.print();
                }, 800);
            };
        }
    </script>
</x-dashboard-shell>

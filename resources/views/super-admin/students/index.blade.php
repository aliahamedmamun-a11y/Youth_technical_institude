<x-dashboard-shell title="Student Information Table" eyebrow="Management" description="View and manage all registered student records.">
    <div class="min-h-screen bg-[#071c2c] p-4 sm:p-6 lg:p-8 rounded-[2.5rem] shadow-2xl">
        <div class="mx-auto max-w-[1600px] space-y-8">

            <div class="text-center space-y-6 pt-6">
                <h1 class="text-2xl font-black text-white uppercase tracking-[0.25em] drop-shadow-lg">Student Information Table</h1>
                <form method="GET" class="mx-auto max-w-xl">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ $search }}"
                            class="w-full rounded-2xl border border-white/10 bg-[#0f2d44] py-4 pl-7 pr-14 text-sm text-white placeholder-slate-500 shadow-2xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 focus:outline-none transition-all"
                            placeholder="Search by Roll Number...">
                        <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-400 group-hover:text-blue-400 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-[2.5rem] border border-white/5 bg-[#0f2d44]/40 shadow-2xl backdrop-blur-2xl">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left text-[11px] font-black uppercase tracking-wider text-slate-300">
                        <thead>
                            <tr class="bg-[#071c2c]/90 text-slate-400 border-b border-white/5">
                                <th class="px-6 py-7 text-center">PICTURE</th>
                                <th class="px-6 py-7 text-center">ACTIONS</th>
                                <th class="px-6 py-7 text-center">ADMIT-CARD</th>
                                <th class="px-6 py-7 text-center">REGISTRATION</th>
                                <th class="px-6 py-7 text-center">CERTIFICATE</th>
                                <th class="px-6 py-7 text-center">TRANSCRIPT</th>
                                <th class="px-6 py-7 text-center">TRANSCRIPTONE</th>
                                <th class="px-6 py-7 text-center">TRANSCRIPTTWO</th>
                                <th class="px-6 py-7 text-center">MSCCARD</th>
                                <th class="px-6 py-7 text-center">CERT STATUS</th>
                                <th class="px-6 py-7 text-center">STUDENT ID</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($students as $student)
                                <tr class="hover:bg-white/[0.03] transition-all duration-300 group">
                                    <td class="px-4 py-4">
                                        <div class="relative mx-auto size-14 overflow-hidden rounded-2xl border-2 border-slate-700 bg-slate-800 shadow-2xl group-hover:border-blue-500 transition-all duration-500">
                                            <img src="{{ $student->image_path ? asset('storage/' . $student->image_path) : asset('images/placeholder-avatar.png') }}"
                                                class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-4 text-[10px] font-black">
                                            <a href="{{ route('super-admin.students.edit', $student) }}" class="text-blue-500 hover:text-blue-400 transition-colors">EDIT</a>
                                            <form action="{{ route('super-admin.students.destroy', $student) }}" method="POST" onsubmit="return confirm('Delete this student?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-pink-600 hover:text-pink-500 transition-colors">DELETE</button>
                                            </form>
                                            <a href="{{ route('super-admin.students.show', $student) }}" class="text-emerald-500 hover:text-emerald-400 transition-colors">UPDATE</a>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'admit-card']) }}" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-red-600 px-4 text-[10px] font-black text-white hover:bg-red-700 shadow-xl shadow-red-900/20 active:scale-95 transition-all">Admit Card</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'registration-card']) }}" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-blue-600 px-4 text-[10px] font-black text-white hover:bg-blue-700 shadow-xl shadow-blue-900/20 active:scale-95 transition-all">Registration Card</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'certificate']) }}" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-emerald-600 px-4 text-[10px] font-black text-white hover:bg-emerald-700 shadow-xl shadow-emerald-900/20 active:scale-95 transition-all">Certificate</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'transcript']) }}" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-green-600 px-4 text-[10px] font-black text-white hover:bg-green-700 shadow-xl shadow-green-900/20 active:scale-95 transition-all">Certificate One</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="#" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-slate-600 px-4 text-[10px] font-black text-white hover:bg-slate-700 shadow-xl active:scale-95 transition-all">Transcript</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="#" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-blue-500 px-4 text-[10px] font-black text-white hover:bg-blue-600 shadow-xl active:scale-95 transition-all">TranscriptOne</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="#" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-cyan-600 px-4 text-[10px] font-black text-white hover:bg-cyan-700 shadow-xl active:scale-95 transition-all">Transcript Two</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="#" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-purple-600 px-4 text-[10px] font-black text-white hover:bg-purple-700 shadow-xl active:scale-95 transition-all">NIDCard</a>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'student-id']) }}" class="inline-flex h-10 min-w-[120px] items-center justify-center rounded-xl bg-indigo-600 px-4 text-[10px] font-black text-white hover:bg-indigo-700 shadow-xl active:scale-95 transition-all">ID Card</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center gap-3 text-slate-500">
                                            <p class="text-sm font-bold uppercase tracking-widest">No student records found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="bg-[#071c2c] px-6 py-10 border-t border-white/5">
                    <div class="mx-auto max-w-sm overflow-hidden rounded-[2.5rem] bg-[#0f2d44] shadow-[0_20px_50px_rgba(0,0,0,0.5)] ring-1 ring-white/10">
                        <div class="flex flex-col items-center gap-5 p-7">
                            <div class="flex items-center gap-2">
                                <span class="size-3 rounded-full bg-indigo-500 shadow-[0_0_15px_rgba(99,102,241,0.6)] animate-pulse"></span>
                                <span class="text-[11px] font-black text-slate-200 uppercase tracking-widest">Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }}</span>
                            </div>

                            <div class="rounded-full bg-[#071c2c] px-6 py-2 border border-white/5 shadow-inner">
                                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.25em]">TOTAL: {{ $students->total() }}</span>
                            </div>

                            <div class="mt-4 flex items-center justify-between w-full">
                                <button class="rounded-2xl bg-[#071c2c] px-6 py-2.5 text-[11px] font-black text-slate-400 border border-white/5 shadow-lg active:scale-95 transition-all hover:text-white">Page {{ $students->currentPage() }}</button>

                                <div class="flex items-center gap-3">
                                    @if($students->onFirstPage())
                                        <span class="grid size-10 place-items-center rounded-xl bg-[#071c2c] text-slate-700 border border-white/5 opacity-40">«</span>
                                    @else
                                        <a href="{{ $students->previousPageUrl() }}" class="grid size-10 place-items-center rounded-xl bg-[#071c2c] text-white border border-white/5 shadow-xl hover:border-blue-500/50 hover:text-blue-400 hover:-translate-x-0.5 transition-all active:scale-90">«</a>
                                    @endif

                                    <div class="flex h-10 items-center rounded-xl bg-[#071c2c] px-5 border border-white/5 shadow-inner ring-1 ring-white/5">
                                        <span class="text-[12px] font-black text-white">{{ $students->currentPage() }} / {{ $students->lastPage() }}</span>
                                    </div>

                                    @if($students->hasMorePages())
                                        <a href="{{ $students->nextPageUrl() }}" class="grid size-10 place-items-center rounded-xl bg-[#071c2c] text-white border border-white/5 shadow-xl hover:border-blue-500/50 hover:text-blue-400 hover:translate-x-0.5 transition-all active:scale-90">»</a>
                                    @else
                                        <span class="grid size-10 place-items-center rounded-xl bg-[#071c2c] text-slate-700 border border-white/5 opacity-40">»</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-shell>

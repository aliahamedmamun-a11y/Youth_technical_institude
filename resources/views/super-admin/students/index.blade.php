<x-dashboard-shell title="Student Information Table">
    <div class="mx-auto max-w-full px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-6 shadow-2xl backdrop-blur-sm lg:p-8">

            <div class="mb-8 text-center">
                <h1 class="text-3xl font-black tracking-tight text-white uppercase sm:text-4xl">Student Information Table</h1>
            </div>

            {{-- Search Bar --}}
            <div class="mx-auto mb-8 max-w-2xl">
                <form method="GET" class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search by Roll Number..."
                        class="w-full rounded-2xl border border-white/10 bg-[#071c2c]/70 py-4 pl-12 pr-6 text-sm text-white placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-xl">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </form>
            </div>

            <!-- Student Information Table -->
            <div class="overflow-hidden rounded-2xl border border-white/10 bg-[#071c2c]/60 shadow-2xl">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-4 py-4 text-center">PICTURE</th>
                                <th class="px-4 py-4 text-center">ACTIONS</th>
                                <th class="px-4 py-4 text-center">ADMIT-CARD</th>
                                <th class="px-4 py-4 text-center">REGISTRATION</th>
                                <th class="px-4 py-4 text-center">CERTIFICATE</th>
                                <th class="px-4 py-4 text-center">TRANSCRIPT</th>
                                <th class="px-4 py-4 text-center">TRANSCRIPTONE</th>
                                <th class="px-4 py-4 text-center">TRANSCRIPTTWO</th>
                                <th class="px-4 py-4 text-center">NIDCARD</th>
                                <th class="px-4 py-4 text-center">RESULT 1</th>
                                <th class="px-4 py-4 text-center">RESULT 2</th>
                                <th class="px-4 py-4 text-center">DELETE SCORE</th>
                                <th class="px-4 py-4 text-center">BRANCH ID</th>
                                <th class="px-4 py-4 text-center">STUDENT ID</th>
                                <th class="px-4 py-4 text-center">STUDENT REGISTRATION NUMBER</th>
                                <th class="px-4 py-4 text-center">STUDENT ROLL NUMBER</th>
                                <th class="px-4 py-4 text-center">CERTIFICATE SERIAL NUMBER</th>
                                <th class="px-4 py-4 text-center">STUDENT NAME</th>
                                <th class="px-4 py-4 text-center">FATHER NAME</th>
                                <th class="px-4 py-4 text-center">MOTHER NAME</th>
                                <th class="px-4 py-4 text-center">DOB</th>
                                <th class="px-4 py-4 text-center">GENDER</th>
                                <th class="px-4 py-4 text-center">PASSPORT</th>
                                <th class="px-4 py-4 text-center">GUARDIAN PHONE</th>
                                <th class="px-4 py-4 text-center">STUDENT ADDRESS</th>
                                <th class="px-4 py-4 text-center">DISTRICT</th>
                                <th class="px-4 py-4 text-center">THANA</th>
                                <th class="px-4 py-4 text-center">SEARCH COURSE</th>
                                <th class="px-4 py-4 text-center">DURATION</th>
                                <th class="px-4 py-4 text-center">SESSION</th>
                                <th class="px-4 py-4 text-center">EDUCATION QUALIFICATION</th>
                                <th class="px-4 py-4 text-center">INSTITUTE</th>
                                <th class="px-4 py-4 text-center">ISSUE DATE</th>
                                <th class="px-4 py-4 text-center">EXPIRE DATE</th>
                                <th class="px-4 py-4 text-center">DIRECTOR NAME</th>
                                <th class="px-4 py-4 text-center">CREATED AT</th>
                                <th class="px-4 py-4 text-center">PICTURE</th>
                                <th class="px-4 py-4 text-center">EXAMINATION MONTH</th>
                                <th class="px-4 py-4 text-center">PUBLICATION DATE</th>
                                <th class="px-4 py-4 text-center">TOTAL MARKS</th>
                                <th class="px-4 py-4 text-center">ID CARD</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($students as $student)
                                @php
                                    $studentImg = $student->image_path ? (str_starts_with($student->image_path, 'http') ? $student->image_path : asset('storage/' . $student->image_path)) : 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg';
                                    $studentJsonData = [
                                        'id' => $student->id,
                                        'branch_id' => $student->branch_id,
                                        'registration_number' => $student->registration_number,
                                        'roll_number' => $student->roll_number,
                                        'certificate_serial' => $student->certificate_serial,
                                        'institute_name' => ($student->institute_name && !in_array(strtoupper($student->institute_name), ['BNTEI', 'BNTI'])) ? $student->institute_name : ($student->branch?->institute_name ?? 'South Asia Engineering & Technical Institute'),
                                        'director_name' => $student->director_name,
                                        'name' => $student->name,
                                        'father_name' => $student->father_name,
                                        'mother_name' => $student->mother_name,
                                        'date_of_birth' => optional($student->date_of_birth)->format('Y-m-d'),
                                        'gender' => $student->gender ?? 'Male',
                                        'passport_nid_number' => $student->passport_nid_number,
                                        'phone' => $student->phone,
                                        'address' => $student->address,
                                        'district' => $student->district,
                                        'upazila' => $student->upazila,
                                        'course_id' => $student->course_id,
                                        'duration' => $student->duration,
                                        'session' => $student->session,
                                        'education_qualification' => $student->education_qualification,
                                        'admitted_at' => optional($student->admitted_at)->format('Y-m-d'),
                                        'expire_date' => optional($student->expire_date)->format('Y-m-d'),
                                        'full_marks' => $student->full_marks,
                                        'written_marks' => $student->written_marks,
                                        'viva_marks' => $student->viva_marks,
                                        'practical_marks' => $student->practical_marks,
                                        'score' => $student->score,
                                        'grade' => $student->grade,
                                        'cgpa' => $student->cgpa,
                                        'publication_date' => $student->publication_date,
                                        'examination_month' => $student->examination_month,
                                        'semesters' => $student->results->mapWithKeys(fn($r) => [$r->semester => ['cgpa' => $r->gpa, 'grade' => $r->overall_grade]]),
                                        'created_at' => $student->created_at?->toISOString(),
                                        'image' => $studentImg,
                                        'update_url' => route('super-admin.students.update', $student),
                                    ];
                                @endphp
                                <tr class="group transition-colors hover:bg-white/5 text-[11px] font-bold text-slate-300">
                                    {{-- PICTURE --}}
                                    <td class="px-4 py-4 text-center">
                                        <div class="size-11 overflow-hidden rounded-xl border border-white/20 bg-slate-800 shadow-xl mx-auto">
                                            <img src="{{ $studentImg }}" alt="{{ $student->name }}" class="size-full object-cover" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
                                        </div>
                                    </td>

                                    {{-- ACTIONS --}}
                                    <td class="px-4 py-4 text-center">
                                        <div class="flex items-center gap-2 justify-center">
                                            <a href="{{ route('super-admin.students.edit', $student) }}"
                                               data-student="{{ json_encode($studentJsonData) }}"
                                               onclick="openEditModalFromElement(event, this)"
                                               class="text-blue-400 hover:text-blue-300 font-black uppercase text-[10px] tracking-wider cursor-pointer">
                                                EDIT
                                            </a>
                                            <form action="{{ route('super-admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-400 hover:text-rose-300 font-black uppercase text-[10px] tracking-wider cursor-pointer bg-transparent border-0 p-0">
                                                    DELETE
                                                </button>
                                            </form>
                                            <a href="{{ route('super-admin.students.edit', $student) }}"
                                               data-student="{{ json_encode($studentJsonData) }}"
                                               onclick="openEditModalFromElement(event, this)"
                                               class="text-emerald-400 hover:text-emerald-300 font-black uppercase text-[10px] tracking-wider cursor-pointer">
                                                UPDATE
                                            </a>
                                        </div>
                                    </td>

                                    {{-- ADMIT-CARD --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'admit-card']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-red-600 hover:bg-red-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            Admit-Card
                                        </a>
                                    </td>

                                    {{-- REGISTRATION --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'registration-card']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-blue-600 hover:bg-blue-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            Registration Card
                                        </a>
                                    </td>

                                    {{-- CERTIFICATE --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'certificate']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-emerald-600 hover:bg-emerald-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            Certificate
                                        </a>
                                    </td>

                                    {{-- TRANSCRIPT --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'transcript']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-teal-600 hover:bg-teal-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            Certificate One
                                        </a>
                                    </td>

                                    {{-- TRANSCRIPTONE --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'transcript']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-slate-600 hover:bg-slate-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            Transcript
                                        </a>
                                    </td>

                                    {{-- TRANSCRIPTTWO --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'transcript']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-sky-600 hover:bg-sky-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            TranscriptOne
                                        </a>
                                    </td>

                                    {{-- NIDCARD --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'student-id']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-cyan-600 hover:bg-cyan-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            NIDCard
                                        </a>
                                    </td>

                                    {{-- RESULT 1 --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'results']) }}"
                                           target="_blank"
                                           class="inline-block rounded-lg bg-emerald-600 hover:bg-emerald-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            Result 1
                                        </a>
                                    </td>

                                    {{-- RESULT 2 --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'results-2']) }}"
                                           target="_blank"
                                           class="inline-block rounded-lg bg-indigo-600 hover:bg-indigo-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            Result 2
                                        </a>
                                    </td>

                                    {{-- DELETE SCORE --}}
                                    <td class="px-4 py-4 text-center">
                                        @if($student->results()->exists() || $student->score !== null || $student->grade !== null)
                                            <form action="{{ route('super-admin.students.destroy-score', $student) }}" method="POST" onsubmit="return confirm('Delete score/results for this student?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rounded-full bg-rose-500/20 hover:bg-rose-500/40 px-3 py-1 text-[9px] font-black uppercase text-rose-300 transition cursor-pointer">
                                                    DELETE SCORE
                                                </button>
                                            </form>
                                        @else
                                            <span class="rounded-full bg-slate-500/20 px-3 py-1 text-[9px] font-black uppercase text-slate-400">NO SCORE</span>
                                        @endif
                                    </td>

                                    {{-- BRANCH ID --}}
                                    <td class="px-4 py-4 text-slate-300 font-mono">{{ $student->branch_id ?: 'N/A' }}</td>

                                    {{-- STUDENT ID --}}
                                    <td class="px-4 py-4 text-slate-300 font-mono">{{ str_pad($student->id, 6, '0', STR_PAD_LEFT) }}</td>

                                    {{-- STUDENT REGISTRATION NUMBER --}}
                                    <td class="px-4 py-4 text-slate-300 font-mono">{{ $student->registration_number }}</td>

                                    {{-- STUDENT ROLL NUMBER --}}
                                    <td class="px-4 py-4 text-slate-300 font-mono">{{ $student->roll_number }}</td>

                                    {{-- CERTIFICATE SERIAL NUMBER --}}
                                    <td class="px-4 py-4 text-amber-300 font-mono font-bold">{{ $student->certificate_serial ?: '—' }}</td>

                                    {{-- STUDENT NAME --}}
                                    <td class="px-4 py-4 text-white font-bold">{{ $student->name }}</td>

                                    {{-- FATHER NAME --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->father_name ?: 'N/A' }}</td>

                                    {{-- MOTHER NAME --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->mother_name ?: 'N/A' }}</td>

                                    {{-- DOB --}}
                                    <td class="px-4 py-4 text-slate-400">{{ optional($student->date_of_birth)->format('Y-m-d') ?: 'N/A' }}</td>

                                    {{-- GENDER --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->gender ?: 'Male' }}</td>

                                    {{-- PASSPORT --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->passport_nid_number ?: 'N/A' }}</td>

                                    {{-- GUARDIAN PHONE --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->phone }}</td>

                                    {{-- STUDENT ADDRESS --}}
                                    <td class="px-4 py-4 text-slate-400 max-w-[200px] truncate">{{ $student->address }}</td>

                                    {{-- DISTRICT --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->district }}</td>

                                    {{-- THANA --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->upazila }}</td>

                                    {{-- SEARCH COURSE --}}
                                    <td class="px-4 py-4 text-slate-300">{{ $student->course?->name ?: 'N/A' }}</td>

                                    {{-- DURATION --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->duration ?: "6 Month's" }}</td>

                                    {{-- SESSION --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->session ?: '2023-2024' }}</td>

                                    {{-- EDUCATION QUALIFICATION --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->education_qualification ?: 'SSC' }}</td>

                                    {{-- INSTITUTE --}}
                                    <td class="px-4 py-4 text-slate-300 uppercase">{{ $student->institute_name ?: ($student->branch?->institute_name ?? 'BNTEI') }}</td>

                                    {{-- ISSUE DATE --}}
                                    <td class="px-4 py-4 text-slate-400">{{ optional($student->admitted_at)->format('Y-m-d') ?: 'N/A' }}</td>

                                    {{-- EXPIRE DATE --}}
                                    <td class="px-4 py-4 text-slate-400">{{ optional($student->expire_date)->format('Y-m-d') ?: 'N/A' }}</td>

                                    {{-- DIRECTOR NAME --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->director_name ?: 'Md Salam' }}</td>

                                    {{-- CREATED AT --}}
                                    <td class="px-4 py-4 text-slate-400">{{ $student->created_at?->format('Y-m-d') }}</td>

                                    {{-- PICTURE --}}
                                    <td class="px-4 py-4 text-center">
                                        <div class="size-11 overflow-hidden rounded-xl border border-white/20 bg-slate-800 shadow-xl mx-auto">
                                            <img src="{{ $studentImg }}" alt="{{ $student->name }}" class="size-full object-cover" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
                                        </div>
                                    </td>

                                    {{-- EXAMINATION MONTH --}}
                                    <td class="px-4 py-4 text-slate-400">Jul - Dec 2023</td>

                                    {{-- PUBLICATION DATE --}}
                                    <td class="px-4 py-4 text-slate-400">15 Dec 2025</td>

                                    {{-- TOTAL MARKS --}}
                                    <td class="px-4 py-4 text-slate-400 font-mono">3860</td>

                                    {{-- ID CARD --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'student-id']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-indigo-600 hover:bg-indigo-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            ID Card
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="40" class="px-6 py-20 text-center text-sm font-bold text-slate-400">
                                        No student records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Footer --}}
            @if($students->hasPages())
                <div class="mt-8">
                    {{ $students->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- EDIT STUDENT INFORMATION MODAL OVERLAY -->
    <div id="edit-student-modal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-md overflow-y-auto p-3 sm:p-6 flex items-start justify-center">
        <div class="relative w-full max-w-4xl max-h-[88vh] overflow-y-auto my-auto rounded-3xl border border-white/10 bg-[#0e1828] p-6 lg:p-10 shadow-2xl space-y-8">

            <div class="text-center">
                <h2 class="text-2xl sm:text-3xl font-black text-[#818cf8] uppercase tracking-tight">
                    Edit Student Information
                </h2>
            </div>

            <form method="POST" id="modal-edit-form" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <!-- CENTERED AVATAR PHOTO & CHANGE IMAGE BUTTON -->
                <div class="flex flex-col items-center justify-center space-y-3 pb-4 border-b border-white/10">
                    <div class="size-28 sm:size-32 rounded-full overflow-hidden border-2 border-indigo-500/50 bg-[#071c2c] shadow-2xl flex items-center justify-center ring-4 ring-indigo-500/10">
                        <img id="modal-avatar-preview" src="https://i.ibb.co/qMgPTvMQ/1000072415.jpg" alt="Student Photo" class="size-full object-cover" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
                    </div>
                    <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                        <span>Change Image</span>
                        <input type="file" name="image" accept="image/*" class="hidden" onchange="previewModalAvatar(this)">
                    </label>
                </div>

                @php
                    $modalInputClass = 'w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-indigo-500 outline-none transition-all';
                    $modalSelectClass = $modalInputClass . ' cursor-pointer';
                    $modalLabelClass = 'block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider';
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Branch Id -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Branch Id</label>
                        <input type="text" name="branch_id" id="modal-branch-id" placeholder="Branch Code / ID" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Student Id -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Student Id</label>
                        <input type="text" name="student_id" id="modal-student-id" placeholder="Student ID" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Student Registration Number -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Student Registration Number</label>
                        <input type="text" name="registration_number" id="modal-reg-no" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Student Roll Number -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Student Roll Number</label>
                        <input type="text" name="roll_number" id="modal-roll-no" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Certificate Serial Number -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Certificate Serial Number</label>
                        <input type="text" name="certificate_serial" id="modal-cert-serial" placeholder="Certificate Serial Number" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Student Name -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Student Name</label>
                        <input type="text" name="name" id="modal-name" required placeholder="Student Name" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Father Name -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Father Name</label>
                        <input type="text" name="father_name" id="modal-father-name" placeholder="Father Name" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Mother Name -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Mother Name</label>
                        <input type="text" name="mother_name" id="modal-mother-name" placeholder="Mother Name" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Dob -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Dob</label>
                        <input type="date" name="date_of_birth" id="modal-dob" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Gender</label>
                        <select name="gender" id="modal-gender" class="{{ $modalSelectClass }}">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Passport -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Passport</label>
                        <input type="text" name="passport_nid_number" id="modal-passport" placeholder="Passport or NID Number" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Guardian Phone -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Guardian Phone</label>
                        <input type="text" name="phone" id="modal-phone" placeholder="Guardian Phone" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Student Address -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Student Address</label>
                        <input type="text" name="address" id="modal-address" placeholder="Student Address" class="{{ $modalInputClass }}">
                    </div>

                    <!-- District -->
                    <div>
                        <label class="{{ $modalLabelClass }}">District</label>
                        <select name="district" id="modal-district-select" class="{{ $modalSelectClass }}">
                            <option value="">Select District</option>
                            @foreach(config('bangladesh.districts') as $dist)
                                <option value="{{ $dist }}">{{ $dist }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Thana -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Thana</label>
                        <select name="upazila" id="modal-upazila-select" class="{{ $modalSelectClass }}">
                            <option value="">Select Thana</option>
                        </select>
                    </div>

                    <!-- Search Course -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Search Course</label>
                        <select name="course_id" id="modal-course-id" class="{{ $modalSelectClass }}">
                            <option value="">Select Course</option>
                            @foreach($courses ?? [] as $crs)
                                <option value="{{ $crs->id }}">{{ $crs->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Duration -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Duration</label>
                        <select name="duration" id="modal-duration" class="{{ $modalSelectClass }}">
                            @foreach(['3 Months', "6 Month's", '1 Year', '2 Years', '4 Years'] as $dur)
                                <option value="{{ $dur }}">{{ $dur }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Session -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Session</label>
                        <input type="text" name="session" id="modal-session" placeholder="Session" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Education Qualification -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Education Qualification</label>
                        <input type="text" name="education_qualification" id="modal-education" placeholder="Education Qualification" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Institute -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Institute</label>
                        <input type="text" name="institute_name" id="modal-institute" placeholder="Institute Name" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Issue Date -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Issue Date</label>
                        <input type="date" name="admitted_at" id="modal-admitted-at" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Expire Date -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Expire Date</label>
                        <input type="date" name="expire_date" id="modal-expire-date" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Director Name -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Director Name</label>
                        <input type="text" name="director_name" id="modal-director-name" placeholder="Director Name" class="{{ $modalInputClass }}">
                    </div>

                    <!-- Created At -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Created At</label>
                        <input type="text" id="modal-created-at" readonly class="{{ $modalInputClass }} cursor-not-allowed text-slate-400">
                    </div>

                    <!-- Picture -->
                    <div>
                        <label class="{{ $modalLabelClass }}">Picture Upload / Photo</label>
                        <input type="file" name="image" accept="image/*" class="{{ $modalInputClass }} file:mr-2 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-black file:bg-indigo-600 file:text-white">
                        <input type="text" id="modal-picture-url" readonly class="{{ $modalInputClass }} mt-1 cursor-not-allowed text-slate-400 text-xs truncate">
                    </div>

                </div>

                <!-- ADD SUBJECTS SECTION -->
                <div class="space-y-4 pt-6 border-t border-white/10">
                    <h3 class="text-base font-black text-[#818cf8] uppercase tracking-wide">Add Subjects</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="{{ $modalLabelClass }}">Select Semester</label>
                            <select id="modal-sub-semester" onchange="updateAddSubButtonText(this.value)" class="{{ $modalSelectClass }}">
                                <option value="1st">1st</option>
                                <option value="2nd">2nd</option>
                                <option value="3rd">3rd</option>
                                <option value="4th">4th</option>
                                <option value="5th">5th</option>
                                <option value="6th">6th</option>
                                <option value="7th">7th</option>
                                <option value="8th">8th</option>
                            </select>
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Subject Names (One Per Line)</label>
                            <textarea id="modal-sub-names" rows="3" placeholder="Enter subject names here, each on a new line." class="{{ $modalInputClass }} resize-none"></textarea>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <!-- RED MARKED POSITION: TWO BUTTONS FOR RESULT 1 & RESULT 2 -->
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button type="button" id="modal-btn-result-mode-1" onclick="switchModalResultMode('result1')"
                                class="flex-1 sm:flex-none rounded-xl px-5 py-2.5 font-black text-xs uppercase tracking-wider transition-all shadow-lg bg-emerald-600 text-white ring-2 ring-emerald-400">
                                📜 Result 1
                            </button>
                            <button type="button" id="modal-btn-result-mode-2" onclick="switchModalResultMode('result2')"
                                class="flex-1 sm:flex-none rounded-xl px-5 py-2.5 font-black text-xs uppercase tracking-wider transition-all shadow-lg bg-[#071c2c] text-slate-300 border border-white/10 hover:bg-[#0f2d44]">
                                📊 Result 2
                            </button>
                        </div>

                        <button type="button" onclick="addModalSubjects()" class="w-full sm:w-auto rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-6 py-2.5 font-bold text-xs uppercase tracking-wider shadow-lg transition-all active:scale-95">
                            <span id="add-sub-btn-text">Add Subjects for 1st Semester</span>
                        </button>
                    </div>
                </div>

                <!-- SUBJECT PREVIEW TABLE -->
                <div class="space-y-4 pt-4 border-t border-white/10">
                    <h3 class="text-base font-black text-slate-200 uppercase tracking-wide">Subject Preview</h3>
                    <div class="overflow-hidden rounded-xl border border-white/10 bg-[#071c2c]/70">
                        <table class="w-full text-left text-xs font-bold text-slate-300">
                            <thead>
                                <tr class="border-b border-white/10 bg-white/5 uppercase tracking-widest text-[#6cb2eb]">
                                    <th class="px-4 py-3">Subject</th>
                                    <th class="px-4 py-3">Semester</th>
                                    <th class="px-4 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="modal-subject-preview-body" class="divide-y divide-white/5">
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-slate-500">No subjects added yet.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- SECTION RESULT 1 MODE: ACADEMIC DETAILS & FINAL RESULT -->
                <div id="modal-section-result-1" class="space-y-6">
                    <!-- ACADEMIC DETAILS (PER SEMESTER) -->
                    <div class="space-y-4 pt-6 border-t border-white/10">
                        <div>
                            <h3 class="text-base font-black text-slate-200 uppercase tracking-wide">Academic Details (Per Semester)</h3>
                            <p class="text-xs text-slate-400 font-medium">Enter the CGPA (0.00-4.00) for each semester, and the Grade will auto-calculate.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'] as $idx => $sem)
                                <div class="rounded-2xl border border-white/10 bg-[#071c2c]/80 p-4 space-y-3">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-xs font-black text-[#818cf8] uppercase tracking-wider">{{ $sem }} Semester</h4>
                                        <span class="text-[9px] font-bold text-slate-300 uppercase">CGPA</span>
                                    </div>
                                    <input type="number" step="0.01" min="0" max="4.00" name="semesters[{{ $sem }}][cgpa]" id="modal-sem-cgpa-{{ $idx }}"
                                        oninput="calcModalSemGrade({{ $idx }})" placeholder="e.g. 3.75"
                                        class="w-full rounded-xl border border-white/20 bg-[#070d19] py-2.5 px-3 text-xs font-bold text-white placeholder-slate-400 focus:border-indigo-500 outline-none transition-all">

                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-300 mb-1 uppercase tracking-wider">Grade (Auto-Calculated)</label>
                                        <select name="semesters[{{ $sem }}][grade]" id="modal-sem-grade-{{ $idx }}" class="{{ $modalSelectClass }} py-2 text-xs">
                                            <option value="">Select Grade</option>
                                            <option value="A+">A+</option>
                                            <option value="A">A</option>
                                            <option value="A-">A-</option>
                                            <option value="B+">B+</option>
                                            <option value="B">B</option>
                                            <option value="B-">B-</option>
                                            <option value="C+">C+</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="F">F</option>
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- FINAL RESULT (OVERALL) -->
                    <div class="space-y-4 pt-6 border-t border-white/10">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <h3 class="text-base font-black text-slate-200 uppercase tracking-wide">Final Result (Overall)</h3>
                            <button type="button" onclick="calcModalOverallResult()" class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-4 py-2 font-black text-xs uppercase tracking-wider shadow transition active:scale-95">
                                ✨ Auto-Calculate Overall Result
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="{{ $modalLabelClass }}">Full Mark</label>
                                <input type="number" name="full_mark" id="modal-full-mark" placeholder="e.g. 4800" class="{{ $modalInputClass }}">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Written Marks</label>
                                <input type="number" name="written_marks" id="modal-written-marks" oninput="calcModalOverallResult()" placeholder="e.g. 3320" class="{{ $modalInputClass }}">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Viva Marks</label>
                                <input type="number" name="viva_marks" id="modal-viva-marks" oninput="calcModalOverallResult()" placeholder="e.g. 250" class="{{ $modalInputClass }}">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Practical Mark</label>
                                <input type="number" name="practical_mark" id="modal-practical-mark" oninput="calcModalOverallResult()" placeholder="e.g. 270" class="{{ $modalInputClass }}">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Total Marks (Auto)</label>
                                <input type="number" name="total_marks" id="modal-total-marks" value="0" class="{{ $modalInputClass }} font-bold text-indigo-300">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Letter Grade (Auto)</label>
                                <select name="letter_grade" id="modal-letter-grade" class="{{ $modalSelectClass }}">
                                    <option value="">Select Grade</option>
                                    <option value="A+">A+</option>
                                    <option value="A">A</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B">B</option>
                                    <option value="B-">B-</option>
                                    <option value="C+">C+</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="F">F</option>
                                </select>
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">CGPA (Overall Auto)</label>
                                <input type="number" step="0.01" name="cgpa" id="modal-cgpa" placeholder="e.g. 3.75" class="{{ $modalInputClass }} font-bold text-emerald-400">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Publication Date</label>
                                <input type="date" name="publication_date" id="modal-pub-date" class="{{ $modalInputClass }}">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Examination Month</label>
                                <input type="text" name="examination_month" id="modal-exam-month" placeholder="e.g. July 2025" class="{{ $modalInputClass }}">
                            </div>
                            <div>
                                <label class="{{ $modalLabelClass }}">Session (Display)</label>
                                <input type="text" name="session_display" id="modal-session-disp" placeholder="Jan 2024 - Dec 2024" class="{{ $modalInputClass }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECTION RESULT 2 MODE: COURSE LIST SHOW SECTION (MATCHING SCREENSHOT 2) -->
                <div id="modal-section-result-2" class="hidden space-y-6 pt-6 border-t border-white/10">
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 sm:p-7 text-slate-900 shadow-2xl space-y-5">

                        <!-- HEADER -->
                        <div class="text-center space-y-1">
                            <div class="inline-flex size-10 rounded-xl bg-indigo-50 text-indigo-600 items-center justify-center shadow-sm mx-auto mb-1">
                                <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                            </div>
                            <h2 class="text-2xl font-black uppercase tracking-tight text-slate-900">
                                COURSE LIST SHOW
                            </h2>
                        </div>

                        <!-- SUB HEADER CONTROLS BAR -->
                        <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-[#375267] p-3 text-white shadow-md">
                            <button type="button" onclick="addModalCourseRow()" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black text-xs uppercase tracking-wider px-4 py-2 transition shadow active:scale-95">
                                <span>ADD PAGE +</span>
                            </button>
                            <div class="flex items-center gap-2 font-black text-sm">
                                <span>(</span>
                                <select id="modal-result2-sem-select" onchange="renderModalCourseList()" class="bg-transparent text-white font-bold outline-none cursor-pointer">
                                    <option value="1st" class="text-slate-900">1st semester</option>
                                    <option value="2nd" class="text-slate-900">2nd semester</option>
                                    <option value="3rd" class="text-slate-900">3rd semester</option>
                                    <option value="4th" class="text-slate-900">4th semester</option>
                                    <option value="5th" class="text-slate-900">5th semester</option>
                                    <option value="6th" class="text-slate-900">6th semester</option>
                                    <option value="7th" class="text-slate-900">7th semester</option>
                                    <option value="8th" class="text-slate-900">8th semester</option>
                                </select>
                                <span>)</span>
                            </div>
                        </div>

                        <!-- SAVED ALERT NOTIFICATION -->
                        <div id="modal-course-save-note" class="hidden rounded-xl bg-emerald-500/20 border border-emerald-500/40 p-3 text-emerald-800 font-bold text-xs text-center transition-all">
                            ✓ Subject saved successfully for this semester! Click "SAVE CHANGES" below to persist all updates.
                        </div>

                        <!-- COURSE LIST TABLE -->
                        <div class="overflow-x-auto rounded-2xl border border-slate-200 shadow-sm">
                            <table class="w-full text-left text-xs border-collapse">
                                <thead class="bg-[#416279] text-white font-black uppercase tracking-wider">
                                    <tr>
                                        <th class="px-3 py-3 border-r border-slate-400/30">COURSE CODE</th>
                                        <th class="px-3 py-3 border-r border-slate-400/30">COURSE NAME</th>
                                        <th class="px-3 py-3 border-r border-slate-400/30 text-center">CREDIT</th>
                                        <th class="px-3 py-3 border-r border-slate-400/30 text-center">MARKS</th>
                                        <th class="px-3 py-3 border-r border-slate-400/30 text-center">LETTER GRADE</th>
                                        <th class="px-3 py-3 border-r border-slate-400/30 text-center">GRADE POINT</th>
                                        <th class="px-3 py-3 text-center">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id="modal-result2-course-tbody" class="divide-y divide-slate-200 font-bold text-slate-800">
                                    <!-- Dynamic course rows -->
                                </tbody>
                            </table>
                        </div>
                        <div id="modal-course-hidden-inputs"></div>

                        <!-- SUMMARY FOOTER -->
                        <div class="flex flex-wrap items-center justify-between gap-4 rounded-2xl bg-slate-100 p-4 border border-slate-200 text-slate-900">
                            <div>
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">TOTAL CREDIT:</span>
                                <span id="modal-result2-total-credit" class="text-2xl font-black text-slate-900">9.0</span>
                            </div>

                            <div class="rounded-xl bg-[#375267] text-white px-6 py-2 text-xs font-black uppercase tracking-widest shadow">
                                CREDIT
                            </div>

                            <div class="text-right">
                                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">FINAL CGPA:</span>
                                <span id="modal-result2-final-cgpa" class="text-2xl font-black text-indigo-700">4.00</span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ACTION BUTTONS -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeEditModal()" class="rounded-xl bg-[#334155] hover:bg-[#475569] text-white px-8 py-3.5 font-bold text-sm uppercase tracking-wider transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-10 py-3.5 font-black text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                        Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>

    <script>
        const modalUpazilasByDistrict = @json(config('bangladesh.upazilas'));

        function openEditModalFromElement(event, el) {
            event.preventDefault();
            let data = {};
            if (el.dataset.student) {
                try {
                    data = JSON.parse(el.dataset.student);
                    data.image_url = data.image;
                    data.father_name = data.father_name;
                    data.mother_name = data.mother_name;
                    data.date_of_birth = data.date_of_birth;
                    data.passport_nid_number = data.passport_nid_number;
                    data.education_qualification = data.education_qualification;
                } catch(e) {
                    console.error("Failed to parse student data", e);
                }
            } else {
                data = {
                    id: el.dataset.studentId,
                    name: el.dataset.studentName,
                    father_name: el.dataset.studentFather,
                    mother_name: el.dataset.studentMother,
                    date_of_birth: el.dataset.studentDob,
                    gender: el.dataset.studentGender,
                    passport_nid_number: el.dataset.studentPassport,
                    phone: el.dataset.studentPhone,
                    address: el.dataset.studentAddress,
                    district: el.dataset.studentDistrict,
                    upazila: el.dataset.studentUpazila,
                    course_id: el.dataset.studentCourse,
                    duration: el.dataset.studentDuration,
                    session: el.dataset.studentSession,
                    education_qualification: el.dataset.studentEducation,
                    admitted_at: el.dataset.studentAdmitted,
                    expire_date: el.dataset.studentExpire,
                    created_at: el.dataset.studentCreated,
                    image_url: el.dataset.studentImage,
                    update_url: el.dataset.studentUpdateUrl
                };
            }
            openEditModal(data);
        }

        function openEditModal(student) {
            const modal = document.getElementById('edit-student-modal');
            const form = document.getElementById('modal-edit-form');
            if (!modal || !form) return;

            form.action = student.update_url;

            document.getElementById('modal-avatar-preview').src = student.image_url || student.image || 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg';
            document.getElementById('modal-branch-id').value = student.branch_id || '';
            document.getElementById('modal-student-id').value = student.id || student.student_id || '';
            document.getElementById('modal-reg-no').value = student.registration_number || '';
            document.getElementById('modal-roll-no').value = student.roll_number || '';
            if (document.getElementById('modal-cert-serial')) {
                document.getElementById('modal-cert-serial').value = student.certificate_serial || '';
            }
            if (document.getElementById('modal-institute')) {
                document.getElementById('modal-institute').value = student.institute_name || '';
            }
            if (document.getElementById('modal-director-name')) {
                document.getElementById('modal-director-name').value = student.director_name || '';
            }
            if (document.getElementById('modal-picture-url')) {
                document.getElementById('modal-picture-url').value = student.image_url || student.image || '';
            }
            document.getElementById('modal-name').value = student.name || '';
            document.getElementById('modal-father-name').value = student.father_name || '';
            document.getElementById('modal-mother-name').value = student.mother_name || '';
            document.getElementById('modal-dob').value = student.date_of_birth || '';
            document.getElementById('modal-gender').value = student.gender || 'Male';
            document.getElementById('modal-passport').value = student.passport_nid_number || '';
            document.getElementById('modal-phone').value = student.phone || '';
            document.getElementById('modal-address').value = student.address || '';

            const distSel = document.getElementById('modal-district-select');
            if (distSel) {
                distSel.value = student.district || '';
                populateModalThana(student.district, student.upazila);
            }

            document.getElementById('modal-course-id').value = student.course_id || '';
            document.getElementById('modal-duration').value = student.duration || "6 Month's";
            document.getElementById('modal-session').value = student.session || '';
            document.getElementById('modal-education').value = student.education_qualification || '';
            document.getElementById('modal-admitted-at').value = student.admitted_at || '';
            document.getElementById('modal-expire-date').value = student.expire_date || '';
            document.getElementById('modal-created-at').value = student.created_at || '2026-07-22T15:47:56.202Z';

            if (document.getElementById('modal-full-mark')) document.getElementById('modal-full-mark').value = student.full_marks || '';
            if (document.getElementById('modal-written-marks')) document.getElementById('modal-written-marks').value = student.written_marks || '';
            if (document.getElementById('modal-viva-marks')) document.getElementById('modal-viva-marks').value = student.viva_marks || '';
            if (document.getElementById('modal-practical-mark')) document.getElementById('modal-practical-mark').value = student.practical_marks || '';
            if (document.getElementById('modal-total-marks')) document.getElementById('modal-total-marks').value = student.score || '';
            if (document.getElementById('modal-letter-grade')) document.getElementById('modal-letter-grade').value = student.grade || '';
            if (document.getElementById('modal-cgpa')) document.getElementById('modal-cgpa').value = student.cgpa || '';
            if (document.getElementById('modal-pub-date')) document.getElementById('modal-pub-date').value = student.publication_date || '';
            if (document.getElementById('modal-exam-month')) document.getElementById('modal-exam-month').value = student.examination_month || '';
            if (document.getElementById('modal-session-disp')) document.getElementById('modal-session-disp').value = student.session || '';

            if (student.semesters) {
                const semKeys = ['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'];
                semKeys.forEach((sem, idx) => {
                    const semData = student.semesters[`${sem} Semester`] || student.semesters[sem] || student.semesters[`${sem} semester`];
                    if (semData) {
                        const cgpaIn = document.getElementById(`modal-sem-cgpa-${idx}`);
                        const gradeIn = document.getElementById(`modal-sem-grade-${idx}`);
                        if (cgpaIn) cgpaIn.value = semData.cgpa || '';
                        if (gradeIn) gradeIn.value = semData.grade || '';
                    }
                });
            }

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function calcModalSemGrade(idx) {
            const cgpaInput = document.getElementById(`modal-sem-cgpa-${idx}`);
            const gradeSelect = document.getElementById(`modal-sem-grade-${idx}`);
            if (!cgpaInput || !gradeSelect) return;

            const val = parseFloat(cgpaInput.value);
            if (isNaN(val)) {
                gradeSelect.value = '';
                return;
            }

            if (val >= 4.00) gradeSelect.value = 'A+';
            else if (val >= 3.75) gradeSelect.value = 'A';
            else if (val >= 3.50) gradeSelect.value = 'A-';
            else if (val >= 3.25) gradeSelect.value = 'B+';
            else if (val >= 3.00) gradeSelect.value = 'B';
            else if (val >= 2.75) gradeSelect.value = 'B-';
            else if (val >= 2.50) gradeSelect.value = 'C+';
            else if (val >= 2.25) gradeSelect.value = 'C';
            else if (val >= 2.00) gradeSelect.value = 'D';
            else gradeSelect.value = 'F';

            calcModalOverallResult();
        }

        function calcModalOverallResult() {
            const written = parseFloat(document.getElementById('modal-written-marks')?.value || 0);
            const viva = parseFloat(document.getElementById('modal-viva-marks')?.value || 0);
            const practical = parseFloat(document.getElementById('modal-practical-mark')?.value || 0);

            // 1. Total Marks Sum
            const total = written + viva + practical;
            const totalInput = document.getElementById('modal-total-marks');
            if (totalInput) totalInput.value = total > 0 ? total : 0;

            // 2. Average CGPA from all 8 Semester CGPAs
            let totalCgpa = 0;
            let count = 0;
            for (let i = 0; i < 8; i++) {
                const semCgpaInput = document.getElementById(`modal-sem-cgpa-${i}`);
                if (semCgpaInput && semCgpaInput.value) {
                    const val = parseFloat(semCgpaInput.value);
                    if (!isNaN(val) && val > 0) {
                        totalCgpa += val;
                        count++;
                    }
                }
            }

            if (count > 0) {
                const avgCgpa = (totalCgpa / count).toFixed(2);
                const overallCgpaInput = document.getElementById('modal-cgpa');
                const gradeSelect = document.getElementById('modal-letter-grade');

                if (overallCgpaInput) overallCgpaInput.value = avgCgpa;

                if (gradeSelect) {
                    const cg = parseFloat(avgCgpa);
                    if (cg >= 4.00) gradeSelect.value = 'A+';
                    else if (cg >= 3.75) gradeSelect.value = 'A';
                    else if (cg >= 3.50) gradeSelect.value = 'A-';
                    else if (cg >= 3.25) gradeSelect.value = 'B+';
                    else if (cg >= 3.00) gradeSelect.value = 'B';
                    else if (cg >= 2.75) gradeSelect.value = 'B-';
                    else if (cg >= 2.50) gradeSelect.value = 'C+';
                    else if (cg >= 2.25) gradeSelect.value = 'C';
                    else if (cg >= 2.00) gradeSelect.value = 'D';
                    else gradeSelect.value = 'F';
                }
            }
        }

        let modalSemesterCourses = {
            '1st': [
                { code: 'CSE101', name: 'Intro to Computing', credit: 3.0, marks: '80 - 100', grade: 'A+', point: '4.00' },
                { code: 'CSE102', name: 'Discrete Math', credit: 3.0, marks: '75 - 79', grade: 'A', point: '3.75' },
                { code: 'ENG103', name: 'Comm. English', credit: 3.0, marks: '70 - 74', grade: 'A-', point: '3.50' },
                { code: 'CSE102', name: 'Comm. English', credit: 3.0, marks: '65 - 69', grade: 'B+', point: '3.25' },
                { code: 'CSE104', name: 'Engineering English', credit: 3.0, marks: '60 - 64', grade: 'B', point: '3.00' },
                { code: 'CSE104', name: 'Engineering English', credit: 3.0, marks: '55 - 59', grade: 'B-', point: '2.75' },
                { code: 'CSE105', name: 'Comm. English', credit: 3.0, marks: '50 - 54', grade: 'C+', point: '2.50' },
                { code: 'CSE106', name: 'Mathmatiic English', credit: 3.0, marks: '45 - 49', grade: 'C', point: '2.25' },
                { code: 'CSE103', name: 'Programming English', credit: 3.0, marks: '40 - 44', grade: 'D', point: '2.00' },
                { code: 'CSE103', name: 'Comm. English', credit: 3.0, marks: '0 - 39', grade: 'F', point: '0.00' }
            ],
            '2nd': [], '3rd': [], '4th': [], '5th': [], '6th': [], '7th': [], '8th': []
        };

        function getActiveSemKey() {
            const sel = document.getElementById('modal-result2-sem-select');
            return sel ? sel.value : '1st';
        }

        function switchModalResultMode(mode) {
            const btn1 = document.getElementById('modal-btn-result-mode-1');
            const btn2 = document.getElementById('modal-btn-result-mode-2');
            const sec1 = document.getElementById('modal-section-result-1');
            const sec2 = document.getElementById('modal-section-result-2');

            if (mode === 'result1') {
                if (btn1) btn1.className = 'flex-1 sm:flex-none rounded-xl px-5 py-2.5 font-black text-xs uppercase tracking-wider transition-all shadow-lg bg-indigo-600 text-white ring-2 ring-indigo-400';
                if (btn2) btn2.className = 'flex-1 sm:flex-none rounded-xl px-5 py-2.5 font-black text-xs uppercase tracking-wider transition-all shadow-lg bg-[#071c2c] text-slate-300 border border-white/10 hover:bg-[#0f2d44]';
                if (sec1) sec1.classList.remove('hidden');
                if (sec2) sec2.classList.add('hidden');
            } else {
                if (btn1) btn1.className = 'flex-1 sm:flex-none rounded-xl px-5 py-2.5 font-black text-xs uppercase tracking-wider transition-all shadow-lg bg-[#071c2c] text-slate-300 border border-white/10 hover:bg-[#0f2d44]';
                if (btn2) btn2.className = 'flex-1 sm:flex-none rounded-xl px-5 py-2.5 font-black text-xs uppercase tracking-wider transition-all shadow-lg bg-indigo-600 text-white ring-2 ring-indigo-400';
                if (sec1) sec1.classList.add('hidden');
                if (sec2) sec2.classList.remove('hidden');
                renderModalCourseList();
            }
        }

        function renderModalCourseList() {
            const sem = getActiveSemKey();
            const tbody = document.getElementById('modal-result2-course-tbody');
            const hiddenBox = document.getElementById('modal-course-hidden-inputs');
            if (!tbody) return;

            const list = modalSemesterCourses[sem] || [];
            let html = '';
            let totalCredit = 0;
            let totalPointCredit = 0;

            if (list.length === 0) {
                html = `
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-400 font-bold uppercase tracking-wider">
                            No subjects added for ${sem} semester. Click "ADD PAGE +" to add a subject.
                        </td>
                    </tr>
                `;
            } else {
                list.forEach((item, idx) => {
                    const credit = parseFloat(item.credit) || 0;
                    const point = parseFloat(item.point) || 0;
                    totalCredit += credit;
                    totalPointCredit += credit * point;

                    let badgeClass = 'bg-emerald-100 text-emerald-800';
                    if (item.grade === 'B' || item.grade === 'B-') badgeClass = 'bg-amber-100 text-amber-800';
                    if (item.grade === 'C+' || item.grade === 'C') badgeClass = 'bg-orange-100 text-orange-800';
                    if (item.grade === 'D' || item.grade === 'F') badgeClass = 'bg-rose-100 text-rose-800';

                    html += `
                        <tr class="border-b border-slate-200 hover:bg-slate-50 transition">
                            <td class="px-3 py-2 border-r border-slate-200">
                                <input type="text" value="${item.code || ''}" onchange="updateCourseItem('${sem}', ${idx}, 'code', this.value)" class="w-full bg-slate-50 border border-slate-200 rounded px-2 py-1 outline-none font-mono font-bold text-xs focus:bg-white focus:border-indigo-500">
                            </td>
                            <td class="px-3 py-2 border-r border-slate-200">
                                <input type="text" value="${item.name || ''}" onchange="updateCourseItem('${sem}', ${idx}, 'name', this.value)" class="w-full bg-slate-50 border border-slate-200 rounded px-2 py-1 outline-none font-bold text-xs focus:bg-white focus:border-indigo-500">
                            </td>
                            <td class="px-3 py-2 border-r border-slate-200 text-center">
                                <input type="number" step="0.5" min="0" value="${item.credit ?? 3.0}" onchange="updateCourseItem('${sem}', ${idx}, 'credit', this.value)" class="w-14 text-center bg-slate-50 border border-slate-200 rounded px-1 py-1 outline-none font-bold text-xs focus:bg-white focus:border-indigo-500">
                            </td>
                            <td class="px-3 py-2 border-r border-slate-200 text-center">
                                <input type="text" value="${item.marks || ''}" onchange="updateCourseItem('${sem}', ${idx}, 'marks', this.value)" class="w-20 text-center bg-slate-50 border border-slate-200 rounded px-1 py-1 outline-none text-xs focus:bg-white focus:border-indigo-500">
                            </td>
                            <td class="px-3 py-2 border-r border-slate-200 text-center">
                                <span class="inline-block px-2.5 py-0.5 rounded font-black text-xs ${badgeClass}">${item.grade || 'A+'}</span>
                            </td>
                            <td class="px-3 py-2 border-r border-slate-200 text-center">
                                <input type="number" step="0.01" min="0" max="4.00" value="${item.point ?? '4.00'}" onchange="updateCourseItem('${sem}', ${idx}, 'point', this.value)" class="w-16 text-center bg-slate-50 border border-slate-200 rounded px-1 py-1 outline-none font-bold text-xs focus:bg-white focus:border-indigo-500">
                            </td>
                            <td class="px-3 py-2 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button type="button" onclick="saveCourseRow('${sem}', ${idx})" title="Save Subject" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-2.5 py-1 font-black text-[10px] uppercase tracking-wider shadow transition active:scale-95 cursor-pointer">
                                        Save
                                    </button>
                                    <button type="button" onclick="deleteCourseRow('${sem}', ${idx})" title="Delete Subject" class="rounded-lg bg-rose-600 hover:bg-rose-700 text-white px-2.5 py-1 font-black text-[10px] uppercase tracking-wider shadow transition active:scale-95 cursor-pointer">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });
            }

            tbody.innerHTML = html;

            const finalCgpa = totalCredit > 0 ? (totalPointCredit / totalCredit).toFixed(2) : '0.00';
            const totalCreditEl = document.getElementById('modal-result2-total-credit');
            const finalCgpaEl = document.getElementById('modal-result2-final-cgpa');

            if (totalCreditEl) totalCreditEl.textContent = totalCredit.toFixed(1);
            if (finalCgpaEl) finalCgpaEl.textContent = finalCgpa;

            // Generate hidden inputs for form submission
            if (hiddenBox) {
                let hHtml = '';
                Object.keys(modalSemesterCourses).forEach(sKey => {
                    (modalSemesterCourses[sKey] || []).forEach((cItem, cIdx) => {
                        hHtml += `<input type="hidden" name="course_list[${sKey}][${cIdx}][code]" value="${cItem.code || ''}">`;
                        hHtml += `<input type="hidden" name="course_list[${sKey}][${cIdx}][name]" value="${cItem.name || ''}">`;
                        hHtml += `<input type="hidden" name="course_list[${sKey}][${cIdx}][credit]" value="${cItem.credit || 3.0}">`;
                        hHtml += `<input type="hidden" name="course_list[${sKey}][${cIdx}][marks]" value="${cItem.marks || ''}">`;
                        hHtml += `<input type="hidden" name="course_list[${sKey}][${cIdx}][grade]" value="${cItem.grade || 'A+'}">`;
                        hHtml += `<input type="hidden" name="course_list[${sKey}][${cIdx}][point]" value="${cItem.point || '4.00'}">`;
                    });
                });
                hiddenBox.innerHTML = hHtml;
            }
        }

        function updateCourseItem(sem, idx, key, val) {
            if (modalSemesterCourses[sem] && modalSemesterCourses[sem][idx]) {
                modalSemesterCourses[sem][idx][key] = val;
                if (key === 'point') {
                    const pt = parseFloat(val);
                    if (pt >= 4.00) modalSemesterCourses[sem][idx].grade = 'A+';
                    else if (pt >= 3.75) modalSemesterCourses[sem][idx].grade = 'A';
                    else if (pt >= 3.50) modalSemesterCourses[sem][idx].grade = 'A-';
                    else if (pt >= 3.25) modalSemesterCourses[sem][idx].grade = 'B+';
                    else if (pt >= 3.00) modalSemesterCourses[sem][idx].grade = 'B';
                    else if (pt >= 2.75) modalSemesterCourses[sem][idx].grade = 'B-';
                    else if (pt >= 2.50) modalSemesterCourses[sem][idx].grade = 'C+';
                    else if (pt >= 2.25) modalSemesterCourses[sem][idx].grade = 'C';
                    else if (pt >= 2.00) modalSemesterCourses[sem][idx].grade = 'D';
                    else modalSemesterCourses[sem][idx].grade = 'F';
                }
                renderModalCourseList();
            }
        }

        function addModalCourseRow() {
            const sem = getActiveSemKey();
            if (!modalSemesterCourses[sem]) modalSemesterCourses[sem] = [];
            modalSemesterCourses[sem].push({
                code: 'CSE10' + (modalSemesterCourses[sem].length + 1),
                name: 'New Course Name',
                credit: 3.0,
                marks: '80 - 100',
                grade: 'A+',
                point: '4.00'
            });
            renderModalCourseList();
        }

        function saveCourseRow(sem, idx) {
            renderModalCourseList();
            const alertNote = document.getElementById('modal-course-save-note');
            if (alertNote) {
                alertNote.classList.remove('hidden');
                setTimeout(() => alertNote.classList.add('hidden'), 3000);
            }
        }

        function deleteCourseRow(sem, idx) {
            if (modalSemesterCourses[sem] && modalSemesterCourses[sem][idx] !== undefined) {
                modalSemesterCourses[sem].splice(idx, 1);
                renderModalCourseList();
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('edit-student-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function populateModalThana(district, selectedUpazila) {
            const upSel = document.getElementById('modal-upazila-select');
            if (!upSel) return;
            upSel.innerHTML = '<option value="">Select Thana</option>';
            if (district && modalUpazilasByDistrict[district]) {
                modalUpazilasByDistrict[district].forEach(u => {
                    const opt = document.createElement('option');
                    opt.value = u;
                    opt.textContent = u;
                    if (selectedUpazila && u === selectedUpazila) {
                        opt.selected = true;
                    }
                    upSel.appendChild(opt);
                });
            } else if (selectedUpazila) {
                const opt = document.createElement('option');
                opt.value = selectedUpazila;
                opt.textContent = selectedUpazila;
                opt.selected = true;
                upSel.appendChild(opt);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const distSel = document.getElementById('modal-district-select');
            if (distSel) {
                distSel.addEventListener('change', function() {
                    populateModalThana(this.value, null);
                });
            }
        });

        function previewModalAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('modal-avatar-preview');
                    if (preview) preview.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

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

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
                                <th class="px-4 py-4 text-center">STUDENT ID</th>
                                <th class="px-4 py-4 text-center">STUDENT REGISTRATION NUMBER</th>
                                <th class="px-4 py-4 text-center">STUDENT ROLL NUMBER</th>
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
                                        'institute_name' => $student->institute_name ?: ($student->branch?->institute_name ?? 'BNTEI'),
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

                                    {{-- STUDENT ID --}}
                                    <td class="px-4 py-4 text-slate-300 font-mono">{{ str_pad($student->id, 6, '0', STR_PAD_LEFT) }}</td>

                                    {{-- STUDENT REGISTRATION NUMBER --}}
                                    <td class="px-4 py-4 text-slate-300 font-mono">{{ $student->registration_number }}</td>

                                    {{-- STUDENT ROLL NUMBER --}}
                                    <td class="px-4 py-4 text-slate-300 font-mono">{{ $student->roll_number }}</td>

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
    <div id="edit-student-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="relative w-full max-w-3xl rounded-3xl border border-white/10 bg-[#0e1828] p-6 lg:p-10 shadow-2xl space-y-8 my-8">

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
                        <label class="{{ $modalLabelClass }}">Picture</label>
                        <input type="text" id="modal-picture-url" readonly class="{{ $modalInputClass }} cursor-not-allowed text-slate-400">
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

                <!-- ACADEMIC DETAILS (PER SEMESTER) -->
                <div class="space-y-4 pt-6 border-t border-white/10">
                    <div>
                        <h3 class="text-base font-black text-slate-200 uppercase tracking-wide">Academic Details (Per Semester)</h3>
                        <p class="text-xs text-slate-400 font-medium">Enter the **CGPA (0.00-4.00)** for each semester, and the Grade will be automatically selected based on the grade point.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'] as $sem)
                            <div class="rounded-2xl border border-white/10 bg-[#071c2c]/80 p-4 space-y-3">
                                <h4 class="text-xs font-black text-[#818cf8] uppercase tracking-wider">{{ $sem }} Semester</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-1">Grade (Auto-Calculated)</label>
                                    <select name="semesters[{{ $sem }}][grade]" class="{{ $modalSelectClass }} py-2 text-xs">
                                        <option value="">Select Grade</option>
                                        <option value="A+">A+</option>
                                        <option value="A">A</option>
                                        <option value="A-">A-</option>
                                        <option value="B">B</option>
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
                    <h3 class="text-base font-black text-slate-200 uppercase tracking-wide">Final Result (Overall)</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="{{ $modalLabelClass }}">Full Mark</label>
                            <input type="text" name="full_mark" id="modal-full-mark" placeholder="Full Mark" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Written Marks</label>
                            <input type="text" name="written_marks" id="modal-written-marks" placeholder="Written Marks" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Viva Marks</label>
                            <input type="text" name="viva_marks" id="modal-viva-marks" placeholder="Viva Marks" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Practical Mark</label>
                            <input type="text" name="practical_mark" id="modal-practical-mark" placeholder="Practical Mark" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Total Marks</label>
                            <input type="text" name="total_marks" id="modal-total-marks" value="0" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Letter Grade</label>
                            <select name="letter_grade" id="modal-letter-grade" class="{{ $modalSelectClass }}">
                                <option value="">Select Grade</option>
                                <option value="A+">A+</option>
                                <option value="A">A</option>
                                <option value="A-">A-</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">CGPA (Overall)</label>
                            <input type="text" name="cgpa" id="modal-cgpa" placeholder="CGPA" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Publication Date</label>
                            <input type="date" name="publication_date" id="modal-pub-date" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Examination Month</label>
                            <input type="text" name="examination_month" id="modal-exam-month" placeholder="Examination Month" class="{{ $modalInputClass }}">
                        </div>
                        <div>
                            <label class="{{ $modalLabelClass }}">Session (Display)</label>
                            <input type="text" name="session_display" id="modal-session-disp" placeholder="Jan 2024 - Dec 2024" class="{{ $modalInputClass }}">
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

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
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

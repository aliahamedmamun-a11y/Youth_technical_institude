<x-dashboard-shell title="Branch Students">
    <div class="mx-auto max-w-[1800px]">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-6 sm:p-8 shadow-2xl backdrop-blur-sm lg:p-10 space-y-8">

            <!-- Header & Back Navigation -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-white/10 pb-6">
                <div>
                    <a href="{{ route('super-admin.students.index', ['show_branches' => 1]) }}"
                       class="inline-flex items-center gap-2 text-xs font-black uppercase text-blue-400 hover:text-blue-300 transition-colors mb-2">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                        </svg>
                        <span>Back to All Branches</span>
                    </a>
                    <h1 class="text-2xl sm:text-3xl font-black text-white uppercase tracking-tight">
                        {{ $branch?->institute_name ?? 'Branch ID: ' . $branchId }}
                    </h1>
                    <p class="text-xs font-bold text-slate-300">
                        Total Registered Students: <span class="text-emerald-400 font-black">{{ $students->total() }}</span>
                    </p>
                </div>

                <a href="{{ route('super-admin.students.create') }}" class="rounded-xl bg-indigo-600 hover:bg-indigo-500 px-6 py-3 text-xs font-black uppercase text-white shadow-lg transition">
                    + Add New Student
                </a>
            </div>

            <!-- Search Bar -->
            <div class="mx-auto max-w-xl">
                <form method="GET" action="{{ route('super-admin.students.index') }}" class="relative">
                    <input type="hidden" name="branch_id" value="{{ $branchId }}">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search by Roll Number, Name or Reg Number..."
                        class="w-full rounded-2xl border border-white/10 bg-[#071c2c]/70 py-3.5 pl-12 pr-6 text-sm text-white placeholder-slate-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all shadow-xl">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                </form>
            </div>

            <!-- Student Table -->
            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
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
                                <th class="px-4 py-4 text-center">CERT STATUS</th>
                                <th class="px-4 py-4 text-center">TRANS-ONE STATUS</th>
                                <th class="px-4 py-4 text-center">BRANCH PERM</th>
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
                                            Transcript Two
                                        </a>
                                    </td>

                                    {{-- CERT STATUS --}}
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('super-admin.students.documents.show', [$student, 'student-id']) }}"
                                           onclick="downloadPdf(event, this.href)"
                                           class="inline-block rounded-lg bg-purple-600 hover:bg-purple-500 px-3 py-1.5 text-[10px] font-black text-white uppercase shadow transition">
                                            NIDCard
                                        </a>
                                    </td>

                                    {{-- TRANS-ONE STATUS --}}
                                    <td class="px-4 py-4 text-center">
                                        <span class="rounded-full bg-pink-500/20 px-3 py-1 text-[9px] font-black uppercase text-pink-300">NOT ALLOWED</span>
                                    </td>

                                    {{-- BRANCH PERM --}}
                                    <td class="px-4 py-4 text-center">
                                        <span class="rounded-full bg-pink-500/20 px-3 py-1 text-[9px] font-black uppercase text-pink-300">NOT ALLOWED</span>
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

            <!-- Pagination -->
            @if($students->hasPages())
                <div class="mt-8">
                    {{ $students->links() }}
                </div>
            @endif

        </div>
    </div>

    <!-- EDIT STUDENT INFORMATION MODAL OVERLAY -->
    <div id="edit-student-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-2 sm:p-4">
        <div class="relative w-full max-w-3xl max-h-[92vh] overflow-y-auto rounded-3xl border border-white/10 bg-[#0e1828] p-4 sm:p-6 lg:p-10 shadow-2xl space-y-6 sm:space-y-8 my-auto">

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

                    <!-- Created At -->
                    <div class="md:col-span-2">
                        <label class="{{ $modalLabelClass }}">Created At</label>
                        <input type="text" id="modal-created-at" readonly class="{{ $modalInputClass }} cursor-not-allowed text-slate-400">
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

            document.getElementById('modal-avatar-preview').src = student.image_url || 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg';
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

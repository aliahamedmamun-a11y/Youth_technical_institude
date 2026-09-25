<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information | BNYTI</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#070d19] min-h-screen p-4 sm:p-8 text-white font-sans">

<div class="max-w-6xl mx-auto">

    <!-- Card Container -->
    <div class="rounded-3xl border border-white/10 bg-[#0e1828] p-6 lg:p-10 shadow-2xl space-y-10">

        <!-- Title -->
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#818cf8] text-center uppercase tracking-tight">
                Edit Student Information
            </h1>
        </div>

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-5 text-rose-300 text-sm">
                <ul class="list-disc pl-5 space-y-1 font-bold">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('students.update', $student) }}" class="space-y-10">
            @csrf
            @method('PUT')

            <!-- SECTION 1: BASIC STUDENT DETAILS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Branch Id -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Branch Id</label>
                    <input type="text" name="branch_id" value="{{ old('branch_id', $student->branch_id ?? '198305') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Student Id -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Student Id</label>
                    <input type="text" name="student_id_display" value="{{ str_pad($student->id ?? 36592, 6, '0', STR_PAD_LEFT) }}" readonly
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none cursor-not-allowed">
                </div>

                <!-- Student Registration Number -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Student Registration Number</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number', $student->registration_number ?? '50936928') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Student Roll Number -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Student Roll Number</label>
                    <input type="text" name="roll_number" value="{{ old('roll_number', $student->roll_number ?? '906940') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Student Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Student Name</label>
                    <input type="text" name="name" value="{{ old('name', $student->name ?? 'Juwel') }}" required
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Father Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Father Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $student->father_name ?? 'Gaijuddin Ahammed') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Mother Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Mother Name</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $student->mother_name ?? 'Monowara Begum') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Dob -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Dob</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d') ?: '1973-11-16') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Gender</label>
                    <select name="gender" class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                        <option value="Male" @selected(old('gender', $student->gender) === 'Male')>Male</option>
                        <option value="Female" @selected(old('gender', $student->gender) === 'Female')>Female</option>
                        <option value="Other" @selected(old('gender', $student->gender) === 'Other')>Other</option>
                    </select>
                </div>

                <!-- Passport -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Passport</label>
                    <input type="text" name="passport_nid_number" value="{{ old('passport_nid_number', $student->passport_nid_number) }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Guardian Phone -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Guardian Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $student->phone) }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Student Address -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Student Address</label>
                    <input type="text" name="address" value="{{ old('address', $student->address) }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- District -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">District</label>
                    <select name="district" id="district-select" class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                        <option value="">Select District</option>
                        @foreach(config('bangladesh.districts') as $dist)
                            <option value="{{ $dist }}" @selected(old('district', $student->district ?: 'Manikganj') === $dist)>{{ $dist }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Thana -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Thana</label>
                    <select name="upazila" id="upazila-select" class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                        <option value="{{ old('upazila', $student->upazila ?: 'Manikganj Sadar') }}">{{ old('upazila', $student->upazila ?: 'Manikganj Sadar') }}</option>
                    </select>
                </div>

                <!-- Search Course -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Search Course</label>
                    <select name="course_id" class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                        <option value="">Select Course</option>
                        @foreach($courses ?? [] as $crs)
                            <option value="{{ $crs->id }}" @selected(old('course_id', $student->course_id) == $crs->id)>{{ $crs->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Duration -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Duration</label>
                    <select name="duration" class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                        @foreach(['3 Months', '6 Months', '1 Year', '2 Years', '4 Years'] as $dur)
                            <option value="{{ $dur }}" @selected(old('duration', $student->duration ?: '1 Year') === $dur)>{{ $dur }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Session -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Session</label>
                    <input type="text" name="session" value="{{ old('session', $student->session ?: 'Jan - Dec 2021') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Education Qualification -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Education Qualification</label>
                    <input type="text" name="education_qualification" value="{{ old('education_qualification', $student->education_qualification) }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Expire Date -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Expire Date</label>
                    <input type="date" name="expire_date" value="{{ old('expire_date', optional($student->expire_date)->format('Y-m-d') ?: '2026-09-24') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Director Name -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Director Name</label>
                    <input type="text" name="director_name" value="{{ old('director_name', $student->director_name ?? '') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

                <!-- Created At -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Created At</label>
                    <input type="text" value="{{ $student->created_at?->toISOString() ?: '2026-09-24T07:50:05.898Z' }}" readonly
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-slate-400 outline-none cursor-not-allowed">
                </div>

                <!-- Picture -->
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Picture</label>
                    <input type="text" name="picture" value="{{ old('picture', $student->image_path ? asset('storage/'.$student->image_path) : 'https://i.ibb.co/qMgPTvMQ/1000072415.jpg') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
                </div>

            </div>

            <!-- SECTION 2: ADD SUBJECTS -->
            <div class="pt-6 border-t border-white/10 space-y-6">
                <h2 class="text-xl font-black text-[#818cf8] uppercase tracking-tight">Add Subjects</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Select Semester</label>
                        <select id="select-semester-dropdown" onchange="updateAddSubjectBtnLabel()"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all">
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
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Subject Names (One Per Line)</label>
                        <textarea id="subject-names-input" rows="3" placeholder="Enter subject names here, each on a new line."
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3 px-4 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all"></textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="handleAddSubjectClick()"
                        class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-8 py-3.5 font-black text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                        Add Subjects for <span id="add-sub-btn-sem">1st</span> Semester
                    </button>
                </div>
            </div>

            <!-- SECTION 3: SUBJECT PREVIEW -->
            <div class="pt-6 border-t border-white/10 space-y-4">
                <h2 class="text-xl font-black text-[#818cf8] uppercase tracking-tight">Subject Preview</h2>

                <div class="overflow-hidden rounded-2xl border border-white/10 bg-[#071c2c]/40">
                    <table class="w-full text-left text-sm text-white">
                        <thead class="bg-[#071c2c] text-xs font-black uppercase tracking-widest text-slate-400 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4">Subject</th>
                                <th class="px-6 py-4">Semester</th>
                                <th class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="subject-preview-body" class="divide-y divide-white/5">
                            <tr id="empty-subjects-row">
                                <td colspan="3" class="px-6 py-8 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">
                                    No subjects added yet
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 4: ACADEMIC DETAILS (PER SEMESTER) -->
            <div class="pt-6 border-t border-white/10 space-y-4">
                <h2 class="text-xl font-black text-[#818cf8] uppercase tracking-tight">Academic Details (Per Semester)</h2>
                <p class="text-xs font-bold text-slate-400">
                    Enter the <strong class="text-white">**CGPA (0.00-4.00)**</strong> for each semester, and the Grade will be automatically selected based on the grade point.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach(['1st', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th'] as $idx => $semLabel)
                        <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-3">
                            <h3 class="text-sm font-black text-indigo-400 uppercase tracking-wider">{{ $semLabel }} Semester</h3>
                            <input type="number" step="0.01" min="0" max="4.00" name="semester_cgpa[{{ $semLabel }}]" id="sem-cgpa-{{ $idx }}"
                                oninput="autoCalculateSemesterGrade({{ $idx }})" placeholder="CGPA"
                                class="w-full rounded-xl border border-white/10 bg-[#070d19] py-3 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">

                            <div>
                                <label class="block text-[11px] font-bold text-slate-400 mb-1.5 uppercase tracking-wider">Grade (Auto-Calculated)</label>
                                <select name="semester_grade[{{ $semLabel }}]" id="sem-grade-{{ $idx }}"
                                    class="w-full rounded-xl border border-white/10 bg-[#070d19] py-3 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
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

            <!-- SECTION 5: FINAL RESULT (OVERALL) -->
            <div class="pt-6 border-t border-white/10 space-y-6">
                <h2 class="text-xl font-black text-[#818cf8] uppercase tracking-tight">Final Result (Overall)</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Full Mark -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Full Mark</label>
                        <input type="number" name="full_marks" value="{{ old('full_marks', $student->full_marks ?? 1200) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Written Marks -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Written Marks</label>
                        <input type="number" name="written_marks" id="written-marks-input" oninput="calculateTotalMarks()"
                            value="{{ old('written_marks', $student->written_marks ?? 720) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Viva Marks -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Viva Marks</label>
                        <input type="number" name="viva_marks" id="viva-marks-input" oninput="calculateTotalMarks()"
                            value="{{ old('viva_marks', $student->viva_marks ?? 72) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Practical Mark -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Practical Mark</label>
                        <input type="number" name="practical_marks" id="practical-marks-input" oninput="calculateTotalMarks()"
                            value="{{ old('practical_marks', $student->practical_marks ?? 74) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Total Marks -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Total Marks</label>
                        <input type="number" name="score" id="total-marks-input" value="{{ old('score', $student->score ?? 866) }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Letter Grade -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Letter Grade</label>
                        <select name="grade" id="overall-grade-select"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                            <option value="">Select Grade</option>
                            <option value="A+" @selected(old('grade', $student->grade ?? 'A') === 'A+')>A+</option>
                            <option value="A" @selected(old('grade', $student->grade ?? 'A') === 'A')>A</option>
                            <option value="A-" @selected(old('grade', $student->grade) === 'A-')>A-</option>
                            <option value="B+" @selected(old('grade', $student->grade) === 'B+')>B+</option>
                            <option value="B" @selected(old('grade', $student->grade) === 'B')>B</option>
                            <option value="B-" @selected(old('grade', $student->grade) === 'B-')>B-</option>
                            <option value="C+" @selected(old('grade', $student->grade) === 'C+')>C+</option>
                            <option value="C" @selected(old('grade', $student->grade) === 'C')>C</option>
                            <option value="D" @selected(old('grade', $student->grade) === 'D')>D</option>
                            <option value="F" @selected(old('grade', $student->grade) === 'F')>F</option>
                        </select>
                    </div>

                    <!-- CGPA (Overall) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">CGPA (Overall)</label>
                        <input type="number" step="0.01" name="cgpa" id="overall-cgpa-input" value="{{ old('cgpa', $student->cgpa ?? '3.75') }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Publication Date -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Publication Date</label>
                        <input type="text" name="publication_date" value="{{ old('publication_date', $student->publication_date ?? '15-Feb-2022') }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Examination Month -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Examination Month</label>
                        <input type="text" name="examination_month" value="{{ old('examination_month', $student->examination_month ?? '15 Dec 2021') }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>

                    <!-- Session (Display) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider">Session (Display)</label>
                        <input type="text" name="session_display" value="{{ old('session_display', $student->session ?? 'Jan - Dec 2021') }}"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white focus:border-indigo-500 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex items-center justify-end gap-4 pt-8 border-t border-white/10">
                <a href="{{ route('students.index') }}"
                    class="rounded-xl bg-[#334155] hover:bg-[#475569] text-white px-8 py-3.5 font-black text-sm uppercase tracking-wider transition-all">
                    Cancel
                </a>
                <button type="submit"
                    class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-10 py-3.5 font-black text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                    Save Changes
                </button>
            </div>

        </form>

    </div>

</div>

<!-- JAVASCRIPT LOGIC FOR DYNAMIC FUNCTIONALITY -->
<script>
    const upazilasByDistrict = @json(config('bangladesh.upazilas'));
    let subjectsList = [];

    document.addEventListener('DOMContentLoaded', () => {
        // District/Thana Cascading
        const distSelect = document.getElementById('district-select');
        const upSelect = document.getElementById('upazila-select');

        if (distSelect && upSelect) {
            distSelect.addEventListener('change', function() {
                const selectedDistrict = this.value;
                upSelect.innerHTML = '<option value="">Select Thana</option>';
                if (selectedDistrict && upazilasByDistrict[selectedDistrict]) {
                    upazilasByDistrict[selectedDistrict].forEach(u => {
                        const opt = document.createElement('option');
                        opt.value = u;
                        opt.textContent = u;
                        upSelect.appendChild(opt);
                    });
                }
            });
        }

        updateAddSubjectBtnLabel();
    });

    function updateAddSubjectBtnLabel() {
        const dropdown = document.getElementById('select-semester-dropdown');
        const labelSpan = document.getElementById('add-sub-btn-sem');
        if (dropdown && labelSpan) {
            labelSpan.textContent = dropdown.value;
        }
    }

    function handleAddSubjectClick() {
        const dropdown = document.getElementById('select-semester-dropdown');
        const textarea = document.getElementById('subject-names-input');
        if (!dropdown || !textarea) return;

        const semester = dropdown.value;
        const text = textarea.value.trim();
        if (!text) return;

        const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);
        lines.forEach(line => {
            subjectsList.push({ subject: line, semester: semester });
        });

        textarea.value = '';
        renderSubjectsPreview();
    }

    function removeSubjectItem(index) {
        subjectsList.splice(index, 1);
        renderSubjectsPreview();
    }

    function renderSubjectsPreview() {
        const tbody = document.getElementById('subject-preview-body');
        if (!tbody) return;

        if (subjectsList.length === 0) {
            tbody.innerHTML = `
                <tr id="empty-subjects-row">
                    <td colspan="3" class="px-6 py-8 text-center text-xs font-bold text-slate-500 uppercase tracking-widest">
                        No subjects added yet
                    </td>
                </tr>`;
            return;
        }

        let html = '';
        subjectsList.forEach((item, idx) => {
            html += `
                <tr class="hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 font-bold text-white">${item.subject}</td>
                    <td class="px-6 py-4 font-bold text-slate-300">${item.semester}</td>
                    <td class="px-6 py-4 text-center">
                        <input type="hidden" name="subjects[${idx}][name]" value="${item.subject}">
                        <input type="hidden" name="subjects[${idx}][semester]" value="${item.semester}">
                        <button type="button" onclick="removeSubjectItem(${idx})" class="text-rose-500 hover:text-rose-400 font-black text-xs uppercase tracking-wider transition-colors">
                            Delete
                        </button>
                    </td>
                </tr>`;
        });

        tbody.innerHTML = html;
    }

    function autoCalculateSemesterGrade(idx) {
        const cgpaInput = document.getElementById(`sem-cgpa-${idx}`);
        const gradeSelect = document.getElementById(`sem-grade-${idx}`);
        if (!cgpaInput || !gradeSelect) return;

        const val = parseFloat(cgpaInput.value);
        if (isNaN(val)) {
            gradeSelect.value = '';
            return;
        }

        if (val >= 3.75) gradeSelect.value = 'A+';
        else if (val >= 3.50) gradeSelect.value = 'A';
        else if (val >= 3.25) gradeSelect.value = 'A-';
        else if (val >= 3.00) gradeSelect.value = 'B+';
        else if (val >= 2.75) gradeSelect.value = 'B';
        else if (val >= 2.50) gradeSelect.value = 'B-';
        else if (val >= 2.25) gradeSelect.value = 'C+';
        else if (val >= 2.00) gradeSelect.value = 'C';
        else if (val >= 1.00) gradeSelect.value = 'D';
        else gradeSelect.value = 'F';

        updateOverallCgpaAndGrade();
    }

    function calculateTotalMarks() {
        const written = parseFloat(document.getElementById('written-marks-input')?.value || 0);
        const viva = parseFloat(document.getElementById('viva-marks-input')?.value || 0);
        const practical = parseFloat(document.getElementById('practical-marks-input')?.value || 0);

        const totalInput = document.getElementById('total-marks-input');
        if (totalInput) {
            totalInput.value = written + viva + practical;
        }
    }

    function updateOverallCgpaAndGrade() {
        let totalCgpa = 0;
        let count = 0;

        for (let i = 0; i < 8; i++) {
            const input = document.getElementById(`sem-cgpa-${i}`);
            if (input && input.value) {
                const val = parseFloat(input.value);
                if (!isNaN(val)) {
                    totalCgpa += val;
                    count++;
                }
            }
        }

        if (count > 0) {
            const avgCgpa = (totalCgpa / count).toFixed(2);
            const overallCgpaInput = document.getElementById('overall-cgpa-input');
            const overallGradeSelect = document.getElementById('overall-grade-select');

            if (overallCgpaInput) overallCgpaInput.value = avgCgpa;

            if (overallGradeSelect) {
                if (avgCgpa >= 3.75) overallGradeSelect.value = 'A+';
                else if (avgCgpa >= 3.50) overallGradeSelect.value = 'A';
                else if (avgCgpa >= 3.25) overallGradeSelect.value = 'A-';
                else if (avgCgpa >= 3.00) overallGradeSelect.value = 'B+';
                else if (avgCgpa >= 2.75) overallGradeSelect.value = 'B';
                else if (avgCgpa >= 2.50) overallGradeSelect.value = 'B-';
                else if (avgCgpa >= 2.25) overallGradeSelect.value = 'C+';
                else if (avgCgpa >= 2.00) overallGradeSelect.value = 'C';
                else if (avgCgpa >= 1.00) overallGradeSelect.value = 'D';
                else overallGradeSelect.value = 'F';
            }
        }
    }
</script>

</body>
</html>

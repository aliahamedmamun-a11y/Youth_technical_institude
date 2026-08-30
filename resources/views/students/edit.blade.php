<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Student | BNYTI</title>

    @vite(['resources/css/app.css'])

</head>


<body class="bg-gray-100 min-h-screen p-6">


<div class="max-w-5xl mx-auto">


    <!-- Header -->

    <div class="bg-green-700 text-white rounded-2xl shadow-lg p-6 mb-6">

        <h1 class="text-3xl font-black">
            Edit Student Information
        </h1>

        <p class="text-green-100 mt-2">
            Update student registration information
        </p>

    </div>


    <!-- Validation Errors -->

    @if($errors->any())

        <div class="bg-red-100 border border-red-300 text-red-700 rounded-xl p-5 mb-6">

            <ul class="list-disc pl-5">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <!-- Edit Form -->

    <form
        method="POST"
        action="{{ route('students.update', $student) }}"
        class="bg-white rounded-2xl shadow p-6">

        @csrf

        @method('PUT')


        <div class="grid md:grid-cols-2 gap-5">


            <!-- Student Name -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Student Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $student->name) }}"
                    required
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Registration Number -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Registration Number
                </label>

                <input
                    type="text"
                    value="{{ $student->registration_number }}"
                    readonly
                    class="w-full border rounded-xl px-4 py-3 bg-gray-100">

            </div>


            <!-- Roll Number -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Roll Number
                </label>

                <input
                    type="text"
                    name="roll_number"
                    value="{{ old('roll_number', $student->roll_number) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Father Name -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Father Name
                </label>

                <input
                    type="text"
                    name="father_name"
                    value="{{ old('father_name', $student->father_name) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Mother Name -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Mother Name
                </label>

                <input
                    type="text"
                    name="mother_name"
                    value="{{ old('mother_name', $student->mother_name) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Phone -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Phone
                </label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $student->phone) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Email -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Email
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $student->email) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Gender -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Gender
                </label>

                <input
                    type="text"
                    name="gender"
                    value="{{ old('gender', $student->gender) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Date Of Birth -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Date of Birth
                </label>

                <input
                    type="date"
                    name="date_of_birth"
                    value="{{ old('date_of_birth', optional($student->date_of_birth)->format('Y-m-d')) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- District -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    District
                </label>

                <input
                    type="text"
                    name="district"
                    value="{{ old('district', $student->district) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Upazila -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Upazila
                </label>

                <input
                    type="text"
                    name="upazila"
                    value="{{ old('upazila', $student->upazila) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Passport / NID -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Passport / NID
                </label>

                <input
                    type="text"
                    name="passport_nid_number"
                    value="{{ old('passport_nid_number', $student->passport_nid_number) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Education Qualification -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Education Qualification
                </label>

                <input
                    type="text"
                    name="education_qualification"
                    value="{{ old('education_qualification', $student->education_qualification) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Start Month -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Start Month
                </label>

                <select
                    name="start_month"
                    class="w-full border rounded-xl px-4 py-3">

                    <option value="">Select Start Month</option>

                    @foreach([
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    ] as $month)

                        <option
                            value="{{ $month }}"
                            @selected(old('start_month', $student->start_month) === $month)>
                            {{ $month }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- End Month -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    End Month
                </label>

                <select
                    name="end_month"
                    class="w-full border rounded-xl px-4 py-3">

                    <option value="">Select End Month</option>

                    @foreach([
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    ] as $month)

                        <option
                            value="{{ $month }}"
                            @selected(old('end_month', $student->end_month) === $month)>
                            {{ $month }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- Start Year -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Start Year
                </label>

                <input
                    type="number"
                    name="start_year"
                    value="{{ old('start_year', $student->start_year) }}"
                    min="1900"
                    max="2100"
                    placeholder="Example: 2026"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- End Year -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    End Year
                </label>

                <input
                    type="number"
                    name="end_year"
                    value="{{ old('end_year', $student->end_year) }}"
                    min="1900"
                    max="2100"
                    placeholder="Example: 2027"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Session -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Session
                </label>

                <input
                    type="text"
                    name="session"
                    value="{{ old('session', $student->session) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Admitted At -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Admitted At
                </label>

                <input
                    type="date"
                    name="admitted_at"
                    value="{{ old('admitted_at', optional($student->admitted_at)->format('Y-m-d')) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Expire Date -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Expire Date
                </label>

                <input
                    type="date"
                    name="expire_date"
                    value="{{ old('expire_date', optional($student->expire_date)->format('Y-m-d')) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Result Status -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Result Status
                </label>

                <input
                    type="text"
                    name="result_status"
                    value="{{ old('result_status', $student->result_status) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Grade -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Grade
                </label>

                <input
                    type="text"
                    name="grade"
                    value="{{ old('grade', $student->grade) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Score -->

            <div>

                <label class="block text-sm font-bold mb-2">
                    Score
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="score"
                    value="{{ old('score', $student->score) }}"
                    class="w-full border rounded-xl px-4 py-3">

            </div>


            <!-- Address -->

            <div class="md:col-span-2">

                <label class="block text-sm font-bold mb-2">
                    Address
                </label>

                <textarea
                    name="address"
                    rows="4"
                    class="w-full border rounded-xl px-4 py-3">{{ old('address', $student->address) }}</textarea>

            </div>


        </div>


        <!-- Buttons -->

        <div class="flex gap-3 mt-8">

            <button
                type="submit"
                class="bg-green-600 text-white px-7 py-3 rounded-xl font-bold hover:bg-green-700">

                Update Student

            </button>


            <a
                href="{{ route('students.index') }}"
                class="bg-gray-700 text-white px-7 py-3 rounded-xl font-bold">

                Cancel

            </a>

        </div>


    </form>


</div>


</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Student Registration Details | BNYTI</title>

    @vite(['resources/css/app.css'])

</head>


<body class="bg-gray-100 min-h-screen p-6">


<div class="max-w-6xl mx-auto">


    <!-- Header -->

    <div class="bg-green-700 text-white rounded-2xl shadow-lg p-6 mb-6">

        <h1 class="text-3xl font-black">
            Student Registration Details
        </h1>

        <p class="text-green-100 mt-2">
            Bangladesh National Youth Technical Institute
        </p>

    </div>




    <!-- Student Details -->

    <div class="bg-white rounded-2xl shadow p-6">


        <div class="grid md:grid-cols-3 gap-8">


            <!-- Student Image -->

            <div class="flex justify-center items-start">


                @if($student->image_path)

                <img
                src="{{ asset('storage/'.$student->image_path) }}"
                class="w-56 h-56 rounded-2xl object-cover border-4 border-green-600 shadow">


                @else


                <div class="w-56 h-56 rounded-2xl bg-gray-200 flex items-center justify-center text-gray-500 font-bold">

                    No Image

                </div>


                @endif


            </div>





            <!-- Student Information -->


            <div class="md:col-span-2 grid md:grid-cols-2 gap-5">



                <div>
                    <p class="text-gray-500 text-sm">
                        Student Name
                    </p>

                    <p class="font-bold text-lg">
                        {{ $student->name }}
                    </p>
                </div>



                <div>
                    <p class="text-gray-500 text-sm">
                        Registration Number
                    </p>

                    <p class="font-bold">
                        {{ $student->registration_number }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Father Name
                    </p>

                    <p class="font-bold">
                        {{ $student->father_name }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Mother Name
                    </p>

                    <p class="font-bold">
                        {{ $student->mother_name }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Phone
                    </p>

                    <p class="font-bold">
                        {{ $student->phone }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Email
                    </p>

                    <p class="font-bold">
                        {{ $student->email ?? 'N/A' }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Course
                    </p>

                    <p class="font-bold">
                        {{ $student->course?->name ?? 'N/A' }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Session
                    </p>

                    <p class="font-bold">
                        {{ $student->session ?? 'N/A' }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Gender
                    </p>

                    <p class="font-bold">
                        {{ $student->gender ?? 'N/A' }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Date Of Birth
                    </p>

                    <p class="font-bold">
                        {{ $student->date_of_birth?->format('d M Y') ?? 'N/A' }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Education Qualification
                    </p>

                    <p class="font-bold">
                        {{ $student->education_qualification ?? 'N/A' }}
                    </p>
                </div>




                <div>
                    <p class="text-gray-500 text-sm">
                        Passport / NID
                    </p>

                    <p class="font-bold">
                        {{ $student->passport_nid_number ?? 'N/A' }}
                    </p>
                </div>




                <div class="md:col-span-2">

                    <p class="text-gray-500 text-sm">
                        Address
                    </p>

                    <p class="font-bold">
                        {{ $student->address ?? 'N/A' }}
                    </p>

                </div>



            </div>


        </div>


    </div>





    <!-- Back Button -->


    <div class="mt-6">


        <a href="{{ route('students.index') }}"
        class="bg-gray-800 text-white px-6 py-3 rounded-xl font-bold">

            ← Back To Students

        </a>


    </div>



</div>


</body>

</html>
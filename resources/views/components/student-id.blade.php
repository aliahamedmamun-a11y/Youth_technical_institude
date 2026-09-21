@props([
    'student',
    'qrCode' => null,
])

@vite(['resources/css/app.css', 'resources/css/student-id.css', 'resources/js/app.js'])

<main class="student-id-screen">
    <div class="student-id-container">
        {{-- Front Side --}}
        <article class="id-card id-card--front">
            {{-- Using the combined template image --}}
            <img src="{{ asset('images/Logo Or ID card-02.png') }}" alt="" class="id-card__template">

            <div class="id-card__content">
                <div class="id-card__photo-box">
                    @if ($student->image_path)
                        <img src="{{ asset('storage/'.$student->image_path) }}" alt="{{ $student->name }}">
                    @else
                        <div class="flex size-full items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="size-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    @endif
                </div>

                {{-- Optional: Add Name/Course on front if desired, but template seems to favor back side for info --}}
            </div>
        </article>

        {{-- Back Side --}}
        <article class="id-card id-card--back">
            <img src="{{ asset('images/Logo Or ID card-02.png') }}" alt="" class="id-card__template">

            <div class="id-card__content">
                <div class="id-card__details">
                    <dl>
                        <dt>Name</dt><dd>: {{ $student->name }}</dd>
                        <dt>Roll No</dt><dd>: {{ $student->roll_number ?? '—' }}</dd>
                        <dt>Reg No</dt><dd>: {{ $student->registration_number }}</dd>
                        <dt>Session</dt><dd>: {{ $student->session ?? '2020-2023' }}</dd>
                        <dt>Course</dt><dd>: {{ $student->course?->name ?? '—' }}</dd>
                        <dt>Blood Group</dt><dd>: {{ $student->blood_group ?? 'O+' }}</dd>
                        <dt>Father's Name</dt><dd>: {{ $student->father_name ?? '—' }}</dd>
                        <dt>Mother's Name</dt><dd>: {{ $student->mother_name ?? '—' }}</dd>
                        <dt>Phone</dt><dd>: {{ $student->phone }}</dd>
                    </dl>
                </div>

                <div class="id-card__qr-box">
                    @if($qrCode)
                        <img src="{{ $qrCode }}" alt="QR Verification">
                    @else
                        {{-- Fallback QR if none provided --}}
                        <div class="size-full bg-slate-50 flex items-center justify-center text-[8px] text-slate-300">QR CODE</div>
                    @endif
                </div>
            </div>
        </article>
    </div>

    <nav class="id-card-actions print:hidden">
        <button type="button" data-print-document onclick="window.print()" class="rounded-full bg-emerald-700 px-8 py-3 font-black text-white transition hover:bg-emerald-600 cursor-pointer">
            Print ID Card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-8 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back
        </a>
    </nav>
</main>

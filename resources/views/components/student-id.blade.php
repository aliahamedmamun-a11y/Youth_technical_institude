@props([
    'student',
    'instituteName' => 'Bangladesh National Youth Technical Institute',
    'instituteWeb' => 'www.bntei.com',
    'qrCode' => null,
])

@vite(['resources/css/app.css', 'resources/css/student-id.css', 'resources/js/app.js'])

<main class="student-id-screen">
    <div class="student-id-container">
        {{-- Front Side --}}
        <article class="id-card id-card--front">
            <div class="id-card__background">
                <svg viewBox="0 0 320 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H320V400C320 400 240 430 160 430C80 430 0 400 0 400V0Z" fill="#F8FAF4"/>
                    <path d="M0 400V500H320V400C320 400 240 430 160 430C80 430 0 400 0 400Z" fill="#1A4D2E"/>
                </svg>
            </div>

            <div class="id-card__content">
                <div class="id-card__header">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="id-card__logo">
                    <h2 class="id-card__inst-name">{{ $instituteName }}</h2>
                    <p class="id-card__inst-web">{{ $instituteWeb }}</p>
                </div>

                <div class="id-card__title-badge">STUDENT ID</div>

                <div class="id-card__photo-box">
                    @if ($student->image_path)
                        <img src="{{ asset('storage/'.$student->image_path) }}" alt="{{ $student->name }}">
                    @else
                        <div class="flex size-full items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="size-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    @endif
                </div>

                <div class="id-card__student-info">
                    <h3 class="id-card__student-name">{{ $student->name }}</h3>
                    <p class="id-card__student-course">{{ $student->course?->name }}</p>
                </div>

                <div class="id-card__footer">
                    <div class="id-card__signature">
                        <div class="id-card__sig-placeholder">Saiful</div>
                        <div class="id-card__sig-line"></div>
                        <p class="id-card__sig-label">Controller of Examinations</p>
                    </div>
                </div>
            </div>
        </article>

        {{-- Back Side --}}
        <article class="id-card id-card--back">
            <div class="id-card__background">
                <svg viewBox="0 0 320 500" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 0H320V100C320 100 240 70 160 70C80 70 0 100 0 100V0Z" fill="#1A4D2E"/>
                    <path d="M0 100V400C0 400 80 430 160 430C240 430 320 400 320 400V100C320 100 240 70 160 70C80 70 0 100 0 100Z" fill="#F8FAF4"/>
                    <path d="M0 400V500H320V400C320 400 240 430 160 430C80 430 0 400 0 400Z" fill="#1A4D2E"/>
                </svg>
            </div>

            <div class="id-card__content">
                <div class="id-card__title-badge">STUDENT INFORMATION</div>

                <dl class="id-card__details">
                    <div><dt>Student ID</dt><dd>: {{ $student->registration_number }}</dd></div>
                    <div><dt>Father's Name</dt><dd>: {{ $student->father_name }}</dd></div>
                    <div><dt>Mother's Name</dt><dd>: {{ $student->mother_name }}</dd></div>
                    <div><dt>Date of Birth</dt><dd>: {{ $student->date_of_birth?->format('d-m-Y') }}</dd></div>
                    <div><dt>Blood Group</dt><dd>: {{ $student->blood_group ?? 'O+' }}</dd></div>
                    <div><dt>Contact No</dt><dd>: {{ $student->phone }}</dd></div>
                </dl>

                <div class="id-card__instructions-badge">INSTRUCTIONS</div>
                <ul class="id-card__instructions-list">
                    <li>● This ID card is non-transferable.</li>
                    <li>● The cardholder must carry this ID card at all times in the Institute.</li>
                    <li>● This ID card must be shown when requested by the authority. If found, please return this card to the Institute office.</li>
                </ul>

                <div class="id-card__qr-box">
                    @if($qrCode)
                        <img src="{{ $qrCode }}" alt="QR">
                    @endif
                </div>

                <div class="id-card__footer-info">
                    <div class="id-card__address">
                        Address: House-52, Road-01, Dhanmondi R/A, Dhaka-1205, Bangladesh.
                    </div>
                    <div class="id-card__contact">
                        Phone:<br>+880 1717 123456<br>+880 1999 654321
                    </div>
                </div>
            </div>
        </article>
    </div>

    <nav class="id-card-actions print:hidden">
        <button type="button" data-print-document class="rounded-full bg-emerald-700 px-8 py-3 font-black text-white transition hover:bg-emerald-600">
            Print ID Card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-8 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back
        </a>
    </nav>
</main>

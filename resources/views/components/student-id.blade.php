@props([
    'student',
    'qrCode' => null,
])

@vite(['resources/css/app.css', 'resources/css/student-id.css', 'resources/js/app.js'])

<main class="student-id-screen">
    <div class="student-id-container">

        {{-- FRONT SIDE --}}
        <article class="id-card id-card--front">
            <img src="{{ asset('images/Logo Or ID card-02.png') }}" alt="ID Card Front Template" class="id-card__template id-card__template--front">

            <div class="id-card__content">
                <!-- Institute Header -->
                <div class="id-card__header text-center pt-4 px-3">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="size-10 mx-auto object-contain drop-shadow">
                    <h2 class="text-[10px] font-black uppercase text-[#03224c] tracking-tight mt-1 leading-tight">
                        South Asia Engineering & Technical Institute
                    </h2>
                    <span class="inline-block bg-[#03224c] text-white text-[8px] font-black uppercase tracking-widest px-3 py-0.5 rounded-full mt-1 shadow-sm">
                        STUDENT ID
                    </span>
                </div>

                <!-- Student Photo Frame -->
                <div class="id-card__photo-box">
                    @if ($student->image_path)
                        <img src="{{ str_starts_with($student->image_path, 'http') ? $student->image_path : asset('storage/'.$student->image_path) }}" alt="{{ $student->name }}" onerror="this.onerror=null; this.src='https://i.ibb.co/qMgPTvMQ/1000072415.jpg';">
                    @else
                        <div class="flex size-full items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="size-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    @endif
                </div>

                <!-- Student Front Info -->
                <div class="id-card__front-info text-center">
                    <h3 class="text-sm sm:text-base font-black text-[#03224c] uppercase tracking-wide truncate px-2">
                        {{ $student->name }}
                    </h3>
                    <p class="text-[10px] font-bold text-slate-600 truncate px-2">
                        {{ $student->course?->name ?? 'Technical Training Course' }}
                    </p>
                    <p class="text-[9px] font-black text-[#03224c] uppercase tracking-wider mt-1">
                        ROLL NO: {{ $student->roll_number ?: sprintf('%06d', $student->id) }}
                    </p>
                </div>
            </div>
        </article>

        {{-- BACK SIDE --}}
        <article class="id-card id-card--back">
            <img src="{{ asset('images/Logo Or ID card-02.png') }}" alt="ID Card Back Template" class="id-card__template id-card__template--back">

            <div class="id-card__content">
                <!-- Header -->
                <div class="text-center pt-3 pb-1 border-b border-slate-200/60 mx-4">
                    <h3 class="text-[9px] font-black uppercase text-[#03224c] tracking-wider">
                        South Asia Engineering & Technical Institute
                    </h3>
                </div>

                <!-- Details List -->
                <div class="id-card__details">
                    <dl>
                        <dt>NAME</dt><dd>: {{ $student->name }}</dd>
                        <dt>ROLL NO</dt><dd>: {{ $student->roll_number ?? '—' }}</dd>
                        <dt>REG NO</dt><dd>: {{ $student->registration_number ?? '—' }}</dd>
                        <dt>SESSION</dt><dd>: {{ $student->session ?? '2024-2025' }}</dd>
                        <dt>COURSE</dt><dd>: {{ $student->course?->name ?? '—' }}</dd>
                        <dt>BLOOD GROUP</dt><dd>: O+</dd>
                        <dt>FATHER'S NAME</dt><dd>: {{ $student->father_name ?? '—' }}</dd>
                        <dt>MOTHER'S NAME</dt><dd>: {{ $student->mother_name ?? '—' }}</dd>
                        <dt>PHONE</dt><dd>: {{ $student->phone ?? '—' }}</dd>
                    </dl>
                </div>

                <!-- QR Code & Signature -->
                <div class="id-card__footer flex items-end justify-between px-5 pb-3">
                    <div class="text-center">
                        <div class="h-5 border-b border-slate-400 w-20 mx-auto flex items-end justify-center">
                            <span class="font-serif italic text-[9px] font-bold text-slate-800">G. A. Mamun</span>
                        </div>
                        <span class="text-[7px] font-bold text-slate-600 block mt-0.5 uppercase">Authorized Signature</span>
                    </div>

                    <div class="id-card__qr-box">
                        @if($qrCode)
                            <img src="{{ $qrCode }}" alt="QR Verification">
                        @else
                            <div class="size-full bg-slate-50 flex items-center justify-center text-[7px] text-slate-400 font-bold">QR CODE</div>
                        @endif
                    </div>
                </div>
            </div>
        </article>

    </div>

    <!-- ACTIONS -->
    <nav class="id-card-actions print:hidden">
        <button type="button" data-print-document onclick="window.print()" class="rounded-xl bg-[#03224c] hover:bg-slate-800 px-8 py-3 text-xs font-black uppercase text-white shadow-xl transition cursor-pointer active:scale-95 flex items-center gap-2">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m11.318-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231a1.125 1.125 0 01-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.036 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.656" />
            </svg>
            Print ID Card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-8 py-3 text-xs font-black uppercase text-slate-800 transition">
            Back
        </a>
    </nav>
</main>

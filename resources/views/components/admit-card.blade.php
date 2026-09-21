@props([
    'student',
    'serial',
    'instituteCode',
    'instituteName' => 'Bangladesh Technical Training Institute',
    'examineeType' => 'Regular',
    'qrCode' => null,
    'qrUrl' => null,
    'printedAt' => null,
])

@vite(['resources/css/app.css', 'resources/css/admit-card.css', 'resources/js/app.js'])

<main class="admit-card-screen">
    <h1 class="sr-only">Admit Card for {{ $student->name }}</h1>

    <div class="admit-card-frame">
        <article class="admit-card" aria-label="Admit card for {{ $student->name }}">
            {{-- Background admit card template containing layout and static borders/text --}}
            <img class="admit-card__template" src="{{ asset('images/admit-card-template.png') }}" alt="Admit Card Background">

            {{-- Dynamic Serial No overlay --}}
            <div class="ac-field ac-field--serial">
                {{ $serial ?? '036564' }}
            </div>

            {{-- Left Side Student Information Fields Overlays --}}
            <div class="ac-field ac-field--institute">
                {{ $student->institute_name ?? $instituteName }}
            </div>

            <div class="ac-field ac-field--student">
                {{ $student->name }}
            </div>

            <div class="ac-field ac-field--father">
                {{ $student->father_name ?? '—' }}
            </div>

            <div class="ac-field ac-field--mother">
                {{ $student->mother_name ?? '—' }}
            </div>

            <div class="ac-field ac-field--dob">
                {{ $student->date_of_birth?->format('Y-m-d') ?? '1994-06-01' }}
            </div>

            <div class="ac-field ac-field--session">
                {{ $student->session ?? '2020 - 2023' }}
            </div>

            {{-- Subject Name below the dividing bar --}}
            <div class="ac-field ac-field--subject">
                {{ $student->course?->name ?? 'Diploma in Electrician' }}
            </div>

            {{-- Right Side Box Inputs Overlays --}}
            <div class="ac-field ac-field--roll">
                {{ $student->roll_number ?? '906912' }}
            </div>

            <div class="ac-field ac-field--reg">
                {{ $student->registration_number ?? '50936900' }}
            </div>

            <div class="ac-field ac-field--sex">
                {{ $student->gender ?? 'Male' }}
            </div>

            <div class="ac-field ac-field--examinee-type">
                {{ $examineeType ?? 'Regular' }}
            </div>

            {{-- Photo Window Overlay --}}
            <figure class="admit-card__photo">
                @if ($student->image_path)
                    <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo of {{ $student->name }}">
                @else
                    <div class="w-full h-full bg-slate-100 flex flex-col items-center justify-center text-[10px] text-slate-400">
                        <span>No Photo</span>
                    </div>
                @endif
            </figure>

            {{-- Verification QR Code Box Overlay --}}
            @if($qrCode)
                <div class="admit-card__qr">
                    <img src="{{ $qrCode }}" alt="QR Verification" class="w-full h-full object-contain">
                </div>
            @endif
        </article>
    </div>

    <nav class="admit-card-actions print:hidden" aria-label="Admit card actions">
        <button type="button" data-print-document onclick="window.print()" class="rounded-full bg-blue-800 px-5 py-3 font-black text-white transition hover:bg-blue-700 cursor-pointer">
            Print admit card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

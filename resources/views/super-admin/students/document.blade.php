@if ($document === 'admit-card')
    <x-admit-card
        :student="$student"
        :serial="$admitCardSerial"
        :institute-code="$admitCardInstituteCode"
        :institute-name="$admitCardInstituteName"
        :examinee-type="$admitCardExamineeType"
        :qr-code="$admitCardQrCode"
        :qr-url="$admitCardQrUrl"
        :printed-at="$admitCardPrintedAt"
    />
@elseif ($document === 'registration-card')
    <x-registration-card
        :student="$student"
        :serial="$registrationCardSerial"
        :institute-code="$registrationCardInstituteCode"
        :institute-name="$registrationCardInstituteName"
        :qr-code="$registrationCardQrCode"
        :qr-url="$registrationCardQrUrl"
    />
@elseif ($document === 'certificate')
    <x-certificate
        :student="$student"
        :latest-result="$latestResult"
        :cumulative-gpa="$cumulativeGpa"
        :certificate-serial="$certificateSerial"
    />
@elseif ($document === 'testimonial')
    <x-testimonial
        :student="$student"
        :latest-result="$latestResult"
        :cumulative-gpa="$cumulativeGpa"
    />
@elseif ($document === 'transcript')
    <x-academic-transcript
        :student="$student"
        :pages="$transcriptPages"
        :cumulative-gpa="$cumulativeGpa"
        :letter-grade="$transcriptLetterGrade"
        :institute-name="$transcriptInstituteName"
    />
@else
    <x-dashboard-shell :title="$documentTitle" eyebrow="Student document" :description="$student->name.' · '.$student->registration_number">
        <article class="mx-auto max-w-3xl border border-slate-300 bg-white p-8 shadow-xl shadow-slate-900/10 sm:p-12">
            <header class="border-b-4 border-emerald-700 pb-6 text-center">
                <img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="mx-auto size-16">
                <h2 class="mt-3 text-2xl font-black text-slate-950">Bangladesh National Youth Technical Institute</h2>
                <p class="mt-2 text-sm font-bold uppercase tracking-[.16em] text-emerald-700">{{ $documentTitle }}</p>
            </header>

            @if ($document === 'student-id')
                <div class="mt-8 rounded-2xl border-2 border-emerald-700 p-6">
                    <p class="document-dynamic-value text-xl">{{ $student->name }}</p>
                    <p class="mt-2 font-bold text-slate-600">Student ID: <span class="document-dynamic-value">{{ $student->registration_number }}</span></p>
                    <p class="mt-1 text-slate-600">Course: <span class="document-dynamic-value">{{ $student->course->name }}</span></p>
                    <p class="mt-1 text-slate-600">Phone: <span class="document-dynamic-value">{{ $student->phone }}</span></p>
                </div>
            @elseif ($document === 'results')
                <dl class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div><dt class="text-xs font-black uppercase text-slate-500">Student</dt><dd class="document-dynamic-value mt-1">{{ $student->name }}</dd></div>
                    <div><dt class="text-xs font-black uppercase text-slate-500">Course</dt><dd class="document-dynamic-value mt-1">{{ $student->course->name }}</dd></div>
                    <div><dt class="text-xs font-black uppercase text-slate-500">Result status</dt><dd class="document-dynamic-value mt-1">{{ $student->result_status }}</dd></div>
                    <div><dt class="text-xs font-black uppercase text-slate-500">Grade / Score</dt><dd class="document-dynamic-value mt-1">{{ $student->grade ?? '—' }} / {{ $student->score ?? '—' }}</dd></div>
                </dl>
            @else
                <p class="mt-8 text-center text-lg leading-9 text-slate-700">
                    This is to certify that <strong class="document-dynamic-value">{{ $student->name }}</strong>,
                    registration number <strong class="document-dynamic-value">{{ $student->registration_number }}</strong>,
                    is enrolled in <strong class="document-dynamic-value">{{ $student->course->name }}</strong>
                    at Bangladesh National Youth Technical Institute.
                </p>
                <dl class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div><dt class="text-xs font-black uppercase text-slate-500">Roll number</dt><dd class="document-dynamic-value mt-1">{{ $student->roll_number ?? '—' }}</dd></div>
                    <div><dt class="text-xs font-black uppercase text-slate-500">Admission date</dt><dd class="document-dynamic-value mt-1">{{ $student->admitted_at?->format('d M Y') ?? '—' }}</dd></div>
                </dl>
            @endif

            <footer class="mt-16 flex justify-between border-t border-slate-200 pt-8 text-sm font-bold text-slate-600">
                <span>Issued: <span class="document-dynamic-value">{{ now()->format('d M Y') }}</span></span>
                <span>Authorized Signature</span>
            </footer>
        </article>

        <div class="mt-6 flex justify-center">
            <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Back to student</a>
        </div>
    </x-dashboard-shell>
@endif

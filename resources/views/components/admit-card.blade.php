@props(['student'])

@vite(['resources/css/app.css', 'resources/css/admit-card.css', 'resources/js/app.js'])

<main class="admit-card-screen">
    <h1 class="sr-only">Admit Card for {{ $student->name }}</h1>

    <div class="admit-card-frame">
        <article class="admit-card" aria-label="Admit card for {{ $student->name }}">
            <img class="admit-card__template" src="{{ asset('images/admit-card-template.png') }}" alt="">

            <section class="admit-card__identity" aria-label="Student information">
                <img class="admit-card__watermark" src="{{ asset('images/bnyti-logo.svg') }}" alt="">

                <p class="admit-card__section-title">Student Information</p>

                <dl class="admit-card__details">
                    <div class="admit-card__name">
                        <dt>Student Name</dt>
                        <dd>{{ $student->name }}</dd>
                    </div>

                    <div>
                        <dt>Registration No.</dt>
                        <dd>{{ $student->registration_number ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt>Roll No.</dt>
                        <dd>{{ $student->roll_number ?? '—' }}</dd>
                    </div>

                    <div class="admit-card__wide-detail">
                        <dt>Course</dt>
                        <dd>{{ $student->course?->name ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt>Session</dt>
                        <dd>{{ $student->session ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt>Duration</dt>
                        <dd>{{ $student->duration ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt>Father's Name</dt>
                        <dd>{{ $student->father_name ?? '—' }}</dd>
                    </div>

                    <div>
                        <dt>Mother's Name</dt>
                        <dd>{{ $student->mother_name ?? '—' }}</dd>
                    </div>
                </dl>

                <figure class="admit-card__photo">
                    @if ($student->image_path)
                        <img src="{{ asset('storage/'.$student->image_path) }}" alt="Photo of {{ $student->name }}">
                    @else
                        <div class="admit-card__photo-placeholder" aria-label="Student photo not available">
                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20 21a8 8 0 0 0-16 0M12 13a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z" />
                            </svg>
                            <span>No photo</span>
                        </div>
                    @endif

                    <figcaption>Student Photo</figcaption>
                </figure>
            </section>
        </article>
    </div>

    <nav class="admit-card-actions print:hidden" aria-label="Admit card actions">
        <button type="button" data-print-document class="rounded-full bg-blue-800 px-5 py-3 font-black text-white transition hover:bg-blue-700">
            Print admit card
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

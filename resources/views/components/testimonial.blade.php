@props([
    'student',
    'latestResult' => null,
    'cumulativeGpa' => null,
])

@php
    $testimonialGrade = $latestResult?->overall_grade ?? $student->grade;
    $testimonialGpa = $cumulativeGpa ?? $latestResult?->gpa;
@endphp

@vite(['resources/css/app.css', 'resources/css/testimonial.css', 'resources/js/app.js'])

<main class="testimonial-screen">
    <h1 class="sr-only">Testimonial for {{ $student->name }}</h1>

    <div class="testimonial-frame">
        <article class="testimonial-document" aria-label="Testimonial for {{ $student->name }}">
            <img class="testimonial-template" src="{{ asset('images/testimonial-template.png') }}" alt="">

            <span class="testimonial-data testimonial-data--serial">{{ $latestResult ? sprintf('TEST-%06d', $latestResult->id) : '—' }}</span>
            <span class="testimonial-data testimonial-data--student">{{ $student->name }}</span>
            <span class="testimonial-data testimonial-data--father">{{ $student->father_name ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--course">{{ $student->course?->name ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--grade">{{ $testimonialGrade ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--gpa">{{ $testimonialGpa !== null ? number_format((float) $testimonialGpa, 2) : '—' }}</span>
            <span class="testimonial-data testimonial-data--roll">{{ $student->roll_number ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--registration">{{ $student->registration_number ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--session">{{ $latestResult?->session ?? $student->session ?? '—' }}</span>
            <span class="testimonial-data testimonial-data--date">{{ $latestResult?->published_at?->format('d/m/Y') ?? '—' }}</span>
        </article>
    </div>

    <nav class="testimonial-actions print:hidden" aria-label="Testimonial actions">
        <button type="button" data-print-document class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white transition hover:bg-emerald-600">
            Print testimonial
        </button>
        <a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 bg-white px-5 py-3 font-black text-slate-700 transition hover:border-slate-400 hover:bg-slate-50">
            Back to student
        </a>
    </nav>
</main>

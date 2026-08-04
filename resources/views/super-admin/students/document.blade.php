@if ($document === 'certificate')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body { margin: 0; width: 100%; height: 100%; max-width: 100%; overflow-x: hidden; overflow-y: auto; background: #1f1f1f; }
        .certificate-page { width: min(1000px, calc(100vw - 48px)); max-width: 100%; margin: 0 auto; padding: 24px; box-sizing: border-box; }
        .certificate { position: relative; width: min(1100px, 100%); height: auto; aspect-ratio: 1.414 / 1; margin: 0 auto; overflow: hidden; background-size: cover; background-position: center; background-repeat: no-repeat; }
        .certificate .absolute { position: absolute; }
        @page { size: A4 landscape; margin: 0; }
        @media print { body { background: #fff !important; } .no-print { display: none !important; } .certificate-page { width: 100%; max-width: none !important; padding: 0; } .certificate { width: 100vw; height: 100vh; aspect-ratio: auto; } }
    </style>
    <div class="certificate-page mx-auto w-full max-w-[1200px]">
        <h1 class="sr-only">Certificate</h1>
        <article class="certificate relative aspect-[1.414/1] overflow-hidden bg-[#fff3e5] bg-cover bg-center bg-no-repeat text-black" style="background-image:url('{{ asset('images/certificate-template.jpg') }}');">
            <div class="absolute left-[27.7%] top-[47.4%] w-[67%] text-center font-serif text-[clamp(10px,1.35vw,26px)] italic">{{ $student->name }}</div>
            <div class="absolute left-[71%] top-[36%] w-[23.5%] font-serif text-[clamp(9px,1vw,19px)] italic">{{ $student->registration_number }}</div>
            <div class="absolute left-[67.5%] top-[41.8%] w-[27%] font-serif text-[clamp(9px,1vw,19px)] italic">{{ $student->session ?? '—' }}</div>
            <div class="absolute left-[36%] top-[52.0%] w-[55%] font-serif text-[clamp(9px,1.05vw,20px)] italic">{{ $student->father_name }}</div>
            <div class="absolute left-[25%] top-[56.6%] w-[66%] font-serif text-[clamp(9px,1.05vw,20px)] italic">{{ $student->mother_name }}</div>
            <div class="absolute left-[25%] top-[61.1%] w-[66%] font-serif text-[clamp(9px,1.05vw,20px)] italic">{{ $student->course->name }}</div>
            <div class="absolute left-[34%] top-[65.7%] w-[57%] font-serif text-[clamp(9px,1.05vw,20px)] italic">{{ $student->roll_number ?? '—' }}</div>
            <div class="absolute left-[55%] top-[65.7%] w-[35%] font-serif text-[clamp(9px,1.05vw,20px)] italic">{{ $latestResult?->semester ?? '—' }}</div>
            <div class="absolute left-[70%] top-[70.2%] w-[22%] text-center font-serif text-[clamp(10px,1.2vw,23px)] italic">{{ number_format((float) ($cumulativeGpa ?? $latestResult?->gpa ?? 0), 2) }}</div>
            <div class="absolute left-[9%] top-[87.2%] font-serif text-[clamp(8px,.9vw,17px)] font-bold italic">{{ $latestResult?->published_at?->format('d/m/Y') ?? now()->format('d/m/Y') }}</div>
        </article>
        <div class="no-print mt-6 flex justify-center gap-3"><button onclick="window.print()" class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white">Print certificate</button><a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Back to student</a></div>
    </div>
    <style>@page{size:A4 landscape;margin:0}@media print{body{background:#fff!important}.no-print{display:none!important}.certificate-page{max-width:none!important}.certificate{width:100vw;height:100vh;aspect-ratio:auto}}</style>
@else
<x-dashboard-shell :title="$documentTitle" eyebrow="Student document" :description="$student->name.' · '.$student->registration_number">
    <article class="mx-auto max-w-3xl border border-slate-300 bg-white p-8 shadow-xl shadow-slate-900/10 sm:p-12">
        <header class="border-b-4 border-emerald-700 pb-6 text-center"><img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="mx-auto size-16"><h2 class="mt-3 text-2xl font-black text-slate-950">Bangladesh National Youth Technical Institute</h2><p class="mt-2 text-sm font-bold uppercase tracking-[.16em] text-emerald-700">{{ $documentTitle }}</p></header>
        @if ($document === 'student-id')<div class="mt-8 rounded-2xl border-2 border-emerald-700 p-6"><p class="text-xl font-black">{{ $student->name }}</p><p class="mt-2 font-bold text-slate-600">Student ID: {{ $student->registration_number }}</p><p class="mt-1 text-slate-600">Course: {{ $student->course->name }}</p><p class="mt-1 text-slate-600">Phone: {{ $student->phone }}</p></div>
        @elseif ($document === 'results' || $document === 'transcript')<dl class="mt-8 grid gap-5 sm:grid-cols-2"><div><dt class="text-xs font-black uppercase text-slate-500">Student</dt><dd class="mt-1 font-black">{{ $student->name }}</dd></div><div><dt class="text-xs font-black uppercase text-slate-500">Course</dt><dd class="mt-1 font-black">{{ $student->course->name }}</dd></div><div><dt class="text-xs font-black uppercase text-slate-500">Result status</dt><dd class="mt-1 font-black">{{ $student->result_status }}</dd></div><div><dt class="text-xs font-black uppercase text-slate-500">Grade / Score</dt><dd class="mt-1 font-black">{{ $student->grade ?? '—' }} / {{ $student->score ?? '—' }}</dd></div></dl>
        @else<p class="mt-8 text-center text-lg leading-9 text-slate-700">This is to certify that <strong>{{ $student->name }}</strong>, registration number <strong>{{ $student->registration_number }}</strong>, is enrolled in <strong>{{ $student->course->name }}</strong> at Bangladesh National Youth Technical Institute.</p><dl class="mt-8 grid gap-5 sm:grid-cols-2"><div><dt class="text-xs font-black uppercase text-slate-500">Roll number</dt><dd class="mt-1 font-black">{{ $student->roll_number ?? '—' }}</dd></div><div><dt class="text-xs font-black uppercase text-slate-500">Admission date</dt><dd class="mt-1 font-black">{{ $student->admitted_at?->format('d M Y') ?? '—' }}</dd></div></dl>@endif
        <footer class="mt-16 flex justify-between border-t border-slate-200 pt-8 text-sm font-bold text-slate-600"><span>Issued: {{ now()->format('d M Y') }}</span><span>Authorized Signature</span></footer>
    </article><div class="mt-6 flex justify-center"><a href="{{ route('super-admin.students.show', $student) }}" class="rounded-full border border-slate-300 px-5 py-3 font-black text-slate-700">Back to student</a></div>
</x-dashboard-shell>
@endif

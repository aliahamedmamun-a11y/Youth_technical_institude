<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Student Registration | BNYTI</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <main class="mx-auto max-w-5xl px-4 py-10 sm:px-6">
            <a href="{{ route('home') }}" class="text-sm font-black text-emerald-700">← Back to BNYTI</a>
            <section class="mt-5">
                <div class="rounded-3xl bg-ink p-6 text-white shadow-xl sm:p-10">
                    <p class="text-sm font-black uppercase tracking-[.16em] text-emerald-300">Student registration</p>
                    <h1 class="mt-3 text-3xl font-black sm:text-4xl">Start your learning journey</h1>
                    <p class="mt-3 max-w-2xl text-slate-300">Submit your details and our admissions team will review your registration.</p>
                </div>
                @if (session('status'))<div class="mt-5 rounded-xl bg-emerald-50 px-4 py-3 font-bold text-emerald-800">{{ session('status') }}</div>@endif
                <div class="mt-5"><x-student-form :courses="$courses" :action="route('student-registrations.store')" :cancel-route="route('home')" submit-label="Submit registration" /></div>
            </section>
        </main>
    </body>
</html>

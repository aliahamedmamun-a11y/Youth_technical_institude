<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $teacher->name }} | BNYTI</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-stone-50 text-slate-900 dark:bg-ink dark:text-white">
        <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 sm:py-12">
            <a href="{{ route('home') }}#expert-teachers" class="inline-flex items-center gap-2 font-black text-emerald-700 transition hover:text-emerald-600 dark:text-emerald-400">
                <span aria-hidden="true">←</span> Back to teachers
            </a>

            <article class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-900/5 dark:border-white/10 dark:bg-deep">
                <div class="grid md:grid-cols-[minmax(260px,0.8fr)_1.2fr]">
                    <div class="relative min-h-80 overflow-hidden bg-[#2699e8] md:min-h-full">
                        @if ($teacher->image_path)
                            <img src="{{ Storage::disk('public')->url($teacher->image_path) }}" alt="{{ $teacher->name }}" class="size-full object-cover object-top">
                        @else
                            <div class="size-full min-h-80 bg-[url('/images/expert-teachers-sprite-v2.png')] bg-no-repeat" style="background-size: 600% auto; background-position: 0 52%;"></div>
                        @endif
                    </div>

                    <div class="p-7 sm:p-10">
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-emerald-700 dark:text-emerald-400">Our expert teacher</p>
                        <h1 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">{{ $teacher->name }}</h1>
                        <p class="mt-2 text-lg font-bold text-slate-600 dark:text-slate-300">{{ $teacher->designation }}</p>
                        <span class="mt-5 inline-flex rounded-full bg-emerald-600 px-4 py-2 text-xs font-black text-white">{{ $teacher->department ?: 'BNYTI Faculty' }}</span>

                        <div class="mt-8 border-t border-slate-200 pt-7 dark:border-white/10">
                            <h2 class="text-sm font-black uppercase tracking-wide text-slate-500 dark:text-slate-400">About the instructor</h2>
                            <p class="mt-3 whitespace-pre-line text-base leading-8 text-slate-700 dark:text-slate-300">{{ $teacher->description ?: 'Our instructor brings practical guidance and industry-focused experience to every class.' }}</p>
                        </div>

                        <dl class="mt-8 grid gap-4 border-t border-slate-200 pt-7 text-sm sm:grid-cols-2 dark:border-white/10">
                            @if ($teacher->qualification)
                                <div><dt class="font-black text-slate-500">Qualification</dt><dd class="mt-1 font-bold">{{ $teacher->qualification }}</dd></div>
                            @endif
                            @if ($experience)
                                <div><dt class="font-black text-slate-500">Experience</dt><dd class="mt-1 font-bold">{{ $experience }}+ years</dd></div>
                            @endif
                            @if ($teacher->email)
                                <div><dt class="font-black text-slate-500">Email</dt><dd class="mt-1 break-all font-bold">{{ $teacher->email }}</dd></div>
                            @endif
                            @if ($teacher->phone)
                                <div><dt class="font-black text-slate-500">Phone</dt><dd class="mt-1 font-bold">{{ $teacher->phone }}</dd></div>
                            @endif
                        </dl>
                    </div>
                </div>
            </article>
        </main>
    </body>
</html>

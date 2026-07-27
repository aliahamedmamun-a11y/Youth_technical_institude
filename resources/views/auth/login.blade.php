<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | Bangladesh National Youth Technical Institute</title>
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-stone-50 text-slate-900 antialiased">
        <main class="flex min-h-screen items-center justify-center px-4 py-12">
            <section class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-8 shadow-xl shadow-slate-900/5">
                <a href="{{ url('/') }}" class="mb-8 flex items-center gap-3">
                    <img src="{{ asset('images/bnyti-logo.svg') }}" alt="BNYTI logo" class="brand-logo size-12">
                    <span>
                        <span class="block text-sm font-black text-slate-950">BNYTI</span>
                        <span class="block text-xs font-bold tracking-[0.18em] text-slate-500">STAFF ACCESS</span>
                    </span>
                </a>

                <div class="mb-8">
                    <h1 class="text-3xl font-black tracking-tight text-slate-950">Sign in</h1>
                    <p class="mt-2 text-sm font-medium text-slate-600">Access your assigned institute dashboard.</p>
                </div>

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="text-sm font-bold text-slate-700">Email address</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="mt-2 block min-h-12 w-full rounded-xl border border-slate-300 px-4 text-sm font-semibold outline-none transition focus:border-emerald-500"
                        >
                        @error('email')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="text-sm font-bold text-slate-700">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            class="mt-2 block min-h-12 w-full rounded-xl border border-slate-300 px-4 text-sm font-semibold outline-none transition focus:border-emerald-500"
                        >
                        @error('password')
                            <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-3 text-sm font-semibold text-slate-600">
                        <input name="remember" type="checkbox" class="size-4 rounded border-slate-300 text-emerald-600">
                        Remember this device
                    </label>

                    <button type="submit" class="primary-button w-full">
                        Sign in
                    </button>
                </form>
            </section>
        </main>
    </body>
</html>

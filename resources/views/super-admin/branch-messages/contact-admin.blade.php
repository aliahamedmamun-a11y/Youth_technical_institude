<x-dashboard-shell title="Contact Admin in Emergency">
    <div class="mx-auto max-w-xl py-6">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/90 p-8 sm:p-10 shadow-2xl backdrop-blur-sm space-y-6">

            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl font-black text-[#4da6ff] uppercase tracking-tight text-center">
                Contact Admin in Emergency
            </h1>

            <form action="{{ route('super-admin.branch-messages.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Your Name (Optional) --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-300">Your Name (Optional)</label>
                    <input type="text" name="name" placeholder="John Doe" value="{{ old('name', auth()->user()?->name) }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/80 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-blue-500 outline-none transition-all shadow-md">
                    @error('name') <span class="mt-1 block text-xs font-bold text-rose-400">{{ $message }}</span> @enderror
                </div>

                {{-- Email (Optional) --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-300">Email (Optional)</label>
                    <input type="email" name="email" placeholder="example@domain.com" value="{{ old('email', auth()->user()?->email) }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/80 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-blue-500 outline-none transition-all shadow-md">
                    @error('email') <span class="mt-1 block text-xs font-bold text-rose-400">{{ $message }}</span> @enderror
                </div>

                {{-- Phone Number (Optional) --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-300">Phone Number (Optional)</label>
                    <input type="text" name="phone" placeholder="(123) 456-7890" value="{{ old('phone') }}"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/80 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-blue-500 outline-none transition-all shadow-md">
                    @error('phone') <span class="mt-1 block text-xs font-bold text-rose-400">{{ $message }}</span> @enderror
                </div>

                {{-- Your Suggestion (Required) --}}
                <div>
                    <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-slate-300">Your Suggestion (Required)</label>
                    <textarea name="message" rows="5" required placeholder="How can we improve the exam or system?"
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/80 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-blue-500 outline-none transition-all resize-none shadow-md">{{ old('message') }}</textarea>
                    @error('message') <span class="mt-1 block text-xs font-bold text-rose-400">{{ $message }}</span> @enderror
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" class="w-full rounded-xl bg-emerald-600 hover:bg-emerald-500 py-3.5 text-sm font-black text-white uppercase tracking-wider shadow-xl transition-all active:scale-95 cursor-pointer">
                        Submit Suggestion
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-dashboard-shell>

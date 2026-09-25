<x-dashboard-shell title="AllTableAdminAdd">
    <div class="mx-auto max-w-2xl py-10">
        <div class="overflow-hidden rounded-3xl border border-white/20 bg-[#03224c] shadow-2xl backdrop-blur-sm">
            {{-- White Header Section --}}
            <div class="bg-white p-8 text-center">
                <h1 class="flex items-center justify-center gap-3 text-2xl font-black text-[#03224c] uppercase">
                    <svg viewBox="0 0 24 24" class="size-8" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 21h18M3 10h18M5 10V7a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3v3M4 21V10m16 11V10M9 21v-4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v4"/>
                    </svg>
                    শাখা বার্তা বোর্ড
                </h1>
                <p class="mt-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest leading-relaxed">
                    অ্যাডমিন কর্তৃক প্রদত্ত বার্তা, নাম ও ডাউনলোড লিংক এখানে দেখা যাবে।
                </p>
            </div>

            <div class="p-8 lg:p-12">
                <form action="{{ route('super-admin.branch-messages.store') }}" method="POST" class="space-y-8">
                    @csrf

                    {{-- Name Input --}}
                    <div>
                        <label class="mb-3 block text-sm font-bold text-slate-400">Your Name (Optional)</label>
                        <input type="text" name="name" placeholder="John Doe"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-4 px-6 text-sm text-white placeholder-slate-600 focus:border-blue-500 outline-none transition-all">
                        @error('name') <span class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Suggestion Input --}}
                    <div>
                        <label class="mb-3 block text-sm font-bold text-slate-400">Your Suggestion (Required)</label>
                        <textarea name="message" rows="6" required placeholder="How can we improve the exam or system?"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-4 px-6 text-sm text-white placeholder-slate-600 focus:border-blue-500 outline-none transition-all resize-none"></textarea>
                        @error('message') <span class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-6">
                        <button type="submit" class="flex w-full items-center justify-center gap-3 rounded-xl bg-emerald-600 py-4 text-sm font-black text-white uppercase tracking-widest shadow-xl transition hover:bg-emerald-500 active:scale-95">
                            Submit Suggestion
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-shell>

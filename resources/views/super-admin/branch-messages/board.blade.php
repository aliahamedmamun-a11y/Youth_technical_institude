<x-dashboard-shell title="Branch Message Board">
    <div class="mx-auto max-w-2xl py-10">
        <div class="rounded-[2rem] border border-white/20 bg-[#1e293b] p-10 shadow-2xl backdrop-blur-sm lg:p-14" style="background-color: #1a2c3d;">
            {{-- Header --}}
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-slate-400 uppercase tracking-tight" style="color: #4a5568;">Branch Message Board</h1>
            </div>

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
</x-dashboard-shell>

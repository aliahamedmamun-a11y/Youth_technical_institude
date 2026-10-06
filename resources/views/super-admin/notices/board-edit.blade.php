<x-dashboard-shell title="Edit Notice Board Suggestion">
    <div class="mx-auto max-w-2xl py-10">
        <div class="overflow-hidden rounded-3xl border border-white/20 bg-[#03224c] shadow-2xl backdrop-blur-sm">
            <div class="bg-white p-8 text-center">
                <h1 class="text-2xl font-black text-[#03224c] uppercase">
                    Edit Notice Board Suggestion
                </h1>
                <p class="mt-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    Update announcement or suggestion content.
                </p>
            </div>

            <div class="p-8 lg:p-12">
                <form action="{{ route('super-admin.notice-board-suggestions.update', $suggestion) }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-3 block text-sm font-bold text-slate-400">Title / Name (Optional)</label>
                        <input type="text" name="name" value="{{ old('name', $suggestion->name) }}" placeholder="e.g. Exam Schedule Update"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-4 px-6 text-sm text-white placeholder-slate-600 focus:border-blue-500 outline-none transition-all">
                        @error('name') <span class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</span> @error
                    </div>

                    <div>
                        <label class="mb-3 block text-sm font-bold text-slate-400">Suggestion / Message (Required)</label>
                        <textarea name="suggestion" rows="6" required placeholder="Enter suggestion or announcement details..."
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-4 px-6 text-sm text-white placeholder-slate-600 focus:border-blue-500 outline-none transition-all resize-none">{{ old('suggestion', $suggestion->suggestion) }}</textarea>
                        @error('suggestion') <span class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6">
                        <a href="{{ route('super-admin.notice-board-suggestions.index') }}" class="rounded-xl bg-[#334155] hover:bg-[#475569] px-6 py-3.5 text-xs font-black uppercase text-white transition">
                            Cancel
                        </a>
                        <button type="submit" class="rounded-xl bg-emerald-600 hover:bg-emerald-500 px-8 py-3.5 text-xs font-black uppercase text-white shadow-xl transition active:scale-95">
                            Update Suggestion
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-shell>

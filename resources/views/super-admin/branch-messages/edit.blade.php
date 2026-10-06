<x-dashboard-shell title="Edit Branch Message">
    <div class="mx-auto max-w-2xl py-10">
        <div class="overflow-hidden rounded-3xl border border-white/20 bg-[#03224c] shadow-2xl backdrop-blur-sm">
            <div class="bg-white p-8 text-center">
                <h1 class="text-2xl font-black text-[#03224c] uppercase">
                    Edit Branch Message / Suggestion
                </h1>
                <p class="mt-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">
                    Update details for this message item.
                </p>
            </div>

            <div class="p-8 lg:p-12">
                <form action="{{ route('super-admin.branch-messages.update', $branchMessage) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase text-slate-300">Name / Title</label>
                        <input type="text" name="name" value="{{ old('name', $branchMessage->name) }}" placeholder="Name"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 px-4 text-sm text-white focus:border-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase text-slate-300">Email</label>
                        <input type="email" name="email" value="{{ old('email', $branchMessage->email) }}" placeholder="Email Address"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 px-4 text-sm text-white focus:border-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase text-slate-300">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $branchMessage->phone) }}" placeholder="Phone Number"
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 px-4 text-sm text-white focus:border-blue-500 outline-none transition-all">
                    </div>

                    <div>
                        <label class="mb-2 block text-xs font-bold uppercase text-slate-300">Message / Suggestion</label>
                        <textarea name="message" rows="5" required placeholder="Message content..."
                            class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 px-4 text-sm text-white focus:border-blue-500 outline-none transition-all resize-none">{{ old('message', $branchMessage->message) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('super-admin.branch-messages.index') }}" class="rounded-xl bg-[#334155] hover:bg-[#475569] px-6 py-3.5 text-xs font-black uppercase text-white transition">
                            Cancel
                        </a>
                        <button type="submit" class="rounded-xl bg-emerald-600 hover:bg-emerald-500 px-8 py-3.5 text-xs font-black uppercase text-white shadow-xl transition active:scale-95">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dashboard-shell>

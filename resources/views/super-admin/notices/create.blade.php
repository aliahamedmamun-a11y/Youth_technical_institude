<x-dashboard-shell title="Notice Management">
    <div class="mx-auto max-w-4xl space-y-10">
        {{-- Header Title --}}
        <div class="text-center">
            <h1 class="text-4xl font-black text-[#4da6ff] uppercase tracking-tight">Notice Management</h1>
        </div>

        {{-- Add New Notice Card --}}
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
            <h2 class="mb-6 text-xl font-black text-white uppercase tracking-widest">Add New Notice</h2>

            <form action="{{ route('super-admin.notices.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="is_published" value="1">
                {{-- Setting message same as title since screenshot shows only one field --}}
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-400">Notice Title</label>
                    <input type="text" name="title" required placeholder="e.g., Admission for next session is open"
                        class="w-full rounded-lg border border-white/10 bg-[#071c2c]/50 py-3.5 px-5 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    @error('title') <span class="mt-1 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                </div>

                {{-- Hidden or default message field to satisfy validation/database --}}
                <textarea name="message" class="hidden">Default Notice Message</textarea>

                <div class="flex justify-center pt-4">
                    <button type="submit" class="rounded-xl bg-[#4f46e5] py-3 px-10 text-sm font-black text-white uppercase tracking-widest transition hover:bg-[#4338ca] active:scale-95 shadow-lg shadow-indigo-900/40">
                        Add Notice
                    </button>
                </div>
            </form>
        </div>

        {{-- Existing Notices Card --}}
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
            <h2 class="mb-8 text-xl font-black text-white uppercase tracking-widest">Existing Notices</h2>

            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-6 py-4">Notice Title</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($notices as $notice)
                                <tr class="group transition-colors hover:bg-white/5">
                                    <td class="px-6 py-5 text-sm font-bold text-white">
                                        <div class="max-w-2xl truncate">{{ $notice->title }}</div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <form action="{{ route('super-admin.notices.destroy', $notice) }}" method="POST" onsubmit="return confirm('Delete this notice?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rounded-md bg-[#ff4d94] px-4 py-1.5 text-[10px] font-black uppercase text-white shadow-lg transition hover:bg-[#ff1a75] active:scale-95">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                        No notices found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-shell>

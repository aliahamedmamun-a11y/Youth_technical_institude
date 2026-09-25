<x-dashboard-shell title="Subject Management">
    <div class="mx-auto max-w-4xl space-y-10">
        {{-- Header Title --}}
        <div class="text-center">
            <h1 class="text-4xl font-black text-[#4da6ff] uppercase tracking-tight">Subject Management</h1>
        </div>

        {{-- Add New Subject Card --}}
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
            <h2 class="mb-6 text-xl font-black text-white uppercase tracking-widest">Add New Subject</h2>

            <form action="{{ route('super-admin.subject-suggestions.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="mb-2 block text-sm font-bold text-slate-400">Subject Name</label>
                    <input type="text" name="name" required placeholder="e.g., Algorithms and Data Structures"
                        class="w-full rounded-lg border border-white/10 bg-[#071c2c]/50 py-3.5 px-5 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    @error('name') <span class="mt-1 block text-xs font-bold text-rose-500">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-center pt-4">
                    <button type="submit" class="rounded-xl bg-blue-600 py-3 px-10 text-sm font-black text-white uppercase tracking-widest transition hover:bg-blue-500 active:scale-95 shadow-lg shadow-blue-900/40">
                        Add Subject
                    </button>
                </div>
            </form>
        </div>

        {{-- Existing Subjects Card --}}
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
            <h2 class="mb-8 text-xl font-black text-white uppercase tracking-widest">Existing Subjects</h2>

            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                            <th class="px-6 py-4">Subject Name</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($suggestions as $suggestion)
                            <tr class="group transition-colors hover:bg-white/5">
                                <td class="px-6 py-5 text-sm font-bold text-white">{{ $suggestion->name }}</td>
                                <td class="px-6 py-5">
                                    <div class="flex justify-center">
                                        <form action="{{ route('super-admin.subject-suggestions.destroy', $suggestion) }}" method="POST" onsubmit="return confirm('Remove this subject suggestion?')">
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
                                    No subjects found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-dashboard-shell>

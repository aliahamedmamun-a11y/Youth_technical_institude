<x-dashboard-shell title="ALL Branches">
    <div class="mx-auto max-w-[1600px]">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">

            <div class="mb-10">
                <h1 class="text-3xl font-black tracking-tight text-[#4da6ff] uppercase lg:text-4xl">ALL Branches</h1>
            </div>

            {{-- Centered Search Bar --}}
            <div class="mb-10 max-w-2xl">
                <form method="GET" class="relative">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search by Branch ID..."
                        class="w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 pl-12 pr-6 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none transition-all">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-500">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                </form>
            </div>

            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-6 py-4">District</th>
                                <th class="px-6 py-4">Username</th>
                                <th class="px-6 py-4 text-center">DirectorPhoto</th>
                                <th class="px-6 py-4 text-center">InstitutePhoto</th>
                                <th class="px-6 py-4 text-center">NationalIdPhoto</th>
                                <th class="px-6 py-4 text-center">SignaturePhoto</th>
                                <th class="px-6 py-4 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($branches as $branch)
                                <tr class="group transition-colors hover:bg-white/5">
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->district }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->username }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-12 overflow-hidden rounded-full border-2 border-white/10 bg-slate-800 shadow-xl">
                                                <img src="{{ $branch->director_photo_path ? asset('storage/' . $branch->director_photo_path) : asset('images/placeholder-avatar.png') }}"
                                                    class="size-full object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-12 overflow-hidden rounded-full border-2 border-white/10 bg-slate-800 shadow-xl">
                                                <img src="{{ $branch->institute_photo_path ? asset('storage/' . $branch->institute_photo_path) : asset('images/placeholder-institute.png') }}"
                                                    class="size-full object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-12 overflow-hidden rounded-full border-2 border-white/10 bg-slate-800 shadow-xl">
                                                <img src="{{ $branch->nid_photo_path ? asset('storage/' . $branch->nid_photo_path) : asset('images/placeholder-doc.png') }}"
                                                    class="size-full object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-12 overflow-hidden rounded-full border-2 border-white/10 bg-slate-800 shadow-xl">
                                                <img src="{{ $branch->director_signature_path ? asset('storage/' . $branch->director_signature_path) : asset('images/placeholder-sig.png') }}"
                                                    class="size-full object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-4">
                                            <a href="{{ route('super-admin.branch-applications.edit', $branch) }}" class="text-blue-400 transition hover:scale-110 active:scale-95" title="Edit Branch">
                                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                            </a>
                                            <form action="{{ route('super-admin.branch-applications.toggle', $branch) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-emerald-400 transition hover:scale-110 active:scale-95" title="Toggle Status">
                                                    <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="2.5">
                                                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                        No branches found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($branches->hasPages())
                <div class="mt-8">
                    {{ $branches->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard-shell>

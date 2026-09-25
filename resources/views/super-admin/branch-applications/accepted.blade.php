<x-dashboard-shell title="Approved Branches">
    <div class="mx-auto max-w-7xl">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">

            <div class="mb-10 text-center">
                <h1 class="text-4xl font-black tracking-tight text-[#ff4d94] uppercase">Approved Branches</h1>
            </div>

            {{-- Search Bar --}}
            <div class="mx-auto mb-10 max-w-2xl">
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
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-6 py-4">BRANCH ID</th>
                                <th class="px-6 py-4">INSTITUTE NAME</th>
                                <th class="px-6 py-4">EMAIL</th>
                                <th class="px-6 py-4">DISTRICT</th>
                                <th class="px-6 py-4 text-center">ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($branches as $branch)
                                <tr class="group transition-colors hover:bg-white/5">
                                    <td class="px-6 py-5 text-sm font-bold text-blue-400">
                                        {{ str_pad($branch->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-black text-white">
                                        {{ $branch->institute_name }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->email }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->district }}
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <form action="{{ route('super-admin.branch-applications.revoke', $branch) }}" method="POST" onsubmit="return confirm('Revoke verification for this branch?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-blue-400 transition hover:scale-110 active:scale-90" title="Revoke Approval">
                                                <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <path d="M3 2v6h6"/><path d="M3 13a9 9 0 1 0 3-7.7L3 8"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                        No approved branches found.
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

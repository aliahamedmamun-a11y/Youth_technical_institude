<x-dashboard-shell title="ALL Branches" eyebrow="Management" description="View and manage all approved institute branches.">
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <form method="GET" class="flex w-full max-w-md items-center gap-2">
            <div class="relative w-full">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ $search }}" class="block w-full rounded-lg border border-slate-700 bg-slate-900 py-2 pl-10 pr-3 text-sm text-white placeholder-slate-400 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Search by Branch ID, Name...">
            </div>
            <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Search</button>
        </form>
        @if(session('status'))
            <div class="rounded-lg bg-emerald-500/10 px-4 py-2 text-sm font-bold text-emerald-500 border border-emerald-500/20">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-800 bg-[#0f172a] shadow-2xl">
        <div class="bg-[#1e293b] px-6 py-4 border-b border-slate-800 flex justify-between items-center">
            <h2 class="text-xl font-bold text-blue-400">ALL Branches</h2>
            <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-bold border border-blue-500/20">Total: {{ $branches->total() }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="bg-[#1e293b] text-xs font-semibold uppercase text-slate-400">
                    <tr>
                        <th class="px-6 py-4">branchId</th>
                        <th class="px-6 py-4 text-center">Action</th>
                        <th class="px-6 py-4">instituteName</th>
                        <th class="px-6 py-4">email</th>
                        <th class="px-6 py-4">password</th>
                        <th class="px-6 py-4">district</th>
                        <th class="px-6 py-4">username</th>
                        <th class="px-6 py-4 text-center">directorPhoto</th>
                        <th class="px-6 py-4 text-center">institutePhoto</th>
                        <th class="px-6 py-4 text-center">nationalIdPhoto</th>
                        <th class="px-6 py-4 text-center">signaturePhoto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($branches as $branch)
                        <tr class="hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 font-mono text-blue-400">
                                {{ str_pad($branch->id, 6, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('super-admin.branch-applications.toggle', $branch) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        @if($branch->is_active)
                                            <button type="submit" class="rounded bg-emerald-600 px-3 py-1 text-xs font-bold text-white hover:bg-emerald-700">Active</button>
                                        @else
                                            <button type="submit" class="rounded bg-slate-600 px-3 py-1 text-xs font-bold text-white hover:bg-slate-700">Block</button>
                                        @endif
                                    </form>
                                    <a href="{{ route('super-admin.branch-applications.edit', $branch) }}" class="rounded bg-indigo-600 px-3 py-1 text-xs font-bold text-white hover:bg-indigo-700">Update</a>
                                    <form action="{{ route('super-admin.branch-applications.destroy', $branch) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this branch?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded bg-rose-600 px-3 py-1 text-xs font-bold text-white hover:bg-rose-700">Delete</button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-pink-400 whitespace-nowrap">
                                {{ $branch->institute_name }}
                            </td>
                            <td class="px-6 py-4 text-emerald-400">
                                {{ $branch->email }}
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-amber-400">
                                {{ $branch->password ?? '********' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $branch->district }}
                            </td>
                            <td class="px-6 py-4 text-slate-500">
                                {{ $branch->username }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <img src="{{ $branch->director_photo_path ? asset('storage/' . $branch->director_photo_path) : asset('images/placeholder-avatar.png') }}" class="h-10 w-10 rounded-full border border-slate-700 object-cover bg-slate-800">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <img src="{{ $branch->institute_photo_path ? asset('storage/' . $branch->institute_photo_path) : asset('images/placeholder-institute.png') }}" class="h-10 w-10 rounded-full border border-slate-700 object-cover bg-slate-800">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <img src="{{ $branch->nid_photo_path ? asset('storage/' . $branch->nid_photo_path) : asset('images/placeholder-doc.png') }}" class="h-10 w-10 rounded-full border border-slate-700 object-cover bg-slate-800">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    <img src="{{ $branch->director_signature_path ? asset('storage/' . $branch->director_signature_path) : asset('images/placeholder-sig.png') }}" class="h-10 w-10 rounded-full border border-slate-700 object-cover bg-slate-800">
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-slate-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <p class="font-bold">No branches found</p>
                                    <p class="text-xs">Try adjusting your search criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($branches->hasPages())
            <div class="border-t border-slate-800 bg-[#1e293b] px-6 py-4">
                {{ $branches->links() }}
            </div>
        @endif
    </div>
</x-dashboard-shell>

<x-dashboard-shell title="ALL Branches">
    <div class="mx-auto max-w-[1600px]">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">

            <div class="mb-10">
                <h1 class="text-3xl font-black tracking-tight text-[#4da6ff] uppercase lg:text-4xl">ALL Branches</h1>
            </div>

            {{-- Search Bar --}}
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
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-6 py-4">branchId</th>
                                <th class="px-6 py-4">Action</th>
                                <th class="px-6 py-4">instituteName</th>
                                <th class="px-6 py-4">email</th>
                                <th class="px-6 py-4">password</th>
                                <th class="px-6 py-4">directorName</th>
                                <th class="px-6 py-4">fatherName</th>
                                <th class="px-6 py-4">motherName</th>
                                <th class="px-6 py-4">mobileNumber</th>
                                <th class="px-6 py-4">address</th>
                                <th class="px-6 py-4">postOffice</th>
                                <th class="px-6 py-4">upazila</th>
                                <th class="px-6 py-4">district</th>
                                <th class="px-6 py-4">username</th>
                                <th class="px-6 py-4 text-center">directorPhoto</th>
                                <th class="px-6 py-4 text-center">institutePhoto</th>
                                <th class="px-6 py-4 text-center">nationalIdPhoto</th>
                                <th class="px-6 py-4 text-center">signaturePhoto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($branches as $branch)
                                <tr class="group transition-colors hover:bg-white/5">
                                    {{-- branchId --}}
                                    <td class="px-6 py-5 text-sm font-bold text-blue-400">
                                        {{ str_pad($branch->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('super-admin.branch-applications.edit', $branch) }}"
                                                class="rounded bg-indigo-600 px-4 py-1.5 text-[10px] font-black uppercase text-white shadow-lg transition hover:bg-indigo-500">
                                                Update
                                            </a>
                                            <form action="{{ route('super-admin.branch-applications.destroy', $branch) }}" method="POST" onsubmit="return confirm('Permanently delete this branch?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rounded bg-[#ff4d94] px-4 py-1.5 text-[10px] font-black uppercase text-white shadow-lg transition hover:bg-[#ff1a75]">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    {{-- instituteName --}}
                                    <td class="px-6 py-5 text-sm font-black text-[#ff4d94]">
                                        {{ $branch->institute_name }}
                                    </td>

                                    {{-- email --}}
                                    <td class="px-6 py-5 text-sm font-bold text-emerald-400">
                                        {{ $branch->email }}
                                    </td>

                                    {{-- password --}}
                                    <td class="px-6 py-5 text-sm font-bold text-[#ff4d94]">
                                        {{ $branch->password ?? 'Pa$$w0rd!' }}
                                    </td>

                                    {{-- directorName --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->director_name }}
                                    </td>

                                    {{-- fatherName --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->father_name }}
                                    </td>

                                    {{-- motherName --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->mother_name }}
                                    </td>

                                    {{-- mobileNumber --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->mobile_number }}
                                    </td>

                                    {{-- address --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->full_address }}
                                    </td>

                                    {{-- postOffice --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->post_office }}
                                    </td>

                                    {{-- upazila --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->upazila }}
                                    </td>

                                    {{-- district --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->district }}
                                    </td>

                                    {{-- username --}}
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $branch->username }}
                                    </td>

                                    {{-- Photos --}}
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <img src="{{ $branch->director_photo_path ? Storage::disk('public')->url($branch->director_photo_path) : asset('images/placeholder-avatar.png') }}" class="size-12 rounded-full border-2 border-white/10 object-cover shadow-xl">
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <img src="{{ $branch->institute_photo_path ? Storage::disk('public')->url($branch->institute_photo_path) : asset('images/placeholder-institute.png') }}" class="size-12 rounded-full border-2 border-white/10 object-cover shadow-xl">
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <img src="{{ $branch->nid_photo_path ? Storage::disk('public')->url($branch->nid_photo_path) : asset('images/placeholder-doc.png') }}" class="size-12 rounded-full border-2 border-white/10 object-cover shadow-xl">
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex justify-center">
                                            <img src="{{ $branch->director_signature_path ? Storage::disk('public')->url($branch->director_signature_path) : asset('images/placeholder-sig.png') }}" class="size-12 rounded-full border-2 border-white/10 object-cover shadow-xl">
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="18" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
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

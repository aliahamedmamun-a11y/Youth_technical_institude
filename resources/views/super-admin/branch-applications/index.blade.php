<x-dashboard-shell title="User Approval Requests">
    <div class="mx-auto max-w-7xl">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">

            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black tracking-tight text-[#4da6ff] uppercase lg:text-4xl">User Approval Requests</h1>
            </div>

            <div class="overflow-hidden rounded-2xl border border-white/5 bg-[#071c2c]/30">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-6 py-4">Photo</th>
                                <th class="px-6 py-4">Institute Name</th>
                                <th class="px-6 py-4">Director Name</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">District</th>
                                <th class="px-6 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($applications as $application)
                                <tr class="group transition-colors hover:bg-white/5">
                                    <td class="px-6 py-4">
                                        <div class="size-10 overflow-hidden rounded-full border border-white/10 bg-slate-800">
                                            <img src="{{ $application->institute_photo_path ? asset('storage/' . $application->institute_photo_path) : asset('images/placeholder-avatar.png') }}"
                                                class="size-full object-cover">
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-white">
                                        {{ $application->institute_name }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $application->director_name }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $application->email }}
                                    </td>
                                    <td class="px-6 py-5 text-sm font-bold text-slate-400">
                                        {{ $application->district }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center justify-center gap-4">
                                            {{-- Approve Action --}}
                                            <form method="POST" action="{{ route('super-admin.branch-applications.update', $application) }}" onsubmit="return confirm('Approve this branch?')">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="text-emerald-500 transition hover:scale-110 active:scale-95" title="Approve Request">
                                                    <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="3">
                                                        <path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </button>
                                            </form>

                                            {{-- Reject/Delete Action --}}
                                            <form action="{{ route('super-admin.branch-applications.destroy', $application) }}" method="POST" onsubmit="return confirm('Reject and delete this request?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-[#ff4d94] transition hover:scale-110 active:scale-95" title="Reject Request">
                                                    <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="3">
                                                        <path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center text-sm font-bold text-slate-500">
                                        No pending approval requests found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($applications->hasPages())
                <div class="mt-8">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-dashboard-shell>

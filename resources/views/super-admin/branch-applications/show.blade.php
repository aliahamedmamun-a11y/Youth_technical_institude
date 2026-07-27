<x-dashboard-shell :title="$branchApplication->proposed_branch_name" eyebrow="Branch application" :description="$branchApplication->applicant_name.' · '.$branchApplication->district">
    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5">
        <dl class="grid gap-6 sm:grid-cols-2">
            <div><dt class="text-xs font-black uppercase text-slate-500">Email</dt><dd class="mt-2 font-black">{{ $branchApplication->email }}</dd></div>
            <div><dt class="text-xs font-black uppercase text-slate-500">Phone</dt><dd class="mt-2 font-black">{{ $branchApplication->phone }}</dd></div>
            <div><dt class="text-xs font-black uppercase text-slate-500">Address</dt><dd class="mt-2 font-black">{{ $branchApplication->address }}</dd></div>
            <div><dt class="text-xs font-black uppercase text-slate-500">Experience</dt><dd class="mt-2 font-black">{{ $branchApplication->years_of_experience ?? 0 }} years</dd></div>
            <div class="sm:col-span-2"><dt class="text-xs font-black uppercase text-slate-500">Applicant message</dt><dd class="mt-2 leading-7">{{ $branchApplication->message ?? 'No message provided.' }}</dd></div>
        </dl>

        @if (session('status'))
            <div class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 font-bold text-emerald-800">{{ session('status') }}</div>
        @endif

        @if ($branchApplication->status->value === 'pending')
            <section class="mt-8 border-t border-slate-200 pt-6">
                <div class="mb-4"><p class="text-xs font-black uppercase tracking-[0.16em] text-slate-500">Review decision</p><p class="mt-1 text-sm text-slate-600">Choose one final outcome for this application.</p></div>
                <div class="grid items-start gap-4 lg:grid-cols-[0.8fr_1.2fr]">
                <form method="POST" action="{{ route('super-admin.branch-applications.update', $branchApplication) }}" class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    <p class="text-sm font-black text-emerald-900">Ready to approve?</p>
                    <p class="mt-1 text-sm leading-6 text-emerald-800">This marks the application as approved and records the review time.</p>
                    <button class="mt-4 inline-flex min-h-11 items-center rounded-full bg-emerald-700 px-5 py-3 font-black text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-200">Approve application</button>
                </form>
                <form method="POST" action="{{ route('super-admin.branch-applications.update', $branchApplication) }}" class="rounded-2xl border border-rose-200 bg-rose-50/40 p-5">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    <label class="grid gap-2 text-sm font-black text-rose-950">Rejection reason<textarea name="rejection_reason" required rows="2" placeholder="Explain the reason clearly for the applicant record." class="w-full resize-y rounded-xl border border-rose-200 bg-white px-4 py-3 text-sm font-medium text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-rose-500 focus:ring-4 focus:ring-rose-100"></textarea></label>
                    <button class="mt-4 inline-flex min-h-11 items-center rounded-full bg-rose-700 px-5 py-3 font-black text-white transition hover:bg-rose-800 focus:outline-none focus:ring-4 focus:ring-rose-200">Reject application</button>
                </form>
                </div>
            </section>
        @else
            <div class="mt-8 rounded-xl bg-slate-50 p-4 font-bold">Status: {{ $branchApplication->status->label() }}@if ($branchApplication->rejection_reason) · {{ $branchApplication->rejection_reason }}@endif</div>
        @endif
    </article>
</x-dashboard-shell>

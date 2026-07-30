<x-dashboard-shell :title="$branchApplication->institute_name ?? $branchApplication->proposed_branch_name" eyebrow="Branch register" :description="($branchApplication->director_name ?? $branchApplication->applicant_name).' · '.($branchApplication->district)">
    <article class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-900/5 sm:p-8">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach(['director_name' => 'Director name', 'father_name' => "Father's name", 'mother_name' => "Mother's name", 'institute_name' => 'Institute name', 'district' => 'District', 'upazila' => 'Upazila', 'post_office' => 'Post office', 'email' => 'E-mail', 'sex' => 'Sex', 'username' => 'Username', 'mobile_number' => 'Mobile number'] as $field => $label)
                <div><dt class="text-xs font-black uppercase text-slate-500">{{ $label }}</dt><dd class="mt-2 font-bold">{{ $branchApplication->{$field} ?? '—' }}</dd></div>
            @endforeach
            <div class="lg:col-span-3"><dt class="text-xs font-black uppercase text-slate-500">Full address</dt><dd class="mt-2 leading-7">{{ $branchApplication->full_address ?? $branchApplication->address ?? '—' }}</dd></div>
        </div>
        <div class="mt-8 grid gap-5 border-t border-slate-200 pt-8 sm:grid-cols-3">
            @foreach(['director_photo_path' => 'Director photo', 'nid_photo_path' => 'NID photo', 'director_signature_path' => 'Director signature'] as $field => $label)
                <div><p class="text-xs font-black uppercase text-slate-500">{{ $label }}</p>@if($branchApplication->{$field})<img src="{{ Storage::disk('public')->url($branchApplication->{$field}) }}" alt="{{ $label }}" class="mt-2 h-32 w-full rounded-xl object-contain object-left">@else<p class="mt-2 text-sm text-slate-400">Not uploaded</p>@endif</div>
            @endforeach
        </div>
        @if (session('status'))<div class="mt-6 rounded-xl bg-emerald-50 px-4 py-3 font-bold text-emerald-800">{{ session('status') }}</div>@endif
        @if ($branchApplication->status->value === 'pending')
            <section class="mt-8 border-t border-slate-200 pt-6"><p class="text-xs font-black uppercase tracking-[0.16em] text-slate-500">Review decision</p><div class="mt-4 grid items-start gap-4 lg:grid-cols-[0.8fr_1.2fr]"><form method="POST" action="{{ route('super-admin.branch-applications.update', $branchApplication) }}" class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-5">@csrf @method('PATCH')<input type="hidden" name="status" value="approved"><button class="rounded-full bg-emerald-700 px-5 py-3 font-black text-white">Approve registration</button></form><form method="POST" action="{{ route('super-admin.branch-applications.update', $branchApplication) }}" class="rounded-2xl border border-rose-200 bg-rose-50/40 p-5">@csrf @method('PATCH')<input type="hidden" name="status" value="rejected"><label class="grid gap-2 text-sm font-black text-rose-950">Rejection reason<textarea name="rejection_reason" required rows="2" class="w-full rounded-xl border border-rose-200 bg-white px-4 py-3"></textarea></label><button class="mt-4 rounded-full bg-rose-700 px-5 py-3 font-black text-white">Reject registration</button></form></div></section>
        @else
            <div class="mt-8 rounded-xl bg-slate-50 p-4 font-bold">Status: {{ $branchApplication->status->label() }}@if ($branchApplication->rejection_reason) · {{ $branchApplication->rejection_reason }}@endif</div>
        @endif
    </article>
</x-dashboard-shell>

@php
    $inputClass = 'min-w-0 w-full rounded-xl border border-slate-700 bg-slate-900 px-4 py-3 text-sm font-medium text-white shadow-sm outline-none transition placeholder:text-slate-500 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20';
    $labelClass = 'block text-sm font-bold text-slate-300 mb-2';
@endphp

<x-dashboard-shell :title="'Edit Branch: ' . $branchApplication->institute_name" eyebrow="Management" description="Update branch details and information." :breadcrumbs="['All Branches' => route('super-admin.all-branches'), 'Edit Branch' => null]">
    <div class="mx-auto max-w-5xl">
        <form method="POST" action="{{ route('super-admin.branch-applications.update-data', $branchApplication) }}" enctype="multipart/form-data" class="space-y-8 rounded-[2rem] border border-slate-800 bg-[#0f172a] p-6 shadow-2xl sm:p-10">
            @csrf
            @method('PUT')

            <div class="grid gap-8 lg:grid-cols-2">
                {{-- Institute Info --}}
                <section class="space-y-6">
                    <h2 class="flex items-center gap-2 text-lg font-black uppercase tracking-wider text-blue-400">
                        <span class="grid size-8 place-items-center rounded-lg bg-blue-500/10 text-blue-500">1</span>
                        Institute Details
                    </h2>

                    <div>
                        <label class="{{ $labelClass }}">Institute Name</label>
                        <input name="institute_name" value="{{ old('institute_name', $branchApplication->institute_name) }}" class="{{ $inputClass }}">
                        @error('institute_name') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', $branchApplication->email) }}" class="{{ $inputClass }}">
                        @error('email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="{{ $labelClass }}">District</label>
                            <input name="district" value="{{ old('district', $branchApplication->district) }}" class="{{ $inputClass }}">
                        </div>
                        <div>
                            <label class="{{ $labelClass }}">Upazila</label>
                            <input name="upazila" value="{{ old('upazila', $branchApplication->upazila) }}" class="{{ $inputClass }}">
                        </div>
                    </div>
                </section>

                {{-- Director Info --}}
                <section class="space-y-6">
                    <h2 class="flex items-center gap-2 text-lg font-black uppercase tracking-wider text-emerald-400">
                        <span class="grid size-8 place-items-center rounded-lg bg-emerald-500/10 text-emerald-500">2</span>
                        Director Details
                    </h2>

                    <div>
                        <label class="{{ $labelClass }}">Director Name</label>
                        <input name="director_name" value="{{ old('director_name', $branchApplication->director_name) }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Mobile Number</label>
                        <input name="mobile_number" value="{{ old('mobile_number', $branchApplication->mobile_number) }}" class="{{ $inputClass }}">
                    </div>

                    <div>
                        <label class="{{ $labelClass }}">Username (Login ID)</label>
                        <input name="username" value="{{ old('username', $branchApplication->username) }}" class="{{ $inputClass }} opacity-70" readonly>
                        <p class="mt-1 text-[10px] text-slate-500 uppercase font-bold">Username cannot be changed</p>
                    </div>
                </section>
            </div>

            <div class="border-t border-slate-800 pt-8">
                <h2 class="flex items-center gap-2 text-lg font-black uppercase tracking-wider text-pink-400 mb-6">
                    <span class="grid size-8 place-items-center rounded-lg bg-pink-500/10 text-pink-500">3</span>
                    Update Photos (Optional)
                </h2>
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach(['director_photo' => 'Director', 'institute_photo' => 'Institute', 'nid_photo' => 'NID', 'director_signature' => 'Signature'] as $field => $label)
                        <div class="space-y-3">
                            <label class="{{ $labelClass }}">{{ $label }} Photo</label>
                            <div class="relative group aspect-square rounded-2xl border-2 border-dashed border-slate-700 bg-slate-800/50 flex flex-col items-center justify-center p-4 transition hover:border-pink-500/50">
                                @php($pathField = $field . ($field === 'director_signature' ? '_path' : '_photo_path'))
                                @if($branchApplication->$pathField)
                                    <img src="{{ asset('storage/' . $branchApplication->$pathField) }}" class="absolute inset-0 h-full w-full object-cover rounded-2xl opacity-40 group-hover:opacity-20 transition">
                                @endif
                                <svg class="size-8 text-slate-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span class="text-[10px] font-bold text-slate-400 text-center">Click to change {{ strtolower($label) }} photo</span>
                                <input type="file" name="{{ $field }}" class="absolute inset-0 opacity-0 cursor-pointer">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex flex-col justify-end gap-3 border-t border-slate-800 pt-8 sm:flex-row">
                <a href="{{ route('super-admin.all-branches') }}" class="inline-flex min-h-[50px] items-center justify-center rounded-xl border border-slate-700 px-8 font-black text-slate-400 transition hover:bg-slate-800">CANCEL</a>
                <button type="submit" class="inline-flex min-h-[50px] items-center justify-center rounded-xl bg-blue-600 px-8 font-black text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-500">UPDATE BRANCH DATA</button>
            </div>
        </form>
    </div>
</x-dashboard-shell>

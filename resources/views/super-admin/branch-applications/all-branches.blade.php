<x-dashboard-shell title="ALL Branches">
    <div class="mx-auto max-w-[1800px]">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">

            <div class="mb-10 text-center">
                <h1 class="text-4xl font-black tracking-tight text-[#4da6ff] uppercase lg:text-5xl">ALL Branches</h1>
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
                <div class="overflow-x-auto scrollbar-hide">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead>
                            <tr class="border-b border-white/10 bg-white/5 text-[10px] font-black uppercase tracking-widest text-[#6cb2eb]">
                                <th class="px-4 py-4">branchId</th>
                                <th class="px-4 py-4">Action</th>
                                <th class="px-4 py-4">instituteName</th>
                                <th class="px-4 py-4">email</th>
                                <th class="px-4 py-4">password</th>
                                <th class="px-4 py-4">directorName</th>
                                <th class="px-4 py-4">fatherName</th>
                                <th class="px-4 py-4">motherName</th>
                                <th class="px-4 py-4">mobileNumber</th>
                                <th class="px-4 py-4">address</th>
                                <th class="px-4 py-4">postOffice</th>
                                <th class="px-4 py-4">upazila</th>
                                <th class="px-4 py-4">district</th>
                                <th class="px-4 py-4">username</th>
                                <th class="px-4 py-4 text-center">directorPhoto</th>
                                <th class="px-4 py-4 text-center">institutePhoto</th>
                                <th class="px-4 py-4 text-center">nationalIdPhoto</th>
                                <th class="px-4 py-4 text-center">signaturePhoto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($branches as $branch)
                                <tr class="group transition-colors hover:bg-white/5 text-[11px] font-bold">
                                    {{-- branchId --}}
                                    <td class="px-4 py-5 text-blue-400">
                                        {{ str_pad($branch->id, 6, '0', STR_PAD_LEFT) }}
                                    </td>

                                    {{-- Action --}}
                                    <td class="px-4 py-5">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('super-admin.branch-applications.edit', $branch) }}"
                                                onclick='event.preventDefault(); openBranchEditModal(@json([
                                                    "id" => $branch->id,
                                                    "branch_id" => str_pad($branch->id, 6, "0", STR_PAD_LEFT),
                                                    "institute_name" => $branch->institute_name,
                                                    "director_name" => $branch->director_name,
                                                    "father_name" => $branch->father_name,
                                                    "mother_name" => $branch->mother_name,
                                                    "email" => $branch->email,
                                                    "mobile_number" => $branch->mobile_number,
                                                    "full_address" => $branch->full_address,
                                                    "post_office" => $branch->post_office,
                                                    "upazila" => $branch->upazila,
                                                    "district" => $branch->district,
                                                    "username" => $branch->username,
                                                    "password" => $branch->password ?: "Pa\$\$w0rd!",
                                                    "status" => is_string($branch->status) ? $branch->status : $branch->status?->value ?? "pending",
                                                    "director_photo_url" => $branch->director_photo_path ? asset("storage/" . $branch->director_photo_path) : asset("images/placeholder-avatar.png"),
                                                    "institute_photo_url" => $branch->institute_photo_path ? asset("storage/" . $branch->institute_photo_path) : asset("images/placeholder-institute.png"),
                                                    "nid_photo_url" => $branch->nid_photo_path ? asset("storage/" . $branch->nid_photo_path) : asset("images/placeholder-doc.png"),
                                                    "signature_photo_url" => $branch->director_signature_path ? asset("storage/" . $branch->director_signature_path) : asset("images/placeholder-sig.png"),
                                                    "update_url" => route("super-admin.branch-applications.update-data", $branch)
                                                ]))'
                                                class="rounded bg-[#6366f1] px-3 py-1.5 text-[9px] font-black uppercase text-white shadow-lg transition hover:bg-indigo-500 cursor-pointer">
                                                Update
                                            </a>
                                            <a href="{{ route('super-admin.branch-students.index', ['branch_id' => $branch->id]) }}"
                                                class="rounded bg-emerald-600 px-3 py-1.5 text-[9px] font-black uppercase text-white shadow-lg transition hover:bg-emerald-500">
                                                Students
                                            </a>
                                            <form action="{{ route('super-admin.branch-applications.destroy', $branch) }}" method="POST" onsubmit="return confirm('Permanently delete this branch?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="rounded bg-[#ec4899] px-3 py-1.5 text-[9px] font-black uppercase text-white shadow-lg transition hover:bg-pink-500">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                    {{-- instituteName --}}
                                    <td class="px-4 py-5 text-pink-400 uppercase">
                                        {{ $branch->institute_name }}
                                    </td>

                                    {{-- email --}}
                                    <td class="px-4 py-5 text-emerald-400">
                                        {{ $branch->email }}
                                    </td>

                                    {{-- password --}}
                                    <td class="px-4 py-5 text-pink-400">
                                        {{ $branch->password ?: 'Pa$$w0rd!' }}
                                    </td>

                                    {{-- directorName --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->director_name }}
                                    </td>

                                    {{-- fatherName --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->father_name ?: 'N/A' }}
                                    </td>

                                    {{-- motherName --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->mother_name ?: 'N/A' }}
                                    </td>

                                    {{-- mobileNumber --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->mobile_number }}
                                    </td>

                                    {{-- address --}}
                                    <td class="px-4 py-5 text-slate-400 max-w-[200px] truncate">
                                        {{ $branch->full_address }}
                                    </td>

                                    {{-- postOffice --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->post_office ?: 'N/A' }}
                                    </td>

                                    {{-- upazila --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->upazila }}
                                    </td>

                                    {{-- district --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->district }}
                                    </td>

                                    {{-- username --}}
                                    <td class="px-4 py-5 text-slate-400">
                                        {{ $branch->username }}
                                    </td>

                                    {{-- Photos --}}
                                    <td class="px-4 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-11 overflow-hidden rounded-full border border-white/10 bg-slate-800 shadow-lg">
                                                <img src="{{ $branch->director_photo_path ? asset('storage/' . $branch->director_photo_path) : asset('images/placeholder-avatar.png') }}" class="size-full object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-11 overflow-hidden rounded-full border border-white/10 bg-slate-800 shadow-lg">
                                                <img src="{{ $branch->institute_photo_path ? asset('storage/' . $branch->institute_photo_path) : asset('images/placeholder-institute.png') }}" class="size-full object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-11 overflow-hidden rounded-full border border-white/10 bg-slate-800 shadow-lg">
                                                <img src="{{ $branch->nid_photo_path ? asset('storage/' . $branch->nid_photo_path) : asset('images/placeholder-doc.png') }}" class="size-full object-cover">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-5">
                                        <div class="flex justify-center">
                                            <div class="size-11 overflow-hidden rounded-full border border-white/10 bg-slate-800 shadow-lg">
                                                <img src="{{ $branch->director_signature_path ? asset('storage/' . $branch->director_signature_path) : asset('images/placeholder-sig.png') }}" class="size-full object-cover brightness-0 invert">
                                            </div>
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

    <!-- UPDATE BRANCH MODAL OVERLAY -->
    <div id="update-branch-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-black/80 backdrop-blur-md flex items-center justify-center p-4">
        <div class="relative w-full max-w-3xl rounded-3xl border border-white/10 bg-[#0e1828] p-6 lg:p-10 shadow-2xl space-y-8 my-8">

            <div class="text-center">
                <h2 class="text-2xl sm:text-3xl font-black text-[#818cf8] uppercase tracking-tight">
                    Update Branch
                </h2>
            </div>

            <form method="POST" id="modal-branch-form" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                @php
                    $bInputClass = 'w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-indigo-500 outline-none transition-all';
                    $bLabelClass = 'block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider';
                @endphp

                <!-- Branch Id -->
                <div>
                    <label class="{{ $bLabelClass }}">Branch Id</label>
                    <input type="text" id="b-id" readonly class="{{ $bInputClass }} cursor-not-allowed text-slate-400">
                </div>

                <!-- Institute Name -->
                <div>
                    <label class="{{ $bLabelClass }}">Institute Name</label>
                    <input type="text" name="institute_name" id="b-inst-name" required placeholder="Institute Name" class="{{ $bInputClass }}">
                </div>

                <!-- Director Name -->
                <div>
                    <label class="{{ $bLabelClass }}">Director Name</label>
                    <input type="text" name="director_name" id="b-dir-name" placeholder="Director Name" class="{{ $bInputClass }}">
                </div>

                <!-- Father Name -->
                <div>
                    <label class="{{ $bLabelClass }}">Father Name</label>
                    <input type="text" name="father_name" id="b-father-name" placeholder="Father Name" class="{{ $bInputClass }}">
                </div>

                <!-- Mother Name -->
                <div>
                    <label class="{{ $bLabelClass }}">Mother Name</label>
                    <input type="text" name="mother_name" id="b-mother-name" placeholder="Mother Name" class="{{ $bInputClass }}">
                </div>

                <!-- Email -->
                <div>
                    <label class="{{ $bLabelClass }}">Email</label>
                    <input type="email" name="email" id="b-email" placeholder="Email Address" class="{{ $bInputClass }}">
                </div>

                <!-- Mobile Number -->
                <div>
                    <label class="{{ $bLabelClass }}">Mobile Number</label>
                    <input type="text" name="mobile_number" id="b-mobile" placeholder="Mobile Number" class="{{ $bInputClass }}">
                </div>

                <!-- Address -->
                <div>
                    <label class="{{ $bLabelClass }}">Address</label>
                    <input type="text" name="full_address" id="b-address" placeholder="Address" class="{{ $bInputClass }}">
                </div>

                <!-- Post Office -->
                <div>
                    <label class="{{ $bLabelClass }}">Post Office</label>
                    <input type="text" name="post_office" id="b-po" placeholder="Post Office" class="{{ $bInputClass }}">
                </div>

                <!-- Upazila -->
                <div>
                    <label class="{{ $bLabelClass }}">Upazila</label>
                    <input type="text" name="upazila" id="b-upazila" placeholder="Upazila" class="{{ $bInputClass }}">
                </div>

                <!-- District -->
                <div>
                    <label class="{{ $bLabelClass }}">District</label>
                    <input type="text" name="district" id="b-district" placeholder="District" class="{{ $bInputClass }}">
                </div>

                <!-- Username -->
                <div>
                    <label class="{{ $bLabelClass }}">Username</label>
                    <input type="text" name="username" id="b-username" placeholder="Username" class="{{ $bInputClass }}">
                </div>

                <!-- Password -->
                <div>
                    <label class="{{ $bLabelClass }}">Password</label>
                    <input type="text" name="password" id="b-password" placeholder="Password" class="{{ $bInputClass }}">
                </div>

                <!-- File Upload Cards -->
                <div class="space-y-4 pt-4 border-t border-white/10">

                    <!-- Director Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $bLabelClass }}">Director Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="director_photo" accept="image/*" class="hidden" onchange="previewBranchFile(this, 'b-dir-img')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="b-dir-img" src="{{ asset('images/placeholder-avatar.png') }}" class="size-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Institute Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $bLabelClass }}">Institute Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="institute_photo" accept="image/*" class="hidden" onchange="previewBranchFile(this, 'b-inst-img')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="b-inst-img" src="{{ asset('images/placeholder-institute.png') }}" class="size-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- National Id Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $bLabelClass }}">National Id Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="nid_photo" accept="image/*" class="hidden" onchange="previewBranchFile(this, 'b-nid-img')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="b-nid-img" src="{{ asset('images/placeholder-doc.png') }}" class="size-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Signature Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $bLabelClass }}">Signature Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="director_signature" accept="image/*" class="hidden" onchange="previewBranchFile(this, 'b-sig-img')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="b-sig-img" src="{{ asset('images/placeholder-sig.png') }}" class="size-full object-cover brightness-0 invert">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Status -->
                <div>
                    <label class="{{ $bLabelClass }}">Status</label>
                    <input type="text" name="status" id="b-status" value="pending" class="{{ $bInputClass }}">
                </div>

                <!-- Role -->
                <div>
                    <label class="{{ $bLabelClass }}">Role</label>
                    <input type="text" name="role" value="admin" class="{{ $bInputClass }}">
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/10">
                    <button type="button" onclick="closeBranchEditModal()" class="rounded-xl bg-[#334155] hover:bg-[#475569] text-white px-8 py-3.5 font-bold text-sm uppercase tracking-wider transition-all">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-10 py-3.5 font-black text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openBranchEditModal(data) {
            const modal = document.getElementById('update-branch-modal');
            const form = document.getElementById('modal-branch-form');
            if (!modal || !form) return;

            form.action = data.update_url;

            document.getElementById('b-id').value = data.branch_id || '';
            document.getElementById('b-inst-name').value = data.institute_name || '';
            document.getElementById('b-dir-name').value = data.director_name || '';
            document.getElementById('b-father-name').value = data.father_name || '';
            document.getElementById('b-mother-name').value = data.mother_name || '';
            document.getElementById('b-email').value = data.email || '';
            document.getElementById('b-mobile').value = data.mobile_number || '';
            document.getElementById('b-address').value = data.full_address || '';
            document.getElementById('b-po').value = data.post_office || '';
            document.getElementById('b-upazila').value = data.upazila || '';
            document.getElementById('b-district').value = data.district || '';
            document.getElementById('b-username').value = data.username || '';
            document.getElementById('b-password').value = data.password || 'Pa$$w0rd!';
            document.getElementById('b-status').value = data.status || 'pending';

            if (data.director_photo_url) document.getElementById('b-dir-img').src = data.director_photo_url;
            if (data.institute_photo_url) document.getElementById('b-inst-img').src = data.institute_photo_url;
            if (data.nid_photo_url) document.getElementById('b-nid-img').src = data.nid_photo_url;
            if (data.signature_photo_url) document.getElementById('b-sig-img').src = data.signature_photo_url;

            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeBranchEditModal() {
            const modal = document.getElementById('update-branch-modal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        function previewBranchFile(input, imgId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(imgId);
                    if (img) img.src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-dashboard-shell>

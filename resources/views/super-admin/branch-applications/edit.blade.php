@php
    $inputClass = 'w-full rounded-xl border border-white/10 bg-[#071c2c]/90 py-3.5 px-4 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all';
    $labelClass = 'block text-xs font-bold text-slate-300 mb-2 uppercase tracking-wider';
@endphp

<x-dashboard-shell title="Update Branch" eyebrow="Branch management" :description="$branchApplication->institute_name">
    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('super-admin.branch-applications.update-data', $branchApplication) }}" enctype="multipart/form-data" class="space-y-8 rounded-3xl border border-white/10 bg-[#0e1828] p-6 sm:p-10 shadow-2xl">
            @csrf
            @method('PUT')

            <div class="text-center">
                <h1 class="text-2xl sm:text-3xl font-black text-[#818cf8] uppercase tracking-tight">Update Branch</h1>
            </div>

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-5 text-rose-300 text-sm">
                    <ul class="list-disc pl-5 space-y-1 font-bold">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-6">

                <!-- Branch Id -->
                <div>
                    <label class="{{ $labelClass }}">Branch Id</label>
                    <input type="text" value="{{ str_pad($branchApplication->id, 6, '0', STR_PAD_LEFT) }}" readonly class="{{ $inputClass }} cursor-not-allowed text-slate-400">
                </div>

                <!-- Institute Name -->
                <div>
                    <label class="{{ $labelClass }}">Institute Name</label>
                    <input type="text" name="institute_name" value="{{ old('institute_name', $branchApplication->institute_name) }}" required placeholder="Institute Name" class="{{ $inputClass }}">
                </div>

                <!-- Director Name -->
                <div>
                    <label class="{{ $labelClass }}">Director Name</label>
                    <input type="text" name="director_name" value="{{ old('director_name', $branchApplication->director_name) }}" placeholder="Director Name" class="{{ $inputClass }}">
                </div>

                <!-- Father Name -->
                <div>
                    <label class="{{ $labelClass }}">Father Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name', $branchApplication->father_name) }}" placeholder="Father Name" class="{{ $inputClass }}">
                </div>

                <!-- Mother Name -->
                <div>
                    <label class="{{ $labelClass }}">Mother Name</label>
                    <input type="text" name="mother_name" value="{{ old('mother_name', $branchApplication->mother_name) }}" placeholder="Mother Name" class="{{ $inputClass }}">
                </div>

                <!-- Email -->
                <div>
                    <label class="{{ $labelClass }}">Email</label>
                    <input type="email" name="email" value="{{ old('email', $branchApplication->email) }}" placeholder="Email Address" class="{{ $inputClass }}">
                </div>

                <!-- Mobile Number -->
                <div>
                    <label class="{{ $labelClass }}">Mobile Number</label>
                    <input type="text" name="mobile_number" value="{{ old('mobile_number', $branchApplication->mobile_number) }}" placeholder="Mobile Number" class="{{ $inputClass }}">
                </div>

                <!-- Address -->
                <div>
                    <label class="{{ $labelClass }}">Address</label>
                    <input type="text" name="full_address" value="{{ old('full_address', $branchApplication->full_address) }}" placeholder="Address" class="{{ $inputClass }}">
                </div>

                <!-- Post Office -->
                <div>
                    <label class="{{ $labelClass }}">Post Office</label>
                    <input type="text" name="post_office" value="{{ old('post_office', $branchApplication->post_office) }}" placeholder="Post Office" class="{{ $inputClass }}">
                </div>

                <!-- Upazila -->
                <div>
                    <label class="{{ $labelClass }}">Upazila</label>
                    <input type="text" name="upazila" value="{{ old('upazila', $branchApplication->upazila) }}" placeholder="Upazila" class="{{ $inputClass }}">
                </div>

                <!-- District -->
                <div>
                    <label class="{{ $labelClass }}">District</label>
                    <input type="text" name="district" value="{{ old('district', $branchApplication->district) }}" placeholder="District" class="{{ $inputClass }}">
                </div>

                <!-- Username -->
                <div>
                    <label class="{{ $labelClass }}">Username</label>
                    <input type="text" name="username" value="{{ old('username', $branchApplication->username) }}" placeholder="Username" class="{{ $inputClass }}">
                </div>

                <!-- Password -->
                <div>
                    <label class="{{ $labelClass }}">Password</label>
                    <input type="text" name="password" value="{{ old('password', $branchApplication->password ?: 'Pa$$w0rd!') }}" placeholder="Password" class="{{ $inputClass }}">
                </div>

                <!-- File Upload Cards -->
                <div class="space-y-4 pt-4 border-t border-white/10">

                    <!-- Director Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $labelClass }}">Director Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="director_photo" accept="image/*" class="hidden" onchange="previewFile(this, 'dir-preview')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="dir-preview" src="{{ $branchApplication->director_photo_path ? asset('storage/'.$branchApplication->director_photo_path) : asset('images/placeholder-avatar.png') }}" class="size-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Institute Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $labelClass }}">Institute Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="institute_photo" accept="image/*" class="hidden" onchange="previewFile(this, 'inst-preview')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="inst-preview" src="{{ $branchApplication->institute_photo_path ? asset('storage/'.$branchApplication->institute_photo_path) : asset('images/placeholder-institute.png') }}" class="size-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- National Id Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $labelClass }}">National Id Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="nid_photo" accept="image/*" class="hidden" onchange="previewFile(this, 'nid-preview')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="nid-preview" src="{{ $branchApplication->nid_photo_path ? asset('storage/'.$branchApplication->nid_photo_path) : asset('images/placeholder-doc.png') }}" class="size-full object-cover">
                            </div>
                        </div>
                    </div>

                    <!-- Signature Photo -->
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/60 p-5 space-y-2">
                        <label class="{{ $labelClass }}">Signature Photo</label>
                        <div class="flex items-center justify-between gap-4">
                            <label class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-5 py-2.5 font-black text-xs uppercase tracking-wider cursor-pointer shadow-lg transition-all active:scale-95">
                                <span>Choose File</span>
                                <input type="file" name="director_signature" accept="image/*" class="hidden" onchange="previewFile(this, 'sig-preview')">
                            </label>
                            <div class="size-20 rounded-xl overflow-hidden border border-white/20 bg-[#0f2d48] flex items-center justify-center">
                                <img id="sig-preview" src="{{ $branchApplication->director_signature_path ? asset('storage/'.$branchApplication->director_signature_path) : asset('images/placeholder-sig.png') }}" class="size-full object-cover brightness-0 invert">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Status -->
                <div>
                    <label class="{{ $labelClass }}">Status</label>
                    <input type="text" name="status" value="{{ old('status', is_string($branchApplication->status) ? $branchApplication->status : $branchApplication->status?->value ?? 'pending') }}" class="{{ $inputClass }}">
                </div>

                <!-- Role -->
                <div>
                    <label class="{{ $labelClass }}">Role</label>
                    <input type="text" name="role" value="admin" class="{{ $inputClass }}">
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-white/10">
                <a href="{{ route('super-admin.all-branches') }}" class="rounded-xl bg-[#334155] hover:bg-[#475569] text-white px-8 py-3.5 font-bold text-sm uppercase tracking-wider transition-all">
                    Cancel
                </a>
                <button type="submit" class="rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white px-10 py-3.5 font-black text-sm uppercase tracking-wider shadow-xl transition-all active:scale-95">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewFile(input, imgId) {
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

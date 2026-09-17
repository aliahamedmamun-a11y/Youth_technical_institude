@php
    $inputClass = 'w-full rounded-xl border border-white/10 bg-[#071c2c]/50 py-3.5 px-5 text-sm text-white placeholder-slate-500 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 outline-none transition-all';
    $labelClass = 'block text-sm font-bold text-slate-300 mb-2';
@endphp

<x-dashboard-shell :title="'Update Branch'" eyebrow="Branch management" :description="$branchApplication->institute_name">
    <div class="mx-auto max-w-2xl">
        <form method="POST" action="{{ route('super-admin.branch-applications.update-data', $branchApplication) }}" enctype="multipart/form-data" class="space-y-8 rounded-[2.5rem] border border-white/20 bg-[#03224c]/40 p-10 shadow-2xl backdrop-blur-md">
            @csrf
            @method('PUT')

            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-[#6366f1] uppercase tracking-tight">Update Branch</h1>
            </div>

            <div class="space-y-6">
                {{-- File Uploads --}}
                @foreach(['director_photo' => 'Director', 'director_signature' => 'Signature'] as $field => $label)
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                        @if($label === 'Signature')
                            <label class="{{ $labelClass }} mb-4">Signature Photo</label>
                        @endif
                        <div class="flex items-center justify-between gap-6">
                            <div class="flex items-center gap-4">
                                <label class="cursor-pointer rounded-full bg-[#6366f1] px-6 py-2.5 text-xs font-black text-white transition hover:bg-indigo-500 uppercase tracking-widest">
                                    Choose File
                                    <input type="file" name="{{ $field }}" class="hidden">
                                </label>
                                <span class="text-xs font-bold text-slate-400">No file chosen</span>
                            </div>
                            <div class="size-20 overflow-hidden rounded-2xl border-2 border-[#6366f1]/30 bg-slate-900 shadow-xl">
                                @php($pathField = $field . ($field === 'director_signature' ? '_path' : '_photo_path'))
                                @if($branchApplication->$pathField)
                                    <img src="{{ Storage::disk('public')->url($branchApplication->$pathField) }}" class="size-full object-cover @if($field === 'director_signature') brightness-0 invert @endif">
                                @else
                                    <div class="flex size-full items-center justify-center text-[10px] text-slate-600">No Img</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Status --}}
                <div>
                    <label class="{{ $labelClass }}">Status</label>
                    <input name="status" value="{{ old('status', $branchApplication->status->value) }}" class="{{ $inputClass }}">
                </div>

                {{-- Role --}}
                <div>
                    <label class="{{ $labelClass }}">Role</label>
                    <input name="role" value="admin" class="{{ $inputClass }}">
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6">
                <a href="{{ route('super-admin.all-branches') }}" class="rounded-xl bg-slate-600 px-8 py-3.5 text-sm font-black text-white transition hover:bg-slate-500 uppercase tracking-widest">
                    Cancel
                </a>
                <button type="submit" class="rounded-xl bg-[#6366f1] px-8 py-3.5 text-sm font-black text-white shadow-xl shadow-indigo-900/40 transition hover:bg-indigo-500 active:scale-95 uppercase tracking-widest">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-dashboard-shell>

<x-dashboard-shell title="Edit Card">
    <div class="mx-auto max-w-4xl">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-12">
            <h2 class="mb-10 text-center text-3xl font-black tracking-tight text-[#4da6ff] uppercase">Edit Card</h2>

            <form action="{{ route('super-admin.admin-cards.update', $adminCard) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-[#6cb2eb]">Name</label>
                    <input type="text" name="name" value="{{ old('name', $adminCard->name) }}"
                        class="w-full rounded-lg border border-white/10 bg-[#071c2c]/50 py-3 px-4 text-sm text-white focus:border-blue-500 outline-none">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-[#6cb2eb]">Title</label>
                    <input type="text" name="title" value="{{ old('title', $adminCard->title) }}"
                        class="w-full rounded-lg border border-white/10 bg-[#071c2c]/50 py-3 px-4 text-sm text-white focus:border-blue-500 outline-none">
                </div>

                <div>
                    <label class="mb-2 block text-xs font-black uppercase tracking-widest text-[#6cb2eb]">Photo</label>
                    <input type="file" name="image"
                        class="w-full rounded-lg border border-white/10 bg-[#071c2c]/50 py-3 px-4 text-sm text-white file:mr-4 file:rounded file:border-0 file:bg-blue-600 file:px-4 file:py-1 file:text-xs file:font-black file:text-white">
                    @if($adminCard->image_path)
                        <img src="{{ Storage::disk('public')->url($adminCard->image_path) }}" class="mt-4 h-32 rounded-lg object-cover">
                    @endif
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="flex-1 rounded-xl bg-blue-600 py-4 text-sm font-black text-white uppercase tracking-widest transition hover:bg-blue-500 shadow-lg">
                        Update Card
                    </button>
                    <a href="{{ route('super-admin.admin-cards.index') }}" class="flex-1 rounded-xl border border-white/10 bg-white/5 py-4 text-center text-sm font-black text-slate-300 uppercase tracking-widest transition hover:bg-white/10">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-dashboard-shell>

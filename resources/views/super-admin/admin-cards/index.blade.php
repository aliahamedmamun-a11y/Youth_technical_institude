<x-dashboard-shell title="AdminForm">
    <div class="mx-auto max-w-5xl">
        {{-- Add New Card Section --}}
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">
            <h2 class="mb-8 text-xl font-black text-white uppercase tracking-widest">Add New Card</h2>

            <form action="{{ route('super-admin.admin-cards.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <input type="text" name="name" placeholder="Name"
                        class="w-full rounded border border-white/20 bg-[#071c2c]/50 py-3 px-4 text-sm text-white placeholder-slate-400 focus:border-blue-500 outline-none">
                </div>

                <div>
                    <input type="text" name="title" placeholder="Title"
                        class="w-full rounded border border-white/20 bg-[#071c2c]/50 py-3 px-4 text-sm text-white placeholder-slate-400 focus:border-blue-500 outline-none">
                </div>

                <div>
                    <input type="file" name="image"
                        class="w-full rounded border border-white/20 bg-[#071c2c]/50 py-3 px-4 text-sm text-white file:mr-4 file:rounded file:border-0 file:bg-blue-600 file:px-4 file:py-1 file:text-xs file:font-black file:text-white hover:file:bg-blue-500">
                </div>

                <div class="space-y-2">
                    <p class="text-sm font-black text-white uppercase tracking-widest">Items</p>
                    <div id="items-container">
                        <input type="text" name="items[]" placeholder="Item 1"
                            class="w-full rounded border border-white/20 bg-[#071c2c]/50 py-3 px-4 text-sm text-white placeholder-slate-400 focus:border-blue-500 outline-none">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="rounded bg-emerald-600 px-8 py-2.5 text-xs font-black text-white uppercase tracking-widest transition hover:bg-emerald-500 active:scale-95 shadow-lg">
                        Add
                    </button>
                </div>
            </form>
        </div>

        {{-- All Cards Section --}}
        <div class="mt-10 rounded-3xl border border-white/20 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm lg:p-10">
            <h2 class="mb-8 text-xl font-black text-white uppercase tracking-widest">All Cards</h2>

            <div class="divide-y divide-white/10 rounded-2xl border border-white/5 bg-[#071c2c]/30">
                @forelse($cards as $card)
                    <div class="flex items-center justify-between p-6 transition-colors hover:bg-white/5">
                        <div class="flex items-center gap-4">
                            @if($card->image_path)
                                <img src="{{ Storage::disk('public')->url($card->image_path) }}" class="size-10 rounded-full object-cover border border-white/10">
                            @endif
                            <p class="text-sm font-black text-white">
                                {{ $card->name }} <span class="mx-2 text-slate-500">-</span>
                                <span class="text-slate-400">{{ $card->title }}</span>
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('super-admin.admin-cards.edit', $card) }}"
                                class="rounded bg-blue-600 px-4 py-1.5 text-[10px] font-black uppercase text-white shadow-lg transition hover:bg-blue-500 active:scale-95">
                                Edit
                            </a>
                            <form action="{{ route('super-admin.admin-cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Delete this card?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="rounded bg-[#ff4d94] px-4 py-1.5 text-[10px] font-black uppercase text-white shadow-lg transition hover:bg-[#ff1a75] active:scale-95">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-10 text-center text-sm font-bold text-slate-500">
                        No cards found.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-dashboard-shell>

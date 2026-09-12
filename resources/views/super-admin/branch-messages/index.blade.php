<x-dashboard-shell title="Branch Message inbox">
    <div class="mx-auto max-w-6xl space-y-10">
        {{-- Header Title --}}
        <div class="text-center">
            <h1 class="text-4xl font-black text-[#4da6ff] uppercase tracking-tight">Contact admin in emergency</h1>
        </div>

        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse($messages as $msg)
                <div class="rounded-3xl border border-white/20 bg-[#03224c] p-8 shadow-2xl backdrop-blur-sm">
                    <div class="space-y-4">
                        <h2 class="text-xl font-black text-[#4da6ff]">{{ $msg->name }}</h2>

                        <div class="space-y-1">
                            <p class="text-sm font-bold text-white">Email:</p>
                            <p class="text-sm font-medium text-[#6cb2eb] break-all">{{ $msg->email }}</p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-sm font-bold text-white">Phone: <span class="text-[#6cb2eb] font-medium ml-1">{{ $msg->phone }}</span></p>
                        </div>

                        <div class="space-y-1">
                            <p class="text-sm font-bold text-white">Suggestion: <span class="text-[#6cb2eb] font-medium ml-1">{{ $msg->message }}</span></p>
                        </div>

                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest pt-2">
                            Submitted: {{ $msg->created_at->format('m/d/Y, h:i:s A') }}
                        </p>

                        <div class="pt-4">
                            <form action="{{ route('super-admin.branch-messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-full rounded-xl bg-[#243b55] py-2.5 text-sm font-black text-slate-300 transition hover:bg-[#2c4b6b] hover:text-white shadow-lg">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-3xl border border-white/5 bg-[#071c2c]/30 p-12 text-center">
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">No emergency messages found.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-dashboard-shell>

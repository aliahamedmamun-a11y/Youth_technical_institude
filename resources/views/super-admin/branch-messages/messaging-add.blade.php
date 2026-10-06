<x-dashboard-shell title="Admin Messaging">
    <div class="mx-auto max-w-[1600px] space-y-10">
        {{-- Header Section --}}
        <div class="text-center">
            <h1 class="text-5xl font-black text-[#4da6ff] uppercase tracking-tight">Admin Messaging</h1>
            <p class="mt-4 text-sm font-bold text-slate-400 uppercase tracking-widest">View and manage messages submitted to admin.</p>
        </div>

        {{-- Grid of Messages --}}
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse($messages as $msg)
                <article class="group relative flex flex-col rounded-[2.5rem] border border-white/10 bg-[#03224c]/40 p-8 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:-translate-y-2 hover:border-blue-500/30">
                    <div class="flex-1 space-y-6">
                        <h2 class="text-2xl font-black text-[#6cb2eb] uppercase tracking-tight">{{ $msg->name ?: 'Anonymous' }}</h2>

                        <div class="space-y-3">
                            <p class="text-xs font-black text-slate-500 uppercase tracking-widest">Suggestion:</p>
                            <div class="min-h-[120px] rounded-2xl bg-[#071c2c]/60 p-5 ring-1 ring-white/5">
                                <p class="text-sm font-medium leading-relaxed text-slate-300 break-words">{{ $msg->message }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 text-[10px] font-bold text-slate-500 uppercase tracking-tight">
                            <svg viewBox="0 0 24 24" class="size-3" fill="none" stroke="currentColor" stroke-width="3">
                                <rect x="3" y="4" width="18" height="16" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Submitted: {{ $msg->created_at->format('m/d/Y, h:i:s A') }}
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-3">
                        <a href="{{ route('super-admin.branch-messages.edit', $msg) }}" class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-blue-600 py-3.5 text-xs font-black text-white uppercase tracking-widest shadow-xl transition hover:bg-blue-500 active:scale-95">
                            Edit
                        </a>
                        <form action="{{ route('super-admin.branch-messages.destroy', $msg) }}" method="POST" onsubmit="return confirm('Permanently delete this suggestion?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 py-3.5 text-xs font-black text-white uppercase tracking-widest shadow-xl transition hover:bg-red-500 active:scale-95">
                                Delete
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-32 text-center">
                    <p class="text-lg font-black text-slate-600 uppercase tracking-[0.3em]">No suggestions found</p>
                </div>
            @endforelse
        </div>

        {{-- Footer --}}
        <div class="pt-10 text-center">
            <p class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.25em]">© {{ date('Y') }} Admin Messaging System.</p>
        </div>
    </div>
</x-dashboard-shell>

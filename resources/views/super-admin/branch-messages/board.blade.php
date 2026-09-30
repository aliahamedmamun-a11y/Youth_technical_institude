<x-dashboard-shell title="Branch Message Board">
    <div class="mx-auto max-w-[1800px]">
        <div class="rounded-3xl border border-white/20 bg-[#03224c]/40 p-6 sm:p-8 shadow-2xl backdrop-blur-sm lg:p-10 space-y-8">

            {{-- Top Pill --}}
            <div class="flex items-center justify-between">
                <span class="inline-flex items-center gap-2 rounded-xl bg-blue-600/30 border border-blue-500/40 px-4 py-2 text-xs font-black text-blue-300 uppercase shadow-lg">
                    Student Admission Form
                </span>
            </div>

            {{-- Title & Subtitle --}}
            <div class="text-center space-y-2">
                <div class="inline-flex items-center justify-center gap-3">
                    <svg viewBox="0 0 24 24" class="size-8 sm:size-10 text-[#4da6ff]" fill="none" stroke="currentColor" stroke-width="2.2">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <h1 class="text-3xl font-black text-[#4da6ff] uppercase tracking-tight sm:text-4xl lg:text-5xl">
                        Branch Message Board
                    </h1>
                </div>
                <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">
                    View important messages or links shared by admin.
                </p>
            </div>

            {{-- Message Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($messages as $msg)
                    <div class="rounded-2xl border border-white/10 bg-[#071c2c]/80 p-6 shadow-xl flex flex-col justify-between gap-6 transition-all hover:border-blue-500/30 group">
                        <div class="space-y-4">
                            <h3 class="text-base font-black text-white uppercase group-hover:text-blue-300 transition-colors">
                                {{ $msg->name ?: ($msg->title ?? 'Admin Notice') }}
                            </h3>

                            @if(!empty($msg->link))
                                <a href="{{ $msg->link }}" target="_blank"
                                   class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-[#4f46e5] hover:bg-[#4338ca] text-white py-2.5 px-4 text-xs font-black uppercase tracking-wider shadow-lg transition-all active:scale-95">
                                    <svg viewBox="0 0 24 24" class="size-4" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                                    </svg>
                                    <span>Open Link</span>
                                </a>
                            @elseif(!empty($msg->message))
                                <p class="text-xs font-medium text-slate-300 leading-relaxed break-words">
                                    {{ $msg->message }}
                                </p>
                            @endif
                        </div>

                        <div class="text-right border-t border-white/5 pt-3">
                            <span class="text-[10px] font-bold text-slate-500">
                                {{ $msg->created_at?->format('n/j/Y, g:i:s A') ?? '9/30/2026, 11:54:53 AM' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 font-bold">
                        No messages or notices published yet.
                    </div>
                @endforelse
            </div>

            {{-- Footer --}}
            <div class="pt-10 text-center text-xs font-bold text-slate-400">
                © {{ date('Y') }} Branch Admin System. All rights reserved.
            </div>

        </div>
    </div>
</x-dashboard-shell>

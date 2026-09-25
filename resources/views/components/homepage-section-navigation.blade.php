@props(['sections', 'currentSection'])

<nav aria-label="Homepage sections" class="admin-panel mb-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div><h2 class="text-base font-black text-slate-950">Homepage sections</h2><p class="mt-1 text-sm text-slate-600">Choose a section to view and manage its content.</p></div>
        <a href="{{ route('home') }}" target="_blank" rel="noopener" class="admin-button admin-button--secondary">Preview website ↗</a>
    </div>
    <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
        @foreach($sections as $homepageSection)
            <a href="{{ route('super-admin.homepage.items.index', $homepageSection->key) }}" @class(['shrink-0 rounded-xl border px-4 py-2.5 text-sm font-black transition', 'border-blue-600 bg-blue-600 text-white' => $homepageSection->is($currentSection), 'border-slate-200 bg-white text-slate-700 hover:border-blue-300 hover:text-blue-700' => ! $homepageSection->is($currentSection)]) @if($homepageSection->is($currentSection)) aria-current="page" @endif>
                {{ $homepageSection->label }}
                @unless($homepageSection->is_visible)<span class="ml-1 text-[10px] opacity-70">Hidden</span>@endunless
            </a>
        @endforeach
    </div>
</nav>

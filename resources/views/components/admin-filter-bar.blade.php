@props(['search' => '', 'status' => '', 'statuses' => []])

<form method="GET" {{ $attributes->class('admin-panel mb-5 flex flex-col gap-3 sm:flex-row') }} aria-label="Filter records">
    <label class="flex-1"><span class="sr-only">{{ __('admin.filters.search') }}</span><input name="search" value="{{ $search }}" placeholder="{{ $attributes->get('placeholder', __('admin.filters.search')) }}" class="min-h-11 w-full rounded-xl border border-slate-300 px-4 text-sm"></label>
    @if($statuses)<label><span class="sr-only">{{ __('admin.filters.status') }}</span><select name="status" class="min-h-11 w-full rounded-xl border border-slate-300 px-4 text-sm sm:w-44"><option value="">All statuses</option>@foreach($statuses as $value => $label)<option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>@endforeach</select></label>@endif
    <button class="admin-button admin-button--primary">{{ __('admin.filters.apply') }}</button>
    @if($search || $status)<a href="{{ url()->current() }}" class="admin-button admin-button--secondary">{{ __('admin.filters.clear') }}</a>@endif
</form>

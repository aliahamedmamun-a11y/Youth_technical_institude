@props(['status'])

@php
    $value = $status instanceof \BackedEnum ? $status->value : strtolower((string) $status);
    $label = $status instanceof \App\Enums\BranchApplicationStatus ? $status->label() : ucfirst($value);
@endphp

<span {{ $attributes->class(['admin-status', 'admin-status--success' => in_array($value, ['active', 'approved', 'published'], true), 'admin-status--warning' => in_array($value, ['pending', 'draft'], true), 'admin-status--danger' => in_array($value, ['rejected', 'inactive'], true)]) }}>{{ $label }}</span>

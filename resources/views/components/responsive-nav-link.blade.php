@props(['active'])

@php
$classes = ($active ?? false)
            ? 'mobile-nav mobile-nav-active'
            : 'mobile-nav';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
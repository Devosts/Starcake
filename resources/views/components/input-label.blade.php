@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-surface-700']) }}>
    {{ $value ?? $slot }}
</label>
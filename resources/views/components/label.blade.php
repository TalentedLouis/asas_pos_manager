@props(['value'])

<label {{ $attributes->merge(['class' => 'w-full block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>

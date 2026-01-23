@props([
    'name' => null,
])

@php
    $isEmoji = $name && mb_strlen($name) <= 4 && preg_match('/\p{Emoji}/u', $name);
@endphp

@if ($name)
    @if ($isEmoji)
        <span {{ $attributes->merge(['class' => 'inline-flex items-center text-2xl shrink-0']) }}>
            {{ $name }}
        </span>
    @else
        <x-dynamic-component
            :component="$name"
            {{ $attributes }}
        />
    @endif
@endif

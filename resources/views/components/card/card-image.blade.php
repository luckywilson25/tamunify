@props(['title', 'image'])

<div {!! $attributes->merge(['class' => 'card bg-base-100 shadow-xl']) !!}>
    <figure>
        <img src="{{ asset($image) }}" alt="{{ $title ?? 'alt' }}" class="object-contain w-full h-56 max-h-56" />
    </figure>
    <div class="card-body">
        <h2 class="card-title">{{ $title ?? '' }}</h2>
        {{ $slot }}

    </div>
</div>

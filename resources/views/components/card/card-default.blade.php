@props(['title', 'header' => false])

<div {!! $attributes->merge(['class' => 'card bg-base-100']) !!}>
    @if ($header)
    <div class="relative h-16 bg-gradient-to-r from-[#006838] to-[#00a550] overflow-hidden w-full">
        <div class="absolute inset-0 opacity-20">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full">
                <path d="M0,0 L100,0 L100,25 C75,50 25,50 0,25 Z" fill="white" />
            </svg>
        </div>
        <div class="absolute inset-0 flex items-center justify-center">
            <img src="{{ asset('assets/images/tamunify-logo.png') }}" alt="Tamunify Logo"
                class="h-32 w-32 object-contain brightness-0 invert">
        </div>
    </div>
    @endif
    <div class="card-body">
        <h2 class="card-title">{{ $title ?? '' }}</h2>
        {{ $slot }}
    </div>
</div>
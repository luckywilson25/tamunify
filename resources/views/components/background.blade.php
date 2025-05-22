<div class="absolute inset-0 z-0">
    {{-- Gradient background dengan warna PT Pupuk Kujang --}}
    <div class="absolute inset-0 bg-gradient-to-b from-[#006838]/5 via-[#006838]/10 to-[#006838]/15"></div>

    {{-- Pattern overlay dengan lingkaran --}}
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-0 left-0 w-full h-full">
            @php
            $circles = collect(range(1, 6))->map(function () {
            return [
            'width' => rand(100, 400),
            'height' => rand(100, 400),
            'top' => rand(0, 100),
            'left' => rand(0, 100),
            'opacity' => 0.1,
            'scale' => rand(60, 140) / 100, // 0.6 - 1.4
            ];
            });
            @endphp

            @foreach ($circles as $circle)
            <div class="absolute rounded-full bg-[#006838]" style="
                        width: {{ $circle['width'] }}px;
                        height: {{ $circle['height'] }}px;
                        top: {{ $circle['top'] }}%;
                        left: {{ $circle['left'] }}%;
                        opacity: {{ $circle['opacity'] }};
                        transform: scale({{ $circle['scale'] }});
                    ">
            </div>
            @endforeach
        </div>
    </div>

    {{-- Kujang pattern overlay --}}
    <div class="absolute inset-0 opacity-5">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <pattern id="kujangPattern" patternUnits="userSpaceOnUse" width="100" height="100"
                patternTransform="rotate(45)">
                <path d="M50,10 C70,10 85,25 85,50 C85,75 70,90 50,90 C30,90 15,75 15,50 C15,25 30,10 50,10 Z"
                    fill="#006838" opacity="0.1" />
                <path d="M65,30 L50,70 L35,30 L50,40 Z" fill="#006838" opacity="0.2" />
            </pattern>
            <rect width="100%" height="100%" fill="url(#kujangPattern)" />
        </svg>
    </div>
</div>

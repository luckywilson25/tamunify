<header class="w-full bg-white border-b">
    {{-- Announcement Bar --}}
    <div class="bg-[#00843D]">
        <div class="flex items-center justify-between">
            {{-- Logo Tamunify di kiri --}}
            <div class="flex-shrink-0">
                <a href="{{ url('/') }}">
                    <div class="relative h-12 w-52 ml-0">
                        <img src="{{ asset('assets/images/tamunify-logo.png') }}" alt="Tamunify Logo"
                            class="object-left object-contain brightness-0 invert w-full h-full" />
                    </div>
                </a>
            </div>

            {{-- Text di kanan --}}
            <div class="text-xs text-white font-medium whitespace-nowrap pr-4">
                PT. Pupuk Kujang Cikampek
            </div>
        </div>
    </div>

    {{-- Main Navigation --}}
    <div class="relative w-full overflow-hidden">
        {{-- Decorative SVG Wave --}}
        <div class="absolute inset-0 z-0">
            <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="absolute bottom-0 left-0 w-full h-14">
                <path d="M0,0 C150,90 350,0 500,100 C650,190 750,100 900,50 C1050,0 1150,80 1200,80 L1200,120 L0,120 Z"
                    class="fill-[#00843D] opacity-10" />
                <path
                    d="M0,80 C150,100 350,10 500,110 C650,200 750,110 900,60 C1050,10 1150,90 1200,90 L1200,120 L0,120 Z"
                    class="fill-[#00843D] opacity-15" />
            </svg>
        </div>

        {{-- Logo BUMN + Admin Login --}}
        <div class="relative z-10 w-full flex items-center justify-between px-4 py-3">
            <a href="{{ url('/') }}" class="flex items-center">
                <div class="relative h-12 w-52">
                    <img src="{{ asset('assets/images/bumn-pupuk-logos.png') }}" alt="BUMN and Pupuk Indonesia Logos"
                        class="object-contain w-full h-full" />
                </div>
            </a>

            <div class="flex items-center">
                {{-- @if (Route::currentRouteName() == 'home')
                <a href="{{ route('admin.login') }}">
                    <button
                        class="bg-transparent border-0 text-transparent hover:text-white hover:bg-[#006838] active:bg-[#006838]/20 focus:bg-[#006838]/20 focus:text-white focus:ring-2 focus:ring-[#006838]/30 active:border active:border-[#006838] transition-all duration-300 px-4 py-2 rounded">
                        Admin Login
                    </button>
                </a>
                @endif --}}
            </div>
        </div>
    </div>
</header>
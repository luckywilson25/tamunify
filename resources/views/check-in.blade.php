@section('title', "Check-in")
<x-guest-layout>
    @php
    $steps = [
    [
    'title' => 'Registrasi',
    'desc' => 'Daftar sesuai Jenis/Kategori Kunjungan Anda',
    'icon' => '<i class="fa-solid fa-receipt w-12 h-12 text-green-700 mx-auto"></i>',
    ],
    [
    'title' => 'Verifikasi',
    'desc' => 'Menunggu Verifikasi & Persetujuan',
    'icon' => '<i class="fa-solid fa-user-shield w-12 h-12 text-green-700 mx-auto"></i>',
    ],
    [
    'title' => 'Akses',
    'desc' => 'Dapatkan Barcode/Kartu akses masuk untuk akses gerbang',
    'icon' => '<i class="fa-solid fa-user-check w-12 h-12 text-green-700 mx-auto"></i>',
    ],
    [
    'title' => 'In/Out',
    'desc' => 'Scan Barcode untuk keluar-masuk gerbang',
    'icon' => '<i class="fa-solid fa-calendar w-12 h-12 text-green-700 mx-auto"></i>',
    ],
    ];
    @endphp

    <div class="flex min-h-screen flex-col relative overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 z-0">
            {{--
            <x-building-background /> --}}
            <div class="absolute inset-0 bg-white bg-opacity-50"></div>
        </div>


        {{-- Main Content --}}
        <main class="flex-1 relative z-10 px-4 py-10 md:py-14">
            <div class="max-w-6xl mx-auto space-y-16">

                {{-- Kategori Tamu --}}
                <div class="grid md:grid-cols-3 gap-8">
                    @include('components.card-default', [
                    'icon' => '<i class="fa-solid fa-user w-8 h-8 text-green-700"></i>',
                    'title' => 'Tamu Umum',
                    'desc' => 'Untuk kunjungan satu kali seperti meeting, pengiriman, atau kunjungan singkat lainnya.',
                    'href' => route('register.one-time')
                    ])

                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                        @include('components.card-default', [
                        'icon' => '<i class="fa-solid fa-calendar w-8 h-8 text-green-700"></i>',
                        'title' => 'Magang/PKL',
                        'desc' => 'Untuk mahasiswa atau siswa yang akan melaksanakan magang atau praktik kerja
                        lapangan.',
                        'href' => route('register.internship')
                        ])
                        @include('components.card-default', [
                        'icon' => '<i class="fa-solid fa-clock w-8 h-8 text-green-700"></i>',
                        'title' => 'Tamu Berulang',
                        'desc' => 'Untuk orang tua/wali, vendor, atau tamu yang perlu akses berulang dalam periode
                        tertentu.',
                        'href' => route('register.recurring')
                        ])
                    </div>
                </div>
                
                {{-- Cara Kerja Sistem --}}
                <section
                    class="bg-white p-8 rounded-2xl shadow-xl max-w-5xl mx-auto text-center border border-gray-100 relative overflow-hidden">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-50 pointer-events-none">
                    </div>
                    <h3 class="text-2xl font-bold mb-8 text-green-900 relative z-10">Cara Kerja Sistem</h3>

                    {{-- Desktop View --}}
                    <div
                        class="hidden md:grid grid-cols-[1fr_40px_1fr_40px_1fr_40px_1fr] gap-0 relative z-10 items-center">
                        @foreach ($steps as $index => $item)
                        <div class="flex flex-col items-center px-2">
                            <div class="mb-4">{!! $item['icon'] !!}</div>
                            <h4 class="font-bold text-lg text-green-800 mb-2">{{ $item['title'] }}</h4>
                            <p class="text-gray-700 text-sm">{{ $item['desc'] }}</p>
                        </div>
                        @if ($index < count($steps) - 1) <div class="flex justify-center items-center">
                            <i class="fa-solid fa-arrow-right w-6 h-6 text-gray-400"></i>
                    </div>
                    @endif
                    @endforeach
            </div>

            {{-- Mobile View --}}
            <div class="md:hidden flex flex-col items-center gap-8 relative z-10">
                @foreach ($steps as $index => $item)
                <div class="text-center">
                    <div class="mb-4">{!! $item['icon'] !!}</div>
                    <h4 class="font-bold text-lg text-green-800 mb-2">{{ $item['title'] }}</h4>
                    <p class="text-gray-700 text-sm">{{ $item['desc'] }}</p>
                    @if ($index < count($steps) - 1) <i
                        class="fa-solid fa-arrow-right w-5 h-5 text-gray-400 mt-4 mx-auto"></i>
                        @endif
                </div>
                @endforeach
            </div>

            <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-green-100 rounded-full opacity-30"></div>
            <div class="absolute -top-6 -right-6 w-32 h-32 bg-green-100 rounded-full opacity-30"></div>
            </section>

            {{-- Tombol Kembali --}}
            <div class="flex justify-center">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 text-white font-medium bg-green-800 hover:bg-green-900 px-5 py-3 rounded-lg transition-all duration-300 hover:scale-105 shadow-md hover:shadow-lg">
                    <i class="fa-solid fa-arrow-left w-5 h-5"></i>
                    Kembali ke Beranda
                </a>
            </div>

    </div>
    </main>
    </div>
</x-guest-layout>

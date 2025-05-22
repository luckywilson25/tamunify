@section('title', 'Tambah Tamu')
@section('header', 'Tambah Tamu')

<x-app-layout>
    <div class="p-6 flex-grow">
        @if (session()->has('success'))
        <x-alert.success :message="session('success')" />
        @endif

        <div class="grid md:grid-cols-3 gap-8">
            @include('components.card-default', [
            'icon' => '<i class="fa-solid fa-user w-8 h-8 text-green-700"></i>',
            'title' => 'Tamu Umum',
            'desc' => 'Untuk kunjungan satu kali seperti meeting, pengiriman, atau kunjungan singkat lainnya.',
            'href' => route('visitor.create.one-time')
            ])

            <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('components.card-default', [
                'icon' => '<i class="fa-solid fa-calendar w-8 h-8 text-green-700"></i>',
                'title' => 'Magang/PKL',
                'desc' => 'Untuk mahasiswa atau siswa yang akan melaksanakan magang atau praktik kerja
                lapangan.',
                'href' => route('visitor.create.internship')
                ])
                @include('components.card-default', [
                'icon' => '<i class="fa-solid fa-clock w-8 h-8 text-green-700"></i>',
                'title' => 'Tamu Berulang',
                'desc' => 'Untuk orang tua/wali, vendor, atau tamu yang perlu akses berulang dalam periode
                tertentu.',
                'href' => route('visitor.create.recurring')
                ])
            </div>
        </div>
    </div>
</x-app-layout>
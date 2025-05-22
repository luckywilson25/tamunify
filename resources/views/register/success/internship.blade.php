@section('title', 'Pendaftaran Berhasil')

<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 p-4 py-16">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg">
            @if(session('success'))
                <div class="text-center p-6">
                    <i class="fa-solid fa-circle-check mx-auto h-16 w-16 text-green-600 mb-4"></i>

                    <h2 class="text-2xl font-semibold">{{ session('success') }}</h2>
                </div>
            @endif
            @if(session('data'))
                @php
                    $data = session('data');
                @endphp
                <div class="text-center p-6">
                    <i class="fa-solid fa-circle-check mx-auto h-16 w-16 text-green-600 mb-4"></i>

                    <h2 class="text-2xl font-semibold">Pendaftaran Magang Berhasil!</h2>
                </div>

                <div class="text-center p-6">
                    <p class="text-gray-600 mb-6">
                        Data pendaftaran magang Anda telah berhasil disubmit. Tim kami akan memproses pendaftaran Anda.
                    </p>

                    <div class="bg-[#006838] border border-[#006838] rounded-lg p-4 mb-6 text-green-100 ">
                        <div class="flex items-center justify-center gap-2 mb-4">

                            <h3 class="font-medium text-green-100 text-lg">Status Pendaftaran: Menunggu Persetujuan</h3>
                        </div>

                        <div class="flex items-center justify-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-green-100 -mt-6 -ml-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6M5 8h14M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8" />
                            </svg>
                            <p class="text-sm mb-4 text-green-100 ">
                                Pendaftaran anda sedang dalam proses review oleh departemen terkait. Kami akan mengirimkan
                                email konfirmasi dalam 24 jam kerja.
                            </p>
                        </div>

                        <div class="flex items-center justify-center gap-2 text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-100" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 0 0 2.22 0L21 8m-18 8h18a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H3a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2z" />
                            </svg>
                            <span class="text-green-100 ">Cek email Anda secara berkala untuk informasi selanjutnya</span>
                        </div>
                    </div>

                    <div class="text-sm text-gray-600 text-left space-y-2">
                        <p class="font-medium">Langkah Selanjutnya:</p>
                        <ul class="list-disc list-outside pl-5 space-y-1">
                            <li>Tim kami akan mereview pendaftaran Anda</li>
                            <li>Jika disetujui, Anda akan menerima email konfirmasi dengan detail selanjutnya</li>
                            <li>Anda akan diminta untuk mengambil kartu akses magang pada hari pertama</li>
                            <li>Kartu akses magang akan aktif selama periode magang yang disetujui</li>
                            <li>Orang tua/wali yang akan mengantar-jemput dapat mendaftar sebagai tamu berulang</li>
                        </ul>
                    </div>

                </div>

                <div class="flex flex-col gap-2 p-6 border-t">
                    <a href="{{ route('register.recurring') }}" class="w-full">
                        <button class="w-full border border-gray-300 hover:bg-gray-100 py-2 rounded-md">Daftar Akses untuk
                            Orang Tua/Wali</button>
                    </a>
                    <a href="{{ route('home') }}" class="w-full mt-2">
                        <button class="w-full text-gray-700 hover:underline py-2">Kembali ke Beranda</button>
                    </a>
                </div>

                <div class="max-w-md w-full bg-white rounded-lg shadow-lg">
                @php
                    $emotions = [
                        ['value' => 5, 'emoji' => '😍', 'label' => 'Sangat Puas', 'color' => 'text-green-500'],
                        ['value' => 4, 'emoji' => '😊', 'label' => 'Puas', 'color' => 'text-emerald-400'],
                        ['value' => 3, 'emoji' => '😐', 'label' => 'Biasa', 'color' => 'text-yellow-400'],
                        ['value' => 2, 'emoji' => '😕', 'label' => 'Kurang Puas', 'color' => 'text-orange-400'],
                        ['value' => 1, 'emoji' => '😡', 'label' => 'Tidak Puas', 'color' => 'text-red-500'],
                    ];
                @endphp
    
                <div class="bg-[#006838]/5 p-6 rounded-lg" id="rating-container">
                    <h3 class="text-lg font-medium text-[#006838] mb-4">Bagaimana pengalaman Anda dengan proses check-in
                        kami?</h3>
    
                    <form method="POST" action="{{ route('store.reaction') }}" onsubmit="return handleSubmit(event)">
                        @csrf
                        <input type="hidden" name="visitor_id" value="{{ $data['visitor']->id }}">
                        <input type="hidden" name="rating" id="ratingInput">
    
                        <div class="flex justify-center mb-6 gap-2" id="ratingOptions">
                            @foreach($emotions as $emotion)
                                <button type="button" data-value="{{ $emotion['label'] }}"
                                    class="rating-btn flex flex-col items-center p-2 rounded-lg transition-all focus:outline-none hover:bg-white/50"
                                    aria-label="{{ $emotion['label'] }}">
                                    <div class="emoji text-2xl mb-2 text-gray-400">{{ $emotion['emoji'] }}</div>
                                    <span class="label text-xs font-medium text-gray-500">{{ $emotion['label'] }}</span>
                                </button>
                            @endforeach
                        </div>
    
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Berikan komentar atau saran (opsional):</p>
                            <textarea name="feedback" rows="3" placeholder="Bagikan pengalaman atau saran Anda..."
                                class="resize-none w-full border-gray-300 rounded-md shadow-sm focus:border-[#006838] focus:ring-[#006838]"></textarea>
                        </div>
    
                        <button type="submit" class="w-full bg-[#006838] hover:bg-[#005028] text-white py-2 rounded-md"
                            id="submitBtn">
                            Kirim Penilaian
                        </button>
                    </form>
                </div>
            </div>
            @else
            

                @if(!session('success'))
                    <div class="text-center p-6">
                        <i class="fa-solid fa-circle-xmark mx-auto h-16 w-16 text-green-600 mb-4"></i>

                        <h2 class="text-2xl font-semibold">Uppss Anda Belum Melakukan Pendaftaran!</h2>
                    </div>
                @endif
                <div class="flex flex-col gap-2 p-6 border-t">
                    <a href="{{ route('home') }}" class="w-full mt-2">
                        <button class="w-full text-gray-700 hover:underline py-2">Kembali ke Beranda</button>
                    </a>
                </div>
            @endif
            
        </div>
    </div>
    <x-slot name="script">
        <script>
            let selectedRating = 0;
            const ratingButtons = document.querySelectorAll('.rating-btn');
            const ratingInput = document.getElementById('ratingInput');
            const submitBtn = document.getElementById('submitBtn');

            ratingButtons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const value = btn.getAttribute('data-value');
                    selectedRating = value;
                    ratingInput.value = value;

                    // Reset all buttons
                    ratingButtons.forEach(b => {
                        b.classList.remove('bg-white', 'shadow-md');
                        b.querySelector('.emoji').classList.remove('text-green-500', 'text-emerald-400', 'text-yellow-400', 'text-orange-400', 'text-red-500');
                        b.querySelector('.label').classList.remove('text-green-500', 'text-emerald-400', 'text-yellow-400', 'text-orange-400', 'text-red-500');
                        b.querySelector('.emoji').classList.add('text-gray-400');
                        b.querySelector('.label').classList.add('text-gray-500');
                    });

                    // Activate selected
                    btn.classList.add('bg-white', 'shadow-md');
                    const colorMap = {
                        5: 'text-green-500',
                        4: 'text-emerald-400',
                        3: 'text-yellow-400',
                        2: 'text-orange-400',
                        1: 'text-red-500',
                    };
                    const emoji = btn.querySelector('.emoji');
                    const label = btn.querySelector('.label');
                    const color = colorMap[value];

                    emoji.classList.remove('text-gray-400');
                    emoji.classList.add(color);
                    label.classList.remove('text-gray-500');
                    label.classList.add(color);
                });
            });

            function handleSubmit(e) {
                if (!selectedRating) {
                    e.preventDefault();
                    alert('Mohon berikan rating sebelum mengirim.');
                    return false;
                }
                submitBtn.disabled = true;
                submitBtn.innerText = 'Mengirim...';
                return true;
            }
        </script>
    </x-slot>
</x-guest-layout>
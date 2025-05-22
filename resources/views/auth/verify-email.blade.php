@section('title', 'Email Verifikasi')

<x-guest-layout>
    <div class="py-12 bg-base-100 flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-3xl">
            <div class="card shadow-xl bg-white border border-base-300">
                <div class="card-body space-y-4 text-center">

                    <div class="text-primary">
                        <i class="fas fa-envelope-circle-check text-6xl"></i>
                    </div>

                    <h2 class="text-2xl font-bold text-primary">
                        Verifikasi Email
                    </h2>

                    <p class="text-neutral leading-relaxed">
                        Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan
                        mengklik
                        tautan yang baru saja kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut,
                        kami akan dengan senang hati mengirimkan email baru kepada Anda.
                    </p>

                    @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success shadow-sm">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Link verifikasi baru telah dikirim ke alamat email Anda.</span>
                    </div>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:justify-between gap-4 pt-4">
                        <x-form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary w-full sm:w-auto">
                                Kirim Ulang Email Verifikasi
                            </button>
                        </x-form>

                        <x-form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-error w-full sm:w-auto">
                                Log Out
                            </button>
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
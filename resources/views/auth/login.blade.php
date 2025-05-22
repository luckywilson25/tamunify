@section('title', 'Masuk')

<x-guest-layout>
    <div class="relative min-h-screen bg-white overflow-hidden">
        <div class="absolute top-6 left-6 z-20">
            <a href="{{ route('home') }}"
                class="inline-flex items-center text-sm font-medium text-[#006838] hover:text-[#005028] transition-colors bg-white/80 backdrop-blur-sm py-2 px-4 rounded-full shadow-sm hover:shadow-md">
                <i class="fa-solid fa-arrow mr-2-left w-4 h-4"></i>
                Kembali ke Beranda
            </a>
        </div>

        <div class="absolute inset-0 -z-10">
            <svg width="100%" height="100%" class="absolute inset-0 opacity-[0.03]">
                <pattern id="pattern-circles" x="0" y="0" width="50" height="50" pattern-units="userSpaceOnUse"
                    pattern-content-units="userSpaceOnUse">
                    <circle id="pattern-circle" cx="10" cy="10" r="1.6257413380501518" fill="#006838"></circle>
                </pattern>
                <rect id="rect" x="0" y="0" width="100%" height="100%" fill="url(#pattern-circles)"></rect>
            </svg>
        </div>

        <div class="absolute top-0 right-0 h-screen w-1/2 bg-gradient-to-bl from-[#e6f4ea]/30 via-white to-white -z-10">
        </div>
        <div
            class="absolute bottom-0 left-0 h-screen w-1/2 bg-gradient-to-tr from-[#e6f4ea]/30 via-white to-white -z-10">
        </div>
        <div class="absolute top-[15%] right-[10%] w-64 h-64 rounded-full bg-[#006838]/5 blur-3xl -z-10"></div>
        <div class="absolute bottom-[15%] left-[10%] w-80 h-80 rounded-full bg-[#006838]/5 blur-3xl -z-10"></div>
        <div class="absolute top-1/3 left-1/4 w-40 h-40 rounded-full bg-[#006838]/3 blur-2xl -z-10"></div>

        <div class="relative z-10 flex justify-center items-center min-h-screen px-4">

            <!-- Bagian Form Login -->
            <div class="w-full max-w-md">
                @if ($errors->any())
                <x-alert.error :errors="$errors->all()" />
                @endif

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <x-card.card-default header
                    class="static shadow-[0_20px_60px_-15px_rgba(0,104,56,0.1)] rounded-2xl overflow-hidden p-0">

                    <div>
                        <h1 class="text-[#006838] text-xl font-bold">Login Admin</h1>
                        <p class="text-xs">Masuk ke dashboard admin untuk mengelola sistem tamu</p>
                    </div>

                    <x-form action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div>
                            <x-input.input-label for="email" :value="__('Email')" />
                            <x-input.text-input id="email" class="mt-1 w-full" type="text" name="email"
                                :value="old('email')" required autofocus autocomplete="email" />
                            <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4" x-data="{ show: false }">
                            <x-input.input-label for="password" :value="__('Password')" />

                            <label class="input text-base-content w-full">
                                <input :type="show ? 'text' : 'password'" id="password" name="password" class="grow"
                                    required autocomplete="current-password" />
                                <button type="button" @click="show = !show" class="ml-2 text-sm">
                                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.993 9.993 0 013.065-4.412M6.4 6.4A9.965 9.965 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.974 9.974 0 01-4.205 5.234M15 12a3 3 0 01-4.65 2.55M9.878 9.878A3 3 0 0115 12m-6 0a3 3 0 003 3m9 6l-18-18" />
                                    </svg>
                                </button>
                            </label>

                            <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="mt-4 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-4">
                            <x-input.input-label for="remember" class="label cursor-pointer mr-3">
                                <x-input.checkbox name="remember" id="remember" :title="__('Remember Me')" />
                            </x-input.input-label>

                            @if (Route::has('password.request'))
                            <a class="underline text-sm link text-start sm:order-1"
                                href="{{ route('password.request') }}">
                                {{ __('Lupa kata sandi?') }}
                            </a>
                            @endif
                        </div>

                        <div class="mt-4">
                            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-4">


                                <div class="flex gap-4 sm:order-2 justify-start w-full">
                                    <x-button.default-button
                                        class="text-white w-full bg-gradient-to-r from-[#006838] to-[#00a550] hover:from-[#005028] hover:to-[#008a40] transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98] shadow-md hover:shadow-lg"
                                        type="submit">
                                        {{ __('Log in') }}
                                    </x-button.default-button>
                                </div>


                            </div>


                        </div>
                    </x-form>
                </x-card.card-default>
            </div>
        </div>
    </div>
</x-guest-layout>
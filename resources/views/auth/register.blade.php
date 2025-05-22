@section('title', 'Daftar Akun')

<x-guest-layout>
    <div class="py-12">
        <div class="w-2/3 mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <x-alert.error :errors="$errors->all()" />
            @endif

            <x-card.card-default class="static shadow-xl">
                <x-form action="{{ route('register') }}" class="md:grid md:grid-cols-2 gap-4">
                    @csrf

                    <!-- First Name -->
                    <div>
                        <x-input.input-label for="first_name" :value="__('Nama Depan')" />
                        <x-input.text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                            :value="old('first_name')" required autofocus autocomplete="first_name"
                            placeholder="John" />
                        <x-input.input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-input.input-label for="last_name" :value="__('Nama Belakang')" />
                        <x-input.text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                            :value="old('last_name')" required autofocus autocomplete="last_name" placeholder="Doe" />
                        <x-input.input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <!-- Phone Number -->
                    <div class="mt-4">
                        <x-input.input-label for="phone" :value="__('No Telpon')" />
                        <x-input.text-input id="phone" class="block mt-1 w-full" type="phone" name="phone"
                            :value="old('phone')" required autocomplete="phone" placeholder="08xxxxx" />
                        <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Gender -->
                    <div class="mt-4">
                        <x-input.input-label for="gender" :value="__('Jenis Kelamin')" />
                        <x-input.select-input id="gender" class="mt-1 w-full" type="text" name="gender" required
                            autofocus autocomplete="gender">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki - Laki" {{ old('gender')=='Laki - Laki' ? ' selected' : ' ' }}>Laki -
                                Laki
                            </option>
                            <option value="Perempuan" {{ old('gender')=='Perempuan' ? ' selected' : ' ' }}>Perempuan
                            </option>
                        </x-input.select-input>
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input.input-label for="email" :value="__('Email')" />
                        <x-input.text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="email" placeholder="john@gmail.com" />
                        <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div></div>

                    <!-- Password -->
                    <div class="mt-4" x-data="{
                        show: false,
                        password: '',
                        get hasUppercase() { return /[A-Z]/.test(this.password) },
                        get hasNumber() { return /\d/.test(this.password) },
                        get hasMinLength() { return this.password.length >= 8 }
                    }">
                        <x-input.input-label for="password" :value="__('Password')" />

                        <label class="input text-base-content w-full mt-1">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" class="mt-1 grow"
                                required autocomplete="new-password" x-model="password" />
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

                        {{-- Error message server-side --}}
                        <x-input.input-error :messages="$errors->get('password')" class="mt-2" />

                        {{-- Realtime Password Checklist --}}
                        <ul class="text-sm mt-2 space-y-1">
                            <li :class="hasMinLength ? 'text-success' : 'text-error'">
                                <i :class="hasMinLength ? 'fas fa-check-circle' : 'fas fa-circle-xmark'"
                                    class="mr-2"></i>
                                Minimal 8 karakter
                            </li>
                            <li :class="hasUppercase ? 'text-success' : 'text-error'">
                                <i :class="hasUppercase ? 'fas fa-check-circle' : 'fas fa-circle-xmark'"
                                    class="mr-2"></i>
                                Mengandung huruf kapital
                            </li>
                            <li :class="hasNumber ? 'text-success' : 'text-error'">
                                <i :class="hasNumber ? 'fas fa-check-circle' : 'fas fa-circle-xmark'" class="mr-2"></i>
                                Mengandung angka
                            </li>
                        </ul>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input.input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

                        <x-input.text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4 col-span-2">
                        @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="link">
                            <x-button.link-button type="button">
                                {{ __('Sudah Daftar?') }}
                            </x-button.link-button>
                        </a>
                        @endif

                        <x-button.primary-button class="ms-4">
                            {{ __('Daftar') }}
                        </x-button.primary-button>
                    </div>
                </x-form>
            </x-card.card-default>
        </div>
    </div>
</x-guest-layout>
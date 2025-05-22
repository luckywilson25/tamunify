@section('title', 'Reset Kata Sandi')

<x-guest-layout>
    <div class="py-12">
        <div class="w-2/3 mx-auto sm:px-6 lg:px-8">
            <x-card.card-default class="static shadow-xl">
                <x-form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input.input-label for="email" :value="__('Email')" />
                        <x-input.text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4" x-data="{ show: false }">
                        <x-input.input-label for="password" :value="__('Password')" />

                        <label class="input text-base-content w-full">
                            <input :type="show ? 'text' : 'password'" id="password" name="password" class="grow"
                                required autocomplete="new-password" />
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

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input.input-label for="password_confirmation" :value="__('Konfirmasi Password')" />

                        <x-input.text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />

                        <x-input.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button.primary-button>
                            {{ __('Reset Password') }}
                        </x-button.primary-button>
                    </div>
                </x-form>
            </x-card.card-default>
        </div>
    </div>
</x-guest-layout>
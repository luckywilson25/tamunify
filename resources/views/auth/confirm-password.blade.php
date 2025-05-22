@section('title', 'Reset Kata Sandi')

<x-guest-layout>
    <div class="py-12">
        <div class="w-2/3 mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <x-card.card-default class="static shadow-xl">
                <x-form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div>
                        <x-input.input-label for="password" :value="__('Password')" />

                        <x-input.text-input id="password" class="block mt-1 w-full" type="password" name="password"
                            required autocomplete="current-password" />

                        <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex justify-end mt-4">
                        <x-button.primary-button>
                            {{ __('Confirm') }}
                        </x-button.primary-button>
                    </div>
                </x-form>
            </x-card.card-default>
        </div>
    </div>
</x-guest-layout>
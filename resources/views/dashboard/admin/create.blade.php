@section('title', 'Tambah Data Admin')

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card.card-default class="static">
                <a href="{{ route('admin.index') }}">
                    <x-button.info-button>
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </x-button.info-button>
                </a>

                @if ($errors->any())
                <div role="alert" class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                    @endforeach
                </div>
                @endif

                <x-form action="{{ route('admin.store') }}" class="md:grid md:grid-cols-2 gap-4"
                    enctype="multipart/form-data">
                    @csrf


                    <div class="mt-4">
                        <x-input.input-label for="email" :value="__('Email')" />
                        <x-input.text-input id="email" class="mt-1 w-full" type="text" name="email"
                            :value="old('email')" required autofocus autocomplete="email" />
                        <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input.input-label for="name" :value="__('Nama')" />
                        <x-input.text-input id="name" class="mt-1 w-full" type="text" name="name" :value="old('name')"
                            required autofocus autocomplete="name" />
                        <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input.input-label for="department" :value="__('Departemen')" />
                        <x-input.select-input id="department" class="mt-1 w-full" type="text" name="department">
                            <option value="" disabled selected>Pilih Departemen</option>
                            @foreach (\App\Enums\DepartmentType::cases() as $department)
                            <option value="{{ $department->value }}" {{ old('department')==$department->value ?
                                'selected' : '' }}>
                                {{ $department->value }}
                            </option>
                            @endforeach
                        </x-input.select-input>
                        <x-input.input-error :messages="$errors->get('department')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input.input-label for="password" :value="__('Password')" />
                        <x-input.text-input id="password" class="mt-1 w-full" type="password" name="password" required
                            autocomplete="new-password" />
                        <x-input.input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input.input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-input.text-input id="password_confirmation" class="mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input.input-label for="status" :value="__('Status')" />
                        <x-input.select-input id="status" class="mt-1 w-full" type="text" name="status">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Active" {{ old('status')=='Active' ? 'selected' : '' }}>
                                Aktif
                            </option>
                            <option value="Inactive" {{ old('status')=='Inactive' ? 'selected' : '' }}>
                                Tidak Aktif
                            </option>
                        </x-input.select-input>
                        <x-input.input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="col-span-2">
                        <x-button.primary-button type="submit">
                            {{ __('Simpan') }}
                        </x-button.primary-button>
                    </div>

                </x-form>
            </x-card.card-default>
        </div>
    </div>

</x-app-layout>
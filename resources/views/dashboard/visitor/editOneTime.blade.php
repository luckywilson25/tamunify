@section('title', 'Edit Tamu Umum')
@section('header', 'Edit Tamu Umum')

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card.card-default class="static">
                <a href="{{ route('visitor.index') }}">
                    <x-button.info-button>
                        <i class="fa-solid fa-arrow-left"></i>
                        Kembali
                    </x-button.info-button>
                </a>
                @if (session()->has('success'))
                <x-alert.success :message="session('success')" />
                @endif

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

                <form action="{{ route('visitor.update.one-time', $visitor->id) }}" method="POST"
                    enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    {{-- Data Diri --}}
                    <div class="mb-6">
                        <div class="grid md:grid-cols-2 gap-4">

                            <div class="mb-4">
                                <x-input.input-label for="name" :value="__('Nama Lengkap')" />
                                <x-input.text-input id="name" class="mt-1 w-full" type="text" name="name"
                                    :value="old('name', $visitor->name)" required autofocus autocomplete="name"
                                    placeholder="Masukan nama lengkap" />
                                <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="identity_number" :value="__('NIK / No. Identitas')" />
                                <x-input.text-input id="identity_number" class="mt-1 w-full" type="number"
                                    name="identity_number" :value="old('identity_number', $visitor->identity_number)"
                                    required autofocus autocomplete="identity_number"
                                    placeholder="Masukan nomor identitas" />
                                <x-input.input-error :messages="$errors->get('identity_number')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="company" :value="__('Perusahaan / Instansi')" />
                                <x-input.text-input id="company" class="mt-1 w-full" type="text" name="company"
                                    :value="old('company', $visitor->general->company)" required autofocus
                                    autocomplete="company" placeholder="Masukan nama perusahaan" />
                                <x-input.input-error :messages="$errors->get('company')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-input.text-input id="phone" class="mt-1 w-full" type="number" name="phone"
                                    :value="old('phone', $visitor->phone)" required autofocus autocomplete="phone"
                                    placeholder="Masukan nomor telepon" />
                                <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="email" :value="__('Email')" />
                                <x-input.text-input id="email" class="mt-1 w-full" type="email" name="email"
                                    :value="old('email', $visitor->email)" required autofocus autocomplete="email"
                                    placeholder="Masukan alamat email" />
                                <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="purpose" :value="__('Tujuan Kunjungan')" />
                                <x-input.select-input id="purpose" class="mt-1 w-full" type="text" name="purpose"
                                    required autofocus autocomplete="purpose">
                                    <option value="" disabled selected>Pilih Tujuan Kunjungan</option>
                                    @foreach (\App\Enums\PurposeType::cases() as $purpose)
                                    <option value="{{ $purpose->value }}" {{ old('purpose', $visitor->
                                        general->purpose->value)
                                        == $purpose->value ? 'selected' : '' }}>
                                        {{ $purpose->value }}
                                    </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('purpose')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="person_to_meet" :value="__('Orang yang ingin anda temui')" />
                                <x-input.text-input id="person_to_meet" class="mt-1 w-full" type="text"
                                    name="person_to_meet"
                                    :value="old('person_to_meet', $visitor->general->person_to_meet)" required autofocus
                                    autocomplete="person_to_meet"
                                    placeholder="Masukan nama orang yang ingin anda temui" />
                                <x-input.input-error :messages="$errors->get('person_to_meet')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="department" :value="__('Departement / Divisi')" />
                                <x-input.select-input id="department" class="mt-1 w-full" type="text" name="department"
                                    required autofocus autocomplete="department">
                                    <option value="" disabled selected>Pilih Departement / Divisi</option>
                                    @foreach (\App\Enums\DepartmentType::cases() as $department)
                                    <option value="{{ $department->value }}" {{ old('department', $visitor->
                                        general->department->value) == $department->value ? 'selected' : '' }}>
                                        {{ $department->value }}
                                    </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('department')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="visit_date" :value="__('Tanggal Kunjungan')" />
                                <x-input.text-input id="visit_date" class="mt-1 w-full" type="date" name="visit_date"
                                    :value="old('visit_date', $visitor->general->visit_date?->format('Y-m-d'))" required
                                    autofocus autocomplete="visit_date" />
                                <x-input.input-error :messages="$errors->get('visit_date')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="exit_date" :value="__('Tanggal Keluar Kunjungan')" />
                                <x-input.text-input id="exit_date" class="mt-1 w-full" type="date" name="exit_date"
                                    :value="old('exit_date', $visitor->general->exit_date?->format('Y-m-d'))" required
                                    autofocus autocomplete="exit_date" />
                                <x-input.input-error :messages="$errors->get('exit_date')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="visit_time" :value="__('Waktu Kunjungan')" />
                                <x-input.text-input id="visit_time" class="mt-1 w-full" type="time" name="visit_time"
                                    :value="old('visit_time', $visitor->general->visit_time)" required autofocus
                                    autocomplete="visit_time" />
                                <x-input.input-error :messages="$errors->get('visit_time')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="exit_time" :value="__('Waktu Keluar Kunjungan')" />
                                <x-input.text-input id="exit_time" class="mt-1 w-full" type="time" name="exit_time"
                                    :value="old('exit_time', $visitor->general->exit_time)" required autofocus
                                    autocomplete="exit_time" />
                                <x-input.input-error :messages="$errors->get('exit_time')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="vehicle_number"
                                    :value="__(key: 'Nomor Kendaraan (Opsional)')" />
                                <x-input.text-input id="vehicle_number" class="mt-1 w-full" type="text"
                                    name="vehicle_number"
                                    :value="old('vehicle_number', $visitor->general->vehicle_number)" autofocus
                                    autocomplete="vehicle_number" placeholder="Masukan nomor kendaraan" />
                                <x-input.input-error :messages="$errors->get('vehicle_number')" class="mt-2" />
                            </div>
                            <div class="mb-4 col-span-2">
                                <x-input.input-label for="additional_info"
                                    :value="__(key: 'Informasi Tambahan (Opsional)')" />
                                <x-input.text-area id="additional_info" class="mt-1 w-full" name="additional_info"
                                    :value="old('additional_info', $visitor->general->additional_info)" autofocus
                                    autocomplete="additional_info" placeholder="Masukan informasi tambahan">
                                    {{ old('additional_info') }}
                                </x-input.text-area>
                                <x-input.input-error :messages="$errors->get('additional_info')" class="mt-2" />
                            </div>

                        </div>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-4">

                        <button type="submit"
                            class="px-4 py-2 bg-[#006838] text-white rounded hover:bg-[#004d29]">Simpan</button>
                    </div>
                </form>
            </x-card.card-default>
        </div>
    </div>
</x-app-layout>
@section('title', 'Edit Tamu Magang')
@section('header', 'Edit Tamu Magang')

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


                <form action="{{ route('visitor.update.internship', $visitor->id) }}" method="POST"
                    enctype="multipart/form-data" class="p-6">
                    @csrf
                    @method('PUT')

                    {{-- Data Diri --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Data Diri Peserta</h3>
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
                                <x-input.input-label for="institution" :value="__('Institusi Pendidikan')" />
                                <x-input.text-input id="institution" class="mt-1 w-full" type="text" name="institution"
                                    :value="old('institution', $visitor->internship->institution)" required autofocus
                                    autocomplete="institution" placeholder="Masukan nama institusi pendidikan" />
                                <x-input.input-error :messages="$errors->get('institution')" class="mt-2" />
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


                        </div>
                    </div>

                    {{-- Informasi Magang --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Informasi Magang</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input.input-label for="internship_start" :value="__('Tanggal Mulai Magang')" />
                                <x-input.text-input id="internship_start" class="mt-1 w-full" type="date"
                                    name="internship_start"
                                    :value="old('internship_start', $visitor->internship->internship_start?->format('Y-m-d'))"
                                    autofocus autocomplete="internship_start" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="internship_end" :value="__('Tanggal Selesai Magang')" />
                                <x-input.text-input id="internship_end" class="mt-1 w-full" type="date"
                                    name="internship_end"
                                    :value="old('internship_end', $visitor->internship->internship_end?->format('Y-m-d'))"
                                    autofocus autocomplete="internship_end" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="department" :value="__('Departement yang dituju')" />
                                <x-input.select-input id="department" class="mt-1 w-full" type="text" name="department"
                                    required autofocus autocomplete="department">
                                    <option value="" disabled selected>Pilih Departement</option>
                                    @foreach (\App\Enums\DepartmentType::cases() as $department)
                                    <option value="{{ $department->value }}" {{ old('department', $visitor->
                                        internship->department->value)==$department->value ?
                                        'selected' : '' }}>
                                        {{ $department->value }}
                                    </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('department')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="supervisor" :value="__('Pembimbing (jika sudah
                                            ada)')" />
                                <x-input.text-input id="supervisor" class="mt-1 w-full" type="text" name="supervisor"
                                    :value="old('supervisor', $visitor->internship->supervisor)" autofocus
                                    autocomplete="supervisor" placeholder="Masukan nama pembimbing" />
                                <x-input.input-error :messages="$errors->get('supervisor')" class="mt-2" />
                            </div>


                        </div>
                    </div>

                    {{-- Kontak Darurat --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Kontak Darurat</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input.input-label for="emergency_contact_name" :value="__('Nama Kontak Darurat')" />
                                <x-input.text-input id="emergency_contact_name" class="mt-1 w-full" type="text"
                                    name="emergency_contact_name"
                                    :value="old('emergency_contact_name', $visitor->internship->emergency_contact_name)"
                                    required autofocus autocomplete="emergency_contact_name"
                                    placeholder="Masukan nama kontak darurat" />
                                <x-input.input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="emergency_contact_phone" :value="__('Nama Kontak Darurat')" />
                                <x-input.text-input id="emergency_contact_phone" class="mt-1 w-full" type="number"
                                    name="emergency_contact_phone"
                                    :value="old('emergency_contact_phone', $visitor->internship->emergency_contact_phone)"
                                    required autofocus autocomplete="emergency_contact_phone"
                                    placeholder="Masukan nomor telepon darurat" />
                                <x-input.input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="emergency_contact_relation" :value="__('Hubungan')" />
                                <x-input.select-input id="emergency_contact_relation" class="mt-1 w-full" type="text"
                                    name="emergency_contact_relation" required autofocus
                                    autocomplete="emergency_contact_relation">
                                    <option value="" disabled selected>Pilih Hubungan</option>
                                    @foreach (\App\Enums\ContactType::cases() as $relation)
                                    <option value="{{ $relation->value }}" {{ old('emergency_contact_relation',
                                        $visitor->internship->emergency_contact_relation->value)==$relation->value ?
                                        'selected' : '' }}>
                                        {{ $relation->value }}
                                    </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('emergency_contact_relation')"
                                    class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col-span-2">
                        <x-input.input-label for="additional_info" :value="__(key: 'Informasi Tambahan (Opsional)')" />
                        <x-input.text-area id="additional_info" class="mt-1 w-full" name="additional_info"
                            :value="old('additional_info', $visitor->internship->additional_info)" autofocus
                            autocomplete="additional_info" placeholder="Masukan informasi tambahan">
                            {{ old('additional_info') }}
                        </x-input.text-area>
                        <x-input.input-error :messages="$errors->get('additional_info')" class="mt-2" />
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
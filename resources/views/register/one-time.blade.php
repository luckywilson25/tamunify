@section('title', 'Pendaftaran Tamu Umum')

<x-guest-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto w-full">

            <a href="{{ route('checkin') }}"
                class="mt-4 inline-flex items-center text-[#006838] mb-6 hover:underline font-semibold">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Beranda
            </a>

            <div class="shadow-lg rounded-lg overflow-hidden bg-white">

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

                <div class="bg-[#006838] text-white p-6 rounded-t-lg">
                    <h2 class="text-2xl font-semibold">Pendaftaran Tamu Umum</h2>
                    <p class="text-white">Silakan isi data diri Anda untuk mendaftar kunjungan satu kali</p>
                </div>

                <form action="{{ route('store.one-time') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    {{-- Data Diri --}}
                    <div class="mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Nama Lengkap -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="name" :value="__('Nama Lengkap')" />
                                <x-input.text-input id="name" class="mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autocomplete="name"
                                    placeholder="Masukan nama lengkap" />
                                <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- NIK -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="identity_number" :value="__('NIK / No. Identitas')" />
                                <x-input.text-input id="identity_number" class="mt-1 w-full" type="number"
                                    name="identity_number" :value="old('identity_number')" required
                                    autocomplete="identity_number" placeholder="Masukan nomor identitas" />
                                <x-input.input-error :messages="$errors->get('identity_number')" class="mt-2" />
                            </div>

                            <!-- Perusahaan -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="company" :value="__('Perusahaan / Instansi')" />
                                <x-input.text-input id="company" class="mt-1 w-full" type="text" name="company"
                                    :value="old('company')" required autocomplete="company"
                                    placeholder="Masukan nama perusahaan" />
                                <x-input.input-error :messages="$errors->get('company')" class="mt-2" />
                            </div>

                            <!-- Telepon -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-input.text-input id="phone" class="mt-1 w-full" type="number" name="phone"
                                    :value="old('phone')" required autocomplete="phone"
                                    placeholder="Masukan nomor telepon" />
                                <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="email" :value="__('Email')" />
                                <x-input.text-input id="email" class="mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autocomplete="email"
                                    placeholder="Masukan alamat email" />
                                <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Tujuan -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="purpose" :value="__('Tujuan Kunjungan')" />
                                <x-input.select-input id="purpose" class="mt-1 w-full" name="purpose" required
                                    autocomplete="purpose">
                                    <option value="" disabled selected>Pilih Tujuan Kunjungan</option>
                                    @foreach (\App\Enums\PurposeType::cases() as $purpose)
                                        <option value="{{ $purpose->value }}" {{ old('purpose') == $purpose->value ? 'selected' : '' }}>
                                            {{ $purpose->value }}
                                        </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('purpose')" class="mt-2" />

                                <!-- Tujuan lainnya -->
                                <input type="text" name="purpose_more" id="purpose_more"
                                    class="mt-2 w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Masukkan nama departemen lain" value="{{ old('purpose_more') }}"
                                    style="{{ old('purpose') == 'Lainnya' ? '' : 'display:none;' }}" />
                            </div>

                            <!-- Orang yang ingin ditemui -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="person_to_meet" :value="__('Orang yang ingin anda temui')" />
                                <x-input.text-input id="person_to_meet" class="mt-1 w-full" type="text"
                                    name="person_to_meet" :value="old('person_to_meet')" required
                                    autocomplete="person_to_meet" placeholder="Masukan nama orang" />
                                <x-input.input-error :messages="$errors->get('person_to_meet')" class="mt-2" />
                            </div>

                            <!-- Departemen -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="department" :value="__('Departement / Divisi')" />
                                <x-input.select-input id="department" class="mt-1 w-full" name="department" required
                                    autocomplete="department">
                                    <option value="" disabled selected>Pilih Departement / Divisi</option>
                                    @foreach (\App\Enums\DepartmentType::cases() as $department)
                                        <option value="{{ $department->value }}" {{ old('department') == $department->value ? 'selected' : '' }}>
                                            {{ $department->value }}
                                        </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('department')" class="mt-2" />
                                <input type="text" name="department_more" id="department_more"
                                    class="mt-2 w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Masukkan nama departemen lain" value="{{ old('department_more') }}"
                                    style="{{ old('department') == 'Lainnya' ? '' : 'display:none;' }}" />
                            </div>

                            <!-- Tanggal Kunjungan -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="visit_date" :value="__('Tanggal Kunjungan')" />
                                <x-input.text-input id="visit_date" class="mt-1 w-full" type="date" name="visit_date"
                                    :value="old('visit_date')" required autocomplete="visit_date" />
                                <x-input.input-error :messages="$errors->get('visit_date')" class="mt-2" />
                            </div>

                            <!-- Tanggal Keluar -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="exit_date" :value="__('Tanggal Keluar Kunjungan')" />
                                <x-input.text-input id="exit_date" class="mt-1 w-full" type="date" name="exit_date"
                                    :value="old('exit_date')" required autocomplete="exit_date" />
                                <x-input.input-error :messages="$errors->get('exit_date')" class="mt-2" />
                            </div>

                            <!-- Waktu Masuk -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="visit_time" :value="__('Waktu Kunjungan')" />
                                <x-input.text-input id="visit_time" class="mt-1 w-full" type="time" name="visit_time"
                                    :value="old('visit_time')" required autocomplete="visit_time" />
                                <x-input.input-error :messages="$errors->get('visit_time')" class="mt-2" />
                            </div>

                            <!-- Waktu Keluar -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="exit_time" :value="__('Waktu Keluar Kunjungan')" />
                                <x-input.text-input id="exit_time" class="mt-1 w-full" type="time" name="exit_time"
                                    :value="old('exit_time')" required autocomplete="exit_time" />
                                <x-input.input-error :messages="$errors->get('exit_time')" class="mt-2" />
                            </div>

                            <!-- Nomor Kendaraan -->
                            <div class="lg:col-span-2">
                                <x-input.input-label for="vehicle_number" :value="__('Nomor Kendaraan (Opsional)')" />
                                <x-input.text-input id="vehicle_number" class="mt-1 w-full" type="text"
                                    name="vehicle_number" :value="old('vehicle_number')" autocomplete="vehicle_number"
                                    placeholder="Masukan nomor kendaraan" />
                                <x-input.input-error :messages="$errors->get('vehicle_number')" class="mt-2" />
                            </div>

                            <!-- Informasi Tambahan -->
                            <div class="col-span-1 sm:col-span-2 lg:col-span-4">
                                <x-input.input-label for="additional_info" :value="__('Informasi Tambahan (Opsional)')" />
                                <x-input.text-area id="additional_info" class="mt-1 w-full" name="additional_info"
                                    placeholder="Masukan informasi tambahan">{{ old('additional_info') }}</x-input.text-area>
                                <x-input.input-error :messages="$errors->get('additional_info')" class="mt-2" />
                            </div>

                            <!-- Foto Diri -->
                            <div class="col-span-1 sm:col-span-2 lg:col-span-4 space-y-2">
                                <label class="block text-sm font-medium">Foto Diri</label>
                                <div class="border-2 border-dashed border-[#a3c4a1] rounded-lg p-4 text-center">
                                    <i class="fa-solid fa-upload mx-auto h-8 w-8 text-gray-400"></i>
                                    <p class="mt-2 text-xs text-gray-500">Klik untuk mengambil foto atau unggah foto
                                        Anda</p>
                                    <input type="file" name="photo"
                                        class="mt-2 text-xs h-8 w-full border border-gray-300 rounded"
                                        accept="image/*" />
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- Tombol --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('checkin') }}"
                            class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-[#006838] text-white rounded hover:bg-[#004d29]">Daftar
                            Kunjugan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const departmentSelect = document.getElementById('department');
                const departmentMore = document.getElementById('department_more');
                const purposeSelect = document.getElementById('purpose');
                const purposeMore = document.getElementById('purpose_more');

                departmentSelect.addEventListener('change', function () {
                    departmentMore.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });

                purposeSelect.addEventListener('change', function () {
                    purposeMore.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });
            });
        </script>
    </x-slot>
</x-guest-layout>
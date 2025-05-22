@section('title', 'Pendaftaran Magang')

<x-guest-layout>
    <div class="min-h-screen bg-gray-50 py-6 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto w-full max-w-3xl">

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
                    <h2 class="text-2xl font-semibold">Pendaftaran Magang/PKL</h2>
                    <p class="text-white">Silakan isi data diri Anda untuk mendaftar program magang atau praktik kerja
                        lapangan</p>
                </div>

                <form action="{{ route('store.internship') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    {{-- Data Diri --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Data Diri Peserta</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input.input-label for="name" :value="__('Nama Lengkap')" />
                                <x-input.text-input id="name" class="mt-1 w-full" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name"
                                    placeholder="Masukan nama lengkap" />
                                <x-input.input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="identity_number" :value="__('NIK / No. Identitas')" />
                                <x-input.text-input id="identity_number" class="mt-1 w-full" type="number"
                                    name="identity_number" :value="old('identity_number')" required autofocus
                                    autocomplete="identity_number" placeholder="Masukan nomor identitas" />
                                <x-input.input-error :messages="$errors->get('identity_number')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="institution" :value="__('Institusi Pendidikan')" />
                                <x-input.text-input id="institution" class="mt-1 w-full" type="text" name="institution"
                                    :value="old('institution')" required autofocus autocomplete="institution"
                                    placeholder="Masukan nama institusi pendidikan" />
                                <x-input.input-error :messages="$errors->get('institution')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="phone" :value="__('Nomor Telepon')" />
                                <x-input.text-input id="phone" class="mt-1 w-full" type="number" name="phone"
                                    :value="old('phone')" required autofocus autocomplete="phone"
                                    placeholder="Masukan nomor telepon" />
                                <x-input.input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="email" :value="__('Email')" />
                                <x-input.text-input id="email" class="mt-1 w-full" type="email" name="email"
                                    :value="old('email')" required autofocus autocomplete="email"
                                    placeholder="Masukan alamat email" />
                                <x-input.input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mb-4">
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

                    {{-- Informasi Magang --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Informasi Magang</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <!-- Tanggal Mulai Magang -->
                            <div>
                                <x-input.input-label for="internship_start" :value="__('Tanggal Mulai Magang')" />
                                <x-input.text-input id="internship_start" class="mt-1 w-full" type="date"
                                    name="internship_start" :value="old('internship_start')" autofocus
                                    autocomplete="internship_start" />
                            </div>

                            <!-- Tanggal Selesai Magang -->
                            <div>
                                <x-input.input-label for="internship_end" :value="__('Tanggal Selesai Magang')" />
                                <x-input.text-input id="internship_end" class="mt-1 w-full" type="date"
                                    name="internship_end" :value="old('internship_end')" autofocus
                                    autocomplete="internship_end" />
                            </div>

                            <!-- Departemen -->
                            <div>
                                <x-input.input-label for="department" :value="__('Departemen yang dituju')" />
                                <x-input.select-input id="department" class="mt-1 w-full" name="department" required>
                                    <option value="" disabled selected>Pilih Departemen</option>
                                    @foreach (\App\Enums\DepartmentType::cases() as $department)
                                        <option value="{{ $department->value }}" {{ old('department') == $department->value ? 'selected' : '' }}>
                                            {{ $department->value }}
                                        </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('department')" class="mt-2" />

                                <!-- Input Departemen Lain -->
                                <input type="text" name="department_more" id="department_more"
                                    class="mt-2 w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Masukkan nama departemen lain" value="{{ old('department_more') }}"
                                    style="{{ old('department') == 'Lainnya' ? '' : 'display:none;' }}" />
                            </div>

                            <!-- Pembimbing -->
                            <div>
                                <x-input.input-label for="supervisor" :value="__('Pembimbing (jika sudah ada)')" />
                                <x-input.text-input id="supervisor" class="mt-1 w-full" type="text" name="supervisor"
                                    :value="old('supervisor')" autofocus autocomplete="supervisor"
                                    placeholder="Masukan nama pembimbing" />
                                <x-input.input-error :messages="$errors->get('supervisor')" class="mt-2" />
                            </div>

                            <!-- Surat Pengantar -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium">Surat Pengantar</label>
                                <div class="border-2 border-dashed border-[#a3c4a1] rounded-lg p-4 text-center">
                                    <i class="fa-solid fa-upload mx-auto h-8 w-8 text-gray-400"></i>
                                    <p class="mt-2 text-xs text-gray-500">Unggah surat pengantar dari institusi
                                        pendidikan</p>
                                    <input type="file" name="referral_letter"
                                        class="mt-2 text-xs h-8 w-full border border-gray-300 rounded" />
                                </div>
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
                                    name="emergency_contact_name" :value="old('emergency_contact_name')" required
                                    autofocus autocomplete="emergency_contact_name"
                                    placeholder="Masukan nama kontak darurat" />
                                <x-input.input-error :messages="$errors->get('emergency_contact_name')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="emergency_contact_phone" :value="__('Nama Kontak Darurat')" />
                                <x-input.text-input id="emergency_contact_phone" class="mt-1 w-full" type="number"
                                    name="emergency_contact_phone" :value="old('emergency_contact_phone')" required
                                    autofocus autocomplete="emergency_contact_phone"
                                    placeholder="Masukan nomor telepon darurat" />
                                <x-input.input-error :messages="$errors->get('emergency_contact_phone')" class="mt-2" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="emergency_contact_relation" :value="__('Hubungan')" />
                                <x-input.select-input id="emergency_contact_relation" class="mt-1 w-full"
                                    name="emergency_contact_relation" required>
                                    <option value="" disabled selected>Pilih Hubungan</option>
                                    @foreach (\App\Enums\ContactType::cases() as $relation)
                                        <option value="{{ $relation->value }}" {{ old('emergency_contact_relation') == $relation->value ? 'selected' : '' }}>
                                            {{ $relation->value }}
                                        </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('emergency_contact_relation')"
                                    class="mt-2" />

                                <input type="text" name="emergency_contact_relation_more"
                                    id="emergency_contact_relation_more"
                                    class="mt-2 w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Masukkan hubungan lain"
                                    value="{{ old('emergency_contact_relation_more') }}"
                                    style="{{ old('emergency_contact_relation') == 'Lainnya' ? '' : 'display:none;' }}" />
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 col-span-2">
                        <x-input.input-label for="additional_info" :value="__(key: 'Informasi Tambahan (Opsional)')" />
                        <x-input.text-area id="additional_info" class="mt-1 w-full" name="additional_info"
                            :value="old('additional_info')" autofocus autocomplete="additional_info"
                            placeholder="Masukan informasi tambahan">
                            {{ old('additional_info') }}
                        </x-input.text-area>
                        <x-input.input-error :messages="$errors->get('additional_info')" class="mt-2" />
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('checkin') }}"
                            class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">Batal</a>
                        <button type="submit"
                            class="px-4 py-2 bg-[#006838] text-white rounded hover:bg-[#004d29]">Daftar
                            Magang</button>
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
                const relationSelect = document.getElementById('emergency_contact_relation');
                const relationMore = document.getElementById('emergency_contact_relation_more');

                departmentSelect.addEventListener('change', function () {
                    departmentMore.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });

                relationSelect.addEventListener('change', function () {
                    relationMore.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });
            });
        </script>
    </x-slot>
</x-guest-layout>
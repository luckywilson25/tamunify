@section('title', 'Pendaftaran Tamu Berulang')

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
                    <h2 class="text-2xl font-semibold">Pendaftaran Tamu Berulang</h2>
                    <p class="text-white">Silakan isi data diri Anda untuk mendaftar akses berulang (orang tua/wali,
                        vendor, dll)</p>
                </div>

                <form action="{{ route('store.recurring') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    {{-- Data Diri --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Data Diri</h3>
                        <div class="grid md:grid-cols-2 gap-4">
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
                                <x-input.input-label for="company" :value="__('Perusahaan / Instansi (opsional)')" />
                                <x-input.text-input id="company" class="mt-1 w-full" type="text" name="company"
                                    :value="old('company')" autofocus autocomplete="company"
                                    placeholder="Masukan nama institusi pendidikan" />
                                <x-input.input-error :messages="$errors->get('company')" class="mt-2" />
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

                    {{-- Informasi Kunjungan --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Informasi Kunjungan</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <x-input.input-label for="recurring_type" :value="__('Tipe tamu berulang')" />
                                <x-input.select-input id="recurring_type" class="mt-1 w-full" type="text"
                                    name="recurring_type" required autofocus autocomplete="recurring_type">
                                    <option value="" disabled selected>Pilih Tipe</option>
                                    @foreach (\App\Enums\RecurringType::cases() as $recurring_type)
                                                                    <option value="{{ $recurring_type->value }}" {{
                                        old('recurring_type') == $recurring_type->value ?
                                        'selected' : '' }}>
                                                                        {{ $recurring_type->value }}
                                                                    </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('recurring_type')" class="mt-2" />

                                <input type="text" name="recurring_type_more" id="recurring_type_more"
                                    class="mt-2 w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Masukkan nama departemen lain" value="{{ old('recurring_type_more') }}"
                                    style="{{ old('recurring_type') == 'Lainnya' ? '' : 'display:none;' }}" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="related_to" :value="__('Terkait dengan')" />
                                <x-input.text-input id="related_to" class="mt-1 w-full" type="text" name="related_to"
                                    :value="old('related_to')" required autofocus autocomplete="related_to"
                                    placeholder="Nama peserta magang/proyek/department" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="relation" :value="__('Hubungan')" />
                                <x-input.select-input id="relation" class="mt-1 w-full" type="text" name="relation"
                                    required autofocus autocomplete="relation">
                                    <option value="" disabled selected>Pilih Hubungan</option>
                                    @foreach (\App\Enums\RelationType::cases() as $relation)
                                                                    <option value="{{ $relation->value }}" {{ old('relation') == $relation->value ?
                                        'selected' : '' }}>
                                                                        {{ $relation->value }}
                                                                    </option>
                                    @endforeach
                                </x-input.select-input>
                                <x-input.input-error :messages="$errors->get('relation')" class="mt-2" />

                                <input type="text" name="relation_more" id="relation_more"
                                    class="mt-2 w-full border border-gray-300 rounded px-3 py-2"
                                    placeholder="Masukkan nama departemen lain" value="{{ old('relation_more') }}"
                                    style="{{ old('relation') == 'Lainnya' ? '' : 'display:none;' }}" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="department" :value="__('Departement yang dituju')" />
                                <x-input.select-input id="department" class="mt-1 w-full" type="text" name="department"
                                    required autofocus autocomplete="department">
                                    <option value="" disabled selected>Pilih Departement</option>
                                    @foreach (\App\Enums\DepartmentType::cases() as $department)
                                                                    <option value="{{ $department->value }}" {{ old('department') == $department->value ?
                                        'selected' : '' }}>
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

                            <div class="mb-4">
                                <x-input.input-label for="access_start" :value="__('Tanggal Awal Akses')" />
                                <x-input.text-input id="access_start" class="mt-1 w-full" type="date"
                                    name="access_start" :value="old('access_start')" required autofocus
                                    autocomplete="access_start" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="access_end" :value="__('Tanggal Selesai Akses')" />
                                <x-input.text-input id="access_end" class="mt-1 w-full" type="date" name="access_end"
                                    :value="old('access_end')" required autofocus autocomplete="access_end" />
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="vehicle_number" :value="__('Nomor Kendaraan (Opsional)')" />
                                <x-input.text-input id="vehicle_number" class="mt-1 w-full" type="text"
                                    name="vehicle_number" :value="old('vehicle_number')" autofocus
                                    autocomplete="vehicle_number"
                                    placeholder="Masukan nomor kendaraan jika membawa kendaraan" />
                            </div>

                        </div>
                    </div>

                    {{-- Jadwal Kunjungan --}}
                    <div class="mb-6">
                        <h3 class="font-medium text-lg mb-2">Jadwal Kunjugan</h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="mb-4 col-span-2">
                                <label class="block text-sm font-medium mb-2">Hari Kunjungan</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @php
                                        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                                    @endphp

                                    @foreach ($days as $day)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="visit_days[]" value="{{ $day }}"
                                                class="form-checkbox text-green-600">
                                            <span class="ml-2">{{ $day }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-4">
                                <x-input.input-label for="usual_entry_time" :value="__('Jam Masuk Biasa')" />
                                <x-input.text-input id="usual_entry_time" class="mt-1 w-full" type="time"
                                    name="usual_entry_time" :value="old('usual_entry_time')" required autofocus
                                    autocomplete="usual_entry_time" />
                                <x-input.input-error :messages="$errors->get('usual_entry_time')" class="mt-2" />
                            </div>
                            <div class="mb-4">
                                <x-input.input-label for="usual_exit_time" :value="__('Jam Keluar Biasa')" />
                                <x-input.text-input id="usual_exit_time" class="mt-1 w-full" type="time"
                                    name="usual_exit_time" :value="old('usual_exit_time')" required autofocus
                                    autocomplete="usual_exit_time" />
                                <x-input.input-error :messages="$errors->get('usual_exit_time')" class="mt-2" />
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
                            Akses Berulang</button>
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
                const relationSelect = document.getElementById('relation');
                const relationMore = document.getElementById('relation_more');
                const recurringSelect = document.getElementById('recurring_type');
                const recurringMore = document.getElementById('recurring_type_more');

                departmentSelect.addEventListener('change', function () {
                    departmentMore.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });

                relationSelect.addEventListener('change', function () {
                    relationMore.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });

                recurringSelect.addEventListener('change', function () {
                    recurringMore.style.display = this.value === 'Lainnya' ? 'block' : 'none';
                });
            });
        </script>
    </x-slot>
</x-guest-layout>
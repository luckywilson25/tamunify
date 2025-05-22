@section('title', 'Data Admin')
@section('header', 'Kelola Admin')

<x-app-layout>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-card.card-default class="static">
                @if (session()->has('success'))
                <x-alert.success :message="session('success')" />
                @endif
                @if (session()->has('error'))
                <x-alert.error :message="session('error')" />
                @endif

                <div class="flex justify-start space-x-4">
                    <a href="{{ route('admin.create') }}">
                        <x-button.default-button class="border-[#006838] text-white bg-[#006838] hover:bg-[#005830]">
                            <i class="fa-solid fa-plus"></i>
                            Tambah Data
                        </x-button.default-button>
                    </a>
                </div>
                <div class="flex justify-start space-x-4">
                    <div class="mt-4">
                        <x-input.select-input id="status" class="mt-1 w-full" type="text" name="status">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="All">Semua
                            </option>
                            <option value="Active">Aktif
                            </option>
                            <option value="Inactive">Tidak Aktif
                            </option>
                        </x-input.select-input>
                    </div>
                    <div class="mt-4">
                        <x-input.select-input id="department" class="mt-1 w-full" type="text" name="department">
                            <option value="" disabled selected>Pilih Departemen</option>
                            @foreach (\App\Enums\DepartmentType::cases() as $department)
                            <option value="{{ $department->value }}" {{ old('department')==$department->value ?
                                'selected' : '' }}>
                                {{ $department->value }}
                            </option>
                            @endforeach
                        </x-input.select-input>
                    </div>
                </div>
                <div class="relative overflow-x-auto mt-5">
                    <table id="admins" class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Departemen
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </x-card.card-default>
        </div>
    </div>

    <x-slot name="script">
        <script>
            $(document).ready(function() {


                let dataTable = $('#admins').DataTable({
                    buttons: [
                        // 'copy', 'excel', 'csv', 'pdf', 'print',
                        'colvis'
                    ],
                    processing: true,
                    search: {
                        return: true
                    },
                    serverSide: true,
                    ajax: {
                        url: '{{ route('admin.index') }}',
                        beforeSend: function() {
                        Swal.fire({
                        title: 'Loading...',
                        text: 'Tunggu sebentar',
                        allowOutsideClick: false,
                        didOpen: () => {
                        Swal.showLoading();
                        }
                        });
                        },
                        complete: function() {
                        Swal.close();
                        },
                        data: function(d) {
                            d.status = $('#status').val();
                            d.department = $('#department').val();
                        }
                    },
                    columns: [{
                            data: null,
                            name: 'no',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'department',
                            name: 'department'
                        },
                        {
                            data: null,
                            render: function(data) {
                                return data.status == 'Active' ? 'Aktif' : 'Tidak Aktif';
                            },
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, full, meta) {
                                return `
                                <a href="{{ url('/dashboard/admin/${full.id}/edit') }}">
                                    <x-button.info-button type="button" class="btn-sm text-white"><i class="fa-regular fa-pen-to-square"></i>Edit</x-button.info-button>
                                </a>
                                <x-form action="{{ url('/dashboard/admin/${full.id}') }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-button.danger-button type="submit" class="btn-sm text-white" onclick="return confirm('Kamu Yakin?')"><i class="fa-regular fa-trash-can"></i>Hapus</x-button.danger-button>
                                </x-form>
                            `;
                            }
                        },
                    ]
                });
                $('#status, #department').change(function() {
                    dataTable.ajax.reload();
                });
            });
        </script>
    </x-slot>
</x-app-layout>
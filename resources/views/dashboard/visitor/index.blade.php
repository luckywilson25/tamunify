@section('title', 'Dashboard')
@section('header', 'Dashboard')

<x-app-layout>
    <div class="p-6 flex-grow">
        @if (session()->has('success'))
        <x-alert.success :message="session('success')" />
        @endif

        <x-card.card-default class="bg-white/95 rounded-lg shadow-md border border-[#006838]/20 mb-6">
            <div>
                <div class="flex items-center justify-between -mt-5">
                    <div>
                        <h3 class="text-lg font-bold text-[#006838]">Manajemen Tamu</h3>
                    </div>

                    <div class="flex items-center justify-start mb-5">
                        <i class="fa-solid fa-filter mr-1 w-4 h-4"></i>
                        <div class="mr-3">
                            <x-input.select-input id="type" class="w-full" type="text" name="type">
                                <option value="" disabled selected>Pilih Tipe</option>
                                <option value="All">Semua
                                </option>
                                @foreach (\App\Enums\VisitorType::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->value }}
                                </option>
                                @endforeach
                            </x-input.select-input>
                        </div>
                        <x-form id="export-form" action="{{ route('dashboard.export') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="statusExport" name="statusExport" value="">
                            <input type="hidden" id="typeExport" name="typeExport" value="">
                            <x-button.default-button id="export-button" type="submit"
                                class="border-[#006838] text-white bg-[#006838] hover:bg-[#005830]">
                                <i class="fa-regular fa-file-excel"></i>
                                Export
                            </x-button.default-button>
                        </x-form>
                    </div>
                </div>
                <div class="flex justify-start space-x-4 mb-10">
                    <a href="{{ route('visitor.create') }}">
                        <x-button.default-button class="border-[#006838] text-white bg-[#006838] hover:bg-[#005830]">
                            <i class="fa-solid fa-plus"></i>
                            Tambah Data
                        </x-button.default-button>
                    </a>
                </div>
            </div>

            <div class="flex items-center justify-start w-full -mt-5">
                <div class="join">
                <input type="radio" name="status" value="All" id="all" class="hidden peer/all" checked />
                    <label for="all"
                    class="join-item btn w-32 bg-base-200 peer-checked/all:bg-[#006838] peer-checked/all:text-white peer-checked/all:border-[#006838]">
                    Semua
                    </label>
                <input type="radio" name="status" value="Pending" id="pending" class="hidden peer/pending" />
                     <label for="pending"
                        class="join-item btn w-32 bg-base-200 peer-checked/pending:bg-[#006838] peer-checked/pending:text-white peer-checked/pending:border-[#006838]">
                         Menunggu
                    </label>
                <input type="radio" name="status" value="Active" id="active" class="hidden peer/active" />
                    <label for="active"
                      class="join-item btn w-32 bg-base-200 peer-checked/active:bg-[#006838] peer-checked/active:text-white peer-checked/active:border-[#006838]">
                         Aktif
                </label>
                     <input type="radio" name="status" value="Inactive" id="inactive" class="hidden peer/inactive" />
                    <label for="inactive"
                     class="join-item btn w-32 bg-base-200 peer-checked/inactive:bg-[#006838] peer-checked/inactive:text-white peer-checked/inactive:border-[#006838]">
                     Selesai
                </label>
            </div>
            </div>

            <div class="relative overflow-x-auto mt-5">
                <table id="visitors" class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                No
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Tipe
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Instansi / Institusi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Orang yang dituju
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Departemen
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </x-card.card-default>


    </div>

    <x-modal.basic id="detail" title="Detail Tamu">
        <div id="visitor-detail-body">

        </div>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Tutup</button>
            </form>
        </div>
    </x-modal.basic>
    <x-slot name="script">
        <script>
            $(document).ready(function() {
                $('#export-button').on('click', function() {
                    // Ambil nilai dari elemen #jurusan, #from, dan #to
                    let status = $('input[name="status"]:checked').val();
                    let type = $('#type').val();

                    // Set nilai input field pada form
                    $('#export-form #statusExport').val(status);
                    $('#export-form #typeExport').val(type);
                });


                let dataTable = $('#visitors').DataTable({
                    scrollY: '400px',          // tinggi maksimal tabel (bisa disesuaikan)
    scrollCollapse: true,      // scroll akan aktif jika data lebih dari tinggi
    scroller: true,
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
                        url: '{{ route('visitor.index') }}',
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
                            d.status = $('input[name="status"]:checked').val();
                            d.type = $('#type').val();
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
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: null,
                            render: function(data) {
                                let comp = null;
                                if (data.general) {
                                    comp = data?.general?.company || '-';
                                } else if (data.internship) {
                                    comp = data?.internship?.institution || '-';
                                } else if (data.recurring) {
                                    comp = data?.recurring?.company || '-';
                                }
                                return comp;
                            },
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: null,
                            render: function(data) {
                                let person = null;
                                if (data.general) {
                                    person = data?.general?.person_to_meet || '-';
                                } else if (data.internship) {
                                    person = '-';
                                } else if (data.recurring) {
                                    person = data?.recurring?.related_to || '-';
                                }
                                return person;
                            },
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: null,
                            render: function(data) {
                                let department = null;
                                if (data.general) {
                                    department = data?.general?.department || '-';
                                } else if (data.internship) {
                                    department = data.internship.department;
                                } else if (data.recurring) {
                                    department = data?.recurring?.department || '-';
                                }
                                return department;
                            },
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'status',
                            name: 'status',
                            render: function(data, type, row) {
                                const labelMap = {
                                    Pending: 'Menunggu',
                                    Active: 'Aktif',
                                    Inactive: 'Selesai',
                                    Cancel: 'Tolak'
                                };

                                const colorMap = {
                                    Pending: 'btn-warning',
                                    Active: 'btn-primary',
                                    Inactive: 'btn-secondary',
                                    Cancel: 'btn-error'
                                };

                                const statusOptions = ['Pending', 'Active', 'Inactive', 'Cancel'];

                                let html = `
            <div class="dropdown dropdown-start">
                <button tabindex="0" role="button" class="btn ${colorMap[data] || 'btn-ghost'} btn-sm " type="button" >
                    ${labelMap[data] || data}
                </button>
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">`;

                                statusOptions.forEach(opt => {
                                    html += `
                <li>
                    <x-button.default-button class="status-dropdown-item mt-2 ${colorMap[opt]} btn-xs" data-id="${row.id}" data-status="${opt}">
                        ${labelMap[opt]}
                    </x-button.default-button>
                </li>`;
                                });

                                html += `</ul></div>`;
                                return html;
                            }
                        },


                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, full, meta) {
                                return `
                                        <x-button.info-button type="button" data-id="${full.id}" class="btn-detail btn-sm text-white"><i class="fa-solid fa-eye"></i>Detail</x-button.info-button>
                                        <a href="{{ url('/dashboard/visitor/${full.id}/edit') }}">
                                            <x-button.success-button type="button" class="btn-sm text-white"><i class="fa-regular fa-pen-to-square"></i>Edit
                                            </x-button.success-button>
                                        </a>
                                    <x-form action="{{ url('/dashboard/visitor/${full.id}') }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <x-button.danger-button type="submit" class="btn-sm text-white" onclick="return confirm('Kamu Yakin?')"><i class="fa-regular fa-trash-can"></i>Hapus</x-button.danger-button>
                                    </x-form>
                                `;
                            }
                        },
                    ]
                });
                $('#type').change(function() {
                    dataTable.ajax.reload();
                });
                $('input[name="status"]').change(function() {
                    dataTable.ajax.reload();
                });

                $('#visitors').on('click', '.status-dropdown-item', function() {
                    const newStatus = $(this).data('status');
                    const visitorId = $(this).data('id');

                    $.ajax({
                        url: `/dashboard/update-status/${visitorId}`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: newStatus
                        },
                        success: function() {
                            Swal.fire('Success', 'Status updated!', 'success');
                            $('#visitors').DataTable().ajax.reload(null, false);
                        },
                        error: function() {
                            Swal.fire('Error', 'Gagal update status', 'error');
                        }
                    });
                });

                $('#visitors').on('click', '.btn-detail', function() {
                    const visitorId = $(this).data('id');

                    $.get(`/dashboard/get/visitor/${visitorId}`, function(data) {
                        $('#visitor-detail-body').html(data.html);
                        document.getElementById('detail').showModal();
                    });
                });



            });
        </script>

    </x-slot>
</x-app-layout>
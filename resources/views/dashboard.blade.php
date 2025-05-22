@section('title', 'Dashboard')
@section('header', 'Dashboard')

<x-app-layout>
   <div class="p-6 flex-grow">
        @if (session()->has('success'))
        <x-alert.success :message="session('success')" />
        @endif
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <x-card.card-default class="border-[#006838]/20 bg-[#006838] shadow-md">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-[#006838]">Total Tamu Hari Ini</p>
                            <p class="text-3xl font-bold text-[#006838]">{{ $totalVisitorToday }}</p>
                        </div>
                        <div class="h-12 w-12 bg-[#006838]/10 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt w-6 h-6 text-[#006838]"></i>
                        </div>
                    </div>
                </div>
            </x-card.card-default>

        <x-card.card-default class="border-[#006838]/20 bg-[#006838] shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#006838]">Tamu Aktif</p>
                        <p class="text-3xl font-bold text-[#006838]">{{ $visitorActive }}</p>
                    </div>
                    <div class="h-12 w-12 bg-[#006838]/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-users w-6 h-6 text-[#006838]"></i>
                    </div>
                </div>
            </div>
        </x-card.card-default>

        <x-card.card-default class="border-[#006838]/20 bg-[#006838] shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#006838]">Peserta Magang Aktif</p>
                        <p class="text-3xl font-bold text-[#006838]">{{ $internshipActive }}</p>
                    </div>
                    <div class="h-12 w-12 bg-[#006838]/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt w-6 h-6 text-[#006838]"></i>
                    </div>
                </div>
            </div>
        </x-card.card-default>

        <x-card.card-default class="border-[#006838]/20 bg-[#006838] shadow-md">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-[#006838]">Tamu Berulang Aktif</p>
                        <p class="text-3xl font-bold text-[#006838]">{{ $recurringActive }}</p>
                    </div>
                    <div class="h-12 w-12 bg-[#006838]/10 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-alt w-6 h-6 text-[#006838]"></i>
                    </div>
                </div>
            </div>
        </x-card.card-default>
    </div>


        <x-card.card-default class="bg-white/95 rounded-lg shadow-md border border-[#006838]/20 mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-[#006838]">Manajemen Tamu</h3>
                    </div>
                    <div class="flex items-center justify-start">
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
            </div>

            <div class="flex items-center justify-start w-full">
                <!-- <div class="join ">
                    <input
                        class="join-item btn w-32 bg-base-200 checked:bg-[#006838] checked:text-white checked:border-[#006838]"
                        type="radio" name="status" id="status" value="All" aria-label="Semua" />
                    <input
                        class="join-item btn w-32 bg-base-200 checked:bg-[#006838] checked:text-white checked:border-[#006838]"
                        type="radio" name="status" id="status" value="Pending" aria-label="Menunggu" />
                    <input
                        class="join-item btn w-32 bg-base-200 checked:bg-[#006838] checked:text-white checked:border-[#006838]"
                        type="radio" name="status" id="status" value="Active" aria-label="Aktif" />
                    <input
                        class="join-item btn w-32 bg-base-200 checked:bg-[#006838] checked:text-white checked:border-[#006838]"
                        type="radio" name="status" id="status" value="Inactive" aria-label="Selesai" />
                </div> -->
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

            <div class="relative overflow-x-auto mt-5 ">
                <table id="visitors" class="table ">
                    <thead >
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
                                Karyawan yang dituju
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- <x-card.card-default class="bg-white/95 rounded-lg shadow-md border border-[#006838]/20 mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-semibold">Jadwal Hari Ini</h2>
                    <div class="space-y-4">
                        <div class="flex items-center p-3 bg-[#006838]/5 rounded-lg">
                            <div class="mr-4">
                                <i class="fa-solid fa-clock h-10 w-10 text-[#006838]"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium">09:00 - Meeting dengan PT Maju Bersama</h4>
                                <p class="text-sm text-gray-500">Budi Santoso - Engineering</p>
                            </div>
                            <span class="badge bg-blue-500">Disetujui</span>
                        </div>

                        <div class="flex items-center p-3 bg-[#006838]/5 rounded-lg">
                            <div class="mr-4">
                                <i class="fa-solid fa-clock h-10 w-10 text-[#006838]"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium">10:30 - Pengiriman dari CV Teknologi Nusantara</h4>
                                <p class="text-sm text-gray-500">Siti Rahayu - Produksi</p>
                            </div>
                            <span class="badge bg-green-500">Check-in</span>
                        </div>

                        <div class="flex items-center p-3 bg-[#006838]/5 rounded-lg">
                            <div class="mr-4">
                                <i class="fa-solid fa-clock h-10 w-10 text-[#006838]"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-medium">13:00 - Maintenance Peralatan IT</h4>
                                <p class="text-sm text-gray-500">Joko Widodo - IT</p>
                            </div>
                            <span class="badge bg-yellow-500">Menunggu</span>
                        </div>
                    </div>
                </div>
            </x-card.card-default> --}}

            <x-card.card-default class="bg-white/95 rounded-lg shadow-md border border-[#006838]/20 mb-6">
                <div class="p-6">
                    <h2 class="text-lg font-semibold mb-3">Ringkasan Tamu</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-2 border-b">
                            <span class="font-medium">Tamu Umum</span>
                            <span class="text-[#006838] font-bold">{{ $generalCount }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b">
                            <span class="font-medium">Peserta Magang</span>
                            <span class="text-[#006838] font-bold">{{ $internshipCount }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b">
                            <span class="font-medium">Tamu Berulang</span>
                            <span class="text-[#006838] font-bold">{{ $recurringCount }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b">
                            <span class="font-medium">Total Tamu Aktif</span>
                            <span class="text-[#006838] font-bold">{{ $totalActive }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium">Rata-rata Durasi</span>
                            <span class="text-[#006838] font-bold">{{ $averageDuration }} menit</span>
                        </div>
                    </div>
                </div>
            </x-card.card-default>
        </div>

        <x-card.card-default class="bg-white/95 rounded-lg shadow-md border border-[#006838]/20 mb-6">
            <div class="p-6">
                <h2 class="text-lg font-semibold">Scan QR Code</h2>
                <div id="reader"
                    class="border border-base-100 mt-4 mx-auto w-full max-w-sm sm:max-w-md lg:max-w-lg p-4"></div>
                <input type="file" accept="image/*" id="qr-upload" class="my-4" />
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
                        url: '{{ route('dashboard.index') }}',
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
                                        
                                    <x-form action="{{ url('/dashboard/destroy/${full.id}') }}" style="display: inline;">
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
        <script>
            const qrReader = new Html5Qrcode("reader");

            function onScanSuccess(decodedText, decodedResult) {
                console.log(`Scan berhasil: ${decodedText}`);

                fetch('/dashboard/process-qr-code', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            qr_code: decodedText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                toast: true,
                                icon: 'success',
                                title: data.message || 'Absensi berhasil dilakukan!',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                icon: 'error',
                                title: data.message || 'Terjadi kesalahan saat melakukan absen!',
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }

                        setTimeout(() => {
                            startScanner();
                        }, 2000);
                    })
                    .catch(err => {
                        console.error('Error:', err);
                        Swal.fire({
                            toast: true,
                            icon: 'error',
                            title: 'Gagal mengirim data ke server!',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });

                        setTimeout(() => {
                            startScanner();
                        }, 2000);
                    });

                qrReader.stop().catch(err => console.warn("Gagal menghentikan scanner:", err));
            }

            function onScanFailure(error) {
                // console.warn(`Scan gagal: ${error}`);
            }

            function startScanner() {
                const config = {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    }
                };

                qrReader.start({
                        facingMode: "environment"
                    }, config, onScanSuccess, onScanFailure)
                    .catch(err => console.error("Error memulai kamera:", err));
            }

            window.addEventListener("DOMContentLoaded", () => {
                startScanner();

                document.getElementById("qr-upload").addEventListener("change", function(e) {
                    if (e.target.files.length === 0) {
                        return;
                    }

                    const file = e.target.files[0];


                    Html5Qrcode.getCameras().then(() => {
                        qrReader.scanFile(file, true) // true = verbose mode
                            .then(decodedText => {
                                onScanSuccess(decodedText, null);
                            })
                            .catch(err => {
                                console.error("Gagal memindai gambar QR:", err);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal memindai QR dari gambar!',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            });
                    });
                });
            });
        </script>

    </x-slot>
</x-app-layout>
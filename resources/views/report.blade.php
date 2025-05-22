@section('title', 'Laporan')
@section('header', 'Laporan')

<x-app-layout>
    <div class="p-6 flex-grow">
        @if (session()->has('success'))
        <x-alert.success :message="session('success')" />
        @endif

        <form method="GET" action="{{ route('report.index') }}" class="mb-4">
            <select name="periode" onchange="this.form.submit()" class="border border-gray-300 rounded p-2 text-sm">
                <option value="today" {{ request('periode')=='today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="this_week" {{ request('periode')=='this_week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="this_month" {{ request('periode')=='this_month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="this_year" {{ request('periode')=='this_year' ? 'selected' : '' }}>Tahun Ini</option>
            </select>
        </form>

        <p class="text-sm text-gray-600 mt-2 mb-3">
            Menampilkan kunjungan untuk:
            @switch($periode)
            @case('this_week') Minggu Ini @break
            @case('this_month') Bulan Ini @break
            @case('this_year') Tahun Ini @break
            @default Hari Ini
            @endswitch
        </p>


        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Total Kunjungan --}}
            <div class="border border-[#006838]/20 bg-white/90 rounded-xl shadow-sm p-4">
                <div class="pb-2">
                    <h3 class="text-sm font-medium text-gray-500">Total Kunjungan</h3>
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#006838]">
                        {{ $currentTotal }}
                    </div>
                    <p class="text-xs mt-1 {{ $percentageChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $percentageChange >= 0 ? '+' : '' }}{{ $percentageChange }}% dari periode sebelumnya
                    </p>
                </div>
            </div>

            {{-- Rata-rata Durasi Kunjungan --}}
            <div class="border border-[#006838]/20 bg-white/90 rounded-xl shadow-sm p-4">
                <div class="pb-2">
                    <h3 class="text-sm font-medium text-gray-500">Rata-rata Durasi Kunjungan</h3>
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#006838]">
                        {{ $averageDuration }} menit
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Berdasarkan semua kunjungan yang selesai</p>
                </div>
            </div>

            {{-- Karyawan Paling Banyak Dikunjungi --}}
            <div class="border border-[#006838]/20 bg-white/90 rounded-xl shadow-sm p-4">
                <div class="pb-2">
                    <h3 class="text-sm font-medium text-gray-500">Karyawan Paling Banyak Dikunjungi</h3>
                </div>
                <div>
                    <div class="text-3xl font-bold text-[#006838]">
                        {{ $topHost }}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">
                        {{ $topHostCount }} kunjungan dalam periode ini
                    </p>
                </div>
            </div>
        </div>


        <!-- name of each tab group should be unique -->
        <div class="tabs tabs-box">
            <input type="radio" name="my_tabs_6" class="tab checked:focus:bg-[#006838]" aria-label="Ringkasan" checked="checked" />
            <div class="tab-content bg-base-100 border-base-300 p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Tren Kunjungan --}}
                    <div class="border border-[#006838]/20 bg-white/90 rounded-xl shadow-sm p-4">
                        <div class="mb-4">
                            <h2 class="text-[#006838] text-lg font-semibold">Tren Kunjungan</h2>
                            <p class="text-sm text-gray-500">Jumlah kunjungan per periode</p>
                        </div>
                        <div class="flex justify-center gap-2 mb-4">
                            <button class="px-4 py-1 border text-sm rounded bg-[#006838] text-white"
                                onclick="changeChartType('day')">Harian</button>
                            <button class="px-4 py-1 border text-sm rounded text-[#006838] border-[#006838]"
                                onclick="changeChartType('week')">Mingguan</button>
                            <button class="px-4 py-1 border text-sm rounded text-[#006838] border-[#006838]"
                                onclick="changeChartType('month')">Bulanan</button>
                        </div>
                        <canvas id="visitorChart" height="300"></canvas>
                        <p class="mt-4 text-sm text-gray-500 text-center" id="chartDesc">Jumlah kunjungan 7 hari
                            terakhir</p>
                    </div>

                    {{-- Distribusi Berdasarkan Departemen --}}
                    <div class="border border-[#006838]/20 bg-white/90 rounded-xl shadow-sm p-4 h-full">
                        <div class="mb-4">
                            <h2 class="text-[#006838] text-lg font-semibold">Distribusi Berdasarkan Departemen</h2>
                            <p class="text-sm text-gray-500">Kunjungan berdasarkan departemen</p>
                        </div>

                        <canvas id="departmentPieChart" height="250"></canvas>

                        <p class="text-sm text-center text-gray-500 mt-4">
                            Data berdasarkan {{ $totalVisitors }} kunjungan
                        </p>
                    </div>
                </div>

            </div>

            <input type="radio" name="my_tabs_6" class="tab checked:focus:bg-[#006838]" aria-label="Laporan Harian" />
            <div class="tab-content bg-base-100 border-base-300 p-6">
                <h1 class="mb-4 font-bold text-lg text-[#006838]">Laporan Harian</h1>
                <p class="mb-3">Statistik kunjungan harian 14 hari terakhir</p>
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-[#006838] text-white text-sm">
                            <th>Tanggal</th>
                            <th>Total Pengunjung</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Rata-rata Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyReports as $report)
                        <tr class="text-sm">
                            <td>{{ \Carbon\Carbon::parse($report->date)->translatedFormat('l, d M Y') }}</td>
                            <td>{{ $report->total }}</td>
                            <td>{{ $report->checkin }}</td>
                            <td>{{ $report->checkout }}</td>
                            <td>{{ $report->average_duration }} menit</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <input type="radio" name="my_tabs_6" class="tab checked:focus:bg-[#006838]" aria-label="Laporan Mingguan" />
            <div class="tab-content bg-base-100 border-base-300 p-6">
                <h1 class="mb-4 font-bold text-lg text-[#006838]">Laporan Mingguan</h1>
                <p class="mb-3">Statistik kunjungan mingguan 8 minggu terakhir</p>
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-[#006838] text-white text-sm">
                            <th>Minggu</th>
                            <th>Total Pengunjung</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Rata-rata Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($weeklyReports as $report)
                        <tr class="text-sm">
                            <td>{{ $report->week }}</td>
                            <td>{{ $report->total }}</td>
                            <td>{{ $report->checkin }}</td>
                            <td>{{ $report->checkout }}</td>
                            <td>{{ $report->average_duration }} menit</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <input type="radio" name="my_tabs_6" class="tab checked:focus:bg-[#006838]" aria-label="Laporan Bulanan" />
            <div class="tab-content bg-base-100 border-base-300 p-6">
                <h1 class="mb-4 font-bold text-lg text-[#006838]">Laporan Bulanan</h1>
                <p class="mb-3">Statistik kunjungan bulanan 12 bulan terakhir</p>
                <table class="table table-zebra w-full">
                    <thead>
                        <tr class="bg-[#006838] text-white text-sm">
                            <th>Bulan</th>
                            <th>Total Pengunjung</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Rata-rata Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlyReports as $report)
                        <tr class="text-sm">
                            <td>{{ $report->month }}</td>
                            <td>{{ $report->total }}</td>
                            <td>{{ $report->checkin }}</td>
                            <td>{{ $report->checkout }}</td>
                            <td>{{ $report->average_duration }} menit</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <input type="radio" name="my_tabs_6" class="tab checked:focus:bg-[#006838]" aria-label="Data Kunjungan" />
            <div class="tab-content bg-base-100 border-base-300 p-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#006838]">Data Kunjungan Terbaru</h3>
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
                            <x-form id="export-form" action="{{ route('dashboard.export') }}"
                                enctype="multipart/form-data">
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
                    <div class="join ">
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
            </div>

            <input type="radio" name="my_tabs_6" class="tab checked:focus:bg-[#006838]" aria-label="Reaction" />
            <div class="tab-content bg-base-100 border-base-300 p-6">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-[#006838]">Data Reaction</h3>
                        </div>

                        
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">

                 <div class="border border-[#006838]/20 bg-white/90 rounded-xl shadow-sm p-4">
                        <!-- <div class="mb-4">
                            <h2 class="text-[#006838] text-lg font-semibold">Tren Kunjungan</h2>
                            <p class="text-sm text-gray-500">Jumlah kunjungan per periode</p>
                        </div> -->
                    <div class="relative w-64 h-64 mx-auto">
         <canvas id="reactionChart"></canvas>
     </div>
     </div>
     
     <div class="border border-[#006838]/20 bg-white/90 rounded-xl shadow-sm p-4">
     <div class="relative overflow-x-auto mt-5 w-full">
                         <table id="reactions" class="table">
                             <thead>
                                 <tr>
                                     <th scope="col" class="px-6 py-3">
                                         No
                                     </th>
                                     <th scope="col" class="px-6 py-3">
                                         Rating
                                     </th>
                                     <th scope="col" class="px-6 py-3">
                                         Feedback
                                     </th>
                                     
                                 </tr>
                             </thead>
                             <tbody></tbody>
                         </table>
                     </div>
                </div>
                </div>

            </div>
        </div>

    </div>
    <x-slot name="script">
        <script>
            const chartData = {
                        day: {
                            labels: @json($dayLabels), // contoh: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']
                            data: @json($dailyData),
                            desc: 'Jumlah kunjungan 7 hari terakhir'
                        },
                        week: {
                            labels: @json($weekLabels), // contoh: ['Minggu 1', 'Minggu 2', ...]
                            data: @json($weeklyData),
                            desc: 'Jumlah kunjungan 5 minggu terakhir'
                        },
                        month: {
                            labels: @json($monthLabels), // contoh: ['Mei', 'Apr', 'Mar', ...]
                            data: @json($monthlyData),
                            desc: 'Jumlah kunjungan 6 bulan terakhir'
                        }
                    };
                
                    let currentType = 'day';
                    const ctx = document.getElementById('visitorChart').getContext('2d');
                    let visitorChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartData[currentType].labels,
                            datasets: [{
                                label: 'Jumlah Kunjungan',
                                data: chartData[currentType].data,
                                borderColor: '#006838',
                                backgroundColor: 'rgba(0,104,56,0.2)',
                                tension: 0.3
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                
                    function changeChartType(type) {
                        currentType = type;
                        visitorChart.data.labels = chartData[type].labels;
                        visitorChart.data.datasets[0].data = chartData[type].data;
                        visitorChart.update();
                        document.getElementById('chartDesc').innerText = chartData[type].desc;
                    }
        </script>
        <script>
            const departmentData = @json($visitorsByDepartment);
                
                    const labels = departmentData.map(item => item.department);
                    const data = departmentData.map(item => item.count);
                    const backgroundColors = [
                        '#006838', '#4CAF50', '#81C784', '#A5D6A7', '#C8E6C9',
                        '#388E3C', '#2E7D32', '#1B5E20', '#66BB6A', '#43A047'
                    ];
                
                    const ctx2 = document.getElementById('departmentPieChart').getContext('2d');
                    new Chart(ctx2, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Distribusi Kunjungan',
                                data: data,
                                backgroundColor: backgroundColors,
                                borderColor: '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const count = context.raw;
                                            const total = data.reduce((a, b) => a + b, 0);
                                            const percentage = ((count / total) * 100).toFixed(1);
                                            return `${context.label}: ${count} (${percentage}%)`;
                                        }
                                    }
                                }
                            }
                        }
                    });
        </script>

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
                url: '{{ route('report.index') }}',
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
                        let status = null;
                        if (data == 'Active') {
                            status = 'Aktif';
                        } else if (data == 'Inactive') {
                            status = 'Tidak Aktif';
                        } else if (data == 'Pending') {
                            status = 'Menunggu';
                        } else if (data == 'Cancel') {
                            status = 'Tolak';
                        }
                        return status;
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
                                
                        `;
                    }
                },
            ]
        });
        let dataTable2 = $('#reactions').DataTable({
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
                url: '{{ route('report.reaction') }}',
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
                    data: 'note',
                    name: 'note'
                },
            ]
        });
        $('#type').change(function() {
            dataTable.ajax.reload();
        });
        $('input[name="status"]').change(function() {
            dataTable.ajax.reload();
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
    const labels_r = {!! json_encode($reactionCounts->pluck('name')) !!};
    const data_r = {!! json_encode($reactionCounts->pluck('total')) !!};

    const pieChart = new Chart(document.getElementById('reactionChart'), {
        type: 'pie',
        data: {
            labels: labels_r,
            datasets: [{
                label: 'Reaksi Tamu',
                data: data_r,
                backgroundColor: [
                    '#22c55e', // Sangat Puas
                    '#10b981', // Puas
                    '#facc15', // Biasa
                    '#f97316', // Kurang Puas
                    '#ef4444', // Tidak Puas
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                },
            },
        }
    });
</script>

    </x-slot>
</x-app-layout>
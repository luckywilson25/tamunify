<div class="space-y-6">
    <p class="text-xs">Informasi lengkap tentang tamu</p>

    {{-- Informasi Dasar & Kontak --}}
    <div class="flex flex-col md:flex-row gap-6">
        <div class="w-full md:w-1/2">
            <h1 class="text-[#006838] font-semibold">Informasi Dasar</h1>
            <ul class="list-none list-outside space-y-1 text-sm">
                <li>ID Tamu : {{ $visitor->uuid }}</li>
                <li>Nama : {{ $visitor->name }}</li>
                <li>Perusahaan / Institusi Pendidikan :
                    {{ $visitor->general ? $visitor->general->company :
                    ($visitor->internship ? $visitor->internship->institution : $visitor->recurring->company) }}
                </li>
                <li>Tipe Tamu : {{ $visitor->type }}</li>
                @if($visitor->general)
                <li>Tujuan : {{ $visitor->general->purpose }}</li>
                @endif
                @if ($visitor->recurring || $visitor->general)
                <li>Karyawan :
                    {{ $visitor->general ? $visitor->general->person_to_meet :
                    ($visitor->internship ? '-' : $visitor->recurring->related_to) }}
                </li>
                @else
                <li>Pembimbing : {{ $visitor->internship->supervisor }}</li>
                @endif
            </ul>
        </div>

        <div class="w-full md:w-1/2">
            <h1 class="text-[#006838] font-semibold">Kontak & Identitas</h1>
            <ul class="list-none list-outside space-y-1 text-sm">
                <li>Email : {{ $visitor->email }}</li>
                <li>Telepon : {{ $visitor->phone }}</li>
                <li>No Identitas : {{ $visitor->identity_number }}</li>
            </ul>
        </div>
    </div>

    {{-- Informasi Kunjungan / Magang --}}
    <div>
        @if ($visitor->recurring || $visitor->general)
        <h1 class="text-[#006838] font-semibold">Informasi Kunjungan</h1>
        <div class="flex flex-col md:flex-row gap-6 text-sm">
            <p>Tanggal: {{ $visitor->general ? $visitor->general->visit_date->format('d-m-Y') :
                $visitor->recurring->access_start->format('d-m-Y') }}
            </p>
            <p>Check In: {{ $visitor->general ? $visitor->general->visit_time : $visitor->recurring->usual_entry_time
                }}
            </p>
            <p>Check Out: {{ $visitor->general ? $visitor->general->exit_time : $visitor->recurring->usual_exit_time }}
            </p>
        </div>
        @else
        <h1 class="text-[#006838] font-semibold">Informasi Magang</h1>
        <div class="flex flex-col md:flex-row gap-6 text-sm">
            <p>Tanggal Mulai: {{ $visitor->internship->internship_start->format('d-m-Y') }}</p>
            <p>Tanggal Selesai: {{ $visitor->internship->internship_end->format('d-m-Y') }}</p>
        </div>
        @endif
    </div>

    {{-- Status --}}
    <div>
        <h1 class="text-[#006838] font-semibold">Status</h1>
        <p class="text-sm">{{ $visitor->status }}</p>
    </div>

    {{-- Catatan --}}
    <div>
        <h1 class="text-[#006838] font-semibold">Catatan</h1>
        <p class="text-sm">
            {{ $visitor->general ? $visitor->general->additional_info :
            ($visitor->internship ? $visitor->internship->additional_info : $visitor->recurring->additional_info) }}
        </p>
    </div>

    @if ($visitor->photo)
    <div>
        <h1 class="text-[#006838] font-semibold">Foto</h1>
        <img src="{{ asset('storage/visitor/photo/' . $visitor->photo) }}" class="w-1/2 object-contain" alt="Foto" />
    </div>
    @endif
    @if ($visitor->internship)
    <div>
        <h1 class="text-[#006838] font-semibold">Surat Pengantar</h1>
        <a href="{{ url('storage/visitor/referral_letter/' . $visitor->internship->referral_letter) }}">Unduh</a>
    </div>
    @endif
</div>
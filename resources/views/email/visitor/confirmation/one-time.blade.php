<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Berhasil</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ddd;">
        <h2 style="text-align: center; color: green;">Pendaftaran Berhasil!</h2>

        <p style="text-align: center;">
            Data kunjungan Anda telah terdaftar.
        </p>

        <div style="text-align: center; margin: 20px 0;">
            {!! $qrCode !!}
        </div>

        <h4>Informasi Kunjungan:</h4>
        <p>Tanggal: {{ $visitor->general->visit_date->format('d-m-Y') }}</p>
        <p>Waktu: {{ $visitor->general->visit_time }}</p>

        <h4>Petunjuk:</h4>
        <ul>
            <li>Tunjukkan QR Code ini kepada petugas keamanan di gerbang</li>
            <li>QR Code hanya berlaku satu kali pada tanggal tersebut</li>
            <li>Bawa identitas diri (KTP/SIM)</li>
            <li>Kartu akses magang aktif selama masa magang</li>
            <li>Patuhi semua peraturan keamanan perusahaan</li>
        </ul>

        <p style="text-align: center; margin-top: 30px;">
            Terima kasih telah melakukan pendaftaran.
        </p>
    </div>
</body>

</html>
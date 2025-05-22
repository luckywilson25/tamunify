<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Magang</title>
</head>

<body style="font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px;">
    <div
        style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px #ddd;">
        <h2 style="text-align: center; color: green;">Konfirmasi Magang!</h2>

        @if ($visitor->status == 'Active')
        <p style="text-align: center;">
             Permintaan akses kartu magang Anda telah disetujui. Silakan datang ke Departemen Keamanan pada hari pertama magang untuk pengambilan kartu
        </p>
        @else
        <p style="text-align: center;">
            Mohon maaf pendaftaran anda ditolak
        </p>
        @endif


        <h4>Status Pendaftaran:
            @if ($visitor->status == 'Active')
            <span style="color: green;">Diterima</span>
            @else
            <span style="color: red;">Ditolak</span>
            @endif
        </h4>

        <p style="text-align: center; margin-top: 30px;">
            Terima kasih telah berusaha.
        </p>
    </div>
</body>

</html>
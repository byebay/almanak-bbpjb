<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Atur Ulang Kata Sandi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1f2937; margin: 0; padding: 0; background-color: #f3f4f6;">
    <div style="max-width: 600px; margin: 24px auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
        <div style="background-color: #2563eb; padding: 24px; color: #ffffff;">
            <h2 style="margin: 0; font-size: 22px;">Permintaan Atur Ulang Kata Sandi</h2>
        </div>
        <div style="padding: 24px;">
            <p style="margin-top: 0;">Halo,</p>
            <p>Anda menerima pesan ini karena kami menerima permintaan untuk mengatur ulang kata sandi akun Anda.</p>
            <p style="margin: 24px 0;">
                <a href="{{ $url }}" style="display: inline-block; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 20px; border-radius: 6px; font-weight: bold;">
                    Ganti Kata Sandi
                </a>
            </p>
            <p>Tautan untuk mengatur ulang kata sandi ini berlaku selama 60 menit.</p>
            <p>Jika Anda tidak merasa melakukan permintaan ini, Anda dapat mengabaikan pesan ini dengan aman.</p>
            <p>Jika tombol di atas tidak berfungsi, salin dan tempel tautan berikut ke browser Anda:</p>
            <p style="word-break: break-all; color: #4b5563;">{{ $url }}</p>
            <p style="margin-top: 24px;">Salam,<br>Tim {{ $appName }}</p>
        </div>
    </div>
</body>
</html>

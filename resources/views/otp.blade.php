<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, sans-serif; background-color: #f9fafb; padding: 40px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 500px; margin: auto; background: #ffffff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <tr>
            <td style="padding: 30px; text-align: center;">
                <h2 style="color: #059669; font-size: 22px; margin-bottom: 10px;">Verifikasi Akun Kamu</h2>
                <p style="color: #4b5563; font-size: 15px; margin-bottom: 30px;">
                    Gunakan kode OTP berikut untuk memverifikasi email kamu.
                </p>

                <div style="display: inline-block; background: #059669; color: #ffffff; padding: 15px 30px; border-radius: 8px; font-size: 28px; letter-spacing: 5px; font-weight: bold;">
                    {{ $otp }}
                </div>

                <p style="color: #6b7280; font-size: 14px; margin-top: 30px;">
                    Kode ini hanya berlaku selama <strong>10 menit</strong>.<br>
                    Jika kamu tidak meminta kode ini, abaikan email ini.
                </p>

                <hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">

                <p style="color: #9ca3af; font-size: 12px;">
                    © {{ date('Y') }} Aplikasi Kamu. Semua hak dilindungi.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

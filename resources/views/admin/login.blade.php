<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <title>Ecozyne Website</title>
</head>
<body style="background-color: #D6EDDE; font-family: 'Poppins', sans-serif;">
<div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="p-4 rounded shadow-lg bg-light" style="width: 100%; max-width: 600px;">
        <div class="mt-3 d-flex justify-content-center">
            <img src="{{ asset('images/ecozyne_logo.png') }}" alt="Logo Perusahaan">
        </div>
        <h2 class="text-center fw-semibold">Masuk Akun</h2>
        <form action="{{ route('login.process') }}" method="post">
            @csrf
            <input class="form-control" name="email" type="email" placeholder="Email">
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <input class="form-control mt-3" name="password" type="password" placeholder="Kata Sandi">
            @error('password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="mt-3 d-flex justify-content-center">
                <button type="submit" class="btn btn-lg" style="background-color: #55C173; color: #000;">Masuk</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
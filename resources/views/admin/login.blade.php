<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/ecozyne_logo.png') }}">
    
    <title>Ecozyne Website | Admin</title>
    <style>
        body {
            /* Perubahan di sini: Menggunakan Inter */
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
            background-color: #f8f9fa;
        }
        
        .split-container {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        .left-panel img {
            width: 150px;          
            height: auto;
            object-fit: contain;  
            filter: drop-shadow(0 0 8px rgba(58, 56, 56, 0.7)); 
        }

        .left-panel {
            background-color: #3ab65d;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex: 1;
            padding: 2rem;
            min-width: 0;
        }

        .right-panel {
            background-color: #d3e6d8;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            padding: 2rem;
            min-width: 0;
            overflow-y: auto;
        }

        .login-card {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 600px;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) { /* Small devices (landscape phones, 768px and up) */
            .left-panel {
                display: none;
            }
            .right-panel {
                flex: 1 1 100%;
                padding: 1rem;
            }
            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="split-container">
    {{-- Left Panel --}}
    <div class="left-panel">
        <div>
            <img src="{{ asset('images/ecozyne_logo.png') }}" alt="Logo Ecozyne" class="mb-4" style="width: 120px;">
            <h2 class="fw-bold mb-3">Ecozyne</h2>
            <p class="fs-6">
                Masuk sekarang untuk mengelola data lingkungan
            </p>
        </div>
    </div>
    
    {{-- Right Panel - Login Form --}}
    <div class="right-panel">
        <div class="login-card">
            
            <h2 class="text-center fw-semibold mb-4">Masuk Akun</h2>
            <form action="{{ route('login.process') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="email_input" class="form-label">Email</label>
                    <input class="form-control form-control-lg" name="email" id="email_input" type="email" placeholder="contoh@gmail.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="kata_sandi" class="form-label">Kata Sandi</label>
                    <input class="form-control form-control-lg" name="password" type="password" placeholder="Kata Sandi Anda" id="kata_sandi" required>
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4 form-check">
                    <input class="form-check-input me-1" type="checkbox" onclick="showPassword()" id="login_checkbox">
                    <label class="form-check-label" for="login_checkbox">Tampilkan Sandi</label>
                </div>
                
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-lg fw-bold" style="background-color: #55C173; color: #fff;">Masuk</button>
                </div>
            </form>
        </div>
    </div>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('error'))
    <script>
        Swal.fire({
        icon: 'error',
        title: '{{ session("error") }}',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: true,
        confirmButtonText: 'OK'
        });
    </script>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showPassword() {
        var x = document.getElementById("kata_sandi");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
</body>
</html>
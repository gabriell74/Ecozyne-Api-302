@extends('layout.admin')

{{-- Judul halaman berdasarkan gambar "Akun" --}}
@section('title', 'Profil')
@section('header', 'Profil') 

@section('content')
<div class="container-fluid py-5">
    {{-- Container utama akun, dengan latar belakang putih melengkung di tengah halaman --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-lg rounded-4 p-5" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1);">
                
                {{-- Judul Halaman --}}
                <h3 class="fw-bold mb-4" style="color: #2B3A55;">Profil Pengguna</h3>

                {{-- Pesan Sukses atau Error (Opsional, dari Controller) --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- Handle error dari validasi yang tidak spesifik per field --}}
                @if ($errors->any() && !session('success') && !session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Mohon periksa kembali input Anda.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile_update') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- Metode PUT biasanya digunakan untuk update --}}
                    @method('PUT') 

                    {{-- Bagian Avatar dan Input Utama --}}
                    <div class="row">

                        {{-- Kolom Kanan: Input Form Utama --}}
                        <div class="col-12 col-md-12">
                            
                            {{-- Baris 1: Nama Asli & Nama Pengguna --}}
                            <div class="row mb-4">
                                <div class="col-md-5">
                                    <label for="username" class="form-label small text-muted">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username ?? '') }}" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('username') 
                                        <div class="text-danger small">{{ $message }}</div> 
                                    @enderror
                                </div>
                                <div class="col-md-7">
                                    <label for="email" class="form-label small text-muted">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('email') 
                                        <div class="text-danger small">{{ $message }}</div> 
                                    @enderror
                                </div>
                            </div>

                            {{-- Baris 2: Kata Sandi --}}
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="password" class="form-label small text-muted">Kata Sandi</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('password') 
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            {{-- Tombol Simpan --}}
                            <div class="d-flex justify-content-between mt-4">
                                <button type="reset" class="btn px-4 py-2 fw-bold bg-danger" style="color: white; border-radius: 8px;">Reset</button>
                                <button type="submit" class="btn px-4 py-2 fw-bold" style="background-color: #10b981; color: white; border-radius: 8px;">Simpan</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logika untuk menampilkan preview gambar yang diupload
        document.getElementById('avatar_upload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const avatarPreview = document.querySelector('.profile-avatar');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Jika sebelumnya ikon, ubah jadi img
                    if (avatarPreview.tagName === 'DIV') {
                        const img = document.createElement('img');
                        img.className = avatarPreview.className; // Salin kelas dari div
                        img.style = avatarPreview.style; // Salin gaya
                        img.alt = "Avatar";
                        avatarPreview.parentNode.replaceChild(img, avatarPreview);
                        img.src = e.target.result;
                    } else {
                        avatarPreview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(file);
            } else {
                // Jika file dibatalkan atau tidak ada, kembalikan ke ikon default jika diperlukan
                // atau biarkan gambar lama jika ada
                @if(!isset($user->avatar) || !$user->avatar)
                    // Jika memang tidak ada avatar sebelumnya, bisa dikembalikan ke ikon
                    const currentAvatar = document.querySelector('.profile-avatar');
                    if (currentAvatar.tagName === 'IMG') {
                        const divIcon = document.createElement('div');
                        divIcon.className = currentAvatar.className;
                        divIcon.style = currentAvatar.style;
                        divIcon.innerHTML = '<i class="fas fa-user fa-3x" style="color: #10b981;"></i>';
                        currentAvatar.parentNode.replaceChild(divIcon, currentAvatar);
                    }
                @endif
            }
        });
    });
</script>

<style>
    /* Mengatur background pink di luar container untuk meniru tampilan gambar */
    body {
        background-color: #f7e6e9; /* Warna mendekati pink tua */
    }
    
    /* Warna latar belakang utama platform (hijau muda) seperti gambar */
    .admin-content-wrapper {
        background-color: #e6fae6; /* Asumsi warna konten utama */
    }

    /* Style untuk form control agar lebih meniru tampilan pada gambar */
    .form-control {
        background-color: white;
        padding: 0.75rem 1rem;
    }

    /* Style tambahan untuk avatar */
    .profile-avatar {
        transition: all 0.3s ease;
    }
</style>
@endsection
@extends('layout.admin')

{{-- Judul halaman berdasarkan gambar "Akun" --}}
@section('title', 'Profil')
@section('header', 'Profil') 

@section('content')
<div class="container-fluid py-5">
    {{-- Container utama akun, dengan latar belakang putih melengkung di tengah halaman --}}
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
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
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
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

                <form method="POST" action="{{ route('user.update.profile') }}" enctype="multipart/form-data">
                    @csrf
                    {{-- Metode PUT biasanya digunakan untuk update --}}
                    @method('PUT') 

                    {{-- Bagian Avatar dan Input Utama --}}
                    <div class="row">
                        
                        {{-- Kolom Kiri: Avatar dan Edit --}}
                        <div class="col-12 col-md-4 d-flex justify-content-center align-items-center mb-4 mb-md-0">
                            <div class="position-relative d-inline-block avatar-wrapper">
                                {{-- Placeholder Gambar Profil atau Ikon --}}
                                @if(isset($user->avatar) && $user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle profile-avatar" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #10b981;">
                                @else
                                    {{-- Menggunakan ikon profil jika tidak ada avatar --}}
                                    <div class="rounded-circle profile-avatar d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background-color: #e6fae6; border: 3px solid #10b981;">
                                        <i class="fas fa-user fa-3x" style="color: #10b981;"></i>
                                    </div>
                                @endif
                                
                                {{-- Tombol Edit Avatar (diubah menjadi label untuk akses input file) --}}
                                <label for="avatar_upload" class="btn btn-sm rounded-circle position-absolute bottom-0 end-0" 
                                       style="background-color: #06b6d4; color: white; width: 30px; height: 30px; line-height: 15px; padding: 0; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-pencil-alt fa-xs"></i>
                                </label>
                                
                                {{-- Field untuk upload gambar (disembunyikan) --}}
                                <input type="file" id="avatar_upload" name="avatar" style="display: none;">
                                @error('avatar') <div class="text-danger small mt-2">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Kolom Kanan: Input Form Utama --}}
                        <div class="col-12 col-md-8">
                            
                            {{-- Baris 1: Nama Asli & Nama Pengguna --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nama_asli" class="form-label small text-muted">Nama asli</label>
                                    <input type="text" class="form-control" id="nama_asli" name="nama_asli" value="{{ old('nama_asli', $user->name ?? '') }}" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('nama_asli') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="nama_pengguna" class="form-label small text-muted">nama pengguna</label>
                                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="{{ old('nama_pengguna', $user->username ?? '') }}" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('nama_pengguna') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            
                            {{-- Baris 2: Email & Kata Sandi --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label small text-muted">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label small text-muted">kata sandi</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                                    {{-- Tambahkan field konfirmasi password jika Anda menggunakan validasi 'confirmed' --}}
                                    {{-- <input type="password" class="form-control mt-2" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" style="border-radius: 8px; border: 1px solid #ccc;"> --}}
                                </div>
                            </div>

                            {{-- Baris 3: No HP & Alamat --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label small text-muted">No HP</label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="background-color: #eee; border-radius: 8px 0 0 8px; border-right: none;">+62</span>
                                        <input type="tel" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->phone_number ?? '') }}" style="border-radius: 0 8px 8px 0; border-left: none; border: 1px solid #ccc;">
                                    </div>
                                    @error('no_hp') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="alamat" class="form-label small text-muted">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $user->address ?? '') }}" style="border-radius: 8px; border: 1px solid #ccc;">
                                    @error('alamat') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            
                            {{-- Tombol Simpan --}}
                            <div class="d-flex justify-content-end mt-4">
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
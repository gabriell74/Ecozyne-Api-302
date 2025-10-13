@extends('layout.admin')

@section('title', 'Kelola Komunitas - Ecozyne')

@section('content')
<div class="container-fluid py-4" style="background-color: #D6EDDE; min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <!-- Header dengan Breadcrumb -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                            </li>
                        </ol>
                    </nav>
                    <h4 class="fw-bold mb-0" style="color:#343C6A">Kelola Komunitas</h4>
                    <p class="text-muted mb-0">176 akun terdaftar</p>
                </div>
            </div>
            <!-- Card List Komunitas -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-0">
                    <!-- Komunitas 1 -->
                    <div class="border-bottom border-dark p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Komunitas Hijau Lestari</h6>
                                <p class="text-muted mb-0">hijaulestari@gmail.com</p>
                                <small class="text-muted">Terdaftar: 15 Januari 2024</small>
                            </div>
                            <div>
                                <button class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Komunitas 2 -->
                    <div class="border-bottom border-dark p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Eco Warriors</h6>
                                <p class="text-muted mb-0">ecowarriors@gmail.com</p>
                                <small class="text-muted">Terdaftar: 20 Februari 2024</small>
                            </div>
                            <div>
                                <button class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Komunitas 3 -->
                    <div class="border-bottom border-dark p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Bumi Sehat</h6>
                                <p class="text-muted mb-0">bumisehat@gmail.com</p>
                                <small class="text-muted">Terdaftar: 5 Maret 2024</small>
                            </div>
                            <div>
                                <button class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan lebih banyak komunitas sesuai kebutuhan -->
                    
                    <!-- Komunitas 176 -->
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Green Community</h6>
                                <p class="text-muted mb-0">greencommunity@gmail.com</p>
                                <small class="text-muted">Terdaftar: 10 Agustus 2024</small>
                            </div>
                            <div>
                                <button class="btn btn-outline-danger btn-sm rounded-pill">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <p class="text-muted mb-0">Menampilkan 4 dari 176 komunitas</p>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Sebelumnya</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Selanjutnya</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layout.admin')

@section('title', 'Kelola Komunitas - Ecozyne')

@section('content')
<div class="container-fluid py-4 page-komunitas" 
     style="background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%); min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"></li>
                        </ol>
                    </nav>
                    <h4 class="fw-bold mb-0" style="color:#343C6A">Kelola Bank Sampah</h4>
                    <p class="text-muted mb-0">100 akun terdaftar</p>
                </div>
            </div>

            <!-- Card List Komunitas -->
            <div class="card border-0 shadow-sm rounded-4" 
                 style="background-color: #f5f8f3d2; color: #00000087;">
                <div class="card-body p-0">

                    <!-- Komunitas 1 -->
                    <div class="border-bottom border-secondary p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle me-3" style="font-size: 1.9rem; color: #007559;"></i>
                                <div>
                                    <h6 class="fw-semibold mb-0 text-#001d16" style="font-size: 1rem;">Bank Sampah Lestari</h6>
                                    <p class="mb-0 text-#001d16" style="font-size: 0.85rem;">lestari@gmail.com</p>
                                    <small class="text-light-50" style="font-size: 0.75rem;">Terdaftar: 20 Januari 2024</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Komunitas 2 -->
                    <div class="border-bottom border-secondary p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle me-3" style="font-size: 1.9rem; color: #007559;"></i>
                                <div>
                                    <h6 class="fw-semibold mb-0 text-#001d16" style="font-size: 1rem;">Bank Warriors</h6>
                                    <p class="mb-0 text-#001d16" style="font-size: 0.85rem;">warriors@gmail.com</p>
                                    <small class="text-light-50" style="font-size: 0.75rem;">Terdaftar: 30 Februari 2024</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Komunitas 3 -->
                    <div class="border-bottom border-secondary p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle me-3" style="font-size: 1.9rem; color: #007559;"></i>
                                <div>
                                    <h6 class="fw-semibold mb-0 text-#001d16" style="font-size: 1rem;">Bank Sehat</h6>
                                    <p class="mb-0 text-#001d16" style="font-size: 0.85rem;">banksehat@gmail.com</p>
                                    <small class="text-light-50" style="font-size: 0.75rem;">Terdaftar: 13 Maret 2024</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Komunitas 4 -->
                    <div class="p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle me-3" style="font-size: 1.9rem; color: #007559;"></i>
                                <div>
                                    <h6 class="fw-semibold mb-0 text-#001d16" style="font-size: 1rem;">Bank Aji Stone</h6>
                                    <p class="mb-0 text-#001d16" style="font-size: 0.85rem;">community@gmail.com</p>
                                    <small class="text-light-50" style="font-size: 0.75rem;">Terdaftar: 17 Agustus 1945</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <p class="text-muted mb-0">Menampilkan 4 dari 1 komunitas</p>
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

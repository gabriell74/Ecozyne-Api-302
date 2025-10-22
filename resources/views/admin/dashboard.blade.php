@extends('layout.admin')

@section('title', 'Dasbor Ecozyne')

@section('content')
<div class="container-fluid py-4" style="background-color: #D6EDDE; min-height: 100vh;">
    <!-- Header Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0" style="color:#343C6A">Admin</h4>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Total Pengguna</h6>
                            <h3 class="fw-bold mb-0">1,248</h3>
                            <small class="opacity-75">+12 dari bulan lalu</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Bank Sampah</h6>
                            <h3 class="fw-bold mb-0">90</h3>
                            <small class="opacity-75">Aktif</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Total Artikel</h6>
                            <h3 class="fw-bold mb-0">156</h3>
                            <small class="opacity-75">+5 artikel baru</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-4 h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title mb-2">Kegiatan</h6>
                            <h3 class="fw-bold mb-0">12</h3>
                            <small class="opacity-75">Sedang berjalan</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-12 col-lg-8">
            <!-- Pengguna Section -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0" style="color:#343C6A">
                        <i class="fas fa-users me-2 text-primary"></i>Kelola Pengguna
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center p-3 border rounded-3 h-100">
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-users-cog text-primary fa-lg"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Komunitas</h6>
                                    <p class="text-muted mb-2 small">176 akun terdaftar</p>
                                    <a href="{{ route('admin.komunitas') }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                        Kelola Akun
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center p-3 border rounded-3 h-100">
                                <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="fas fa-trash-alt text-success fa-lg"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Bank Sampah</h6>
                                    <p class="text-muted mb-2 small">90 akun terdaftar</p>
                                    <a href="{{ route('admin.wastebank') }}" class="btn btn-sm btn-success rounded-pill px-3">
                                        Kelola Akun
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artikel Section -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0" style="color:#343C6A">
                        <i class="fas fa-newspaper me-2 text-info"></i>Artikel Terbaru
                    </h5>
                    <a href="{{ route('article.list') }}" class="btn btn-dark btn-sm rounded-pill px-3"> 
                        Kelola Artikel
                    </a>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach (range(1, 3) as $i)
                        <div class="col-12 col-md-4">
                            <div class="card border-0 rounded-3 overflow-hidden" style="height: 140px;">
                                <div class="h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #53B175 0%, #429861 100%);">
                                    <i class="fas fa-image fa-2x text-white opacity-75"></i>
                                </div>
                            </div>
                            <small class="d-block text-center mt-2 fw-semibold">Eco-Enzyme Guide</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-12 col-lg-4">
            <!-- Kegiatan Section -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0" style="color:#343C6A">
                        <i class="fas fa-hands-helping me-2 text-warning"></i>Kegiatan Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-badge bg-warning me-3">
                                    <i class="fas fa-tree text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Menanam Pohon</h6>
                                    <p class="text-muted mb-1 small">12 Agustus 2025</p>
                                    <span class="badge bg-warning bg-opacity-20 text-warning">Aktif</span>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-badge bg-success me-3">
                                    <i class="fas fa-water text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1">Bersih Pantai</h6>
                                    <p class="text-muted mb-1 small">15 Agustus 2025</p>
                                    <span class="badge bg-success bg-opacity-20 text-success">Coming Soon</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-dark rounded-pill w-100">Kelola Kegiatan</button>
                    </div>
                </div>
            </div>

            <!-- Katalog Hadiah Section -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0" style="color:#343C6A">
                        <i class="fas fa-gift me-2 text-danger"></i>Katalog Hadiah
                    </h5>
                </div>
                <div class="card-body">
                    <div class="reward-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded p-2 me-3">
                                    <i class="fas fa-wheat-alt text-warning fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Beras Organik</h6>
                                    <small class="text-muted">200 Poin</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm rounded-circle">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="reward-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded p-2 me-3">
                                    <i class="fas fa-cube text-brown fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0">Gula Merah</h6>
                                    <small class="text-muted">300 Poin</small>
                                </div>
                            </div>
                            <button class="btn btn-outline-danger btn-sm rounded-circle">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="#" class="fw-bold text-decoration-none text-primary">TAMPILKAN SELENGKAPNYA</a>
                    </div>
                </div>
            </div>

            <!-- Komik Section -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0" style="color:#343C6A">
                        <i class="fas fa-book-open me-2 text-info"></i>Komik Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="comic-item mb-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded p-2 me-3">
                                <i class="fas fa-book text-info"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">Eco Buster</h6>
                                <small class="text-muted">12 Agustus 2025</small>
                            </div>
                        </div>
                    </div>
                    <div class="comic-item">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded p-2 me-3">
                                <i class="fas fa-book text-success"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">Mico dan Lobak</h6>
                                <small class="text-muted">15 Agustus 2025</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="fw-bold text-decoration-none text-primary">TAMPILKAN SELENGKAPNYA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-badge {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.timeline-item {
    position: relative;
}

.timeline-item:not(:last-child):after {
    content: '';
    position: absolute;
    left: 20px;
    top: 40px;
    bottom: -20px;
    width: 2px;
    background-color: #e9ecef;
}

.reward-item {
    padding: 12px;
    border-radius: 8px;
    transition: background-color 0.2s;
}

.reward-item:hover {
    background-color: #f8f9fa;
}

.text-brown {
    color: #8B4513;
}

.bg-brown {
    background-color: #8B4513;
}
</style>
@endsection
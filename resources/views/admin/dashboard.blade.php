@extends('layout.admin')

@section('title', 'Dasbor Ecozyne')

@section('content')
<div class="container-fluid py-4" style="background-color: #D6EDDE; min-height: 100vh;">
    <div class="row">
        <div class="col-12 col-lg-8">
            <h5 class="fw-bold mb-3" style="color:#343C6A">Pengguna</h5>
            <div class="row">
                <div class="col-12 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-bold">Komunitas</h6>
                            <p class="text-muted mb-2">176 akun terdaftar</p>
                            <a href="" class="btn btn-dark rounded-pill mt-2">
                            Kelola Akun
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h6 class="fw-bold">Bank Sampah</h6>
                            <p class="text-muted mb-2">90 akun terdaftar</p>
                            <a href="}" class="btn btn-dark rounded-pill mt-2">
                                Kelola Akun
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <h5 class="fw-bold mb-3" style="color:#343C6A">Kegiatan</h5>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="border-bottom border-dark p-1 mb-3">
                        <div class="mb-3">
                            <strong>Menanam Pohon</strong>
                            <p class="text-muted">12 Agustus 2025</p>
                        </div>
                    </div>
                    <div class="border-bottom border-dark p-1 mb-3">
                        <div class="mb-3">
                            <strong>Menanam Pohon</strong>
                            <p class="text-muted">12 Agustus 2025</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-dark rounded-pill">Kelola Kegiatan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 col-lg-8">
            <h5 class="fw-bold mb-3" style="color:#343C6A">Artikel</h5>
            <div class="row g-3 mb-4">
                @foreach (range(1, 3) as $i)
                <div class="col-6 col-md-4">
                    <div class="card border-0 shadow-sm rounded-4" style="background-color: #53B175; height: 120px;"></div>
                    <small class="d-block text-center mt-2 text-muted">eco-enzyme</small>
                </div>
                @endforeach
                <div class="col-12 text-end mt-2">
                    <button class="btn btn-dark rounded-pill">Kelola Artikel</button>
                </div>
            </div>

            <h5 class="fw-bold mb-3" style="color:#343C6A">Katalog Hadiah</h5>
           <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center me-5">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('beras.png') }}" alt="Beras" width="50" class="me-3 rounded">
                        <div>
                            <h6 class="fw-bold mb-0">Beras</h6>
                            <small class="text-muted">200 Poin</small>
                        </div>
                    </div>
                    <button class="btn bg-transparent">
                        <i class="fas fa-trash-alt text-danger"></i>
                    </button>
                </div>

                    <div class="d-flex justify-content-between align-items-center me-5 mb-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('gula.png') }}" alt="Gula" width="50" class="me-3 rounded">
                            <div>
                                <h6 class="fw-bold mb-0">Gula</h6>
                                <small class="text-muted">300 Poin</small>
                            </div>
                        </div>
                        <button class="btn bg-transparent">
                            <i class="fas fa-trash-alt text-danger"></i>
                        </button>
                    </div>

                    <div class="border-top border-dark">
                        <div class="text-center mt-3">
                            <a href="#" class="fw-bold text-decoration-none text-primary">TAMPILKAN SELENGKAPNYA</a>
                        </div>
                    </div>
                </div>
            </div>


            <h5 class="fw-bold mb-3" style="color:#343C6A">Komik</h5>
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body">
                    <div class="border-bottom border-dark p-1 mb-3">
                        <h6 class="fw-bold mb-1">Eco Buster</h6>
                        <small class="text-muted d-block mb-3">12 Agustus 2025</small>
                    </div>
                    <div class="border-bottom border-dark p-1 mb-3">
                        <h6 class="fw-bold mb-1">Mico dan Lobak</h6>
                        <small class="text-muted d-block mb-3">15 Agustus 2025</small>
                    </div>
                    <div class="text-center mt-3">
                        <a href="#" class="fw-bold text-decoration-none text-primary">TAMPILKAN SELENGKAPNYA</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <h5 class="fw-bold mb-3" style="color:#343C6A">Video</h5>
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body text-center">
                    <img src="{{ asset('video-placeholder.png') }}" alt="Video" class="img-fluid rounded-4 mb-2">
                    <small class="text-muted d-block mb-3">Eco Enzyme</small>
                    <button class="btn btn-dark rounded-pill">Kelola Video</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

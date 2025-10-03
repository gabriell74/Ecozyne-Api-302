@extends('layout.admin') 

@section('title', 'Dasbor Ecozyne')

@section('content')

<div class="row">
    {{-- Bagian Pengguna --}}
    <h5 class="mb-3 mt-2 fw-bold text-secondary">Pengguna</h5>
    <div class="col-md-4 mb-4">
        <div class="custom-card green-card">
            <h6 class="fw-bold">Komunitas</h6>
            <p class="text-muted">176 akun terdaftar</p>
            <a href="#" class="btn btn-kelola btn-sm">Kelola Akun</a>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="custom-card green-card">
            <h6 class="fw-bold">Bank Sampah</h6>
            <p class="text-muted">90 akun terdaftar</p>
            <a href="#" class="btn btn-kelola btn-sm">Kelola Akun</a>
        </div>
    </div>

    {{-- Kegiatan Sosial (Kolom Kanan) --}}
    <div class="col-md-4 mb-4">
        <div class="custom-card green-card h-100">
            <h6 class="fw-bold">Kegiatan Sosial</h6>
            <ul class="list-unstyled mt-3">
                <li><small>Menanam Pohon - 12 Agustus 2025</small></li>
                <li><small>Menanam Pohon - 15 Agustus 2025</small></li>
                <li><small>Menanam Pohon - 14 Agustus 2025</small></li>
            </ul>
            <div class="text-end mt-4">
                 <a href="#" class="btn btn-kelola btn-sm">Kelola Kegiatan</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    {{-- Bagian Kiri (Artikel, Hadiah, Komik) --}}
    <div class="col-md-8">
        {{-- ARTIKEL --}}
        <h5 class="mb-3 fw-bold text-secondary">Artikel</h5>
        <div class="row mb-4">
            {{-- Item Artikel Placeholder --}}
            <div class="col-4">
                <div class="article-thumb bg-success rounded-3 shadow-sm" style="height: 120px; background-color: var(--eco-green);"></div>
                <small class="text-center d-block mt-1">eco-enzyme</small>
            </div>
            <div class="col-4">
                <div class="article-thumb bg-success rounded-3 shadow-sm" style="height: 120px; background-color: var(--eco-green);"></div>
                <small class="text-center d-block mt-1">eco-enzyme</small>
            </div>
            <div class="col-4 d-flex flex-column justify-content-end align-items-end">
                <a href="#" class="btn btn-kelola">Kelola Artikel</a>
            </div>
        </div>

        {{-- KATALOG HADIAH --}}
        <h5 class="mb-3 fw-bold text-secondary">Katalog Hadiah</h5>
        <div class="custom-card p-3 mb-4">
            <div class="row">
                <div class="col-6 d-flex align-items-center mb-2">
                    <img src="{{ asset('beras.png') }}" alt="Beras" style="width: 50px;" class="me-3">
                    <div>
                        <h6 class="mb-0 fw-bold">Beras</h6>
                        <small class="text-muted">200 Poin</small>
                    </div>
                    <a href="#" class="ms-auto text-danger"><i class="fas fa-trash-alt"></i></a>
                </div>
                 <div class="col-6 d-flex align-items-center mb-2">
                    <img src="{{ asset('gula.png') }}" alt="Gula" style="width: 50px;" class="me-3">
                    <div>
                        <h6 class="mb-0 fw-bold">Gula</h6>
                        <small class="text-muted">300 Poin</small>
                    </div>
                    <a href="#" class="ms-auto text-danger"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none fw-bold" style="color: var(--eco-blue);">TAMPILKAN SELENGKAPNYA</a>
            </div>
        </div>

        {{-- KOMIK --}}
        <h5 class="mb-3 fw-bold text-secondary">Komik</h5>
        <div class="custom-card p-3 mb-4">
            <h6 class="fw-bold">Eco Buster</h6>
            <small class="text-muted">12 Agustus 2025</small>
            <hr>
            <h6 class="fw-bold">Mico dan Lobak</h6>
            <small class="text-muted">15 Agustus 2025</small>
            <div class="text-center mt-3">
                <a href="#" class="text-decoration-none fw-bold" style="color: var(--eco-blue);">TAMPILKAN SELENGKAPNYA</a>
            </div>
        </div>
    </div> 

    {{-- Bagian Kanan (Video) --}}
    <div class="col-md-4">
        <h5 class="mb-3 fw-bold text-secondary">Video</h5>
        <div class="custom-card green-card p-3">
            <div class="video-container text-center">
                <img src="{{ asset('video-placeholder.png') }}" alt="Video" class="img-fluid rounded-3" style="width: 100%;">
                <small class="text-muted d-block mt-2">Eco Enzyme</small>
            </div>
            <div class="text-center mt-3">
                <a href="#" class="btn btn-kelola btn-sm">Kelola Video</a>
            </div>
        </div>
    </div>
</div>

@endsection
@extends('layout.admin') 

@section('title', 'Dasbor Ecozyne')

@section('content')

<div class="row">
    {{-- Bagian Pengguna --}}
    <h5 class="mb-3 mt-2 fw-bold text-secondary">Pengguna</h5>
    <div class="col-md-4 mb-4">
        <div class="custom-card green-card" >
            @include('partials.card', [
            'title' => 'Komunitas',
            'data' => '176 akun terdaftar',
            'button_text' => 'Kelola Akun'
            ])
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="custom-card green-card">
            @include('partials.card', [
            'title' => 'Bank Sampah',
            'data' => '176 akun terdaftar',
            'button_text' => 'Kelola Akun'
            ])
        </div>
    </div>

    
    <div class="col-md-4 mb-4">
        <div class="">
            @include('partials.kegiatan_sosial')
            <div class="text-end mt-4">
            </div>
        </div>
    </div>
</div>

<div class="row">
   <div class="card-artikel-wrapper">
    <div class="artikel-header">
    <h2>Artikel</h2>z
    
    <div class="artikel-list-container"> 
        <div class="artikel-item-card">
            <div class="kotak-hijau-placeholder"></div>
            <p class="kategori-text">eco-enzyme</p>
        </div>
        
        <div class="artikel-item-card">
            <div class="kotak-hijau-placeholder"></div>
            <p class="kategori-text">eco-enzyme</p>
        </div>

         <div class="artikel-item-card">
            <div class="kotak-hijau-placeholder"></div>
            <p class="kategori-text">eco-enzyme</p>
        </div>
        <div class="tombol-container">
       <a href="#" class="btn-kelola-artikel">Kelola Artikel</a>
    </div>
    
    <div class="artikel-list-container">
        </div>
</div>
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
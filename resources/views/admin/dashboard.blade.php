@extends('layout.admin') 
@section('title', 'Dasbor Ecozyne')

@section('content')

<div class="main-content flex-grow-1 p-4" style="background-color: #f8f9fa;">
    
    <header class="d-flex justify-content-between align-items-center mb-4">
        </header>
    
    <div class="container-fluid p-0">
        </div>
</div>
    <div class="main-content flex-grow-1 p-4" style="background-color: #f8f9fa;">
        
        <header class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Dasbor</h1>
            <div class="d-flex align-items-center">
                <div class="input-group me-3" style="width: 250px;">
                    <input type="text" class="form-control rounded-pill" placeholder="Search for something" style="border-radius: 50px!important;">
                    <span class="input-group-text border-0 bg-transparent position-absolute end-0" style="z-index: 10;"><i class="fas fa-search"></i></span>
                </div>
                <button class="btn btn-light me-2 rounded-circle" style="width: 40px; height: 40px;"><i class="fas fa-bell"></i></button>
                <img src="user-placeholder.png" class="rounded-circle" alt="User" style="width: 40px; height: 40px; border: 2px solid #38bdf8;">
            </div>
        </header>
        <div class="container-fluid p-0">
            
            <div class="row">
                <h5 class="mb-3 text-secondary">Pengguna</h5>
                
                <div class="col-md-4">
                    @include('partials.card', [
                        'title' => 'Komunitas', 
                        'data' => '176 akun terdaftar', 
                        'color' => 'bg-info', 
                        'button_text' => 'Kelola Akun'
                    ])
                </div>
                
                <div class="col-md-4">
                    @include('partials.card', [
                        'title' => 'Bank Sampah', 
                        'data' => '90 akun terdaftar', 
                        'color' => 'bg-info', 
                        'button_text' => 'Kelola Akun'
                    ])
                </div>

                <div class="col-md-4">
                    @include('partials.kegiatan_sosial')
                </div>
            </div>

            <div class="row">

                <div class="col-md-8">
                    <h5 class="mb-1 text-secondary">Artikel</h5>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="article-thumb" style="background-color: #4ade80; height: 120px; border-radius: 8px;"></div>
                            <small class="text-center d-block mt-1">eco-enzyme</small>
                        </div>
                        <div class="col-md-3">
                            <div class="article-thumb" style="background-color: #4ade80; height: 120px; border-radius: 8px;"></div>
                            <small class="text-center d-block mt-1">eco-enzyme</small>
                        </div>
                        <div class="col-md-3">
                            <div class="article-thumb" style="background-color: #4ade80; height: 120px; border-radius: 8px;"></div>
                            <small class="text-center d-block mt-1">eco-enzyme</small>
                        </div>
                        <div class="col-md-3 d-flex align-items-end justify-content-end">
                             <button class="btn btn-sm btn-success rounded-pill" style="background-color: #4ade80; border: none;">Kelola Artikel</button>
                        </div>
                    </div>

                    <h5 class="mb-3 text-secondary">Katalog Hadiah</h5>
                    <div class="row mb-4 bg-white p-3 rounded-3 shadow-sm">  
                      @include('partials.hadiah_item', ['name' => 'Beras', 'points' => 200]) 
                      @include('partials.hadiah_item', ['name' => 'Gula', 'points' => 250]) 
                      <div class="text-center mt-2">
                          <a href="#" class="text-decoration-none" style="color: #38bdf8;">TAMPILKAN SELENGKAPNYA</a>
                      </div>
                  </div>

                    <h5 class="mb-3 text-secondary">Komik</h5>
                    <div class="row mb-4 bg-white p-3 rounded-3 shadow-sm">
                        @include('partials.komik_item', ['title' => 'Eco Buster', 'date' => '12 Agustus 2025'])
                        @include('partials.komik_item', ['title' => 'Mico dan Lobak', 'date' => '15 Agustus 2025'])
                        <div class="text-center mt-2">
                            <a href="#" class="text-decoration-none" style="color: #38bdf8;">TAMPILKAN SELENGKAPNYA</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <h5 class="mb-3 text-secondary">Video</h5>
                    @include('partials.video_card')
                </div>
            </div>

        </div>
        </div>
    </div>

<script src="https://kit.fontawesome.com/your-font-awesome-kit.js" crossorigin="anonymous"></script> 
@endsection
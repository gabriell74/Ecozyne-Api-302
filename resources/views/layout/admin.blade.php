<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dasbor Admin')</title>
    
    {{-- CDN Bootstrap dan Font Awesome --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- CSS KUSTOM --}}
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
</head>
<body class="bg-light">
    
    <div class="d-flex" id="wrapper">
        
        {{-- SIDEBAR --}}
        <div class="border-end bg-white shadow-sm" id="sidebar-wrapper">
            <div class="sidebar-heading p-3 text-start fw-bold fs-5 border-bottom">
                <img src="{{ asset('logo-placeholder.png') }}" alt="Logo" style="height: 30px;" class="me-2"> Ecozyne
            </div>
            <div class="list-group list-group-flush pt-2">
                <a href="#" class="list-group-item list-group-item-action border-0 py-3 active"><i class="fas fa-home me-2"></i> Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-exchange-alt me-2"></i> Tukar Poin</a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-users me-2"></i> Pengguna</a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-chart-bar me-2"></i> Artikel</a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-hands-helping me-2"></i> Kegiatan Sosial</a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-video me-2"></i> Video</a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-book-open me-2"></i> Komik</a>
                <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-gift me-2"></i> Katalog Hadiah</a>
            </div>
        </div>
        
        {{-- PAGE CONTENT WRAPPER --}}
        <div id="page-content-wrapper" class="flex-grow-1">
            
            {{-- HEADER / TOP NAVBAR --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3">
                <div class="container-fluid">
                    <h5 class="mb-0 fw-bold">Dasbor</h5>
                    <div class="d-flex ms-auto">
                        {{-- Search Bar --}}
                        <div class="input-group me-3" style="width: 250px;">
                            <input type="text" class="form-control rounded-pill-start border-end-0" placeholder="Search for something">
                            <span class="input-group-text bg-transparent border-start-0 rounded-pill-end"><i class="fas fa-search"></i></span>
                        </div>
                        <a href="#" class="text-secondary me-3 my-auto"><i class="fas fa-bell fa-lg"></i></a>
                        <img src="{{ asset('user-placeholder.png') }}" class="rounded-circle" alt="User" style="width: 40px; height: 40px; cursor: pointer;">
                    </div>
                </div>
            </nav>

            {{-- KONTEN UTAMA --}}
            <div class="container-fluid p-4">
                @yield('content')
            </div>

        </div>
    </div>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
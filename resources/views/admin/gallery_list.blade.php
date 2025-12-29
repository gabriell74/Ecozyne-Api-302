@extends('layout.admin')

@section('title', 'Galeri')
@section('header', 'Galeri')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold mb-2" style="color:#2B3A55;">Daftar Galeri</h4>
        <a href="{{ route('gallery.create') }}" class="btn text-white rounded-3 px-4 py-2"
            style="background-color: #38A169; border: 1px solid #2F855A; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Tambah Foto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3 mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($galleries->isEmpty())
        <div class="alert alert-info text-center shadow-sm border-0 rounded-3">
            Belum ada foto yang tersedia.
        </div>
    @else
        <div class="row g-4">
            @foreach($galleries as $gallery)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 position-relative hover-card" 
                        style="transition: all 0.3s ease; background: #ffffff;">
                        
                        <form action="{{ route('gallery.destroy', $gallery->id)}}" 
                              class="position-absolute top-0 end-0 m-2" 
                              method="post" style="z-index: 10;" id="delete_form{{ $gallery->id }}">
                            @csrf @method('delete')
                            <button class="btn btn-sm btn-danger rounded-circle shadow-sm" type="button" onclick="confirmDelete('delete_form{{ $gallery->id }}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                        @if($gallery->photo)
                            <div class="bg-white rounded-top-4 d-flex align-items-center justify-content-center" 
                                 style="height: 180px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $gallery->photo) }}" 
                                     class="card-img-top" 
                                     alt="{{ $gallery->title }}" 
                                     style="height: 100%; width: 100%; object-fit: contain;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-top-4" 
                                 style="height: 180px; color: #aaa;">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold mb-2" style="color:#2B3A55;">
                                {{ Str::limit($gallery->description, 50) }}
                            </h6>
                            <small class="text-muted mb-3">
                                {{ $gallery->created_at->format('d M Y') }}
                            </small>

                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('gallery.show', $gallery->id) }}" 
                                   class="btn btn-success rounded-pill px-3 py-1">
                                    <i class=""></i>Lihat Detail
                                </a>
                                <a href="{{ route('gallery.edit', $gallery->id) }}" 
                                   class="btn btn-outline-success btn-sm rounded-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $galleries->links() }}
        </div>
    @endif
</div>

<style>
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .btn-success {
        background-color: #38A169; /* Mengganti dari #2F855A agar konsisten dengan tombol Tambah */
        border: none;
    }

    .btn-success:hover {
        background-color: #2F855A;
    }

    .btn-outline-success {
        border-color: #00C896;
        color: #00C896;
    }

    .btn-outline-success:hover {
        background-color: #00C896;
        color: #fff;
    }

    .alert-success {
        background-color: #E6FFF3;
        color: #13855C;
    }

    .alert-info {
        background-color: #E7F6F2;
        color: #317773;
    }
</style>
@endsection
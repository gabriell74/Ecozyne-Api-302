@extends('layout.admin')

@section('title', 'Komik')
@section('header', 'Komik')

@section('content')
{{-- Kontainer utama dengan padding --}}
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold mb-2" style="color:#2B3A55;">Daftar Komik</h4>
        <a href="{{ route('comic.create') }}" class="btn text-white rounded-3 px-4 py-2" 
           style="background-color: #38A169; border: 1px solid #2F855A; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Tambah Komik
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3 mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($comics->isEmpty())
        <div class="alert alert-info text-center shadow-sm border-0 rounded-3">
            Belum ada komik yang tersedia.
        </div>
    @else
        {{-- Tata letak grid (4 kartu per baris di layar ekstra besar) --}}
        <div class="row g-4">
            @foreach($comics as $comic)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 position-relative hover-card" 
                         style="transition: all 0.3s ease; background: #ffffff;">
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('comic.destroy', $comic->id)}}" 
                              class="position-absolute top-0 end-0 m-2" 
                              method="post" style="z-index: 10;">
                            @csrf @method('delete')
                            <button class="btn btn-sm btn-danger rounded-circle shadow-sm" type="submit"
                                    onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                                <i class="fas fa-trash"></i> 
                            </button>
                        </form>

                        {{-- FOTO COVER KOMIK (Dengan object-fit: contain) --}}
                        @if($comic->cover_photo)
                            <div class="bg-white rounded-top-4 d-flex align-items-center justify-content-center" 
                                 style="height: 180px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $comic->cover_photo) }}" 
                                     class="card-img-top" 
                                     alt="{{ $comic->comic_title     }}" 
                                     style="height: 100%; width: 100%; object-fit: contain;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-top-4" 
                                 style="height: 180px; color: #aaa;">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif

                        {{-- KONTEN TEKS: Judul, Tanggal, Deskripsi --}}
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold mb-2" style="color:#2B3A55;">
                                {{ Str::limit($comic->comic_title, 50) }}
                            </h6>
                            
                            <small class="text-muted mb-3">
                                {{ $comic->created_at->format('d M Y') }}
                            </small>

                            {{-- Tombol Aksi (Edit dan Detail) --}}
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('comic.show', $comic->id) }}" 
                                    class="btn btn-success rounded-pill px-3 py-1">
                                    <i class=""></i>Lihat Detail
                                </a>
                                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('comic.edit', $comic->id) }}" class="btn btn-outline-success btn-sm rounded-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $comics->links() }}
        </div>
    @endif
</div>

<style>
    
</style>
@endsection
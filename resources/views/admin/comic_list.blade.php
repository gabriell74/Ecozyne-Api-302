@extends('layout.admin')

@section('title', 'Kegiatan Sosial')
@section('header', 'Kegiatan Sosial')

@section('content')
{{-- Kontainer utama dengan padding --}}
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold mb-2" style="color:#2B3A55;">Daftar Kegiatan Sosial</h4>
        <a href="{{ route('activity.create') }}" class="btn text-white rounded-3 px-4 py-2" 
           style="background-color: #38A169; border: 1px solid #2F855A; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Tambah Kegiatan
        </a>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3 mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($activities->isEmpty())
        <div class="alert alert-info text-center shadow-sm border-0 rounded-3">
            Belum ada kegiatan sosial yang tersedia.
        </div>
    @else
        {{-- Tata letak grid (4 kartu per baris di layar ekstra besar) --}}
        <div class="row g-4">
            @foreach($activities as $activity)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 position-relative hover-card" 
                         style="transition: all 0.3s ease; background: #ffffff;">
                        
                        {{-- Tombol Hapus --}}
                        <form action="{{ route('activity.destroy', $activity->id)}}" 
                              class="position-absolute top-0 end-0 m-2" 
                              method="post" style="z-index: 10;">
                            @csrf @method('delete')
                            <button class="btn btn-sm btn-danger rounded-circle shadow-sm" type="submit"
                                    onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?');">
                                <i class="fas fa-trash"></i> 
                            </button>
                        </form>

                        {{-- FOTO KEGIATAN (Dengan object-fit: contain) --}}
                        @if($activity->photo)
                            <div class="bg-white rounded-top-4 d-flex align-items-center justify-content-center" 
                                 style="height: 180px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $activity->photo) }}" 
                                     class="card-img-top" 
                                     alt="{{ $activity->title }}" 
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
                                {{ Str::limit($activity->title, 50) }}
                            </h6>
                            
                            <small class="text-muted mb-3">
                                {{ $activity->created_at->format('d M Y') }}
                            </small>
                            
                            {{-- DESKRIPSI KEGIATAN --}}
                            <p class="text-muted flex-grow-1" style="font-size: 0.9rem;">
                                {{ Str::limit(strip_tags($activity->description), 80) }}
                            </p>

                            {{-- Tombol Aksi (Edit dan Detail) --}}
                            <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                {{-- Tombol Detail --}}
                                <a href="{{ route('activity.show', $activity->id) }}" 
                                    class="btn btn-success rounded-pill px-3 py-1">
                                    <i class=""></i>Lihat Detail
                                </a>
                                
                                {{-- Tombol Edit --}}
                                <a href="{{ route('activity.edit', $activity->id) }}" class="btn btn-outline-success btn-sm rounded-circle">
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
            {{ $activities->links() }}
        </div>
    @endif
</div>

<style>
    /* Styling agar seragam dengan Daftar Artikel dan Katalog Hadiah */
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .btn-success {
        background-color: #38A169; /* Warna hijau tua dari tombol Tambah Artikel */
        border: none;
    }

    .btn-success:hover {
        background-color: #2F855A;
    }

    .btn-outline-success {
        border-color: #00C896; /* Warna hijau muda */
        color: #00C896;
    }

    .btn-outline-success:hover {
        background-color: #00C896;
        color: #fff;
    }

    .alert-success {
        background-color: #E6FFF3; /* Latar belakang alert sukses */
        color: #13855C;
    }

    .alert-info {
        background-color: #E7F6F2; /* Latar belakang alert info */
        color: #317773;
    }
</style>
@endsection
@extends('layout.admin')

@section('title', 'Detail Kegiatan: ' . $activity->title)
@section('header', 'Detail Kegiatan')

@section('content')
<div class="container py-4">

    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('activity.list') }}" class="btn btn-sm text-white rounded-pill px-4" 
           style="background-color: #38A169; border: none; font-weight: 500;">
            <i class="fas fa-arrow-left me-2"></i> Kembali 
        </a>
    </div>

    {{-- Kartu Konten Utama dengan Shadow dan Rounded Edge yang lebih menonjol --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        
        <div class="row g-0">
            {{-- Kolom Kiri: Gambar (Penuh di Mobile, Setengah di Desktop) --}}
            <div class="col-12 col-md-6">
                @if($activity->photo)
                    {{-- Gambar Kegiatan dengan gaya modern --}}
                    <img src="{{ asset('storage/' . $activity->photo) }}" 
                         class="img-fluid activity-img" 
                         alt="{{ $activity->title }}" 
                         style="height: 100%; width: 100%; object-fit: cover; border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                @else
                    {{-- Placeholder Gambar --}}
                    <div class="d-flex align-items-center justify-content-center bg-light text-muted p-5 h-100" style="min-height: 350px;">
                        <div class="text-center">
                            <i class="fas fa-image fa-4x mb-3" style="color: #ccc;"></i>
                            <p class="fw-bold mb-0">Tidak Ada Gambar Kegiatan</p>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Kolom Kanan: Detail Informasi --}}
            <div class="col-12 col-md-6">
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Judul dan Tanggal --}}
                    <h1 class="card-title fw-bold mb-2" style="color: #2D3748;">{{ $activity->title }}</h1>
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">
                        <i class=""></i> Dipublikasikan: {{ $activity->created_at->format('d M Y') }}
                    </p>

                    {{-- Tombol Aksi (Edit dan Hapus) --}}
                    <div class="d-flex mb-4 border-bottom pb-3">
                        <a href="{{ route('activity.edit', $activity->id) }}" class="btn btn-outline-primary rounded-pill me-3 px-4">
                            <i class="fas fa-edit me-2"></i> Edit 
                        </a>
                        <form action="{{ route('activity.destroy', $activity->id)}}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini secara permanen?');">
                            @csrf @method('delete')
                            <button class="btn btn-outline-danger rounded-pill px-4" type="submit">
                                <i class="fas fa-trash-alt me-2"></i> Hapus
                            </button>
                        </form>
                    </div>

                    {{-- Deskripsi Kegiatan --}}
                    <h5 class="fw-bold mb-3" style="color: #4A5568;">Deskripsi Lengkap</h5>
                    <div class="card-text text-secondary line-height-md" style="font-size: 1rem;">
                        {{ $activity->description }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Mengatasi border radius pada mobile */
    @media (max-width: 767.98px) {
        .activity-img {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            border-bottom-left-radius: 0 !important;
            max-height: 300px !important;
        }
    }
    
    /* Mengatasi border radius pada desktop */
    @media (min-width: 768px) {
        .activity-img {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
    }
    
    /* Gaya untuk Konten yang di-wrap (Deskripsi) */
    .line-height-md {
        line-height: 1.8;
    }
</style>
@endsection
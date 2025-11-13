@extends('layout.admin')

@section('title', 'Detail Komik : ' . $comic->comic_title)
@section('header', 'Detail Komik')

@section('content')
<div class="container py-4">

    {{-- Tombol Kembali yang bergaya konsisten --}}
    <div class="mb-4">
        <a href="{{ route('comic.list') }}" class="btn btn-sm text-white rounded-pill px-4" 
           style="background-color: #38A169; border: none; font-weight: 500;">
            <i class="fas fa-arrow-left me-2"></i> Kembali 
        </a>
    </div>

{{-- Kartu Konten Utama dengan Shadow dan Rounded Edge yang menonjol --}}
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            {{-- Kolom Kiri: Info Teks (Ubah ke col-md-6) --}}
            <div class="col-12 col-md-12"> 
                <div class="card-body p-4 p-md-5">
                    {{-- Judul Artikel --}}
                    <h1 class="card-title fw-bold mb-2" style="color: #2D3748;">{{ $comic->comic_title }}</h1>

                    {{-- Tanggal Publikasi --}}
                    <p class="text-muted mb-4" style="font-size: 0.95rem;">
                        <i class=""></i> Dipublikasikan: {{ $comic->created_at->format('d M Y') }}
                    </p>

                    {{-- Tombol Aksi (Edit dan Hapus) --}}
                    <div class="d-flex mb-4 border-bottom pb-3">
                        <a href="{{ route('comic.edit', $comic->id) }}" class="btn btn-outline-primary rounded-pill me-3 px-4">
                            <i class="fas fa-edit me-2"></i> Edit 
                        </a>
                        <form action="{{ route('comic.destroy', $comic->id)}}" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini secara permanen?');">
                            @csrf @method('delete')
                            <button class="btn btn-outline-danger rounded-pill px-4" type="submit">
                                <i class="fas fa-trash-alt me-2"></i> Hapus
                            </button>
                        </form>
                    </div>

                    {{-- ANDA MUNGKIN INGIN MENARUH GAMBAR DI SINI JIKA HANYA 1 FOTO --}}
                    {{-- ATAU BIARKAN DI KOLOM SEBELAH --}}
                    
                </div>
            </div>

            {{-- Kolom Kanan: Gambar (sudah benar col-md-6) --}}
            <div class="col-12 col-md-12">
                @foreach($comic_photos as $comic_photo)
                    {{-- Gambar Artikel --}}
                    <img src="{{ asset('storage/' . $comic_photo->photo) }}" 
                        class="img-fluid comic-img" 
                        alt="{{ $comic_photo->photo }}" 
                        style="width: 100%; object-fit: cover;"> {{-- Dihapus beberapa style agar lebih rapi --}}
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    /* --- Media Queries yang sudah Anda buat, ditambahkan di sini untuk kelengkapan --- */
    @media (max-width: 767.98px) {
        .comic-img {
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            border-bottom-left-radius: 0 !important;
            max-height: 300px !important;
        }
    }

    @media (min-width: 768px) {
        .comic-img {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
    } 
</style>
@endsection
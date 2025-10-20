@extends('layout.admin')

@section('title', 'Edit Artikel')
@section('header', 'Artikel')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Ubah Artikel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Judul Artikel</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="Masukkan judul artikel" 
                                   value="{{ $article->title }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="5" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Tuliskan isi artikel..." 
                                    >{{ $article->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       <div class="mb-3">
                            <label for="photo" class="form-label fw-bold">Foto Artikel</label>

                            @if ($article->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $article->photo) }}" 
                                        alt="Foto Artikel" 
                                        width="150" 
                                        class="rounded">
                                </div>
                                <small class="text-muted d-block mb-2">
                                    Biarkan kosong jika tidak ingin mengganti foto.
                                </small>
                            @endif

                            <input type="file" 
                                name="photo" 
                                id="photo" 
                                class="form-control @error('photo') is-invalid @enderror" 
                                accept="image/*">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="d-flex justify-content-between">
                            <a href="{{ route('article.list') }}" class="btn btn-outline-dark">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn bg-success text-white">
                                <i class="bi bi-save"></i> Simpan Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

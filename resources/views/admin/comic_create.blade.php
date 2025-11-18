@extends('layout.admin')

@section('title', 'Tambah Komik')
@section('header', 'Komik')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tambah Komik Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('comic.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="comic_title" class="form-label fw-bold">Judul Komik</label>
                            <input type="text" 
                                   name="comic_title" 
                                   id="comic_title" 
                                   class="form-control @error('comic_title') is-invalid @enderror" 
                                   placeholder="Masukkan judul komik" 
                                   value="{{ old('comic_title') }}">
                            @error('comic_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="cover_photo" class="form-label fw-bold">Foto Cover Komik</label>
                            <div id="preview_cover_foto" class="d-flex flex-wrap gap-2 mb-3"></div>
                            <input type="file" 
                                   name="cover_photo" 
                                   id="cover_photo" 
                                   class="form-control @error('cover_photo') is-invalid @enderror" 
                                   accept="image/*">
                            @error('cover_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <p class="form-label fw-bold">Foto Komik</p>
                            <div id="preview_foto" class="d-flex flex-wrap gap-2 mb-3"></div>
                            <div class="d-flex align-items-center justify-content-center border border-2 rounded bg-light"
                                id="input_foto" 
                                style="width: 100px; height: 100px; cursor: pointer;"> +
                            </div>
                            <input type="file" 
                                style="display: none;"
                                name="photo[]" 
                                id="photo" 
                                class="form-control @error('photo') is-invalid @enderror" 
                                accept="image/*" multiple> 
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('comic.list') }}" class="btn btn-outline-dark">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn bg-success text-white">
                                <i class="bi bi-save"></i> Simpan Komik
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    document.getElementById('input_foto').addEventListener('click', function() {
        document.getElementById('photo').click();
    });

    document.getElementById('photo').addEventListener('change', function(event) {
        let preview = document.getElementById('preview_foto');
        preview.innerHTML = ''; // kosongkan dulu
        
        let files = event.target.files;
        
        // Perulangan untuk memproses SEMUA file (Kode ini sudah benar)
        for (let file of files) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.width = 250; 
                img.style.borderRadius = '8px';
                img.style.objectFit = 'cover';
                
                // Tambahkan gambar ke wadah preview
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('cover_photo').addEventListener('change', function(event) {
        let preview = document.getElementById('preview_cover_foto');
        preview.innerHTML = ''; // kosongkan dulu
        let files = event.target.files;
        for (let file of files) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.width = 250;
                img.style.borderRadius = '8px';
                img.style.objectFit = 'cover';
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
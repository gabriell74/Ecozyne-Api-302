@extends('layout.admin')

@section('title', 'Ubah Komik')
@section('header', 'Komik')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Ubah Komik</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('comic_photo.update', $comic_photo->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                       <div class="mb-3">
                            <label for="photo" class="form-label fw-bold">Foto Komik</label>
                            @if ($comic_photo->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $comic_photo->photo) }}" 
                                        alt="Foto Komik" 
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
                            <div id="preview_foto"></div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('comic.show', $comic_photo->comic_id) }}" class="btn btn-outline-dark">
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
    document.getElementById('photo').addEventListener('change', function(event) {
        let preview = document.getElementById('preview_foto');
        preview.innerHTML = ''; // kosongkan dulu
        let files = event.target.files;
        for (let file of files) {
            let reader = new FileReader();
            reader.onload = function(e) {
                let img = document.createElement('img');
                img.src = e.target.result;
                img.width = 250 ;
                img.style.borderRadius = '8px';
                img.style.objectFit = 'cover';
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
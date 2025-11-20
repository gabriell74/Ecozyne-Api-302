@extends('layout.admin')

@section('title', 'Tambah Kegiatan')
@section('header', 'Kegiatan')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tambah Aktivitas Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('activity.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Judul Aktivitas</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="Masukkan judul aktivitas" 
                                   value="{{ old('title') }}">
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
                                      placeholder="Tuliskan deskripsi aktivitas..." 
                                    >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label fw-bold">Lokasi Kegiatan</label>
                            <input type="text" 
                                   name="location" 
                                   id="location" 
                                   class="form-control @error('location') is-invalid @enderror" 
                                   placeholder="Masukkan lokasi kegiatan" 
                                   value="{{ old('location') }}">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="quota" class="form-label fw-bold">Jumlah Kuota</label>
                            <input type="number" 
                                   name="quota" 
                                   id="quota" 
                                   class="form-control @error('quota') is-invalid @enderror" 
                                   placeholder="Masukkan jumlah kuota aktivitas" 
                                   value="{{ old('quota') }}">
                            @error('quota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="registration_start_date" class="form-label fw-bold">Tanggal Pembukaan Pendaftaran</label>
                            <input type="date" 
                                   name="registration_start_date" 
                                   id="registration_start_date" 
                                   class="form-control @error('registration_start_date') is-invalid @enderror" 
                                   value="{{ old('registration_start_date') }}">
                            @error('registration_start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="registration_due_date" class="form-label fw-bold">Tanggal Penutupan Pendaftaran</label>
                            <input type="date" 
                                   name="registration_due_date" 
                                   id="registration_due_date" 
                                   class="form-control @error('registration_due_date') is-invalid @enderror"
                                   value="{{ old('registration_due_date') }}">
                            @error('registration_due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-bold">Tanggal Mulai</label>
                            <input type="date" 
                                   name="start_date" 
                                   id="start_date" 
                                   class="form-control @error('start_date') is-invalid @enderror" 
                                   value="{{ old('start_date') }}">
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label fw-bold">Tanggal Selesai</label>
                            <input type="date" 
                                   name="due_date" 
                                   id="due_date" 
                                   class="form-control @error('due_date') is-invalid @enderror"
                                   value="{{ old('due_date') }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label fw-bold">Foto Aktivitas</label>
                            <div id="preview_foto"></div>
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
                            <a href="{{ route('activity.list') }}" class="btn btn-outline-dark">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn bg-success text-white">
                                <i class="bi bi-save"></i> Simpan Aktivitas
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
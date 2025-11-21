@extends('layout.admin')

@section('title', 'Ubah Kegiatan')
@section('header', 'Kegiatan')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Ubah Aktivitas</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('activity.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Judul Aktivitas</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="Masukkan judul aktivitas" 
                                   value="{{ $activity->title }}">
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
                                      placeholder="Tuliskan isi aktivitas..." 
                                    >{!! $activity->description !!}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label fw-bold">Lokasi Aktivitas</label>
                            <input type="text" 
                                   name="location" 
                                   id="location" 
                                   class="form-control @error('location') is-invalid @enderror" 
                                   placeholder="Masukkan lokasi aktivitas" 
                                   value="{{ $activity->location }}">
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
                                   placeholder="Masukkan judul aktivitas" 
                                   value="{{ $activity->quota }}">
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
                                   placeholder="Masukkan judul aktivitas" 
                                   value="{{ $activity->registration_start_date }}">
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
                                   placeholder="Masukkan judul aktivitas" 
                                   value="{{ $activity->registration_due_date }}">
                            @error('registration_due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        <div class="mb-3">
                            <label for="start_date" class="form-label fw-bold">Tanggal Mulai</label>
                            <input type="date" 
                                   name="start_date" 
                                   id="start_date" 
                                   class="form-control @error('start_date') is-invalid @enderror" 
                                   placeholder="Masukkan judul aktivitas" 
                                   value="{{ $activity->start_date }}">
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
                                   placeholder="Masukkan judul aktivitas" 
                                   value="{{ $activity->due_date }}">
                            @error('due_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                       <div class="mb-3">
                            <label for="photo" class="form-label fw-bold">Foto Aktivitas</label>

                            @if ($activity->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $activity->photo) }}" 
                                        alt="Foto Aktivitas" 
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
@endsection
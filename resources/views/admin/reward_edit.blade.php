@extends('layout.admin')

@section('title', 'Ubah Hadiah')
@section('header', 'Hadiah')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Ubah Artikel</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reward.update', $reward->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <div class="mb-3">
                            <label for="reward_name" class="form-label fw-bold">Judul Artikel</label>
                            <input type="text" 
                                   name="reward_name" 
                                   id="reward_name" 
                                   class="form-control @error('reward_name') is-invalid @enderror" 
                                   placeholder="Masukkan nama hadiah" 
                                   value="{{ $reward->reward_name }}">
                            @error('reward_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label fw-bold">Stock</label>
                            <input type="number" 
                                   name="stock" 
                                   id="stock" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   placeholder="Masukkan nama hadiah" 
                                   value="{{ $reward->stock }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit_point" class="form-label fw-bold">Harga Tukar (Point)</label>
                            <input type="number" 
                                   name="unit_point" 
                                   id="unit_point" 
                                   class="form-control @error('unit_point') is-invalid @enderror" 
                                   placeholder="Masukkan nama hadiah" 
                                   value="{{ $reward->unit_point }}">
                            @error('unit_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label fw-bold">Foto Hadiah</label>

                            @if ($reward->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $reward->photo) }}" 
                                        alt="Foto Hadiah" 
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
                            <a href="{{ route('reward.list') }}" class="btn btn-outline-dark">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                            <button type="submit" class="btn bg-success text-white">
                                <i class="bi bi-save"></i> Simpan Hadiah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
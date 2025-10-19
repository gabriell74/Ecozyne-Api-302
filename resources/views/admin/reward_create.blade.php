@extends('admin.dashboard')

@section('title', 'Tambah Hadiah')
@section('header', 'Hadiah')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Tambah Hadiah Baru</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reward.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="reward_name" class="form-label fw-bold">Hadiah</label>
                            <input type="text" 
                                   name="reward_name" 
                                   id="reward_name" 
                                   class="form-control @error('reward_name') is-invalid @enderror" 
                                   placeholder="Masukkan nama hadiah" 
                                   value="{{ old('reward_name') }}">
                            @error('reward_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="5" 
                                      class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Tuliskan deskripsi hadiah..." 
                                    >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="stock" class="form-label fw-bold">Stock</label>
                            <input type="number" 
                                   name="stock" 
                                   id="stock" 
                                   class="form-control @error('stock') is-invalid @enderror" 
                                   placeholder="Masukkan jumlah stock" 
                                   value="{{ old('stock') }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="unit_point" class="form-label fw-bold">Point</label>
                            <input type="number" 
                                   name="unit_point" 
                                   id="unit_point" 
                                   class="form-control @error('unit_point') is-invalid @enderror" 
                                   placeholder="Masukkan harga point hadiah" 
                                   value="{{ old('unit_point') }}">
                            @error('unit_point')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label fw-bold">Foto Artikel</label>
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

@extends('layout.admin')

@section('title', 'Detail Reward')
@section('header', 'Reward')

@section('content')
<div class="container py-4">

    <div class="mb-3">
        <a href="{{ route('reward.list') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        @if($reward->photo)
            <img src="{{ asset('storage/' . $reward->photo) }}" 
                 class="card-img-top" 
                 alt="{{ $reward->title }}" 
                 style="max-height: 700px; object-fit: cover;">
        @else
            <div class="bg-light text-center py-5 text-muted">
                <i class="fas fa-image fa-3x mb-2"></i>
                <p class="mb-0">Tidak ada gambar</p>
            </div>
        @endif

        <div class="card-body">
            <h3 class="card-title fw-bold">{{ $reward->reward_name }}</h3>
            <hr>

            <p class="card-text">
                {{ $reward->description }}
            </p>
            <hr>
            <p class="card-text">
                Stock Tersisa: {{ $reward->stock }}
            </p>
            <p class="card-text">
                Harga Tukar (Point) : {{ $reward->unit_point }}
            </p>
        </div>

        <div class="card-footer text-muted d-flex justify-content-between align-items-center">
            <small>Dipublikasikan: {{ $reward->created_at->format('d M Y') }}</small>
        </div>
    </div>
</div>
@endsection

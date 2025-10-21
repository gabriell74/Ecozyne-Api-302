@extends('layout.admin')

@section('title', 'Detail Aktivitas')
@section('header', 'Aktivitas')

@section('content')
<div class="container py-4">

    <div class="mb-3">
        <a href="{{ route('activity.list') }}" class="btn btn-outline-dark">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        @if($activity->photo)
            <img src="{{ asset('storage/' . $activity->photo) }}" 
                 class="card-img-top" 
                 alt="{{ $activity->title }}" 
                 style="max-height: 700px; object-fit: cover;">
        @else
            <div class="bg-light text-center py-5 text-muted">
                <i class="fas fa-image fa-3x mb-2"></i>
                <p class="mb-0">Tidak ada gambar</p>
            </div>
        @endif

        <div class="card-body">
            <h3 class="card-title fw-bold">{{ $activity->title }}</h3>
            <hr>
            <p class="card-text">
                {{ $activity->description }}
            </p>
        </div>

        <div class="card-footer text-muted d-flex justify-content-between align-items-center">
            <small>Dipublikasikan: {{ $activity->created_at->format('d M Y') }}</small>
        </div>
    </div>
</div>
@endsection

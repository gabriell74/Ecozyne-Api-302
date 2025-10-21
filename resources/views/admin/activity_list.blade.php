@extends('layout.admin')

@section('title', 'Aktivitas Kegiatan')
@section('header', 'Aktivitas Kegiatan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold text-secondary mb-2">Daftar Aktivitas</h4>
        <a href="{{ route('activity.create') }}" class="btn text-white bg-black">
            <i class="fas fa-plus me-2"></i>Tambah Aktivitas
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-light mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($activities->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada aktivitas yang tersedia.
        </div>
    @else
        <div class="row g-4">
            @foreach($activities as $activity)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 bg-white">
                        @if($activity->photo)
                        <div class="position-relative d-inline-block-w-100" style="max-width: 400px;">
                            <form action="{{ route('activity.destroy', $activity->id)}}" class="position-absolute top-0 end-0 m-2" method="post">
                                @csrf @method('delete')
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <img src="{{ asset('storage/' . $activity->photo) }}" class="card-img-top" alt="{{ $activity->title }}" style="height: 180px; object-fit: cover;">
                        </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 180px; color: gray;">
                                <form action="{{ route('activity.destroy', $activity->id)}}" class="position-absolute top-0 end-0 m-2" method="post">
                                    @csrf @method('delete')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold text-dark mb-2">{{ Str::limit($activity->title, 50) }}</h6>
                            <small class="text-muted mb-3">
                                {{ $activity->created_at->format('d M Y') }}
                            </small>
                            <p class="text-muted flex-grow-1" style="font-size: 0.9rem;">
                                {{ Str::limit(strip_tags($activity->description), 80) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('activity.show', $activity->id) }}" 
                                   class="btn text-white bg-black rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Lihat Artikel
                                </a>
                                <div>
                                    <a href="{{ route('activity.edit', $activity->id) }}" 
                                       class=" btn btn-sm btn-outline-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

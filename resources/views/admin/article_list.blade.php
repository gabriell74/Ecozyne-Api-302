@extends('layout.admin')

@section('title', 'Artikel')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold text-secondary mb-2">Daftar Artikel</h4>
        <a href="{{ route('article.create') }}" class="btn text-white bg-black">
            <i class="fas fa-plus me-2"></i>Tambah Artikel
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-light mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($articles->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada artikel yang tersedia.
        </div>
    @else
        <div class="row g-4">
            @foreach($articles as $article)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 bg-white">
                        @if($article->photo)
                        <div class="position-relative d-inline-block-w-100" style="max-width: 400px;">
                            <form action="{{ route('article.destroy', $article->id)}}" class="position-absolute top-0 end-0 m-2" method="post">
                                @csrf @method('delete')
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <img src="{{ asset('storage/' . $article->photo) }}" class="card-img-top" alt="{{ $article->title }}" style="height: 180px; object-fit: cover;">
                        </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" 
                                 style="height: 180px; color: gray;">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold text-dark mb-2">{{ Str::limit($article->title, 50) }}</h6>
                            <small class="text-muted mb-3">
                                {{ $article->created_at->format('d M Y') }}
                            </small>
                            <p class="text-muted flex-grow-1" style="font-size: 0.9rem;">
                                {{ Str::limit(strip_tags($article->description), 80) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('article.show', $article->id) }}" 
                                   class="btn text-white bg-black rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Lihat Artikel
                                </a>
                                <div>
                                    <a href="{{ route('article.show', $article->id) }}" 
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

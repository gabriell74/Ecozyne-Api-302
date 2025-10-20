@extends('layout.admin')

@section('title', 'Katalog Hadiah')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold text-secondary mb-2">Daftar Hadiah</h4>
        <a href="{{ route('reward.create') }}" class="btn text-white bg-black">
            <i class="fas fa-plus me-2"></i>Tambah Hadiah
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-light mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($rewards->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada hadiah yang tersedia.
        </div>
    @else
        <div class="row g-4">
            @foreach($rewards as $reward)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 bg-white">
                        @if($reward->photo)
                        <div class="position-relative d-inline-block-w-100" style="max-width: 400px;">
                            <form action="{{ route('reward.destroy', $reward->id)}}" class="position-absolute top-0 end-0 m-2" method="post">
                                @csrf @method('delete')
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <img src="{{ asset('storage/' . $reward->photo) }}" class="card-img-top" alt="{{ $reward->title }}" style="height: 180px; object-fit: cover;">
                        </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 180px; color: gray;">
                                <form action="{{ route('reward.destroy', $reward->id)}}" class="position-absolute top-0 end-0 m-2" method="post">
                                    @csrf @method('delete')
                                    <button class="btn btn-sm btn-danger" type="submit">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold text-dark mb-2">{{ Str::limit($reward->reward_name, 500) }}</h6>
                            <p class="text-muted flex-grow-1" style="font-size: 0.9rem;">
                                {{ $reward->unit_point }} Point
                            </p>
                            <div class="d-flex justify-content-between align-items-center mt-2">
                                <a href="{{ route('reward.show', $reward->id) }}" 
                                   class="btn text-white bg-black rounded-pill">
                                    <i class="fas fa-eye me-1"></i>Lihat Hadiah
                                </a>
                                <div>
                                    <a href="{{ route('reward.edit', $reward->id) }}" 
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

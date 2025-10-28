@extends('layout.admin')

@section('title', 'Katalog Hadiah')
@section('header', 'Katalog Hadiah') 

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold mb-2" style="color:#2B3A55;">Daftar Hadiah</h4>
        <a href="{{ route('reward.create') }}" class="btn text-white rounded-3 px-4 py-2"
            style="background-color: #38A169; border: 1px solid #2F855A; font-weight: 600;">
            <i class="fas fa-plus me-2"></i>Tambah Hadiah
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3 mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if($rewards->isEmpty())
        <div class="alert alert-info text-center shadow-sm border-0 rounded-3">
            Belum ada hadiah yang tersedia.
        </div>
    @else
        <div class="row g-4">
            @foreach($rewards as $reward)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="card h-100 shadow-sm border-0 rounded-4 position-relative hover-card" 
                        style="transition: all 0.3s ease; background: #ffffff;">
                        
                        <form action="{{ route('reward.destroy', $reward->id)}}" 
                              class="position-absolute top-0 end-0 m-2" 
                              method="post" style="z-index: 10;">
                            @csrf @method('delete')
                            <button class="btn btn-sm btn-danger rounded-circle shadow-sm" type="submit">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>

                        @if($reward->photo)
                            <div class="bg-white rounded-top-4 d-flex align-items-center justify-content-center" 
                                 style="height: 180px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $reward->photo) }}" 
                                     class="card-img-top" 
                                     alt="{{ $reward->reward_name }}" 
                                     style="height: 100%; width: 100%; object-fit: contain;">
                            </div>
                        @else
                            <div class="d-flex align-items-center justify-content-center bg-light rounded-top-4" 
                                 style="height: 180px; color: #aaa;">
                                <i class="fas fa-image fa-2x"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold mb-2" style="color:#2B3A55;">
                                {{ Str::limit($reward->reward_name, 50) }}
                            </h6>
                            <small class="text-success fw-semibold mb-3">
                                <i class="fas fa-coins me-1"></i> {{ number_format($reward->unit_point, 0, ',', '.') }} Point
                            </small>
                            <p class="text-muted flex-grow-1" style="font-size: 0.9rem;">
                                Tersedia: {{ $reward->stock ?? 'N/A' }} unit
                            </p>

                            <div class="d-flex justify-content-end align-items-center mt-2">
                                {{-- Tombol Lihat Detail dihapus di sini --}}
                                <a href="{{ route('reward.edit', $reward->id) }}" 
                                   class="btn btn-outline-success btn-sm rounded-circle">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $rewards->links() }}
        </div>
    @endif
</div>

<style>
    /* Styling agar seragam dengan Daftar Artikel */
    .hover-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .btn-success {
        background-color: #38A169; /* Warna hijau tua dari tombol Tambah Artikel */
        border: none;
    }

    .btn-success:hover {
        background-color: #2F855A;
    }

    .btn-outline-success {
        border-color: #00C896; /* Warna hijau muda */
        color: #00C896;
    }

    .btn-outline-success:hover {
        background-color: #00C896;
        color: #fff;
    }

    .alert-success {
        background-color: #E6FFF3; /* Latar belakang alert sukses */
        color: #13855C;
    }

    .alert-info {
        background-color: #E7F6F2; /* Latar belakang alert info */
        color: #317773;
    }
</style>
@endsection
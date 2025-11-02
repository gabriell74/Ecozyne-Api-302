@extends('layout.admin')

@section('title', 'Kelola Komunitas - Ecozyne')

@section('content')
<div class="container-fluid py-4 page-komunitas" 
     style="background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%); min-height: 100vh;">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"></li>
                        </ol>
                    </nav>
                    <h4 class="fw-bold mb-0" style="color:#343C6A">Kelola Komunitas</h4>
                    <p class="text-muted mb-0">{{ $community_total }} Akun Komunitas Terdaftar</p>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success shadow-sm border-0 rounded-3 mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if($communities->isEmpty())
                <div class="alert alert-info text-center shadow-sm border-0 rounded-3">
                    Belum ada kegiatan sosial yang tersedia.
                </div>
            @else <!-- Card List Komunitas -->
                <div class="card border-0 shadow-sm rounded-4" 
                    style="background-color: #f5f8f3d2; color: #00000087;">
                    <div class="card-body p-0">

                        <!-- Komunitas 1 -->
                        @foreach($communities as $community)
                        <div class="border-bottom border-secondary p-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle me-3" style="font-size: 1.9rem; color: #007559;"></i>
                                    <div>
                                        <h5 class="fw-bold mb-1 text-#001d16" style="font-size: 1rem;">Username : {{ $community->user->username }}</h5>
                                        <h6 class="fw-semibold mb-1 text-#001d16" style="font-size: 1rem;">Nama Komunitas : {{ $community->name }}</h6>
                                        <p class="mb-0 text-#001d16" style="font-size: 0.85rem;">Email : {{ $community->user->email }}</p>
                                        <small class="text-light-50" style="font-size: 0.75rem;">Tanggal Pendaftaran : {{ $community->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>
                                <form action="{{ route('community.destroy', $community->id)}}" method="post" style="z-index: 10;">
                                    @csrf @method('delete')
                                    <button class="btn btn-outline-danger btn-sm rounded-pill" type="submit">
                                        <i class="fas fa-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $communities->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layout.admin')

@section('title', 'Konfirmasi Tukar Hadiah')

@section('content')
<div class="container-fluid py-4 bg-light rounded">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4" style="background-color: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h3 class="fw-bold mb-2 text-success">
                                <i class="fas fa-gift me-2 text-success"></i>
                                Konfirmasi Tukar Hadiah
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clock me-1"></i>
                                <strong>{{ $pendingCount }}</strong> Komunitas Menunggu Konfirmasi Penukaran Hadiah
                            </p>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="badge rounded-pill px-4 py-2 fs-6" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); backdrop-filter: blur(10px); transition: all 0.3s ease;"">
                                <i class="fas fa-inbox me-1"></i>Total: {{ $exchanges->total() }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-lg border-0 rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0 rounded-4 mb-4" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    @if($exchanges->isEmpty())
        <div class="card border-0 shadow-lg rounded-4 text-center py-5">
            <div class="card-body">
                <i class="fas fa-inbox text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                <h5 class="mt-4 text-muted">Belum ada komunitas yang menukar hadiah</h5>
                <p class="text-muted">Data penukaran hadiah akan muncul di sini</p>
            </div>
        </div>
    @else
        <div class="accordion" id="exchangeAccordion">
            @foreach($exchanges as $index => $exchange)
            <div class="accordion-item border-0 shadow-sm rounded-3 mb-3" style="background-color: rgba(255, 255, 255, 0.75);">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                        <div class="d-flex align-items-center justify-content-between w-100 me-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong class="d-block">{{ $exchange->community->user->username }}</strong>
                                    <small style="opacity: 0.9;">{{ $exchange->community->name }}</small>
                                </div>
                            </div>
                            <div>
                                @php
                                    $statusConfig = match($exchange->exchange_status) {
                                        'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'fa-clock'],
                                        'approved' => ['class' => 'bg-success text-white', 'icon' => 'fa-check-circle'],
                                        'rejected' => ['class' => 'bg-danger text-white', 'icon' => 'fa-times-circle'],
                                        default => ['class' => 'bg-secondary text-white', 'icon' => 'fa-question-circle'],
                                    };
                                @endphp
                                <span class="badge {{ $statusConfig['class'] }} rounded-pill px-3 py-2">
                                    <i class="fas {{ $statusConfig['icon'] }} me-1"></i>
                                    {{ strtoupper($exchange->exchange_status_label) }}
                                </span>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}">
                    <div class="accordion-body p-4" style="background-color: rgba(255, 255, 255, 0.85);">
                        
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-success">
                                <i class="fas fa-gift me-2 text-success"></i>Detail Hadiah
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle">
                                    <thead style="background-color: #f8f9fa;">
                                        <tr>
                                            <th class="border-0">Nama Hadiah</th>
                                            <th class="border-0 text-center">Jumlah</th>
                                            <th class="border-0 text-center">Total Poin</th>
                                            <th class="border-0 text-center">Sisa Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exchange->exchangeTransactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-box me-2 text-success"></i>
                                                    <span>{{ $transaction->reward->reward_name }}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge rounded-pill px-2 bg-success">
                                                    {{ $transaction->amount }}x
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-success rounded-pill px-2">
                                                    <i class="fas fa-coins me-1"></i>{{ number_format($transaction->total_unit_point) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info rounded-pill px-2">
                                                    {{ $transaction->reward->stock }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-success">
                                <i class="fas fa-map-marker-alt text-danger me-2"></i>Alamat Pengiriman
                            </h6>
                            <div class="card border-0 shadow-sm" style="background-color: rgba(248, 249, 250, 0.8);">
                                <div class="card-body p-3">
                                    <div class="row g-2">
                                        <div class="col-12">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-road me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Alamat</small>
                                                    <span class="fw-bold">{{ $exchange->community->address->address ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-building me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Kelurahan</small>
                                                    <span class="fw-bold">{{ $exchange->community->address->kelurahan->kelurahan ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-city me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Kecamatan</small>
                                                    <span class="fw-bold">{{ $exchange->community->address->kelurahan->kecamatan->kecamatan ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-wrap pt-3 border-top">
                            <div class="text-muted">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <small>{{ $exchange->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            @if ($exchange->exchange_status === 'pending')
                            <div class="mt-2 mt-md-0">
                                <form action="{{ route('admin.exchange_reward_approval', $exchange->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="exchange_status" value="rejected" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                        <i class="fas fa-times me-1"></i>Tolak
                                    </button>
                                </form>
                                <form action="{{ route('admin.exchange_reward_approval', $exchange->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="exchange_status" value="approved" class="btn btn-outline-success btn-sm rounded-pill px-3">
                                        <i class="fas fa-check me-1"></i>Setujui
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            <div class="card border-0 shadow-lg rounded-4 p-2">
                {{ $exchanges->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
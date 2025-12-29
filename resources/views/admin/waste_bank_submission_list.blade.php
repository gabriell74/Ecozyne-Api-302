@extends('layout.admin')

@section('title', 'Konfirmasi Pengajuan Bank Sampah')

@section('content')
<div class="container-fluid py-4 bg-light rounded">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg rounded-4" style="background-color: rgba(255, 255, 255, 0.95);">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h3 class="fw-bold mb-2 text-success">
                                <i class="fas fa-user-clock me-2 text-success"></i>
                                Konfirmasi Pengajuan Bank Sampah
                            </h3>
                            <p class="text-muted mb-0">
                                <i class="fas fa-clock me-1"></i>
                                <strong>{{ $pendingCount }}</strong> Komunitas Menunggu Konfirmasi Pengajuan Bank Sampah
                            </p>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="badge rounded-pill px-4 py-2 fs-6" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); backdrop-filter: blur(10px); transition: all 0.3s ease;"">
                                <i class="fas fa-inbox me-1"></i>Total: {{ $waste_bank_submissions->total() }}
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


    @if($waste_bank_submissions->isEmpty())
        <div class="card border-0 shadow-lg rounded-4 text-center py-5">
            <div class="card-body">
                <i class="fas fa-inbox text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                <h5 class="mt-4 text-muted">Belum ada komunitas yang mengajukan menjadi bank sampah</h5>
                <p class="text-muted">Data pengajuan bank sampah muncul disini</p>
            </div>
        </div>
    @else
        <div class="accordion" id="exchangeAccordion">
            @foreach($waste_bank_submissions as $index => $waste_bank_submission)
            <div class="accordion-item border-0 shadow-sm rounded-3 mb-3" style="background-color: rgba(255, 255, 255, 0.75);">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button collapsed rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="false" aria-controls="collapse{{ $index }}" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                        <div class="d-flex align-items-center justify-content-between w-100 me-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-user-circle me-3" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong class="d-block">{{ $waste_bank_submission->community->user->username }}</strong>
                                    <small style="opacity: 0.9;">{{ $waste_bank_submission->community->name }}</small>
                                </div>
                            </div>
                            <div>
                                @php
                                    $statusConfig = match($waste_bank_submission->status) {
                                        'pending' => ['class' => 'bg-warning text-dark', 'icon' => 'fa-clock', 'status' => 'Menunggu'],
                                        'approved' => ['class' => 'bg-success text-white', 'icon' => 'fa-check-circle', 'status' => 'Disetujui'],
                                        'rejected' => ['class' => 'bg-danger text-white', 'icon' => 'fa-times-circle', 'status' => 'Ditolak'],
                                        default => ['class' => 'bg-secondary text-white', 'icon' => 'fa-question-circle', 'status' => 'Tidak Diketahui'],
                                    };
                                @endphp
                                <span class="badge {{ $statusConfig['class'] }} rounded-pill px-3 py-2">
                                    <i class="fas {{ $statusConfig['icon'] }} me-1"></i>
                                    {{ strtoupper($statusConfig['status']) }}
                                </span>
                            </div>
                        </div>
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $index }}">
                    <div class="accordion-body p-4" style="background-color: rgba(255, 255, 255, 0.85);">

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="fas fa-user text-success me-2"></i>Detail Pengguna
                            </h6>
                            <div class="card border-0 shadow-sm" style="background-color: rgba(248, 249, 250, 0.8);">
                                <div class="card-body p-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-id-card me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Username</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->community->user->username }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-at me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Email</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->community->user->email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-users-gear me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Nama Komunitas</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->community->name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-phone me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Nomor Handphone</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->community->phone_number }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="far fa-map me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Alamat</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->community->address->address }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-city me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Kode Pos</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->community->address->postal_code }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="fas fa-folder-open text-success me-2"></i>Detail Pengajuan
                            </h6>
                            <div class="card border-0 shadow-sm" style="background-color: rgba(248, 249, 250, 0.8);">
                                <div class="card-body p-3">
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-trash me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Nama Bank Sampah</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->waste_bank_name }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-road me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Lokasi Bank Sampah</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->waste_bank_location }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-map-pin me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Latitude</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->latitude }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-map-pin me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Longitude</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->longitude }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="far fa-note-sticky me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">Catatan</small>
                                                    <span class="fw-bold">{{ $waste_bank_submission->notes }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-file-pdf me-2 mt-1 text-success"></i>
                                                <div>
                                                    <small class="text-muted d-block">File Dokumen Pengajuan</small>
                                                    <span class="fw-bold"><a href="{{ asset('storage/'. $waste_bank_submission->file_document )}}">Download PDF</a></span>
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
                                <small>{{ $waste_bank_submission->created_at->format('d M Y, H:i') }}</small>
                            </div>
                            @if ($waste_bank_submission->status === 'pending')
                            <div class="mt-2 mt-md-0">
                                <form action="{{ route('waste_bank_submission.approval', $waste_bank_submission->id) }}" method="post" class="d-inline" id="reject_form{{ $waste_bank_submission->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-3" onclick="confirmReject('reject_form{{ $waste_bank_submission->id }}')">
                                        <i class="fas fa-times me-1"></i>Tolak
                                    </button>
                                </form>
                                <form action="{{ route('waste_bank_submission.approval', $waste_bank_submission->id) }}" method="post" class="d-inline" id="accept_form{{ $waste_bank_submission->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button type="button" class="btn btn-success btn-sm rounded-pill px-3" onclick="confirmAccept('accept_form{{ $waste_bank_submission->id }}')">
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
                {{ $waste_bank_submissions->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
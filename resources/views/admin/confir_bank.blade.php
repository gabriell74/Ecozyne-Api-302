@extends('layout.admin') 

@section('title', 'Pengajuan Bank Sampah')
@section('header', 'Daftar Pengajuan Komunitas')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h4 class="fw-bold mb-0" style="color:#2B3A55;">Daftar Pengajuan Komunitas</h4>
        <div class="d-flex align-items-center">
            <label for="filterStatus" class="form-label mb-0 me-2 text-muted">Filter Status:</label>
            <select class="form-select w-auto" id="filterStatus" style="min-width: 150px;">
                <option value="all">Semua Status</option>
                <option value="pending">Menunggu Persetujuan</option>
                <option value="approved">Diterima</option>
                <option value="rejected">Ditolak</option>
            </select>
        </div>
    </div>

    {{-- Pesan Sukses/Error --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 rounded-3 mt-3">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0 rounded-3 mt-3">
            {{ session('error') }}
        </div>
    @endif

    {{-- Kartu Tabel --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">
            @if($submissions->isEmpty()) {{-- Asumsi ada variabel $submissions dari controller --}}
                <div class="alert alert-info text-center shadow-sm border-0 rounded-3">
                    Belum ada pengajuan bank sampah yang tersedia.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Komunitas</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pengaju (PIC)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Pengajuan</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $submission)
                            <tr>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">#{{ $submission->id }}</p>
                                </td>
                                <td>
                                    <h6 class="mb-0 text-sm fw-bold" style="color:#2B3A55;">{{ $submission->community_name }}</h6>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $submission->pic_name }}</p>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">{{ $submission->created_at->format('d M Y') }}</p>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch($submission->status) {
                                            case 'pending':
                                                $statusClass = 'bg-warning text-dark';
                                                $statusText = 'MENUNGGU PERSETUJUAN';
                                                break;
                                            case 'approved':
                                                $statusClass = 'bg-success text-white';
                                                $statusText = 'DITERIMA';
                                                break;
                                            case 'rejected':
                                                $statusClass = 'bg-danger text-white';
                                                $statusText = 'DITOLAK';
                                                break;
                                            default:
                                                $statusClass = 'bg-secondary text-white';
                                                $statusText = 'TIDAK DIKETAHUI';
                                        }
                                    @endphp
                                    <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill fw-semibold">{{ $statusText }}</span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('bank_sampah.show', $submission->id) }}" class="btn btn-sm btn-outline-success rounded-circle p-2" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $submissions->links('pagination::bootstrap-5') }} {{-- Sesuaikan dengan gaya paginasi Anda --}}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Tambahan styling untuk konsistensi */
    .btn-outline-success {
        border-color: #00C896; /* Warna hijau muda */
        color: #00C896;
    }
    .btn-outline-success:hover {
        background-color: #00C896;
        color: #fff;
    }
    .badge.bg-warning {
        background-color: #FFC107 !important; /* Warna kuning Bootstrap default */
        color: #212529 !important; /* Agar teks kuning terlihat jelas */
    }
    .badge.bg-success {
        background-color: #38A169 !important; /* Warna hijau Ecozyne */
    }
    .badge.bg-danger {
        background-color: #dc3545 !important; /* Warna merah Bootstrap default */
    }
    .table thead th {
        border-bottom: 1px solid #e9ecef; /* Garis bawah pada header tabel */
    }
    .table tbody tr:last-child {
        border-bottom: none; /* Hilangkan border di baris terakhir tbody */
    }
    .pagination .page-link {
        color: #38A169; /* Warna link paginasi */
        border-color: #e9ecef;
    }
    .pagination .page-item.active .page-link {
        background-color: #38A169;
        border-color: #38A169;
        color: white;
    }
    .pagination .page-link:hover {
        background-color: #E6FFF3; /* Latar belakang hover */
        border-color: #38A169;
        color: #38A169;
    }
</style>
@endsection
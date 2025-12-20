@extends('layout.admin')

@section('title', 'Dasbor Ecozyne')

@section('content')
{{-- PERUBAHAN TAMBAHAN: Tambahkan p-0 m-0 dan pertahankan overflow-x: hidden --}}
<div class="container-fluid py-5 p-0 m-0" style="overflow-x: hidden;">
    <div style="position: absolute; top: -100px; right: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(16, 185, 129, 0.15) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>
    <div style="position: absolute; bottom: -150px; left: -150px; width: 500px; height: 500px; background: radial-gradient(circle, rgba(6, 182, 212, 0.1) 0%, transparent 70%); border-radius: 50%; pointer-events: none;"></div>

    <div class="row mb-5" style="position: relative; z-index: 1;">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1" style="color: #747070; font-size: 2rem;">Selamat datang, kelola platform Ecozyne</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3" style="position: relative; z-index: 1;">
        <div class="col-6 col-md-3 mb-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); backdrop-filter: blur(10px); transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                    <h6 class="card-title mb-2" style="font-size: 0.9rem; opacity: 0.9;">Total Pengguna</h6>
                    <h3 class="fw-bold mb-2" style="font-size: 2rem;">{{ $user_total }}</h3>
                    <small style="opacity: 0.8;">↑ {{ $user_this_month }} pengguna terdaftar bulan ini</small>
                </div>
            </div>
        </div>
        
    <div class="col-6 col-md-3 mb-4">
        <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden" style="background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); backdrop-filter: blur(10px); transition: all 0.3s ease;">
            <div class="card-body text-white p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-trash-alt fa-lg"></i>
                    </div>
                </div>
                <h6 class="card-title mb-2" style="font-size: 0.9rem; opacity: 0.9;">Pengajuan Bank Sampah</h6>
                <h3 class="fw-bold mb-2" style="font-size: 2rem;">{{ $waste_bank_submission_total }}</h3>
                <small style="opacity: 0.8;">↑ {{ $waste_bank_submission_this_month }} pengajuan bulan ini</small>
            </div>
        </div>
    </div>
        
        <div class="col-6 col-md-3 mb-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); backdrop-filter: blur(10px); transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-newspaper fa-lg"></i>
                        </div>
                    </div>
                    <h6 class="card-title mb-2" style="font-size: 0.9rem; opacity: 0.9;">Total Artikel</h6>
                    <h3 class="fw-bold mb-2" style="font-size: 2rem;">{{ $article_total }}</h3>
                    <small style="opacity: 0.8;">↑ {{ $article_this_month }} artikel baru bulan ini</small>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-md-3 mb-4">
            <div class="card border-0 shadow-lg rounded-4 h-100 overflow-hidden" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); backdrop-filter: blur(10px); transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div style="width: 50px; height: 50px; background: rgba(126, 76, 76, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                    </div>
                    <h6 class="card-title mb-2" style="font-size: 0.9rem; opacity: 0.9;">Kegiatan</h6>
                    <h3 class="fw-bold mb-2" style="font-size: 2rem;">{{ $activity_total }}</h3>
                    <small style="opacity: 0.8;">↑ {{ $activity_this_month }} kegiatan terdaftar bulan ini</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="position: relative; z-index: 1;">
        <div class="col-12 col-lg-8">
            {{-- PERUBAHAN: Background menjadi putih transparan, teks menjadi gelap --}}
            <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                    <h5 class="fw-bold mb-0" style="color: #2B3A55;">
                        <i class="fas fa-chart-bar me-2" style="color: #10b981;"></i>Setoran Bank Sampah Dalam 1 Bulan Terakhir
                    </h5>
                </div>
                <div class="card-body p-4">
                    <canvas id="bankSampahChart" height="120"></canvas>
                </div>
            </div>

            {{-- PERUBAHAN: Background menjadi putih transparan, teks menjadi gelap --}}
            <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                    <h5 class="fw-bold mb-0" style="color: #2B3A55;">
                        <i class="fas fa-users me-2" style="color: #06b6d4;"></i>Kelola Pengguna
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center p-4 rounded-3 h-100" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); transition: all 0.3s ease;">
                                <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                    <i class="fas fa-users-cog" style="color: #10b981; font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                                    <h6 class="fw-bold mb-1" style="color: #2B3A55;">Komunitas</h6>
                                    {{-- PERUBAHAN: Warna teks menjadi abu-abu (#6b7280) --}}
                                    <p class="mb-2 small" style="color: #6b7280;">{{ $community_total }} akun terdaftar</p>
                                    <a href="{{ route('community.list') }}" class="btn btn-sm rounded-pill px-3" style="background: #10b981; color: white; border: none; font-size: 0.85rem;">
                                        Kelola Akun
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-center p-4 rounded-3 h-100" style="background: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.2); transition: all 0.3s ease;">
                                <div style="width: 50px; height: 50px; background: rgba(6, 182, 212, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                    <i class="fas fa-trash-alt" style="color: #06b6d4; font-size: 1.5rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                                    <h6 class="fw-bold mb-1" style="color: #2B3A55;">Bank Sampah</h6>
                                    {{-- PERUBAHAN: Warna teks menjadi abu-abu (#6b7280) --}}
                                    <p class="mb-2 small" style="color: #6b7280;">{{ $waste_bank_total }} akun terdaftar</p>
                                    <a href="{{ route('waste_bank.list') }}" class="btn btn-sm rounded-pill px-3" style="background: #06b6d4; color: white; border: none; font-size: 0.85rem;">
                                        Kelola Akun
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PERUBAHAN: Background menjadi putih transparan, teks menjadi gelap --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                    <h5 class="fw-bold mb-0" style="color: #2B3A55;">
                        <i class="fas fa-newspaper me-2" style="color: #8b5cf6;"></i>Artikel Terbaru
                    </h5>
                    {{-- PERUBAHAN: Warna teks menjadi ungu gelap --}}
                    <a href="{{ route('article.list') }}" class="btn btn-sm rounded-pill px-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border: 1px solid rgba(15, 255, 55, 0.3); font-size: 0.85rem;"> 
                        Kelola Artikel
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach ($latest_article as $article)
                        <div class="col-12 col-md-4">
                            <div class="card border-0 rounded-3 overflow-hidden" style="height: 140px; cursor: pointer; transition: all 0.3s ease;">
                                <img 
                                    src="{{ asset('storage/' . $article->photo) }}" 
                                    alt="Gambar untuk {{ $article->title }}" 
                                    class="w-100 h-100 object-fit-cover"
                                    style="object-fit: cover;">
                            </div>
                            
                            {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                            <small class="d-block text-center mt-2 fw-semibold" style="color: #2B3A55;">{{ $article->title }}</small>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            {{-- PERUBAHAN: Background menjadi putih transparan, teks menjadi gelap --}}
            <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                    <h5 class="fw-bold mb-0" style="color: #2B3A55;">
                        <i class="fas fa-hands-helping me-2" style="color: rgba(16, 185, 129, 1);"></i>Kegiatan Terbaru
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="timeline">
                        @foreach($latest_activity as $activity)
                        <div class="timeline-item mb-4">
                            <div class="d-flex">
                                <div class="timeline-badge me-3" style="width: 40px; height: 40px; border-radius: 50%; background: rgba(16, 185, 129, 1); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-tree text-white"></i>
                                </div>
                                <div class="flex-grow-1">
                                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                                    <h6 class="fw-bold mb-1" style="color: #2B3A55;">{{ $activity->title }}</h6>
                                    {{-- PERUBAHAN: Warna teks menjadi abu-abu (#6b7280) --}}
                                    <p class="mb-2 small" style="color: #6b7280;">{{ $activity->created_at->format('d-m-Y') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="text-center mt-4"> 
                        <a href="{{ route('activity.list') }}" class="btn rounded-pill w-100" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border: none; font-weight: 500; padding: 0.75rem;">Kelola Kegiatan</a>
                    </div>
                </div>
            </div>

            {{-- PERUBAHAN: Background menjadi putih transparan, teks menjadi gelap --}}
            <div class="card border-0 shadow-lg rounded-4 mb-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                    <h5 class="fw-bold mb-0" style="color: #2B3A55;">
                        <i class="fas fa-gift me-2" style="color: #f59e0b;"></i>Katalog Hadiah
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($latest_reward as $reward)
                    <div class="reward-item mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div style="width: 45px; height: 45px; background: rgba(245, 158, 11, 0.2); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                    <i class="fas fa-gift" style="color: #f59e0b; font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                                    <h6 class="fw-bold mb-0" style="color: #2B3A55;">{{ $reward->reward_name }}</h6>
                                    {{-- PERUBAHAN: Warna teks menjadi abu-abu (#6b7280) --}}
                                    <small style="color: #6b7280;">{{ $reward->unit_point }} Poin</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-center">
                        <a href="{{ route('reward.list') }}" class="fw-bold text-decoration-none" style="color: #06b6d4; font-size: 0.85rem;">TAMPILKAN SELENGKAPNYA</a>
                    </div>
                </div>
            </div>

            {{-- PERUBAHAN: Background menjadi putih transparan, teks menjadi gelap --}}
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(10px); border: 1px solid rgba(0, 0, 0, 0.1);">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                    <h5 class="fw-bold mb-0" style="color: #2B3A55;">
                        <i class="fas fa-book-open me-2" style="color: #10b981;"></i>Komik Terbaru
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($latest_comic as $comic)
                    <div class="comic-item mb-3">
                        <div class="d-flex align-items-center">
                            <div style="width: 40px; height: 40px; background: rgba(16, 185, 129, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 1rem; flex-shrink: 0;">
                                <i class="fas fa-book" style="color: #10b981;"></i>
                            </div>
                            <div class="flex-grow-1">
                                {{-- PERUBAHAN: Warna teks menjadi gelap (#2B3A55) --}}
                                <h6 class="fw-bold mb-1" style="color: #2B3A55;">{{ $comic->comic_title }}</h6>
                                {{-- PERUBAHAN: Warna teks menjadi abu-abu (#6b7280) --}}
                                <small style="color: #6b7280;">{{ $comic->created_at->format('d-m-Y') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="text-center mt-3">
                        <a href="{{ route('comic.list') }}" class="fw-bold text-decoration-none" style="color: #06b6d4; font-size: 0.85rem;">TAMPILKAN SELENGKAPNYA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('bankSampahChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($labels), 
            datasets: [{
                label: 'Total Setoran (Kg)',
                data: @json($weights), 
                backgroundColor: [
                    'rgba(16, 185, 129, 0.9)',
                    'rgba(6, 182, 212, 0.9)',
                    'rgba(139, 92, 246, 0.9)',
                    'rgba(245, 158, 11, 0.9)',
                    'rgba(236, 72, 153, 0.9)'
                ],
                borderRadius: 10,
                barThickness: 35
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    // PERUBAHAN: Ubah warna tooltip agar cocok dengan background terang
                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                    titleColor: '#2B3A55',
                    bodyColor: '#6b7280',
                    borderColor: 'rgba(0, 0, 0, 0.1)',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    // PERUBAHAN: Ubah warna grid dan ticks untuk background terang
                    grid: { color: 'rgba(0, 0, 0, 0.1)' },
                    ticks: { color: '#6b7280', font: { size: 12 } }
                },
                x: {
                    // PERUBAHAN: Ubah warna ticks untuk background terang
                    grid: { display: false },
                    ticks: { color: '#6b7280', font: { size: 12 } }
                }
            }
        }
    });
});
</script>

<style>
    .timeline-item {
        position: relative;
    }

    .timeline-item:not(:last-child):after {
        content: '';
        position: absolute;
        left: 20px;
        top: 40px;
        bottom: -20px;
        width: 2px;
        /* PERUBAHAN: Warna garis timeline menjadi abu-abu terang */
        background-color: rgba(0, 0, 0, 0.1); 
    }

    .reward-item {
        padding: 12px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .reward-item:hover {
        /* PERUBAHAN: Warna hover menjadi abu-abu terang */
        background-color: rgba(0, 0, 0, 0.05); 
    }

    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        /* PERUBAHAN: Shadow disesuaikan untuk background terang */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important; 
    }

    /* Smooth scrollbar styling */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05); /* Disesuaikan untuk terang */
    }

    ::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.2); /* Disesuaikan untuk terang */
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: rgba(0, 0, 0, 0.4); /* Disesuaikan untuk terang */
    }
</style>
@endsection
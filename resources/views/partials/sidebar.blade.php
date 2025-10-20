<div class="border-end bg-white shadow-sm" id="sidebar-wrapper">
  <div class="sidebar-heading p-3 text-start fw-bold fs-5 border-bottom d-flex align-items-center">
    <img src="{{ asset('images/ecozyne_logo.png') }}" alt="Logo" style="height: 40px;" class="me-2"> Ecozyne
  </div>

  <div class="list-group list-group-flush pt-2">
    <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }} list-group-item list-group-item-action border-0 py-3"><i class="fas fa-home me-2"></i> Dashboard</a>
    <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-exchange-alt me-2"></i> Tukar Poin</a>
    <a href="#submenu-pengguna" data-bs-toggle="collapse" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-users me-2"></i> Pengguna</a>
      <div class="collapse list-group-item border-0 py-0" id="submenu-pengguna">
          <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-users-cog me-2"></i> Komunitas</a>
          <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-trash-alt me-2"></i> Bank Sampah</a>
      </div>
    <a href="{{ route('article.list') }}" class="{{ Route::is('article.list', 'article.create', 'article.show', 'article.edit') ? 'active' : '' }} list-group-item list-group-item-action border-0 py-3">
      <i class="fas fa-chart-bar me-2"></i> Artikel
    </a>
    <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-hands-helping me-2"></i> Kegiatan Sosial</a>
    <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-video me-2"></i> Video</a>
    <a href="#" class="list-group-item list-group-item-action border-0 py-3"><i class="fas fa-book-open me-2"></i> Komik</a>
    <a href="{{ route('reward.list') }}" class="{{ Route::is('reward.list', 'reward.create', 'reward.show', 'reward.edit') ? 'active' : '' }} list-group-item list-group-item-action border-0 py-3"><i class="fas fa-gift me-2"></i> Katalog Hadiah</a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="list-group-item list-group-item-action border-0 py-3" style="color: red;"><i class="fas fa-arrow-left me-2"></i> Logout</button>
    </form>
  </div>
</div>

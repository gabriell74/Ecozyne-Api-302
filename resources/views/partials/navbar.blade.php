<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-4 sticky-top">
  <div class="container-fluid">

    {{-- Tombol toggle sidebar (untuk layar kecil) --}}
    <button class="btn btn-outline-secondary d-lg-none me-3" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </button>

    <h5 class="mb-0 fw-bold">@yield('header','Dashbor Ecozyne')</h5>

    {{-- Toggle Navbar di mobile --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
      <a href="{{ route('admin.profile') }}" class="text-secondary me-3 my-auto d-none d-lg-block text-decoration-none" title="Profil Admin">
        <i class="fas fa-user-circle fa-2xl"></i> Kelola Profil 
      </a>
    </div>
  </div>
</nav>
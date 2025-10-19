<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm py-3 sticky-top">
  <div class="container-fluid">

    {{-- Tombol toggle sidebar (untuk layar kecil) --}}
    <button class="btn btn-outline-secondary d-lg-none me-3" id="menu-toggle">
      <i class="fas fa-bars"></i>
    </button>

    <h5 class="mb-0 fw-bold">@yield('header','Dasbor')</h5>

    {{-- Toggle Navbar di mobile --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarMenu">
      <form class="d-flex me-3 my-2 my-lg-0" style="max-width: 250px;">
        <div class="input-group">
          <input type="text" class="form-control rounded-pill-start border-end-0" placeholder="Search">
          <span class="input-group-text bg-transparent border-start-0 rounded-pill-end"><i class="fas fa-search"></i></span>
        </div>
      </form>

      <a href="#" class="text-secondary me-3 my-auto"><i class="fas fa-bell fa-lg"></i></a>
      <img src="{{ asset('user-placeholder.png') }}" class="rounded-circle" alt="User" style="width: 40px; height: 40px; cursor: pointer;">
    </div>
  </div>
</nav>

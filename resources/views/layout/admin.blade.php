<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dasbor Admin')</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">

  {{-- Overlay hitam untuk layar kecil --}}
  <div id="sidebar-overlay" class="sidebar-overlay"></div>

  <div class="d-flex" id="wrapper">
    @include('partials.sidebar')

    <div id="page-content-wrapper" class="flex-grow-1">
      @include('partials.navbar')

      <div class="container-fluid p-4">
        @yield('content')
      </div>
    </div>
  </div>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Sidebar Toggle Script --}}
  <script>
    const toggleBtn = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar-wrapper');
    const overlay = document.getElementById('sidebar-overlay');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('active');
      overlay.classList.toggle('active');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.remove('active');
      overlay.classList.remove('active');
    });
  </script>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Ecozyne - @yield('title', 'Admin Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
          rel="stylesheet" 
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
          crossorigin="anonymous">
    
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
          integrity="sha512-SnH5r+zR8Fh/E+6X/7lGzFqLz8oYVp3rJgD/zD7jR1PqB4O7fF+QvA9E5k5aG9i2Lw==" 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer" />
          
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    @yield('styles')

</head>
<body>
    
    <div class="d-flex" style="min-height: 100vh;">
        
        @include('partials.sidebar') 
        
        <div class="flex-grow-1">
            @yield('content')
        </div>
        
    </div>
    
    </body>
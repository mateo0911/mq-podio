<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MQ Podio - Sistema de Premios')</title>

    {{-- Bootstrap 5.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FontAwesome 6 --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    {{-- DataTables Bootstrap 5 --}}
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{-- Animate.css --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <link href="{{ asset('css/podio.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <i class="fa-solid fa-trophy trophy-icon me-2"></i>
                <span class="brand-text">MQ Podio</span>
                <span class="brand-sub ms-2 d-none d-sm-inline">Sistema de Premios</span>
            </a>
            <div class="navbar-text text-light d-flex align-items-center">
                <i class="fa-solid fa-star me-1 star-pulse"></i>
                <span class="d-none d-md-inline">Reconocimiento al Desempeño</span>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer-custom text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0 text-muted">
                <i class="fa-solid fa-heart text-danger"></i>
                MQ Podio &copy; {{ date('Y') }} — Reconociendo la excelencia
            </p>
        </div>
    </footer>

    
    {{-- jQuery 3.7 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Bootstrap 5.3 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Custom JS --}}
    <script src="{{ asset('js/podio.js') }}"></script>

    @stack('scripts')
</body>
</html>

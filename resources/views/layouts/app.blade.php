<!DOCTYPE html>
<html lang="hr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Moja aplikacija')</title>

    {{-- ===== CSS (vendor first) ===== --}}
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Select2 + Bootstrap 5 theme --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">

    {{-- Tempus Dominus (datetime picker) --}}

    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.16/dist/css/tempus-dominus.min.css">

    {{-- Bootstrap Icons (optional, for calendar icon) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css"
        rel="stylesheet">

    {{-- Custom CSS for dropend submenus --}}
    <style>
        .dropend:hover .dropdown-menu {
            display: block;
            position: absolute;
            top: 0;
            left: 100%;
            margin: 0;
        }
        
        .dropend .dropdown-menu {
            display: none;
        }
        
        /* Ensure submenu appears on the right side */
        .dropend .dropdown-toggle::after {
            border-left: 0.3em solid;
            border-right: 0;
            border-bottom: 0.3em solid transparent;
            border-top: 0.3em solid transparent;
        }
    </style>

    {{-- Page-specific styles (after vendor to allow overrides) --}}
    @stack('styles')

    {{-- CSRF for AJAX --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

  
</head>

<body class="bg-light">
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Mala jedva vidljijva promjena kad sam majmun</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Početna</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link p-0">Odjava</button>
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/prijava') }}">Prijava</a>
                    </li>
                    @endauth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Oglasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ url('/jobpostings') }}">Popis oglasa</a></li>
                            <li><a class="dropdown-item" href="{{ url('/jobpostings/create') }}">Postavi oglas</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        Administracija
    </a>
    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
        <li><a class="dropdown-item" href="{{ route('employees.index') }}">Zaposlenici</a></li>
        <li><a class="dropdown-item" href="{{ route('organizational-units.index') }}">Organizacijske
                jedinice</a></li>
        <li><a class="dropdown-item" href="{{ route('educations.index') }}">Edukacije</a></li>
        <li><a class="dropdown-item" href="{{ route('job-positions.index') }}">Radna mjesta</a></li>
        
        <!-- Submenu: Plan zapošljavanja -->
        <li class="dropend">
            <a class="dropdown-item dropdown-toggle" href="#" id="planDropdown" role="button" aria-expanded="false">
                Plan zapošljavanja
            </a>
            <ul class="dropdown-menu" aria-labelledby="planDropdown">
                <li><a class="dropdown-item" href="{{ url('/hiring-plans') }}">Popis planova</a></li>
                <li><a class="dropdown-item" href="{{ url('/hiring-plans/create') }}">Novi plan</a></li>
            </ul>
        </li>
    </ul>
</li>
            </div>
        </div>
    </nav>

    {{-- Glavni sadržaj --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-5">
        &copy; {{ date('Y') }} Moja aplikacija
    </footer>

    {{-- ===== JS (vendor libs first, then Livewire, then page scripts) ===== --}}
    {{-- jQuery (required by Select2) --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>

    {{-- Select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/hr.js"></script>

    {{-- Popper UMD (required by both Bootstrap and Tempus Dominus) --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    {{-- Bootstrap 5 (no bundle; Popper loaded above) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    {{-- Tempus Dominus --}}
    
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.7.16/dist/js/tempus-dominus.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    {{-- Livewire JS --}}
    

    {{-- Page-specific scripts (can rely on all vendor libs above) --}}
    @stack('scripts')
</body>

</html>
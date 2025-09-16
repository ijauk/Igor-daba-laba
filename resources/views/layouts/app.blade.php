<!DOCTYPE html>
<html lang="hr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'Moja aplikacija')</title>

        {{-- Bootstrap CSS (CDN) --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

        {{-- Dodatni CSS --}}
        @stack('styles')

        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Livewire CSS --}}
        @livewireStyles
    </head>

    <body class="bg-light">
        {{-- Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">Moja Aplikacija</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            {{-- mala napomena: url() ne treba named argument "path:", dovoljno je url('/') --}}
                            <a class="nav-link" href="{{ url('/') }}">Početna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/prijava') }}">Prijava</a>
                        </li>
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
                    </ul>
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

        {{-- Bootstrap JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        {{-- Livewire JS --}}
        @livewireScripts
        <script>
            document.addEventListener('livewire:init', () => {
                console.log('✅ Livewire init OK');
            });
        </script>
        {{-- Učitaj Alpine tek nakon što Livewire najavi da je spreman --}}
        <script>
            window.deferLoadingAlpine = (callback) => {
                // ako Livewire već postoji i tek će emitirati event:
                document.addEventListener('livewire:init', callback);
            }
        </script>
        <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
        @stack('scripts')
    </body>

</html>
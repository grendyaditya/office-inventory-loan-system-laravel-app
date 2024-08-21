<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Barang</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
        .hero-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        .hero-section svg {
            margin-bottom: 20px;
        }
        .hero-section p {
            font-size: 1.2rem;
            color: #6c757d;
        }
        .navbar-custom {
            background-color: #343a40;
        }
        .navbar-custom a {
            color: #ffffff;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="navbar navbar-expand-lg navbar-custom navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Peminjaman Barang</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/home') }}">Home</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section text-center">
        <div class="container">
            <svg viewBox="0 0 651 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-16 w-auto text-danger">
                <g clip-path="url(#clip0)" fill="#EF3B2D">
                    <!-- SVG Paths here -->
                    
                </g>
            </svg>
            <p>
                CV SIAP INTEGRASI<br>
                Menyediakan solusi IT terbaik untuk kebutuhan bisnis Anda
            </p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1040;
            border-bottom: 1px solid #dee2e6;
            background-color: #fff;
        }

        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 220px;
            height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding: 1rem;
            overflow-y: auto;
        }

        .sidebar h5 {
            font-weight: bold;
            text-align: center;
        }

        .sidebar a {
            display: block;
            padding: 8px 12px;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 5px;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .main-content {
            margin-left: 220px;
            padding: 80px 2rem 2rem 2rem;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-md shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            {{ Auth::user()->nombre ?? Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        </div>
                    </li>
                    {{-- Ícono de campana con badge --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notificacionesDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i>
                            @if(session('notificaciones_count') > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ session('notificaciones_count') }}
                            </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificacionesDropdown">
                            @foreach(session('notificaciones') ?? [] as $notificacion)
                            <li><a class="dropdown-item">{{ $notificacion }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Sidebar --}}
    @auth
    <div class="sidebar">
        @if(auth()->user()->perfil_id == 1)
        <h5>Mantenedores</h5>
        <a href="{{ route('problemas.index') }}">🛠 Problemas</a>
        <a href="{{ route('clientes.index') }}">👤 Clientes</a>
        <a href="{{ route('usuarios.index') }}">🧑‍💼 Usuarios</a>
        <a href="{{ route('perfiles.index') }}">🛡 Perfiles</a>
        <hr>
        @else
        <h5>Opciones</h5>
        <a href="{{ route('tickets.asignados') }}">🎫 Tickets Asignados</a>
        <a href="{{ route('tickets.creados') }}">📝 Tickets Creados</a>
        <a href="{{ route('tickets.index') }}">📋 Todos los Tickets</a>
        <a href="{{ route('clientes.index') }}">👤 Clientes</a>
        <hr>
        @endif

    </div>
    @endauth

    {{-- Main Content --}}
    <div class="main-content">
        @yield('content')
    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>
{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Orçamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('projetos.index') }}">
                <i class="fas fa-hard-hat"></i> Sistema de Orçamentos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('projetos.index') }}">
                                <i class="fas fa-folder"></i> Meus Projetos
                            </a>
                        </li>
                        
                        {{-- Menu Admin (apenas para usuários admin) --}}
                        @if(Auth::user()->type == 'admin')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-cog"></i> Admin
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('admin.estrutura.index') }}">
                                    <i class="fas fa-sitemap"></i> Estrutura
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.estrutura.modulos') }}">
                                    <i class="fas fa-layer-group"></i> Módulos
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.estrutura.capitulos') }}">
                                    <i class="fas fa-book"></i> Capítulos
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.estrutura.actividades') }}">
                                    <i class="fas fa-tasks"></i> Actividades
                                </a>
                                <a class="dropdown-item" href="{{ route('admin.estrutura.grupos') }}">
                                    <i class="fas fa-layer-group"></i> Grupos
                                </a>
                                {{-- CORREÇÃO: Usar a rota correta de componentes --}}
                                <a class="dropdown-item" href="{{ route('admin.estrutura.componentes.todos') }}">
                                    <i class="fas fa-cube"></i> Componentes
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('users.list') }}">
                                    <i class="fas fa-users"></i> Usuários
                                </a>
                            </div>
                        </li>
                        @endif
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Sair
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>
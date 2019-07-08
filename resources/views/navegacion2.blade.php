<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background:black">
    <a class="navbar-brand font-weight-bold" href="{{asset('/')}}">
        @foreach ($logoEmpresa as $item)
        <img src="/img/perfiles/{{$item->logo_empresa}}" height="50" class="d-inline-block align-top" alt="">
        <span style="font-size:1.2rem;">{{$item->nombre_corto}}</span>
        @endforeach
    </a>
    <button class="navbar-toggler text-white btn btn-outline-info" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars fa-2x"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">

        </ul>
        <div class="top-right links text-center">
            <!-- validar auth sesion -->
            @if(Auth::check())<!-- si esta autenticado el usuario actual-->
                @if(Auth::user()->roles_roles_id == 3)<!-- si es cliente-->
                    <ul class="navbar-nav text-center">
                        <li class="nav-item">
                            <a href="{{ url('/miSolicitud') }}" class="btn btn-primary mb-1 mr-sm-1"><i class="far fa-calendar-alt"></i> Mis Citas</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/nuevaCita') }}" class="btn btn-success mb-1 mr-sm-1"><i class="fas fa-plus"></i> Nueva Cita</a>
                        </li>

                        <div class="nav-item dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle mb-1 mr-sm-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Auth::user()->nombre_usuario }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default">
                                <a class="dropdown-item text-primary" href="{{ route('miPerfil') }}"><i class="fas fa-id-card"></i> Mi Perfil</a>
                                <a class="dropdown-item text-success" href="{{ url('/') }}"><i class="fas fa-home"></i> Página Web</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </ul>
                @elseif(Auth::user()->roles_roles_id == 2)<!-- si es Empleado-->
                    <ul class="navbar-nav text-center">
                        <div class="nav-item dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle mb-1 mr-sm-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Auth::user()->nombre_usuario }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default">
                                <a class="dropdown-item text-primary" href="/admin#/miAgenda"><i class="fas fa-id-card"></i> Mi Panel</a>
                                <a class="dropdown-item text-success" href="{{ url('/') }}"><i class="fas fa-home"></i> Página Web</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </ul>
                @elseif(Auth::user()->roles_roles_id == 4)<!-- si es Agendador-->
                    <ul class="navbar-nav text-center">
                        <div class="nav-item dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle mb-1 mr-sm-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Auth::user()->nombre_usuario }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default">
                                <a class="dropdown-item text-primary" href="{{ route('admin') }}"><i class="fas fa-id-card"></i> Mi Panel</a>
                                <a class="dropdown-item text-success" href="{{ url('/') }}"><i class="fas fa-home"></i> Página Web</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </ul>
                @else
                    <ul class="navbar-nav text-center">
                        <div class="nav-item dropdown">
                            <button type="button" class="btn btn-primary dropdown-toggle mb-1 mr-sm-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i> {{ Auth::user()->nombre_usuario }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right dropdown-default">
                                <a class="dropdown-item text-primary" href="{{ route('admin') }}"><i class="fas fa-id-card"></i> Mi Panel</a>
                                <a class="dropdown-item text-success" href="{{ url('/') }}"><i class="fas fa-home"></i> Página Web</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </ul>
                @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-sign-in-alt"></i> Ingresar</a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-danger"><i class="fas fa-plus-circle"></i> Registrarme</a>
                    @endif
            @endif
        </div>
    </div>
</nav>

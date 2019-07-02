<section class="menu cid-qTkzRZLJNu" once="menu" id="menu1-8">
    <nav class="navbar navbar-expand beta-menu navbar-dropdown align-items-center navbar-fixed-top navbar-toggleable-sm" style="background:black">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </button>
        <div class="menu-logo">
            <div class="navbar-brand">
                @foreach ($logoEmpresa as $item)
                <span class="navbar-logo">
                    <a href="{{asset('/')}}">
                        <img src="/img/perfiles/{{$item->logo_empresa}}" title="" style="height: 3.8rem;">
                    </a>
                </span>
                <span class="navbar-caption-wrap"><a class="navbar-caption text-white display-4" href="">{{$item->nombre_corto}}</a></span>
                @endforeach
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navbar-buttons mbr-section-btn">
                <!-- validar auth sesion -->
                @if(Auth::check())<!-- si esta autenticado el usuario actual-->
                    @if(Auth::user()->roles_roles_id == 3)<!-- si es cliente-->
                        <a class="btn btn-sm btn-primary display-4" href="{{ url('/miSolicitud') }}">
                            <span class="mobi-mbri mobi-mbri-calendar mbr-iconfont mbr-iconfont-btn"></span>Mis Citas<br>
                        </a>
                        <a class="btn btn-sm btn-secondary display-4" href="{{ url('/nuevaCita') }}">
                            <span class="mobi-mbri mobi-mbri-plus mbr-iconfont mbr-iconfont-btn"></span>Nueva Cita<br>
                        </a>

                        <span><i class="fas fa-user"></i> {{ Auth::user()->nombre_usuario }}</span>

                        <a class="btn btn-sm btn-warning display-4" href="{{ route('miPerfil') }}">
                            <span class="mbri-user mbr-iconfont mbr-iconfont-btn"></span>{{ Auth::user()->nombre_usuario }}<br>
                        </a>
                        <a class="btn btn-sm btn-info display-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <span class="mbri-logout mbr-iconfont mbr-iconfont-btn"></span>Cerrar Sesión<br>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    @elseif(Auth::user()->roles_roles_id == 2)<!-- si es empleado-->
                        <span class="navbar-caption-wrap"><a class="navbar-caption text-white display-4">
                            <i class="far fa-user"></i> {{ Auth::user()->nombre_usuario }}</a>
                        </span>

                        <a class="btn btn-sm btn-primary display-4" href="/admin#/miAgenda">
                            <span class="mbri-setting mbr-iconfont mbr-iconfont-btn"></span>Mi Panel<br>
                        </a>
                        <a class="btn btn-sm btn-info display-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <span class="mbri-logout mbr-iconfont mbr-iconfont-btn"></span>Cerrar Sesión<br>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    @elseif(Auth::user()->roles_roles_id == 4)<!-- si es agendador-->
                        <span class="navbar-caption-wrap"><a class="navbar-caption text-white display-4">
                            <i class="far fa-user"></i> {{ Auth::user()->nombre_usuario }}</a>
                        </span>

                        <a class="btn btn-sm btn-primary display-4" href="{{ route('admin') }}">
                            <span class="mbri-setting mbr-iconfont mbr-iconfont-btn"></span>Mi Panel<br>
                        </a>
                        <a class="btn btn-sm btn-info display-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <span class="mbri-logout mbr-iconfont mbr-iconfont-btn"></span>Cerrar Sesión<br>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    @else
                        <span class="navbar-caption-wrap"><a class="navbar-caption text-white display-4">
                            <i class="far fa-user"></i> {{ Auth::user()->nombre_usuario }}</a>
                        </span>

                        <a class="btn btn-sm btn-primary display-4" href="{{ route('admin') }}">
                            <span class="mbri-setting mbr-iconfont mbr-iconfont-btn"></span>Mi Panel<br>
                        </a>
                        <a class="btn btn-sm btn-info display-4" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <span class="mbri-logout mbr-iconfont mbr-iconfont-btn"></span>Cerrar Sesión<br>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    @endif
                    @else
                        <a class="btn btn-sm btn-primary display-4" href="{{ route('login') }}">
                            <span class="mbri-login mbr-iconfont mbr-iconfont-btn"></span>Ingresar<br>
                        </a>
                    @if (Route::has('register'))
                        <a class="btn btn-sm btn-info display-4" href="{{ route('register') }}">
                            <span class="mbri-sites mbr-iconfont mbr-iconfont-btn"></span>Registrarme
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </nav>
</section>

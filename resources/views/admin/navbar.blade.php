<header class="main-header">
    <!-- Logo -->
    @if(Auth::check())<!-- si esta autenticado el usuario actual-->
        @if(Auth::user()->roles_roles_id == 1)<!-- si es cliente-->
            <a href="{{ asset('/admin') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>M</b>PL</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>{{ config('app.name')}}</span>
            </a>
        @else
            <router-link to="/miAgenda" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>M</b>PL</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>{{ config('app.name')}}</span>
            </router-link>
        @endif
    @endif

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">

        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="far fa-bell"></i>
                    <span class="label label-warning">10</span>
                    </a>
                    <ul class="dropdown-menu">
                    <li class="header text-center"><b>Tienes # Solicitudes</b></li>
                    <li>
                        <ul class="menu">
                            <li>
                                <a href="#">
                                <i class="fa fa-bell text-aqua" aria-hidden="true"></i> 5 new members joined today
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="footer"><a href="#">Ver todas</a></li>
                    </ul>
                </li>-->
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="/img/perfiles/{{ auth()->user()->imagen }}" class="user-image" alt="User Image">
                    <span class="hidden-xs">{{ Auth::user()->nombre_usuario }}</span>
                    </a>
                    <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="/img/perfiles/{{ auth()->user()->imagen }}" class="img-circle" alt="User Image">

                        <p>
                            {{ Auth::user()->nombre_usuario}} {{ Auth::user()->apellido_usuario}}
                        <small>{{ Auth::user()->email}}</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <a href="{{asset('/')}}" type="button" class="btn btn-info"><i class="fa fa-home" aria-hidden="true"></i> Mi Página</a>
                            </div>
                        </div>
                        <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <router-link to="/miperfil" class="btn btn-default alert-success"><i class="fa fa-address-card" aria-hidden="true"></i> Mi Perfil</router-link>
                        </div>
                        <div class="pull-right">
                            <a href="{{ route('logout') }}" class="btn btn-default alert-danger" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

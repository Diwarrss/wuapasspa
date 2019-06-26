<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Mayra Peluqueria sitio web para solicitar mi Cita para ser atendido." />
        <meta name="keywords" content="Mayra Peluqueria, San Gil, Agendar, Pagina Web" />

        <title>{{ config('app.name', 'Mayra Peluqueria') }}</title>

        <!--importamos todos los css generados con webpack-->
        <link type="text/css" rel="stylesheet" href="{{asset('css/miWelcome.css')}}"/>
        <!-- Para que sea Full PWA -->
        @laravelPWA
    </head>
    <body>

        {{-- Iniciamos el For para mostrar la informacion de la empresa --}}
        <div id="app" class="py-4">
            @include('navegacion')
            <main>
                {{-- seccion del carousel --}}
                <section class="carousel slide cid-ru615axhXJ" data-interval="false" id="slider2-x" style="background-image: linear-gradient(to bottom, #9937ae, #843eae, #6e43ad, #5846a9, #4148a4, #3e49a6, #3b49a8, #374aaa, #4b4ab4, #604abd, #7548c5, #8a44cb); background-repeat: no-repeat; background-attachment: fixed;">
                    @if ($errors->has('sugerencia'))
                        <div class="container">
                            <div class="alert alert-info alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $errors->first('sugerencia') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    @if(Session::has('success'))
                        <div class="container">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Bien!</strong> {{ Session::get('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="container content-slider">
                        <div class="content-slider-wrap">
                            <div>
                                <div class="mbr-slider slide carousel" data-pause="true" data-keyboard="false" data-ride="carousel" data-interval="3000">

                                    <div class="carousel-inner" role="listbox">
                                        @foreach ($imagenes as $item)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <img src="img/carousel/{{$item->url_imagen}}" class="card-img-top img-responsive" alt="img/carousel/{{$item->url_imagen}}" >
                                        </div>
                                        @endforeach
                                    </div>
                                    <a data-app-prevent-settings="" class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#slider2-x">
                                        <span aria-hidden="true" class="mbri-left mbr-iconfont"></span><span class="sr-only">Previous</span>
                                    </a>
                                    <a data-app-prevent-settings="" class="carousel-control carousel-control-next" role="button" data-slide="next" href="#slider2-x">
                                        <span aria-hidden="true" class="mbri-right mbr-iconfont"></span><span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="mbr-section content8 cid-ru63RlTe41" id="content8-z" style="background-image: linear-gradient(to bottom, #9937ae, #843eae, #6e43ad, #5846a9, #4148a4, #3e49a6, #3b49a8, #374aaa, #4b4ab4, #604abd, #7548c5, #8a44cb); background-repeat: no-repeat; background-attachment: fixed;">
                    <div class="container">
                        <div class="media-container-row title">
                            <div class="col-12 col-md-8">
                                <div class="mbr-section-btn align-center">
                                    <a class="btn btn-primary display-7" href="/nuevaCita">
                                        <span class="mbri-edit mbr-iconfont mbr-iconfont-btn"></span> ¡Agenda Tu Cita Ahora!
                                    </a>
                                </div>
                                {{--<div class="mbr-section-btn align-center d-none d-sm-none d-md-block">
                                    <button onclick="install()" class="btn btn-primary display-7 align-center">
                                        Añadir al Escritorio
                                    </button>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </section>
                {{-- seccion de los servicios --}}
                <section class="services3 cid-ru624clkax mbr-parallax-background" id="services3-y" style="z-index: 0; background-image: url('img/carousel/facebook_imagen.jpg'); position: relative;">
                    <!---->

                    <!---->
                    <!--Overlay-->
                    <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(206, 191, 175);">
                    </div>
                    <!--Container-->
                    <div class="container">
                        <div class="row">
                            <!--Titles-->
                            <div class="title pb-5 col-12">
                                <h2 class="align-left mbr-fonts-style display-2"><strong>
                                    <i class="fas fa-list-ul"></i> Servicios</strong></h2>
                            </div>
                            <!--Card-1-->
                            @foreach ($servicios as $item)
                            <div class="card px-3 col-12 col-md-6">
                                <div class="card-wrapper media-container-row media-container-row">
                                    <div class="card-box">
                                        <div class="top-line pb-1">
                                            <h4 class="card-title mbr-fonts-style display-5">
                                                <img class="img-responsive" src="/img/logo/belleza.png" width="" height="45"> {{$item->nombre_servicio}}
                                            </h4>
                                            <p class="mbr-text card-title cost mbr-fonts-style m-0 display-4"></p>
                                        </div>
                                        <div class="bottom-line">
                                            <p class="mbr-text mbr-fonts-style display-7">
                                                {{$item->descripcion_servicio}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="mbr-section form1 cid-ru64LmyPnK mbr-parallax-background" id="form1-12" style="z-index: 0; background-image: url('img/carousel/_LCP1445-min.JPG'); position: relative;">
                    <div class="mbr-overlay" style="opacity: 0.9; background-color: rgb(193, 193, 193);">
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="title col-12 col-lg-8">
                                <h2 class="mbr-section-title align-center pb-3 mbr-fonts-style display-2">
                                    <i class="far fa-bell"></i><strong> Envia tu sugerencia </strong></h2>
                                <h3 class="mbr-section-subtitle align-center mbr-light pb-3 mbr-fonts-style display-5">
                                    Tu opinión nos ayudará a mejorar nuestros servicios.</h3>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="media-container-column col-lg-8">
                                <!---Formbuilder Form--->
                                <form method="POST" action="{{ url('/enviarSugerencia') }}" class="mbr-form form-with-styler" data-form-title="Mobirise Form">
                                    {{ csrf_field() }}
                                    <div class="dragArea row">
                                        <div data-for="message" class="col-md-12 form-group">
                                            <label for="message-form1-12" class="form-control-label mbr-fonts-style display-7"></label>
                                            <textarea name="sugerencia" id="sugerencia" data-form-field="Message" class="form-control display-7" placeholder="Escribir sugerencia" id="message-form1-12"></textarea>
                                        </div>
                                        <div class="col-md-12 input-group-btn align-center">
                                            <button type="submit" class="btn btn-form btn-warning display-4">
                                                <span class="mbri-paper-plane mbr-iconfont mbr-iconfont-btn"></span>Enviar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="mbr-section contacts3 cid-ru65QYf5WR" id="contacts3-13">

                    <!--Container-->
                    <div class="container">
                        @foreach ($miEmpresa as $item)
                        <div class="row">
                            <!--Titles-->
                            <div class="title col-12">
                                <h2 class="align-left mbr-fonts-style display-2"><strong>
                                    <i class="far fa-address-card"></i> Contacto</strong></h2>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="wrapper">
                                            <span class="iconfont-wrapper">
                                                <span class="amp-iconfont icon fa-thumbs-o-up fa"></span>
                                            </span>
                                            <div class="b-info b-adress">
                                                <h5 class="align-left mbr-fonts-style display-5">
                                                    <i class="fas fa-map-marker-alt"></i> Dirección:
                                                </h5>
                                                    <p class="mbr-text align-left mbr-fonts-style display-7">
                                                        {{$item->direccion_empresa}}
                                                    </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="wrapper">
                                            <span class="iconfont-wrapper">
                                                <span class="amp-iconfont icon fa-phone fa"></span>
                                            </span>
                                            <div class="b-info b-phone">
                                                <h5 class="align-left mbr-fonts-style display-5">
                                                    Celular:</h5>
                                                <p class="mbr-text align-left mbr-fonts-style display-7">
                                                    <i class="fas fa-phone"></i> {{$item->telefono_empresa}} <br>
                                                    <a target="_blank" href="https://api.whatsapp.com/send?phone=57{{$item->celular_empresa}}&text=Hola, quiero conocer mas información de {{$item->nombre_empresa}}.">
                                                        <i class="fab fa-whatsapp text-green"></i> WhatsApp, {{$item->celular_empresa}}
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="wrapper">
                                            <span class="iconfont-wrapper">
                                                <span class="amp-iconfont icon fa-comment-o fa"></span>
                                            </span>
                                            <div class="b-info b-mail">
                                                <h5 class="align-left mbr-fonts-style display-5">
                                                    <i class="far fa-envelope"></i> E-mail:
                                                </h5>
                                                <p class="mbr-text align-left mbr-fonts-style display-7">
                                                    <a href = "mailto:{{$item->correo_empresa}}">{{$item->correo_empresa}}</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="wrapper">
                                            <span class="iconfont-wrapper">
                                                <span class="amp-iconfont icon fa-th-large fa"></span>
                                            </span>
                                            <div class="b-info b-mail">
                                                <h5 class="align-left mbr-fonts-style display-5">
                                                    Horario de Atención:</h5>
                                                <p class="mbr-text align-left mbr-fonts-style display-7">
                                                    8:00 am - 7:00 pm
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <section class="cid-rua54tdUv9" id="social-buttons3-17">
                            <div class="container">
                                <div class="media-container-row">
                                    <div class="col-md-8 align-center">
                                        <div>
                                            <div class="mbr-social-likes social-likes social-likes_visible social-likes_ready">
                                                <a target="_blank" class="btn btn-social" title="Facebook" href="{{$item->facebook_empresa}}">
                                                    <i class="fab fa-facebook"></i>
                                                </a>
                                                <a target="_blank" class="btn btn-social" title="Instagram" href="{{$item->instagram_empresa}}">
                                                    <i class="fab fa-instagram"></i>
                                                </a>
                                                <a target="_blank" class="btn btn-social" title="WhatsApp" href="https://api.whatsapp.com/send?phone=57{{$item->celular_empresa}}&text=Hola, quiero conocer mas información de {{$item->nombre_empresa}}.">
                                                    <i class="fab fa-whatsapp"></i>
                                                </a>
                                                <a target="_blank" class="btn btn-social" title="Mi Pagina" href="{{$item->urlweb_empresa}}">
                                                    <i class="fab fa-chrome"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="align-center">
                                    Copyright © <a href="https://www.gridsoft.co/" target="_blank">GridSoft</a>
                                </div>
                            </div>
                        </section>
                        @endforeach
                    </div>
                </section>
            </main>
        </div>
        <!--Importando todos los Js del webpack vue y boostrap-->
        <script src="{{asset('js/miWelcome.js')}}"></script>
        <script src="{{asset('js/appCliente.js')}}"></script>
        <!-- Script para preguntar si quiere instalar el sistema como PWA en PC -->
        <script>
            /*let deferredPrompt = null;

            window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent Chrome 67 and earlier from automatically showing the prompt
            e.preventDefault();
            // Stash the event so it can be triggered later.
            deferredPrompt = e;
            });

            async function install() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                console.log(deferredPrompt)
                deferredPrompt.userChoice.then(function(choiceResult){

                if (choiceResult.outcome === 'accepted') {
                console.log('Your PWA has been installed');
                } else {
                console.log('User chose to not install your PWA');
                }

                deferredPrompt = null;

                });


            }
            }*/
        </script>
    </body>
</html>

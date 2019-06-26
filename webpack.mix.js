const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//para el js de bootstrap 4.3.1 y vuejs, etc cliente
mix.js(['resources/js/appCliente.js'
   ],'public/js/appCliente.js')

//Creamos el js de nosotros mismos
.scripts([
   'public/assets/web/assets/jquery/jquery.min.js',//version 3.3.1
   'public/assets/popper/popper.min.js',
   'public/assets/tether/tether.min.js',
   'public/assets/bootstrap/js/bootstrap.min.js',
   'public/assets/dropdown/js/nav-dropdown.js',
   'public/assets/dropdown/js/navbar-dropdown.js',
   'public/assets/touchswipe/jquery.touch-swipe.min.js',//version 3.3.1
   'public/assets/ytplayer/jquery.mb.ytplayer.min.js',
   'public/assets/vimeoplayer/jquery.mb.vimeo_player.js',
   'public/assets/smoothscroll/smooth-scroll.js',
   'public/assets/bootstrapcarouselswipe/bootstrap-carousel-swipe.js',
   'public/assets/parallax/jarallax.min.js',
   'public/assets/theme/js/script.js',//version 3.3.1
   'public/assets/slidervideo/script.js',
   'public/assets/formoid/formoid.min.js'
], 'public/js/miWelcome.js')

//Creamos el css modificado de boostrap 4 para cliente
.styles([
   'public/assets/web/assets/mobirise-icons2/mobirise2.css',
   'public/assets/web/assets/mobirise-icons/mobirise-icons.css',
   'public/assets/tether/tether.min.css',
   'public/assets/bootstrap/css/bootstrap.min.css',
   'public/assets/bootstrap/css/bootstrap-grid.min.css',
   'public/assets/bootstrap/css/bootstrap-reboot.min.css',
   'public/assets/dropdown/css/style.css',
   'public/assets/theme/css/style.css',
   'public/assets/mobirise/css/mbr-additional.css',
   'public/resources/MisLibrerias/fontawesome-free/css/all.css'
], 'public/css/miWelcome.css')

//Creamos el js de nosotros mismos
.scripts([
   'public/resources/adminlte/bower_components/jquery/dist/jquery.min.js',//version 3.3.1
   'public/resources/MisLibrerias/bootstrap/js/popper.min.js',
   'public/resources/MisLibrerias/bootstrap/js/bootstrap.min.js',
   'public/resources/MisLibrerias/sweetalert2/sweetalert2.all.min.js',
   'public/resources/MisLibrerias/datatablesB4/js/pdfmake.min.js',
   'public/resources/MisLibrerias/datatablesB4/js/vfs_fonts.js',
   'public/resources/MisLibrerias/datatablesB4/js/datatables.min.js'
], 'public/js/misLibrerias.js')

//Creamos el css modificado de boostrap 4 para cliente
.styles([
   'public/resources/MisLibrerias/bootstrap/css/bootstrapRedonder.min.css',
   'public/resources/MisLibrerias/datatablesB4/css/datatables.min.css',
   'public/resources/MisLibrerias/fontawesome-free/css/all.css'
], 'public/css/misLibrerias.css')

//para el js de solo Vuejs y axios sin boostrap panel admin
.js('resources/js/appAdmin.js', 'public/js')

//Creamos los css de adminlte Panel Administrador
.styles([
    'public/resources/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css',
    'public/resources/adminlte/bower_components/font-awesome/css/font-awesome.min.css',
    'public/resources/MisLibrerias/fontawesome-free/css/all.css',//libreria mas actualizada
    'public/resources/adminlte/dist/css/AdminLTE.min.css',
    'public/resources/adminlte/dist/css/skins/_all-skins.min.css',
    'public/resources/MisLibrerias/datatablesB3/css/datatables.min.css',
    'public/resources/MisLibrerias/charjs/Chart.min.css'
 ], 'public/css/adminlte.css')

 //Creamos el js de bootstrap 3 para adminlte Panel Administrador
 .scripts([
    'public/resources/adminlte/bower_components/jquery/dist/jquery.min.js',
    'public/resources/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js',
    'public/resources/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
    'public/resources/MisLibrerias/sweetalert2/sweetalert2.all.min.js',
    'public/resources/adminlte/dist/js/adminlte.min.js',
    'public/resources/MisLibrerias/datatablesB3/js/pdfmake.min.js',
    'public/resources/MisLibrerias/datatablesB3/js/vfs_fonts.js',
    'public/resources/MisLibrerias/datatablesB3/js/datatables.min.js',
    'public/resources/MisLibrerias/charjs/Chart.min.js'
 ], 'public/js/adminlte.js');

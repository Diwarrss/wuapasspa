<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//todos los no autenticados los invitados
Route::get('/', 'WelcomeController@index')->name('welcome'); //ruta de welcome para usuario cliente o invitado por defecto el middleware permite esta ruta ya que esta como guest o invitado
Route::post('/enviarSugerencia', 'SugerenciaController@enviarSugerencia');

//link personalizacion Login
Route::post('/login', 'Auth\LoginController@login')->name('login');

//para guardar la subscripcion del q acepta las notificaciones
Route::post('/pushs', 'PushController@store');
//Enviar notificacion al Admin cuando cliente pida cita
Route::get('/push', 'PushController@push')->name('push');

//Enviar notificacion a los Clientes cuando el admin la agende
Route::get('/pushClientes', 'PushController@pushClientes')->name('pushClientes');

Auth::routes(); //ruta de sistema login laravel Ya tienen implementado los Middleware

//para todos los usuarios autenticados
Route::group(['middleware' => 'auth'], function () {
    //controlador vista MiPerfil
    Route::get('/showPerfil', 'UserController@showPerfil')->name('showPerfil');
    Route::put('/actualizarPerfil', 'UserController@actualizarPerfil')->name('actualizarPerfil');
    Route::put('/actualizarPassword', 'UserController@actualizarPassword')->name('actualizarPassword');
    Route::post('/updateImagen', 'UserController@updateImagen')->name('updateImagen');
    //enviar el rol a cualquier vue
    Route::get('/enviarRol', 'UserController@enviarRol')->name('enviarRol');

    //middleware que solo permite acceso a admin
    Route::group(['middleware' => ['admin']], function () {
        Route::get('/admin', 'AdminController@index')->name('admin');
        //controlador vista Roles
        Route::get('/showrolesDT', 'RolController@showrolesDT')->name('showrolesDT'); //ruta para usarlos con datatables
        //controlador vista Empleados
        Route::get('/showEmpleadosDT', 'UserController@showEmpleadosDT')->name('showEmpleadosDT'); //ruta para usarlos con datatables
        Route::get('/showEmpleado', 'UserController@showEmpleado')->name('showEmpleado'); //ruta para usarlos en select de agendar
        Route::post('/createEmpleado', 'UserController@createEmpleado')->name('createEmpleado');
        Route::put('/actualizarEmpleado', 'UserController@actualizarEmpleado')->name('actualizarEmpleado');
        Route::put('/updateEstadoEmple', 'UserController@updateEstadoEmple')->name('updateEstadoEmple');
        //controlador vista Clientes
        Route::get('/showClientesDT', 'UserController@showClientesDT')->name('showClientesDT');
        Route::post('/createCliente', 'UserController@createCliente')->name('createCliente');
        Route::put('/actualizarCliente', 'UserController@actualizarCliente')->name('actualizarCliente');
        Route::get('/showCumpleClientes', 'UserController@showCumpleClientes')->name('showCumpleClientes');
        //controlador vista Solicitudes
        Route::get('/showSolicitudesPendientes', 'SolicitudesController@showSolicitudesPendientes')->name('showSolicitudesPendientes');
        Route::get('/contarSolicitudes', 'SolicitudesController@contarSolicitudes')->name('contarSolicitudes');
        Route::put('/cancelarSolicitud', 'SolicitudesController@cancelarSolicitud')->name('cancelarSolicitud'); //para cancelar solo solicitud sin agendar
        //solo para sheluder
        Route::get('/sheluder', 'AdminController@sheluder')->name('sheluder');
        //controlador para Reservaciones
        Route::post('/storeReservaciones', 'ReservacionesController@store')->name('storeReservaciones');
        Route::get('/listarReservaciones', 'ReservacionesController@listar')->name('listReservaciones');
        Route::put('/cancelarReservaciones', 'ReservacionesController@cancelar')->name('cancelReservaciones');
        Route::get('/showReservaAgendada', 'ReservacionesController@showReservaAgendada')->name('showReservaAgendada');
        Route::get('/contarAgendadas', 'ReservacionesController@contarAgendadas')->name('contarAgendadas');
        Route::put('/clienteAsistio', 'ReservacionesController@clienteAsistio')->name('clienteAsistio');
        Route::put('/clienteNoAsistio', 'ReservacionesController@clienteNoAsistio')->name('clienteNoAsistio');
        Route::put('/clienteConfirmar', 'ReservacionesController@clienteConfirmar')->name('clienteConfirmar');
        Route::post('/cancelaSolReserva', 'ReservacionesController@cancelaSolReserva')->name('cancelaSolReserva');
        //Vista Admin menu Agenda
        Route::get('/showEnEspera', 'ReservacionesController@showEnEspera')->name('showEnEspera');
        Route::get('/showAtendidos', 'ReservacionesController@showAtendidos')->name('showAtendidos');
        Route::get('/showNoAsistio', 'ReservacionesController@showNoAsistio')->name('showNoAsistio');
        Route::get('/showCanceladas', 'ReservacionesController@showCanceladas')->name('showCanceladas');
        //Vista de Reportes
        Route::get('/listarTotalAnonimas', 'ReservacionesController@listarTotalAnonimas')->name('listarTotalAnonimas');
        Route::get('/showCitasMes', 'ReportesController@showCitasMes')->name('showCitasMes');
        Route::get('/showCitasAtendidas', 'ReportesController@showCitasAtendidas')->name('showCitasAtendidas');
        Route::get('/showCitasNoAsis', 'ReportesController@showCitasNoAsis')->name('showCitasNoAsis');
        Route::get('/showReservacionEmpleado', 'ReportesController@showReservacionEmpleado')->name('showReservacionEmpleado');
        Route::get('/showServices', 'ReportesController@showServices')->name('showServices');
        //vista Mi pagina
        Route::get('/mostrar', 'EmpresaController@index')->name('mostrarEmpresa');
        Route::put('/actualizarEmpresa', 'EmpresaController@actualizarEmpresa')->name('actualizarEmpresa');
        Route::get('/showServicios', 'ServiciosController@showServicios')->name('showServicios');
        Route::post('/crearServicio', 'ServiciosController@crearServicio')->name('crearServicio');
        Route::post('/actualizarServicio', 'ServiciosController@actualizarServicio')->name('actualizarServicio');
        Route::post('/updateImagenEmpresa', 'EmpresaController@updateImagenEmpresa')->name('updateImagenEmpresa');
        Route::post('/crearCategoria', 'CategoriaController@crearCategoria')->name('crearCategoria');
        Route::get('/showCategoria', 'CategoriaController@showCategoria')->name('showCategoria');
        Route::post('/updateCategoria', 'CategoriaController@updateCategoria')->name('updateCategoria');
        Route::get('/showCategoriaActivas', 'CategoriaController@showCategoriaActivas')->name('showCategoriaActivas');
        //para las imagenes
        Route::get('/showImagenes', 'ImagenesController@showImagenes')->name('showImagenes');
        Route::post('/saveImagen', 'ImagenesController@saveImagen')->name('saveImagen');
        Route::post('/deleteImagen', 'ImagenesController@deleteImagen')->name('deleteImagen');

        //vista buzon de sugerencias
        Route::get('/showBuzon', 'SugerenciaController@showBuzon')->name('showBuzon');
        //agenda anonima
        Route::get('/listarTodo', 'ReservacionesController@listarTodo')->name('listarTodo');
        Route::get('/listarAnonimas', 'ReservacionesController@listarAnonimas')->name('listarAnonimas');
        Route::post('/storeReservacionesA', 'ReservacionesController@storeAnonimo')->name('storeReservacionesA');
        //todas las operaciones para caja Registradora
        Route::post('/crearCaja', 'CajaController@crearCaja')->name('crearCaja');
        Route::get('/listarCajar', 'CajaController@listarCajar')->name('listarCajar');
        Route::get('/empleadosAgendadores', 'UserController@empleadosAgendadores')->name('showEmpleado'); //ruta para usarlos en select de agendar
        Route::get('/infoCajaDiv', 'CajaController@infoCajaDiv')->name('infoCajaDiv');
        Route::put('/actualizarCaja', 'CajaController@actualizarCaja')->name('actualizarCaja');
        //todas las operacoines de Tranferencias entre cajas listarTransferencia
        Route::get('/listarTransferencia', 'TransferenciaController@listarTransferencia')->name('listarTransferencia');
        Route::get('/cajasListTranferencias', 'CajaController@cajasListTranferencias')->name('cajasListTranferencias');
        Route::post('/crearTransferencia', 'TransferenciaController@crearTransferencia')->name('crearTransferencia');
        Route::put('/confirmarTransferencia', 'TransferenciaController@confirmarTransferencia')->name('confirmarTransferencia');
        Route::post('/anularTransferencia', 'TransferenciaController@anularTransferencia')->name('anularTransferencia');

        //Controlador de Facturacion
        Route::get('/listarFacturacion', 'FacturaController@listarFacturacion')->name('listarFacturacion');
        Route::get('/listarFacturacionDiaria', 'FacturaController@listarFacturacionDiaria')->name('listarFacturacionDiaria');
        Route::get('/historialFacturas', 'FacturaController@historialFacturas')->name('historialFacturas');
        Route::get('/mostrarInfoFacturar', 'FacturaController@mostrarInfoFacturar')->name('mostrarInfoFacturar');
        Route::get('/serviciosFaturables', 'ServiciosController@serviciosFaturables')->name('serviciosFaturables');
        Route::post('/facturarCargos', 'FacturaController@facturarCargos')->name('facturarCargos');
        Route::post('/anularFactura', 'FacturaController@anularFactura')->name('anularFactura');
        Route::post('/crearFacturaGastos', 'FacturaController@crearFacturaGastos')->name('crearFacturaGastos');
        Route::get('/listarGastosDiarios', 'FacturaController@listarGastosDiarios')->name('listarGastosDiarios');
        Route::get('/verInfoFactura', 'FacturaController@verInfoFactura')->name('verInfoFactura');
        //pdf de factura servicios
        Route::get('/pdfFacturaServicios/{id}', 'FacturaController@pdfFacturaServicios');
        Route::get('/pdfFacturaAnulServicios/{id}', 'FacturaController@pdfFacturaAnulServicios');

        //Controlador de Nomina
        Route::get('/listarEmpleadosNomina', 'NominaController@listarEmpleadosNomina')->name('listarEmpleadosNomina');
        Route::get('/verServiciosLiquidar', 'NominaController@verServiciosLiquidar')->name('verServiciosLiquidar');
        Route::post('/pagarNomina', 'NominaController@pagarNomina')->name('pagarNomina');
        Route::get('/listarPagosNomina', 'NominaController@listarPagosNomina')->name('listarPagosNomina');
        Route::post('/cancelarPago', 'NominaController@cancelarPago')->name('cancelarPago');

        //para todo lo del Dashboard
        Route::get('/contarClientes', 'UserController@contarClientes')->name('contarClientes');
    });

    //middleware que solo permite acceso a agendador
    Route::group(['middleware' => ['agendador']], function () {
        Route::get('/admin', 'AdminController@index')->name('admin');
        //controlador vista Empleados
        Route::get('/showEmpleadosDT', 'UserController@showEmpleadosDT')->name('showEmpleadosDT'); //ruta para usarlos con datatables
        Route::get('/showEmpleado', 'UserController@showEmpleado')->name('showEmpleado'); //ruta para usarlos en select de agendar
        Route::post('/createEmpleado', 'UserController@createEmpleado')->name('createEmpleado');
        Route::put('/actualizarEmpleado', 'UserController@actualizarEmpleado')->name('actualizarEmpleado');
        Route::put('/updateEstadoEmple', 'UserController@updateEstadoEmple')->name('updateEstadoEmple');
        //controlador vista Clientes
        Route::get('/showClientesDT', 'UserController@showClientesDT')->name('showClientesDT');
        Route::post('/createCliente', 'UserController@createCliente')->name('createCliente');
        Route::put('/actualizarCliente', 'UserController@actualizarCliente')->name('actualizarCliente');
        Route::get('/showCumpleClientes', 'UserController@showCumpleClientes')->name('showCumpleClientes');
        //controlador vista Solicitudes
        Route::get('/showSolicitudesPendientes', 'SolicitudesController@showSolicitudesPendientes')->name('showSolicitudesPendientes');
        Route::get('/contarSolicitudes', 'SolicitudesController@contarSolicitudes')->name('contarSolicitudes');
        Route::put('/cancelarSolicitud', 'SolicitudesController@cancelarSolicitud')->name('cancelarSolicitud'); //para cancelar solo solicitud sin agendar
        //solo para sheluder
        Route::get('/sheluder', 'AdminController@sheluder')->name('sheluder');
        //controlador para Reservaciones
        Route::post('/storeReservaciones', 'ReservacionesController@store')->name('storeReservaciones');
        Route::get('/listarReservaciones', 'ReservacionesController@listar')->name('listReservaciones');
        Route::put('/cancelarReservaciones', 'ReservacionesController@cancelar')->name('cancelReservaciones');
        Route::get('/showReservaAgendada', 'ReservacionesController@showReservaAgendada')->name('showReservaAgendada');
        Route::get('/contarAgendadas', 'ReservacionesController@contarAgendadas')->name('contarAgendadas');
        Route::put('/clienteAsistio', 'ReservacionesController@clienteAsistio')->name('clienteAsistio');
        Route::put('/clienteNoAsistio', 'ReservacionesController@clienteNoAsistio')->name('clienteNoAsistio');
        Route::put('/clienteConfirmar', 'ReservacionesController@clienteConfirmar')->name('clienteConfirmar');
        //Vista Admin menu Agenda
        Route::get('/showEnEspera', 'ReservacionesController@showEnEspera')->name('showEnEspera');
        Route::get('/showAtendidos', 'ReservacionesController@showAtendidos')->name('showAtendidos');
        Route::get('/showNoAsistio', 'ReservacionesController@showNoAsistio')->name('showNoAsistio');
        Route::get('/showCanceladas', 'ReservacionesController@showCanceladas')->name('showCanceladas');
        //vista buzon de sugerencias
        Route::get('/showBuzon', 'SugerenciaController@showBuzon')->name('showBuzon');
        //agenda anonima
        Route::get('/listarTodo', 'ReservacionesController@listarTodo')->name('listarTodo');
        Route::get('/listarTodoHorarios', 'ReservacionesController@listarTodoHorarios')->name('listarTodoHorarios');
        Route::get('/listarAnonimas', 'ReservacionesController@listarAnonimas')->name('listarAnonimas');
        Route::post('/storeReservacionesA', 'ReservacionesController@storeAnonimo')->name('storeReservacionesA');
    });
    //middleware que solo permite acceso a empleado
    Route::group(['middleware' => ['empleado']], function () {
        Route::get('/admin', 'AdminController@index')->name('admin');
        //mostrar agenda por empleado
        Route::get('/showReservaciones', 'ReservacionesController@showReservaciones')->name('showReservaciones');
        Route::get('/showReservacionesSheluder', 'ReservacionesController@showReservacionesSheluder')->name('showReservacionesSheluder');
        Route::put('/clienteAsistio', 'ReservacionesController@clienteAsistio')->name('clienteAsistio');
        Route::put('/clienteNoAsistio', 'ReservacionesController@clienteNoAsistio')->name('clienteNoAsistio');
    });

    //middleware que solo permite acceso a cliente
    Route::group(['middleware' => ['cliente']], function () {
        Route::get('/miSolicitud', 'SolicitudesController@componente')->name('componenteSolicitude'); //para mostrar el componente
        Route::get('/listarSolicitudesCliente', 'SolicitudesController@listarSolicitudesCliente')->name('listarSolicitudesCliente');
        Route::get('/totalsolicitudes', 'SolicitudesController@totalsolicitudes')->name('totalsolicitudes');
        Route::post('/crearSolicitudesCliente', 'SolicitudesController@store')->name('crearSolicitudesCliente');
        Route::get('/nuevaCita', 'ServiciosController@componente')->name('componenteServicio'); //para mostrar el componente der srvicoso cita
        Route::post('/cancelarAgendada', 'SolicitudesController@cancelarAgendada')->name('cancelarAgendada'); //para cancelar solicitud agendada
        Route::post('/cancelarSolicitud', 'SolicitudesController@cancelarSolicitud')->name('cancelarSolicitud'); //para cancelar solo solicitud sin agendar
        Route::post('/confirmarAgendada', 'SolicitudesController@confirmarAgendada')->name('confirmarAgendada');
        Route::get('/listarServicios', 'ServiciosController@index')->name('listarServicios');
        //Para ir a componente de miPerfil
        Route::get('/miPerfil', function () {
            $logoEmpresa = DB::table('empresas')
                ->select('logo_empresa', 'nombre_corto')
                ->get();
            return view('/cliente/miPerfil', ['logoEmpresa' => $logoEmpresa]);
        })
            ->name('miPerfil');
    });
});

//Rutas para el login con redes sociales
Route::get('login/{driver}', 'Auth\LoginController@redirectToProvider')->name('social_auth'); //le pasamos la variable driver "facebook, google"
Route::get('login/{driver}/callback', 'Auth\LoginController@handleProviderCallback');//Para dar respuesta desde nuestra aplicacion misma url que colocamos al configurar developer de facebook y google

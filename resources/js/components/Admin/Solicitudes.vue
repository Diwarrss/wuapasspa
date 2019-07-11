<template>
    <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-calendar-alt"></i> Solicitudes <small>Agendar</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"><i class="fas fa-calendar-alt"></i> Solicitudes</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#pendientes" class="text-danger"><i class="fas fa-hourglass-start"></i> Pendientes <span class="label label-danger" v-text="cantidad"></span></a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#agendadas" class="text-success"> <i class="far fa-calendar-check"></i> Agendadas</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="pendientes" class="tab-pane fade in active">
                        <div class="box-header">
                            <button @click="actualizarPendientes()" class="btn btn-info btn-sm"><i class="fas fa-sync-alt"></i> Actualizar</button>
                            <a href="/admin#/agendaLibre" type="button" class="btn btn-primary btn-sm"><i class="fas fa-send"></i> Agendar Libre</a>
                        </div>
                        <div class="table-responsive container-fluid">
                            <table id="tablaPendientes" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Notas: </th>
                                        <th>Fecha Solicitada: </th>
                                        <th>Servicios: </th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="agendadas" class="tab-pane fade">
                        <div class="box-header">
                            <button @click="actualizarAgendadas()" class="btn btn-info btn-sm"><i class="fas fa-sync-alt"></i> Actualizar</button>
                            <a href="/admin#/agendaLibre" type="button" class="btn btn-primary btn-sm"><i class="fas fa-send"></i> Agendar Libre</a>
                        </div>
                        <div class="table-responsive container-fluid">
                            <table id="tablaAgendadas" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Agendada el</th>
                                        <th>Cliente</th>
                                        <th>Fecha Cita</th>
                                        <th>WhatsApp</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- el calendario salvaje -->
                    <div id="sheluder" class="tab-pane fade">
                        <div class="box-header">
                            <button data-toggle="tab" href="#pendientes" class="btn btn-info btn-sm"><i class="fas fa-reply"></i> Volver</button>
                            <hr>
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="empleado" class="col-sm-3 control-label hidden-xs"><i class="fas fa-user-tie"></i> Empleado: </label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="empleado" v-model="idEmpleadoElegido">
                                            <option disabled value="999">Escoge tu Empleado</option>
                                            <option v-for="empleado in empleados" :key="empleado.id" v-bind:value="empleado.id">
                                                {{ empleado.nombre}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <vue-scheduler v-if="idEmpleadoElegido!='999'"
                            :min-date="null"
                            :max-date="null"
                            :labels="{
                                today: 'Hoy',
                                back: 'Atrás',
                                next: 'Siguiente',
                                month: 'Mes',
                                week: 'Semana',
                                day: 'Día',
                                all_day: 'Todo el día'
                            }"
                            :time-range="[8,19]"
                            :available-views="['month', 'week', 'day']"
                            :initial-date="dateInit"
                            initial-view="day"
                            :use12="true"
                            :show-time-marker="showMarker"
                            :show-today-button="false"
                            :events="objetodeCitas"
                            :event-display="mostrarComentariosAgenda"
                            :disable-dialog="false"
                            :event-dialog-config="VentanitadeCrearcita"

                            @event-created="guardarReservacion"
                            @event-clicked="cancelarReservacion"
                        />
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                id: '',
                solicitudId: '',
                cantidad: 0,
                //cantidadA: 0,
                showMarker:false,
                dateInit: moment(),
                empleados: [],
                idEmpleadoElegido: '999',
                objetodeCitas: [],
                reservacionDT: [],
                VentanitadeCrearcita: {
                    title: 'ESTA MIERTA NO SE MUESTRA',
                    overrideInputClass: false,
                    createButtonLabel: 'Y EL NOMBRE DEL BOTON TAMPOCO',
                    enableTimeInputs: true
                },

            }
        },
        methods: {
            //metodo para saber la cantidad de solicitudes nuevas
            cantidadSolicitudes(){
                let me = this;
                axios.get('/contarSolicitudes')
                .then(function (response) {
                    //guardo en mi variable el valor y ya
                    me.cantidad = response.data.cantidad;
                    //console.log(response.data.cantidad);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            //metodo para saber la cantidad de Agendadas nuevas
            cantidadAgendadas(){
                let me = this;
                axios.get('/contarAgendadas')
                .then(function (response) {
                    //guardo en mi variable el valor y ya
                    me.cantidadA = response.data.cantidad;
                    //console.log(response.data.cantidad);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            mostrarComentariosAgenda(objetoCitaEvento) {
                return objetoCitaEvento.nombre_completo_cliente+ ' - ' + objetoCitaEvento.estado_reservacion_nombre;
            },
            listarReservaciones(sheluderXEmpelado){
                var data = this;
                axios.get('/listarReservaciones', {
                            params: {
                                empleadoID: sheluderXEmpelado
                            }
                        }).then(function (response) {
                    // data.fechaprobable=response.data[0].fechaprobable;
                    // data.comentario=response.data[0].comentario;
                    //console.log(response.data);
                    data.objetodeCitas=response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            listarEmpleados(){
                var data = this;
                axios.get('/showEmpleado').then(function (response) {
                    // data.fechaprobable=response.data[0].fechaprobable;
                    // data.comentario=response.data[0].comentario;
                    //console.log(response.data);
                    data.empleados=response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cancelarReservacion(event){
                var data = this;

                // no se puede cancelar cuando la reservacion esta en los siguiente estados
                // ATENTIDO = 2;
                // NOASISTIO = 3;
                if(event.estado_reservacion ==='2' || event.estado_reservacion ==='3'){
                        Swal.fire({
                        type: 'info',
                        title: 'Información',
                        text: 'Cita Atendida o No Asistió',
                        confirmButtonText: '<i class="fas fa-check"></i> Entendido',
                    });
                }
                else{
                     Swal.fire({
                        title: 'Esta Seguro de Cancelar la Reservación?',
                        text: "Una vez Cancelada la Reservacion debera agendar una nueva.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: 'red',
                        confirmButtonText: '<i class="fas fa-check"></i> Si',
                        cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                        if (result.value) {
                            // /cancelarReservacion
                            axios.put('/cancelarReservaciones', {
                                id: event.id
                            }).then(function (response) {
                                Swal.fire(
                                    'Cita Cancelada!',
                                    '',
                                    'success'
                                    );
                                    data.listarReservaciones(data.idEmpleadoElegido);//refrescar todos los datos para el empleado seleccionado
                                    data.cantidadSolicitudes();
                                    //data.cantidadAgendadas();
                                    jQuery('#tablaPendientes').DataTable().ajax.reload();//refrestcar la tabla de pendientes
                                    jQuery('#tablaAgendadas').DataTable().ajax.reload();
                            })
                            .catch(function (error) {
                                if (error.response.status == 422) {//preguntamos si el error es 422
                                    Swal.fire(
                                    'Se produjo un Error',
                                    'Por favor intentalo mas tarde',
                                    'error'
                                    );
                                }
                                console.log(error.response.data.errors);
                            });
                        }
                    });
                }
            },
            guardarReservacion(event) {
                var data = this;
                if(data.reservacionDT === undefined || data.reservacionDT.length == 0){
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Debe seleccionar una reservación para Agendar',
                        });
                        data.listarReservaciones(data.idEmpleadoElegido);//refrescar todos los datos para el empleado seleccionado
                }
                else{
                    axios.post('/storeReservaciones', {
                        solicitudes_solicitudes_id: data.reservacionDT.id,// esta es la solicitud de prueba que esta en mi DB
                        users_users_id: data.idEmpleadoElegido,//este seria el peluquero
                        fechaHoraInicio_reserva: moment(event.date).add(moment.duration(event.startTime, "HH:mm"),"ms").format("YYYY-MM-DD HH:mm:ss"),
                        fechaHoraFinal_reserva: moment(event.date).add(moment.duration(event.endTime, "HH:mm"),"ms").format("YYYY-MM-DD HH:mm:ss")
                    }).then(function (response) {
                        //mesaje exito y lo redirecciona a la pagina de la solicitudes hechas
                        Swal.fire({
                            position: 'top-end',
                            title: 'Solicitud Reservada con éxito!',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        // .then(function(){
                        //     window.location.href = "/admin";
                        // });
                        data.listarReservaciones(data.idEmpleadoElegido);//refrescar todos los datos para el empleado seleccionado
                        data.cantidadSolicitudes();//refrescar datos de cantidad
                        //data.cantidadAgendadas();
                        data.reservacionDT=[];//LIMPIAR EL OBJETO UNA VEZ GUARDADO
                        jQuery('#tablaPendientes').DataTable().ajax.reload();//refrestcar la tabla de pendientes
                        jQuery('#tablaAgendadas').DataTable().ajax.reload();
                        //console.log(event);
                    })
                    .catch(function (error) {
                        // if (error.response.status == 422) {//preguntamos si el error es 422
                        //     data.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                        // }
                        console.log(error);
                    });
                }
            },
            listarPendientes(){
                var data = this;
                jQuery(document).ready(function() {
                    var tablaPendientes = jQuery('#tablaPendientes').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "asc" ]],
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showSolicitudesPendientes",
                        "columns": [
                                {data:'nombre_completo'},
                                {data:'comentario'},
                                {data:'fechaprobable'},
                                {data:'nombre_servicio'},
                                {render: function (data, type, row) {
                                    if (row.estado_solicitud_nombre === 'Pendiente'){
                                        return '<span class="label label-warning">' + row.estado_solicitud_nombre + '</span>';
                                        }
                                    }
                                },
                                {render: function (data, type, row) {
                                    if (row.estado_solicitud_nombre === 'Pendiente'){
                                        return `<button type="button" data-toggle="tab" href="#sheluder" class="btn btn-success btn-sm agendar" title="Agendar Cita" style="margin-top: 1px">
                                                    <i class="far fa-calendar-check"></i> Agendar
                                                </button>
                                                <button type="button" data-toggle="tab" class="btn btn-danger btn-sm cancelarS" title="Cancelar Solicitud" style="margin-top: 1px">
                                                    <i class="far fa-trash-alt"></i> Cancelar
                                                </button>`
                                        }
                                    }
                                }
                            ]
                    });
                    //funcion de enviar los datos de la  lista de reservaciones pendientes.
                    tablaPendientes.on('click', '.agendar', function () {
                        jQuery.noConflict();// para evitar errores
                        var idRow = jQuery(this).closest('tr'); //fila que le dan click

                        //para si es responsivo obtenemos la data
                        if (idRow.hasClass('child')) {//Check if the current row is a child row
                            idRow = idRow.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var filaDT = tablaPendientes.row(idRow).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

                        //console.log(filaDT);
                        data.reservacionDT=filaDT;
                    });
                    //para cancelar la Reservacion
                    tablaPendientes.on('click', '.cancelarS', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaPendientes.row(current_row).data();
                        //console.log(datos);

                        data.id = datos["id"];//capturamos el id para enviarlo por put en el metodo
                        Swal.fire({
                            title: 'Esta Seguro de Cancelar la Solicitud?',
                            text: "Una vez Cancelada el cliente debera solicitar una nueva.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.put('/cancelarSolicitud', {
                                    id: data.id
                                }).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Solicitud Cancelada!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                        data.cantidadSolicitudes();//refrescar datos de cantidad
                                        //data.cantidadAgendadas();
                                        jQuery('#tablaPendientes').DataTable().ajax.reload(null,false);//refrestcar la tabla de pendientes
                                })
                                .catch(function (error) {
                                    if (error.response.status == 422) {//preguntamos si el error es 422
                                        Swal.fire({
                                            position: 'top-end',
                                            type: 'error',
                                            title: 'Se produjo un Error, Reintentar',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    console.log(error.response.data.errors);
                                });
                            }
                        });
                    });
                });
            },
            listarAgendadas(){
                let me=this;
                var data = this;
                jQuery(document).ready(function() {
                    var tablaAgendadas = jQuery('#tablaAgendadas').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "desc" ]],
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showReservaAgendada",
                        "columns": [
                                {data:'fechaAgendada'},
                                {data:'nombre_cliente'},
                                {data:'fecha_reserva'},
                                {render: function (data, type, row) {
                                    return '<a href="https://wa.me/57'+ row.celular +'?text=Hola, '+ row.nombre_cliente +', Tu Cita en Wuapas Spa es el '+ row.fecha_reserva +'. Responde Confirmar o Cancelar, muchas gracias" target="_blank" title="Enviar Mensaje"><i class="fab fa-whatsapp text-green"></i> ' + row.celular + ' <span class="label label-success"> Enviar</span></a>';
                                    }
                                },
                                {render: function (data, type, row) {
                                    if (row.estado_reservacion_nombre === 'Por Confirmar'){
                                        return '<span class="label label-warning">' + row.estado_reservacion_nombre + '</span>';
                                        }else{
                                            return '<span class="label label-danger">' + row.estado_reservacion_nombre + '</span>';
                                        }
                                    }
                                },
                                {render: function (data, type, row) {
                                    if (row.estado_reservacion_nombre === 'Por Confirmar'){
                                        return '<button type="button" style="margin: 1px" class="btn btn-danger btn-sm cancelar" title="Cancelar Reservación"><i class="far fa-calendar-times"></i> Cancelar</button> <button type="button" style="margin: 1px" class="btn btn-success btn-sm confirmar" title="Aceptar Reservación"><i class="fas fa-check"></i> Confirmar</button>';
                                    }else{
                                        return '<button type="button" style="margin: 1px" class="btn btn-success btn-sm atendido" title="Atendido"><i class="fas fa-calendar-check"></i> Atentido</button> <button type="button" style="margin: 1px" class="btn btn-warning btn-sm noasistio" title="No Asistió"><i class="far fa-calendar-times"></i> No Asistió</button>';
                                        }
                                    }
                                }
                            ]
                    });
                    //para cancelar la Reservacion
                    tablaAgendadas.on('click', '.cancelar', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaAgendadas.row(current_row).data();
                        //console.log(datos);

                        me.id = datos["id"];//capturamos el id para enviarlo por put en el metodo
                        Swal.fire({
                            title: 'Esta Seguro de Cancelar la Reservación?',
                            text: "Una vez Cancelada la Reservación debera agendar una nueva.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.put('/cancelarReservaciones', {
                                    id: me.id
                                }).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Cita Cancelada!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                        data.listarReservaciones();//refrescar todos los datos
                                        data.cantidadSolicitudes();//refrescar datos de cantidad
                                        //data.cantidadAgendadas();
                                        jQuery('#tablaPendientes').DataTable().ajax.reload();//refrestcar la tabla de pendientes
                                        jQuery('#tablaAgendadas').DataTable().ajax.reload();
                                })
                                .catch(function (error) {
                                    if (error.response.status == 422) {//preguntamos si el error es 422
                                        Swal.fire({
                                            position: 'top-end',
                                            type: 'error',
                                            title: 'Se produjo un Error, Reintentar',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    console.log(error.response.data.errors);
                                });
                            }
                        });
                    });
                    //para marcar como atendido el cliente
                    tablaAgendadas.on('click', '.atendido', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaAgendadas.row(current_row).data();
                        //console.log(datos);

                        me.id = datos["id"];//capturamos el id para enviarlo por put en el metodo
                        me.solicitudId = datos["solicitudes_solicitudes_id"];
                        Swal.fire({
                            title: 'Esta seguro de que el Cliente Asistió',
                            text: "Una vez marcado si, queda como Atendido.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.put('/clienteAsistio', {
                                    id: me.id,
                                    solicitudId: me.solicitudId

                                }).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Atendido!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                        data.listarReservaciones();//refrescar todos los datos
                                        data.cantidadSolicitudes();//refrescar datos de cantidad
                                        //data.cantidadAgendadas();
                                        jQuery('#tablaPendientes').DataTable().ajax.reload();//refrestcar la tabla de pendientes
                                        jQuery('#tablaAgendadas').DataTable().ajax.reload();
                                })
                                .catch(function (error) {
                                    if (error.response.status == 422) {//preguntamos si el error es 422
                                        Swal.fire({
                                            position: 'top-end',
                                            type: 'error',
                                            title: 'Se produjo un Error, Reintentar',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    console.log(error.response.data.errors);
                                });
                            }
                        });
                    });
                    //para marcar como no asistio el cliente
                    tablaAgendadas.on('click', '.noasistio', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaAgendadas.row(current_row).data();
                        //console.log(datos);

                        me.id = datos["id"];//capturamos el id para enviarlo por put en el metodo
                        me.solicitudId = datos["solicitudes_solicitudes_id"];
                        Swal.fire({
                            title: 'Esta seguro de que el Cliente NO Asistió',
                            text: "Una vez marcado si, queda como NO Atendido.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.put('/clienteNoAsistio', {
                                    id: me.id,
                                    solicitudId: me.solicitudId

                                }).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'No Asistió!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                        //data.cantidadAgendadas();
                                        jQuery('#tablaAgendadas').DataTable().ajax.reload();
                                        jQuery('#tablaPendientes').DataTable().ajax.reload();//refrestcar la tabla de pendientes
                                        data.listarReservaciones();//refrescar todos los datos
                                        data.cantidadSolicitudes();//refrescar datos de cantidad
                                })
                                .catch(function (error) {
                                    if (error.response.status == 422) {//preguntamos si el error es 422
                                        Swal.fire({
                                            position: 'top-end',
                                            type: 'error',
                                            title: 'Se produjo un Error, Reintentar',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    console.log(error.response.data.errors);
                                });
                            }
                        });
                    });
                    //para marcar del lado Admin que el cliente confirma la cita
                    tablaAgendadas.on('click', '.confirmar', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaAgendadas.row(current_row).data();
                        //console.log(datos);

                        me.id = datos["id"];//capturamos el id para enviarlo por put en el metodo
                        me.solicitudId = datos["solicitudes_solicitudes_id"];
                        Swal.fire({
                            title: 'Esta seguro de Confirmarle la Cita al Cliente',
                            text: "Una vez marcado si, queda Agendada para ese día.",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.put('/clienteConfirmar', {
                                    id: me.id,
                                    solicitudId: me.solicitudId

                                }).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Confirmada!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                        jQuery('#tablaPendientes').DataTable().ajax.reload();//refrestcar la tabla de pendientes
                                        jQuery('#tablaAgendadas').DataTable().ajax.reload(null,false);
                                        data.listarReservaciones();//refrescar todos los datos
                                        data.cantidadSolicitudes();//refrescar datos de cantidad
                                        //data.cantidadAgendadas();
                                })
                                .catch(function (error) {
                                    if (error.response.status == 422) {//preguntamos si el error es 422
                                        Swal.fire({
                                            position: 'top-end',
                                            type: 'error',
                                            title: 'Se produjo un Error, Reintentar',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                    }
                                    console.log(error.response.data.errors);
                                });
                            }
                        });
                    });
                });
            },
            actualizarPendientes()
            {
                jQuery('#tablaPendientes').DataTable().ajax.reload();
            },
            actualizarAgendadas()
            {
                jQuery('#tablaAgendadas').DataTable().ajax.reload();
            },
            cerrarModal(){
                $("[data-dismiss=modal]").trigger({ type: "click" });//para cerrar la modal con boostrap 3
                jQuery('#tablaPendientes').DataTable().ajax.reload();
            },

        },
        watch: {//apenas se sellecciona un peluqero que actualize los datos
            idEmpleadoElegido: function () {
                var data = this;
                data.listarReservaciones(data.idEmpleadoElegido);
            }
        },
        mounted() {
            this.listarPendientes();
            this.listarAgendadas();
            this.cantidadSolicitudes();
            //this.cantidadAgendadas();
            this.listarEmpleados();//para listar los peluqueros (empleados) apenas cargue la pagina
        }
    }
</script>

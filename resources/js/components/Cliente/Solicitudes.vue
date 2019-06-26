<template>
    <div class="container-fluid py-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">
                    <h3><i class="far fa-calendar-alt"></i> Mis Citas</h3>
                    <button @click="actualizarCitas()" class="btn btn-info btn-sm"><i class="fas fa-sync-alt"></i> Actualizar</button>
                </div>
            </div>
            <div class="card-body">
                <table id="tablaSolicitudes" class="table table-bordered table-responsive" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:15%">Solicitado el</th>
                            <th>Servicios</th>
                            <th>Fecha Probable</th>
                            <th>Notas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                solicitud : []
            }
        },
        methods: {
            listarSolicituesviejas(){
                var data = this;
                axios.get('/listarSolicitudesCliente').then(function (response) {
                    data.solicitud=response.data;

                    //console.log(response.data);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            listarSolicitues(){
                var data=this;//creamos esta variable para q nos reconozca los atributos de vuejs
                    jQuery(document).ready(function() {
                        var tablaSolicitudes = jQuery('#tablaSolicitudes').DataTable({
                            "language": {
                                    "url": "/jsonDTIdioma.json"
                                },
                            "processing": true,
                            "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                            "responsive": true,
                            "order": [],
                            searching: false,
                            "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                            "ajax": "/listarSolicitudesCliente",
                            "columns": [
                                        {data:'created_at'},
                                        {data:'nombre_servicio'},
                                        {data:'fechaprobable'},
                                        {data:'comentario'},
                                        {render: function (data, type, row) {
                                            if (row.estado_solicitud_nombre === 'Agendada'){
                                                return '<span class="badge badge-success mb-1 mr-sm-1">' + row.estado_solicitud_nombre + '</span><button type="button" class="btn btn-sm btn-info mb-1 mr-sm-1 verInformacion" title="Ver Información"><i class="far fa-question-circle"></i><span class="d-lg-none"> Info</span></button>';
                                            }else if(row.estado_solicitud_nombre === 'Cancelada'){
                                                return '<span class="badge badge-danger">' + row.estado_solicitud_nombre + '</span>';
                                            }else if(row.estado_solicitud_nombre === 'Aceptar Cita'){
                                                return '<span class="badge badge-warning mb-1 mr-sm-1">' + row.estado_solicitud_nombre + '</span><button type="button" class="btn btn-sm btn-info mb-1 mr-sm-1 verInformacion" title="Ver Información"><i class="far fa-question-circle"></i><span class="d-lg-none"> Info</span></button>';
                                            }else if(row.estado_solicitud_nombre === 'Atendida'){
                                                return '<span class="badge badge-light mb-1 mr-sm-1">' + row.estado_solicitud_nombre + '</span>';
                                            }else if(row.estado_solicitud_nombre === 'No Asistió'){
                                                return '<span class="badge badge-dark mb-1 mr-sm-1">' + row.estado_solicitud_nombre + '</span>';
                                            }else{
                                                return '<span class="badge badge-info">' + row.estado_solicitud_nombre + '</span>';
                                                }
                                            }
                                        },
                                        {render: function (data, type, row) {
                                            if (row.estado_solicitud_nombre === 'Agendada'){
                                                return '<button type="button" class="btn btn-sm btn-danger mb-1 mr-sm-1 cancelarAgendada" title="Cancelar Cita"><i class="far fa-calendar-times"></i><span class="d-lg-none"> Cancelar</span></button>';
                                            }else if(row.estado_solicitud_nombre === 'Cancelada'){
                                                return '<a href="/nuevaCita" class="btn btn-sm btn-success mb-1 mr-sm-1" title="Crear Nueva Cita"><i class="far fa-calendar-plus"></i><span class="d-lg-none"> Nueva</span></a>';
                                            }else if(row.estado_solicitud_nombre === 'Aceptar Cita'){
                                                return '<button type="button" class="btn btn-sm btn-success mb-1 mr-sm-1 confirmar" title="Confirmar"><i class="far fa-calendar-check"></i><span class="d-lg-none"> Aceptar</span></button> <button type="button" class="btn btn-sm btn-danger mb-1 mr-sm-1 cancelarAgendada" title="Cancelar Cita"><i class="far fa-calendar-times"></i><span class="d-lg-none"> Cancelar</span></button>';
                                            }else if(row.estado_solicitud_nombre === 'Atendida'){
                                                return '<button type="button" class="btn btn-sm btn-info mb-1 mr-sm-1 verInformacion" title="Ver Información"><i class="far fa-question-circle"></i><span class="d-lg-none"> Info</span></button>';
                                            }else if(row.estado_solicitud_nombre === 'No Asistió'){
                                                return '<button type="button" class="btn btn-sm btn-info mb-1 mr-sm-1 verInformacion" title="Ver Información"><i class="far fa-question-circle"></i><span class="d-lg-none"> Info</span></button>';
                                            }else{
                                                return '<button type="button" class="btn btn-sm btn-danger mb-1 mr-sm-1 cancelarSolicitud" title="Cancelar Cita"><i class="far fa-calendar-times"></i><span class="d-lg-none"> Cancelar</span></button>';
                                                }
                                            }
                                        }
                                    ]
                        });
                        tablaSolicitudes.on('click', '.cancelarAgendada', function () {

                            jQuery.noConflict();// para evitar errores
                            var idRow = jQuery(this).closest('tr'); //fila que le dan click

                            Swal.fire({
                                title: 'Esta Seguro de Cancelar la Cita?',
                                text: "Una vez Cancelada la Cita debera agendar una nueva.",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: 'red',
                                confirmButtonText: '<i class="fas fa-check"></i> Si',
                                cancelButtonText: '<i class="fas fa-times"></i> No'
                                }).then((result) => {
                                if (result.value) {
                                    //para si es responsivo obtenemos la data
                                    if (idRow.hasClass('child')) {//Check if the current row is a child row
                                        idRow = idRow.prev();//If it is, then point to the row before it (its 'parent')
                                    }
                                    var data = tablaSolicitudes.row(idRow).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row
                                    //console.log(data);

                                   ///cancelarCita
                                   axios.post('/cancelarAgendada', {
                                        id: data.id,
                                        reservacionId: data.reservacionId
                                    }).then(function (response) {
                                        Swal.fire({
                                            position: 'top-end',
                                            type: 'success',
                                            title: 'Cita Cancelada!',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        tablaSolicitudes.ajax.reload();//refrescar todos los datos
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
                        tablaSolicitudes.on('click', '.cancelarSolicitud', function () {

                            jQuery.noConflict();// para evitar errores
                            var idRow = jQuery(this).closest('tr'); //fila que le dan click

                            Swal.fire({
                                title: 'Esta Seguro de Cancelar la Cita?',
                                text: "Una vez Cancelada la Cita debera agendar una nueva.",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: 'red',
                                confirmButtonText: '<i class="fas fa-check"></i> Si',
                                cancelButtonText: '<i class="fas fa-times"></i> No'
                                }).then((result) => {
                                if (result.value) {

                                    //para si es responsivo obtenemos la data
                                    if (idRow.hasClass('child')) {//Check if the current row is a child row
                                        idRow = idRow.prev();//If it is, then point to the row before it (its 'parent')
                                    }
                                    var data = tablaSolicitudes.row(idRow).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

                                    //console.log(data);

                                   // /cancelarCita
                                   axios.post('/cancelarSolicitud', {
                                        id: data.id
                                    }).then(function (response) {
                                        Swal.fire({
                                                position: 'top-end',
                                                type: 'success',
                                                title: 'Cita Cancelada!',
                                                showConfirmButton: false,
                                                timer: 1500
                                            });
                                        tablaSolicitudes.ajax.reload();//refrescar todos los datos
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
                        tablaSolicitudes.on('click', '.confirmar', function () {

                            jQuery.noConflict();// para evitar errores
                            var idRow = jQuery(this).closest('tr'); //fila que le dan click

                            Swal.fire({
                                title: 'Esta seguro de Aceptar el Día de la Cita?',
                                text: "Una vez confirmada, queda tu turno apartado!",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: 'green',
                                cancelButtonColor: 'red',
                                confirmButtonText: '<i class="fas fa-check"></i> Si',
                                cancelButtonText: '<i class="fas fa-times"></i> No'
                                }).then((result) => {
                                if (result.value) {
                                    //para si es responsivo obtenemos la data
                                    if (idRow.hasClass('child')) {//Check if the current row is a child row
                                        idRow = idRow.prev();//If it is, then point to the row before it (its 'parent')
                                    }
                                    var data = tablaSolicitudes.row(idRow).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row
                                    //console.log(data);

                                   ///cancelarCita
                                   axios.post('/confirmarAgendada', {
                                        id: data.id,
                                        reservacionId: data.reservacionId
                                    }).then(function (response) {
                                        Swal.fire({
                                            position: 'top-end',
                                            type: 'success',
                                            title: 'Cita Apartada!',
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        tablaSolicitudes.ajax.reload();//refrescar todos los datos
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
                        tablaSolicitudes.on('click', '.verInformacion', function () {
                            jQuery.noConflict();// para evitar errores
                            //para si es responsivo obtenemos la data
                            var current_row = jQuery(this).parents('tr');//Get the current row
                            if (current_row.hasClass('child')) {//Check if the current row is a child row
                                current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                            }
                            var datos = tablaSolicitudes.row(current_row).data();
                            //console.log(datos);
                            //console.log(datos["id"]);

                            Swal.fire({
                                type: 'info',
                                title: 'Información de tu Cita',
                                html: datos["fecha_reserva"]+ '<br><b>'+ datos["Empleado"]+'</b>',
                                confirmButtonText: '<i class="fas fa-check"></i> Ocultar',
                            })
                        });
                    });
            },
            actualizarCitas()
            {
                jQuery('#tablaSolicitudes').DataTable().ajax.reload();
            },
        },
        mounted() {
            this.listarSolicitues();
            this.listarSolicituesviejas();
         }

    }
</script>

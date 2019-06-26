<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-hourglass-half"></i> Citas en Espera <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="fas fa-hourglass-half"></i> Citas en Espera</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="table-responsive container-fluid">
                    <table id="tablaEspera" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Agendada el</th>
                                <th>Cliente</th>
                                <th>Fecha Cita</th>
                                <th>Estado/Cita</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
        data() {
            return {

            }
        },
        methods: {
            //aqui tenemos el script para datatables
            listarAgendadas(){
                let me=this;
                var data = this;
                jQuery(document).ready(function() {
                    var tablaEspera = jQuery('#tablaEspera').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "desc" ]],
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showEnEspera",
                        "columns": [
                                {data:'fechaAgendada'},
                                {data:'nombre_cliente'},
                                {data:'fecha_reserva'},
                                {render: function (data, type, row) {
                                    if (row.estado_reservacion_nombre === 'Por Atender' && row.tipo_agenda == 'Sistema'){
                                            return '<span class="label label-danger">' + row.estado_reservacion_nombre + '</span> <span class="label label-primary">' + row.tipo_agenda + '</span>';
                                        }else{
                                            return '<span class="label label-danger">' + row.estado_reservacion_nombre + '</span> <span class="label label-info">' + row.tipo_agenda + '</span>';
                                        }                                       
                                    }
                                },
                                {render: function (data, type, row) {
                                    if (row.estado_reservacion_nombre === 'Por Atender'){
                                            return '<button type="button" style="margin: 1px" class="btn btn-success btn-sm atendido" title="Atendido"><i class="fas fa-calendar-check"></i> Atentido</button> <button type="button" style="margin: 1px" class="btn btn-warning btn-sm noasistio" title="No Asistió"><i class="far fa-calendar-times"></i> No Asistió</button>';
                                        }
                                    }
                                }
                            ]
                    });
                    //para marcar como atendido el cliente
                    tablaEspera.on('click', '.atendido', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaEspera.row(current_row).data();
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
                                        jQuery('#tablaEspera').DataTable().ajax.reload();
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
                    tablaEspera.on('click', '.noasistio', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaEspera.row(current_row).data();
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
                                     jQuery('#tablaEspera').DataTable().ajax.reload();
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
        },
        mounted() {
            this.listarAgendadas();
        }
    }
</script>

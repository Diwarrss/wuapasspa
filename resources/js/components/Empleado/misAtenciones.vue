<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="far fa-calendar-alt"></i> Atenciones Hechas <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin#/miAgenda"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="far fa-calendar-alt"></i> Atenciones Hechas</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="table-responsive container-fluid">
                    <table id="tablaAtenciones" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Fecha Cita</th>
                                <th>Fecha Atención</th>
                                <th>Estado/Cita</th>
                            </tr>
                        </thead>
                        <tbody style="font-weight: normal;">
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
            listarAtendidos(){
                let me=this;
                var data = this;
                jQuery(document).ready(function() {
                    var tablaAtenciones = jQuery('#tablaAtenciones').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "desc" ]],
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showReservaciones",
                        "columns": [
                                {data:'nombre_cliente'},
                                {data:'fecha_reserva'},
                                {data:'fechaAtendido'},
                                {render: function (data, type, row) {
                                    if (row.estado_reservacion_nombre === 'Atendida'){
                                            return '<span class="label label-success">' + row.estado_reservacion_nombre + '</span>';
                                        }else{
                                            return '<span class="label label-warning">' + row.estado_reservacion_nombre + '</span>';
                                        }
                                    }
                                }
                            ]
                    });
                });
            }
        },
        mounted() {
            this.listarAtendidos();
        }
    }
</script>

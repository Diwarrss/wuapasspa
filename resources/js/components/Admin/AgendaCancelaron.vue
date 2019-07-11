<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="far fa-calendar-times"></i> Citas Canceladas <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="far fa-calendar-times"></i> Citas Canceladas</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="table-responsive container-fluid">
                    <table id="tablaCanceladas" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Agendada el</th>
                                <th>Cliente</th>
                                <th>Fecha Cita</th>
                                <th>Cancelada el</th>
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
            listarCanceladas(){
                let me=this;
                var data = this;
                jQuery(document).ready(function() {
                    var tablaCanceladas = jQuery('#tablaCanceladas').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "desc" ]],
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showCanceladas",
                        "columns": [
                                {data:'fechaAgendada'},
                                {data:'nombre_cliente'},
                                {data:'fecha_reserva'},
                                {data:'fechaCancelacion'},
                                {render: function (data, type, row) {
                                    if (row.estado_reservacion_nombre === 'Cancelada' && row.tipo_agenda == 'Sistema'){
                                            return '<span class="label label-danger">' + row.estado_reservacion_nombre + '</span> <span class="label label-primary">' + row.tipo_agenda + '</span>';
                                        }else{
                                            return '<span class="label label-danger">' + row.estado_reservacion_nombre + '</span> <span class="label label-info">' + row.tipo_agenda + '</span>';
                                        }
                                    }
                                }
                            ]
                    });
                });
            }
        },
        mounted() {
            this.listarCanceladas();
        }
    }
</script>

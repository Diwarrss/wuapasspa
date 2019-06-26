<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-mail-bulk"></i> Buzón de Sugerencias <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="fas fa-mail-bulk"></i> Buzón de Sugerencias</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="table-responsive container-fluid">
                    <table id="tablaBuzon" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Descripción</th>
                                <th>Fecha Sugerencia</th>
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
                    var tablaEspera = jQuery('#tablaBuzon').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "desc" ]],
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showBuzon",
                        "columns": [
                                {data:'id'},
                                {data:'descripcion'},
                                {data:'created_at'}
                            ]
                    });
                });
            },
        },
        mounted() {
            this.listarAgendadas();
        }
    }
</script>

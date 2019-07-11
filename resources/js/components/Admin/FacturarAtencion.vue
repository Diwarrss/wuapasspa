<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-file-invoice-dollar"></i> Facturar Atención <small>Facturación</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"><i class="fas fa-file-invoice-dollar"></i> Facturar Atención</li>
            </ol>
        </section>
        <section class="content">
            <div>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Nueva Factura
                </button>
            </div>
            <br>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="table-responsive container-fluid">
                    <table id="tablaFacturacion" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Servicios</th>
                                <th>Valor Total</th>
                                <th>Acciones</th>
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
        watch: {

        },
        methods: {
            //aqui tenemos el script para datatables para los que se facturaran
            listarFacturacion(){
                let me=this;//creamos esta variable para q nos reconozca los atributos de vuejs
                jQuery(document).ready(function() {
                    var tablaFacturacion = jQuery('#tablaFacturacion').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/listarFacturacion",
                        "columns": [
                                {render: function (data, type, row) {
                                    if (row.nombre_cliente != null) {
                                        return row.nombre_cliente;
                                    }else{
                                        return row.nombre_anonimo;
                                    }
                                }},
                                {render: function (data, type, row) {
                                    if (row.nombre_servicio != null) {
                                        return row.nombre_servicio;
                                    }else{
                                        return '<span class="label label-warning">Agregar</span>';
                                    }
                                }},
                                {data: 'valor_total', render: $.fn.dataTable.render.number( '.', ',', 2, '$ ' )},
                                {render: function (data, type, row) {
                                    return `<button type="button" class="btn btn-success btn-sm facturar" title="Facturar Servicio">
                                            <i class="fas fa-donate"></i> Facturar
                                        </button>`
                                    }
                                }
                            ]
                    });
                } );
            },
        },
        mounted() {
            this.listarFacturacion();
        }
    }
</script>

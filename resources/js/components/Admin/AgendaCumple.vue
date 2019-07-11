<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-birthday-cake"></i> Cumpleaños del Mes <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="fas fa-birthday-cake"></i> Cumpleaños del Mes</li>
            </ol>
        </section>
        <section class="content">
                <div class="box box-primary">
                    <div class="box-header">
                    </div>
                    <div class="table-responsive container-fluid">
                        <table id="tablaClienteCumple" class="table table-bordered table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Día Cumpleaños</th>
                                    <th>WhatsApp</th>
                                    <th>Felicitar</th>
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
            listarClienteCumple(){
                jQuery(document).ready(function() {
                    var tablaClienteCumple = jQuery('#tablaClienteCumple').DataTable({
                        "order": [[ 1, "asc" ]],
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showCumpleClientes",
                        "columns": [
                                {data:'nombre_completo'},
                                {data:'cumpleDia'},
                                {render: function (data, type, row) {
                                        return '<i class="fab fa-whatsapp text-green"></i> <a href="https://wa.me/57'+ row.celular +'?text=Hola, '+ row.nombre_completo +' " target="_blank" title="Enviar Mensaje">' + row.celular + '</a>';
                                    }
                                },
                                {render: function (data, type, row) {
                                         return '<a class="btn btn-success btn-sm" href="https://wa.me/57'+ row.celular +'?text=Hola, '+ row.nombre_completo +' " target="_blank" title="Enviar Mensaje"><i class="fab fa-whatsapp"></i> Enviar WhatsApp</a>';
                                    }
                                }
                            ]
                    });
                });
            }
        },
        mounted() {
            this.listarClienteCumple();
        }
    }
</script>

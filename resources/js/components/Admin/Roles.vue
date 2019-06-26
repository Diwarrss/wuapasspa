<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-user-check"></i> Roles <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"><i class="fas fa-user-check"></i> Roles</li>
            </ol>
        </section>
        <section class="content">
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <!-- /.box-header //*********-----La tabla sin datatable--------*----*-*-VueJs
                <div class="box-body no-padding ">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="rol in arrayRoles" :key="rol.id">
                                <td v-text="rol.id"></td>
                                <td v-text="rol.nombre_rol"></td>
                                <td v-text="rol.descripcion_rol"></td>
                                <td v-text="rol.created_at"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>-->
                <!-- /.box-body -->
                <div class="table-responsive container-fluid">
                    <table id="tablaRoles" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Creación</th>
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
                id:'',
                nombre_rol:'',
                descripcion_rol:'',
                created_at:'',
                arrayRoles:[]
            }
        },
        methods: {
            listarRoles(){
                //aqui tenemos el script para datatables
                    jQuery(document).ready(function() {
                        var tablaEmpleados = jQuery('#tablaRoles').DataTable({
                            "language": {
                                "url": "/jsonDTIdioma.json"
                                },
                            "processing": true,
                            "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                            "responsive": true,
                            "order": [[ 0, "asc" ]],
                            "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                            paging: false,
                            searching: false,
                            info:false,
                            "ajax": "/showrolesDT",
                            "columns": [
                                    {data:'id'},
                                    {data:'nombre_rol'},
                                    {data:'descripcion_rol'},
                                    {data:'created_at'}
                                ]
                        });
                        jQuery.noConflict();// para evitar errores
                    });
                }
                /*
                //creamos variable q corresponde a this de mis variables de data()
                let me=this;
                // llamamos la ruta para optener los datos
                axios.get('/roles')
                .then(function (response) {
                    //guardamos el contenido de response del json /roles en nuestra variable arrayRoles
                    //me.arrayRoles = response.data;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .finally(function () {
                    // always executed
                });*/
        },
        mounted() {
            this.listarRoles();
        }
    }
</script>

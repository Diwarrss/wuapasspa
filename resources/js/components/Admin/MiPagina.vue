<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fab fa-chrome"></i> Mi Página <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="fab fa-chrome"></i> Mi Página</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <div v-for="empresa of arrayEmpresa" :key="empresa.id">

                                <img class="profile-user-img img-responsive" v-bind:src="urlLogotipo+empresa.logo_empresa">
                                <h3 class="profile-username text-center" v-text="empresa.nombre_empresa"></h3>

                                <ul class="list-group list-group-unbordered">
                                    <li class="list-group-item">
                                    <b>Nombre Corto: </b> <span class="pull-right" v-text="empresa.nombre_corto"></span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Nit: </b> <span class="pull-right" v-text="empresa.nit_empresa"></span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Direccion: </b> <span class="pull-right" v-text="empresa.direccion_empresa"></span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>E-mail: </b> <span class="pull-right" v-text="empresa.correo_empresa"></span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Url: </b> <a class="btn btn-social btn-xs btn-vimeo pull-right" v-bind:href="empresa.urlweb_empresa" target="_blank"><i class="fab fa-chrome"></i> Visitar</a>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Facebook: </b> <a class="btn btn-social btn-xs btn-facebook pull-right" v-bind:href="empresa.facebook_empresa" target="_blank"><i class="fab fa-facebook-square"></i> Visitar</a>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Instagram: </b> <a class="btn btn-social btn-xs btn-foursquare pull-right" v-bind:href="empresa.instagram_empresa" target="_blank"><i class="fab fa-instagram"></i> Visitar</a>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Celular: </b> <span class="pull-right"><i class="fab fa-whatsapp text-green"></i> {{empresa.celular_empresa}}</span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Telefono: </b> <span class="pull-right" v-text="empresa.telefono_empresa"></span>
                                    </li>
                                    <li class="list-group-item">
                                    <b>Logo: </b> <img class="img-responsive pull-right" height="25px" width="25px" v-bind:src="urlLogotipo+empresa.logo_empresa">
                                    </li>
                                </ul>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalEmpresa"><b><i class="fas fa-edit"></i> Editar</b></button>
                            </div>
                        </div>
                    </div>
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fas fa-image"></i> Logotipo de la Empresa</h3>
                        </div>
                        <form class="form" content-type="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <img class="img-responsive col-md-3 col-sm-2 col-2" height="100px" width="100px" v-bind:src="urlLogotipo+logo_empresa">
                                </div>

                                <div class="form-group">
                                    <div class="col-md-9 col-sm-10 col-10">
                                        <input type="file" class="form-control" name="logo_empresa" id="logo_empresa" @change="imagenSeleccionada1">
                                        <p class="text-red" v-if="arrayErrors.logo_empresa" v-text="arrayErrors.logo_empresa[0]"></p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-success pull-right" @click="updateImagen();"><i class="fas fa-upload"></i> Actualizar</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title"><i class="far fa-images"></i> Lista de Imagenes</h3>
                            <button type="button" class="btn btn-primary" @click="abrirModalImagen()">
                                <i class="fas fa-upload"></i> Subir
                            </button>
                        </div>

                        <div class="table-responsive container-fluid">
                            <table id="tablaImagenes" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Creado el</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody style="font-weight: normal;">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal editar perfil -->
        <section>
            <div class="modal fade in" id="modalEmpresa">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title"><i class="fas fa-edit"></i> Actualizar Empresa</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-body">
                                    <div v-for="empresa of arrayEmpresa" :key="empresa.id">

                                        <div class="form-group">
                                            <label for="Nombre" class="col-sm-4 control-label hidden-xs">Nombre:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" id="Nombre" v-model="empresa.nombre_empresa" placeholder="Nombres">
                                                <p class="text-red" v-if="arrayErrors['empresa.nombre_empresa']" v-text="arrayErrors['empresa.nombre_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="NombreCorto" class="col-sm-4 control-label hidden-xs">Nombre Corto:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" id="NombreCorto" v-model="empresa.nombre_corto" placeholder="Nombres">
                                                <p class="text-red" v-if="arrayErrors['empresa.nombre_corto']" v-text="arrayErrors['empresa.nombre_corto'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="nit" class="col-sm-4 control-label hidden-xs">Nit:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" id="nit" v-model="empresa.nit_empresa" placeholder="Nit">
                                                <p class="text-red" v-if="arrayErrors['empresa.nit_empresa']" v-text="arrayErrors['empresa.nit_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Direccion" class="col-sm-4 control-label hidden-xs">Direccion:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="text" class="form-control" id="Direccion" v-model="empresa.direccion_empresa" placeholder="Direccion">
                                                <p class="text-red" v-if="arrayErrors['empresa.direccion_empresa']" v-text="arrayErrors['empresa.direccion_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="E-mail" class="col-sm-4 control-label hidden-xs">E-mail:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="email" class="form-control" id="E-mail" v-model="empresa.correo_empresa" placeholder="E-mail">
                                                <p class="text-red" v-if="arrayErrors['empresa.correo_empresa']" v-text="arrayErrors['empresa.correo_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Url" class="col-sm-4 control-label hidden-xs">Url:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="url" class="form-control" id="Url" v-model="empresa.urlweb_empresa" placeholder="Url">
                                                <p class="text-red" v-if="arrayErrors['empresa.urlweb_empresa']" v-text="arrayErrors['empresa.urlweb_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Facebook" class="col-sm-4 control-label hidden-xs">Facebook:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="url" class="form-control" id="Facebook" v-model="empresa.facebook_empresa" placeholder="Url Facebook">
                                                <p class="text-red" v-if="arrayErrors['empresa.facebook_empresa']" v-text="arrayErrors['empresa.facebook_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Instagram" class="col-sm-4 control-label hidden-xs">Instagram:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="url" class="form-control" id="Instagram" v-model="empresa.instagram_empresa" placeholder="Url Instagram">
                                                <p class="text-red" v-if="arrayErrors['empresa.instagram_empresa']" v-text="arrayErrors['empresa.instagram_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Celular" class="col-sm-4 control-label hidden-xs">Celular:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="number" class="form-control" id="Celular" v-model="empresa.celular_empresa" placeholder="Celular">
                                                <p class="text-red" v-if="arrayErrors['empresa.celular_empresa']" v-text="arrayErrors['empresa.celular_empresa'][0]"></p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="Telefono" class="col-sm-4 control-label hidden-xs">Telefono:</label>
                                            <div class="col-sm-8 col-xs-12">
                                                <input type="number" class="form-control" id="Telefono" v-model="empresa.telefono_empresa" placeholder="Telefono">
                                                <p class="text-red" v-if="arrayErrors['empresa.telefono_empresa']" v-text="arrayErrors['empresa.telefono_empresa'][0]"></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" @click="cancelarUpdate();"><i class="fas fa-times"></i> Cancelar</button>
                                <button type="button" class="btn btn-success" @click="actualizarEmpresa();"><i class="fas fa-edit"></i> Actualizar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </section>
        <!--Modal editar y crear Imagenes-->
        <section>
            <div class="modal fade in" id="modalImagen">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" content-type="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                                <h4 class="modal-title" v-if="tipoAccionModal==1"><i class="fas fa-plus-circle"></i> Crear Imagen</h4>
                                <h4 class="modal-title" v-if="tipoAccionModal==2"><i class="fas fa-edit"></i> Actualizar Imagen</h4>
                            </div>
                            <div class="modal-body">
                                <div class="box-body">
                                    <!--
                                    <div class="form-group">
                                        <label for="Nombre" class="col-sm-4 control-label hidden-xs">Nombre:</label>
                                        <div class="col-sm-8 col-xs-12">
                                            <input type="text" class="form-control" id="Nombre" v-model="nombre_imagen" placeholder="Nombre Imagen">
                                            <p class="text-red" v-if="arrayErrors.nombre_imagen" v-text="arrayErrors.nombre_imagen[0]"></p>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <div class="col-md-12 col-sm-12 col-12">
                                            <input type="file" class="form-control" name="file" id="file" @change="imagenSeleccionada2">
                                            <p class="text-red" v-if="arrayErrors.file" v-text="arrayErrors.file[0]"></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-md-12 col-sm-12 col-12 col-form-label d-none d-sm-block">Nombre Imagen</label>
                                        <div class="col-md-12 col-sm-12 col-12">
                                            <input type="text" class="form-control" id="password" v-model="nombreImagen" placeholder="Nombre Imagen">
                                            <p class="text-red" v-if="arrayErrors.nombreImagen" v-text="arrayErrors.nombreImagen[0]"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                                <div v-if="tipoAccionModal==1">
                                    <button type="button" class="btn btn-success" @click="crearImagen()"><i class="fas fa-plus-circle"></i> Crear</button>
                                </div>
                                <div v-else>
                                    <button type="button" class="btn btn-success" @click="actualizarImagen()"><i class="fas fa-edit"></i> Actualizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </section>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                roles_roles_id: 0,
                arrayEmpresa:[],
                arrayErrors:[],
                urlLogotipo:'/img/perfiles/',
                logo_empresa: '',
                imagenSelect1: '',
                nombreImagen:'',
                imagenSelect2: '',
                idServicio:0,//el id del servicio
                file: '',
                idImagen: '',
                url_imagen: '',
                tipoAccionModal: ''
            }
        },
        methods: {
            //obtener Rol del User Logeado
            rol() {
            let me = this;
            // Obtener el id que se envia desde ruta especifica
            axios.get("/enviarRol").then(function(response) {
                me.roles_roles_id = response.data[0].roles_roles_id;
            });
            },
            verPerfil(){
                //creamos variable q corresponde a this de mis variables de data()
                let data=this;
                axios.get('/mostrar')
                    .then(function (response) {
                        //guardamos la informacion en nuestro array
                        data.arrayEmpresa = response.data,
                        data.logo_empresa = response.data[0].logo_empresa
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
            },
            actualizarEmpresa(){
                let data = this;
                axios.put('/actualizarEmpresa',{
                    empresa : data.arrayEmpresa[0]
                    })
                    .then(function (response) {
                        $("[data-dismiss=modal]").trigger({ type: "click" });
                        data.arrayErrors = [];
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            type: 'success',
                            title: 'Perfil actualizado!',
                            showConfirmButton: false,
                            timer: 2500
                        });
                        //console.log(response);
                    })
                    .catch(function (error) {
                        if (error.response.status == 422) {//preguntamos si el error es 422
                            data.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                            console.log(error.response.data.errors);
                        };
                        //console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
            },
            cancelarUpdate(){//metodo al cerrar el modal restaure todo xd
                this.verPerfil();
                $("[data-dismiss=modal]").trigger({ type: "click" });
                this.arrayErrors = [];
            },
            imagenSeleccionada1(event){//metodo para capturar la imagen
                let me = this;
                me.imagenSelect1 = event.target.files[0];//array q me contiene todos los datos de la imagen
                //console.log(event);
                //console.log(me.imagenSelect1);
            },
            imagenSeleccionada2(event){//metodo para capturar la imagen
                let me = this;
                me.imagenSelect2 = event.target.files[0];//array q me contiene todos los datos de la imagen
                //console.log(event);
                //console.log(me.imagenSelect2);
            },
            updateImagen(){
                let me = this;
                let data = this;

                let datosFormulario = new FormData();
                datosFormulario.append('logo_empresa', me.imagenSelect1);//envio y con request obtengo lo de imagen
                //console.log(me.imagenSelect);

                axios.post('/updateImagenEmpresa', datosFormulario)//le envio el parametro completo
                    .then(function (response) {
                        data.verPerfil();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            type: 'success',
                            title: 'Imagen Actualizada!',
                            showConfirmButton: false,
                            timer: 2500
                        });
                        //console.log(response);
                    })
                    .catch(function (error) {
                        if (error.response.status == 422) {//preguntamos si el error es 422
                            me.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                        };
                        //console.log(error);
                    });
            },
            crearImagen(){
                let me = this;

                let fileCargada = new FormData();
                fileCargada.append('file', me.imagenSelect2);
                fileCargada.append('nombreImagen', me.nombreImagen);

                axios.post('/saveImagen', fileCargada)//le envio el parametro completo
                    .then(function (response) {
                        jQuery('#tablaImagenes').DataTable().ajax.reload();
                            me.cerrarModalImagen();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            type: 'success',
                            title: 'Imagen Cargada con éxito!',
                            showConfirmButton: false,
                            timer: 2500
                        });
                        //console.log(response);
                    })
                    .catch(function (error) {
                        if (error.response.status == 422) {//preguntamos si el error es 422
                            me.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                        };
                        //console.log(error);
                    });
            },
            cerrarModalImagen(){
                let me=this;
                $("[data-dismiss=modal]").trigger({ type: "click" });//para cerrar la modal con boostrap 3
                this.imagenSelect2=[];
                this.nombreImagen='';
            },
            listarImagenes(){
                let me=this;//creamos esta variable para q nos reconozca los atributos de vuejs
                jQuery(document).ready(function() {
                    var tablaImagenes = jQuery('#tablaImagenes').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "asc" ]],
                        "pagingType": "full",
                        //"serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showImagenes",
                        "columns": [
                                {render: function (data, type, row) {
                                    return '<img class="img-responsive" height="100px" width="100px" src="img/carousel/'+ row.url_imagen + '">';
                                    }
                                },
                                {data:'nombre_imagen'},
                                {data:'created_at'},
                                {defaultContent:'<button class="btn btn-danger borrar btn-sm" title="Eliminar Imagen")><i class="fas fa-eraser"></i> Eliminar</button>'}
                            ]
                    });
                    tablaImagenes.on('click', '.borrar', function () {
                        //aplica para si no es responsiva la tabla
                        //para si es responsivo obtenemos la data
                        var current_row = $(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var data = tablaImagenes.row(current_row).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

                        me.idImagen = data["id"];//el id es este q es de datatables o este id es de la consulta cualquiera sirve
                        me.url_imagen = data["url_imagen"];

                        Swal.fire({
                            title: 'Esta Seguro de Eliminar la Imagen?',
                            text: "Al eliminar tendras que crear una nueva",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.post('/deleteImagen', {
                                    id: me.idImagen,
                                    url_imagen: me.url_imagen
                                }).then(function (response) {
                                    jQuery('#tablaImagenes').DataTable().ajax.reload(null,false);
                                    Swal.fire({
                                        toast: true,
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Imagen Eliminada!',
                                        showConfirmButton: false,
                                        timer: 2500
                                    });                                        
                                })
                                .catch(function (error) {
                                    if (error.response.status == 422) {//preguntamos si el error es 422
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            type: 'error',
                                            title: 'Se produjo un Error, Reintentar',
                                            showConfirmButton: false,
                                            timer: 2500
                                        });
                                    }
                                    console.log(error.response.data.errors);
                                });
                            }
                        });
                    });
                } );
            },
            
            abrirModalImagen(){
                jQuery.noConflict();// para evitar errores al mostrar la modal
                $('#modalImagen').modal('show');
                this.tipoAccionModal = 1; //para registrar
                //reseteamos variables
                this.empresas_empresas_id= 1;
                this.file='';
                this.arrayErrors = [];
            }
        },
        mounted() {
            this.rol();
            this.verPerfil();            
            this.listarImagenes();
        }
    }
</script>

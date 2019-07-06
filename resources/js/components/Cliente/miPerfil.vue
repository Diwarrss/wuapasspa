<template>
    <div class="container-fluid col-md-6 mx-auto py-4">
        <section>
            <div class="card">
                <div class="card-header">
                    <div class="col-md-12 text-center">
                        <h4><i class="far fa-user text-primary"></i> Mi Perfil</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="align-content-center">
                        <img class="rounded-circle img-responsive mx-auto d-block" width="80px" height="80px" v-bind:src="imagen">
                        <h5 class="profile-username text-center" v-text="nombre_usuario+' '+apellido_usuario"></h5>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">Nombres: </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right" v-text="nombre_usuario"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">Apellidos: </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right" v-text="apellido_usuario"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <p class="font-weight-bold">E-mail: </p>
                        </div>
                        <div class="col-8">
                            <p class="text-right" v-text="email"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">WhatsApp: </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right"><i class="fab fa-whatsapp text-success"></i> {{celular}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">Fecha Cumpleaños: </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right" v-text="fecha_cumple"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">Foto Perfil: </p>
                        </div>
                        <div class="col-6 text-right">
                            <img class="img-responsive rounded-circle" height="25px" width="25px" v-bind:src="imagen">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">Estado: </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right badge badge-success" v-if="estado_usuario==1">Activo</p>
                            <p class="text-right badge badge-danger" v-if="estado_usuario==2">Desactivado</p>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalPerfil"><i class="fas fa-edit"></i> Editar</button>
                </div>
            </div>
        </section>
        <div class="py-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">Creado el: </p>
                        </div>
                        <div class="col-6">
                            <p class="text-right" v-text="created_at"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="font-weight-bold">Última Modificación: </p>
                        </div>
                        <div class="col-6 text-right">
                            <p class="text-right" v-text="updated_at"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-2">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-secret"></i> Cambiar Contraseña
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group row">
                            <label for="password" class="col-sm-5 col-form-label d-none d-sm-block">Contraseña Nueva</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="password" v-model="password" placeholder="Contraseña Nueva">
                                <p class="text-danger" v-if="arrayErrors.password" v-text="arrayErrors.password[0]"></p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password2" class="col-sm-5 col-form-label d-none d-sm-block">Confirma Contraseña</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" v-model="password2" placeholder="Confirma Contraseña">
                                <p class="text-danger" v-if="password != password2">Contraseñas no coinciden</p>
                                <p v-else-if="password2 == ''"></p>
                                <p class="text-success" v-else>Contraseñas coinciden con éxito</p>
                                <p class="text-danger" v-if="arrayErrors.password2" v-text="arrayErrors.password2[0]"></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div v-if="password != password2"></div>
                    <div v-else>
                        <button type="button" class="btn btn-success pull-right" @click="actualizarPassword();"><i class="fas fa-check"></i> Guardar Cambios</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal editar imagen -->
        <div class="py-2">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-user-circle"></i> Imagen de Perfil
                </div>
                <div class="card-body">
                    <form content-type="multipart/form-data">
                        <div class="align-content-center">
                            <img class="img-responsive rounded-circle mx-auto d-block" height="60px" width="60px" v-bind:src="imagen"><br>
                        </div>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imagen" name="imagen" @change="imagenSeleccionada">
                                <label class="custom-file-label" for="imagen" data-browse="Buscar">Seleccionar Archivo</label>
                            </div>
                        </div>
                        <p class="text-danger" v-if="arrayErrors.imagen" v-text="arrayErrors.imagen[0]"></p>
                    </form>
                </div>
                <div class="card-footer">
                    <div>
                        <button type="button" class="btn btn-success pull-right" @click="updateImagen();"><i class="fas fa-upload"></i> Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <section>
            <!-- Modal -->
            <div class="modal fade" id="modalPerfil" tabindex="-1" role="dialog" aria-labelledby="modalPerfil" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-edit"></i> Actualizar Perfil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4 d-none d-sm-block">
                                    <label class="font-weight-bold col-form-label" for="nombre_usuario">Nombres </label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-12 text-right">
                                    <input type="text" class="form-control" id="nombre_usuario" placeholder="Nombres" v-model="nombre_usuario">
                                    <p class="text-danger" v-if="arrayErrors.nombre_usuario" v-text="arrayErrors.nombre_usuario[0]"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4 d-none d-sm-block">
                                    <label class="font-weight-bold col-form-label" for="apellido_usuario">Apellidos </label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-12 text-right">
                                    <input type="text" class="form-control" id="apellido_usuario" placeholder="Apellidos" v-model="apellido_usuario">
                                    <p class="text-danger" v-if="arrayErrors.apellido_usuario" v-text="arrayErrors.apellido_usuario[0]"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4 d-none d-sm-block">
                                    <label class="font-weight-bold col-form-label" for="email">E-mail </label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-12 text-right">
                                    <input type="text" class="form-control" id="email" placeholder="E-mail" v-model="email">
                                    <p class="text-danger" v-if="arrayErrors.email" v-text="arrayErrors.email[0]"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4 d-none d-sm-block">
                                    <label class="font-weight-bold col-form-label" for="celular">WhatsApp </label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-12 text-right">
                                    <input type="text" class="form-control" id="celular" placeholder="WhatsApp" v-model="celular">
                                    <p class="text-danger" v-if="arrayErrors.celular" v-text="arrayErrors.celular[0]"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4 d-none d-sm-block">
                                    <label class="font-weight-bold col-form-label" for="fecha_cumple">Fecha Cumpleaños </label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-12 text-right">
                                    <datetime v-model="fecha_cumple" type="date" :phrases="{ok: 'Continuar', cancel: 'Cancelar'}"
                                        format="dd/MM/yyyy" value-zone="America/Bogota" input-id="fecha_probable" use12-hour input-class="form-control" placeholder="Fecha cumpleaños" auto readonly>
                                    </datetime>
                                    <p class="text-red" v-if="arrayErrors.fecha_cumple" v-text="arrayErrors.fecha_cumple[0]"></p>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4 col-sm-4 d-none d-sm-block">
                                    <label class="font-weight-bold col-form-label" for="estado_usuario">Estado </label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-12 text-right">
                                    <select class="form-control" v-model="estado_usuario">
                                        <option value="" disabled>Seleccionar...</option>
                                        <option value="1">Activo</option>
                                        <option value="2">Desactivado</option>
                                    </select>
                                    <p class="text-red" v-if="arrayErrors.estado_usuario" v-text="arrayErrors.estado_usuario[0]"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" @click="cancelarUpdate();"><i class="fas fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-success" @click="actualizarPerfil();"><i class="fas fa-edit"></i> Actualizar</button>
                    </div>
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
                roles_roles_id: '',
                empresas_empresas_id: '',
                nombre_usuario: '',
                apellido_usuario: '',
                usuario: '',
                password: '',
                password2: '',
                email: '',
                celular: '',
                fecha_cumple: '',
                imagen: '',
                imagenSelect: '',
                estado_usuario: 1,
                created_at: '',
                updated_at: '',
                arrayUser:[],
                arrayErrors:[]
            }
        },
        methods: {
            verPerfil(){
                //creamos variable q corresponde a this de mis variables de data()
                let me=this;
                axios.get('/showPerfil')
                    .then(function (response) {
                        //guardamos la informacion en nuestro array
                        me.arrayUser = response.data;
                        var created_at2 = response.data[0].created_at;
                        var updated_at2 = response.data[0].updated_at;
                        //convertir formato de fecha para mostrar
                        var created_at1 = moment(created_at2).format('DD-MM-YYYY hh:mm a');
                        var updated_at1 = moment(updated_at2).format('DD-MM-YYYY hh:mm a');

                        me.id = response.data[0].id;
                        me.roles_roles_id = response.data[0].roles_roles_id;
                        me.empresas_empresas_id = response.data[0].empresas_empresas_id;
                        me.imagen = '/img/perfiles/' + response.data[0].imagen;
                        me.nombre_usuario = response.data[0].nombre_usuario;
                        me.apellido_usuario = response.data[0].apellido_usuario;
                        me.email = response.data[0].email;
                        me.celular = response.data[0].celular;
                        me.fecha_cumple = response.data[0].fecha_cumple;
                        me.estado_usuario = response.data[0].estado_usuario;
                        me.fecha_cumple = response.data[0].fecha_cumple;
                        me.estado_usuario = response.data[0].estado_usuario;
                        me.created_at = created_at1;
                        me.updated_at = updated_at1;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
            },
            actualizarPerfil(){
                let me = this;
                axios.put('/actualizarPerfil',{
                    id: me.id,
                    roles_roles_id: me.roles_roles_id,
                    empresas_empresas_id: me.empresas_empresas_id,
                    nombre_usuario: me.nombre_usuario,
                    apellido_usuario: me.apellido_usuario,
                    email: me.email,
                    celular: me.celular,
                    fecha_cumple: moment(me.fecha_cumple).format('YYYY-MM-DD'),
                    estado_usuario: me.estado_usuario,
                    })
                    .then(function (response) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Perfil actualizado!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function(){
                            $("[data-dismiss=modal]").trigger({ type: "click" });
                            me.arrayErrors = [];
                        });
                        //console.log(response);
                    })
                    .catch(function (error) {
                        if (error.response.status == 422) {//preguntamos si el error es 422
                            me.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
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
            actualizarPassword(){
                let me = this;
                axios.put('/actualizarPassword',{
                    id: me.id,
                    //passwordAnt: me.passwordAnt,
                    password: me.password,
                    password2: me.password2,
                    })
                    .then(function (response) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Contraseña actualizada!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function(){
                            me.password = '';
                            me.password2 = '';
                            me.arrayErrors = [];
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
            imagenSeleccionada(event){//metodo para capturar la imagen
                let me = this;
                me.imagenSelect = event.target.files[0];//array q me contiene todos los datos de la imagen
                //console.log(event);
                //console.log(me.imagenSelect);
            },
            updateImagen(){
                let me = this;

                let datosFormulario = new FormData();
                datosFormulario.append('imagen', me.imagenSelect);//envio y con request obtengo lo de imagen
                //console.log(me.imagenSelect);

                axios.post('/updateImagen', datosFormulario)//le envio el parametro completo
                    .then(function (response) {
                        Swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Imagen Actualizada!',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function(){
                            document.location.reload(true);
                        });
                        //console.log(response);
                    })
                    .catch(function (error) {
                        if (error.response.status == 422) {//preguntamos si el error es 422
                            me.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                        };
                        //console.log(error);
                    });
            }
        },
        mounted() {
            this.verPerfil();
            // Al momento de agregar la Imagen q muestre el nombre de archivo
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        }
    }
</script>

<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fa fa-users" aria-hidden="true"></i> Clientes <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="fa fa-users" aria-hidden="true"></i> Clientes</li>
            </ol>
        </section>

        <section class="content">
            <div>
                <button type="button" class="btn btn-primary" @click="abrirModal()">
                    <i class="fas fa-plus-circle"></i> Crear
                </button>
            </div>
            <br>
            <div class="box box-primary">
                <div class="box-header">
                </div>
                <div class="table-responsive container-fluid">
                    <table id="tablaClientes" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Email</th>
                                <th>WhatsApp</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- Modal crear NUEVO, ACTUALIZAR empleado -->
        <div class="modal fade in" id="modalCliente">
          <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" v-if="tipoAccionModal==1"><i class="fas fa-plus-circle"></i> Crear Cliente</h4>
                        <h4 class="modal-title" v-if="tipoAccionModal==2"><i class="fas fa-edit"></i> Actualizar Cliente</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="nombre_usuario" class="col-sm-4 control-label hidden-xs">Nombres</label>
                                <div class="col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="nombre_usuario" v-model="nombre_usuario" placeholder="Nombres">
                                    <p class="text-red" v-if="arrayErrors.nombre_usuario" v-text="arrayErrors.nombre_usuario[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="apellido_usuario" class="col-sm-4 control-label hidden-xs">Apellidos</label>

                                <div class="col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="apellido_usuario" v-model="apellido_usuario" placeholder="Apellidos">
                                    <p class="text-red" v-if="arrayErrors.apellido_usuario" v-text="arrayErrors.apellido_usuario[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-4 control-label hidden-xs">E-mail</label>

                                <div class="col-sm-8 col-xs-12">
                                    <input type="email" class="form-control" id="email" v-model="email" placeholder="E-mail">
                                    <p class="text-red" v-if="arrayErrors.email" v-text="arrayErrors.email[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label hidden-xs">Contraseña</label>

                                <div class="col-sm-8 col-xs-12">
                                    <input type="password" class="form-control" id="password" v-model="password" placeholder="Contraseña">
                                    <p class="text-red" v-if="arrayErrors.password" v-text="arrayErrors.password[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password2" class="col-sm-4 control-label hidden-xs">Confirma Contraseña</label>

                                <div class="col-sm-8 col-xs-12">
                                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" v-model="password2" placeholder="Confirma Contraseña">
                                    <p class="text-red" v-if="password != password2">Contraseñas no coinciden</p>
                                    <p v-else-if="password2 == ''"></p>
                                    <p class="text-success" v-else>Contraseñas coinciden con éxito</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="celular" class="col-sm-4 control-label hidden-xs">WhatsApp</label>

                                <div class="col-sm-8 col-xs-12">
                                    <input type="number" class="form-control" id="celular" v-model="celular" placeholder="WhatsApp">
                                    <p class="text-red" v-if="arrayErrors.celular" v-text="arrayErrors.celular[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fecha_cumple" class="col-sm-4 control-label hidden-xs">Fecha Cumpleaños</label>
                                <div class="col-sm-8 col-xs-12">
                                    <datetime v-model="fecha_cumple" type="date" :phrases="{ok: 'Continuar', cancel: 'Cancelar'}"
                                        format="dd/MM/yyyy" value-zone="America/Bogota" input-id="fecha_probable" use12-hour input-class="form-control" placeholder="Fecha cumpleaños" auto readonly>
                                    </datetime>
                                    <p class="text-red" v-if="arrayErrors.fecha_cumple" v-text="arrayErrors.fecha_cumple[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="estado_usuario" class="col-sm-4 control-label hidden-xs">Estado</label>

                                <div class="col-sm-8 col-xs-12">
                                    <select class="form-control" v-model="estado_usuario">
                                      <option value="" disabled>Seleccionar...</option>
                                      <option value="1">Activo</option>
                                      <option value="2">Inactivo</option>
                                    </select>
                                    <p class="text-red" v-if="arrayErrors.estado_usuario" v-text="arrayErrors.estado_usuario[0]"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" @click="cerrarModal();"><i class="fas fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-success" v-if="tipoAccionModal == 1" @click="crearCliente();"><i class="fas fa-check"></i> Guardar</button>
                        <button type="button" class="btn btn-success" v-if="tipoAccionModal == 2" @click="actualizarCliente();"><i class="fas fa-edit"></i> Actualizar</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                id: 0,//id del cliente
                roles_roles_id: 3,//cliente
                empresas_empresas_id: 1,
                nombre_usuario:'',
                apellido_usuario:'',
                usuario:'',
                email:'',
                password:'',
                password2:'',
                celular:'',
                fecha_cumple: '',
                imagen:'',
                estado_usuario: 1,
                arrayErrors:[],
                tipoAccionModal: 0,
                arrayClientes:[]
            }
        },
        methods: {
            //aqui tenemos el script para datatables
            listarClientes(){
                let me=this;//creamos esta variable para q nos reconozca los atributos de vuejs
                jQuery(document).ready(function() {
                    var tablaClientes = jQuery('#tablaClientes').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        //"order": [[ 0, "asc" ]],
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/showClientesDT",
                        "columns": [
                                {data:'nombre_completo'},
                                {data:'email'},
                                {render: function (data, type, row) {
                                        return '<i class="fab fa-whatsapp text-green"></i> <a href="https://wa.me/57'+ row.celular +'?text=Hola, '+ row.nombre_completo +' " target="_blank" title="Enviar Mensaje">' + row.celular + '</a>';
                                    }
                                },
                                {render: function (data, type, row) {
                                    if (row.estado_nombre === 'Activo'){
                                            return '<span class="label label-success">' + row.estado_nombre + '</span>';
                                        }else{
                                            return '<span class="label label-danger">' + row.estado_nombre + '</span>';
                                        }
                                    }
                                },
                                {defaultContent:'<button class="btn btn-warning edit btn-sm" title="Editar Cliente"><i class="fas fa-edit"></i> Editar</button>'}
                            ]
                    });

                    //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
                    tablaClientes.on('click', '.edit', function () {
                        jQuery.noConflict();// para evitar errores
                        $('#modalCliente').modal('show'); //mostramos la modal
                        me.tipoAccionModal = 2; //para actualizar colocamos 2 en esta variable de vuejs

                        //aplica para si no es responsiva la tabla
                        //var data= tablaClientes.row($(this).parents('tr')).data();//optenemos los datos de esa fila seleccionada variable data

                        //para si es responsivo obtenemos la data
                        var current_row = $(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var data = tablaClientes.row(current_row).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

                        //var data = me.arrayClientes;
                        //$(this).parents('tr') esto es para obtener por fila
                        //console.log('Row data:' + data);

                        me.id = data["id"];//el id es este q es de datatables o este id es de la consulta cualquiera sirve
                        me.roles_roles_id = data["roles_roles_id"];
                        me.empresas_empresas_id = data["empresas_empresas_id"];
                        me.nombre_usuario = data["nombre_usuario"];
                        me.apellido_usuario = data["apellido_usuario"];
                        me.usuario = data["usuario"];
                        me.email = data["email"];
                        me.password = "";
                        me.celular = data["celular"];
                        me.fecha_cumple = data["fecha_cumple"];
                        me.imagen = data["imagen"];
                        me.estado_usuario = data["estado_usuario"];
                    });
                } );
            },
            crearCliente(){
                //creamos variable q corresponde a this de mis variables de data()
                let me=this;
                //reseteamos los errores
                this.arrayErrors=[];

                axios.post('/createCliente', {
                    //enviamos los tados que hay en nuestros parametros
                    'roles_roles_id': this.roles_roles_id,
                    'empresas_empresas_id': this.empresas_empresas_id,
                    'nombre_usuario': this.nombre_usuario,
                    'apellido_usuario': this.apellido_usuario,
                    'usuario': this.usuario,
                    'email': this.email,
                    'password': this.password,
                    'celular': this.celular,
                    'fecha_cumple': moment(this.fecha_cumple).format('YYYY-MM-DD'),
                    'imagen': this.imagen,
                    'estado_usuario': this.estado_usuario
                })
                .then(function (response) {
                    //para actualizar la tabla de datatables
                    jQuery('#tablaClientes').DataTable().ajax.reload();
                    me.cerrarModal();
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Cliente creado con éxito',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    //console.log(response);
                })
                .catch(function (error) {
                    if (error.response.status == 422) {//preguntamos si el error es 422
                        me.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                    };
                    console.log(error);
                    //console.log(me.arrayErrors);
                });
            },
            actualizarCliente(){
                //creamos variable q corresponde a this de mis variables de data()
                let me=this;
                //reseteamos los errores
                this.arrayErrors=[];

                axios.put('/actualizarCliente', {
                    //enviamos los tados que hay en nuestros parametros
                    'id': this.id,
                    'roles_roles_id': this.roles_roles_id,
                    'empresas_empresas_id': this.empresas_empresas_id,
                    'nombre_usuario': this.nombre_usuario,
                    'apellido_usuario': this.apellido_usuario,
                    'usuario': this.usuario,
                    'email': this.email,
                    'password': this.password,
                    'celular': this.celular,
                    'fecha_cumple': moment(this.fecha_cumple).format('YYYY-MM-DD'),
                    'imagen': this.imagen,
                    'estado_usuario': this.estado_usuario
                })
                .then(function (response) {
                    //para actualizar la tabla de datatables
                    jQuery('#tablaClientes').DataTable().ajax.reload(null,false);
                    me.cerrarModal();
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Cliente actualizado',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    console.log(response);
                })
                .catch(function (error) {
                    if (error.response.status == 422) {//preguntamos si el error es 422
                        me.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                    };
                    console.log(error);
                    //console.log(me.arrayErrors);
                });
            },
            abrirModal(){
                jQuery.noConflict();// para evitar errores al mostrar la modal
                $('#modalCliente').modal('show');
                this.tipoAccionModal = 1; //para registrar
                //reseteamos variables
                this.roles_roles_id= 3;
                this.empresas_empresas_id= 1;
                this.nombre_usuario='';
                this.apellido_usuario='';
                this.usuario='';
                this.email='';
                this.password='';
                this.password2='';
                this.celular='';
                this.fecha_cumple='';
                this.imagen='';
                this.estado_usuario= 1;
                this.arrayErrors = [];
            },
            cerrarModal(){
                $("[data-dismiss=modal]").trigger({ type: "click" });//para cerrar la modal con boostrap 3
                jQuery('#tablaClientes').DataTable().ajax.reload();//toca con jQuery para recargar la tabla si no genera conflicto
                this.roles_roles_id= 3;
                this.empresas_empresas_id= 1;
                this.nombre_usuario='';
                this.apellido_usuario='';
                this.usuario='';
                this.email='';
                this.password='';
                this.password2='';
                this.celular='';
                this.fecha_cumple='';
                this.imagen='';
                this.estado_usuario= 1;
                this.arrayErrors = [];
            }
        },
        //watch apenas cambie la data de nota_adicional o fecha_probable ejecuta el codigo :P
        watch: {

        },
        mounted() {
            this.listarClientes();
        }
    }
</script>

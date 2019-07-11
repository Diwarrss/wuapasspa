<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-cash-register"></i> Cajas Registradoras <small>Cajas</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"><i class="fas fa-cash-register"></i> Cajas Registradoras</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                     <!-- elemeto cajita -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h4 class="text-center">CAJA MAESTRA</h4>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <h4>Valor Inicial</h4>
                                            <p>200.000</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>Valor Producido</h4>
                                            <p>500</p>
                                        </div>
                                     </div>
                                </div>
                                <div class="icon">
                                <i class="fas fa-cash-register"></i>
                                </div>
                                <a href="admin#/cajaRegistradora" @click="abrirModal('empleado','crear')" class="small-box-footer">Acciones
                                <i class="fas fa-wrench"></i></a>
                            </div>
                    <!-- elemtno cajita -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <button type="button" class="btn btn-primary" @click="abrirModal('empleado','crear')">
                            <i class="fas fa-plus-circle"></i> Crear
                        </button>
                    </div>
                    <br>
                    <div class="box box-primary">
                        <div class="box-header">
                        </div>
                        <div class="table-responsive container-fluid">
                            <table id="tablaEmpleados" class="table table-bordered table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Empleado Responsable</th>
                                        <th>Nombre Caja</th>
                                        <th>Valor Inicialr</th>
                                        <th>Valor Producido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modal crear NUEVO, ACTUALIZAR Caja Registradora -->
        <div class="modal fade in" id="modalEmpleado">
          <div class="modal-dialog">
            <div class="modal-content">
                <form class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" v-if="tipoAccionModal==1"><i class="fas fa-plus-circle"></i> Crear Caja</h4>
                        <h4 class="modal-title" v-if="tipoAccionModal==2"><i class="fas fa-edit"></i> Actualizar Caja</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="form-group" v>
                                <label for="nombre_usuario" class="col-sm-4 control-label hidden-xs">Nombre Caja</label>
                                <div class="col-sm-8 col-xs-12">
                                    <input type="text" class="form-control" id="nombre_usuario" v-model="nombre_caja" placeholder="Nombre  Caja">
                                    <p class="text-red" v-if="arrayErrors.nombre_caja" v-text="arrayErrors.nombre_caja[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="valor_inicial" class="col-sm-4 control-label hidden-xs">Valor Inicial</label>

                                <div class="col-sm-8 col-xs-12">
                                    <input type="number" class="form-control" id="valor_inicial" v-model="valor_inicial" placeholder="Apellidos">
                                    <p class="text-red" v-if="arrayErrors.valor_inicial" v-text="arrayErrors.valor_inicial[0]"></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="valor_producido" class="col-sm-4 control-label hidden-xs">Valor Producido</label>

                                <div class="col-sm-8 col-xs-12">
                                    <input type="number" class="form-control" id="valor_producido" v-model="valor_producido" placeholder="E-mail">
                                    <p class="text-red" v-if="arrayErrors.valor_producido" v-text="arrayErrors.valor_producido[0]"></p>
                                </div>
                            </div>
                             <div class="form-group">
                                    <label for="empleado" class="col-sm-4 control-label hidden-xs"><i class="fas fa-user-tie"></i> Asignar A:</label>
                                    <div class="col-sm-6">
                                        <select class="form-control" id="empleado" v-model="idEmpleadoElegido">
                                            <option disabled value="">Escoge tu Empleado</option>
                                            <option v-for="empleado in empleados" :key="empleado.id" v-bind:value="empleado.id">
                                                {{ empleado.nombre}}
                                            </option>
                                        </select>
                                        <p class="text-red" v-if="arrayErrors.empleado_id" v-text="arrayErrors.empleado_id[0]"></p>
                                    </div>
                                </div>
                            <div class="form-group">
                                <label for="estado_usuario" class="col-sm-4 control-label hidden-xs">Estado</label>

                                <div class="col-sm-8 col-xs-12">
                                    <select class="form-control" v-model="estado_usuario">
                                      <option value="" disabled>Seleccionar...</option>
                                      <option value="1">Activo</option>
                                      <option value="2">Desactivado</option>
                                    </select>
                                    <p class="text-red" v-if="arrayErrors.estado_usuario" v-text="arrayErrors.estado_usuario[0]"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" @click="cerrarModal();"><i class="fas fa-times"></i> Cancelar</button>
                        <button type="button" class="btn btn-success" v-if="tipoAccionModal == 1" @click="crearCaja();"><i class="fas fa-check"></i> Guardar</button>
                        <button type="button" class="btn btn-success" v-if="tipoAccionModal == 2" @click="actualizarEmpleado();"><i class="fas fa-edit"></i> Actualizar</button>
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
                id: 0,//id del empleado
                rol_user: '',//empleado Rol
                arrayCaja:[],
                empresas_empresas_id: 1,
                nombre_caja:'',
                valor_inicial:'0',
                idEmpleadoElegido: '',
                empleados:[],
                usuario:'',
                valor_producido:'0',
                password:'',
                password2:'',
                celular:'',
                fecha_cumple: '',
                imagen:'',
                estado_usuario: 1,
                arrayErrors:[],
                tipoAccionModal: 0,
                arrayEmpleados:[]
            }
        },
        methods: {
            EmpleadoListaCrear(){
                var data = this;
                axios.get('/empleadosAgendadores').then(function (response) {
                    // data.fechaprobable=response.data[0].fechaprobable;
                    // data.comentario=response.data[0].comentario;
                    //console.log(response.data);
                    data.empleados=response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            //aqui tenemos el script para datatables
            listarEmpleados(){
                let me=this;//creamos esta variable para q nos reconozca los atributos de vuejs
                jQuery(document).ready(function() {
                    var tablaEmpleados = jQuery('#tablaEmpleados').DataTable({
                        "language": {
                                "url": "/jsonDTIdioma.json"
                            },
                        "processing": true,
                        "lengthMenu": [[5,10, 25, 50, -1], [5,10, 25, 50, "Todos"]],
                        "responsive": true,
                        "order": [],//no colocar ordenamiento
                        "serverSide": true, //Lado servidor activar o no mas de 20000 registros
                        "ajax": "/listarCajar",
                        "columns": [
                                {data:'nombre_usuario'},
                                {data:'nombre_caja'},
                                {data:'valor_inicial'},
                                {data:'valor_producido'}
                            ]
                    });

                    //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
                    tablaEmpleados.on('click', '.edit', function () {
                        jQuery.noConflict();// para evitar errores
                        $('#modalEmpleado').modal('show'); //mostramos la modal
                        me.tipoAccionModal = 2; //para actualizar colocamos 2 en esta variable de vuejs

                        //aplica para si no es responsiva la tabla
                        //var data= tablaEmpleados.row($(this).parents('tr')).data();//optenemos los datos de esa fila seleccionada variable data

                        //para si es responsivo obtenemos la data
                        var current_row = $(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var data = tablaEmpleados.row(current_row).data();//At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

                        //var data = me.arrayEmpleados;
                        //$(this).parents('tr') esto es para obtener por fila
                        //console.log('Row data:' + data);

                        me.id = data["id"];//el id es este q es de datatables o este id es de la consulta cualquiera sirve
                        me.rol_user = data["roles_roles_id"];
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
                    //para desactivar el empleado
                    tablaEmpleados.on('click', '.desactivar', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaEmpleados.row(current_row).data();
                        //console.log(datos);

                        me.id = datos["id"];//capturamos el id para enviarlo por put en el metodo
                        Swal.fire({
                            title: '¿Desactivar el empleado?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.put('/updateEstadoEmple', {
                                    id: me.id,
                                    estado_usuario: 2
                                }).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Empleado Desactivado!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                        jQuery('#tablaEmpleados').DataTable().ajax.reload(null,false);
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
                    //para Activar el empleado
                    tablaEmpleados.on('click', '.activar', function () {
                        jQuery.noConflict();// para evitar errores
                        //para si es responsivo obtenemos la data
                        var current_row = jQuery(this).parents('tr');//Get the current row
                        if (current_row.hasClass('child')) {//Check if the current row is a child row
                            current_row = current_row.prev();//If it is, then point to the row before it (its 'parent')
                        }
                        var datos = tablaEmpleados.row(current_row).data();
                        //console.log(datos);

                        me.id = datos["id"];//capturamos el id para enviarlo por put en el metodo
                        Swal.fire({
                            title: 'Activar el empleado?',
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: 'green',
                            cancelButtonColor: 'red',
                            confirmButtonText: '<i class="fas fa-check"></i> Si',
                            cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                            if (result.value) {
                                // /cancelarReservacion
                                axios.put('/updateEstadoEmple', {
                                    id: me.id,
                                    estado_usuario: 1
                                }).then(function (response) {
                                    Swal.fire({
                                        position: 'top-end',
                                        type: 'success',
                                        title: 'Empleado Activado!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                        jQuery('#tablaEmpleados').DataTable().ajax.reload(null,false);
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
                } );
            },
            crearCaja(){
                //creamos variable q corresponde a this de mis variables de data()
                let data=this;

                axios.post('/crearCaja', {
                    'empleado_id': data.idEmpleadoElegido,
                    'nombre_caja': data.nombre_caja,
                    'valor_inicial': data.valor_inicial,
                    'valor_producido': data.valor_producido
                })
                .then(function (response) {
                    //para actualizar la tabla de datatables
                    jQuery('#tablaEmpleados').DataTable().ajax.reload();
                    data.cerrarModal();
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Empleado creado con éxito',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    //console.log(response);
                })
                .catch(function (error) {
                    if (error.response.status == 422) {//preguntamos si el error es 422
                         data.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                    };
                    console.log(error);
                    console.log(data.arrayErrors);
                });
            },
            actualizarEmpleado(){
                //creamos variable q corresponde a this de mis variables de data()
                let me=this;
                //reseteamos los errores
                this.arrayErrors=[];

                axios.put('/actualizarEmpleado', {
                    //enviamos los tados que hay en nuestros parametros
                    'id': this.id,
                    'roles_roles_id': this.rol_user,
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
                    jQuery('#tablaEmpleados').DataTable().ajax.reload(null,false);
                    me.cerrarModal();
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Empleado actualizado',
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
            abrirModal(modelo, accion){
                switch (modelo) {
                    case "empleado": {
                    switch (accion) {
                        case "crear": {
                            jQuery.noConflict();// para evitar errores al mostrar la modal
                            $('#modalEmpleado').modal('show');
                            this.tipoAccionModal = 1; //para registrar
                            //reseteamos variables
                            this.roles_roles_id= 2;
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
                            break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                $("[data-dismiss=modal]").trigger({ type: "click" });//para cerrar la modal con boostrap 3
                jQuery('#tablaEmpleados').DataTable().ajax.reload();//toca con jQuery para recargar la tabla si no genera conflicto

                this.arrayErrors = [];
                this.nombre_caja= '',
                this.valor_inicial= '0',
                this.idEmpleadoElegido=  '',
                this.valor_producido= '0',
                this.arrayErrors= []

            }
        },
        mounted() {
            this.listarEmpleados();
            this.EmpleadoListaCrear();
        }
    }
</script>

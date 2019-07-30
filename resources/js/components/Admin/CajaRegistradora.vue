<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-cash-register"></i> Cajas Registradoras
        <small>Cajas</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-cash-register"></i> Cajas Registradoras
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-4" v-if="dataCajaDiv.length > 0">
          <!-- elemeto cajita -->
          <div class="small-box bg-green">
            <div class="inner">
              <strong>
                <h3 class="text-center" v-text="dataCajaDiv[0].nombre_caja"></h3>
              </strong>
              <div class="row">
                <div class="col-md-4 text-center">
                  <h4>Valor Inicial</h4>
                  <strong>
                    <p>${{formatearValor(dataCajaDiv[0].valor_inicial)}}</p>
                  </strong>
                </div>
                <div class="col-md-4 text-center">
                  <h4>Valor Producido</h4>
                  <strong>
                    <p>${{formatearValor(dataCajaDiv[0].valor_producido)}}</p>
                  </strong>
                </div>
                <div class="col-md-4 text-center">
                  <h4>Valor Gastos</h4>
                  <strong>
                    <p>${{formatearValor(dataCajaDiv[0].valor_gastos)}}</p>
                  </strong>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center">
                  <h4>Valor Actual Caja</h4>
                  <strong>
                    <p>${{formatearValor(((parseInt(dataCajaDiv[0].valor_inicial) + parseInt(dataCajaDiv[0].valor_producido)) - parseInt(dataCajaDiv[0].valor_gastos) ))}}</p>
                  </strong>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="fas fa-cash-register"></i>
            </div>
            <button class="small-box-footer btn btn-block" @click="abrirModalTransferencia()">
              <h4>
                Transferir Dinero
                <i class="fas fa-exchange-alt"></i>
              </h4>
            </button>
          </div>
          <!-- elemtno cajita -->
        </div>
        <div class="col-md-8">
          <div v-if="roles_roles_id == 1">
            <button type="button" class="btn btn-primary" @click="abrirModal('empleado','crear')">
              <i class="fas fa-plus-circle"></i> Nueva Caja
            </button>
          </div>

          <br />
          <div class="box box-primary">
            <div class="box-header">
              <h4>
                <i class="fas fa-cash-register"></i> Lista de Cajas
              </h4>
            </div>
            <div class="table-responsive container-fluid">
              <table
                id="tablaEmpleados"
                class="table table-bordered table-hover"
                style="width:100%"
              >
                <thead>
                  <tr>
                    <th>Empleado Responsable</th>
                    <th>Nombre Caja</th>
                    <th>Valor Inicial</th>
                    <th>Valor Producido</th>
                    <th>Valor Gastos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody style="font-weight: normal;"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header">
              <h4>
                <i class="fas fa-exchange-alt"></i> Lista de Transferencias
              </h4>
            </div>
            <div class="table-responsive container-fluid">
              <table
                id="tablaTransferencias"
                class="table table-bordered table-hover"
                style="width:100%"
              >
                <thead>
                  <tr>
                    <th>Caja de Origen</th>
                    <th>Caja de Destino</th>
                    <th>Valor</th>
                    <th>Notas</th>
                    <th>Fecha de Transferencia</th>
                    <th>Estado Transferencia</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody style="font-weight: normal;"></tbody>
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
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" v-if="tipoAccionModal==1">
                <i class="fas fa-plus-circle"></i> Crear Caja
              </h4>
              <h4 class="modal-title" v-if="tipoAccionModal==2">
                <i class="fas fa-edit"></i> Actualizar Caja
              </h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group" v>
                  <label for="nombre_usuario" class="col-sm-4 control-label hidden-xs">Nombre Caja</label>
                  <div class="col-sm-8 col-xs-12">
                    <input
                      type="text"
                      class="form-control"
                      id="nombre_usuario"
                      v-model="nombre_caja"
                      placeholder="Nombre Caja"
                    />
                    <p
                      class="text-red"
                      v-if="arrayErrors.nombre_caja"
                      v-text="arrayErrors.nombre_caja[0]"
                    ></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="valor_inicial" class="col-sm-4 control-label hidden-xs">Valor Inicial</label>

                  <div class="col-sm-8 col-xs-12">
                    <input
                      type="number"
                      class="form-control"
                      id="valor_inicial"
                      v-model="valor_inicial"
                      placeholder="Valor Inicial"
                    />
                    <p
                      class="text-red"
                      v-if="arrayErrors.valor_inicial"
                      v-text="arrayErrors.valor_inicial[0]"
                    ></p>
                  </div>
                </div>
                <div class="form-group">
                  <label
                    for="valor_producido"
                    class="col-sm-4 control-label hidden-xs"
                  >Valor Producido</label>

                  <div class="col-sm-8 col-xs-12">
                    <input
                      type="number"
                      class="form-control"
                      id="valor_producido"
                      v-model="valor_producido"
                      placeholder="Valor Producido"
                    />
                    <p
                      class="text-red"
                      v-if="arrayErrors.valor_producido"
                      v-text="arrayErrors.valor_producido[0]"
                    ></p>
                  </div>
                </div>
                <div class="form-group">
                  <label
                    for="valor_producido"
                    class="col-sm-4 control-label hidden-xs"
                  >Valor Gastado</label>

                  <div class="col-sm-8 col-xs-12">
                    <input
                      type="number"
                      class="form-control"
                      id="valor_producido"
                      v-model="valor_gastos"
                      placeholder="Valor Gastos"
                    />
                    <p
                      class="text-red"
                      v-if="arrayErrors.valor_gastos"
                      v-text="arrayErrors.valor_gastos[0]"
                    ></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="empleado" class="col-sm-4 control-label hidden-xs">
                    <i class="fas fa-user-tie"></i> Asignar A:
                  </label>
                  <div class="col-sm-6">
                    <select class="form-control" id="empleado" v-model="idEmpleadoElegido">
                      <option disabled value>Escoge tu Empleado</option>
                      <option
                        v-for="empleado in empleados"
                        :key="empleado.id"
                        v-bind:value="empleado.id"
                      >{{ empleado.nombre}}</option>
                    </select>
                    <p
                      class="text-red"
                      v-if="arrayErrors.empleado_id"
                      v-text="arrayErrors.empleado_id[0]"
                    ></p>
                  </div>
                </div>
                <div class="form-group">
                  <label for="estado_usuario" class="col-sm-4 control-label hidden-xs">Estado</label>

                  <div class="col-sm-8 col-xs-12">
                    <select class="form-control" v-model="estado_caja">
                      <option value disabled>Seleccionar...</option>
                      <option value="1">Activo</option>
                      <option value="2">Desactivado</option>
                    </select>
                    <p
                      class="text-red"
                      v-if="arrayErrors.estado_caja"
                      v-text="arrayErrors.estado_caja[0]"
                    ></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" @click="cerrarModal();">
                <i class="fas fa-times"></i> Cancelar
              </button>
              <button
                type="button"
                class="btn btn-success"
                v-if="tipoAccionModal == 1"
                @click="crearCaja();"
              >
                <i class="fas fa-check"></i> Guardar
              </button>
              <button
                type="button"
                class="btn btn-success"
                v-if="tipoAccionModal == 2"
                @click="actualizarEmpleado();"
              >
                <i class="fas fa-edit"></i> Actualizar
              </button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- Modal Modal crear Transaccion -->
    <div class="modal fade in" id="modalTransferencia">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title">
                <i class="fas fa-plus-circle"></i> Hacer Transferencia
              </h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
                  <label for="cajaOrigen" class="col-sm-4 control-label hidden-xs">
                    <i class="fas fa-cash-register"></i> Caja Origen:
                  </label>
                  <div class="col-sm-6">
                    <select class="form-control" id="cajaOrigen" v-model="IdCajaOrigenTrans">
                      <option disabled v-bind:value="IdCajaOrigenTrans">{{NomCajaOrigenTrans}}</option>
                    </select>
                    <p
                      class="text-red"
                      v-if="arrayErrors.caja_origen"
                      v-text="arrayErrors.caja_origen[0]"
                    ></p>
                  </div>
                </div>

                <div class="form-group">
                  <label for="cajaDestino" class="col-sm-4 control-label hidden-xs">
                    <i class="fas fa-cash-register"></i> Caja Destino:
                  </label>
                  <div class="col-sm-6">
                    <select class="form-control" id="cajaDestino" v-model="IdCajaDestinoTrans">
                      <option disabled value>Escoge la Caja</option>
                      <option
                        :disabled="cajaTranferencia.id == IdCajaOrigenTrans"
                        v-for="cajaTranferencia in cajasTranferencias"
                        :key="cajaTranferencia.id"
                        v-bind:value="cajaTranferencia.id"
                      >{{ cajaTranferencia.nombre_caja}}</option>
                    </select>
                    <p
                      class="text-red"
                      v-if="arrayErrors.caja_destino"
                      v-text="arrayErrors.caja_destino[0]"
                    ></p>
                  </div>
                </div>

                <div class="form-group">
                  <label for="valorATransferir" class="col-sm-4 control-label hidden-xs">Valor</label>
                  <div class="col-sm-8 col-xs-12">
                    <money
                      class="form-control input-md"
                      v-bind="money"
                      v-model="valorATransferir"
                    >{{valorATransferir}}</money>
                    <p class="text-red" v-if="arrayErrors.valor" v-text="arrayErrors.valor[0]"></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" @click="cerrarModal();">
                <i class="fas fa-times"></i> Cancelar
              </button>
              <button type="button" class="btn btn-success" @click="transferir();">
                <i class="fas fa-check"></i> Transferir
              </button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- Modal para Cancelar Tranfererencias Hechas por El Perfil -->
    <div class="modal fade in" id="modalAnularTransferencia">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title">
                <i class="fas fa-plus-circle"></i> Anular Transferencias
              </h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="container-fluid">
                  <div class="form-group">
                    <h4>Motivo de Anulación:</h4>
                    <textarea
                      class="form-control"
                      rows="3"
                      placeholder="Escribe aquí porque anulas la Transferencia"
                      v-model="motivo_anulacion"
                    ></textarea>
                    <p
                      class="text-red"
                      v-if="arrayErrors.motivo_anulacion"
                      v-text="arrayErrors.motivo_anulacion[0]"
                    ></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-danger pull-left"
                data-dismiss="modal"
                aria-label="Close"
              >
                <i class="fas fa-times"></i> Cancelar
              </button>
              <button type="button" class="btn btn-success" @click="anularTransferencia();">
                <i class="fas fa-check"></i> Anular
              </button>
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
import moment from "moment";
export default {
  data() {
    return {
      roles_roles_id: 0,
      id_user: "",
      idCaja: "", //id de la caja ya listada
      rol_user: "", //empleado Rol
      arrayCaja: [],
      empresas_empresas_id: 1,
      nombre_caja: "",
      estado_caja: "",
      valor_inicial: "",
      dataCajaDiv: [],
      idEmpleadoElegido: "",
      empleados: [],
      cajasTranferencias: [],
      IdCajaOrigenTrans: "",
      NomCajaOrigenTrans: "",
      IdCajaDestinoTrans: "",
      valorATransferir: "",
      id_Transferencia_Anular: "",
      motivo_anulacion: "",
      usuario: "",
      valor_producido: "",
      valor_gastos: "",
      password: "",
      password2: "",
      celular: "",
      fecha_cumple: "",
      imagen: "",
      estado_usuario: 1,
      arrayErrors: [],
      tipoAccionModal: 0,
      arrayEmpleados: [],
      //para usar el vue componente de moneyConcurrente
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "$",
        suffix: "",
        precision: 0,
        masked: false
      }
    };
  },
  methods: {
    //obtener Rol del User Logeado y el ID del mismo
    rol() {
      let me = this;
      // Obtener el id que se envia desde ruta especifica
      axios.get("/enviarRol").then(function(response) {
        me.roles_roles_id = response.data[0].roles_roles_id;
        me.id_user = response.data[0].id_user; //se usa especialmente para Identificar al usuario que esta logueado
        //que solo pueda cancelar las Tranferencias que el Mismo que  Crea.
      });
    },
    EmpleadoListaCrear() {
      var data = this;
      axios
        .get("/empleadosAgendadores")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data);
          data.empleados = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    cajasListTranferencias() {
      var data = this;
      axios
        .get("/cajasListTranferencias")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data);
          data.cajasTranferencias = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    infoCajaDiv() {
      var data = this;
      axios
        .get("/infoCajaDiv")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data[0].nombre_caja);
          data.dataCajaDiv = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    //aqui tenemos el script para datatables
    listarEmpleados() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaEmpleados = jQuery("#tablaEmpleados").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [], //no colocar ordenamiento
          ////serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarCajar",
          columns: [
            { data: "nombre_usuario" },
            { data: "nombre_caja" },
            {
              data: "valor_inicial",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              data: "valor_producido",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              data: "valor_gastos",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              render: function(data, type, row) {
                if (row.estado_caja === "Activo") {
                  return (
                    '<span class="label label-success">' +
                    row.estado_caja +
                    "</span>"
                  );
                } else {
                  return (
                    '<span class="label label-danger">' +
                    row.estado_caja +
                    "</span>"
                  );
                }
              }
            },
            {
              render: function(data, type, row) {
                if (me.roles_roles_id == 1) {
                  return `<button class="btn btn-warning edit btn-sm" title="Editar Caja" style="margin: 1px"><i class="fas fa-edit"></i> Editar</button>
                  <button class="btn btn-success transferencia btn-sm" title="Hacer Transferencia" style="margin: 1px"><i class="fas fa-exchange-alt"></i> Transferir</button>`;
                } else if (me.roles_roles_id == 4) {
                  return `<button class="btn btn-success transferencia btn-sm" title="Hacer Transferencia" style="margin: 1px"><i class="fas fa-exchange-alt"></i> Transferir</button>`;
                } else {
                  return '<span class="label label-danger"> SIN ACCIONES</span>';
                }
              }
            }
          ]
        });

        //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
        tablaEmpleados.on("click", ".edit", function() {
          jQuery.noConflict(); // para evitar errores
          $("#modalEmpleado").modal("show"); //mostramos la modal
          me.tipoAccionModal = 2; //para actualizar colocamos 2 en esta variable de vuejs

          //aplica para si no es responsiva la tabla
          //var data= tablaEmpleados.row($(this).parents('tr')).data();//optenemos los datos de esa fila seleccionada variable data

          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var data = tablaEmpleados.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          //var data = me.arrayEmpleados;
          //$(this).parents('tr') esto es para obtener por fila
          //console.log(data);
          (me.idCaja = data["id"]),
            (me.idEmpleadoElegido = data["empleado_id"]),
            (me.nombre_caja = data["nombre_caja"]),
            (me.valor_inicial = data["valor_inicial"]),
            (me.valor_producido = data["valor_producido"]),
            (me.valor_gastos = data["valor_gastos"]),
            (me.estado_caja = data["estado_cajaNum"]);
        });

        tablaEmpleados.on("click", ".transferencia", function() {
          jQuery.noConflict(); // para evitar errores
          $("#modalTransferencia").modal("show"); //mostramos la modal

          //aplica para si no es responsiva la tabla
          //var data= tablaEmpleados.row($(this).parents('tr')).data();//optenemos los datos de esa fila seleccionada variable data

          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var data = tablaEmpleados.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          //var data = me.arrayEmpleados;
          //$(this).parents('tr') esto es para obtener por fila
          //console.log(data);
          me.IdCajaOrigenTrans = data["id"];
          me.NomCajaOrigenTrans = data["nombre_caja"];
          me.IdCajaDestinoTrans = "";
          me.valorATransferir = "";
        });
      });
    },
    abrirModalTransferencia() {
      let me = this;
      jQuery.noConflict(); // para evitar errores
      $("#modalTransferencia").modal("show");
      me.IdCajaOrigenTrans = me.dataCajaDiv[0].id;
      me.NomCajaOrigenTrans = me.dataCajaDiv[0].nombre_caja;
    },
    listarTransferencias() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaTransferencias = jQuery("#tablaTransferencias").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [[4, "desc"]], //no colocar ordenamiento
          //serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarTransferencia",
          columns: [
            { data: "nombre_cajaOrigen" },
            { data: "nombre_cajaDestino" },
            {
              data: "valor",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            { data: "notas" },
            { data: "fecha_transferencia" },
            {
              render: function(data, type, row) {
                if (row.estado_transferencia === "Recibida") {
                  return (
                    '<span class="label label-success">' +
                    row.estado_transferencia +
                    "</span>"
                  );
                } else if (row.estado_transferencia === "Pendiente") {
                  return (
                    '<span class="label label-warning">' +
                    row.estado_transferencia +
                    "</span>"
                  );
                } else {
                  return (
                    '<span class="label label-danger">' +
                    row.estado_transferencia +
                    "</span>"
                  );
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.estado_transferencia === "Pendiente") {
                  if (row.EmpCreadorTrans == me.id_user) {
                    return '<button class="btn btn-danger AnularTranferencia btn-sm" title="Cancelar Transferencia" ><i class="fas fa-ban"></i> Anular</button>';
                  } else if (row.EmpRecibeTrans == me.id_user) {
                    return '<button class="btn btn-success confirmar btn-sm" title="Confirmar Transferencia"><i class="fas fa-check-circle"></i>  Confirmar</button>';
                  } else {
                    return "";
                  }
                } else if (row.estado_transferencia === "Recibida") {
                  return '<button class="btn btn-success btn-sm" title="Transferencia COnfirmada" disabled><i class="fas fa-ban"></i> Confirmada</button>';
                } else {
                  return "";
                }
              }
            }
          ]
        });

        //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
        tablaTransferencias.on("click", ".confirmar", function() {
          jQuery.noConflict(); // para evitar errores

          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var data = tablaTransferencias.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          //var data = me.arrayEmpleados;
          //$(this).parents('tr') esto es para obtener por fila
          //console.log(data);
          var idTransferencia = data["id"];

          Swal.fire({
            title: "Esta Seguro de Confirmar la Transferencia",
            text: "Una vez Confirmada no se podra deshacer la operacion",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "green",
            cancelButtonColor: "red",
            confirmButtonText: '<i class="fas fa-check"></i> Si',
            cancelButtonText: '<i class="fas fa-times"></i> No'
          }).then(result => {
            if (result.value) {
              axios
                .put("/confirmarTransferencia", {
                  id: idTransferencia
                })
                .then(function(response) {
                  jQuery("#tablaTransferencias")
                    .DataTable()
                    .ajax.reload(null, false);
                  jQuery("#tablaEmpleados")
                    .DataTable()
                    .ajax.reload(null, false);
                  me.infoCajaDiv();
                  Swal.fire({
                    position: "top-end",
                    type: "success",
                    title: "Transferencia Realizada y Confirmada!",
                    showConfirmButton: false,
                    timer: 1500
                  });
                })
                .catch(function(error) {
                  Swal.fire({
                    position: "top-end",
                    type: "error",
                    title: "El valor a transferir ya no esta disponible",
                    showConfirmButton: true
                  });
                  jQuery("#tablaTransferencias")
                    .DataTable()
                    .ajax.reload(null, false);
                });
            }
          });
        });

        //Metodo para llamar modal de Anular Tranferencia
        tablaTransferencias.on("click", ".AnularTranferencia", function() {
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaTransferencias.row(current_row).data();

          me.id_Transferencia_Anular = datos["id"];

          //abrimos la modal para anular la Transferencia.
          jQuery.noConflict(); // para evitar errores
          $("#modalAnularTransferencia").modal("show"); //mostramos la modal
        });
      });
    },
    //Accion de Anular Transferencias, solo las puede anular el usuario que crea la Transferencia
    anularTransferencia() {
      let data = this;
      Swal.fire({
        title: "¿Seguro de Anular la Transferencia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "red",
        confirmButtonText: '<i class="fas fa-check"></i> Si',
        cancelButtonText: '<i class="fas fa-times"></i> No'
      }).then(result => {
        if (result.value) {
          axios
            .post("/anularTransferencia", {
              id_Transferencia_Anular: data.id_Transferencia_Anular,
              motivo_anulacion: data.motivo_anulacion
            }) //le envio el parametro completo
            .then(function(response) {
              Swal.fire({
                position: "top-end",
                type: "success",
                title: "Transferencia Anulada con éxito!",
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                //actualizamos las tablas
                jQuery("#tablaTransferencias")
                  .DataTable()
                  .ajax.reload(null, false);
                jQuery("[data-dismiss=modal]").trigger({ type: "click" });
                data.motivo_anulacion = "";
              });
              //console.log(response);
            })
            .catch(function(error) {
              if (error.response.status == 422) {
                //preguntamos si el error es 422
                me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
              } else {
                Swal.fire({
                  position: "top-end",
                  type: "error",
                  title:
                    "NO es Posible anular, La Transferencia ya Fue Confirmada",
                  showConfirmButton: true
                });
                jQuery("#tablaTransferencias")
                  .DataTable()
                  .ajax.reload(null, false);
                jQuery("[data-dismiss=modal]").trigger({ type: "click" });
                data.motivo_anulacion = "";
              }
            });
        }
      });
    },
    crearCaja() {
      //creamos variable q corresponde a this de mis variables de data()
      let data = this;

      axios
        .post("/crearCaja", {
          empleado_id: data.idEmpleadoElegido,
          nombre_caja: data.nombre_caja,
          valor_inicial: data.valor_inicial,
          valor_producido: data.valor_producido,
          valor_gastos: data.valor_gastos,
          estado_caja: data.estado_caja
        })
        .then(function(response) {
          //para actualizar la tabla de datatables
          jQuery("#tablaEmpleados")
            .DataTable()
            .ajax.reload();
          data.cerrarModal();
          data.infoCajaDiv();
          data.cajasListTranferencias();
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Empleado creado con éxito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            data.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          console.log(error);
          console.log(data.arrayErrors);
        });
    },
    transferir() {
      //creamos variable q corresponde a this de mis variables de data()
      let data = this;

      axios
        .post("/crearTransferencia", {
          caja_origen: data.IdCajaOrigenTrans,
          caja_destino: data.IdCajaDestinoTrans,
          valor: data.valorATransferir
          //notas: data.valor_producido,
        })
        .then(function(response) {
          //para actualizar la tabla de datatables
          jQuery("#tablaTransferencias")
            .DataTable()
            .ajax.reload(null, false);
          data.infoCajaDiv();
          data.cerrarModal();
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Transferencia Solicitada con Exito",
            showConfirmButton: false,
            timer: 1500
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            data.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          console.log(error);
          console.log(data.arrayErrors);
        });
    },
    formatearValor(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    actualizarEmpleado() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;
      //reseteamos los errores
      this.arrayErrors = [];

      axios
        .put("/actualizarCaja", {
          //enviamos los tados que hay en nuestros parametros
          id: me.idCaja,
          empleado_id: me.idEmpleadoElegido,
          nombre_caja: me.nombre_caja,
          valor_inicial: me.valor_inicial,
          valor_producido: me.valor_producido,
          valor_gastos: me.valor_gastos,
          estado_caja: me.estado_caja
        })
        .then(function(response) {
          //para actualizar la tabla de datatables
          jQuery("#tablaEmpleados")
            .DataTable()
            .ajax.reload(null, false);
          me.infoCajaDiv();
          me.cerrarModal();
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Empleado actualizado",
            showConfirmButton: false,
            timer: 1500
          });
          console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          console.log(error);
          //console.log(me.arrayErrors);
        });
    },
    abrirModal(modelo, accion) {
      switch (modelo) {
        case "empleado": {
          switch (accion) {
            case "crear": {
              jQuery.noConflict(); // para evitar errores al mostrar la modal
              $("#modalEmpleado").modal("show");
              this.tipoAccionModal = 1; //para registrar
              break;
            }
          }
        }
      }
    },
    cerrarModal() {
      jQuery("[data-dismiss=modal]").trigger({ type: "click" }); //para cerrar la modal con boostrap 3
      jQuery("#tablaEmpleados")
        .DataTable()
        .ajax.reload(); //toca con jQuery para recargar la tabla si no genera conflicto

      this.arrayErrors = [];
      (this.nombre_caja = ""),
        (this.valor_inicial = ""),
        (this.idEmpleadoElegido = ""),
        (this.valor_producido = ""),
        (this.valor_gastos = ""),
        (this.estado_caja = ""),
        (this.arrayErrors = []),
        (this.IdCajaOrigenTrans = ""),
        (this.NomCajaOrigenTrans = ""),
        (this.IdCajaDestinoTrans = ""),
        (this.valorATransferir = "");
    }
  },
  mounted() {
    this.rol();
    this.listarEmpleados();
    this.infoCajaDiv();
    this.EmpleadoListaCrear();
    this.listarTransferencias();
    this.cajasListTranferencias();
  }
};
</script>

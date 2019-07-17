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
              <h4 class="text-center" v-text="dataCajaDiv[0].nombre_caja"></h4>
              <div class="row">
                <div class="col-md-3">
                  <h4>Valor Inicial</h4>
                  <p v-text="dataCajaDiv[0].valor_inicial"></p>
                </div>
                <div class="col-md-4">
                  <h4>Valor Neto</h4>
                  <p v-text="dataCajaDiv[0].valor_producido - dataCajaDiv[0].valor_gastos"></p>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="fas fa-cash-register"></i>
            </div>
            <a
              href="admin#/cajaRegistradora"
              @click="abrirModal('empleado','crear')"
              class="small-box-footer"
            >
              Acciones
              <i class="fas fa-wrench"></i>
            </a>
          </div>
          <!-- elemtno cajita -->
        </div>
        <div class="col-md-8">
          <div>
            <button type="button" class="btn btn-primary" @click="abrirModal('empleado','crear')">
              <i class="fas fa-plus-circle"></i> Nueva Caja
            </button>
          </div>
          <br />
          <div class="box box-primary">
            <div class="box-header"></div>
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
  </div>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
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
      arrayEmpleados: []
    };
  },
  methods: {
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
          serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarCajar",
          columns: [
            { data: "nombre_usuario" },
            { data: "nombre_caja" },
            {
              data: "valor_inicial",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$ ")
            },
            {
              data: "valor_producido",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$ ")
            },
            {
              data: "valor_gastos",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$ ")
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
                return '<button class="btn btn-warning edit btn-sm" title="Editar Caja"><i class="fas fa-edit"></i> Editar</button>';
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
              //reseteamos variables
              this.roles_roles_id = 2;
              this.empresas_empresas_id = 1;
              this.nombre_usuario = "";
              this.apellido_usuario = "";
              this.usuario = "";
              this.email = "";
              this.password = "";
              this.password2 = "";
              this.celular = "";
              this.fecha_cumple = "";
              this.imagen = "";
              this.estado_usuario = 1;
              this.arrayErrors = [];
              break;
            }
          }
        }
      }
    },
    cerrarModal() {
      $("[data-dismiss=modal]").trigger({ type: "click" }); //para cerrar la modal con boostrap 3
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
        (this.arrayErrors = []);
    }
  },
  mounted() {
    this.listarEmpleados();
    this.infoCajaDiv();
    this.EmpleadoListaCrear();
  }
};
</script>

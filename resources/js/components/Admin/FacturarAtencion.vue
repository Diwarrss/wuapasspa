<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-file-invoice-dollar"></i> Facturar Atención
        <small>Facturación</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-file-invoice-dollar"></i> Facturar Atención
        </li>
      </ol>
    </section>
    <section v-if="mostrarDiv == 1" class="content">
      <div>
        <button type="button" class="btn btn-primary">
          <i class="fas fa-plus-circle"></i> Nueva Factura
        </button>
      </div>
      <br />
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">
            <i class="far fa-list-alt"></i> Facturar Atenciones
          </h3>
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
            <tbody style="font-weight: normal;"></tbody>
          </table>
        </div>
      </div>
    </section>
    <section v-else-if="mostrarDiv == 2" class="content">
      <div>
        <button type="button" class="btn btn-success" @click="regresar()">
          <i class="fas fa-reply"></i> Regresar
        </button>
      </div>
      <br />
      <div class="box box-primary">
        <div class="box-header with-border bg-aqua-active">
          <div class="col-md-12 text-center">
            <h3>
              <i class="fas fa-file-invoice-dollar"></i> Detalles de Facturación
            </h3>
          </div>
          <div class="col-md-4 col-sm-4">
            <span>
              <strong>Nombre Cliente:</strong>
              <span v-if="nombre_cliente != ''" v-text="nombre_cliente"></span>
              <span else v-text="nombre_anonimo"></span>
            </span>
          </div>
          <div class="col-md-4 col-sm-4 text-center">
            <span>
              <strong>Nombre Empresa:</strong>
              {{nombre_empresa}}
            </span>
          </div>
          <div class="col-md-4 col-sm-4 text-right">
            <span>
              <strong>Fecha Factura:</strong>
              {{fecha_actual}}
            </span>
            <br />
            <span>
              <strong>Facturado Por:</strong>
              {{nombre_facturador}}
            </span>
          </div>
        </div>
        <div class="box-body table-responsive">
          <div class="col-md-6">
            <button
              type="button"
              class="btn btn-default"
              style="margin-bottom: 5px"
              @click="nota();"
            >
              <i class="fas fa-pencil-alt"></i> Nota
            </button>
          </div>
          <div class="col-md-6 text-right">
            <button
              type="button"
              class="btn btn-success"
              style="margin-bottom: 5px"
              @click="agregarDetalles();"
            >
              <i class="fas fa-plus-circle"></i> Añadir Servicio
            </button>
          </div>
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Servicios</th>
                <th>Realizado Por</th>
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Valor Servicio</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody style="font-weight: normal;">
              <tr v-if="informacionFacturar.length == 0">
                <td colspan="6">
                  <div
                    class="alert alert-danger text-center"
                    role="alert"
                  >Agregue información a Facturar</div>
                </td>
              </tr>
              <tr v-for="(detalle, index) in informacionFacturar" :key="detalle.id">
                <td>
                  <span>{{detalle.nombre_servicio}} (${{formatearValor(detalle.valor_servicio)}})</span>
                </td>
                <td>
                  <select class="form-control" id="empleado" v-model="detalle.id_atendido_por">
                    <option
                      v-for="empleado in lista_empleados"
                      :key="empleado.id"
                      v-bind:value="empleado.id"
                    >{{ empleado.nombre}}</option>
                  </select>
                </td>
                <td>
                  <input v-model="detalle.cantidad" type="number" max:3 class="form-control" />
                </td>
                <td>
                  <!-- <input v-model="detalle.valor_descuento" type="number" max:3 class="form-control" /> -->
                  <money
                    class="form-control"
                    v-bind="money"
                    v-model="detalle.valor_descuento"
                  >{{detalle.valor_descuento}}</money>
                </td>
                <td>
                  <span>${{formatearValor((detalle.cantidad*detalle.valor_servicio)-detalle.valor_descuento)}}</span>
                </td>
                <td>
                  <button
                    @click="eliminarDetalle(index)"
                    type="button"
                    class="btn btn-danger"
                    title="Quitar"
                  >
                    <i class="fas fa-close"></i>
                  </button>
                </td>
              </tr>
              <tr v-if="informacionFacturar.length > 0">
                <td colspan="4" align="right">
                  <strong>Subtotal:</strong>
                </td>
                <td>${{formatearValor(subtotal = calcularSubtotal)}}</td>
              </tr>
              <tr v-if="informacionFacturar.length > 0">
                <td colspan="4" align="right">
                  <strong>Descuento:</strong>
                </td>
                <td>
                  ${{formatearValor(descuento = calcularTotalDescuento)}}
                  <!-- <money class="form-control" v-bind="money" v-model="descuento">{{descuento}}</money> -->
                </td>
              </tr>
              <tr v-if="informacionFacturar.length > 0">
                <td colspan="4" align="right">
                  <strong>Total Neto:</strong>
                </td>
                <td>${{formatearValor(valorNeto = calcularNeto)}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="box-footer clearfix">
          <div class="text-left">
            <div v-if="informacionFacturar.length > 0">
              <button
                type="button"
                class="btn btn-success"
                style="margin-bottom: 5px"
                @click="abrirPagos()"
              >
                <i class="fas fa-money"></i> Pago
              </button>
              <button
                type="button"
                class="btn btn-danger"
                style="margin-bottom: 5px"
                @click="regresar()"
              >
                <i class="fas fa-close"></i> Cancelar
              </button>
            </div>
            <div v-else></div>
          </div>
        </div>
      </div>
    </section>
    <!-- seccion parte para mostrar el total de facturados -->
    <section v-if="mostrarDiv == 1" class="content">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">
            <i class="far fa-list-alt"></i> Facturación Diaria
          </h3>
        </div>

        <div class="table-responsive container-fluid">
          <table
            id="tablaFacturasDiarias"
            class="table table-bordered table-hover"
            style="width:100%"
          >
            <thead>
              <tr>
                <th># Factura</th>
                <th>Fecha Factura</th>
                <th>Cliente</th>
                <th>Estado Factura</th>
                <th>Valor Total</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody style="font-weight: normal;"></tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-right">Total:</th>
                <th colspan="2"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>

    <!--Modal mostrar Servicios-->
    <section>
      <div class="modal fade in" id="modalServicios">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form class="form-horizontal" content-type="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-list"></i> Lista de Servicios
                </h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class="table-responsive container-fluid">
                    <table
                      id="tablaServicios"
                      class="table table-bordered table-hover"
                      style="width:100%"
                    >
                      <thead>
                        <tr>
                          <th>Nombre</th>
                          <th>Valor</th>
                          <th>Acción</th>
                        </tr>
                      </thead>
                      <tbody style="font-weight: normal;"></tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                  <i class="fas fa-times"></i> Cancelar
                </button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </section>
    <!--Modal Para realizar Pago Factura-->
    <section>
      <div class="modal fade in" id="modalPagos">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form class="form-horizontal" content-type="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-money"></i> Pagar Factura
                </h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class>
                    <ul class="nav nav-tabs">
                      <li class="active">
                        <a data-toggle="tab" href="#pagoEfectivo">
                          <i class="fas fa-money-bill-wave-alt"></i> Pago Efectivo
                        </a>
                      </li>
                      <li>
                        <a data-toggle="tab" href="#pagoTarjeta">
                          <i class="far fa-credit-card"></i> Pago Tarjeta
                        </a>
                      </li>
                    </ul>
                    <div class="tab-content row">
                      <div id="pagoEfectivo" class="tab-pane fade in active">
                        <div class="box-body">
                          <div class="col-md-6">
                            <div class="box box-primary">
                              <div
                                class="box-body row text-center"
                                style="font-weight: normal; font-size: 22px;"
                              >
                                <div class="col-md-6 col-sm-6">
                                  <strong>Subtotal:</strong>
                                </div>
                                <div
                                  class="col-md-6 col-sm-6"
                                >${{formatearValor(subtotal = calcularSubtotal)}}</div>
                                <div class="col-md-6 col-sm-6">
                                  <strong>Descuento:</strong>
                                </div>
                                <div class="col-md-6 col-sm-6">${{formatearValor(descuento)}}</div>
                                <div class="col-md-6 col-sm-6">
                                  <strong>Total Neto:</strong>
                                </div>
                                <div
                                  class="col-md-6 col-sm-6"
                                >${{formatearValor(valorNeto = calcularNeto)}}</div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="box box-primary">
                              <div class="box-body" style="font-weight: normal; font-size: 22px;">
                                <div class="text-center">
                                  <strong>
                                    <p>Valor Recibido</p>
                                  </strong>
                                  <money
                                    class="form-control input-lg"
                                    v-bind="money"
                                    id="valorR"
                                    v-model="valorRecibido"
                                  >{{valorRecibido}}</money>
                                </div>
                                <div class="text-center">
                                  <strong>
                                    <p>Valor Cambio</p>
                                  </strong>
                                  <p>${{formatearValor(valorRecibido - valorNeto)}}</p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div
                            class="col-md-12 callout callout-danger text-center"
                            v-if="id_caja == 0"
                          >
                            <h4>¡Alerta!</h4>
                            <p>El Usuario Actual no tiene Caja Registradora Asociada, porfavor verificar.</p>
                          </div>
                        </div>
                      </div>
                      <div id="pagoTarjeta" class="tab-pane fade">
                        <div class="box-header"></div>
                        <div class="box-body"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" @click="cerrarModalPago()">
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-default" @click="limpiarPago()">
                  <i class="fas fa-eraser"></i> Limpiar
                </button>
                <button
                  type="button"
                  class="btn btn-success"
                  @click="facturarCargos();"
                  :disabled="valorRecibido < valorNeto || descuento > subtotal || id_caja == 0"
                >
                  <i class="fas fa-shopping-cart"></i> Facturar
                </button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </section>
    <!-- modal para anular factura -->
    <section>
      <div class="modal fade in" id="modalAnularFactura">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-plus-circle"></i> Anular Factura
                </h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class="container-fluid">
                    <div class="form-group text-center">
                      <h4>
                        <strong>Número Factura:</strong>
                        {{num_factura}}
                      </h4>
                      <h4>
                        <strong>Anulado Por:</strong>
                        {{nombre_facturador}}
                      </h4>
                    </div>
                    <div class="form-group">
                      <h4>Motivo de Anulación:</h4>
                      <textarea
                        class="form-control"
                        rows="3"
                        placeholder="Escribe aquí porque anulas la factura"
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
                  @click="cerrarModalAnular();"
                >
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" @click="anularFactura();">
                  <i class="fas fa-check"></i> Anular
                </button>
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
      mostrarDiv: 1,
      id_reserva: "",
      informacionFacturar: [],
      fecha_actual: "",
      nombre_cliente: "",
      nombre_anonimo: "",
      id_facturadopor: "",
      nombre_facturador: "",
      nombre_empresa: "",
      lista_empleados: [],
      subtotal: "",
      descuento: 0,
      valorNeto: "",
      valorRecibido: 0,
      valorCambio: "",
      arrayErrors: [],
      tipo_pago: 1,
      notaFactura: "",
      id_caja: 0,
      id_factura: "",
      num_factura: "",
      motivo_anulacion: "",
      valor_total: 0,
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
  watch: {},
  computed: {
    //calcular el subtotal de la factura
    calcularTotalDescuento: function() {
      var resultado = 0.0;
      for (var i = 0; i < this.informacionFacturar.length; i++) {
        resultado = resultado + this.informacionFacturar[i].valor_descuento;
      }
      return resultado;
    },
    //calcular el subtotal de la factura
    calcularSubtotal: function() {
      var resultado = 0.0;
      for (var i = 0; i < this.informacionFacturar.length; i++) {
        resultado =
          resultado +
          this.informacionFacturar[i].valor_servicio *
            this.informacionFacturar[i].cantidad;
      }
      return resultado;
    },
    /* calcular el totalNeto */
    calcularNeto: function() {
      var resultado = 0.0;
      for (var i = 0; i < this.informacionFacturar.length; i++) {
        resultado =
          resultado +
          this.informacionFacturar[i].valor_servicio *
            this.informacionFacturar[i].cantidad;
      }
      return resultado - this.descuento;
    }
  },
  methods: {
    //listar todas las facturas realizadas en el dia FacturaController
    listarFacturacionDiaria() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaFacturasDiarias = jQuery("#tablaFacturasDiarias").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          //processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [[0, "asc"]],
          ////serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarFacturacionDiaria",
          columns: [
            { data: "num_factura" },
            { data: "fecha_factura" },
            {
              render: function(data, type, row) {
                if (row.nombre_cliente != null) {
                  return row.nombre_cliente;
                } else {
                  return row.nombre_anonimo;
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.estado_factura === "1") {
                  return '<span class="label label-success">Pagada</span>';
                } else if (row.estado_factura === "2") {
                  return '<span class="label label-info">Pago Parcial</span>';
                } else if (row.estado_factura === "3") {
                  return '<span class="label label-warning">Pendiente</span>';
                } else {
                  return '<span class="label label-danger">Anulada</span>';
                }
              }
            },
            {
              data: "valor_total",
              className: "sum",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              render: function(data, type, row) {
                if (row.estado_factura === "1" && row.nomina_id === null) {
                  return `<button style="margin: 1px" type="button" class="btn btn-default imprimir" title="Imprimir Factura">
                            <i class="fas fa-print"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-danger anular" title="Anular Factura">
                            <i class="fas fa-close"></i>
                        </button>`;
                } else if (
                  row.estado_factura === "1" &&
                  row.nomina_id != null
                ) {
                  return `<button style="margin: 1px" type="button" class="btn btn-default imprimir" title="Imprimir Factura">
                            <i class="fas fa-print"></i>
                        </button>  <span class="label label-info">En Nómina</span>`;
                } else if (row.estado_factura === "2") {
                  return `<button style="margin: 1px" type="button" class="btn btn-default imprimir" title="Imprimir Factura">
                            <i class="fas fa-print"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-danger anular" title="Anular Factura">
                            <i class="fas fa-close"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-warning abonarPago" title="Agregar Pago">
                            <i class="fas fa-plus-circle"></i> <i class="fas fa-dollar-sign"></i>
                        </button>`;
                } else if (row.estado_factura === "3") {
                  return `<button style="margin: 1px" type="button" class="btn btn-default imprimir" title="Imprimir Factura">
                            <i class="fas fa-print"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-danger anular" title="Anular Factura">
                            <i class="fas fa-close"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-success pagarFactura" title="Pagar Factura">
                            <i class="fas fa-money-bill-alt"></i>
                        </button>`;
                } else {
                  return `<button style="margin: 1px" type="button" class="btn btn-default imprimir" title="Imprimir Factura">
                            <i class="fas fa-print"></i>
                        </button>`;
                }
              }
            }
          ],
          footerCallback: function(row, data, start, end, display) {
            var api = this.api();
            var numberFormat = jQuery.fn.dataTable.render.number(
              ".",
              ",",
              2,
              "$"
            ).display;
            //sumeme el data que tenga la clase sum
            api.columns(".sum", { page: "current" }).every(function() {
              var sum = this.data().reduce(function(a, b) {
                var x = parseFloat(a) || 0;
                var y = parseFloat(b) || 0;
                return x + y;
              }, 0);
              /* console.log(sum); */
              // Update footer
              $(this.footer()).html(numberFormat(sum));
            });
          }
        });

        //Metodo para anular factura
        tablaFacturasDiarias.on("click", ".anular", function() {
          jQuery.noConflict(); // para evitar errores
          $("#modalAnularFactura").modal("show"); //mostramos la modal
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaFacturasDiarias.row(current_row).data();

          me.id_factura = datos["id_factura"];
          me.num_factura = datos["num_factura"];
          me.valor_total = datos["valor_total"];
          me.id_reserva = datos["id_reserva"];
          if (datos["nombre_cliente"] == null) {
            me.nombre_cliente = datos["nombre_anonimo"];
          } else {
            me.nombre_cliente = datos["nombre_cliente"];
          }
        });
      });
    },
    //listar la caja del Usuario
    infoCajaDiv() {
      let me = this;
      // Make a request for a user with a given ID
      axios
        .get("/infoCajaDiv")
        .then(function(response) {
          me.id_caja = response.data[0].id;
          //console.log(me.lista_empleados);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    //mostrar todos los empleados con Rol Empleado Activos
    listaEmpleados() {
      let me = this;
      // Make a request for a user with a given ID
      axios
        .get("/showEmpleado")
        .then(function(response) {
          me.lista_empleados = response.data;
          //console.log(me.lista_empleados);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    //obtener la informacion de la empresa
    infoEmpresa() {
      let me = this;
      // Make a request for a user with a given ID
      axios
        .get("/mostrar")
        .then(function(response) {
          me.nombre_empresa = response.data[0].nombre_empresa;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    //obtener la informacion del empleado logueado actualmente
    infoFacturador() {
      let me = this;
      // Make a request for a user with a given ID
      axios
        .get("/showPerfil")
        .then(function(response) {
          me.id_facturadopor = response.data[0].id;
          me.nombre_facturador =
            response.data[0].nombre_usuario +
            " " +
            response.data[0].apellido_usuario;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    //metodo para facturar los cargos
    facturarCargos() {
      let me = this;
      if (me.id_caja == 0) {
        Swal.fire({
          position: "top-end",
          title: "El Usuario actual no tiene Caja Registradora!",
          type: "error",
          showConfirmButton: false,
          timer: 3500
        }).then(function() {
          me.cerrarModalPago();
          me.regresar();
        });
      } else {
        axios
          .post("/facturarCargos", {
            informacionFacturar: me.informacionFacturar,
            prefijo: "FV ",
            estado_factura: 1,
            tipo_comprobante: 1,
            tipo_pago: me.tipo_pago,
            descuento: me.descuento,
            valor_total: me.valorNeto,
            nota_factura: me.notaFactura,
            id_reserva: me.id_reserva,
            id_caja: me.id_caja
          })
          .then(function(response) {
            Swal.fire({
              position: "top-end",
              title: "Cargos Facturados con éxito!",
              type: "success",
              showConfirmButton: false,
              timer: 1500
            }).then(function() {
              me.cerrarModalPago();
              me.regresar();
            });
            //console.log(response);
          })
          .catch(function(error) {
            if (error.response.status == 422) {
              //preguntamos si el error es 422
              me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
            }
            console.log(error);
          });
      }
    },
    //aqui tenemos el script para datatables para los que se facturaran
    listarFacturacion() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaFacturacion = jQuery("#tablaFacturacion").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [], //no colocar ordenamiento
          ////serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarFacturacion",
          columns: [
            {
              render: function(data, type, row) {
                if (row.nombre_cliente != null) {
                  return row.nombre_cliente;
                } else {
                  return row.nombre_anonimo;
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.nombre_servicio != null) {
                  return row.nombre_servicio;
                } else {
                  return '<span class="label label-warning">Agregar</span>';
                }
              }
            },
            {
              data: "valor_total",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              render: function(data, type, row) {
                return `<button type="button" class="btn btn-success facturar" title="Facturar Servicio">
                            <i class="fas fa-donate"></i> Facturar
                        </button>`;
              }
            }
          ]
        });
        //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
        tablaFacturacion.on("click", ".facturar", function() {
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaFacturacion.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          me.id_reserva = datos["id_reserva"]; //el id es este q es de datatables o este id es de la consulta cualquiera sirve

          //creamos axios que nos trae la informacion para facturar por id
          axios
            .get("/mostrarInfoFacturar", {
              params: { id_reserva: me.id_reserva }
            })
            .then(function(response) {
              //si todo sale ok capturamos la data de la respuesta de la consulta
              me.informacionFacturar = response.data;
              //aqui mandamos los datos del array a varibles especificas
              me.fecha_actual = response.data[0].fecha_actual;
              me.nombre_cliente = response.data[0].nombre_cliente;
              me.nombre_anonimo = response.data[0].nombre_anonimo;

              //console.log(response);
              //console.log(me.informacionFacturar);
              //para mostrar el div despues de dar en el boton y consultar
              me.mostrarDiv = 2;
              //para borrar el registro del array cuando es anonimo
              if (me.informacionFacturar[0].id_solicitud === null) {
                me.eliminarDetalleAnonimo(0);
                //console.log("borrado");
              }
            })
            .catch(function(error) {
              // handle error
              console.log(error);
            })
            .finally(function() {
              // always executed
            });
        });
      });
    },
    //aqui likstamos los servicios en una tabla
    listarServicios() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaServicios = jQuery("#tablaServicios").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [], //no colocar ordenamiento
          ////serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/serviciosFaturables",
          columns: [
            {
              data: "nombre_servicio"
            },
            {
              data: "valor_servicio",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              render: function(data, type, row) {
                return `<button type="button" class="btn btn-success agregar btn-sm" title="Agregar">
                          <i class="fas fa-plus-circle"></i> Agregar
                        </button>`;
              }
            }
          ]
        });
        //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
        tablaServicios.on("click", ".agregar", function() {
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaServicios.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          //let id_servicio = datos["id"]; //el id es este q es de datatables o este id es de la consulta cualquiera sirve
          me.informacionFacturar.push({
            //llenamos el array con push
            cantidad: "1",
            valor_descuento: "0",
            fecha_actual: me.fecha_actual,
            id_atendido_por: me.lista_empleados[0].id,
            id_reserva: me.id_reserva,
            id_servicio: datos.id,
            id_solicitud: "",
            nombre_anonimo: me.nombre_anonimo,
            nombre_cliente: me.nombre_cliente,
            nombre_servicio: datos.nombre_servicio,
            valor_servicio: datos.valor_servicio
          });
          Swal.fire({
            position: "top-end",
            title: "Agregado con éxito!",
            type: "success",
            showConfirmButton: false,
            timer: 1500
          });
        });
      });
    },
    regresar() {
      let me = this;
      me.mostrarDiv = 1;
      me.listarFacturacion();
      me.listarFacturacionDiaria();
    },
    formatearValor(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    eliminarDetalle(index) {
      let me = this;
      me.informacionFacturar.splice(index, 1); //se usa el metodo splice para borrar el index
      /*Swal.fire({
        position: "top-end",
        title: "Eliminado con éxito!",
        type: "success",
        showConfirmButton: false,
        timer: 1500
      });*/
    },
    eliminarDetalleAnonimo(index) {
      let me = this;
      me.informacionFacturar.splice(index, 1); //se usa el metodo splice para borrar el index
    },
    agregarDetalles() {
      let me = this;

      jQuery.noConflict();
      $("#modalServicios").modal("show");
    },
    //abrimos la modal de pagos
    abrirPagos() {
      let me = this;
      me.valorRecibido = "";
      jQuery.noConflict();
      //para hacer focus en un input de la modal
      $("#modalPagos").on("shown.bs.modal", function() {
        $("#valorR").focus();
      });
      //mostramos la modal
      $("#modalPagos").modal("show");
    },
    cerrarModalPago() {
      $("[data-dismiss=modal]").trigger({ type: "click" });
      this.limpiarPago();
    },
    limpiarPago() {
      let me = this;
      me.valorRecibido = "";
      $("#valorR").focus();
    },
    //anular la factura FacturaController
    anularFactura() {
      let me = this;
      Swal.fire({
        title: "¿Seguro que desea anular la Factura?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "red",
        confirmButtonText: '<i class="fas fa-check"></i> Si',
        cancelButtonText: '<i class="fas fa-times"></i> No'
      }).then(result => {
        if (result.value) {
          axios
            .post("/anularFactura", {
              id_factura: me.id_factura,
              motivo_anulacion: me.motivo_anulacion,
              id_caja: me.id_caja,
              valor_total: me.valor_total,
              id_facturadopor: me.id_facturadopor,
              id_reserva: me.id_reserva,
              nombre_cliente: me.nombre_cliente
            }) //le envio el parametro completo
            .then(function(response) {
              Swal.fire({
                position: "top-end",
                type: "success",
                title: "Factura Anulada con éxito!",
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                jQuery("#tablaFacturasDiarias")
                  .DataTable()
                  .ajax.reload(null, false);
                jQuery("#tablaFacturacion")
                  .DataTable()
                  .ajax.reload();
                me.cerrarModalAnular();
              });
              //console.log(response);
            })
            .catch(function(error) {
              if (error.response.status == 422) {
                //preguntamos si el error es 422
                me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
              }
            });
        }
      });
    },
    cerrarModalAnular() {
      $("[data-dismiss=modal]").trigger({ type: "click" });
      this.id_factura = "";
      this.motivo_anulacion = "";
      this.arrayErrors = [];
    }
  },
  mounted() {
    this.listarFacturacion();
    this.listarFacturacionDiaria();
    this.infoFacturador();
    this.infoEmpresa();
    this.listaEmpleados();
    this.listarServicios();
    this.infoCajaDiv();
  }
};
</script>

<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-university"></i> Nómina
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-university"></i> Nómina
        </li>
      </ol>
    </section>
    <!-- Tabla de los empleados para pagar nomina -->
    <section class="content">
      <br />
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">
            <i class="far fa-list-alt"></i> Liquidación de Nómina
          </h3>
        </div>
        <div class="table-responsive container-fluid">
          <table id="tablaNomina" class="table table-bordered table-hover" style="width:100%">
            <thead>
              <tr>
                <th>Empleado</th>
                <th>Cant. Servicios</th>
                <th>Subtotal Facturado</th>
                <th>Total Descuentos</th>
                <th>Total Realizado</th>
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
    <!-- Tabla de todas los pagos de nomina hechos-->
    <section class="content">
      <br />
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">
            <i class="far fa-list-alt"></i> Lista de Pagos a Empleados
          </h3>
        </div>
        <div class="table-responsive container-fluid">
          <table id="tablaTotalNominas" class="table table-bordered table-hover" style="width:100%">
            <thead>
              <tr>
                <th>#Pago</th>
                <th>Fecha de Pago</th>
                <th>% Pagado</th>
                <th>Valor Pagado</th>
                <th>Pagado A</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody style="font-weight: normal;"></tbody>
          </table>
        </div>
      </div>
    </section>
    <!-- modal para PAGAR NOMINA A EMPLEADO -->
    <section>
      <div class="modal fade in" id="modalPagarNomina">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-plus-circle"></i> Información Nómina
                </h4>
              </div>
              <div class="modal-body">
                <div class="text-right">
                  <h5>
                    <strong>Pagado Por:</strong>
                    {{nombre_realizado}}
                  </h5>
                </div>
                <div class="box box-success">
                  <div class="box-header with-border">
                    <h3 class="box-title">
                      <h4>
                        <strong>Pagado A:</strong>
                        {{nombre_empleado}}
                      </h4>
                      <h5>
                        <strong>Periodo de Pago:</strong>
                        {{minFecha}}
                        <strong>hasta</strong>
                        {{maxFecha}}
                      </h5>
                    </h3>
                  </div>
                  <div class="box-body">
                    <div class="box-body text-center" style="font-weight: normal; font-size: 22px;">
                      <div class="form-group col-md-12">
                        <label>
                          <strong>Valor Servicios:</strong>
                        </label>
                        ${{formatearValor(valor_total_servicios)}}
                      </div>
                      <div class="form-inline form-group col-md-12">
                        <label>
                          <strong>% A Pagar:</strong>
                        </label>
                        <money
                          class="form-control input-lg"
                          v-bind="money"
                          id="valorPorcentaje"
                          v-model="porcentaje_pagado"
                        >{{porcentaje_pagado}}</money>
                      </div>
                      <div class="form-group col-md-12">
                        <label>
                          <strong>Valor A Pagar:</strong>
                        </label>
                        ${{formatearValor(valor_pagado = calcularValorPagar)}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-danger pull-left"
                  @click="cerrarModalNomina();"
                >
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <button
                  type="button"
                  class="btn btn-success"
                  @click="pagarNomina();"
                  :disabled="valor_pagado > valor_total_servicios || valor_pagado == 0"
                >
                  <i class="fas fa-check"></i> Pagar Nómina
                </button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </section>
    <!-- MODAL PARA MOSTRAR LOS SERVICIOS QUE HIZO EL EMPLEADO -->
    <section>
      <div class="modal fade in" id="modalServiciosHechos">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form class="form-horizontal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-list-ul"></i> Lista de Servicios Hechos
                </h4>
              </div>
              <div class="modal-body">
                <div class="box box-success">
                  <div class="box-body table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <!-- <th>Fecha</th> -->
                          <th>Servicio</th>
                          <th>Cantidad</th>
                          <th>Precio</th>
                          <th>Descuento</th>
                          <th>Valor Total</th>
                        </tr>
                      </thead>
                      <tbody style="font-weight: normal;">
                        <tr v-for="listaServices in listaServicioNomina" :key="listaServices.id">
                          <!-- <td>
                            <span>{{listaServices.fecha_servicio}}</span>
                          </td>-->
                          <td>
                            <span>{{listaServices.nombre_servicio}}</span>
                          </td>
                          <td>
                            <span>{{listaServices.cantidad_servicios}}</span>
                          </td>
                          <td>
                            <span>${{formatearValor(listaServices.valor_total_servicios)}}</span>
                          </td>
                          <td>
                            <span>${{formatearValor(listaServices.valor_descuento)}}</span>
                          </td>
                          <td>
                            <span>${{formatearValor(listaServices.valor_total_servicios - listaServices.valor_descuento)}}</span>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="1" align="right">
                            <strong>Totales:</strong>
                          </td>
                          <td>
                            <strong>{{totalCantidades}}</strong>
                          </td>
                          <td>
                            <strong>${{formatearValor(totalServicios)}}</strong>
                          </td>
                          <td>
                            <strong>${{formatearValor(totalDescuentos)}}</strong>
                          </td>
                          <td>
                            <strong>${{formatearValor(totalRealizado)}}</strong>
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
                  <i class="fas fa-times"></i> Cerrar
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
      <div class="modal fade in" id="modalAnularPago">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-plus-circle"></i> Anular Pagos
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
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" @click="anularPago();">
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
import moment from "moment";
export default {
  data() {
    return {
      roles_roles_id: 0,
      realizado_por: 0,
      nombre_realizado: "",
      nombre_empleado: "",
      empleado_id: 0,
      valor_total_servicios: 0,
      porcentaje_pagado: 0,
      valor_pagado: 0,
      minFecha: "",
      maxFecha: "",
      id_caja: "",
      //para usar el vue componente de moneyConcurrente
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "",
        suffix: " %",
        precision: 0,
        masked: false
      },
      id_nomina: "",
      listaServicioNomina: [],
      motivo_anulacion: "",
      arrayErrors: [],
      id_movimiento: 0,
      valor_pagado: 0
    };
  },
  watch: {},
  computed: {
    //calcular el subtotal de la factura
    calcularValorPagar: function() {
      var resultado = 0.0;
      resultado = (this.porcentaje_pagado * this.valor_total_servicios) / 100;

      return resultado;
    },
    //calcular los totales de los servicios
    totalCantidades: function() {
      var resultado = 0;
      for (var i = 0; i < this.listaServicioNomina.length; i++) {
        resultado =
          resultado + parseInt(this.listaServicioNomina[i].cantidad_servicios);
      }
      return resultado;
    },
    //calcular los totales de los servicios
    totalDescuentos: function() {
      var resultado = 0.0;
      for (var i = 0; i < this.listaServicioNomina.length; i++) {
        resultado =
          resultado + parseInt(this.listaServicioNomina[i].valor_descuento);
      }
      return resultado;
    },
    //calcular los totales de los servicios
    totalServicios: function() {
      var resultado = 0.0;
      for (var i = 0; i < this.listaServicioNomina.length; i++) {
        resultado =
          resultado +
          parseInt(this.listaServicioNomina[i].valor_total_servicios);
      }
      return resultado;
    },
    //calcular los totales de los servicios menos el descuento
    totalRealizado: function() {
      var resultado = 0.0;
      for (var i = 0; i < this.listaServicioNomina.length; i++) {
        resultado =
          resultado +
          parseInt(
            this.listaServicioNomina[i].valor_total_servicios -
              this.listaServicioNomina[i].valor_descuento
          );
      }
      return resultado;
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
    //listar todas las facturas realizadas FacturaController
    listarEmpleadosNomina() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaNomina = jQuery("#tablaNomina").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          //processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [[0, "asc"]],
          ////serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarEmpleadosNomina",
          columns: [
            { data: "nombre_empleado" },
            { data: "cantidad_servicios" },
            {
              data: "subtotal_servicios",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              data: "valor_total_descuentos",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              data: "valor_total_servicios",
              className: "sum",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              render: function(data, type, row) {
                return `<button style="margin: 1px" type="button" class="btn btn-success pagarNomina" title="Pagar a Cliente">
                          <i class="fas fa-money-check-alt"></i> Liquidar
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-info verServicios" title="Ver Información">
                          <i class="far fa-eye"></i> Ver
                        </button>`;
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

        //Metodo para llamar modal pagar Nomina
        tablaNomina.on("click", ".pagarNomina", function() {
          jQuery.noConflict(); // para evitar errores
          $("#modalPagarNomina").modal("show"); //mostramos la modal
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaNomina.row(current_row).data();

          me.nombre_empleado = datos["nombre_empleado"];
          me.empleado_id = datos["empleado_id"];
          me.valor_total_servicios = datos["valor_total_servicios"];
          me.minFecha = moment(datos["minFecha"]).format("DD/MM/YYYY hh:mm a");
          me.maxFecha = moment(datos["maxFecha"]).format("DD/MM/YYYY hh:mm a");

          //para enviar el focus al input del porcentaje
          $("#modalPagarNomina").on("shown.bs.modal", function() {
            $("#valorPorcentaje").focus();
          });
        });

        //para mostrar los servicios del empleado que realizo
        //Metodo para llamar modal pagar Nomina
        tablaNomina.on("click", ".verServicios", function() {
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaNomina.row(current_row).data();

          //abrimos la modal de ver los servicios del empleado
          jQuery.noConflict();
          $("#modalServiciosHechos").modal("show");

          me.empleado_id = datos["empleado_id"];
          //envio por axios el id para q me muestre la info de ese empleado
          axios
            .get("/verServiciosLiquidar", {
              params: { empleado_id: me.empleado_id }
            })
            .then(function(response) {
              me.listaServicioNomina = response.data;
            })
            .catch(function(error) {
              // handle error
              console.log(error);
            });
        });
      });
    },
    listarPagosNomina() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaTotalNominas = jQuery("#tablaTotalNominas").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          //processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [[0, "desc"]],
          //serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarPagosNomina",
          columns: [
            { data: "id" },
            { data: "fecha_pago" },
            {
              data: "porcentaje_pagado",
              render: jQuery.fn.dataTable.render.number(",", ".", 0, "", "%")
            },
            {
              data: "valor_pagado",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$")
            },
            { data: "nombre_empleado" },
            {
              render: function(data, type, row) {
                if (row.estado_nomina == 1) {
                  return '<span class="label label-success"> Pagado</span></a>';
                } else {
                  return '<span class="label label-danger"> Cancelado</span></a>';
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.estado_nomina == 1) {
                  return `<button style="margin: 1px" type="button" class="btn btn-info verPago" title="Ver Pago">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-default imprimir" title="Imprimir Pago">
                            <i class="fas fa-print"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-danger cancelar" title="Anular Pago">
                            <i class="fas fa-ban"></i>
                        </button>`;
                } else {
                  return `<button style="margin: 1px" type="button" class="btn btn-info verPago" title="Ver Pago">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button style="margin: 1px" type="button" class="btn btn-default imprimir" title="Imprimir Pago">
                            <i class="fas fa-print"></i>
                        </button>`;
                }
              }
            }
          ]
        });
        //Metodo para llamar modal pagar Nomina
        tablaTotalNominas.on("click", ".cancelar", function() {
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaTotalNominas.row(current_row).data();

          me.id_nomina = datos["id"];
          me.id_movimiento = datos["movimientos_id"];
          me.valor_pagado = datos["valor_pagado"];

          //abrimos la modal para anular el pago que se hizo
          jQuery.noConflict(); // para evitar errores
          $("#modalAnularPago").modal("show"); //mostramos la modal
        });
      });
    },
    //realiar anulacion del pago
    anularPago() {
      let me = this;
      Swal.fire({
        title: "¿Seguro de Anular el Pago?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "red",
        confirmButtonText: '<i class="fas fa-check"></i> Si',
        cancelButtonText: '<i class="fas fa-times"></i> No'
      }).then(result => {
        if (result.value) {
          axios
            .post("/cancelarPago", {
              id_nomina: me.id_nomina,
              id_movimiento: me.id_movimiento,
              id_caja: me.id_caja,
              valor_pagado: me.valor_pagado,
              motivo_anulacion: me.motivo_anulacion
            }) //le envio el parametro completo
            .then(function(response) {
              //actualizamos las tablas
              jQuery("#tablaNomina")
                .DataTable()
                .ajax.reload();
              me.cerrarModalNomina();
              jQuery("#tablaTotalNominas")
                .DataTable()
                .ajax.reload(null, false);
              me.motivo_anulacion = "";
              Swal.fire({
                toast: true,
                position: "top-end",
                type: "success",
                title: "Pago Anulado con éxito!",
                showConfirmButton: false,
                timer: 2500
              }).then(function() {});
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
    //realizar pago de nomina del empleado
    pagarNomina() {
      let me = this;
      Swal.fire({
        title: "¿Seguro de Pagar Nómina?",
        html:
          "<strong>Empleado: </strong>" +
          me.nombre_empleado +
          "<br><strong>Valor a Pagar:</strong> $" +
          this.formatearValor(me.valor_pagado) +
          "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "green",
        cancelButtonColor: "red",
        confirmButtonText: '<i class="fas fa-check"></i> Si',
        cancelButtonText: '<i class="fas fa-times"></i> No'
      }).then(result => {
        if (result.value) {
          axios
            .post("/pagarNomina", {
              empleado_id: me.empleado_id,
              id_caja: me.id_caja,
              valor_pagado: me.valor_pagado,
              porcentaje_pagado: me.porcentaje_pagado,
              valor_total_servicios: me.valor_total_servicios
            }) //le envio el parametro completo
            .then(function(response) {
              jQuery("#tablaNomina")
                .DataTable()
                .ajax.reload(null, false);
              me.cerrarModalNomina();
              jQuery("#tablaTotalNominas")
                .DataTable()
                .ajax.reload();
              Swal.fire({
                toast: true,
                position: "top-end",
                type: "success",
                title: "Pago registrado con éxito!",
                showConfirmButton: false,
                timer: 2500
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
    //obtener la informacion del empleado logueado actualmente
    infoRealizadoPor() {
      let me = this;
      // Make a request for a user with a given ID
      axios
        .get("/showPerfil")
        .then(function(response) {
          me.realizado_por = response.data[0].id;
          me.nombre_realizado =
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
    formatearValor(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    cerrarModalNomina() {
      $("[data-dismiss=modal]").trigger({ type: "click" });
      this.porcentaje_pagado = 0;
    },
    formatearValor(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
  },
  mounted() {
    this.rol();
    this.listarEmpleadosNomina();
    this.infoRealizadoPor();
    this.infoCajaDiv();
    this.listarPagosNomina();
  }
};
</script>

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
    <!-- Tabla de todas als facturas -->
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
                <th>Valor Total Servicios</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody style="font-weight: normal;"></tbody>
            <tfoot>
              <tr>
                <th colspan="2" class="text-right">Total:</th>
                <th colspan="2"></th>
              </tr>
            </tfoot>
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
                      <form class="form-inline">
                        <div class="form-group col-md-12">
                          <label>
                            <strong>Valor Servicios:</strong>
                          </label>
                          ${{formatearValor(valor_total_servicios)}}
                        </div>
                        <div class="form-group col-md-12">
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
                      </form>
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
  </div>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      realizado_por: 0,
      nombre_realizado: "",
      nombre_empleado: "",
      empleado_id: 0,
      valor_total_servicios: 0,
      porcentaje_pagado: 0,
      valor_pagado: 0,
      minFecha: "",
      maxFecha: "",
      //para usar el vue componente de moneyConcurrente
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "",
        suffix: " %",
        precision: 0,
        masked: false
      }
    };
  },
  watch: {},
  computed: {
    //calcular el subtotal de la factura
    calcularValorPagar: function() {
      var resultado = 0.0;
      resultado = (this.porcentaje_pagado * this.valor_total_servicios) / 100;

      return resultado;
    }
  },
  methods: {
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
          //serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarEmpleadosNomina",
          columns: [
            { data: "nombre_empleado" },
            { data: "cantidad_servicios" },
            {
              data: "valor_total_servicios",
              className: "sum",
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$ ")
            },
            {
              render: function(data, type, row) {
                return `<button style="margin: 1px" type="button" class="btn btn-success pagarNomina" title="Pagar a Cliente">
                            <i class="fas fa-money-check-alt"></i> Liquidar
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
              "$ "
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
              empleado_id: me.empleado_id
            }) //le envio el parametro completo
            .then(function(response) {
              Swal.fire({
                position: "top-end",
                type: "success",
                title: "Pago registrado con éxito!",
                showConfirmButton: false,
                timer: 1500
              }).then(function() {
                me.cerrarModalNomina();
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
    }
  },
  mounted() {
    this.listarEmpleadosNomina();
    this.infoRealizadoPor();
  }
};
</script>

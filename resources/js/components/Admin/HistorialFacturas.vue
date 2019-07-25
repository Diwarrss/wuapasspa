<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-file-invoice"></i> Facturas
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-file-invoice"></i> Facturas
        </li>
      </ol>
    </section>
    <!-- Tabla de todas als facturas -->
    <section class="content">
      <div>
        <a type="button" class="btn btn-primary" href="/admin#/facturarAtencion">
          <i class="fas fa-plus-circle"></i> Nueva Factura
        </a>
      </div>
      <br />
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">
            <i class="far fa-list-alt"></i> Lista de Facturas
          </h3>
        </div>
        <div class="table-responsive container-fluid">
          <table
            id="tablaHistorialFacturas"
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
      id_facturadopor: "",
      nombre_facturador: "",
      id_caja: 0,
      id_factura: "",
      num_factura: "",
      motivo_anulacion: "",
      valor_total: 0,
      id_reserva: "",
      arrayErrors: [],
      nombre_cliente: ""
    };
  },
  methods: {
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
    //listar todas las facturas realizadas FacturaController
    historialFacturas() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaHistorialFacturas = jQuery(
          "#tablaHistorialFacturas"
        ).DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          //processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [[0, "asc"]],
          serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/historialFacturas",
          columns: [
            { data: "num_factura" },
            { data: "fecha_factura" },
            {
              render: function(data, type, row) {
                if (row.nombre_cliente != null) {
                  return row.nombre_cliente;
                } else if (row.nombre_anonimo != null) {
                  return row.nombre_anonimo;
                } else {
                  return row.nomCliente_anulada;
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.estado_factura === "1" && row.nomina_id === null) {
                  return '<span class="label label-success">Pagada</span>';
                } else if (
                  row.estado_factura === "1" &&
                  row.nomina_id != null
                ) {
                  return '<span class="label label-success">Pagada</span> <span class="label label-info">En Nómina</span>';
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
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$ ")
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
                        </button>`;
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

        //Metodo para anular factura
        tablaHistorialFacturas.on("click", ".anular", function() {
          jQuery.noConflict(); // para evitar errores
          $("#modalAnularFactura").modal("show"); //mostramos la modal
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaHistorialFacturas.row(current_row).data();

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
                jQuery("#tablaHistorialFacturas")
                  .DataTable()
                  .ajax.reload(null, false);
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
    this.historialFacturas();
    this.infoFacturador();
    this.infoCajaDiv();
  }
};
</script>

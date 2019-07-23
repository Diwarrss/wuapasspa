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
                <th>Valor Total</th>
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
  </div>
</template>
<script>
export default {
  data() {
    return {};
  },
  watch: {},
  computed: {},
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
      });
    }
  },
  mounted() {
    this.listarEmpleadosNomina();
  }
};
</script>

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
        <div class="box-header"></div>
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
        <button type="button" class="btn btn-info" @click="regresar()">
          <i class="fas fa-reply"></i> Regresar
        </button>
      </div>
      <br />
      <div class="box box-primary">
        <div class="box-header">
          <h1>PARA LA FACTURACION</h1>
        </div>
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
      informacionFacturar: []
    };
  },
  watch: {},
  methods: {
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
          serverSide: true, //Lado servidor activar o no mas de 20000 registros
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
              render: jQuery.fn.dataTable.render.number(".", ",", 2, "$ ")
            },
            {
              render: function(data, type, row) {
                return `<button type="button" class="btn btn-success btn-sm facturar" title="Facturar Servicio">
                            <i class="fas fa-donate"></i> Facturar
                        </button>`;
              }
            }
          ]
        });
        //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
        tablaFacturacion.on("click", ".facturar", function() {
          me.mostrarDiv = 2;
          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var data = tablaFacturacion.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          me.id_reserva = data["id_reserva"]; //el id es este q es de datatables o este id es de la consulta cualquiera sirve

          //creamos axios que nos trae la informacion para facturar por id
          axios
            .get("/mostrarInfoFacturar", {
              params: { id_reserva: me.id_reserva }
            })
            .then(function(response) {
              //si todo sale ok capturamos la data de la respuesta de la consulta
              me.informacionFacturar = data;
              console.log(response);
              console.log(me.informacionFacturar);
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
    regresar() {
      let me = this;
      me.mostrarDiv = 1;
      me.listarFacturacion();
    }
  },
  mounted() {
    this.listarFacturacion();
  }
};
</script>

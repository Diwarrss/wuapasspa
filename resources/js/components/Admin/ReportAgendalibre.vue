<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fas fa-user-plus"></i> Agenda Libre
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fas fa-user-plus"></i> Agenda Libre
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title">
            <i class="far fa-list-alt"></i> Agendas Libres
          </h3>
        </div>
        <div class="table-responsive container-fluid">
          <table id="tablaAgendasL" class="table table-bordered table-hover" style="width:100%">
            <thead>
              <tr>
                <th>Cliente</th>
                <th>Fecha Cita</th>
                <th>Nota</th>
                <th>WhatsApp</th>
                <th>Estado</th>
              </tr>
            </thead>
            <tbody style="font-weight: normal;"></tbody>
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
  methods: {
    listarAgeAnonima() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaAgendasL = jQuery("#tablaAgendasL").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
          responsive: true,
          order: [], //no colocar ordenamiento
          //"order": [[ 0, "asc" ]],
          //serverSide: true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarTotalAnonimas",
          columns: [
            { data: "nombre_completo_cliente" },
            { data: "fecha_reserva" },
            { data: "notas" },
            {
              render: function(data, type, row) {
                return (
                  '<a href="https://wa.me/57' +
                  row.celular +
                  "?text=Hola, " +
                  row.nombre_completo_cliente +
                  ", Tu Cita en Wuapas Spa es el " +
                  row.fecha_reserva +
                  '. Responde Confirmar o Cancelar, muchas gracias" target="_blank" title="Enviar Mensaje"><i class="fab fa-whatsapp text-green"></i> ' +
                  row.celular +
                  ' <span class="label label-success"> Enviar</span></a>'
                );
              }
            },
            {
              render: function(data, type, row) {
                if (row.estado_reservacion_nombre === "En Espera") {
                  return (
                    '<span class="label label-warning">' +
                    row.estado_reservacion_nombre +
                    "</span>"
                  );
                } else if (row.estado_reservacion_nombre === "No Asistió") {
                  return (
                    '<span class="label label-danger">' +
                    row.estado_reservacion_nombre +
                    "</span>"
                  );
                } else if (row.estado_reservacion_nombre === "Atendido") {
                  return (
                    '<span class="label label-success">' +
                    row.estado_reservacion_nombre +
                    "</span>"
                  );
                } else if (row.estado_reservacion_nombre === "Cancelo") {
                  return (
                    '<span class="label label-default">' +
                    row.estado_reservacion_nombre +
                    "</span>"
                  );
                } else if (row.estado_reservacion_nombre === "Por Confirmar") {
                  return (
                    '<span class="label label-info">' +
                    row.estado_reservacion_nombre +
                    "</span>"
                  );
                }
              }
            }
          ]
        });
      });
    }
  },
  mounted() {
    this.listarAgeAnonima();
  }
};
</script>

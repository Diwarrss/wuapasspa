<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-calendar-check-o"></i> Agendar Libre
        <small>Información</small>
        <a
          href="/admin#/horarioCitas"
          type="button"
          class="btn btn-success btn-lg"
          title="Ver Horarios de Empleados"
        >
          <i class="fas fa-user-clock"></i> Horarios
        </a>
        <a
          href="/admin#/facturarAtencion"
          type="button"
          class="btn btn-primary btn-lg"
          title="Facturar Citas"
        >
          <i class="fas fa-user-clock"></i> Facturación
        </a>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-calendar-check-o"></i> Agendar Libre
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-5">
          <div class="box box-success">
            <div class="box-header text-center">
              <h4 class="box-title">
                <i class="fas fa-user-tie"></i> Seleccione Empleado:
              </h4>
              <div class="form-group">
                <div class="container-fluid">
                  <!-- <select class="form-control" id="empleado" v-model="idEmpleadoElegido">
                                            <option disabled value="999">Escoge tu Empleado</option>
                                            <option v-for="empleado in empleados" :key="empleado.id" v-bind:value="empleado.id">
                                                {{ empleado.nombre}}
                                            </option>
                  </select>-->
                  <button
                    style="margin: 3px"
                    class="btn btn-primary"
                    type="button"
                    v-for="empleado in empleados"
                    :key="empleado.id"
                    v-bind:value="empleado.id"
                    @click="idEmpleadoElegido = empleado.id, nombreEmpleado= empleado.nombre"
                  >
                    <i class="fas fa-user-check"></i>
                    {{empleado.nombre}}
                  </button>
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="col-md-12 text-center" v-if="nombreEmpleado != ''">
              <h3>
                <strong>Horario de:</strong>
                {{nombreEmpleado}}
              </h3>
            </div>
            <vue-scheduler
              v-if="idEmpleadoElegido!='999'"
              :event-dialog-config="dialogConfig"
              :min-date="null"
              :max-date="null"
              :labels="{
                                today: 'Hoy',
                                back: 'Atrás',
                                next: 'Siguiente',
                                month: 'Mes',
                                week: 'Semana',
                                day: 'Día',
                                all_day: 'Todo el día'
                            }"
              :time-range="[7,21]"
              :available-views="['month', 'week', 'day']"
              :initial-date="dateInit"
              initial-view="day"
              :use12="true"
              :show-time-marker="showMarker"
              :show-today-button="false"
              :events="objetodeCitas"
              :event-display="mostrarComentariosAgenda"
              :disable-dialog="false"
              @event-created="guardarReservacion"
              @event-clicked="cancelarReservacion"
            />
            <br />
          </div>
        </div>
        <div class="col-md-7">
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
  </div>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      roles_roles_id: 0,
      idReserva: 0,
      dateInit: moment(),
      showMarker: false,
      objetodeCitas: [],
      empleados: [],
      idEmpleadoElegido: "999",
      nombreEmpleado: "",
      dialogConfig: {
        fields: [
          {
            fields: [
              {
                name: "nombre",
                label: "Nombre",
                required: true
              },
              {
                name: "telefono",
                label: "Celular",
                required: true,
                type: "text"
              }
            ]
          },
          {
            name: "notas",
            label: "Notas",
            required: false
          }
        ]
      }
    };
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
    listarReservaciones(sheluderXEmpelado) {
      var data = this;
      axios
        .get("/listarTodo", {
          params: {
            empleadoID: sheluderXEmpelado
          }
        })
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data);
          data.objetodeCitas = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    mostrarComentariosAgenda(objetoCitaEvento) {
      return (
        "Cliente: " +
        objetoCitaEvento.nombre_completo_cliente +
        ", " +
        objetoCitaEvento.estado_reservacion_nombre
      );
    },
    listarEmpleados() {
      var data = this;
      axios
        .get("/showEmpleado")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data);
          data.empleados = response.data;
          data.idEmpleadoElegido = data.empleados[0].id;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    listarAgeAnonima() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      var data = this;
      jQuery(document).ready(function() {
        var tablaAgendasL = jQuery("#tablaAgendasL").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [], //no colocar ordenamiento
          //"order": [[ 0, "asc" ]],
          //"serverSide": true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/listarAnonimas",
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
                } else if (row.estado_reservacion_nombre === "Por Confirmar") {
                  return (
                    '<span class="label label-info">' +
                    row.estado_reservacion_nombre +
                    "</span>"
                  );
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.estado_reservacion_nombre === "En Espera") {
                  return `<button type="button" style="margin: 1px" class="btn btn-success btn-sm atendido" title="Atendido">
                                                <i class="fas fa-calendar-check"></i> Atentido
                                            </button>
                                            <button type="button" style="margin: 1px" class="btn btn-warning btn-sm noasistio" title="No Asistió">
                                                <i class="far fa-calendar-times"></i> No Asistió
                                            </button>
                                            <button type="button" style="margin: 1px" class="btn btn-danger btn-sm cancelarR" title="Cancelar Solicitud" style="margin-top: 1px">
                                                <i class="far fa-trash-alt"></i> Cancelar
                                            </button>`;
                } else {
                  return '<span class="label label-info">Ninguna</span>';
                }
              }
            }
          ]
        });
        //para marcar como atendido el cliente
        tablaAgendasL.on("click", ".atendido", function() {
          jQuery.noConflict(); // para evitar errores
          //para si es responsivo obtenemos la data
          var current_row = jQuery(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaAgendasL.row(current_row).data();
          //console.log(datos);

          me.idReserva = datos["id"]; //capturamos el id para enviarlo por put en el metodo

          Swal.fire({
            title: "Esta seguro de que el Cliente Asistió",
            text: "Una vez marcado si, queda como Atendido.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "green",
            cancelButtonColor: "red",
            confirmButtonText: '<i class="fas fa-check"></i> Si',
            cancelButtonText: '<i class="fas fa-times"></i> No'
          }).then(result => {
            if (result.value) {
              // /cancelarReservacion
              axios
                .put("/clienteAsistio", {
                  id: me.idReserva
                })
                .then(function(response) {
                  Swal.fire({
                    position: "top-end",
                    type: "success",
                    title: "Atendido!",
                    showConfirmButton: false,
                    timer: 1500
                  });
                  //codigo para solo actualizar la fila que se esta llamando
                  jQuery("#tablaAgendasL")
                    .DataTable()
                    .ajax.reload(null, false);
                  data.listarReservaciones(data.idEmpleadoElegido);
                })
                .catch(function(error) {
                  if (error.response.status == 422) {
                    //preguntamos si el error es 422
                    Swal.fire({
                      position: "top-end",
                      type: "error",
                      title: "Se produjo un Error, Reintentar",
                      showConfirmButton: false,
                      timer: 1500
                    });
                  }
                  console.log(error.response.data.errors);
                });
            }
          });
        });
        //para marcar como no asistio el cliente
        tablaAgendasL.on("click", ".noasistio", function() {
          jQuery.noConflict(); // para evitar errores
          //para si es responsivo obtenemos la data
          var current_row = jQuery(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaAgendasL.row(current_row).data();
          //console.log(datos);

          me.idReserva = datos["id"]; //capturamos el id para enviarlo por put en el metodo
          Swal.fire({
            title: "Esta seguro de que el Cliente NO Asistió",
            text: "Una vez marcado si, queda como NO Atendido.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "green",
            cancelButtonColor: "red",
            confirmButtonText: '<i class="fas fa-check"></i> Si',
            cancelButtonText: '<i class="fas fa-times"></i> No'
          }).then(result => {
            if (result.value) {
              axios
                .put("/clienteNoAsistio", {
                  id: me.idReserva
                })
                .then(function(response) {
                  Swal.fire({
                    position: "top-end",
                    type: "success",
                    title: "No Asistió!",
                    showConfirmButton: false,
                    timer: 1500
                  });
                  jQuery("#tablaAgendasL")
                    .DataTable()
                    .ajax.reload(null, false);
                  data.listarReservaciones(data.idEmpleadoElegido);
                })
                .catch(function(error) {
                  if (error.response.status == 422) {
                    //preguntamos si el error es 422
                    Swal.fire({
                      position: "top-end",
                      type: "error",
                      title: "Se produjo un Error, Reintentar",
                      showConfirmButton: false,
                      timer: 1500
                    });
                  }
                  console.log(error.response.data.errors);
                });
            }
          });
        });
        //para cancelar la Reservacion
        tablaAgendasL.on("click", ".cancelarR", function() {
          jQuery.noConflict(); // para evitar errores
          //para si es responsivo obtenemos la data
          var current_row = jQuery(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var datos = tablaAgendasL.row(current_row).data();
          //console.log(datos);

          me.id = datos["id"]; //capturamos el id para enviarlo por put en el metodo
          Swal.fire({
            title: "Esta Seguro de Cancelar la Reservación?",
            text: "Una vez Cancelada la Reservación debera agendar una nueva.",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "green",
            cancelButtonColor: "red",
            confirmButtonText: '<i class="fas fa-check"></i> Si',
            cancelButtonText: '<i class="fas fa-times"></i> No'
          }).then(result => {
            if (result.value) {
              // /cancelarReservacion
              axios
                .put("/cancelarReservaciones", {
                  id: me.id
                })
                .then(function(response) {
                  Swal.fire({
                    position: "top-end",
                    type: "success",
                    title: "Cita Cancelada!",
                    showConfirmButton: false,
                    timer: 1500
                  });
                  //data.cantidadAgendadas();
                  jQuery("#tablaAgendasL")
                    .DataTable()
                    .ajax.reload(null, false);
                  data.listarReservaciones(data.idEmpleadoElegido);
                })
                .catch(function(error) {
                  if (error.response.status == 422) {
                    //preguntamos si el error es 422
                    Swal.fire({
                      position: "top-end",
                      type: "error",
                      title: "Se produjo un Error, Reintentar",
                      showConfirmButton: false,
                      timer: 1500
                    });
                  }
                  console.log(error.response.data.errors);
                });
            }
          });
        });
      });
    },
    guardarReservacion(event) {
      var data = this;
      axios
        .post("/storeReservacionesA", {
          nombre_anonimo: event.nombre,
          celular_anonimo: event.telefono,
          notas_anonimo: event.notas,
          users_users_id: data.idEmpleadoElegido, //este seria el peluquero
          fechaHoraInicio_reserva: moment(event.date)
            .add(moment.duration(event.startTime, "HH:mm"), "ms")
            .format("YYYY-MM-DD HH:mm:ss"),
          fechaHoraFinal_reserva: moment(event.date)
            .add(moment.duration(event.endTime, "HH:mm"), "ms")
            .format("YYYY-MM-DD HH:mm:ss")
        })
        .then(function(response) {
          //mesaje exito y lo redirecciona a la pagina de la solicitudes hechas
          Swal.fire({
            position: "top-end",
            title: "Solicitud Reservada con éxito!",
            type: "success",
            showConfirmButton: false,
            timer: 1500
          });
          // .then(function(){
          //     window.location.href = "/admin";
          // });
          jQuery("#tablaAgendasL")
            .DataTable()
            .ajax.reload();
          data.listarReservaciones(data.idEmpleadoElegido); //refrescar todos los datos para el empleado seleccionado
          //console.log(event);
        })
        .catch(function(error) {
          // if (error.response.status == 422) {//preguntamos si el error es 422
          //     data.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
          // }
          console.log(error);
        });
    },
    cancelarReservacion(event) {
      var data = this;

      // no se puede cancelar cuando la reservacion esta en los siguiente estados
      // ATENTIDO = 2;
      // NOASISTIO = 3;
      if (
        event.estado_reservacion === "2" ||
        event.estado_reservacion === "3"
      ) {
        Swal.fire({
          type: "info",
          title: "Información",
          html:
            "<strong>Horario: </strong>" +
            event.startTime +
            " a " +
            event.endTime +
            "",
          confirmButtonText: '<i class="fas fa-check"></i> Entendido'
        });
      } else {
        Swal.fire({
          title: "Esta Seguro de Cancelar la Reservación?",
          text: "Una vez Cancelada la Reservacion debera agendar una nueva.",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "green",
          cancelButtonColor: "red",
          confirmButtonText: '<i class="fas fa-check"></i> Si',
          cancelButtonText: '<i class="fas fa-times"></i> No'
        }).then(result => {
          if (result.value) {
            // /cancelarReservacion
            axios
              .put("/cancelarReservaciones", {
                id: event.id
              })
              .then(function(response) {
                Swal.fire("Cita Cancelada!", "", "success");
                jQuery("#tablaAgendasL")
                  .DataTable()
                  .ajax.reload();
                data.listarReservaciones(data.idEmpleadoElegido); //refrescar todos los datos para el empleado seleccionado
              })
              .catch(function(error) {
                if (error.response.status == 422) {
                  //preguntamos si el error es 422
                  Swal.fire(
                    "Se produjo un Error",
                    "Por favor intentalo mas tarde",
                    "error"
                  );
                }
                console.log(error.response.data.errors);
              });
          }
        });
      }
    }
  },
  watch: {
    //apenas se sellecciona un peluqero que actualize los datos
    idEmpleadoElegido: function() {
      var data = this;
      data.listarReservaciones(data.idEmpleadoElegido);
    }
  },
  mounted() {
    this.rol();
    //this.listarReservaciones();
    this.listarEmpleados();
    this.listarAgeAnonima();
  }
};
</script>

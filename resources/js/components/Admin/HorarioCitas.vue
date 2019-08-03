<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-user-clock"></i> Horarios Agendas
        <small>Empleados</small>
        <a
          href="/admin#/agendaLibre"
          type="button"
          class="btn btn-info btn-lg"
          title="Agendar Citas"
        >
          <i class="far fa-calendar-plus"></i> Agendar
        </a>
        <a
          href="/admin#/agendaEnEspera"
          type="button"
          class="btn btn-primary btn-lg"
          title="Agendar Citas"
        >
          <i class="fas fa-hourglass-half"></i> Clientes En Espera
        </a>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-user-clock"></i> Horarios Agendas
        </li>
      </ol>
    </section>
    <section class="content" v-if="objetodeCitas.length >= 0">
      <div class="row">
        <div v-for="objetoCita of objetodeCitas" :key="objetoCita.id">
          <div class="col-md-4 col-sm-6 col-lg-4">
            <div class="box box-success">
              <div class="box-header text-center">
                <label for="empleado">
                  <i class="fas fa-user-tie"></i>
                  <strong>Empleado:</strong>
                </label>
                <h4>{{objetoCita.nombre}}</h4>
              </div>
            </div>
            <div>
              <vue-scheduler
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
                :events="objetoCita.reservas"
                :event-display="mostrarComentariosAgenda"
                :disable-dialog="true"
                @event-created="guardarReservacion"
                @event-clicked="cancelarReservacion"
                @time-clicked="timeClicked"
              />
              <br />
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
    listarReservaciones() {
      var data = this;
      axios
        .get("/listarTodoHorarios")
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
    timeClicked(dateWithTime) {
      console.log("Time clicked");
      console.log("Date: " + dateWithTime.date);
      console.log("Time: " + dateWithTime.time);
    },
    mostrarComentariosAgenda(objetoCitaEvento) {
      return (
        "Cliente: " +
        objetoCitaEvento.nombre_completo_cliente +
        ", " +
        objetoCitaEvento.estado_reservacion_nombre
      );
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
            toast: true,
            position: "top-end",
            title: "Solicitud Reservada con éxito!",
            type: "success",
            showConfirmButton: false,
            timer: 2500
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
  mounted() {
    this.rol();
    //this.listarReservaciones();
    this.listarReservaciones();
  }
};
</script>

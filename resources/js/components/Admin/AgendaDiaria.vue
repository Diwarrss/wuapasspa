<template>
  <vue-scheduler
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
    :time-range="[5,22]"
    :available-views="['month', 'day']"
    :initial-date="dateInit"
    initial-view="day"
    :use12="true"
    :show-time-marker="false"
    :show-today-button="false"
    :events="citasAgendadas"
    :event-display="mostrarComentariosAgenda"
    :disable-dialog="true"
    @event-clicked="masInformacion"
  />
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      dateInit: moment(),
      citasAgendadas: []
    };
  },
  methods: {
    listarCitasAgendadas() {
      var data = this;
      axios
        .get("/agendaDiaria")
        .then(function(response) {
          data.citasAgendadas = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    mostrarComentariosAgenda(objetoCitaEvento) {
      return (
        "Cliente: " +
        objetoCitaEvento.nombre_cliente +
        "  Agendado Con: " +
        objetoCitaEvento.nombre_completo_empleado
      );
    },
    masInformacion(event) {
      var data = this;
      Swal.fire({
        type: "info",
        title: "Cliente: " + event.nombre_cliente,
        html:
          "Agendado A: <strong>" +
          event.nombre_completo_empleado +
          "</strong></br>" +
          "El Día: <strong>" +
          event.fecha_reserva +
          "</strong></br>" +
          "Estado: <strong>" +
          event.estado_reservaciones_nombre +
          "</strong>",
        confirmButtonText: '<i class="fas fa-check"></i> Entendido'
      });
    }
  },
  mounted() {
    this.listarCitasAgendadas();
  }
};
</script>

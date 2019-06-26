<template>
    <div class="content-wrapper">
       <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-calendar-alt"></i> Reservaciones <small>Atender</small>
            </h1>
        </section>
         <section class="content">
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
                            :time-range="[8,19]"
                            :available-views="['month', 'week', 'day']"
                            :initial-date="dateInit"
                            initial-view="day"
                            :use12="true"
                            :show-time-marker="showMarker"
                            :show-today-button="false"
                            :events="objetodeCitas"
                            :event-display="mostrarComentariosAgenda"
                            :disable-dialog="true"

                            @event-clicked="cancelarReservacion"
                        />
        </section>
    </div>
</template>
<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                id: '',
                solicitudId: '',
                cantidad: 0,
                showMarker:false,
                dateInit: moment(),
                empleados: [],
                objetodeCitas: [],
                reservacionDT: [],

            }
        },
        methods: {
            listarReservaciones(){
                var data = this;
                axios.get('/showReservacionesSheluder').then(function (response) {
                    //console.log(response.data);
                    data.objetodeCitas=response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            mostrarComentariosAgenda(objetodeCitas) {
                return objetodeCitas.nombre_completo_cliente
                + ' - ' +  objetodeCitas.estado_reservacion_nombre;
            },
            cancelarReservacion(event){
                var data = this;

                // no se puede cancelar cuando la reservacion esta en los siguiente estados
                // ATENTIDO = 2;
                // NOASISTIO = 3;
                if(event.estado_reservacion ==='2' || event.estado_reservacion ==='3'){
                        Swal.fire({
                        type: 'info',
                        title: 'Información',
                        text: 'Cita Atendida o No Asistió',
                        confirmButtonText: '<i class="fas fa-check"></i> Entendido',
                    });
                }
                else{
                     Swal.fire({
                        title: 'El Cliente '+event.nombre_completo_cliente+' Asistió?',
                        text: "Su selección no sera modificada.",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: 'green',
                        cancelButtonColor: 'red',
                        confirmButtonText: '<i class="fas fa-check"></i> Si',
                        cancelButtonText: '<i class="fas fa-times"></i> No'
                        }).then((result) => {
                        if (result.value) {
                            // /cancelarReservacion
                            axios.put('/clienteAsistio', {
                                id: event.id
                            }).then(function (response) {
                                Swal.fire(
                                    'Cita Atendida!',
                                    '',
                                    'success'
                                    );
                                    data.listarReservaciones();//refrescar todos los datos
                            })
                            .catch(function (error) {
                                if (error.response.status == 422) {//preguntamos si el error es 422
                                    Swal.fire(
                                    'Se produjo un Error',
                                    'Por favor intentalo mas tarde',
                                    'error'
                                    );
                                }
                                console.log(error.response.data.errors);
                            });
                        }
                        else if (result.dismiss === Swal.DismissReason.cancel) {
                            axios.put('/clienteNoAsistio', {
                                id: event.id
                            }).then(function (response) {
                                Swal.fire(
                                    'Cliente no Asistió',
                                    '',
                                    'success'
                                    );
                                    data.listarReservaciones();//refrescar todos los datos
                            })
                            .catch(function (error) {
                                if (error.response.status == 422) {//preguntamos si el error es 422
                                    Swal.fire(
                                    'Se produjo un Error',
                                    'Por favor intentalo mas tarde',
                                    'error'
                                    );
                                }
                                console.log(error.response.data.errors);
                            });
                        }
                    });
                }


            },
        },
        mounted() {
            this.listarReservaciones();
        }
    }
</script>

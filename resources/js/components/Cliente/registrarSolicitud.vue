<template>
    <div class="container-fluid col-md-5 mx-auto py-4">
        <div class="card">
            <div class="card-header">
                <div class="col-md-12 text-center">
                    <h5><i class="far fa-calendar-plus"></i> Solicitar Cita</h5>
                </div>
            </div>
            <div class="card-body">
                <form>
                    <!-- https://stackoverflow.com/questions/39947030/display-data-from-selected-option-from-vue-component -->
                    <div class="form-group">
                        <label for="servicios"><strong><i class="fas fa-clipboard-list"></i> Elije tus Servicios</strong></label>
                        <select class="custom-select mr-sm-2" id="servicios" v-model="servicioSeleccionado" multiple size="5">
                            <option v-for="servicio in servicios" v-bind:key="servicio.id" v-bind:value="servicio.id">
                                {{ servicio.nombre_servicio }}
                            </option>
                        </select>
                        <p class="text-danger" v-if="arrayErrors.servicios" v-text="arrayErrors.servicios[0]"></p>
                    </div>
                    <div class="form-group">
                        <label for="fecha_probable"><strong><i class="far fa-clock"></i> Fecha y hora que prefieres</strong></label>
                            <datetime v-model="fecha_probable" type="datetime" :phrases="{ok: 'Continuar', cancel: 'Cancelar'}"
                                format="dd/MM/yyyy HH:mm:ss" value-zone="America/Bogota" input-id="fecha_probable" use12-hour input-class="form-control" readonly>
                            </datetime>
                        <p class="text-danger" v-if="arrayErrors.fecha_probable" v-text="arrayErrors.fecha_probable[0]"></p>
                    </div>
                    <div class="form-group">
                        <label for="comentario"><strong><i class="far fa-comment-alt"></i> Nota adicional</strong></label>
                        <textarea class="form-control" id="comentario"
                        placeholder="Agrega una nota adicional" v-model="comentario" rows="3"></textarea>
                        <p class="text-danger" v-if="arrayErrors.comentario" v-text="arrayErrors.comentario[0]"></p>
                    </div>
                    <button type="button" class="btn btn-success" v-on:click="guardar"><i class="fas fa-check"></i> Solicitar</button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                servicios : [],
                servicioSeleccionado: ["1"],
                arrayErrors: [],
                fecha_probable: '',
                comentario:''
            }
        },
        //watch apenas cambie la data de nota_adicional o fecha_probable ejecuta el codigo :P
        watch: {
            comentario: function () {
                var data = this;
                 if (data.arrayErrors.comentario && data.comentario !=='') {
                     delete data.arrayErrors.comentario;
                 }
            },
            fecha_probable: function () {
                var data = this;
                 if (data.arrayErrors.fecha_probable && data.fecha_probable !=='') {
                     delete data.arrayErrors.fecha_probable;
                 }
            }
        },
        methods: {
            listarServicios(){
                var data = this;
                axios.get('/listarServicios').then(function (response) {
                    // data.fechaprobable=response.data[0].fechaprobable;
                    // data.comentario=response.data[0].comentario;
                    //console.log(response.data);
                    data.servicios=response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            guardar(){
                var data = this;
                axios.post('/crearSolicitudesCliente', {
                    fecha_probable: moment(data.fecha_probable).format('YYYY-MM-DD HH:mm:ss'),//se usa para convertir la fecha antes de entregarla al servidor con formato especifico
                    comentario: data.comentario,
                    servicios: data.servicioSeleccionado
                }).then(function (response) {
                    data.enviarNotificacion();
                    //mesaje exito y lo redirecciona a la pagina de la solicitudes hechas
                    Swal.fire({
                        position: 'top-end',
                        title: 'Cita solicitada con éxito!',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function(){
                        //envio de notifiacion por get                        
                        window.location.href = "/miSolicitud";
                    });
                    console.log(response);
                })
                .catch(function (error) {
                    if (error.response.status == 422) {//preguntamos si el error es 422
                        data.arrayErrors = error.response.data.errors;//guardamos la respuesta del server de errores en el array arrayErrors
                    }
                    console.log(error);
                });
                 
            },
            enviarNotificacion(){
                axios({
                    url: '/push',
                    method: 'get'
                });
            }
        },
        mounted() {
            this.listarServicios();
        }
    }
</script>

<template>
    <section>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img v-bind:src="imagen" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>Agendador</p>
                        <small v-text="nombres"></small><br>
                        <a href="" v-if="estado_usuario == 1"><i class="fa fa-circle text-success"></i> En línea</a>
                        <a href="" v-if="estado_usuario == 2"><i class="fa fa-circle text-success"></i> Desactivado</a>
                    </div>
                </div>
                <li role="separator" class="divider"></li>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header text-center">Menú Principal</li>
                    <li>
                        <router-link to="/" data-toggle="push-menu">
                            <i class="fas fa-list-ol text-white"></i> <span>Solicitudes</span>
                            <span class="pull-right-container">
                                <small class="label pull-right bg-green">
                                    {{cantidad}}
                                </small>
                            </span>
                        </router-link>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="far fa-calendar-alt text-white"></i> <span>Agenda</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <router-link to="/agendaLibre" data-toggle="push-menu">
                                    <i class="far fa-calendar-plus  text-green"></i> Agendar Libre
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/agendaEnEspera" data-toggle="push-menu">
                                    <i class="fas fa-hourglass-half text-green"></i> En Espera
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/agendaAtendidos" data-toggle="push-menu">
                                    <i class="fas fa-calendar-check text-green"></i> Atendidos
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/agendaNoAsistio" data-toggle="push-menu">
                                    <i class="far fa-calendar-minus text-green"></i> No Asistió
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/agendaCancelaron" data-toggle="push-menu">
                                    <i class="far fa-calendar-times text-green"></i> Cancelaron
                                </router-link>
                            </li>

                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fas fa-user-check text-white"></i> <span>Clientes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <router-link to="/clientes" data-toggle="push-menu">
                                    <i class="fa fa-users text-green" aria-hidden="true"></i> <span>Mis Clientes</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link to="/agendaCumple" data-toggle="push-menu">
                                    <i class="fas fa-birthday-cake text-green"></i> <span>Cumpleaños</span>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link to="/empleados" data-toggle="push-menu">
                            <i class="fas fa-user-tie text-white"></i> <span>Empleados</span>
                        </router-link>
                    </li>
                    <li class="header text-center">Configuración</li>
                    <li>
                        <router-link to="/miperfil" data-toggle="push-menu">
                            <i class="fa fa-address-card text-white" aria-hidden="true"></i> <span>Mi Perfil</span>
                        </router-link>
                    </li>
            </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

    </section>
</template>
<script>
    export default {
        data() {
            return {
                cantidad: 0,
                email: '',
                imagen: '',
                nombres: '',
                estado_usuario: 1
            }
        },
        methods: {
            //metodo para saber la cantidad de solicitudes nuevas
            cantidadSolicitudes(){
                let me = this;
                axios.get('/contarSolicitudes')
                .then(function (response) {
                    //guardo en mi variable el valor y ya
                    me.cantidad = response.data.cantidad;
                    //console.log(response.data.cantidad);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            verPerfil(){
                //creamos variable q corresponde a this de mis variables de data()
                let me=this;
                axios.get('/showPerfil')
                    .then(function (response) {
                        me.imagen = '/img/perfiles/' + response.data[0].imagen;
                        me.email = response.data[0].email;
                        me.nombres = response.data[0].nombre_usuario;
                        me.estado_usuario = response.data[0].estado_usuario;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
            },
        },
        mounted() {
            this.verPerfil();
            this.cantidadSolicitudes();
        }
    }
</script>

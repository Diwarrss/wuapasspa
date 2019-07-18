<template>
  <section>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img v-bind:src="imagen" class="img-circle" alt="User Image" />
          </div>
          <div class="pull-left info">
            <p>Administrador</p>
            <small v-text="nombres"></small>
            <br />
            <a href v-if="estado_usuario == 1">
              <i class="fa fa-circle text-success"></i> En línea
            </a>
            <a href v-if="estado_usuario == 2">
              <i class="fa fa-circle text-success"></i> Desactivado
            </a>
          </div>
        </div>
        <li role="separator" class="divider"></li>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header text-center">
            <i class="fas fa-home"></i> Menú Principal
          </li>
          <li>
            <router-link to="/" data-toggle="push-menu">
              <i class="fas fa-calendar-alt text-white"></i>
              <span>Solicitudes</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-green">{{cantidad}}</small>
              </span>
            </router-link>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="far fa-calendar-alt text-white"></i>
              <span>Agenda</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <router-link to="/agendaLibre" data-toggle="push-menu">
                  <i class="far fa-calendar-plus text-green"></i> Agendar Libre
                </router-link>
              </li>
              <li>
                <router-link to="/agendaEnEspera" data-toggle="push-menu">
                  <i class="fas fa-hourglass-half text-green"></i> En Espera
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fas fa-user-check text-white"></i>
              <span>Clientes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <router-link to="/clientes" data-toggle="push-menu">
                  <i class="fa fa-users text-green" aria-hidden="true"></i>
                  <span>Mis Clientes</span>
                </router-link>
              </li>
              <li>
                <router-link to="/agendaCumple" data-toggle="push-menu">
                  <i class="fas fa-birthday-cake text-green"></i>
                  <span>Cumpleaños</span>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fas fa-money-check-alt text-white"></i>
              <span>Facturación</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <router-link to="/cajaRegistradora" data-toggle="push-menu">
                  <i class="fas fa-cash-register text-green"></i>
                  <span>Caja Registradora</span>
                </router-link>
              </li>
              <li>
                <router-link to="/facturarAtencion" data-toggle="push-menu">
                  <i class="fas fa-file-invoice-dollar text-green"></i>
                  <span>Facturar Atención</span>
                </router-link>
              </li>
              <li>
                <router-link to="/nomina" data-toggle="push-menu">
                  <i class="fas fa-university text-green"></i>
                  <span>Nómina</span>
                </router-link>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fas fa-chart-pie text-white"></i>
              <span>Reportes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <router-link to="/reportCitas" data-toggle="push-menu">
                  <i class="fas fa-chart-line text-green"></i> Citas por Mes
                </router-link>
              </li>
              <li>
                <router-link to="/reportEmpleados" data-toggle="push-menu">
                  <i class="fas fa-chart-area text-green"></i> Citas por Empleados
                </router-link>
              </li>
              <li>
                <router-link to="/reportServicios" data-toggle="push-menu">
                  <i class="far fa-chart-bar text-green"></i> Servicios Frecuentes
                </router-link>
              </li>
              <li>
                <router-link to="/reportAgendalibre" data-toggle="push-menu">
                  <i class="fas fa-user-plus text-green"></i> Agendas Libres
                </router-link>
              </li>
              <li>
                <router-link to="/agendaAtendidos" data-toggle="push-menu">
                  <i class="fas fa-calendar-check text-green"></i> Atendidos
                </router-link>
              </li>
              <li>
                <router-link to="/agendaNoAsistio" data-toggle="push-menu">
                  <i class="far fa-calendar-minus text-green"></i> No Asistieron
                </router-link>
              </li>
              <li>
                <router-link to="/agendaCancelaron" data-toggle="push-menu">
                  <i class="far fa-calendar-times text-green"></i> Cancelaron
                </router-link>
              </li>
            </ul>
          </li>
          <li class="header text-center">
            <i class="fas fa-tools"></i> Administración
          </li>
          <li>
            <router-link to="/buzonSugerencias" data-toggle="push-menu">
              <i class="fas fa-mail-bulk"></i>
              <span>Buzón</span>
            </router-link>
          </li>
          <li>
            <router-link to="/empleados" data-toggle="push-menu">
              <i class="fas fa-user-tie text-white"></i>
              <span>Empleados</span>
            </router-link>
          </li>
          <li>
            <router-link to="/roles" data-toggle="push-menu">
              <i class="fas fa-user-cog text-white"></i>
              <span>Roles</span>
            </router-link>
          </li>
          <li class="header text-center">
            <i class="fas fa-wrench"></i> Configuración
          </li>
          <li>
            <router-link to="/miperfil" data-toggle="push-menu">
              <i class="fa fa-address-card text-white" aria-hidden="true"></i>
              <span>Mi Perfil</span>
            </router-link>
          </li>
          <li>
            <router-link to="/mipagina" data-toggle="push-menu">
              <i class="fab fa-chrome text-white"></i>
              <span>Página Web</span>
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
      email: "",
      imagen: "",
      nombres: "",
      estado_usuario: 1
    };
  },
  methods: {
    //metodo para saber la cantidad de solicitudes nuevas
    cantidadSolicitudes() {
      let me = this;
      axios
        .get("/contarSolicitudes")
        .then(function(response) {
          //guardo en mi variable el valor y ya
          me.cantidad = response.data.cantidad;
          //console.log(response.data.cantidad);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    verPerfil() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;
      axios
        .get("/showPerfil")
        .then(function(response) {
          me.imagen = "/img/perfiles/" + response.data[0].imagen;
          me.email = response.data[0].email;
          me.nombres = response.data[0].nombre_usuario;
          me.estado_usuario = response.data[0].estado_usuario;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    }
  },
  mounted() {
    this.verPerfil();
    this.cantidadSolicitudes();
  }
};
</script>

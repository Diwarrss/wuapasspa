<template>
  <section>
    <!-- MENU DEL EMPLEADO -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img v-bind:src="imagen" class="img-circle" alt="User Image" />
          </div>
          <div class="pull-left info">
            <p>Empleado</p>
            <small v-text="nombre_usuario"></small>
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
          <li class="header text-center">Menú Principal</li>
          <li>
            <router-link to="/miAgenda" :data-toggle="[windowWidth<576 ? 'push-menu':'']">
              <i class="fas fa-hourglass-half"></i>
              <span>Mi Agenda</span>
            </router-link>
          </li>
          <li>
            <router-link to="/misAtenciones" :data-toggle="[windowWidth<576 ? 'push-menu':'']">
              <i class="far fa-calendar-alt"></i>
              <span>Mis Atenciones</span>
            </router-link>
          </li>
          <li class="header text-center">Configuración</li>
          <li>
            <router-link to="/miperfil" :data-toggle="[windowWidth<576 ? 'push-menu':'']">
              <i class="fa fa-address-card text-white" aria-hidden="true"></i>
              <span>Mi Perfil</span>
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
      email: "",
      imagen: "",
      estado_usuario: 1,
      nombre_usuario: ""
    };
  },
  methods: {
    verPerfil() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;
      axios
        .get("/showPerfil")
        .then(function(response) {
          me.imagen = "/img/perfiles/" + response.data[0].imagen;
          me.email = response.data[0].email;
          me.estado_usuario = response.data[0].estado_usuario;
          mr.nombre_usuario = response.data[0].nombre_usuario;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    //optenemos el tamaño pantalla que nos envia this.$nextTick
    getWindowWidth(event) {
      this.windowWidth = document.documentElement.clientWidth;
      /*  console.log(this.windowWidth); */
    },
    //destruir el objeto getWindowWidth
    beforeDestroy() {
      window.removeEventListener("resize", this.getWindowWidth);
    }
  },
  mounted() {
    //lanza el evento
    this.$nextTick(function() {
      window.addEventListener("resize", this.getWindowWidth);
      //Init
      this.getWindowWidth();
    });
    this.verPerfil();
  }
};
</script>

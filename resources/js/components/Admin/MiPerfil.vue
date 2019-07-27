<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-address-card" aria-hidden="true"></i> Mi Perfil
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fa fa-address-card" aria-hidden="true"></i> Mi Perfil
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-4">
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" v-bind:src="imagen" />

              <h3 class="profile-username text-center" v-text="nombre_usuario+' '+apellido_usuario"></h3>

              <p class="text-muted text-center" v-if="estado_usuario == 1">
                <i class="fa fa-circle text-success"></i> Activo
              </p>
              <p class="text-muted text-center" v-if="estado_usuario == 2">
                <i class="fa fa-circle text-danger"></i> Desactivado
              </p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Nombres:</b>
                  <span class="pull-right" v-text="nombre_usuario"></span>
                </li>
                <li class="list-group-item">
                  <b>Apellidos:</b>
                  <span class="pull-right" v-text="apellido_usuario"></span>
                </li>
                <li class="list-group-item">
                  <b>E-mail:</b>
                  <span class="pull-right" v-text="email"></span>
                </li>
                <li class="list-group-item">
                  <b>WhatsApp:</b>
                  <span class="pull-right">
                    <i class="fab fa-whatsapp text-green"></i>
                    {{celular}}
                  </span>
                </li>
                <li class="list-group-item">
                  <b>Fecha Cumpleaños:</b>
                  <span class="pull-right" v-text="fecha_cumple"></span>
                </li>
                <li class="list-group-item">
                  <b>Foto Perfil:</b>
                  <img
                    class="img-responsive img-circle pull-right"
                    height="25px"
                    width="25px"
                    v-bind:src="imagen"
                  />
                </li>
              </ul>
              <button class="btn btn-primary" data-toggle="modal" data-target="#modalPerfil">
                <b>
                  <i class="fas fa-edit"></i> Editar
                </b>
              </button>
            </div>
            <!-- /.box-body -->
          </div>
          <div class="box box-warning">
            <div class="box-body box-profile">
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Creado el:</b>
                  <span class="pull-right" v-text="created_at"></span>
                </li>
                <li class="list-group-item">
                  <b>Última Modificación:</b>
                  <span class="pull-right" v-text="updated_at"></span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Cambiar contraseña -->
        <div class="col-md-4">
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">
                <i class="fas fa-user-secret"></i> Cambiar Contraseña
              </h3>
            </div>
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="password" class="col-sm-4 control-label hidden-xs">Contraseña Nueva</label>

                  <div class="col-sm-8 col-xs-12">
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="password"
                      placeholder="Contraseña Nueva"
                    />
                    <p
                      class="text-red"
                      v-if="arrayErrors.password"
                      v-text="arrayErrors.password[0]"
                    ></p>
                  </div>
                </div>
                <div class="form-group">
                  <label
                    for="password2"
                    class="col-sm-4 control-label hidden-xs"
                  >Confirma Contraseña</label>

                  <div class="col-sm-8 col-xs-12">
                    <input
                      type="password"
                      class="form-control"
                      id="password-confirm"
                      name="password_confirmation"
                      v-model="password2"
                      placeholder="Confirma Contraseña"
                    />
                    <p class="text-red" v-if="password != password2">Contraseñas no coinciden</p>
                    <p v-else-if="password2 == ''"></p>
                    <p class="text-success" v-else>Contraseñas coinciden con éxito</p>
                    <p
                      class="text-red"
                      v-if="arrayErrors.password2"
                      v-text="arrayErrors.password2[0]"
                    ></p>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div v-if="password != password2"></div>
                <div v-else>
                  <button
                    type="button"
                    class="btn btn-success pull-right"
                    @click="actualizarPassword();"
                  >
                    <i class="fas fa-check"></i> Guardar Cambios
                  </button>
                </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
        <!-- llamo el componente de editar imagen -->
        <imagenperfil></imagenperfil>
      </div>
    </section>
    <!-- Modal editar perfil -->
    <section>
      <div class="modal fade in" id="modalPerfil">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-edit"></i> Actualizar Perfil
                </h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group" v>
                    <label for="nombre_usuario" class="col-sm-4 control-label hidden-xs">Nombres</label>
                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="text"
                        class="form-control"
                        id="nombre_usuario"
                        v-model="nombre_usuario"
                        placeholder="Nombres"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.nombre_usuario"
                        v-text="arrayErrors.nombre_usuario[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="apellido_usuario" class="col-sm-4 control-label hidden-xs">Apellidos</label>

                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="text"
                        class="form-control"
                        id="apellido_usuario"
                        v-model="apellido_usuario"
                        placeholder="Apellidos"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.apellido_usuario"
                        v-text="arrayErrors.apellido_usuario[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-4 control-label hidden-xs">E-mail</label>

                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="email"
                        class="form-control"
                        id="email"
                        v-model="email"
                        placeholder="E-mail"
                      />
                      <p class="text-red" v-if="arrayErrors.email" v-text="arrayErrors.email[0]"></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="celular" class="col-sm-4 control-label hidden-xs">WhatsApp</label>

                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="number"
                        class="form-control"
                        id="celular"
                        v-model="celular"
                        placeholder="WhatsApp"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.celular"
                        v-text="arrayErrors.celular[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label
                      for="fecha_cumple"
                      class="col-sm-4 control-label hidden-xs"
                    >Fecha Cumpleaños</label>
                    <div class="col-sm-8 col-xs-12">
                      <datetime
                        v-model="fecha_cumple"
                        type="date"
                        :phrases="{ok: 'Continuar', cancel: 'Cancelar'}"
                        format="dd/MM/yyyy"
                        value-zone="America/Bogota"
                        input-id="fecha_probable"
                        use12-hour
                        input-class="form-control"
                        placeholder="Fecha cumpleaños"
                        auto
                        readonly
                      ></datetime>
                      <p
                        class="text-red"
                        v-if="arrayErrors.fecha_cumple"
                        v-text="arrayErrors.fecha_cumple[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="estado_usuario" class="col-sm-4 control-label hidden-xs">Estado</label>

                    <div class="col-sm-8 col-xs-12">
                      <select class="form-control" v-model="estado_usuario">
                        <option value disabled>Seleccionar...</option>
                        <option value="1">Activo</option>
                        <option value="2">Desactivado</option>
                      </select>
                      <p
                        class="text-red"
                        v-if="arrayErrors.estado_usuario"
                        v-text="arrayErrors.estado_usuario[0]"
                      ></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" @click="cancelarUpdate();">
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" @click="actualizarPerfil();">
                  <i class="fas fa-edit"></i> Actualizar
                </button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </section>
  </div>
</template>
<script>
import moment from "moment";
export default {
  data() {
    return {
      roles_roles_id: "",
      empresas_empresas_id: "",
      nombre_usuario: "",
      apellido_usuario: "",
      usuario: "",
      password: "",
      password2: "",
      email: "",
      imagen: "",
      celular: "",
      fecha_cumple: "",
      estado_usuario: 1,
      created_at: "",
      updated_at: "",
      arrayUser: [],
      arrayErrors: []
    };
  },
  methods: {
    verPerfil() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;
      axios
        .get("/showPerfil")
        .then(function(response) {
          //guardamos la informacion en nuestro array
          me.arrayUser = response.data;
          var created_at2 = response.data[0].created_at;
          var updated_at2 = response.data[0].updated_at;
          //convertir formato de fecha para mostrar
          var created_at1 = moment(created_at2).format("DD-MM-YYYY hh:mm a");
          var updated_at1 = moment(updated_at2).format("DD-MM-YYYY hh:mm a");

          me.id = response.data[0].id;
          me.roles_roles_id = response.data[0].roles_roles_id;
          me.empresas_empresas_id = response.data[0].empresas_empresas_id;
          me.imagen = "/img/perfiles/" + response.data[0].imagen;
          me.nombre_usuario = response.data[0].nombre_usuario;
          me.apellido_usuario = response.data[0].apellido_usuario;
          me.email = response.data[0].email;
          me.celular = response.data[0].celular;
          me.fecha_cumple = response.data[0].fecha_cumple;
          me.estado_usuario = response.data[0].estado_usuario;
          me.fecha_cumple = response.data[0].fecha_cumple;
          me.estado_usuario = response.data[0].estado_usuario;
          me.created_at = created_at1;
          me.updated_at = updated_at1;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    actualizarPerfil() {
      let me = this;
      axios
        .put("/actualizarPerfil", {
          id: me.id,
          roles_roles_id: me.roles_roles_id,
          empresas_empresas_id: me.empresas_empresas_id,
          nombre_usuario: me.nombre_usuario,
          apellido_usuario: me.apellido_usuario,
          email: me.email,
          celular: me.celular,
          fecha_cumple: moment(me.fecha_cumple).format("YYYY-MM-DD"),
          estado_usuario: me.estado_usuario
        })
        .then(function(response) {
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Perfil actualizado!",
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            $("[data-dismiss=modal]").trigger({ type: "click" });
            me.arrayErrors = [];
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          //console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    cancelarUpdate() {
      //metodo al cerrar el modal restaure todo xd
      this.verPerfil();
      $("[data-dismiss=modal]").trigger({ type: "click" });
      this.arrayErrors = [];
    },
    actualizarPassword() {
      let me = this;
      axios
        .put("/actualizarPassword", {
          id: me.id,
          //passwordAnt: me.passwordAnt,
          password: me.password,
          password2: me.password2
        })
        .then(function(response) {
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Contraseña actualizada!",
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            me.password = "";
            me.password2 = "";
            me.arrayErrors = [];
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          //console.log(error);
        });
    }
  },
  mounted() {
    this.verPerfil();
  }
};
</script>

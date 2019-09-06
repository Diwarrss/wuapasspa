<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-file-invoice-dollar"></i> Facturar Atención
        <small>Facturación</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-file-invoice-dollar"></i> Facturar Atención
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-3 col-sm-5 col-lg-4">
          <div class="box box-primary">
            <div class="box-header text-center">
              <h3 class="box-title">
                <i class="far fa-list-alt"></i> Lista de Ordenes
              </h3>
            </div>
            <div class="box-body">
              <button class="btn btn-success">Diego Alejandro Vargas</button>
            </div>
          </div>
        </div>
        <div class="col-md-9 col-sm-7 col-lg-8">
          <div class="box box-success">
            <div class="box-header text-center">
              <h3 class="box-title">
                <i class="fas fa-users"></i> Seleccionar el Cliente
              </h3>
              <button class="btn btn-primary" @click="abrirModalClientes()">
                <i class="fas fa-plus"></i> Crear
              </button>
            </div>
            <div class="box-body">
              <div class="col-md-6 col-md-offset-3">
                <v-select
                  :options="clientesArray"
                  :reduce="cliente => cliente.id"
                  placeholder="Buscar Cliente"
                  label="cliente"
                  v-model="clienteSelect"
                >
                  <i slot="spinner" class="icon icon-spinner"></i>
                  <div slot="no-options">No hay Resultados!</div>
                </v-select>
                {{clienteSelect}}
              </div>
            </div>
          </div>
          <div class="box box-primary">
            <div class="box-header text-center">
              <div class="col-md-12">
                <h3 class="box-title">
                  <i class="fas fa-coins"></i> Buscar Servicios o Productos
                </h3>
                <button class="btn btn-primary" @click="abrirModalServicios()">
                  <i class="fas fa-plus"></i> Crear
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-6 col-md-offset-3">
                <v-select
                  :options="serviciosArray"
                  :reduce="servicio => servicio.id"
                  placeholder="Seleccionar servicio o producto"
                  label="servicio"
                  v-model="selectServProd"
                >
                  <i slot="spinner" class="icon icon-spinner"></i>
                  <div slot="no-options">No hay Resultados!</div>
                </v-select>
                <br />
              </div>
              <div class="col-md-12" v-if="selectServProd !=0">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Servicio</th>
                        <th>Realizado Por</th>
                        <th>Cantidad</th>
                        <th>Descuento</th>
                        <th>Valor</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
              <div class="col-md-12" v-if="selectServProd !=0">
                <div class="table-responsive">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Descuento</th>
                        <th>Valor</th>
                        <th>Acción</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="box box-default">
            <div class="box-header text-center">
              <div class="col-md-12">
                <h3 class="box-title">
                  <i class="fas fa-file-invoice-dollar"></i> Información a Facturar
                </h3>
              </div>
              <div class="box-body"></div>
              <div class="box-footer">
                <button class="btn btn-success">
                  <i class="fas fa-check"></i> Facturar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Modal crear NUEVO, ACTUALIZAR empleado -->
    <div class="modal fade in" id="modalCliente">
      <div class="modal-dialog">
        <div class="modal-content">
          <form class="form-horizontal">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title">
                <i class="fas fa-plus-circle"></i> Crear Cliente
              </h4>
            </div>
            <div class="modal-body">
              <div class="box-body">
                <div class="form-group">
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
                  <label for="password" class="col-sm-4 control-label hidden-xs">Contraseña</label>

                  <div class="col-sm-8 col-xs-12">
                    <input
                      type="password"
                      class="form-control"
                      id="password"
                      v-model="password"
                      placeholder="Contraseña"
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
                    <p class="text-red" v-if="arrayErrors.celular" v-text="arrayErrors.celular[0]"></p>
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
                      <option value="2">Inactivo</option>
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
              <button type="button" class="btn btn-danger pull-left" @click="cerrarModal();">
                <i class="fas fa-times"></i> Cancelar
              </button>
              <button type="button" class="btn btn-success" @click="crearCliente();">
                <i class="fas fa-check"></i> Guardar
              </button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--Modal editar y crear Servicio-->
    <section>
      <div class="modal fade in" id="modalServicios">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal" content-type="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">
                  <i class="fas fa-plus-circle"></i> Crear
                </h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group">
                    <label
                      for="categoriaServicio"
                      class="col-sm-4 control-label hidden-xs"
                    >Elegir Categoria</label>

                    <div class="col-sm-8 col-xs-12">
                      <select class="form-control" v-model="categoriaServicio">
                        <option value disabled>Seleccionar Categoria...</option>
                        <option
                          v-for="categoria in arrayCategorias"
                          :key="categoria.id"
                          :value="categoria.id"
                          v-text="categoria.nombre_categoria"
                        ></option>
                      </select>
                      <p
                        class="text-red"
                        v-if="arrayErrors.categoriaServicio"
                        v-text="arrayErrors.categoriaServicio[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="tipo" class="col-sm-4 control-label hidden-xs">Tipo</label>

                    <div class="col-sm-8 col-xs-12">
                      <select class="form-control" v-model="tipo">
                        <option value disabled>Seleccionar Tipo</option>
                        <option value="1">Servicio</option>
                        <option value="2">Producto</option>
                      </select>
                      <p class="text-red" v-if="arrayErrors.tipo" v-text="arrayErrors.tipo[0]"></p>
                    </div>
                  </div>
                  <section v-show="tipo==2">
                    <div class="form-group">
                      <label for="stock" class="col-sm-4 control-label hidden-xs">Stock:</label>
                      <div class="col-sm-8 col-xs-12">
                        <input
                          type="number"
                          class="form-control"
                          id="stock"
                          v-model="stock"
                          placeholder="Cantidad en bodega"
                        />
                        <p class="text-red" v-if="arrayErrors.stock" v-text="arrayErrors.stock[0]"></p>
                      </div>
                    </div>
                  </section>
                  <div class="form-group">
                    <label for="Nombre" class="col-sm-4 control-label hidden-xs">Nombre:</label>
                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="text"
                        class="form-control"
                        id="Nombre"
                        v-model="nombreServicio"
                        placeholder="Nombre"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.nombreServicio"
                        v-text="arrayErrors.nombreServicio[0]"
                      ></p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="descripcion" class="col-sm-4 control-label hidden-xs">Descripción:</label>
                    <div class="col-sm-8 col-xs-12">
                      <textarea
                        size="2"
                        class="form-control"
                        id="descripcion"
                        v-model="descripcion"
                        placeholder="Descripción"
                      ></textarea>
                      <p
                        class="text-red"
                        v-if="arrayErrors.descripcion"
                        v-text="arrayErrors.descripcion[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="estadoServicio" class="col-sm-4 control-label hidden-xs">Estado</label>

                    <div class="col-sm-8 col-xs-12">
                      <select class="form-control" v-model="estadoServicio">
                        <option value disabled>Seleccionar...</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                      </select>
                      <p
                        class="text-red"
                        v-if="arrayErrors.estadoServicio"
                        v-text="arrayErrors.estadoServicio[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label
                      for="urlVideoServicio"
                      class="col-sm-4 control-label hidden-xs"
                    >Url YouTube:</label>
                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="text"
                        class="form-control"
                        id="urlVideoServicio"
                        v-model="urlVideoServicio"
                        placeholder="Url YouTube"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.urlVideoServicio"
                        v-text="arrayErrors.urlVideoServicio[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="files" class="col-sm-4 control-label hidden-xs">Imagen:</label>
                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="file"
                        class="form-control"
                        name="files"
                        id="files"
                        @change="imagenSeleccionada2"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.imagenServicio"
                        v-text="arrayErrors.imagenServicio[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label
                      for="valorServicio"
                      class="col-sm-4 control-label hidden-xs"
                    >Valor de Venta:</label>
                    <div class="col-sm-8 col-xs-12">
                      <money
                        class="form-control"
                        v-bind="money"
                        v-model="valorServicio"
                      >{{valorServicio}}</money>
                      <p
                        class="text-red"
                        v-if="arrayErrors.valorServicio"
                        v-text="arrayErrors.valorServicio[0]"
                      ></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" @click="cerrarModal();">
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" @click="crearServicio()">
                  <i class="fas fa-plus-circle"></i> Crear
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
//importamos vue-select
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import moment from "moment";
export default {
  components: {
    vSelect
  },
  data() {
    return {
      clienteSelect: 0,
      selectServProd: 0,
      clientesArray: [],
      serviciosArray: [],
      arrayErrors: [],
      nombre_usuario: "",
      apellido_usuario: "",
      email: "",
      password: "",
      password2: "",
      celular: "",
      fecha_cumple: "",
      estado_usuario: 1,
      arrayCategorias: [],
      categoriaServicio: "",
      tipo: "",
      estadoServicio: "",
      stock: 0,
      nombreServicio: "",
      descripcion: "",
      urlVideoServicio: "",
      imagenSelect2: "",
      imagenServicio: [],
      valorServicio: "",
      //para usar el vue componente de moneyConcurrente
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "$",
        suffix: "",
        precision: 0,
        masked: false
      }
    };
  },
  methods: {
    listarClientesFact() {
      axios
        .get("/listarClientesFact")
        .then(function(response) {
          this.clientesArray = response.data;
          // handle success
          console.log(this.clientesArray);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    listarServProd() {
      let me = this;
      axios
        .get("/listarServProd")
        .then(function(response) {
          me.serviciosArray = response.data;
          // handle success
          console.log(response);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    abrirModalClientes() {
      jQuery.noConflict(); // para evitar errores al mostrar la modal
      $("#modalCliente").modal("show");
    },
    abrirModalServicios() {
      jQuery.noConflict(); // para evitar errores al mostrar la modal
      $("#modalServicios").modal("show");
      this.showCategoriaActivas();
    },
    cerrarModal() {
      $("[data-dismiss=modal]").trigger({ type: "click" }); //para cerrar la modal con boostrap 3
      this.arrayErrors = [];
      this.nombre_usuario = "";
      this.apellido_usuario = "";
      this.email = "";
      this.password = "";
      this.password2 = "";
      this.celular = "";
      this.fecha_cumple = "";
      this.estado_usuario = 1;
      this.arrayCategorias = [];
      this.categoriaServicio = "";
      this.tipo = "";
      this.estadoServicio = "";
      this.stock = 0;
      this.nombreServicio = "";
      this.descripcion = "";
      this.urlVideoServicio = "";
      this.imagenSelect2 = "";
      this.imagenServicio = [];
      this.valorServicio = "";
    },
    showCategoriaActivas() {
      let data = this;
      axios
        .get("/showCategoriaActivas")
        .then(function(response) {
          //guardamos la informacion en nuestro array
          data.arrayCategorias = response.data;
          //console.log(data.arrayCategorias);
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        })
        .finally(function() {
          // always executed
        });
    },
    imagenSeleccionada2(event) {
      //metodo para capturar la imagen
      let me = this;
      me.imagenSelect2 = event.target.files[0]; //array q me contiene todos los datos de la imagen
      //console.log(event);
      //console.log(me.imagenSelect2);
    },
    crearServicio() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;

      let fileCargada = new FormData();
      fileCargada.append("imagenServicio", me.imagenSelect2);
      fileCargada.append("categoriaServicio", me.categoriaServicio);
      fileCargada.append("nombreServicio", me.nombreServicio);
      fileCargada.append("descripcion", me.descripcion);
      fileCargada.append("estadoServicio", me.estadoServicio);
      fileCargada.append("urlVideoServicio", me.urlVideoServicio);
      fileCargada.append("valorServicio", me.valorServicio);
      fileCargada.append("tipo", me.tipo);
      fileCargada.append("stock", me.stock);

      //reseteamos los errores
      this.arrayErrors = [];

      axios
        .post("/crearServicio", fileCargada)
        .then(function(response) {
          me.cerrarModal();
          Swal.fire({
            toast: true,
            position: "top-end",
            type: "success",
            title: "Servicio creado con éxito",
            showConfirmButton: false,
            timer: 2500
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          console.log(error);
          //console.log(me.arrayErrors);
        });
    },
    crearCliente() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;
      //reseteamos los errores
      this.arrayErrors = [];

      axios
        .post("/createCliente", {
          //enviamos los tados que hay en nuestros parametros
          roles_roles_id: this.roles_roles_id,
          empresas_empresas_id: this.empresas_empresas_id,
          nombre_usuario: this.nombre_usuario,
          apellido_usuario: this.apellido_usuario,
          usuario: this.usuario,
          email: this.email,
          password: this.password,
          celular: this.celular,
          fecha_cumple: moment(this.fecha_cumple).format("YYYY-MM-DD"),
          imagen: this.imagen,
          estado_usuario: this.estado_usuario
        })
        .then(function(response) {
          me.cerrarModal();
          Swal.fire({
            toast: true,
            position: "top-end",
            type: "success",
            title: "Cliente creado con éxito",
            showConfirmButton: false,
            timer: 2500
          });
          //console.log(response);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          console.log(error);
          //console.log(me.arrayErrors);
        });
    }
  },
  mounted() {
    this.listarClientesFact();
    this.listarServProd();
  }
};
</script>

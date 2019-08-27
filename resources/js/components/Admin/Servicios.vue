<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fab fa-buffer"></i> Servicios
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fab fa-buffer"></i> Servicios
        </li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">
                <i class="fas fa-layer-group"></i> Lista de Categorias
              </h3>
              <button type="button" class="btn btn-primary" @click="abrirModalCategorias()">
                <i class="fas fa-plus-circle"></i> Crear
              </button>
            </div>

            <div class="table-responsive container-fluid">
              <table
                id="tablaCategorias"
                class="table table-bordered table-hover"
                style="width:100%"
              >
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Video</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody style="font-weight: normal;"></tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title">
                <i class="far fa-list-alt"></i> Lista de Servicios
              </h3>
              <button type="button" class="btn btn-primary" @click="abrirModal()">
                <i class="fas fa-plus-circle"></i> Crear
              </button>
            </div>

            <div class="table-responsive container-fluid">
              <table
                id="tablaServicios"
                class="table table-bordered table-hover"
                style="width:100%"
              >
                <thead>
                  <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Precio</th>
                    <th>Video</th>
                    <th>Imagen</th>
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
    <!--Modal editar y crear Categoria-->
    <section>
      <div class="modal fade in" id="modalCategorias">
        <div class="modal-dialog">
          <div class="modal-content">
            <form class="form-horizontal" content-type="multipart/form-data">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" v-if="tipoAccionModal==1">
                  <i class="fas fa-plus-circle"></i> Crear Categoria
                </h4>
                <h4 class="modal-title" v-if="tipoAccionModal==2">
                  <i class="fas fa-edit"></i> Actualizar Categoria
                </h4>
              </div>
              <div class="modal-body">
                <div class="box-body">
                  <div class="form-group">
                    <label for="nombreCategoria" class="col-sm-4 control-label hidden-xs">Nombre:</label>
                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="text"
                        class="form-control"
                        id="nombreCategoria"
                        v-model="nombreCategoria"
                        placeholder="Nombre Categoria"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.nombreCategoria"
                        v-text="arrayErrors.nombreCategoria[0]"
                      ></p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label
                      for="urlVideoCategoria"
                      class="col-sm-4 control-label hidden-xs"
                    >Url YouTube:</label>
                    <div class="col-sm-8 col-xs-12">
                      <input
                        type="text"
                        class="form-control"
                        id="urlVideoCategoria"
                        v-model="urlVideoCategoria"
                        placeholder="Url YouTube"
                      />
                      <p
                        class="text-red"
                        v-if="arrayErrors.urlVideoCategoria"
                        v-text="arrayErrors.urlVideoCategoria[0]"
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
                        v-if="arrayErrors.imagenCategoria"
                        v-text="arrayErrors.imagenCategoria[0]"
                      ></p>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="estadoCategoria" class="col-sm-4 control-label hidden-xs">Estado</label>

                    <div class="col-sm-8 col-xs-12">
                      <select class="form-control" v-model="estadoCategoria">
                        <option value disabled>Seleccionar...</option>
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                      </select>
                      <p
                        class="text-red"
                        v-if="arrayErrors.estadoCategoria"
                        v-text="arrayErrors.estadoCategoria[0]"
                      ></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <div v-if="tipoAccionModal==1">
                  <button type="button" class="btn btn-success" @click="crearCategoria()">
                    <i class="fas fa-plus-circle"></i> Crear
                  </button>
                </div>
                <div v-else>
                  <button type="button" class="btn btn-success" @click="updateCategoria()">
                    <i class="fas fa-edit"></i> Actualizar
                  </button>
                </div>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    </section>
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
                <h4 class="modal-title" v-if="tipoAccionModal==1">
                  <i class="fas fa-plus-circle"></i> Crear
                </h4>
                <h4 class="modal-title" v-if="tipoAccionModal==2">
                  <i class="fas fa-edit"></i> Actualizar
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
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">
                  <i class="fas fa-times"></i> Cancelar
                </button>
                <div v-if="tipoAccionModal==1">
                  <button type="button" class="btn btn-success" @click="crearServicio()">
                    <i class="fas fa-plus-circle"></i> Crear
                  </button>
                </div>
                <div v-else>
                  <button type="button" class="btn btn-success" @click="actualizarServicio()">
                    <i class="fas fa-edit"></i> Actualizar
                  </button>
                </div>
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
export default {
  data() {
    return {
      roles_roles_id: 0,
      arrayErrors: [],
      empresas_empresas_id: 1,
      tipoAccionModal: "",
      nombreCategoria: "",
      estadoCategoria: "",
      urlVideoCategoria: "",
      imagenCategoria: [],
      imagenSelect2: "",
      categoriaServicio: "",
      nombreServicio: "",
      descripcion: "",
      descripcion: "",
      estadoServicio: "",
      urlVideoServicio: "",
      imagenServicio: [],
      idCategoria: "",
      arrayCategorias: [],
      valorServicio: 0,
      //para usar el vue componente de moneyConcurrente
      money: {
        decimal: ",",
        thousands: ".",
        prefix: "$",
        suffix: "",
        precision: 2,
        masked: false
      },
      tipo: 1,
      stock: ""
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
          //para actualizar la tabla de datatables
          jQuery("#tablaServicios")
            .DataTable()
            .ajax.reload();
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
    actualizarServicio() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;

      let fileCargada = new FormData();
      fileCargada.append("idServicio", me.idServicio);
      fileCargada.append("imagenServicio", me.imagenSelect2);
      fileCargada.append("categoriaServicio", me.categoriaServicio);
      fileCargada.append("nombreServicio", me.nombreServicio);
      fileCargada.append("descripcion", me.descripcion);
      fileCargada.append("estadoServicio", me.estadoServicio);
      fileCargada.append("urlVideoServicio", me.urlVideoServicio);
      fileCargada.append("valorServicio", me.valorServicio);
      fileCargada.append("tipo", me.tipo);
      fileCargada.append("stock", me.stock);

      axios
        .post("/actualizarServicio", fileCargada)
        .then(function(response) {
          //para actualizar la tabla de datatables
          jQuery("#tablaServicios")
            .DataTable()
            .ajax.reload(null, false);
          me.cerrarModal();
          Swal.fire({
            toast: true,
            position: "top-end",
            type: "success",
            title: "Servicio actualizado!",
            showConfirmButton: false,
            timer: 2500
          });
          console.log(response);
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
    cerrarModal() {
      $("[data-dismiss=modal]").trigger({ type: "click" }); //para cerrar la modal con boostrap 3
      this.categoriaServicio = "";
      this.nombreServicio = "";
      this.descripcion = "";
      this.estadoServicio = "";
      this.urlVideoServicio = "";
      this.imagenServicio = [];
      this.valorServicio = 0;
      this.arrayErrors = [];
      this.tipo = 1;
    },
    crearCategoria() {
      let me = this;

      let fileCargada = new FormData();
      fileCargada.append("imagenCategoria", me.imagenSelect2);
      fileCargada.append("nombreCategoria", me.nombreCategoria);
      fileCargada.append("estadoCategoria", me.estadoCategoria);
      fileCargada.append("urlVideoCategoria", me.urlVideoCategoria);

      axios
        .post("/crearCategoria", fileCargada) //le envio el parametro completo
        .then(function(response) {
          jQuery("#tablaCategorias")
            .DataTable()
            .ajax.reload();
          me.cerrarModalCategorias();
          me.showCategoriaActivas();
          Swal.fire({
            toast: true,
            position: "top-end",
            type: "success",
            title: "Categoria creada con éxito!",
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
          //console.log(error);
        });
    },
    cerrarModalCategorias() {
      let me = this;
      $("[data-dismiss=modal]").trigger({ type: "click" }); //para cerrar la modal con boostrap 3
      this.imagenSelect2 = "";
      this.nombreCategoria = "";
      this.estadoCategoria = "";
      this.urlVideoCategoria = "";
      this.imagenCategoria = [];
      this.arrayErrors = [];
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
    //aqui tenemos el script para datatables
    listarServicios() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaServicios = jQuery("#tablaServicios").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [], //no colocar ordenamiento
          pagingType: "full",
          //"order": [[ 0, "asc" ]],
          //"serverSide": true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/showServicios",
          columns: [
            { data: "nombre_servicio" },
            {
              render: function(data, type, row) {
                if (row.descripcion_servicio == "null") {
                  return '<span class="label label-info"> Ninguna</span>';
                } else {
                  return row.descripcion_servicio;
                }
              }
            },
            { data: "nombre_categoria" },
            {
              render: function(data, type, row) {
                if (row.estado_servicio === "1") {
                  return '<span class="label label-success"> Activo</span>';
                } else {
                  return '<span class="label label-danger"> Desactivado</span>';
                }
              }
            },
            {
              data: "valor_servicio",
              render: $.fn.dataTable.render.number(".", ",", 2, "$")
            },
            {
              render: function(data, type, row) {
                if (row.url_video == "") {
                  return '<span class="label label-info"> Sin video</span>';
                } else {
                  return (
                    '<iframe width="200" height="100" src="https://www.youtube.com/embed/' +
                    row.url_video +
                    '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                  );
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.url_imagen == null) {
                  return '<span class="label label-info"> Sin imagen</span>';
                } else {
                  return (
                    '<img class="img-responsive" height="100px" width="100px" src="img/servicios/' +
                    row.url_imagen +
                    '">'
                  );
                }
              }
            },
            {
              defaultContent:
                '<button class="btn btn-warning edit btn-sm" title="Editar Servicio"><i class="fas fa-edit"></i> Editar</button>'
            }
          ]
        });
        //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
        tablaServicios.on("click", ".edit", function() {
          jQuery.noConflict(); // para evitar errores
          $("#modalServicios").modal("show"); //mostramos la modal
          me.tipoAccionModal = 2; //para actualizar colocamos 2 en esta variable de vuejs

          //aplica para si no es responsiva la tabla

          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var data = tablaServicios.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          me.idServicio = data["id"]; //el id es este q es de datatables o este id es de la consulta cualquiera sirve
          me.empresas_empresas_id = 1;
          me.categoriaServicio = data["categorias_categorias_id"];
          me.nombreServicio = data["nombre_servicio"];
          me.descripcion = data["descripcion_servicio"];
          me.estadoServicio = data["estado_servicio"];
          me.tipo = data["tipo"];
          me.stock = data["stock"];
          if (data["url_video"]) {
            me.urlVideoServicio =
              "https://www.youtube.com/watch?v=" + data["url_video"];
          } else {
            me.urlVideoServicio = "";
          }
          me.valorServicio = data["valor_servicio"];
        });
      });
    },
    updateCategoria() {
      let me = this;

      let fileCargada = new FormData();
      fileCargada.append("imagenCategoria", me.imagenSelect2);
      fileCargada.append("idCategoria", me.idCategoria);
      fileCargada.append("nombreCategoria", me.nombreCategoria);
      fileCargada.append("estadoCategoria", me.estadoCategoria);
      fileCargada.append("urlVideoCategoria", me.urlVideoCategoria);

      axios
        .post("/updateCategoria", fileCargada) //le envio el parametro completo
        .then(function(response) {
          jQuery("#tablaCategorias")
            .DataTable()
            .ajax.reload(null, false);
          me.cerrarModalCategorias();
          me.showCategoriaActivas();
          Swal.fire({
            toast: true,
            position: "top-end",
            type: "success",
            title: "Categoria actualizada!",
            showConfirmButton: false,
            timer: 2500
          });
          //console.log(fileCargada);
        })
        .catch(function(error) {
          if (error.response.status == 422) {
            //preguntamos si el error es 422
            me.arrayErrors = error.response.data.errors; //guardamos la respuesta del server de errores en el array arrayErrors
          }
          //console.log(error);
        });
    },
    //aquio enlistamos las categorias
    listarCategorias() {
      let me = this; //creamos esta variable para q nos reconozca los atributos de vuejs
      jQuery(document).ready(function() {
        var tablaCategorias = jQuery("#tablaCategorias").DataTable({
          language: {
            url: "/jsonDTIdioma.json"
          },
          processing: true,
          lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
          responsive: true,
          order: [], //no colocar ordenamiento
          //"order": [[ 0, "asc" ]],
          pagingType: "full",
          //"serverSide": true, //Lado servidor activar o no mas de 20000 registros
          ajax: "/showCategoria",
          columns: [
            { data: "nombre_categoria" },
            {
              render: function(data, type, row) {
                if (row.estado_categoria === "1") {
                  return '<span class="label label-success"> Activa</span>';
                } else {
                  return '<span class="label label-danger"> Desactivada</span>';
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.url_video == "") {
                  return '<span class="label label-info"> Sin video</span>';
                } else {
                  return (
                    '<iframe width="200" height="100" src="https://www.youtube.com/embed/' +
                    row.url_video +
                    '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                  );
                }
              }
            },
            {
              render: function(data, type, row) {
                if (row.url_imagen == null) {
                  return '<span class="label label-info"> Sin imagen</span>';
                } else {
                  return (
                    '<img class="img-responsive" height="100px" width="100px" src="img/categorias/' +
                    row.url_imagen +
                    '">'
                  );
                }
              }
            },
            {
              render: function(data, type, row) {
                return '<button class="btn btn-warning editCategoria btn-sm" title="Editar Categoria"><i class="fas fa-edit"></i> Editar</button>';
              }
            }
          ]
        });
        //funcion que se ejecuta al hacer click en la tabla y abrimos la modal apartir de la clase edit
        tablaCategorias.on("click", ".editCategoria", function() {
          jQuery.noConflict(); // para evitar errores
          $("#modalCategorias").modal("show"); //mostramos la modal
          me.tipoAccionModal = 2; //para actualizar colocamos 2 en esta variable de vuejs

          //aplica para si no es responsiva la tabla

          //para si es responsivo obtenemos la data
          var current_row = $(this).parents("tr"); //Get the current row
          if (current_row.hasClass("child")) {
            //Check if the current row is a child row
            current_row = current_row.prev(); //If it is, then point to the row before it (its 'parent')
          }
          var data = tablaCategorias.row(current_row).data(); //At this point, current_row refers to a valid row in the table, whether is a child row (collapsed by the DataTable's responsiveness) or a 'normal' row

          me.idCategoria = data["id"]; //el id es este q es de datatables o este id es de la consulta cualquiera sirve
          me.nombreCategoria = data["nombre_categoria"];
          if (data["url_video"]) {
            me.urlVideoCategoria =
              "https://www.youtube.com/watch?v=" + data["url_video"];
          } else {
            me.urlVideoCategoria = "";
          }
          me.estadoCategoria = data["estado_categoria"];
        });
      });
    },
    abrirModal() {
      jQuery.noConflict(); // para evitar errores al mostrar la modal
      $("#modalServicios").modal("show");
      this.tipoAccionModal = 1; //para registrar
      //reseteamos variables
      this.empresas_empresas_id = 1;
      this.nombreServicio = "";
      this.descripcion = "";
      this.urlVideoServicio = "";
      this.valorServicio = 0;
      this.estadoServicio = "";
      this.arrayErrors = [];
    },
    abrirModalCategorias() {
      jQuery.noConflict(); // para evitar errores al mostrar la modal
      $("#modalCategorias").modal("show");
      this.tipoAccionModal = 1; //para registrar
      //reseteamos variables
      this.empresas_empresas_id = 1;
      this.nombreCategoria = "";
      this.estadoCategoria = "";
      this.urlVideoCategoria = "";
      this.imagenCategoria = "";
      this.arrayErrors = [];
    }
  },
  mounted() {
    this.rol();
    this.listarServicios();
    this.listarCategorias();
    this.showCategoriaActivas();
  }
};
</script>

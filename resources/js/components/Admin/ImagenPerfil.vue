<template>
  <!-- actualizar foto perfil -->
  <div class="col-md-4">
    <div class="box box-success">
      <div class="box-header with-border">
        <h3 class="box-title">
          <i class="fas fa-user-circle"></i> Imagen de Perfil
        </h3>
      </div>
      <form class="form" content-type="multipart/form-data">
        <div class="box-body">
          <div class="form-group">
            <img
              class="img-responsive img-circle col-md-3 col-sm-2 col-2"
              height="100px"
              width="100px"
              v-bind:src="imagen"
            />
          </div>

          <div class="form-group">
            <div class="col-md-9 col-sm-10 col-10">
              <input
                type="file"
                class="form-control"
                name="imagen"
                id="imagen"
                @change="imagenSeleccionada"
              />
              <p class="text-red" v-if="arrayErrors.imagen" v-text="arrayErrors.imagen[0]"></p>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="button" class="btn btn-success pull-right" @click="updateImagen();">
            <i class="fas fa-upload"></i> Actualizar
          </button>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      roles_roles_id: 0,
      imagen: "",
      imagenSelect: "",
      arrayErrors: []
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
    verPerfil() {
      //creamos variable q corresponde a this de mis variables de data()
      let me = this;
      axios
        .get("/showPerfil")
        .then(function(response) {
          me.imagen = "/img/perfiles/" + response.data[0].imagen;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    imagenSeleccionada(event) {
      //metodo para capturar la imagen
      let me = this;
      me.imagenSelect = event.target.files[0]; //array q me contiene todos los datos de la imagen
      //console.log(event);
      //console.log(me.imagenSelect);
    },
    updateImagen() {
      let me = this;

      let datosFormulario = new FormData();
      datosFormulario.append("imagen", me.imagenSelect); //envio y con request obtengo lo de imagen
      //console.log(me.imagenSelect);

      axios
        .post("/updateImagen", datosFormulario) //le envio el parametro completo
        .then(function(response) {
          Swal.fire({
            position: "top-end",
            type: "success",
            title: "Imagen Actualizada!",
            showConfirmButton: false,
            timer: 1500
          }).then(function() {
            document.location.reload(true);
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
    this.rol();
    this.verPerfil();
  }
};
</script>

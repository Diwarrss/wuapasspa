<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fas fa-tachometer-alt" aria-hidden="true"></i> Escritorio
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-tachometer-alt" aria-hidden="true"></i> Escritorio
        </li>
      </ol>
    </section>
    <div class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>${{formatearValor(dataCajaDiv[0].valor_producido)}}</h3>

              <p>Total Producido Actual</p>
            </div>
            <div class="icon">
              <i class="fas fa-hand-holding-usd"></i>
            </div>
            <a href="/admin#/cajaRegistradora" class="small-box-footer">
              Ver más
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{cantidadClientes}} Clientes</h3>

              <p>Total de clientes registrados</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="/admin#/clientes" class="small-box-footer">
              Ver más
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dataCajaDiv: [],
      cantidadClientes: 0
    };
  },
  methods: {
    //controlador User
    contarClientes() {
      var data = this;
      axios
        .get("/contarClientes")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data[0].nombre_caja);
          data.cantidadClientes = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    formatearValor(value) {
      let val = (value / 1).toFixed(2).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    infoCajaDiv() {
      var data = this;
      axios
        .get("/infoCajaDiv")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data[0].nombre_caja);
          data.dataCajaDiv = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    }
  },
  mounted() {
    this.infoCajaDiv();
    this.contarClientes();
  }
};
</script>

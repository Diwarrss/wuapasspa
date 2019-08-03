<template>
  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <i class="fas fa-tachometer-alt" aria-hidden="true"></i> Escritorio Diario
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-tachometer-alt" aria-hidden="true"></i> Escritorio Diario
        </li>
      </ol>
    </section>
    <div class="content">
      <div class="row">
        <div class="col-md-6 col-lg-3 col-xs-12" v-if="dataCajaDiv.length > 0">
          <div class="small-box bg-green">
            <div class="inner">
              <h3>${{formatearValor(parseInt(dataCajaDiv[0].valor_inicial) + parseInt(dataCajaDiv[0].valor_producido) )}}</h3>

              <p>
                Total Actual de la Caja
                <!--  = ${{formatearValor(totalFacturadoHoy)}} - (${{formatearValor(totalGastosFact)}} + ${{formatearValor(totalPagosNominahoy)}}) -->
              </p>
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
        <div class="col-md-6 col-lg-3 col-xs-12">
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>${{formatearValor(totalFacturadoHoy)}}</h3>

              <p>Total Facturado Hoy</p>
            </div>
            <div class="icon">
              <i class="fas fa-dollar-sign"></i>
            </div>
            <a href="/admin#/facturarAtencion" class="small-box-footer">
              Ver más
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>${{formatearValor(totalGastosFact)}}</h3>

              <p>Total de los Gastos Facturados Hoy</p>
            </div>
            <div class="icon">
              <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <a href="/admin#/facturarAtencion" class="small-box-footer">
              Ver más
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-md-6 col-lg-3 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>${{formatearValor(totalPagosNominahoy)}}</h3>

              <p>Total de Pagos de Nómina a Empleados Hoy</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="/admin#/nomina" class="small-box-footer">
              Ver más
              <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <div class="col-md-6 col-lg-3 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-primary">
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
      cantidadClientes: 0,
      totalGastosFact: 0,
      totalFacturadoHoy: 0,
      totalPagosNominahoy: 0,
      valor_inicial: 0,
      valor_producido: 0
    };
  },
  methods: {
    //Total Pagos Nomina Hoy
    sumFacturaDiaria() {
      var data = this;
      axios
        .get("/totalPagosDiario")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data[0].nombre_caja);
          data.totalPagosNominahoy = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    //Total gastos facturados
    sumFacturaDiaria() {
      var data = this;
      axios
        .get("/totalFacturadoDiario")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data[0].nombre_caja);
          data.totalFacturadoHoy = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
    //Total gastos facturados
    sumGastosFacturados() {
      var data = this;
      axios
        .get("/totalGastosDiarios")
        .then(function(response) {
          // data.fechaprobable=response.data[0].fechaprobable;
          // data.comentario=response.data[0].comentario;
          //console.log(response.data[0].nombre_caja);
          data.totalGastosFact = response.data;
        })
        .catch(function(error) {
          // handle error
          console.log(error);
        });
    },
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
      let val = (value / 1).toFixed(0).replace(".", ",");
      return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    infoCajaDiv() {
      var datos = this;
      axios
        .get("/infoCajaDiv")
        .then(function(response) {
          datos.dataCajaDiv = response.data;
          /* datos.valor_inicial = datos.dataCajaDiv[0].valor_inicial;
          datos.valor_producido = datos.dataCajaDiv[0].valor_producido; */
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
    this.sumGastosFacturados();
    this.sumFacturaDiaria();
  }
};
</script>

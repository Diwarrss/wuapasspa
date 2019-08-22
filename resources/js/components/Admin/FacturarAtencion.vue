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
            </div>
            <div class="box-body">
              <div class="col-md-6 col-md-offset-3">
                <v-select
                  :options="clientes"
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
              </div>
            </div>
            <div class="box-body">
              <div class="col-md-6 col-md-offset-3">
                <v-select
                  :options="servicios"
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
  </div>
</template>
<script>
//importamos vue-select
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
export default {
  components: {
    vSelect
  },
  data() {
    return {
      clienteSelect: 0,
      selectServProd: 0,
      clientes: [
        { id: "1", cliente: "Juan Diego Diaz" },
        { id: "2", cliente: "Pedro Niño Diaz" }
      ],
      servicios: [
        { id: "1", servicio: "Uñas" },
        { id: "2", servicio: "Pedicure" },
        { id: "3", servicio: "Arroz" }
      ]
    };
  }
};
</script>

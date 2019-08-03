<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fas fa-history"></i> Facturas de Gastos
        <small>Información</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="/admin">
            <i class="fas fa-tachometer-alt"></i> Inicio
          </a>
        </li>
        <li class="active">
          <i class="fas fa-history"></i> Facturas de Gastos
        </li>
      </ol>
    </section>
    <!-- Tabla de todas als Facturas de Gastos -->
    <section class="content">
      <div>
        <a type="button" class="btn btn-primary" href="/admin#/facturarAtencion">
          <i class="fas fa-plus-circle"></i> Nueva Factura
        </a>
      </div>
      <br />
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">
            <i class="far fa-list-alt"></i> Lista de Facturas
          </h3>
        </div>
        <div class="table-responsive container-fluid">
          <table
            id="tablaHistorialFacturas"
            class="table table-bordered table-hover"
            style="width:100%"
          >
            <thead>
              <tr>
                <th># Factura</th>
                <th>Fecha Factura</th>
                <th>Cliente</th>
                <th>Estado Factura</th>
                <th>Valor Total</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody style="font-weight: normal;"></tbody>
            <tfoot>
              <tr>
                <th colspan="4" class="text-right">Total:</th>
                <th colspan="2"></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
</script>

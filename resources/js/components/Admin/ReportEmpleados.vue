<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-chart-area"></i> Citas por Empleados <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="fas fa-chart-area"></i> Citas por Empleados</li>
            </ol>
        </section>
        <section class="content row">
            <div class="col-sm-8 col-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Citas Atendidas por Empleado</h4>
                    </div>
                        <canvas id="citasEmpleado"></canvas>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                //para citas en general
                arrayReservaciones: [],
                varReservaDiv: null,
                chartReservas: null,
                varEmpleados: [],
                varTotalReservas: [],
            }
        },
        methods: {
            listarCitas(){
                let me = this;
                axios.get('/showReservacionEmpleado')
                    .then(function (response) {
                        me.arrayReservaciones = response.data;
                        //cargamos los datos del chart
                        me.loadReservaChart();
                        //console.log(response);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },
            loadReservaChart(){
                let me=this;

                me.arrayReservaciones.map(function(x){//recorremos el array con MAP
                    me.varEmpleados.push(x.nombre);//capturamos los empleados
                    me.varTotalReservas.push(x.cantidad);//cantidad vs empleados
                });

                me.varReservaDiv=document.getElementById('citasEmpleado').getContext('2d');//capturamos en esta variable el id del div canvas

                me.chartReservas = new Chart(me.varReservaDiv, {
                    type: 'bar',
                    data: {
                        labels: me.varEmpleados,//se obtiene
                        datasets: [{
                            label: 'Citas',
                            data: me.varTotalReservas,//obtenemos la cantidad de citas totales por push
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            }
        },
        mounted() {
            this.listarCitas();
        }
    }
</script>

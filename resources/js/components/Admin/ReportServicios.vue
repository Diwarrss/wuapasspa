<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="far fa-chart-bar"></i> Reporte de Servicios <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="far fa-chart-bar"></i> Reporte de Servicios</li>
            </ol>
        </section>
        <section class="content row">
            <div class="col-sm-8 col-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Servicios mas Solicitados</h4>
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
                arrayServicios: [],
                varServiciosDiv: null,
                chartServicios: null,
                varServicios: [],
                varTotalServicios: [],
            }
        },
        methods: {
            listarCitas(){
                let me = this;
                axios.get('/showServices')
                    .then(function (response) {
                        me.arrayServicios = response.data;
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

                me.arrayServicios.map(function(x){//recorremos el array con MAP
                    me.varServicios.push(x.nombre);//capturamos los empleados
                    me.varTotalServicios.push(x.cantidad);//cantidad vs empleados
                });

                me.varServiciosDiv=document.getElementById('citasEmpleado').getContext('2d');//capturamos en esta variable el id del div canvas

                me.chartServicios = new Chart(me.varServiciosDiv, {
                    type: 'bar',
                    data: {
                        labels: me.varServicios,//se obtiene
                        datasets: [{
                            label: 'Servicios',
                            data: me.varTotalServicios,//obtenemos la cantidad de citas totales por push
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

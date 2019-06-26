<template>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <i class="fas fa-chart-line"></i> Citas por Mes <small>Información</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <a href="/admin"><i class="fas fa-tachometer-alt"></i> Inicio</a>
                </li>
                <li class="active"> <i class="fas fa-chart-line"></i> Citas por Mes</li>
            </ol>
        </section>
        <section class="content row">
            <div class="col-sm-6 col-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Citas en Total, año {{year}}</h4>
                    </div>
                        <canvas id="citasMes"></canvas>
                </div>
            </div>

            <div class="col-sm-6 col-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Citas Atendidas, año {{year}}</h4>
                    </div>
                        <canvas id="citasMesAtendidas"></canvas>
                </div>
            </div>

            <div class="col-sm-6 col-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4>Citas No Asistidas, año {{year}}</h4>
                    </div>
                        <canvas id="citasMesNoAsis"></canvas>
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
                arrayCitas: [],
                year: '',
                varcitasMes: null,
                chartcitasMes: null,
                varMesCitas: [],
                varTotalCitas: [],

                //para citas atendidas
                arrayCitasA: [],
                yearA: '',
                varcitasMesA: null,
                chartcitasMesA: null,
                varMesCitasA: [],
                varTotalCitasA: [],

                //para citas no Asistidas
                arrayCitasN: [],
                yearN: '',
                varcitasMesN: null,
                chartcitasMesN: null,
                varMesCitasN: [],
                varTotalCitasN: []
            }
        },
        methods: {
            listarCitas(){
                let me = this;
                axios.get('/showCitasMes')
                    .then(function (response) {
                        me.arrayCitas = response.data;
                        me.year = response.data[0].year;
                        //cargamos los datos del chart
                        me.loadCitasChart();
                        //console.log(response);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },
            listarCitasAtendidas(){
                let me = this;
                axios.get('/showCitasAtendidas')
                    .then(function (response) {
                        me.arrayCitasA = response.data;
                        me.yearA = response.data[0].year;
                        //cargamos los datos del chart
                        me.loadCitasAtendidasChart();
                        //console.log(response);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },
            listarCitasNoAsis(){
                let me = this;
                axios.get('/showCitasNoAsis')
                    .then(function (response) {
                        me.arrayCitasN = response.data;
                        me.yearN = response.data[0].year;
                        //cargamos los datos del chart
                        me.loadCitasNoAsisChart();
                        //console.log(response);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    });
            },
            loadCitasChart(){
                let me=this;
                let meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

                me.arrayCitas.map(function(x){//recorremos el array con MAP
                    me.varMesCitas.push(meses[x.month-1]);//insertamos en los arreglos cada dato de la propiedad mes
                    me.varTotalCitas.push(x.cantidad);
                });

                me.varcitasMes=document.getElementById('citasMes').getContext('2d');//capturamos en esta variable el id del div canvas

                me.chartcitasMes = new Chart(me.varcitasMes, {
                    type: 'bar',
                    data: {
                        labels: me.varMesCitas,//se obtiene
                        datasets: [{
                            label: 'Citas General',
                            data: me.varTotalCitas,//obtenemos la cantidad de citas totales por push
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
            },
            loadCitasAtendidasChart(){
                let me=this;
                let mesesA = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

                me.arrayCitasA.map(function(x){//recorremos el array con MAP
                    me.varMesCitasA.push(mesesA[x.month-1]);//insertamos en los arreglos cada dato de la propiedad mes
                    me.varTotalCitasA.push(x.cantidad);
                });

                me.varcitasMesA=document.getElementById('citasMesAtendidas').getContext('2d');//capturamos en esta variable el id del div canvas

                me.chartcitasMesA = new Chart(me.varcitasMesA, {
                    type: 'bar',
                    data: {
                        labels: me.varMesCitasA,//se obtiene
                        datasets: [{
                            label: 'Citas Atendidas',
                            data: me.varTotalCitasA,//obtenemos la cantidad de citas totales por push
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
            },
            loadCitasNoAsisChart(){
                let me=this;
                let mesesN = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

                me.arrayCitasN.map(function(x){//recorremos el array con MAP
                    me.varMesCitasN.push(mesesN[x.month-1]);//insertamos en los arreglos cada dato de la propiedad mes
                    me.varTotalCitasN.push(x.cantidad);
                });

                me.varcitasMesN=document.getElementById('citasMesNoAsis').getContext('2d');//capturamos en esta variable el id del div canvas

                me.chartcitasMesN = new Chart(me.varcitasMesN, {
                    type: 'bar',
                    data: {
                        labels: me.varMesCitasN,//se obtiene
                        datasets: [{
                            label: 'Citas No Asistidas',
                            data: me.varTotalCitasN,//obtenemos la cantidad de citas totales por push
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
            this.listarCitasAtendidas();
            this.listarCitasNoAsis();
        }
    }
</script>

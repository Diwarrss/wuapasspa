
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//require('./bootstrap');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

//importacion dela libreria de Vuejs
window.Vue = require('vue');
//importacion de libreria Vue Router
import VueRouter from 'vue-router';
Vue.use(VueRouter)

//para el vue datepicker
import Datetime from 'vue-datetime'
Vue.use(Datetime)

//para el vue sheluder
import VueScheduler from 'v-calendar-scheduler';
Vue.use(VueScheduler);

// You need a specific loader for CSS files
import 'vue-datetime/dist/vue-datetime.css'
import 'v-calendar-scheduler/lib/main.css'; //jpara vue sheluder

//importamos el componente de datepicker
/*import Datepicker from 'vuejs-datepicker';
Vue.use(Datepicker);*/

//importamos el componente de veevalidate
/*import VeeValidate from 'vee-validate';
Vue.use(VeeValidate);*/

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//componente de las solicitudes pendientes
/****se pasan a vue router todas
//componente de mi perfil
Vue.component('miperfil', require('./components/Admin/MiPerfil.vue').default);

//componente de las solicitudes pendientes del admin
Vue.component('solicitudes', require('./components/Admin/Solicitudes.vue').default);

//componente de ver todos los Roles
Vue.component('roles', require('./components/Admin/Roles.vue').default);

//componente de ver todos los Empleados
Vue.component('empleados', require('./components/Admin/Empleados.vue').default);

//componente de ver todos los Empleados
Vue.component('clientes', require('./components/Admin/Clientes.vue').default);
 */

//componente de navegacion del Admin
Vue.component('navegacionadmin', require('./components/Admin/NavegacionAdmin.vue').default);
Vue.component('navegacionempleado', require('./components/Empleado/NavegacionEmpleado.vue').default);
Vue.component('navegacionagendador', require('./components/Agendador/NavegacionAgendador.vue').default);

//componentes para optimizar todo
Vue.component('imagenperfil', require('./components/Admin/ImagenPerfil.vue').default);

//----*********** Aqui agregaremos todo configurado con Vue-Router*********
// 0. If using a module system (e.g. via vue-cli), import Vue and VueRouter
// and then call `Vue.use(VueRouter)`.

// 1. Define route components.
// These can be imported from other files
const Error404 = require('./components/Admin/Error404.vue').default;
//para el Admin
const Solicitudes = require('./components/Admin/Solicitudes.vue').default;
const AgendaLibre = require('./components/Admin/AgendaLibre.vue').default;
const AgendaEnEspera = require('./components/Admin/AgendaEnEspera.vue').default;
const AgendaAtendidos = require('./components/Admin/AgendaAtendidos.vue').default;
const AgendaNoAsistio = require('./components/Admin/AgendaNoAsistio.vue').default;
const AgendaCancelaron = require('./components/Admin/AgendaCancelaron.vue').default;
const BuzonSugerencias = require('./components/Admin/BuzonSugerencias.vue').default;
const AgendaCumple = require('./components/Admin/AgendaCumple.vue').default;
const Clientes = require('./components/Admin/Clientes.vue').default;
const Empleados = require('./components/Admin/Empleados.vue').default;
const Roles = require('./components/Admin/Roles.vue').default;
const ReportCitas = require('./components/Admin/ReportCitas.vue').default;
const ReportEmpleados = require('./components/Admin/ReportEmpleados.vue').default;
const ReportServicios = require('./components/Admin/reportServicios.vue').default;
const MiPerfil = require('./components/Admin/MiPerfil.vue').default;
const MiPagina = require('./components/Admin/MiPagina.vue').default;
//para el empleado
const miAgenda = require('./components/Empleado/miAgenda.vue').default;
const misAtenciones = require('./components/Empleado/misAtenciones.vue').default;
//para el modulo de facturacion
const CajaRegistradora = require('./components/Admin/CajaRegistradora.vue').default;
const FacturarAtencion = require('./components/Admin/FacturarAtencion.vue').default;

// 2. Define some routes
// Each route should map to a component. The "component" can
// either be an actual component constructor created via
// `Vue.extend()`, or just a component options object.
// We'll talk about nested routes later.
const routes = [
    { path: '*', component: Error404},
    { path: '/', component: Solicitudes},
    { path: '/agendaLibre', component: AgendaLibre},
    { path: '/agendaEnEspera', component: AgendaEnEspera},
    { path: '/agendaAtendidos', component: AgendaAtendidos},
    { path: '/agendaNoAsistio', component: AgendaNoAsistio},
    { path: '/agendaCancelaron', component: AgendaCancelaron},
    { path: '/buzonSugerencias', component: BuzonSugerencias},
    { path: '/agendaCumple', component: AgendaCumple},
    { path: '/clientes', component: Clientes},
    { path: '/empleados', component: Empleados},
    { path: '/roles', component: Roles},
    { path: '/reportCitas', component: ReportCitas},
    { path: '/reportEmpleados', component: ReportEmpleados},
    { path: '/reportServicios', component: ReportServicios},
    { path: '/miperfil', component: MiPerfil},
    { path: '/mipagina', component: MiPagina},
    { path: '/miAgenda', component: miAgenda},
    { path: '/misAtenciones', component: misAtenciones},
    { path: '/cajaRegistradora', component: CajaRegistradora},
    { path: '/facturarAtencion', component: FacturarAtencion},
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
    //mode: 'history',//quitando el hash # que viene por defecto con vue-router
    routes, // short for `routes: routes`
    base: '/admin'
})

 //el menu numero 3 es para mostrar el componente de listar las citas.
const app = new Vue({
    el: '#app',
    router
});

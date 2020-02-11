
require('./bootstrap');

window.Vue = require('vue');




Vue.component('quienes-somos', require('./components/QuienesSomos.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('inicio', require('./components/Inicio.vue').default);
Vue.component('adopcion', require('./components/RegistrarAdopcion.vue').default);
Vue.component('donaciones', require('./components/RegistrarDonacion.vue').default);
Vue.component('visualizar-donaciones', require('./components/VisualizarDonacion.vue').default);
Vue.component('donacion-dos', require('./components/DonacionOpcion.vue').default);


const app = new Vue({
    el: '#app',
    data:{
        menu: 0,        
    }
});


require('./bootstrap');

window.Vue = require('vue');




Vue.component('quienes-somos', require('./components/QuienesSomos.vue').default);
Vue.component('usuarios', require('./components/Usuarios.vue').default);
Vue.component('inicio', require('./components/Inicio.vue').default);
Vue.component('adopcion', require('./components/RegistrarAdopcion.vue').default);

const app = new Vue({
    el: '#app',
    data:{
        menu: 0,        
    }
});


require('./bootstrap');

window.Vue = require('vue');



/**ADMIN - USUARIO -- CLIENTE -- VISITOR */
Vue.component('quienes-somos', require('./components/QuienesSomos.vue').default);
Vue.component('adopcion', require('./components/RegistrarAdopcion.vue').default);
Vue.component('informacion-general', require('./components/InformacionGeneral.vue').default);
Vue.component('inicio-imagenes', require('./components/InicioCarousel.vue').default);
Vue.component('inicio-general', require('./components/InicioGeneral.vue').default);

/**ADMIN*/
Vue.component('registrar-usuarios', require('./components/RegistrarUsuarios.vue').default);
Vue.component('registrar-diagnostico', require('./components/RegistrarDiagnostico.vue').default);
Vue.component('registrar-donaciones', require('./components/RegistrarDonacion.vue').default);

/**ADMIN - USUARIO -- CLIENTE */
Vue.component('adopcion', require('./components/RegistrarAdopcion.vue').default);
Vue.component('visualizar-donaciones', require('./components/VisualizarDonacion.vue').default);


const app = new Vue({
    el: '#app',
    data:{
        menu: 0,        
    }
});

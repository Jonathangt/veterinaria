
require('./bootstrap');

window.Vue = require('vue');



/**ADMIN - USUARIO -- CLIENTE -- VISITOR */
Vue.component('quienes-somos', require('./components/public/QuienesSomos.vue').default);
//Vue.component('adopcion', require('./components/public/RegistrarAdopcion.vue').default);
Vue.component('informacion-general', require('./components/public/InformacionGeneral.vue').default);
Vue.component('inicio-imagenes', require('./components/public/InicioCarousel.vue').default);
Vue.component('inicio-general', require('./components/public/InicioGeneral.vue').default);
Vue.component('inicio-adopcion', require('./components/public/MascotasAdapcion.vue').default);

/*CLIENTE  */
Vue.component('vizualizar-consulta', require('./components/public/VisualizarConsulta.vue').default);



/**ADMIN*/
Vue.component('registrar-usuarios', require('./components/admin/RegistrarUsuarios.vue').default);
Vue.component('registrar-consulta', require('./components/admin/RegistrarConsulta.vue').default);
Vue.component('registrar-donaciones', require('./components/admin/RegistrarDonacion.vue').default);
Vue.component('registrar-clientes', require('./components/admin/RegistrarCliente.vue').default);
Vue.component('registrar-mascota', require('./components/admin/RegistrarMascota.vue').default);
Vue.component('registrar-informacion', require('./components/admin/RegistrarInformacion.vue').default);
Vue.component('registrar-datos', require('./components/admin/RegistrarDatos.vue').default);
Vue.component('registrar-adopcion', require('./components/admin/RegistrarAdopcion.vue').default);



/**ADMIN - USUARIO -- CLIENTE */
Vue.component('adopcion', require('./components/RegistrarAdopcion.vue').default);
Vue.component('visualizar-donaciones', require('./components/public/VisualizarDonacion.vue').default);


const app = new Vue({
    el: '#app',
    data:{
        menu: 0,        
    }
});

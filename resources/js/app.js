
require('./bootstrap');

window.Vue = require('vue');



Vue.component('quienes-somos', require('./components/QuienesSomos.vue').default);
Vue.component('quienes', require('./components/Quienes.vue').default);

const app = new Vue({
    el: '#app',
    data:{
        menu: 0,        
    }
});

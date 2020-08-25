require('./bootstrap');

import Vue from 'vue';
import Cars from "./components/Cars";
import Create from "./components/Create";
import VueSwal from 'vue-swal';

Vue.use(VueSwal);

const app = new Vue({
    el: '#app',

    components: {
        Cars,
        Create,
    },
});

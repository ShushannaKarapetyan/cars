require('./bootstrap');

import Cars from "./components/Cars";
import Create from "./components/Create";

import Vue from 'vue';

const app = new Vue({
    el: '#app',
    components: {
        Cars,
        Create,
    }
});

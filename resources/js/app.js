/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Event = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('Try', require('./components/Try.vue').default);
Vue.component('patientslist', require('./components/patients-list.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import prescriptionlist from './components/pharmacy-list.vue'
import Userreport from './components/user-report.vue'
import viewpatient from './components/patientinformation.vue'
import consultationview from './components/consultationview.vue'
const app = new Vue({
    el: '#app',
   	components: { 
   	prescriptionlist,
   	Userreport,
   	viewpatient,
   	consultationview,
    }
    

});

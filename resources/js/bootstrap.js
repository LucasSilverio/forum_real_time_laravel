window._ = require('lodash');

try {
    // require('bootstrap');

    window.$ = window.jQuery = require('jquery');

    require('materialize-css/dist/js/materialize.js');
    require('./parallax-header.js');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'fedcdfb100430e11ca79',
    forceTLS: true,    
    cluster: 'sa1'
});


import swal from 'sweetalert2';
import Vue from 'vue';

const successCallback = (response) => {
    return response;
}

const errorCallback = (error) => {
   if (error.response.status === 401) {
        swal({
            title: 'Autenticação',
            text: 'Para acessar este recurso você precisa estar autenticado! Você será redirecionado.',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ok!',
            cancelButtonText: 'Não, obrigado!'
        }).then((result) => {
            if (result.value) {
                window.location = '/login';
            }
        });
   } else {
        swal({
            title: 'Error',
            text: 'Algo deu errado!',
            type: 'error',
            showCancelButton: false,
            confirmButtonText: 'Ok!'
        });
   }
    return Promise.reject(error);
}

window.axios.interceptors.response.use(successCallback, errorCallback);

Vue.component('loader', require('./commons/AxiosLoader.vue').default);

const commonApps = new Vue({
    el: '#loader'
})

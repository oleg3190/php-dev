import Echo from 'laravel-echo'
import InfiniteLoading from 'vue-infinite-loading';


window.io = require('socket.io-client')
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
});


window.Vue = require('vue');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
Vue.use(InfiniteLoading);


let token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

Vue.component('message-form', require('./components/messageForm.vue'));
const app = new Vue({
    el: '#app'
});
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-messages', require('./components/ChatMessages').default);
Vue.component('chat-form', require('./components/ChatForm').default);

const app = new Vue({
    el: '#app',

    data: {
        messages: []
    },

    created() {
        this.fetchMessages();

        Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user,
                    position: 'left',
                    showIcon: true,
                    read: 0
                });
            });
    },

    watch: {
        messages: function (messages) {
            console.log(messages.length - 1)
            for (const key in messages) {
                if (key == (messages.length - 1)) {
                    this.messages[key].showIcon = true
                    console.log(this.messages, 'check ìn for')
                } else {
                    this.messages[key].showIcon = false
                }
            }
            console.log(this.messages)
        }
    },

    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            console.log(message)
            message.position = 'right'
            this.messages.push(message);
            console.log(message,this.messages)

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        },

        clearMessage() {
            axios.post('delete/message').then(function (response) {
                //console.log(response.data);
            });
            this.fetchMessages()
        }
    }
});

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

import { Fireworks } from 'fireworks-js'

const app = new Vue({
    el: '#app',
    data: {
        messages: [],
        selected: null,
        type: 0,
        count: 0,
        show: false
    },

    created() {
        this.fetchMessages();
        Echo.private('chat')
            .listen('MessageSent', (e) => {
                this.messages.push({
                    message: e.message.message,
                    user: e.user,
                    type: this.type,
                    position: 'left',
                    showIcon: true,
                    read: 0
                });
            });
    },
    watch: {
        messages: {
          handler: function (messages) {
              for (const key in messages) {
                  if (key == (messages.length - 1)) {
                      this.messages[key].showIcon = true
                  } else {
                      this.messages[key].showIcon = false
                  }


              }
          }
        },

    },
    updated () {
        if (this.count === 1) {
            this.scrollToEnd();
        }
        this.count++
    },
    mounted() {
        const container = document.querySelector('.fireworks-example')
        const fireworks = new Fireworks(container, {
            rocketsPoint: 50,
            hue: { min: 0, max: 360 },
            delay: { min: 15, max: 30 },
            speed: 1,
            acceleration: 1.05,
            friction: 0.95,
            gravity: 1.5,
            particles: 50,
            trace: 3,
            explosion: 5,
            autoresize: true,
            brightness: {
                min: 50,
                max: 80,
                decay: { min: 0.015, max: 0.03 }
            },
            mouse: {
                click: false,
                move: false,
                max: 3
            },
            boundaries: {
                x: 50,
                y: 50,
                width: container.clientWidth,
                height: container.clientHeight
            },
            sound: {
                enable: true,
                files: [
                    'explosion0.mp3',
                    'explosion1.mp3',
                    'explosion2.mp3'
                ],
                volume: { min: 1, max: 2 },
            }
        });
        fireworks.start();
        this.show = true
    },
    methods: {
        scrollToEnd () {
            const content = this.$refs.messagesContainer;
            content.scrollTop = content.scrollHeight;
        },
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },

        addMessage(message) {
            message.position = 'right'
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        },

        clearMessage() {
            axios.post('delete/message').then(function (response) {
                //console.log(response.data);
            });
            this.fetchMessages()
        },

        handleInputChat() {
            const item = this.messages.slice(-1).pop()
            axios.post('update/read', {message: item.message}).then(function (response) {
                //console.log(response.data);
            });
        },

        hoverItemMessage(id) {
            this.selected = id
        },

        outHover() {
            this.selected = null
        },

        updateType(type) {
            this.type = type
        }
    }
});

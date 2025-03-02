import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import Echo from 'laravel-echo';
window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '4126cc215b26910f04eb',
    cluster: 'eu',
    encrypted: true,
});


import { createApp } from 'vue';
import ChatComponent from './components/ChatComponent.vue';

const app = createApp({});
app.component('chat-component', ChatComponent);
app.mount('#app');

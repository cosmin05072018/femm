import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Pusher = require('pusher-js');
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true,
});


import { createApp } from 'vue';
import ChatComponent from './components/ChatComponent.vue';

const app = createApp({});
// app.component('chat-component', ChatComponent);
// app.mount('#app');
createApp(app)
  .component('chat-component', ChatComponent) // Înregistrează componenta global
  .mount('#app'); // Montează aplicația pe elementul cu id-ul 'app'

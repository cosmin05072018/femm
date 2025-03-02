<template>
    <div class="chat-container">
        <div v-if="loading">Se încarcă chat-ul...</div>

        <div v-else>
            <div class="messages">
                <div v-for="message in messages" :key="message.id" class="message">
                    <strong>{{ message.sender.name }}:</strong> {{ message.message }}
                </div>
            </div>

            <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Scrie un mesaj..." />
            <button @click="sendMessage">Trimite</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
    data() {
        return {
            newMessage: '',
            messages: [],
            userId: null,
            hotelId: null,
            departmentId: null,
            roleId: null,
            groupId: null,
            chatLevel: 1, // Default chat level
            loading: true,
        };
    },
    async mounted() {
        try {
            const userResponse = await axios.get('/api/user');
            const user = userResponse.data;

            this.userId = user.id;
            this.hotelId = user.hotel_id;
            this.departmentId = user.department_id;
            this.roleId = user.role_id;

            this.groupId = `hotel_${this.hotelId}_department_${this.departmentId}`;

            await this.fetchMessages();

            window.Pusher = Pusher;
            window.Echo = new Echo({
                broadcaster: 'pusher',
                key: import.meta.env.VITE_PUSHER_APP_KEY,
                cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
                encrypted: true,
            });

            window.Echo.channel(`chat.${this.groupId}`)
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                });

        } catch (error) {
            console.error("Eroare la încărcarea utilizatorului:", error);
        } finally {
            this.loading = false;
        }
    },
    methods: {
        fetchMessages() {
            let endpoint;
            switch (this.chatLevel) {
                case 1:
                    endpoint = `/fantastic-admin/department/users/chat-nivel1`;
                    break;
                case 2:
                    endpoint = `/fantastic-admin/department/users/chat-nivel2`;
                    break;
                case 3:
                    endpoint = `/fantastic-admin/department/users/chat-nivel3`;
                    break;
                default:
                    endpoint = `/fantastic-admin/department/users/chat-nivel1`;
            }
            axios.get(endpoint).then(response => {
                this.messages = response.data;
            });
        },
        sendMessage() {
            if (this.newMessage.trim() === '') return;

            let endpoint;
            switch (this.chatLevel) {
                case 1:
                    endpoint = `/fantastic-admin/department/users/create-chat-nivel1`;
                    break;
                case 2:
                    endpoint = `/fantastic-admin/department/users/create-chat-nivel2`;
                    break;
                case 3:
                    endpoint = `/fantastic-admin/department/users/create-chat-nivel3`;
                    break;
                default:
                    endpoint = `/fantastic-admin/department/users/create-chat-nivel1`;
            }

            axios.post(endpoint, {
                message: this.newMessage,
                group_id: this.groupId
            }).then(response => {
                this.newMessage = '';
            });
        }
    }
};
</script>


<style scoped>
.chat-container {
    border: 1px solid #ddd;
    padding: 10px;
    max-width: 400px;
}
.messages {
    height: 200px;
    overflow-y: auto;
    margin-bottom: 10px;
}
.message {
    padding: 5px;
    border-bottom: 1px solid #eee;
}
</style>

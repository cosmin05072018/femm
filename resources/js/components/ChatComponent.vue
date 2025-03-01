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
            loading: true,
        };
    },
    async mounted() {
        try {
            const userResponse = await axios.get('/api/user'); // Obținem utilizatorul autentificat
            const user = userResponse.data;

            this.userId = user.id;
            this.hotelId = user.hotel_id;
            this.departmentId = user.department_id;
            this.roleId = user.role_id;

            this.groupId = `hotel_${this.hotelId}_department_${this.departmentId}`; // Grup dinamic

            await this.fetchMessages();

            // Configurare Laravel Echo + Pusher
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
        async fetchMessages() {
            try {
                const response = await axios.get(`/api/chat/messages/${this.groupId}`);
                this.messages = response.data;
            } catch (error) {
                console.error("Eroare la încărcarea mesajelor:", error);
            }
        },
        async sendMessage() {
            if (this.newMessage.trim() === '') return;

            try {
                await axios.post('/api/chat/send', {
                    message: this.newMessage,
                    group_id: this.groupId,
                });

                this.newMessage = '';
            } catch (error) {
                console.error("Eroare la trimiterea mesajului:", error);
            }
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

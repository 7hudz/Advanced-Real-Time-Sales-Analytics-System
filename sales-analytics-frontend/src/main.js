import './assets/main.css'
import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// Pusher and Laravel Echo
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

const app = createApp(App)

app.use(router)

// Pusher configuration
window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: 'pusher',
    key: 'c61d6a894bce05dfb3f9', // Pusher App Key
    cluster: 'eu',              // Pusher App Cluster
    forceTLS: true,
});

app.config.globalProperties.$echo = echo

app.mount('#app')

import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'primeicons/primeicons.css'
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import App from './App.vue'

import './plugins/axios'

import ToastService from 'primevue/toastservice';

const app = createApp(App)

app.use(createPinia())
app.use(PrimeVue, {
    theme: {
        preset: Aura,
    }
})
app.use(ToastService)

app.mount('#app')

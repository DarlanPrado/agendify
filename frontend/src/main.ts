import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'primeicons/primeicons.css'
import PrimeVue from 'primevue/config';
import Lara from '@primevue/themes/lara';
import App from './App.vue'

import './plugins/axios'

import ToastService from 'primevue/toastservice';
import ConfirmationService from 'primevue/confirmationservice';

const app = createApp(App)

app.use(createPinia())
app.use(PrimeVue, {
    theme: {
        preset: Lara,
    }
})
app.use(ToastService)
app.use(ConfirmationService)

app.mount('#app')

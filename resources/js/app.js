import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'

import { createApp } from 'vue'

import SeekerProfileAdmin from './components/SeekerProfileAdmin.vue'
import PaymentList from './components/payments/PaymentList.vue' 

const app = createApp({})

// Đăng ký cả hai component
app.component('seeker-profile-admin', SeekerProfileAdmin)
app.component('payment-admin', PaymentList) 

app.mount('#vue-wrapper')

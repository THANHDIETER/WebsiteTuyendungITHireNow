import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'

// Import Vue components
import SeekerProfileAdmin from './components/SeekerProfileAdmin.vue'
import PaymentList from './components/payments/PaymentList.vue'
import EmployerJobPortal from './components/employers/EmployerJobPortal.vue'

// Khởi tạo Vue app
const app = createApp({})
// Đăng ký các component
app.component('seeker-profile-admin', SeekerProfileAdmin)
app.component('payment-admin', PaymentList)
app.component('employer-job-portal', EmployerJobPortal)

// Mount vào #vue-wrapper (Blade layout phải có ID này)
app.mount('#vue-wrapper')
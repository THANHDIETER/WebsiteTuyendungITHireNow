import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'
// Import Vue components
import SeekerProfileAdmin from './components/SeekerProfileAdmin.vue'
import PaymentList from './components/payments/PaymentList.vue'
import EmployerJobPortal from './components/employers/EmployerJobPortal.vue'
import JobApplicationsList from './components/JobApplicationsList.vue'
<<<<<<< HEAD
=======

>>>>>>> b9415a3b41f90f6ec4df40f97d47fc6235287f05
// Khởi tạo Vue app
const app = createApp({})
// Đăng ký các component
app.component('seeker-profile-admin', SeekerProfileAdmin)
app.component('payment-admin', PaymentList)
app.component('employer-job-portal', EmployerJobPortal)
app.component('employer-job-application', JobApplicationsList)
<<<<<<< HEAD
=======

>>>>>>> b9415a3b41f90f6ec4df40f97d47fc6235287f05

// Mount vào #vue-wrapper (Blade layout phải có ID này)
app.mount('#vue-wrapper')

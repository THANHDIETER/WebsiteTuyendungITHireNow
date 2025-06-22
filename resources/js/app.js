import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'

// Import Vue components
import SeekerProfileAdmin from './components/SeekerProfileAdmin.vue'
import PaymentList from './components/payments/PaymentList.vue'
import EmployerJobPortal from './components/employers/EmployerJobPortal.vue'
import JobApplicationsList from './components/JobApplicationsList.vue'
import bank_account from './components/bank_account/bank_account.vue'
import bank_log from './components/bank_log/Listbanklog.vue'

// Khởi tạo Vue app
const app = createApp({})
// Đăng ký các component
app.component('seeker-profile-admin', SeekerProfileAdmin)
app.component('payment-admin', PaymentList)
app.component('employer-job-portal', EmployerJobPortal)
app.component('employer-job-application', JobApplicationsList)
app.component('bank-account-admin', bank_account)
app.component('banklog-account-admin', bank_log)
// Mount vào #vue-wrapper (Blade layout phải có ID này)
app.mount('#vue-wrapper')

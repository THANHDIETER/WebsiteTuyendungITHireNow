// ✅ 1. Import Echo, Pusher, window setup
import "./bootstrap";

import '../css/app.css';

// ✅ 3. Import Vue và các components
import { createApp } from "vue";
import SeekerProfileAdmin from "./components/SeekerProfileAdmin.vue";
import PaymentList from "./components/payments/PaymentList.vue";
import EmployerJobPortal from "./components/employers/EmployerJobPortal.vue";
import JobApplicationsList from "./components/JobApplicationsList.vue";
import bank_account from "./components/bank_account/bank_account.vue";
import bank_log from "./components/bank_log/Listbanklog.vue";
import job_application_admin from "./components/admin/JobApplicationsList.vue";

// import chat_box from "./components/chatbox/ChatBox.vue";

// ✅ 4. Khởi tạo Vue
const app = createApp({});
app.component("seeker-profile-admin", SeekerProfileAdmin);
app.component("payment-admin", PaymentList);
app.component("employer-job-portal", EmployerJobPortal);
app.component("employer-job-application", JobApplicationsList);
app.component("bank-account-admin", bank_account);
app.component("banklog-account-admin", bank_log);
app.component("job-application-admin", job_application_admin);

// app.component("chat-box", chat_box);
const el = document.getElementById("vue-wrapper");
if (el) {
    app.mount("#vue-wrapper");
}









import { createApp } from "vue";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import "bootstrap-icons/font/bootstrap-icons.css";
// Import Vue components
import SeekerProfileAdmin from "./components/SeekerProfileAdmin.vue";
import PaymentList from "./components/payments/PaymentList.vue";
import EmployerJobPortal from "./components/employers/EmployerJobPortal.vue";
import JobApplicationsList from "./components/JobApplicationsList.vue";

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
const app = createApp({});
// Đăng ký các component

app.component("seeker-profile-admin", SeekerProfileAdmin);
app.component("payment-admin", PaymentList);
app.component("employer-job-portal", EmployerJobPortal);
app.component("employer-job-application", JobApplicationsList);

// Mount vào #vue-wrapper (Blade layout phải có ID này)
app.mount("#vue-wrapper");

window.Echo.private(`notifications.${window.Laravel.userId}`).listen(
    ".notification.sent",
    (e) => {
        alert(e.message);
        // hoặc render vào HTML: document.querySelector('#notifications').innerHTML += ...
    }
);

import "./bootstrap";

if (window.Laravel?.userId) {
    Echo.private(`notifications.${window.Laravel.userId}`).listen(
        ".notification.sent",
        (e) => {
            const time = new Date().toLocaleTimeString("vi-VN", {
                hour: "2-digit",
                minute: "2-digit",
            });

            const newItem = `
                <li class="d-flex align-items-center b-l-primary">
                    <div class="flex-grow-1">
                        <span>${time}</span>
                        <a href="${e.link_url}">
                            <h5>${e.message}</h5>
                        </a>
                        <h6>${window.APP_NAME ?? "Laravel"}</h6>
                    </div>
                    <div class="flex-shrink-0">
                        <img class="b-r-15 img-40" src="/assets/images/avatar/default.jpg" alt="">
                    </div>
                </li>`;

            const list = document.getElementById("noti-list");
            const badge = document.getElementById("noti-count");

            if (list) {
                const empty = list.querySelector(".text-muted");
                if (empty) empty.remove();
                list.insertAdjacentHTML("afterbegin", newItem);
            }

            if (badge) {
                let count = parseInt(badge.innerText) || 0;
                badge.innerText = count + 1;
                badge.classList.remove("d-none");
            }
        }
    );
}

app.component('seeker-profile-admin', SeekerProfileAdmin)
app.component('payment-admin', PaymentList)
app.component('employer-job-portal', EmployerJobPortal)
app.component('employer-job-application', JobApplicationsList)
app.component('bank-account-admin', bank_account)
app.component('banklog-account-admin', bank_log)
// Mount vào #vue-wrapper (Blade layout phải có ID này)
app.mount('#vue-wrapper')


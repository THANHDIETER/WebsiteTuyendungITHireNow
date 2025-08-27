import Echo from "laravel-echo";
import Pusher from "pusher-js";
import { createApp } from "vue";

const app = createApp({});

import job_list from "./components/JobList.vue";

app.component("job-list", job_list);

const el = document.getElementById("vue-wrapper");
if (el) {
    app.mount("#vue-wrapper");
}

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "1ea633f39dfb08c3c0c2",
    cluster: "ap1",
    forceTLS: true,
});

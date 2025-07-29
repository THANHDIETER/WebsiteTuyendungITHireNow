import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
<<<<<<< HEAD
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
=======
>>>>>>> 45aff071f646e7291ddfc422a2b5dd7f837f012b

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '1ea633f39dfb08c3c0c2', 
    cluster: 'ap1',
    encrypted: true,
});

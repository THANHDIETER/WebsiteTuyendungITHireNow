import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '1ea633f39dfb08c3c0c2', 
    cluster: 'ap1',
    encrypted: true,
});
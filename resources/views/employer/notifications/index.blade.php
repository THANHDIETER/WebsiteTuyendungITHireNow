<ul id="notifications">
@foreach(auth()->user()->unreadNotifications as $notification)
    <li>
        <a href="{{ $notification->data['link_url'] }}">{{ $notification->data['message'] }}</a>
    </li>
@endforeach
</ul>

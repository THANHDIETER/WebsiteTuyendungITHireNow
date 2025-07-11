@foreach(auth()->user()->unreadNotifications->take(5) as $noti)
    <li class="d-flex align-items-center b-l-primary" data-id="{{ $noti->id }}">
        <div class="flex-grow-1">
            <span>{{ $noti->created_at->diffForHumans() }}</span>
            <a href="{{ $noti->data['link_url'] }}">
                <h5>{{ $noti->data['message'] }}</h5>
            </a>
            <h6>{{ config('app.name') }}</h6>
        </div>
        <div class="flex-shrink-0">
            <img class="b-r-15 img-40" src="{{ asset('assets/images/avatar/default.jpg') }}" alt="">
        </div>
    </li>
@endforeach
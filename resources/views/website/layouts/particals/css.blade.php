<meta charset="utf-8">
<title>
    @if(!empty($title))
        {{ $title }} | {{ $seo->title ?? '' }}
    @else
        {{ $seo->title ?? '' }}
    @endif
</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="keywords" content="{{ $seo->keywords ?? 'Từ khóa ở đây' }}" />
<meta name="author" content="hastech" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="application-name" content="{{ $seo->title ?? '' }}">
<meta property="og:title" content="{{ $seo->title ?? ''}}">
<meta name="description" content="{{ $seo->description ?? 'Mô tả website của bạn ở đây' }}" />
<meta property="og:description" content="{{ $seo->description ?? 'Mô tả website của bạn ở đây' }}">
<meta name="twitter:description" content="{{ $seo->description ?? 'Mô tả website của bạn ở đây' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $seo->title ?? '' }}">
<meta property="og:site_name" content="{{ $seo->title ?? '' }}">
<meta property="og:image:alt" content="{{ $seo->title ?? '' }}">

@if(!empty($favicon))
  @php
    $faviconUrl = asset('storage/' . $favicon->image_path);
    @endphp
  <meta property="og:image" content="{{ $faviconUrl }}">
  <meta name="twitter:image" content="{{ $faviconUrl }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
  <link rel="shortcut icon" href="{{ $faviconUrl }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl }}">
@endif
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap"
  rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!--== Swiper CSS ==-->
<link href="{{ asset('client/assets/css/swiper.min.css') }}" rel="stylesheet" />
<!--== Fancybox Min CSS ==-->
<link href="{{ asset('client/assets/css/fancybox.min.css') }}" rel="stylesheet" />
<!--== Aos Min CSS ==-->
<link href="{{ asset('client/assets/css/aos.min.css') }}" rel="stylesheet" />

<!--== Main Style CSS ==-->
<link href="{{ asset('client/assets/css/style.css') }}" rel="stylesheet" />
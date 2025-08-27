<meta charset="utf-8">
<title>{{ $title ?? 'Admin' }}</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="keywords" content="{{ $keyword ?? 'Từ khóa ở đây' }}" />
<meta name="author" content="hastech" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:title" content="{{ $metaTitle ?? config('app.name') }}">
<meta name="description" content="{{ $metaDescription ?? 'Mô tả website của bạn ở đây' }}" />
<meta property="og:description" content="{{ $metaDescription ?? 'Mô tả website của bạn ở đây' }}">
<meta name="twitter:description" content="{{ $metaDescription ?? 'Mô tả website của bạn ở đây' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitle ?? config('app.name') }}">
<meta property="og:site_name" content="{{ config('app.name') }}">
@if(!empty($favicon))
    @php
        $faviconUrl = asset('storage/' . $favicon->image_path);
    @endphp
    <meta property="og:image" content="{{ $faviconUrl }}">
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta name="twitter:image" content="{{ $faviconUrl }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $faviconUrl }}">
@endif
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/css/vendors/themify-icons/themify-icons/css/themify.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css/animate.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/weather-icons/css/weather-icons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/simple-datatables/dist/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link id="color" rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" media="screen">

{{-- <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'Laravel CRM') }} | @yield('title','Dashboard')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Bootstrap 5 CSS -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<!-- Custom app CSS -->
<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">

<!-- Full-Calendar CSS (via npm) -->
<link href="{{ asset('node_modules/@fullcalendar/core/main.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/@fullcalendar/daygrid/main.min.css') }}" rel="stylesheet">
<link href="{{ asset('node_modules/@fullcalendar/timegrid/main.min.css') }}" rel="stylesheet">

@stack('styles') --}}


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'Laravel CRM') }} | @yield('title','Dashboard')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Bootstrap 5 CSS (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom app CSS (optional, keep if you have your own styles) -->
<link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">



<!-- FullCalendar CSS (CDN) -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/daygrid/index.global.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/timegrid/index.global.min.css" rel="stylesheet">

@stack('styles')

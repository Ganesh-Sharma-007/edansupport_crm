<!doctype html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body>
<div id="app">
    @include('partials.navbar')
    <div class="container-fluid">
        <div class="row">
            @include('partials.sidebar')
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title','Dashboard')</h1>
                </div>
                <x-alert type="success" :message="session('success')" />
                <x-alert type="danger"  :message="session('error')" />
                @yield('content')
            </main>
        </div>
    </div>
</div>
@include('partials.scripts')
@stack('scripts')
</body>
</html>
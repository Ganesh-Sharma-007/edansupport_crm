<!doctype html>
<html lang="en">
<head>
    @include('partials.head')
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('partials.scripts')
</body>
</html>
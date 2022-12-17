<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    {{-- Any additional links --}}
    @yield('links')
</head>
<body>

    {{-- If there is a status info or error message, display an alert for it --}}
    <div class="alert-area px-0 col-lg-4 col-xl-5 col-md-6 mx-auto">
        @if (session()->has('status'))\
        <div class="alert alert-info mt-3">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ session()->get('status') }}
        </div>
        @endif

        @if ($errors->has('status'))
        <div class="alert alert-danger mt-3">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ $errors->get('status')[0] }}
        </div>
        @endif

        {{-- Auto dismiss the alert --}}
        <script>
            if(document.querySelector('.alert-area .alert') != null){
                setTimeout(function(){
                    document.querySelector('.alert-area .alert .close').click();
                }, 4000);
            }
        </script>
    </div>

    @yield('content')

    <script src="https://kit.fontawesome.com/ce4529ea37.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Any additional scripts --}}
    @yield('scripts')
</body>
</html>

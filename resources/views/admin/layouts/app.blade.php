<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/grid.css') }}">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
            crossorigin="anonymous"
    ></script>

    @yield('title-css')

    <title>@yield('title', 'Hub-admin')</title>
</head>
<body>
    <div id="app">
        <div id="navigation">
            @include('layouts.navigation')
        </div>

        <main class="py-4">
            @if (session()->has('message.level'))
                <div class="container">
                    <div class="alert alert-{{ session('message.level') }}">
                        {!! session('message.content') !!}
                    </div>
                </div>
            @endif
            @if (isset($breadcrumbs))
            @include('utils.breadcrumbs', [
                'breadcrumbs' => $breadcrumbs,
            ])
            @endif
            @yield('content')
        </main>

        <footer class="footer">
            <div class="container">
                <p class="text-muted text-right copyright">© <?= date('Y') ?> hub-admin</p>
            </div>
        </footer>
    </div>

    @yield('js')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>

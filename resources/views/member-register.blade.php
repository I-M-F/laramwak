<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration </title>
    <!-- <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}"> -->
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">
    @livewireStyles
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top:50px">
            <div class="col-md-6 offset-md-3">
                <h1>Member Registration Form </h1><hr>
                @livewire('member-registartion-form')
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html>
@extends('backend.layouts.app')
@section('content')



<!DOCTYPE html>

<html lang="en">

<head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>



</head>

<body>

    <div class="content-wrapper">

        <div class="row text-center">

            <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">

                <div class="row">

                    <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">

                        <i class="fa fa-frown-o" aria-hidden="true" style="font-size:48px;color:red"></i>

                        <h2 class="m-0">REJECTED</h2>

                        <h6>User <span class="text-info bg-dark"> {{$member_dets->name}} </span> Rejected - mwak.co.ke</h6>

                        <p>If Rejected contact Admin <span class="text-info">+254 718111186 </span>, or email <span class="text-info">info@mwak.ke</span> sorry of rthe inconvinece.</p>



                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>


@endsection
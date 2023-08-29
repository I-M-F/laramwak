@extends('backend.layouts.app')
@section('content')


<h2 class="m-0">Rejected</h2>

<h6>User <span class="text-info bg-dark"> {{$status_role->name}} </span> Rejected - mwak.co.ke</h6>

<p>If Rejected contact Admin <span class="text-info">+254 718111186 </span>, or email <span class="text-info">info@mwak.ke</span> sorry of rthe inconvinece.</p>


<!DOCTYPE html>

<html lang="en">

<head>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

    <!-- <style type="text/css">
        body {

            margin-top: 150px;
            background-color: #C4CCD9;



        }


        i {

            font-size: 90px !important;

            color: #5D6572;

            margin-top: 20px;

        }

        .error-main {

            background-color: #fff;

            box-shadow: 0px 10px 10px -10px #5D6572;
            box-shadow: -2px 0px 5px 7px rgba(0, 0, 0, 0.33);
            -webkit-box-shadow: -2px 0px 5px 7px rgba(0, 0, 0, 0.33);
            -moz-box-shadow: -2px 0px 5px 7px rgba(0, 0, 0, 0.33);

        }

        .error-main h1 {

            font-weight: bold;

            color: #444444;

            font-size: 100px;

            text-shadow: 2px 4px 5px #6E6E6E;

        }

        .error-main h6 {

            color: #42494F;

        }

        .error-main p {

            color: #9897A0;

            font-size: 14px;

        }
    </style> -->

</head>

<body>

    <div class="content-wrapper">

        <div class="row text-center">

            <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">

                <div class="row">

                    <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">

                        <i class="fa fa-frown-o" aria-hidden="true" style="font-size:48px;color:red"></i>

                        <h2 class="m-0">Unverified</h2>

                        <h6>User <span class="text-info bg-dark">
                                {{$member_dets->name}}
                            </span> not verified - mwak.co.ke</h6>

                        <p>If not verified in the next 48 hours contact Admin <br> <span class="text-info">
                                <a href="tel:+254 718111186">+254718111186</a>

                            </span> <br> or <br> email <span class="text-info">info@mwak.ke</span> <br>
                            sorry for the inconvinece.</p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>



@endsection
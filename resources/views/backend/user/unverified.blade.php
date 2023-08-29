@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">
    <div class="row text-center">
        <div class="col-lg-6 offset-lg-3 col-sm-6 offset-sm-3 col-12 p-3 error-main">
            <div class="row">
                <div class="col-lg-8 col-12 col-sm-10 offset-lg-2 offset-sm-1">
                    <i class="fa fa-frown-o" aria-hidden="true" style="font-size:48px;color:red"></i>
                    @if ($member_dets->role == 'Rejected')
                    <i class="fa fa-frown-o" aria-hidden="true" style="font-size:48px;color:red"></i>

                    <h2 class="m-0">Rejected</h2>
                    <h6>User <span class="text-info bg-dark">{{$member_dets->name}}</span> Rejected - mwak.co.ke</h6>
                    <p>If Rejected, please contact Admin <br><span class="text-info"><a href="tel:+254718111186">+254 718111186</a></span> <br> or <br> email <span class="text-info">info@mwak.ke</span> <br> Sorry for the inconvenience.</p>
                    @elseif ($member_dets->role == 'Unverified')
                    <i class="fa fa-frown-o" aria-hidden="true" style="font-size:48px;color:red"></i>

                    <h2 class="m-0">Unverified</h2>
                    <h6>User <span class="text-info bg-dark">{{$member_dets->name}}</span> not verified - mwak.co.ke</h6>
                    <p>If not verified in the next 48 hours, please contact Admin <br><span class="text-info"><a href="tel:+254718111186">+254 718111186</a></span> <br> or <br> email <span class="text-info">info@mwak.ke</span> <br> Sorry for the inconvenience.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
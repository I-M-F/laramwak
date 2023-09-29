@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-lg-1">

            </div>
            <div class="col-lg-10">


                <!-- card start -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Transaction</h5>
                    </div>
                    <!-- Start Card Body -->
                    <div class="card-body">
                        <form role="form" action="{{URL::to('/update-tx/'.$edit->id)}}" method="POST">
                            @csrf


                            <!-- <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Transacted Phone No.</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tx_phn_number" placeholder="Enter Phone Number" value="{{$edit->phone}}">
                                </div>
                            </div> -->

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Transacted Phone No.</label>
                                <div class="col-sm-10">
                                    <p class="form-control-plaintext">{{$edit->phone}}</p>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Transaction No.</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="tx_number" placeholder="Enter Transaction Number" value="{{$edit->tx_number}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Payment Description </label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="exampleformControlSelect1" name="payment_description" required>
                                        <option>--Select Payment Description--</option>
                                        <option value="MWAK Membership Fees" {{'MWAK Annual Subscription Fees' == $edit->payment_description ? 'selected' : ''}}>MWAK Annual Membership Fees</option>
                                        <option value="Membership Card Fees" {{'MWAK Membership Fees' == $edit->payment_description ? 'selected' : ''}}>Membership Fees</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Transaction Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="exampleformControlSelect1" name="status" required>
                                        <option>--Select Status--</option>
                                        <option value="Pending" {{'Pending' == $edit->status ? 'selected' : ''}}>Pending</option>
                                        <option value="Paid" {{'Paid' == $edit->status ? 'selected' : ''}}>Paid</option>

                                    </select>
                                </div>
                            </div>
                            <!-- End card body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Card End  -->
            <div class="col-lg-1">

            </div>
        </div>
    </section>
</div>

@endsection
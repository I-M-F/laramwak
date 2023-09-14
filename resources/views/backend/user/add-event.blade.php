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
                    @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                    @endif
                    <div class="card-header">
                        <h5 class="card-title">Add Calendar Events</h5>
                    </div>
                    <!-- Start Card Body -->
                    <div class="card-body">
                        <form role="form" action="{{URL::to('upload-docs')}}" enctype="multipart/form-data" method="POST">
                            @csrf
                 

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label"> Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="event_title" placeholder="Enter Event Title" required>
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
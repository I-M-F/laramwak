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
                        <form role="form" action="{{ URL::to('upload-event') }}" enctype="multipart/form-data" method="POST">
                            @csrf

                            <div class="form-group row">
                                <label for="event_title" class="col-sm-2 col-form-label"> Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="event_title" id="event_title" placeholder="Enter Event Title" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="event_url" class="col-sm-2 col-form-label"> URL Link</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="event_url" id="event_url" placeholder="Enter Event URL Link" required>
                                </div>
                            </div>

                            <!-- Add Date Selection for Event Start -->
                            <div class="form-group row">
                                <label for="event_start" class="col-sm-2 col-form-label">Event Start</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control date" name="event_start" id="event_start" placeholder="Select/Enter Event Start Date (2023-09-28 13:29:28)" required>
                                </div>
                            </div>


                            <!-- Add Date Selection for Event End -->
                            <div class="form-group row">
                                <label for="event_end" class="col-sm-2 col-form-label">Event End</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control date" name="event_end" id="event_end" placeholder="Select/Enter Event End Date (2023-09-30 13:43:23)" required>
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
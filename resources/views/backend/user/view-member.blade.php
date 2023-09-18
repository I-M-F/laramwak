@extends('backend.layouts.app')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/home">Home</a></li>
                        <li class="breadcrumb-item active">Member Details </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('/storage/'.$photo_str) }}" alt="Member profile picture" title="{{$view_member->id_card}}" width='50' height='50' class="img img-responsive">

                            </div>

                            <h3 class="profile-username text-center">{{$view_member->first_name.' '.$view_member->second_name.' '.$view_member->maiden_name}}</h3>

                            <p class="text-muted text-center">{{$view_member->phone}}</p>
                            <ul class="list-group list-group-unbordered mb-3">


                                <li class="list-group-item">
                                    <b>Membership Fee</b> <a class="float-right">{{$paymentDB->status}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Membership No.</b> <a class="float-right">{{$view_member->member_no}}</a>
                                </li>
                                @if($view_member->status=='Active')
                                <li class="list-group-item">
                                    <b>Membership Since</b> <a class="float-right">{{ date('d-M-y', strtotime($paymentDB->updated_at)) }} </a>
                                </li>
                                @endif

                                @if($view_member->status=='Active')
                                <li class="list-group-item">
                                    <b>Chapter</b> <a class="float-right">{{$view_member->member_location}} </a>
                                </li>
                                @endif
                            </ul>
                            @if($status_role->role == 'Unverified' || $status_role->role == 'Rejected')


                            <form role="form" action="{{URL::to('/approve-member/'.$view_member->email)}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="">Approval</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="exampleformControlSelect1" name="status_role" required>
                                            <option>--Approve Member --</option>
                                            <option value="Verified">Verified</option>
                                            <option value="Rejected">Rejected</option>

                                        </select>
                                    </div>
                                </div>
                                <!-- <a type="submit" class="btn btn-primary btn-block"><b>Activate</b></a>
                                 -->
                                <button type="submit" class="btn btn-primary btn-block">Approve</button>
                            </form>
                            @else
                            @if($view_member->status=='Pending' && auth()->user()->role == 'Admin' )
                            <form role="form" action="{{URL::to('/update-member/'.$view_member->id)}}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="">Chapter</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" id="exampleformControlSelect1" name="chapter" required>
                                            <option>--Assign Member Chapter--</option>
                                            <option value="Nairobi Chapter">Nairobi Chapter</option>
                                            <option value="Eldoret Chapter">Eldoret Chapter</option>
                                            <option value="Nakuru Chapter">Nakuru Chapter</option>
                                            <option value="Nanyuki Chapter">Nanyuki Chapter</option>
                                            <option value="Isiolo Chapter">Isiolo Chapter</option>
                                            <option value="Mombasa Chapter">Mombasa Chapter</option>
                                            <option value="Garissa Chapter">Garissa Chapter</option>
                                            <option value="Thika Chapter">Thika Chapter</option>
                                            <option value="Gilgil Chapter">Gilgil Chapter</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <a type="submit" class="btn btn-primary btn-block"><b>Activate</b></a>
                                 -->
                                <button type="submit" class="btn btn-primary btn-block">Activate</button>
                            </form>
                            @endif
                            @if($view_member->status=='Pending')
                            <p class="mb-0">
                                <a href="{{ route('payment') }}" class="text-center">Click to Pay</a>
                                @endif
                                @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


                    <!-- /.card -->
                </div>
                <!-- /.col  -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <!-- only admin can see -->
                                <li class="nav-item"><a class="nav-link active" href="#member_details" data-toggle="tab">Member Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="#spouse_details" data-toggle="tab">Spouse Details</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tx_timeline" data-toggle="tab">Transaction Details</a></li>
                                @if(auth()->user()->role=='Admin')
                                <li class="nav-item"><a class="nav-link" href="#edit_dets" data-toggle="tab">Edit Details</a></li>
                                @else
                                <li class="nav-item"><a class="nav-link" href="#user_edit_dets" data-toggle="tab">Edit Member Details</a></li>
                                @endif
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="member_details">
                                    <!-- Post -->
                                    <!-- About Me Box -->
                                    <div class="card card-primary">

                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <strong><i class="fas fa-book mr-1"></i> Member Names</strong>

                                            <p class="text-muted">

                                                {{$view_member->first_name.' '.$view_member->second_name.' '.$view_member->maiden_name}}
                                            </p>

                                            <hr>


                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> ID Number </strong>

                                            <p class="text-muted">{{$view_member->id_number}}</p>

                                            <hr>

                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> County of Residence</strong>

                                            <p class="text-muted">{{$countyDB->name}} </p>

                                            <hr>

                                            <strong><i class="far fa-file-alt mr-1"></i> Phone </strong>

                                            <p class="text-muted ">{{$view_member->phone}}</p>

                                            <hr>

                                            <strong><i class="far fa-file-alt mr-1"></i> Email</strong>

                                            <p class="text-muted ">{{$view_member->email}}</p>

                                            <hr>

                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.post -->

                                </div>

                                <div class="active tab-pane" id="spouse_details">
                                    <!-- Post -->
                                    <!-- About Me Box -->
                                    <div class="card card-primary">

                                        <!-- /.card-header -->
                                        <div class="card-body">
                                            <strong><i class="fas fa-book mr-1"></i> Spouse Names </strong>

                                            <p class="text-muted">

                                                {{$view_member->spouse_name.' '.$view_member->spouse_maiden_name}}
                                            </p>

                                            <hr>

                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Spouse Status </strong>

                                            <p class="text-muted">{{$view_member->spouse_status}}</p>

                                            <hr>

                                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Spouse Service No. </strong>

                                            <p class="text-muted">{{$view_member->service_number}}</p>

                                            <hr>

                                            <strong><i class="fas fa-pencil-alt mr-1"></i> Service Class | Rank</strong>

                                            <p class="text-muted">
                                                <span class="tag tag-danger">{{$view_member->class}}</span>


                                            </p>

                                            <hr>
                                            <!-- 
                                            <strong><i class="far fa-file-alt mr-1"></i> Uploaded documents </strong>

                                            <p class="text-muted">Lorem ipsum dolor sit amet, xxxxxxxxxxxxxx</p> -->


                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                    <!-- /.post -->

                                </div>


                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tx_timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-danger">
                                                Memberes Since {{ date('d-M-y', strtotime($paymentDB->updated_at)) }}
                                            </span>
                                        </div>
                                        <!-- /.timeline-label -->
                                        <!-- timeline item -->

                                        <!-- END timeline item -->
                                        <!-- timeline item -->
                                        <!-- for each loop all tx-->
                                        <div>
                                            <i class="fas fa-user bg-info"></i>

                                            <div class="timeline-item">
                                                <span class="time"><i class="far fa-clock"></i> {{$paymentDB->updated_at}}</span>

                                                <h3 class="timeline-header border-0"><a href="#">MWAK Membership Fees</a> {{$paymentDB->status}}
                                                </h3>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                        <!-- timeline item -->

                                        <!-- END timeline item -->

                                        <!-- END timeline item -->
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="edit_dets">
                                    <!-- <form class="form-horizontal"> -->
                                    <form role="form" enctype="multipart/form-data" action="{{URL::to('/update-member-dets/'.$view_member->email)}}" method="POST">
                                        @csrf
                                        <div class="form-group row">

                                            <label for="inputName" class="col-sm-2 col-form-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="f_name" placeholder="Enter Your First Name" value="{{$view_member->first_name}}">

                                            </div>
                                            <label for="inputName" class="col-sm-2 col-form-label">Middle Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="m_name" placeholder="Enter Your Second Name" value="{{$view_member->second_name}}">
                                            </div>
                                            <label for="inputName" class="col-sm-2 col-form-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="l_name" placeholder="Enter Your Last Name" value="{{$view_member->maiden_name}}">
                                            </div>
                                        </div>
                                        <hr>


                                        <div class="form-group row">

                                            <label for="inputName" class="col-sm-2 col-form-label">Chapter.</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="chapter" placeholder="Enter Your Email" value="{{$view_member->member_location}}">
                                            </div>
                                        </div>
                                        <hr>

                                        <label for="inputName" class="col-sm-2 col-form-label">ID No.</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="id_no" placeholder="Enter Your Email" value="{{$view_member->id_number}}">
                                        </div>

                                        <hr>

                                        <label for="inputName" class="col-sm-2 col-form-label">Email.</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="email" placeholder="Enter Your Email" value="{{$view_member->email}}">
                                        </div>
                                        <hr>
                                        <div class="form-group row">

                                            <label for="inputName" class="col-sm-2 col-form-label">Spouse F. Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sp_f_name" placeholder="Enter Spouse First Name" value="{{$view_member->spouse_name}}">
                                            </div>
                                            <label for="inputName" class="col-sm-2 col-form-label">Spouse L. Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sp_l_name" placeholder="Enter Spouse Last Name" value="{{$view_member->spouse_maiden_name}}">
                                            </div>

                                            <label for="inputName" class="col-sm-2 col-form-label">Spouse Status</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sp_status" placeholder="Enter Spouse Last Name" value="{{$view_member->spouse_status}}">
                                            </div>
                                            <label for="inputName" class="col-sm-2 col-form-label">Service Class | Rank</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="sp_class" placeholder="Enter Spouse Last Name" value="{{$view_member->class}}">
                                            </div>

                                        </div>
                                        <hr>

                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">ID Card </label>
                                            <img class="profile-user-img img-fluid img-square" src="{{ asset('/storage'.$id_photo_str) }}" alt="Member id picture" title="{{$view_member->id_card}}" width='50' height='50' class="img img-responsive">
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="id_card" placeholder="Enter Your ID Card" value="{{$view_member->id_card}}">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Passport Photo</label>
                                            <img class="profile-user-img img-fluid img-square" src="{{ asset('/storage'.$photo_str) }}" alt="Member passport picture" title="{{$view_member->id_card}}" width='50' height='50' class="img img-responsive">
                                            <div class="col-sm-10">

                                                <input type="file" class="form-control" name="passport" placeholder="Enter Your Passport" value="{{$view_member->passport_photo}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane" id="user_edit_dets">
                                    <!-- <form class="form-horizontal"> -->
                                    <form role="form" enctype="multipart/form-data" action="{{URL::to('/update-user-member-dets/'.$view_member->email)}}" method="POST">
                                        @csrf
                                        <div class="form-group row">

                                            <label for="inputName" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="password" placeholder="Enter Your New Password" value="{{$status_role->password}}">

                                            </div>

                                        </div>
                                        <hr>



                                        <hr>

                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">ID Card</label>
                                            <img class="profile-user-img img-fluid img-square" src="{{ asset('/storage/'.$id_photo_str) }}" alt="Member id picture" title="{{$view_member->id_card}}" width='50' height='50' class="img img-responsive">
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control" name="id_card" placeholder="Enter Your ID Card" value="{{$view_member->id_card}}">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Passport Photo</label>
                                            <img class="profile-user-img img-fluid img-square" src="{{ asset('/storage/'.$photo_str) }}" alt="Member passport picture" title="{{$view_member->id_card}}" width='50' height='50' class="img img-responsive">
                                            <div class="col-sm-10">

                                                <input type="file" class="form-control" name="passport" placeholder="Enter Your Passport" value="{{$view_member->passport_photo}}">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit Member Details</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
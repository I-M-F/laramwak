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
                    <h5 class="card-title">Add Member</h5>
                </div>
                <!-- Start Card Body -->
                <div class="card-body"> 
                    <form role="form" action="{{URL::to('insert-user')}}" method="POST">
                        @csrf

                       <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label"> User Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" placeholder="Enter Your Name" required>
                        </div>
                       </div> 

                       <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label"> User Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" placeholder="Enter Your Email Address" required>
                        </div>
                       </div> 

                       <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" placeholder="Enter Your Password" required>
                        </div>
                       </div> 

                       <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">User Role</label>
                        <div class="col-sm-10">
                        <select class="form-control" id="exampleformControlSelect1" name="role" required>
                            <option>--Select a Role--</option>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                            <option value="Member">Mamber</option>
                            <option value="Staff">Staff</option>
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
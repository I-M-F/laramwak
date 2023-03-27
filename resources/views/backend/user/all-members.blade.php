@extends('backend.layouts.app')
@section('content')

<div class="content-wrapper">


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">


          <div class="card">
            <div class="card-header">
              <h3 class="card-title">MWAK Members Listx</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Reg No. </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>ID</th>
                    <th>County</th>
                    <th>Sub County</th>
                    <th>Interest</th>
                    <th>Spouse Name</th>
                    <th>Service Number</th>
                    <th>Spouse Rank</th>
                    <th>Photo</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- 
                  @foreach($view_members as $key=>$row)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->first_name.' '.$row->maiden_name }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->id_number }}</td>
                    <td>{{ $countyDB->name }}</td>
                    <td>{{ $subCountyDB->name }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->spouse_name.' '.$row->spouse_maiden_name}}</td>
                    @if($row->role=='Unverified')
                    <td style="background-color:green ">{{ $row->service_number }}</td>
                    @elseif($row->role=='Rejected')
                    <td style="background-color:red ">{{ $row->service_number }}</td>
                    @else
                    <td>{{ $row->service_number }}</td>
                    @endif
                    <td>{{ $row->class }}</td>
                    <td><img src=" {{ asset('/storage/'. substr($row->id_card,6)) }}" alt="" title="{{ substr($row->id_card,6) }}" width='50' height='50' class="img img-responsive"> </td>

                    <td>
                      <a href="{{ URL::to('/view-member/'.$row->id) }}" class="btn btn-sm btn-info">View</a>
                      <a href="{{ URL::to('/edit-user/'.$row->id) }}" class="btn btn-sm btn-info">Send SMS</a>
                      <a href="{{ URL::to('/delete-user/'.$row->email) }}" class="btn btn-sm btn-danger">Delete</a>
                    </td>

                  </tr>
                  @endforeach -->

                  @foreach($view_members as $key=>$row)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row['member']->first_name.' '.$row['member']->maiden_name }}</td>
                    <td>{{ $row['member']->email }}</td>
                    <td>{{ $row['member']->phone }}</td>
                    <td>{{ $row['member']->id_number }}</td>
                    <td>{{ $row['county']->name }}</td>
                    <td>{{ $row['sub_county']->name }}</td>
                    <td>{{ $row['member']->phone }}</td>
                    <td>{{ $row['member']->spouse_name.' '.$row['member']->spouse_maiden_name}}</td>
                    @if($row['member']->role=='Unverified')
                    <td style="background-color:green ">{{ $row['member']->service_number }}</td>
                    @elseif($row['member']->role=='Rejected')
                    <td style="background-color:red ">{{ $row['member']->service_number }}</td>
                    @else
                    <td>{{ $row['member']->service_number }}</td>
                    @endif
                    <td>{{ $row['member']->class }}</td>
                    <td><img src="{{ asset('/storage/'. substr($row['member']->id_card,6)) }}" alt="" title="{{ substr($row['member']->id_card,6) }}" width='50' height='50' class="img img-responsive"> </td>

                    <td>
                      <a href="{{ URL::to('/view-member/'.$row['member']->id) }}" class="btn btn-sm btn-info">View</a>
                      <a href="{{ URL::to('/edit-user/'.$row['member']->id) }}" class="btn btn-sm btn-info">Send SMS</a>
                      <a href="{{ URL::to('/delete-user/'.$row['member']->email) }}" class="btn btn-sm btn-danger">Delete</a>
                    </td>

                  </tr>
                  @endforeach



                </tbody>
                <tfoot>
                  <tr>
                    <th>Reg No. </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>ID</th>
                    <th>County</th>
                    <th>Sub County</th>
                    <th>Interest</th>
                    <th>Spouse Name</th>
                    <th>Service Number</th>
                    <th>Spouse Rank</th>
                    <th>Photo</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
</div>
@endsection
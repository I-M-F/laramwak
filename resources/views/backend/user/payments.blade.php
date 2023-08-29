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
              <h3 class="card-title">MWAK Payment List {{}}</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Tx No. </th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Payment Description</th>
                    <th>Transaction No.</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>


                  @foreach($paymentDB as $key=>$row)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->amount }}</td>
                    <td>{{ $row->payment_description }}</td>
                    <td>{{ $row->tx_number }}</td>
                    <td>{{ $row->status }}</td>


                    <td>
                      @if(auth()->user()->role=='Admin')
                      @if($row->status=='Pending')
                      <a href="{{ URL::to('/mpesaSTKPush/'.$row->phone) }}" class="btn btn-sm btn-info">Lipa Na MPesa</a>
                      <a href="{{ URL::to('/edit-tx/'.$row->id) }}" class="btn btn-sm btn-info">Edit </a>
                      <a href="{{ URL::to('/tuma-sms/'.$row->id) }}" class="btn btn-sm btn-info">Send SMS </a>
                      <!-- <a href="{{ URL::to('/sendEmail') }}" class="btn btn-sm btn-info">Pay With VISA/MasterCard Email</a>
                             -->

                      @endif
                      @endif
                      @if(auth()->user()->role=='Member')
                      @if($row->status=='Pending')
                      <a href="{{ URL::to('/mpesaSTKPush/'.$row->phone) }}" class="btn btn-sm btn-info">Lipa Na MPesa</a>

                      @endif
                      @endif
                    </td>
                  </tr>
                  @endforeach


                </tbody>
                <tfoot>
                  <tr>
                    <th>Tx No. </th>
                    <th>Phone</th>
                    <th>Amount</th>
                    <th>Payment Description</th>
                    <th>Transaction No.</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
            <a href="{{ URL::to('/pending-pay/') }}" class="btn btn-sm btn-info">Pending Payment Reminder </a>

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
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
                            <h3 class="card-title">MWAK Payment Subscription Pending List </h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Tx No. </th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Spouse Name</th>                                       
                                        <th>Spouse Status</th>
                                        <th>Amount</th>
                                        <th>Payment Description</th>
                                        <th>Transaction No.</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach($pendingPayments as $key=>$row)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $row->first_name }}</td>
                                        <td>{{ $row->phone }}</td>
                                        <td>{{ $row->spouse_name }}</td>                                  
                                        <td>{{ $row->spouse_status }}</td>
                                        <td>{{ $row->amount }}</td>
                                        <td>{{ $row->payment_description }}</td>
                                        <td>{{ $row->tx_number }} {{ $row->date }}</td>
                                        <td>{{ $row->status }}</td>



                                    </tr>
                                    @endforeach


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Tx No. </th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Spouse Name</th>                                     
                                        <th>Spouse Status</th>
                                        <th>Amount</th>
                                        <th>Payment Description</th>
                                        <th>Transaction No.</th>
                                        <th>Status</th>
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
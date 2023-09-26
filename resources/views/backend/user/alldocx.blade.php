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
                            <h3 class="card-title">MWAK Documents List</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Doc No. </th>
                                        <th>Description</th>
                                        <th>Doc Link</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($all as $key=>$row)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td>{{ $row->docs_data }}</td>
                                        <td>{{ $row->date }}</td>
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('/view-docs/'.$row->id) }}" class="btn btn-sm btn-info">View Doc</a>
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Doc No. </th>
                                        <th>Description</th>
                                        <th>Doc Link </th>
                                        <th>Date</th>
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
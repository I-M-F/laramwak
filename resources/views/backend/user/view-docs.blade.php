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
                        <h5 class="card-title">View Document </h5>
                    </div>
                    <a href="{{asset('/storage/'.$view->docs_data) }}">Link to view Document</a>
                    <!-- Start Card Body -->
                    <div class="card-body">
                        <!-- Element where PSPDFKit will be mounted. -->
                        <div id="pspdfkit" style="height: 100vh"></div>
                        <script src="{{asset('backend/assets/pspdfkit.js')}}"></script>
                       

                        <script>
                            PSPDFKit.load({
                                    container: "#pspdfkit",
                                    document: "{{asset('/storage/'.$view->docs_data) }}", // Add the path to your document here.
                                })
                                .then(function(instance) {
                                    console.log("PSPDFKit loaded", instance);
                                })
                                .catch(function(error) {
                                    console.error(error.message);
                                });
                        </script>
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
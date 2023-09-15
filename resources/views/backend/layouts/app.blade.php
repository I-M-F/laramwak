<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MWAK | Dashboard</title>

  <!-- CSS libraries -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
  <link rel="stylesheet" href="{{ asset('toaster/toastr.min.css') }}">

  <!-- Toaster Notification -->
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="{{ asset('backend/dist/img/logo.jpg') }}" alt="MWAK Logo" height="100" width="100">
    </div>

    <!-- Navbar -->
    @include('backend.layouts.navbar')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('backend.layouts.sidebar')

    <!-- Dashboard -->
    @yield('content')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; <?php echo date("Y") ?> <a href="https://www.mwak.co.ke">Military Wives Association of Kenya (MWAK)</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>

  <!-- Additional scripts and libraries -->
  <script src="{{ asset('backend/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
  <script src="{{ asset('backend/plugins/raphael/raphael.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
  <script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>

  <!-- Toaster and SweetAlert -->
  <script src="{{ asset('toaster/toastr.min.js') }}"></script>
  <script src="{{ asset('toaster/sweetalert.min.js') }}"></script>

  <!-- Page-specific scripts -->
  <script>
    @if(Session::has('messege'))
    var type = "{{ Session::get('alert-type','info') }}";
    switch (type) {
      case 'info':
        toastr.info("{{ Session::get('messege') }}");
        break;
      case 'success':
        toastr.success("{{ Session::get('messege') }}");
        break;
      case 'warning':
        toastr.warning("{{ Session::get('messege') }}");
        break;
      case 'error':
        toastr.error("{{ Session::get('messege') }}");
        break;
    }
    @endif
  </script>

  <script>
    $(document).on("click", "#delete", function(e) {
      e.preventDefault();
      var link = $(this).attr("href");
      swal({
        title: "Are you Want to delete?",
        text: "Once Delete, This will be Permanently Delete!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          window.location.href = link;
        } else {
          swal("Safe Data!");
        }
      });
    });
  </script>

  <!-- Page-specific scripts -->
  <script>
    $(function() {
      $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>

  <!-- FullCalendar integration -->
  <script>
    var calendarEl = document.getElementById('calendar');
    var SITEURL = "{{ url('/') }}";

    document.addEventListener('DOMContentLoaded', function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      $.ajax({
        url: SITEURL + '/calendar-event',
        method: 'GET',
        success: function(data) {
          var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            initialDate: '2023-09-07',
            headerToolbar: {
              left: 'prev,next today',
              center: 'title',
              right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: data,
            eventClick: function(info) {
              info.jsEvent.preventDefault();
              window.open(info.event.url, '_blank');
            }
          });
          calendar.render();
        },
        error: function(xhr, status, error) {
          console.error("Error fetching events:", error);
        }
      });
    });
  </script>

  <!-- Bootstrap Datepicker configuration -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
  <script>
    $(function() {
      var today = new Date();

      $('#event_start').datetimepicker({
        minDate: today,
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss'
      });

      $('#event_end').datetimepicker({
        minDate: today,
        useCurrent: false,
        format: 'YYYY-MM-DD HH:mm:ss'
      });

      $('#event_start').on('dp.change', function(e) {
        $('#event_end').data("DateTimePicker").minDate(e.date);
      });

      $('#event_end').on('dp.change', function(e) {
        $('#event_start').data("DateTimePicker").maxDate(e.date);
      });
    });
  </script>

</body>

</html>
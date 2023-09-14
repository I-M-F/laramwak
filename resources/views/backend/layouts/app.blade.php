<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MWAK | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('backend/plugins/fontawesome-free/css/all.min.css')}}">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('backend/dist/css/adminlte.min.css')}}">

  <!-- fullCalendar -->
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

  <!-- Add these links to your HTML file -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.11.0/dist/css/bootstrap-datepicker.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.11.0/dist/js/bootstrap-datepicker.min.js"></script>


  <!-- Toaster Notification -->
  <link rel="stylesheet" href="{{asset('toaster/toastr.min.css')}}">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="{{asset('backend/dist/img/logo.jpg')}}" alt="MWAK Logo" height="100" width="100">
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
  <!-- jQuery -->
  <script src="{{asset('backend/plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap -->
  <script src="{{asset('backend/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- overlayScrollbars -->
  <script src="{{asset('backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('backend/dist/js/adminlte.js')}}"></script>

  <!-- PAGE PLUGINS -->
  <!-- jQuery Mapael -->
  <script src="{{asset('backend/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
  <script src="{{asset('backend/plugins/raphael/raphael.min.js')}}"></script>
  <script src="{{asset('backend/plugins/jquery-mapael/jquery.mapael.min.js')}}"></script>
  <script src="{{asset('backend/plugins/jquery-mapael/maps/usa_states.min.js')}}"></script>
  <!-- ChartJS -->
  <script src="{{asset('backend/plugins/chart.js/Chart.min.js')}}"></script>

  <!-- AdminLTE for demo purposes -->
  <!-- <script src="{{asset('backend/dist/js/demo.js')}}"></script> -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="{{asset('backend/dist/js/pages/dashboard2.js')}}"></script>

  <!-- DataTables  & Plugins -->
  <script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
  <script src="{{asset('backend/plugins/jszip/jszip.min.js')}}"></script>
  <script src="{{asset('backend/plugins/pdfmake/pdfmake.min.js')}}"></script>
  <script src="{{asset('backend/plugins/pdfmake/vfs_fonts.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
  <script src="{{asset('backend/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>


  <!-- Start Toaster & Sweetalert -->
  <script src="{{ asset('toaster/toastr.min.js')}}"></script>
  <script src="{{ asset('toaster/sweetalert.min.js') }}"></script>





  <script>
    @if(Session::has('messege'))
    var type = "{{Session::get('alert-type','info')}}"
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
        })
        .then((willDelete) => {
          if (willDelete) {
            window.location.href = link;
          } else {
            swal("Safe Data!");
          }
        });
    });
  </script>

  <!-- End Toaster & Sweetalert -->

  <!-- Page specific script -->
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

  <!-- Page specific script -->

  <!-- <script>
    $(document).ready(function() {
      display_events();
    }); //end document.ready block

    function display_events() {
      var events = new Array();
      $.ajax({
        url: 'display_event.php',
        dataType: 'json',
        success: function(response) {

          var result = response.data;
          $.each(result, function(i, item) {
            events.push({
              event_id: result[i].event_id,
              title: result[i].title,
              start: result[i].start,
              end: result[i].end,
              color: result[i].color,
              url: result[i].url
            });
          })
          var calendar = $('#calendar').fullCalendar({
            defaultView: 'month',
            timeZone: 'local',
            editable: true,
            selectable: true,
            selectHelper: true,
            select: function(start, end) {
              alert(start);
              alert(end);
              $('#event_start_date').val(moment(start).format('YYYY-MM-DD'));
              $('#event_end_date').val(moment(end).format('YYYY-MM-DD'));
              $('#event_entry_modal').modal('show');
            },
            events: events,
            eventRender: function(event, element, view) {
              element.bind('click', function() {
                alert(event.event_id);
              });
            }
          }); //end fullCalendar block	
        }, //end success block
        error: function(xhr, status) {
          alert(response.msg);
        }
      }); //end ajax block	
    }

    function save_event() {
      var event_name = $("#event_name").val();
      var event_start_date = $("#event_start_date").val();
      var event_end_date = $("#event_end_date").val();
      if (event_name == "" || event_start_date == "" || event_end_date == "") {
        alert("Please enter all required details.");
        return false;
      }
      $.ajax({
        url: "save_event.php",
        type: "POST",
        dataType: 'json',
        data: {
          event_name: event_name,
          event_start_date: event_start_date,
          event_end_date: event_end_date
        },
        success: function(response) {
          $('#event_entry_modal').modal('hide');
          if (response.status == true) {
            alert(response.msg);
            location.reload();
          } else {
            alert(response.msg);
          }
        },
        error: function(xhr, status) {
          console.log('ajax error = ' + xhr.statusText);
          alert(response.msg);
        }
      });
      return false;
    }
  </script> -->



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
            events: data, // Assign the retrieved JSON data to the events option,
            eventClick: function(info) {
              // Handle event click here
              //showEventDetails(info.event);
              //console.log("events:", data);
              info.jsEvent.preventDefault();

              // Open the event URL in a new tab
              window.open(info.event.url, '_blank');
            }

          });
          console.log("events:", data);
          calendar.render();
        },


        error: function(xhr, status, error) {
          console.error("Error fetching events:", error);
        }
      });
    });

    function showEventDetails(event) {
      // Assuming you have a Bootstrap Modal with an ID "eventModal"
      var modal = $('#eventModal');

      // Sanitize the URL to prevent redirection
      var url = event.url;
      if (!/^https?:\/\//i.test(url)) {
        url = 'http://' + url; // Add "http://" as a prefix for plain text URLs
      }

      // Create a link element for the sanitized URL
      var urlLink = $('<a>', {
        text: event.url,
        href: url,
        target: '_blank', // Open the URL in a new tab
      });

      // Populate the modal with event details
      modal.find('.modal-title').text(event.title);

      //modal.find('.modal-body').append('<p>Link: ' + urlLink); // Append the link element
      modal.find('.modal-body').append('<p>URL: ' + urlLink[0].outerHTML + '</p>'); // Append the <span> element as HTML

      modal.find('.modal-body').html('<p>Start: ' + event.start.toISOString() + '</p>');
      if (event.end) {
        modal.find('.modal-body').append('<p>End: ' + event.end.toISOString() + '</p>');
      }

      // Show the modal
      modal.modal('show');
    }
  </script>

  <!-- <script>
    // Initialize Bootstrap Datepicker
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd', // Define your preferred date format
      autoclose: true,
      todayHighlight: true,
    });
  </script> -->

  <script>
    console.log('Initializing datepicker...');
    // Initialize Bootstrap Datepicker
    $('.datepicker').datepicker({
      format: 'yyyy-mm-dd', // Define your preferred date format
      autoclose: true,
      todayHighlight: true,
    });
    console.log('Datepicker initialized.');
  </script>




  <!-- 
  <script>
    $.noConflict();
    jQuery(document).ready(function($) {
      $('#calendar').fullCalendar({
        // Your FullCalendar options here
      });
    });
  </script> -->






  <!-- <script src="{{ asset('js/app.js') }}"></script>

<script>

document.getElementById('getAccessToken').addEventListener('click', (event) => {
  event.preventDefault()

  axios.post('/get-token', {})
  .then((response) => {
    console.log(response.data);
  })
  .catch((error) => {
    console.log(error);
  })
})
</script> -->

</body>

</html>
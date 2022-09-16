<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>MWAK | Home Page</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta content="" name="keywords" />
  <meta content="" name="description" />

  <!-- Favicon -->
  <link href="{{asset('img/favicon.ico')}}" rel="icon" />

  <!-- Google Web Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet" />

  <!-- Icon Font Stylesheet -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Libraries Stylesheet -->
  <link href="{{asset('backend/dist/lib/animate/animate.min.css')}}" rel="stylesheet" />
  <link href="{{asset('backend/dist/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet" />

  <!-- Customized Bootstrap Stylesheet -->
  <link href="{{asset('backend/dist/css/bootstrap.min.css')}}" rel="stylesheet" />

  <!-- Template Stylesheet -->
  <link href="{{asset('backend/dist/css/style.css')}}" rel="stylesheet" />
</head>

<body>


  <!-- Topbar Start -->

  <!-- Topbar Start -->
  <div class="container-fluid bg-dark text-white-50 py-2 px-0 d-none d-lg-block">
    <div class="row gx-0 align-items-center">
      <div class="col-lg-7 px-5 text-start">
        <div class="h-100 d-inline-flex align-items-center me-4">
          <small class="fa fa-phone-alt me-2"></small>
          <small>+254 718111186</small>
        </div>
        <div class="h-100 d-inline-flex align-items-center me-4">
          <small class="far fa-envelope-open me-2"></small>
          <small>info@mwak.ke</small>
        </div>
        <div class="h-100 d-inline-flex align-items-center me-4">
          <small class="far fa-clock me-2"></small>
          <small>Mon - Fri : 09 AM - 09 PM</small>
        </div>
      </div>
      <div class="col-lg-5 px-5 text-end">
        <div class="h-100 d-inline-flex align-items-center">
          <a class="text-white-50 ms-4" href=""><i class="fab fa-facebook-f"></i></a>
          <a class="text-white-50 ms-4" href=""><i class="fab fa-twitter"></i></a>
          <a class="text-white-50 ms-4" href=""><i class="fab fa-linkedin-in"></i></a>
          <a class="text-white-50 ms-4" href=""><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
  </div>
  <!-- Topbar End -->

  <!-- Topbar End -->

  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top px-4 px-lg-5">
    <a href="index.html" class="navbar-brand d-flex align-items-center">
      <h1 class="m-0">
        <img class="img-fluid me-3" src="{{asset('backend/dist/img/logo.jpg')}}" alt="" />
      </h1>
    </a>

    <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <div class="navbar-nav mx-auto bg-light rounded pe-4 py-3 py-lg-0">
      





  </nav>
  <!-- Navbar End -->

  <!-- Carousel Start -->
  <section>
    <div class="row">
      <div class="column content" style="background-color:#fff;">
        <h3>A BIG OPPORTUNITY FOR</h3>
        <h1>MILITARY WIVES</h1>
        
        @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="btn">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="btn">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('member-register') }}" class="btn account"><img class="img-btn" src="https://z-p3-scontent.fnuu1-1.fna.fbcdn.net/v/t39.8562-6/291368684_3743893072401791_4065535483776826835_n.png?_nc_cat=101&ccb=1-7&_nc_sid=6825c5&_nc_ohc=88ws8smSZvAAX8BG3LF&_nc_ht=z-p3-scontent.fnuu1-1.fna&oh=00_AT9u4oVOh6dcS1cd5H1KUpdHvzKMf4AoXa8LYF8Ry9UQsQ&oe=63255FF3" alt=""></i>Register</a>
                        @endif
                    @endauth
                </div>
            @endif
      
      </div>
      <div class="column" style="background-color:#fdebeb;">
        <img class="img-class" src="{{asset('backend/dist/img/mwakvalues.jpeg')}}" alt="Image" />
      </div>

    </div>


  </section>


  <!-- Carousel End -->




  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="{{asset('backend/lib/wow/wow.min.js')}}"></script>
  <script src="{{asset('backend/lib/easing/easing.min.js')}}"></script>
  <script src="{{asset('backend/lib/waypoints/waypoints.min.js')}}"></script>
  <script src="{{asset('backend/lib/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{asset('backend/lib/counterup/counterup.min.js')}}"></script>

  <!-- Template Javascript -->
  <script src="{{asset('backend/css/js/main.js')}}"></script>
</body>

</html>
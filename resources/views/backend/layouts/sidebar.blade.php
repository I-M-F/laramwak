<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{asset('backend/dist/img/logo.jpg')}}" alt="MWAK Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">MWAK Portal</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('/storage/'.substr(auth()->user()->photo,6)) }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{auth()->user()->name}} </a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @if(auth()->user()->role=='Admin')
        <li class="nav-item">
          <!-- <a href="#" class="nav-link active"> -->
          <a href="{{URL::to('/home')}}" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard

            </p>
          </a>

        </li>



        <!-- <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Widgets
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li> -->
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              User Management
              <i class="fas fa-angle-left right"></i>
              <!-- <span class="badge badge-info right">6</span> -->
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{URL::to('/all-user')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Users</p>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a href="{{URL::to('/add-user-index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>XXAdd Users</p>
              </a>
            </li> -->
          </ul>
        </li>

        <!-- <i class="nav-icon fas fa-book"></i> -->

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Members Management
              <i class="fas fa-angle-left right"></i>
              <!-- <span class="badge badge-info right">6</span> -->
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{URL::to('/all-members')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Members</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/add-all')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Members</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/commissioned')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Commissioned </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/non-commissioned')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Non-Commissioned </p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Communication 
              <i class="fas fa-angle-left right"></i>
              <!-- <span class="badge badge-info right">6</span> -->
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{URL::to('/all-docs')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Document</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/add-docs')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Document</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/bulk-sms')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Bulk SMS</p>
              </a>
            </li>
          </ul>
        </li>


        @endif

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Payment Management
              <i class="fas fa-angle-left right"></i>
              <!-- <span class="badge badge-info right">6</span> -->
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{URL::to('/payment')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>All Payments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/pendingPayList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Pending Payments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/comPayList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Commissioned</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/nonComPayList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Non-Commissioned</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/subPayList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Subscription Payments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{URL::to('/annualPayList')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Annual Payments</p>
              </a>
            </li>

            <!-- @if(auth()->user()->role=='Admin')
              <li class="nav-item">
                <a href="{{URL::to('/edit-payments')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Edit Payments</p>
                </a>
              </li>
              @endif         -->
          </ul>
        </li>
        @if(auth()->user()->role=='Member')
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Document Management
              <i class="fas fa-angle-left right"></i>
              <!-- <span class="badge badge-info right">6</span> -->
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{URL::to('/all-docs')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Document</p>
              </a>
            </li>
            <!-- <li class="nav-item">
                <a href="{{URL::to('/add-docs')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Document</p>
                </a>
              </li>                        -->
          </ul>
        </li>



        <li class="nav-item">
          <a href="{{ URL::to('/view-member/'.auth()->user()->email) }}" class="nav-link">
            <i class="nav-icon far fa-circle text-info"></i>
            <p>Profile</p>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
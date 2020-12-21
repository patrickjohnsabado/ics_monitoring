<header class="main-header">
<!-- Logo -->
  <a href="/" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>Lab Monitoring</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>Lab Monitoring</b></span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <!-- Notifications: style can be found in dropdown.less -->
        @if (\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin')
            <li style="padding:13px; color:white; font-size:16px; font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; text-shadow: 1px 1px 2px #111111;">
            {{\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->fullname}}
            </li>
        @endif
        @if (\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Student')
            <li style="padding:13px; color:white; font-size:16px; font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; text-shadow: 1px 1px 2px #111111;">
            {{\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->fullname}}
            </li>
        @endif
        @if (\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty')
            <li style="padding:13px; color:white; font-size:16px; font-family: 'Source Sans Pro','Helvetica Neue',Helvetica,Arial,sans-serif; text-shadow: 1px 1px 2px #111111; ">
            {{\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->fullname}}
            </li>
        @endif
        <li class="dropdown notifications-menu">
          <a href="/settings">
            <i class="fa fa-gear"></i>
          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>Users</span>
        </a>
        <ul class="treeview-menu">
          <li><a href="/faculties"><i class="fa fa-male"></i> Faculties</a></li>
          <li><a href="/students"><i class="fa fa-child"></i> Students</a></li>
          <li><a href="/admins"><i class="fa fa-child"></i> Admins</a></li>
        </ul>
      </li>
      <li>
        <a href="/logs">
          <i class="fa fa-file-text"></i> <span>Logs</span>
        </a>
      </li>
      <li >
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
      </li>
    </ul>
    </section>
  </aside>

  <aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            @if (\App\account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || \App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty')   
              <li class="treeview">
                <a href="#"><i class="fa  fa-calendar-plus-o"></i><span>Reservations/Calendar</span></a>
                <ul class="treeview-menu">
                  <li><a href="/calendar"><i class="fa  fa-calendar-plus-o"></i> <span>Calendar</span></a></li>
                  <li><a href="/reservation"><i class="fa fa-users"></i> <span>Reservation</span></a></li>
                </ul>
              </li>             
            @endif
            
            @if (\App\account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin')
              <li class="treeview">
                <a href="#"><i class="fa fa-users"></i><span>Users</span></a>
                <ul class="treeview-menu">
                  <li><a href="/faculties"><i class="fa fa-male"></i> Faculties</a></li>
                  <li><a href="/students"><i class="fa fa-child"></i> Students</a></li>
                  <li><a href="/admins"><i class="fa fa-child"></i> Admins</a></li>
                </ul>
              </li>
            @endif
            @if (\App\account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || \App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Student')   
              <li>
                <a href="/logs"><i class="fa fa-hourglass"></i> <span>Logs</span></a>
              </li>
              <li>
                <a href="/print"><i class="fa fa-file-text"></i> <span>Printing</span></a>
              </li>
            @endif
            @if (\App\account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin')
            <li class="treeview">
              <a href="#"><i class="fa fa-users"></i><span>Subject and Schedules</span></a>
              <ul class="treeview-menu">
                <li><a href="/subjects"><i class="fa fa-male"></i> Subjects</a></li>
                <li><a href="/schedules"><i class="fa fa-child"></i> Schedules</a></li>
              </ul>
            </li>
              <li>
                <a href="/room"><i class="fa fa-file-text"></i> <span>Room</span></a>
              </li>
              <li>
                <li><a href="/lab"><i class="fa fa-child"></i>Lab Utilization</a></li>
              </li>              
              <li>
                <a href="/settings"><i class="fa fa-file-text"></i> <span>School Year</span></a>
              </li>
              <li>
                <li class="treeview">
                  <a href="#"><i class="fa  fa-trash-o"></i><span>Archive</span></a>
                  <ul class="treeview-menu">
                <li class="treeview">
                  <a href="#"><i class="fa fa-users"></i><span>Users</span></a>
                  <ul class="treeview-menu">
                    <li><a href="/histfaculties"><i class="fa fa-male"></i>Archived Faculties</a></li>
                    <li><a href="/histstudents"><i class="fa fa-child"></i>Archived Students</a></li>
                  </ul>
                </li>
                <li>
                  <a href="/histlogs"><i class="fa fa-hourglass"></i><span>Archived Logs</span></a>
                </li>
                <li>
                  <a href="/histprint"><i class="fa fa-file-text"></i><span>Archived Printing</span></a>
                </li>
                <li>
                  <a href="/histschedules"><i class="fa fa-file-text"></i><span>Archived Schedules</span></a>
                </li>
                <li>
                  <a href="/histsettings"><i class="fa fa-file-text"></i><span>Archived School Year</span></a>
                </li>
                </ul>
              </li>
            @endif
            <li>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>

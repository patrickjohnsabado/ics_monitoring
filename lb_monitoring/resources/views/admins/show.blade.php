<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lab Monitoring | Admin Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- DataTables -->
    <link rel="stylesheet" href='{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}'>
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css')}}'>
  <!-- Font Awesome -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}'>
  <!-- Ionicons -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css')}}'>
  <!-- daterange picker -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}'>
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}'>
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/plugins/iCheck/all.css')}}'>
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}'>
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css')}}'>
  <!-- Select2 -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/select2/dist/css/select2.min.css')}}'>
  <!-- Theme style -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/dist/css/AdminLTE.min.css')}}'>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css')}}'>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
      @include('inc.navbar')
    
       <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Student
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Student</a></li>
            <li class="active">More of Student</li>
          </ol>
        </section>
        @include('inc.messages')
        <!-- Main content -->
        <section class="content">
    
          <div class="row">
            <div class="col-md-3">
              <div class="box box-primary">
                <div class="box-body box-profile">
                
                  <h3 class="profile-username text-center">{{$students->fullname}}</h3>
                  <p class="text-muted text-center">{{$students->id_number}}</p>
                <p class="text-muted text-center">{{$students->email}}</p>
                </div>
              </div>
    
              <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#settings" data-toggle="tab">Change Password</a></li>
                </ul>
                <div class="tab-content">
                  <!-- /.tab-pane -->
                  
                  <!-- /.tab-pane -->
                  
                  <div  class="active tab-pane" id="settings" >
                        {!! Form::open(['action' => ['AdminContoller@update', $students->id_number], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            {{Form::label('current_password', 'Current Password')}}                
                            {{Form::password('current_password',NULL, ['class' => 'form-control'])}}                
                        </div>                
                        <div class="form-group">                
                            {{Form::label('new_password', 'New Password')}}                
                            {{Form::password('new_password',NULL, ['class' => 'form-control'])}}               
                        </div> 
                        <div class="form-group">                
                            {{Form::label('repeat_password', 'Repeat Password')}}                
                            {{Form::password('repeat_password',NULL, ['class' => 'form-control'])}}                
                        </div>                                      
                        {{Form::hidden('_method','PUT')}}                
                        {{Form::submit('Update', ['class'=>'btn btn-primary'])}}                
                    {!! Form::close() !!}
                   
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
    
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.4.13
        </div>
        <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
        reserved.
      </footer>
    
      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
          <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
          <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
          <!-- Home tab content -->
          <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-birthday-cake bg-red"></i>
    
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>
    
                    <p>Will be 23 on April 24th</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-user bg-yellow"></i>
    
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>
    
                    <p>New phone +1(800)555-1234</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>
    
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>
    
                    <p>nora@example.com</p>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <i class="menu-icon fa fa-file-code-o bg-green"></i>
    
                  <div class="menu-info">
                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>
    
                    <p>Execution time 5 seconds</p>
                  </div>
                </a>
              </li>
            </ul>
            <!-- /.control-sidebar-menu -->
    
            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Custom Template Design
                    <span class="label label-danger pull-right">70%</span>
                  </h4>
    
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Update Resume
                    <span class="label label-success pull-right">95%</span>
                  </h4>
    
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Laravel Integration
                    <span class="label label-warning pull-right">50%</span>
                  </h4>
    
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                  </div>
                </a>
              </li>
              <li>
                <a href="javascript:void(0)">
                  <h4 class="control-sidebar-subheading">
                    Back End Framework
                    <span class="label label-primary pull-right">68%</span>
                  </h4>
    
                  <div class="progress progress-xxs">
                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                  </div>
                </a>
              </li>
            </ul>
            <!-- /.control-sidebar-menu -->
    
          </div>
          <!-- /.tab-pane -->
          <!-- Stats tab content -->
          <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
          <!-- /.tab-pane -->
          <!-- Settings tab content -->
          <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
              <h3 class="control-sidebar-heading">General Settings</h3>
    
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Report panel usage
                  <input type="checkbox" class="pull-right" checked>
                </label>
    
                <p>
                  Some information about this general settings option
                </p>
              </div>
              <!-- /.form-group -->
    
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Allow mail redirect
                  <input type="checkbox" class="pull-right" checked>
                </label>
    
                <p>
                  Other sets of options are available
                </p>
              </div>
              <!-- /.form-group -->
    
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Expose author name in posts
                  <input type="checkbox" class="pull-right" checked>
                </label>
    
                <p>
                  Allow the user to show his name in blog posts
                </p>
              </div>
              <!-- /.form-group -->
    
              <h3 class="control-sidebar-heading">Chat Settings</h3>
    
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Show me as online
                  <input type="checkbox" class="pull-right" checked>
                </label>
              </div>
              <!-- /.form-group -->
    
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Turn off notifications
                  <input type="checkbox" class="pull-right">
                </label>
              </div>
              <!-- /.form-group -->
    
              <div class="form-group">
                <label class="control-sidebar-subheading">
                  Delete chat history
                  <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                </label>
              </div>
              <!-- /.form-group -->
            </form>
          </div>
          <!-- /.tab-pane -->
        </div>
      </aside>
      <!-- /.control-sidebar -->
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src='{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js')}}'></script>
<!-- Bootstrap 3.3.7 -->
<script src='{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}'></script>
<!-- DataTables -->
<script src='{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')}}'></script>
<script src='{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}'></script>
<!-- Select2 -->
<script src='{{ asset('AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}'></script>
<!-- InputMask -->
<script src='{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.js')}}'></script>
<script src='{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.date.extensions.js')}}'></script>
<script src='{{ asset('AdminLTE/plugins/input-mask/jquery.inputmask.extensions.js')}}'></script>
<!-- date-range-picker -->
<script src='{{ asset('AdminLTE/bower_components/moment/min/moment.min.js')}}'></script>
<script src='{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}'></script>
<!-- bootstrap datepicker -->
<script src='{{ asset('AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}'></script>
<!-- bootstrap color picker -->
<script src='{{ asset('AdminLTE/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}'></script>
<!-- bootstrap time picker -->
<script src='{{ asset('AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js')}}'></script>
<!-- SlimScroll -->
<script src='{{ asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}'></script>
<!-- iCheck 1.0.1 -->
<script src='{{ asset('AdminLTE/plugins/iCheck/icheck.min.js')}}'></script>
<!-- FastClick -->
<script src='{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js')}}'></script>
<!-- AdminLTE App -->
<script src='{{ asset('AdminLTE/dist/js/adminlte.min.js')}}'></script>
<!-- AdminLTE for demo purposes -->
<script src='{{ asset('AdminLTE/dist/js/demo.js')}}'></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, locale: { format: 'MM/DD/YYYY hh:mm A' }})
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lab Monitoring | Logs</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
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
  
      <!-- Main content -->
      <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
          @include('inc.messages')
        <h1>
            Laboratory Login
        </h1>
      </section>
  
      <!-- Main content -->
      <section class="content">
  
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
          <div class="box-header with-border">
            
  
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-6">
                <form action="/logs" method="POST" autocomplete="off">
                  @csrf

                  @if (\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin')
                    <div class="form-group">
                      <label>Students/Faculties</label>
                      <select name = 'user[]' class="form-control select2" multiple="multiple" data-placeholder="Student or faculty" style="width: 100%;" required>
                        @foreach ($students as $student)
                          <option value="{{$student->id_number}}">{{$student->id_number}} {{$student->fullname}}</option>
                        @endforeach
                        @foreach ($faculties as $faculty)
                          <option value="{{$faculty->id_number}}">{{$faculty->id_number}} {{$faculty->fullname}}</option>
                        @endforeach
                      </select>
                    </div>
                  @endif

                  @if (\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty')
                    <div class="form-group">
                      <label>Students/Faculties</label>
                      <select name = 'user[]' class="form-control select2" multiple="multiple" data-placeholder="Student or faculty" style="width: 100%;" required>
                        @foreach ($students as $student)
                          <option value="{{$student->id_number}}">{{$student->id_number}} {{$student->fullname}}</option>
                        @endforeach
                      </select>
                    </div>
                  @endif

                  @if (\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Student')
                    
                    <div class="form-group">
                      <label>Student:</label>
                      <input type="text" class="form-control" placeholder="{{\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->fullname}} ({{\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->id_number}})" disabled="">
                      <input name="user[]" type="hidden" value="{{\App\Borrower::where('id_number','=',auth()->user()->id_number)->first()->id_number}}">
                    </div>
                  @endif
                  <div class="form-group">
                    <label>Date:</label>
    
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="date" type="text" class="form-control pull-right" id="datepicker" required>
                    </div>
                    <!-- /.input group -->
                  </div>
                  
                
                <div class="form-group">
                  <div class="form-group">
                    <label>Subjects</label>
                    <select name = 'subject[]' class="form-control select2" multiple="multiple" data-placeholder="Select a Subject or event" style="width: 100%;" required>
                      @foreach ($subjects as $subject)
                        <option value="{{$subject->id}}">{{$subject->code}} - {{$subject->course_number}} {{$subject->description}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>Start Time of Login:</label>
    
                      <div class="input-group">
                        <input name="time_from" type="text" class="form-control timepicker" placeholder="...">
    
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                      </div>
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                  </div>
                  <div class="bootstrap-timepicker">
                    <div class="form-group">
                      <label>End Time of Login:</label>
    
                      <div class="input-group">
                        <input name="time_to" type="text" class="form-control timepicker">
    
                        <div class="input-group-addon">
                          <i class="fa fa-clock-o"></i>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Room</label>
                        <select name = 'room' class="form-control select2" style="width: 100%;" required>>
                          @foreach ($rooms as $room)
                            <option value="{{$room->id}}">{{$room->room_number}} {{$room->room_type}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  
                  <input class="btn btn-block btn-primary" style="width: 12%;" type="Submit" value="Login">
                </form>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
          </div>
        </div>
        <!-- /.box -->
  
        
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
      <!-- FastClick -->
      <script src='{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js')}}'></script>
      <!-- AdminLTE App -->
      <script src='{{ asset('AdminLTE/dist/js/adminlte.min.js')}}'></script>
      <!-- AdminLTE for demo purposes -->
      <script src='{{ asset('AdminLTE/dist/js/demo.js')}}'></script>
      <!-- date-range-picker -->
      <script src='{{ asset('AdminLTE/bower_components/moment/min/moment.min.js')}}'></script>
      <script src='{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}'></script>
      <!-- page script -->
      <script>
        $(function(){
          $('#datepicker').datepicker({
              startDate: '-0m'
              //endDate: '+2d'
          }).on('changeDate', function(ev){
              $('#sDate1').text($('#datepicker').data('date'));
              $('#datepicker').datepicker('hide');
          });
          })
      </script>
      <script>
        $(function () {
          //Initialize Select2 Elements
          $('.select2').select2()
          $('.timepicker').timepicker({
      showInputs: false
    })
        })
      </script>
      <script>$('#button1').click(function(e){
          e.preventDefault();
          var win = window.open('{{ route('logs.create') }}');
           
          win.focus()
      });</script>

</body>
</html>

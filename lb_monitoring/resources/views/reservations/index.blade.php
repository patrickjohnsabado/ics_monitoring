<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lab Monitoring | Reservation</title>
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
              <h1>
                Reservation Form
              </h1>
              @include('inc.messages')
              <ol class="breadcrumb">
                <li ><a href="#"><i class="fa fa-dashboard"></i>Scheduling</a></li>
                <li class="active"><a href="/reservation"></i>Reservation</a></li>
              </ol>
            </section>
        
            <!-- Main content -->
            <section class="content">
              <div class="row">
                <div class="col-md-3" >
                  <div class="box box-solid" >
                    <div class="box-header with-border ">
                      <h3 class="box-title">Reserve a Laboratory Room:</h3>
                    </div>
                    <div class="box-body">
                      <form action="/reservation" autocomplete="off" method="POST">
                        @csrf
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
                      <div class="bootstrap-timepicker">
                        <div class="form-group">
                          <label>Start Time of Login:</label>
        
                          <div class="input-group">
                            <input name="time_from" type="text" class="form-control timepicker" required>
        
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
                            <input name="time_to" type="text" class="form-control timepicker" required>
        
                            <div class="input-group-addon">
                              <i class="fa fa-clock-o"></i>
                            </div>
                          </div>
                        <!-- /.input group -->
                      </div>
                      </div>
                      @if (\App\account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin')
                      <div class="form-group">
                        <label>User</label>
                        <select name="user" class="form-control select2" style="width: 100%;" required>
                          @foreach ($faculties as $faculty)
                            <option value="{{$faculty->id_number}}">{{$faculty->fullname}} ({{$faculty->id_number}}) </option>
                          @endforeach
                        </select>
                      </div> 
                      @else
                      <div class="form-group">
                        @foreach ($faculties as $faculty)
                        <label>User</label>
                        <input type="text" class="form-control" placeholder="{{$faculty->fullname}} ({{$faculty->id_number}})" disabled="">
                      <input name="user" type="hidden" value="{{$faculty->id_number}}">
                      @endforeach
                      </div>
                      @endif
                      

                      
                      <div class="form-group">
                        <label>Subjects</label>
                        <select name = 'subject[]' class="form-control select2" multiple="multiple" data-placeholder="Select a Subject or event" style="width: 100%;" required>
                          @foreach ($subjects as $subject)
                            <option value="{{$subject->id}}">{{$subject->course_number}} {{$subject->description}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Room</label>
                        <select name = 'room' class="form-control select2" style="width: 100%;" required>>
                          @foreach ($rooms as $room)
                            <option value="{{$room->id}}">{{$room->room_number}} {{$room->room_type}}</option>
                          @endforeach
                        </select>
                      </div>
                      <input class="btn btn-block btn-primary" style="width: 100%;" type="Submit" value="Submit">
                  </form>
                      <!-- /input-group -->
                    </div>
                  </div>
                  
                  <!-- /. box -->
                  
                </div>
                
                <!-- /.col -->
                <div class="col-md-9">
                  <div class="box box-primary">
                    <form action="/deleteReservation" method="POST">
                      {{ csrf_field() }}
                      <div class="box-body">
                        @if (\App\account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin')
                        <input type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default" style=" width: 15%; background-color: #dd4b39; border-color: #d73925;" value="Delete Selected Record">
                        @endif
                        <div class="modal fade" id="modal-default">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header" style=" border-bottom: 1px solid;">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">Delete Selected Reservation</h4>
                              </div>
                              <div class="modal-body">
                                <p style="display: flex; justify-content: center; font-size: 20px">Are you sure want to delete the selected Reservation?</p>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" style="background-color: #dd4b39; border-color: #d73925;" class="btn btn-primary">Delete</button>
                              </div>
                            </div>
                              <!-- /.modal-content -->
                          </div>
                              <!-- /.modal-dialog -->
                        </div>
                      </div>
                    <div class="box-body">
                      <!-- THE CALENDAR -->
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <style type="text/css">
                            .btn-primary{
                              width: 12%;
                            }
                            #example1 tr th{
                              text-align: center;
                            }
                            .btn-primary{
                              margin-top: 5px;
                              margin-right: 20px;
                              display: inline;
                            }
                          </style>
                        <tr>
                          <th>
                              <input type="checkbox" onclick="toggle(this);">
                              Select All
                          </th>
                          <th>Name</th>
                          <th>Id Number</th>
                          <th>Subject</th>
                          <th>Room</th>
                          <th>From</th>
                          <th>To</th>
                          <th>Date of Reservation</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($reservations as $reservation)
                          <tr>
                          <td style="text-align: center;"> <input type="checkbox" name="delete[]" value="{{ $reservation->reservation_id }}"> </td>
                            <td style="text-align: center;">{{$reservation->fullname}}</td>
                            <td style="text-align: center;">{{$reservation->r_id_number}}</td>
                            <td style="text-align: center;">{{$reservation->course_number}}  {{$reservation->description}}</td>
                            <td style="text-align: center;">{{$reservation->room_number}} {{$reservation->room_type}}</td>
                            <td style="text-align: center;">{{$reservation->start}}</td>
                            <td style="text-align: center;">{{$reservation->end}}</td>
                            <td style="text-align: center;">{{$reservation->date}}</td>
                            <style type="text/css">
                              .table-data-feature form {
                                display: inline;
                              }
                              .table-data-feature {
                                display: flex;
                                justify-content: space-evenly;
                              }
                              .col-sm-7 {
                                display: flex;
                                justify-content: flex-end;
                              }
                              .col_sm-6 {
                                display: flex;
                              }
                              .col-sm-6 .dataTables_filter{
                                display: flex;
                                justify-content: flex-end;
                              }
                          </style> 
                            </tr> 
                          @endforeach
                        
                        </tbody>
                      </table>
                    </div>
                   
                    <!-- /.box-body -->
                  </div>
                </form>
                  <!-- /. box -->
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
      <script>
        function toggle(source) {
          var checkboxes = document.querySelectorAll('input[type="checkbox"]');
          for (var i = 0; i < checkboxes.length; i++) {
              if (checkboxes[i] != source)
                  checkboxes[i].checked = source.checked;
          }
      }
      
        $(function () {
          $('#example1').DataTable()
          $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
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
      
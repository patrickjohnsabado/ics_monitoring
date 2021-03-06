<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lab Monitor | Create a New Semester</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
        @include('inc.messages')
        <h1>
          Set New Semester
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Semester</a></li>
          <li class="active"><a href="/students">New Semester</a></li>
        </ol>
      </section>
  
      <!-- Main content -->
      <section class="content">
  <br><br>
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
          <div class="box-header with-border" style="border-bottom: 1px solid;">
            <h3 class="box-title">New Semester</h3>
  
            
          </div>
          <!-- /.box-header -->
          <div class="box-body" style="z-index: 10000 !important;">
            <div class="row">
              <div class="col-md-6">
                <form action="/settings" method="POST" autocomplete="off">
                  @csrf 
                <div class="form-group">
                  <div class="form-group">
                    <label>Select Semester:</label>
                    <select name='semester' class="form-control select2"data-placeholder="Select a State" style="width: 100%;" required>
                          <option value="1st Sem">1st Sem</option>
                          <option value="2nd Sem">2nd Sem</option>
                          <option value="Short Term">Short Term</option>
                      </select>


                  </div>


                  <div class="form-group">

                    <label>Start Date of Semester:</label>
    
                    <div class="input-group date">
                      <div class="input-group-addon" >
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="start" type="text" class="form-control pull-right" id="datepicker" required>
                    </div>
                  </div>
                  <label>End Date of Semester:</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input name="end" type="text" class="form-control pull-right" id="datepicker2" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Assigned Token for this Semester:</label>
                    <input type="number" name="token" class="form-control" required>
                  </div>
                  </div>
                  
                      <!-- /.input group -->
                    </div>
                    <!-- /.form group -->
                    <input class="btn btn-block btn-primary" style="width: 12%;" type="Submit" value="Submit">
                  </div>
                </form>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            Reminder:<br> 
            Faculty Name Format: FirstName, MI, LastName
          </div>
        </div>
        <!-- /.box -->
  
        
        <!-- /.tab-pane -->
      </div>
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src='{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js')}}'></script>
<!-- Bootstrap 3.3.7 -->
<script src='{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}'></script>
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
      autoclose: true,
      beforeShow:function(input) {
        $(input).css({
            "z-index": "10000 !important"
        });
    }
    })

    $('#datepicker2').datepicker({
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

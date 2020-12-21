<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Lab Monitoring | Calendar</title>
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
  <!-- fullCalendar -->
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.css')}}'>
  <link rel="stylesheet" href='{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}' media="print">
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
                 Calendar
                 
                </h1>
                @include('inc.messages')
                
                <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i>Scheduling</a></li>
                  <li class="active"><a href="/calendar">Calendar</a></li>
                </ol>
              </section>
            </section>
        
            <!-- Main content -->
            <section class="content">
              <div class="row">
                
                <!-- /.col -->
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-body no-padding">
                      <!-- THE CALENDAR -->
                      <div id="calendar"></div>
                    </div>
                    <!-- /.box-body -->
                  </div>
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
<!-- jQuery UI 1.11.4 -->
<script src='{{ asset('AdminLTE/bower_components/jquery-ui/jquery-ui.min.js')}}'></script>
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
<script src='{{ asset('AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.js')}}'></script>
<script src='{{ asset('AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}'></script>
<!-- bootstrap datepicker -->
<script src='{{ asset('AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}'></script>
<!-- page script -->
<script>
  $(function () {
    
    /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject)

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      eventRender: function(eventObj, $el) {
      $el.popover({
        title: eventObj.title,
        content: eventObj.description,
        trigger: 'hover',
        html: true,
        placement: 'top',
        container: 'body'
      });
    },
      //Random default events
      events    : [
        @foreach ($reservations as $reservation)
        {
          
          title          : '{{$reservation->fullname}} - {{$reservation->description}}',
          @if(Carbon\Carbon::parse($reservation->start)->hour < 12 && Carbon\Carbon::parse($reservation->end)->hour > 12)
          description    : 'Subject: {{$reservation->description}} <br> Faculty:{{$reservation->fullname}} <br> Room:{{$reservation->room_number}}({{$reservation->room_type}})  <br> Date: {{$reservation->date}} <br> Time: {{$reservation->start}} AM - {{ Carbon\Carbon::parse($reservation->end)->subHours(12)->toTimeString()}} PM',
          @elseif (Carbon\Carbon::parse($reservation->start)->hour < 12 && Carbon\Carbon::parse($reservation->end)->hour == 12)
          description    : 'Subject: {{$reservation->description}} <br> Faculty:{{$reservation->fullname}} <br> Room:{{$reservation->room_number}}({{$reservation->room_type}})  <br> Date: {{$reservation->date}} <br> Time: {{$reservation->start}} AM - {{$reservation->end}} PM',
          @elseif (Carbon\Carbon::parse($reservation->start)->hour == 12 && Carbon\Carbon::parse($reservation->end)->hour == 12)
          description    : 'Subject: {{$reservation->description}} <br> Faculty:{{$reservation->fullname}} <br> Room:{{$reservation->room_number}}({{$reservation->room_type}})  <br> Date: {{$reservation->date}} <br> Time: {{$reservation->start}} PM - {{$reservation->end}} PM',
          @elseif (Carbon\Carbon::parse($reservation->start)->hour > 12 && Carbon\Carbon::parse($reservation->end)->hour > 12)
          description    : 'Subject: {{$reservation->description}} <br> Faculty:{{$reservation->fullname}} <br> Room:{{$reservation->room_number}}({{$reservation->room_type}})  <br> Date: {{$reservation->date}} <br> Time: {{ Carbon\Carbon::parse($reservation->start)->subHours(12)->toTimeString()}} PM - {{ Carbon\Carbon::parse($reservation->end)->subHours(12)->toTimeString()}} PM',
          @elseif (Carbon\Carbon::parse($reservation->start)->hour == 12 && Carbon\Carbon::parse($reservation->end)->hour > 12)
          description    : 'Subject: {{$reservation->description}} <br> Faculty:{{$reservation->fullname}} <br> Room:{{$reservation->room_number}}({{$reservation->room_type}})  <br> Date: {{$reservation->date}} <br> Time: {{$reservation->start}} PM - {{ Carbon\Carbon::parse($reservation->end)->subHours(12)->toTimeString()}} PM',
          @else
          description    : 'Subject: {{$reservation->description}} <br> Faculty:{{$reservation->fullname}} <br> Room:{{$reservation->room_number}}({{$reservation->room_type}})  <br> Date: {{$reservation->date}} <br> Time: {{$reservation->start}} AM - {{$reservation->end}} AM',
          @endif
          start          : new Date({{ Carbon\Carbon::parse($reservation->date)->year}}, {{ Carbon\Carbon::parse($reservation->date)->month}}-1, {{ Carbon\Carbon::parse($reservation->date)->day}}, {{ Carbon\Carbon::parse($reservation->start)->hour}}, {{ Carbon\Carbon::parse($reservation->start)->minute}}),
          end            : new Date({{ Carbon\Carbon::parse($reservation->date)->year}}, {{ Carbon\Carbon::parse($reservation->date)->month}}-1, {{ Carbon\Carbon::parse($reservation->date)->day}}, {{ Carbon\Carbon::parse($reservation->end)->hour}}, {{ Carbon\Carbon::parse($reservation->end)->minute}}),
          backgroundColor: '#3c8dbc', //Primary (light-blue)
          borderColor    : '#3c8dbc' //Primary (light-blue)
          
        },
        @endforeach
      ],
      
      editable  : false,
      droppable : false, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)

        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true)

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove()
        }

      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    })

    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

</body>
</html>

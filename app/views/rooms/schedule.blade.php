@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{ url('calendar/fullcalendar.css')}}">
	<script type="text/javascript" language="javascript" src="{{ url('calendar/lib/moment.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('calendar/lib/jquery-ui.custom.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('calendar/lang/de.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('calendar/fullcalendar.js')}}"></script>
	
	<script type="text/javascript" class="init">
	
		$(document).ready(function() {
	
		    // page is now ready, initialize the calendar...
	
		    $('#calendar').fullCalendar({
		        // put your options and callbacks here
		        aspectRatio: 1,
		        header: {
					left: '',
					center: '',
					right: ''
				},
		        lang: 'de',
		    	defaultView: 'agendaWeek',
		    	editable: false,
		    	minTime: "08:00:00",
		    	maxTime: "20:00:00",
		    	slotDuration : '00:30:00',
		    	axisFormat: 'HH:mm',
		    	allDaySlot: false,
		    	timezone: "Europe/Berlin",
		    	columnFormat: "dddd",
		    	weekends: false,
		    	slotEventOverlap: false,
		    	events: {{ json_encode($output) }}
		    });

	
		});

	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Übersichten</li>
	  <li class="active">Stundenpläne</li>
	  <li class="active">{{ $turn->name }}  {{ $turn->year }} </li>
	  <li class="active">{{ $listofdegreecourses[$degreecourse->id] }}</li>
	  <li class="active">Fachsemester: {{ $semester }}</li>
	</ol>
@stop

@section('main')
	<h4>Stundenplan {{ $listofdegreecourses[$degreecourse->id] }} {{ $semester }}. Fachsemester im {{ $turn->name }}  {{ $turn->year }}</h4>
	<div class="row" style="margin-bottom: 5px;">
		{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['schedule.degreecourseSchedule']]) }}
		<div class="col-xs-2">
		{{ Form::select('turn_id', $listofturns, $turn->id, array('id' => "turn_id", 'class' => "form-control input-sm"))}}
		</div>
		<div class="col-xs-3">
			{{ Form::select('degreecourse_id', $listofdegreecourses, $degreecourse->id, array('id' => "degreecourse_id", 'class' => "form-control input-sm"))}}
		</div>
		<div class="col-xs-1">
			{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary')) }}
			{{ Form::hidden('semester', $semester)}}
		</div>
		{{ Form::close() }}
	</div>

	<div class="row" style="margin-bottom: 5px;">
		<div class="col-sm-12">
			<div class="btn-toolbar">
			    <div class="btn-group  btn-group-justified">
			    	@if ($degreecourse->degree->name == "Master")
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 1)) }}" class="btn btn-default">FS: 1</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 2)) }}" class="btn btn-default">FS: 2</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 3)) }}" class="btn btn-default">FS: 3</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 4)) }}" class="btn btn-default">FS: 4</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 'alle')) }}" class="btn btn-default">FS: Alle</a>
					@else
						<a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 1)) }}" class="btn btn-default">FS: 1</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 2)) }}" class="btn btn-default">FS: 2</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 3)) }}" class="btn btn-default">FS: 3</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 4)) }}" class="btn btn-default">FS: 4</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 5)) }}" class="btn btn-default">FS: 5</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 6)) }}" class="btn btn-default">FS: 6</a>
					    <a href="{{ route('schedule.semester', array($turn->id, $degreecourse->id, 'alle')) }}" class="btn btn-default">FS: Alle</a>
					@endif
			    </div>
			</div>
		</div>
	</div>
		<div id='calendar'></div>
@stop
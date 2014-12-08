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
		    	axisFormat: 'HH:mm',
		    	allDaySlot: false,
		    	timezone: "Europe/Berlin",
		    	columnFormat: "dddd",
		    	weekends: false,
		    	slotEventOverlap: true,
		    	events: {{ json_encode($output) }}
		    });
	
		});

	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Übersichten</li>
	  <li class="active">Raumbelegung</li>
	  <li class="active">{{ $turn->name }}  {{ $turn->year }} </li>
	  <li class="active">{{ $room->name }} ({{ $room->location }})</li>
	</ol>
@stop

@section('main')
	<h4>Raumbelegung {{ $room->name }} ({{ $room->location }}) im {{ $turn->name }}  {{ $turn->year }}</h4>
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['rooms.overview']]) }}
			<div class="col-xs-2">
			{{ Form::select('turn_id', $listofturns, $turn->id, array('id' => "turn_id", 'class' => "form-control input-sm"))}}
			</div>
			<div class="col-xs-3">
				{{ Form::select('room_id', $listofrooms, $room->id, array('id' => "room_id", 'class' => "form-control input-sm"))}}
			</div>
			<div class="col-xs-1">
				{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary')) }}
			</div>
			{{ Form::close() }}
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div  class="table-responsive">
		       	<table class="table table-striped table-condensed table-bordered">
		       		<thead>
		       			<tr>
		       				<th>Raumname</th>
		       				<th>Ort</th>
		       				<th>Sätze</th>
		       				<th>Typ</th>	
		       				<th>Beamer</th>
		       				<th>Tafel</th>
		       				<th>OHP</th>
		       				<th>Behindertengerecht</th>
		       			</tr>
		       		</thead>
		       		<tbody>
		       			<tr>
		       				<td>{{ $room->name }}</td>
		    					<td>{{ $room->location }}</td>
		    					<td>{{ $room->seats }}</td>
		    					<td>{{ $listofroomtypes[$room->room_type_id] }}</td>
		    					@if ($room->beamer)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		    					@if ($room->blackboard)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		    					@if ($room->overheadprojector)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		    					@if ($room->accessible)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		       			</tr>
		       		</tbody>
		       	</table>
		    </div>
		</div>
	</div>

	<div id='calendar'></div>
@stop
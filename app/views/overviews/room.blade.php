@section('scripts')
	@include('layouts.partials.calendar-script', ['weekends' => 'true'])
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Übersichten</li>
	  <li class="active">Raumbelegung</li>
	  <li class="active">{{ $turn->present() }} </li>
	  <li class="active">{{ $room->present() }})</li>
	</ol>
@stop

@section('main')
	<h4>Raumbelegung {{ $room->present() }}) im {{ $turn->present() }}</h4>
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['fetchRoomOccupation_path']]) }}
			<div class="col-xs-2">
			{{ Form::select('turnId', $listOfTurns, $turn->id, array('id' => "turnId", 'class' => "form-control input-sm"))}}
			</div>
			<div class="col-xs-3">
				{{ Form::select('roomId', $listOfRooms, $room->id, array('id' => "roomId", 'class' => "form-control input-sm"))}}
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
		    					<td>{{ $listOfRoomtypes[$room->roomtype_id] }}</td>
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
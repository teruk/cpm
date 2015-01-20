@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#data_table').dataTable({
                "displayLength": -1,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
				"pagingType": "full"
			});
		} );
	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
	    <li class="active">Suche nach freien Räumen</li>
	</ol>
@stop

@section('main')
	<h4>Suche nach freien Räumen</h4>
	<div class="row">
		<div class="col-sm-4">
			<div class="well">
				{{ Form::model(new Room, ['method' => 'PATCH', 'route' => ['showRoomSearchResults_path'], 'class' => "form-horizontal"]) }}
				<div class="form-group">
	                {{ Form::label('minSeats', 'Min. Plätze*:', array('class' => "col-lg-5 control-label", 'id' => "minSeats")) }}
	                <div class="col-lg-7">
	                  {{ Form::input('number', 'minSeats', '', array('id' => "minSeats", 'min' => 0, 'step' => 1, 'required' => true, 'class' => "form-control input-sm", 'autofocus' => true)) }}
	                </div>
              	</div>
	              
              	<div class="form-group">
	                {{ Form::label('maxSeats', 'Max. Plätze:', array('class' => "col-lg-5 control-label", 'id' => "maxSeats")) }}
	                <div class="col-lg-7">
	                  {{ Form::input('number', 'maxSeats', '', array('id' => "maxSeats", 'step' => 1, 'class' => "form-control input-sm")) }}
	                </div>
              	</div>
	              
              	<div class="form-group">
	                {{ Form::label('roomtypeId', 'Raumtyp*:', array('class' => "col-lg-5 control-label", 'id' => "roomtypeId")) }}
	                <div class="col-lg-7">
	                  {{ Form::select('roomtypeId', $roomtypes, 2, array('id' => "roomtypeId", 'required' => true, 'class' => "form-control input-sm")) }}
	                </div>
              	</div>

              	<div class="form-group">
	                {{ Form::label('turnId', 'Semester*:', array('class' => "col-lg-5 control-label", 'id' => "turnId")) }}
	                <div class="col-lg-7">
	                  {{ Form::select('turnId', $turns, $currentTurn->id, array('id' => "turnId", 'required' => true, 'class' => "form-control input-sm")) }}
	                </div>
              	</div>

              		<div class="form-group">
			            {{ Form::label('weekday', 'Wochentag*:', array('class' => "col-lg-5 control-label", 'id' => "weekday")) }}
			            <div class="col-lg-7">
			            	{{ Form::select('weekday', Config::get('constants.weekdays_short'), 0, array('class' => 'form-control input-sm')) }}
			            </div>
	         		</div>
	              
	              	<div class="form-group">
			            {{ Form::label('start_time', 'Startzeit*:', array('class' => "col-lg-5 control-label", 'id' => "start_time")) }}
			            <div class="col-lg-7">
			              {{ Form::input('time', 'start_time', '', array('class' => 'form-control input-sm', 'required'=>true)) }}
			            </div>
	         		</div>
	         		<div class="form-group">
			            {{ Form::label('end_time', 'Endzeit*:', array('class' => "col-lg-5 control-label", 'id' => "end_time")) }}
			            <div class="col-lg-7">
			              {{ Form::input('time', 'end_time', '', array('class' => 'form-control input-sm', 'required'=>true)) }}
			            </div>
		         	</div>
		         	
		         	<div class="form-group">
			            <div class="col-lg-7 col-lg-offset-5" style="text-align: right">
			            *erforderlich
			        	{{ Form::submit('Suche freie Räume', array('class' => 'btn btn btn-info')) }}
			            </div>
			          </div>
				{{ Form::close() }}
			</div>
		</div>

		@if (sizeof($searchresults) > 0)
			<div class="col-sm-7">
				<div class="table-responsive">
			        <table class="table table-condensed table-striped" id="data_table" cellspacing="0">
			        	<thead>
			                <tr>
			       				<th>Raumname</th>
			       				<th>Plätze</th>
			       				<th>Typ</th>	
			       				<th>Beamer</th>
			       				<th>Tafel</th>
			       				<th>OHP</th>
			       			</tr>
			          	</thead>
			          	<tbody>
			          		@foreach ($searchresults as $room)
			          			<tr>
				       				<td>{{ link_to_route('showRoomOccupation_path', $room->name.' ('.$room->location.')' , [$turn->id, $room->id]) }}</td>
			    					<td>{{ $room->seats }}</td>
			    					<td>{{ $roomtypes[$room->roomtype_id] }}</td>
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
				       			</tr>
			               	@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@endif
	</div>

@stop
@section('scripts')
	@include('layouts.partials.calendar-script', ['weekends' => 'false'])
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">Semesterplanung</a></li>
	  <li><a href="{{ URL::route('showTurnPlannings_path', $turn->id)}}">{{ $turn->present() }}</a></li>
	  <li  class="active">{{$course->module->short}} {{ $course->module->name }}</li>
	  <li class="active">Räume verwalten</li>
	</ol>
@stop

@section('main')
	<div class="row">
		@include('plannings.partials.sidenav', ['showEmployees' => true, 'showRooms' => false, 'showInformation' => true])

		<div class="col-md-9">
			@include('plannings.partials.heading', ['title' => 'Räume verwalten:'])
			<p>[Infotext]</p>

			<div class="panel panel-default">
            	<div class="panel-body form-horizontal" style="margin-bottom: -20px">
					<table class="table table-striped table-condensed">
		    			<thead>
		    				<tr>
								<th>Zugeordnete Räume</th>
								<th>Tag</th>
								<th>Start</th>
								<th>Ende</th>
								<th colspan=2>Optionen</th>
							</tr>
		    			</thead>
						<tbody>									
							@if(sizeof($planning->rooms) == 0)
		    					<tr>
		    						<td colspan=4>Momentan sind dieser Veranstaltung keine Räume zugeordnet!</td>
		    					</tr>
		    				@else
								 @foreach($planning->rooms as $room)
									<tr>
										{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['updatePlanningRoom_path', $turn->id, $planning->id]]) }}
		        						{{ Form::hidden('room_id_old', $room->id) }}
										<td>{{ Form::select('room_id', $rooms, $room->id, array('class' => 'form-control input-sm')) }}</td>
										<td>{{ Form::select('weekday', Config::get('constants.weekdays_short'), $room->pivot->weekday, array('class' => 'form-control input-sm'))}}</td>
										<td>{{ Form::input('time', 'start_time', $room->pivot->start_time, array('class' => 'form-control input-sm', 'required'=>true)) }}</td>
										<td>{{ Form::input('time', 'end_time', $room->pivot->end_time, array('class' => 'form-control input-sm', 'required'=>true)) }}</td>
										<td>
											@if (Entrust::can('update_planning_room') || Entrust::hasRole('Admin'))
												{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}</td>
												{{ Form::hidden('start_time_old',$room->pivot->start_time) }}
												{{ Form::hidden('end_time_old',$room->pivot->end_time) }}
												{{ Form::hidden('weekday_old',$room->pivot->weekday) }}
												{{ Form::hidden('tabindex', 2) }}
												{{ Form::close() }}
											@endif
										<td>
											@if (Entrust::can('delete_planning_room') || Entrust::hasRole('Admin'))
												{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('detachPlanningRoom_path', $turn->id, $planning->id))) }}
		            							{{ Form::hidden('room_id', $room->id) }}
		            							{{ Form::hidden('weekday', $room->pivot->weekday) }}
		            							{{ Form::hidden('start_time', $room->pivot->start_time) }}
		            							{{ Form::hidden('end_time', $room->pivot->end_time) }}
		            							{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Raumzuordnung löschen')) }}
		            							{{ Form::hidden('tabindex', 2) }}
		            							{{ Form::close() }}
		            						@endif
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>

			@if (Entrust::can('add_planning_room') || Entrust::hasRole('Admin'))
				{{ Form::model($planning, ['method' => 'POST', 'route' => ['assignPlanningRoom_path', $turn->id, $planning->id]]) }}
				<div class="panel panel-default">
	            	<div class="panel-body form-horizontal" style="margin-bottom: -20px">
	            		<table class="table table-striped table-condensed">
	            			<thead>
								<tr>
									<th colspan="6">Neuen Raum zuordnen:</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{ Form::select('room_id', $rooms, 0, array('class' => 'form-control input-sm')) }}</td>
									<td>{{ Form::select('weekday', Config::get('constants.weekdays_short'), 0, array('class' => 'form-control input-sm')) }}</td>
									<td>{{ Form::input('time', 'start_time', '', array('class' => 'form-control input-sm', 'required'=>true)) }}</td>
									<td>{{ Form::input('time', 'end_time', '', array('class' => 'form-control input-sm', 'required'=>true)) }}</td>
									<td>{{ Form::hidden('tabindex', 2) }}</td>
									<td>{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Raum zuordnen')) }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				{{ Form::close() }}
			@endif

			@if ($currentUser->can('add_planning_room') || $currentUser->hasRole('Admin'))
				<p><strong>Zu beachtende Vorlesungen anderer Pflichtveranstaltungen dieses Semesters:</strong></p>
				@include('plannings.partials.conflictTable')
			@endif

			@include('plannings.partials.relatedPlanningRoom')
		</div>
	</div>
@stop
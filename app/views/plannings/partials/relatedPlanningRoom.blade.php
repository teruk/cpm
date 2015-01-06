<div class="panel-group" id="accordion" style="margin-top: 10px;">
	@if (sizeof($oldplannings) > 0)
		  <div class="panel panel-default">
		    <div class="panel-heading">
		      <h4 class="panel-title">
		        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
		          Raumzuordnung der vergangenen Semester:
		        </a>
		      </h4>
		    </div>
		    <div id="collapseOne" class="panel-collapse collapse">
		      <div class="panel-body">
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>Semester</th>
							<th>Raum</th>
							<th>Tag</th>
							<th>Start</th>
							<th>Ende</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach($oldplannings as $p)								
							@if (sizeof($p->rooms) > 0)
								@foreach($p->rooms as $room)
									<tr>
										<td>{{ $room->turn->present() }} </td>
										<td>{{ $room->present() }}</td>
										<td>{{ Config::get('constants.weekdays_short')[$room->weekday] }}</td>
										<td>{{ substr($room->start_time,0,5) }}</td>
										<td>{{ substr($room->end_time,0,5) }}</td>
										<td>
											@if (Entrust::can('add_planning_room') || Entrust::hasRole('Admin'))
												{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['copyPlanningRoom_path', $turn->id, $planning->id]]) }}
												{{ Form::hidden('tabindex', 2) }}
												{{ Form::hidden('source_planning_room_id',$room->id) }}
												{{ Form::button('<i class="glyphicon glyphicon-repeat"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-copy', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Raum und Zeit übernehmen')) }}
												{{ Form::close() }}
											@endif
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="6">{{ $p->course_number }} {{ $course->module->short }} {{ $course->coursetype->name }}: Keine Raumzuordnung vorhanden</td>
								</tr>
							@endif
						@endforeach			
					</tbody>
				</table>
		      </div>
		    </div>
		  </div>
	@endif
	@if (sizeof($relatedplannings) > 0 )
	  	<div class="panel panel-default">
	    	<div class="panel-heading">
	      		<h4 class="panel-title">
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
			          Raumzuordnung anderer Veranstaltungen dieses Moduls:
			        </a>
	      		</h4>
	    	</div>
	    	<div id="collapseTwo" class="panel-collapse collapse in">
      			<div class="panel-body">
			        <table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>Nummer</th>
								<th>Modul</th>
								<th>Typ</th>
								<th>Grp.</th>
								<th>Raum (Zeit)</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
								 @foreach($relatedplannings as $p)								
									<tr>
										<td>{{ $p->course_number }}</td>
										<td>{{ $p->course->module->short }}</td>
										<td>{{ $p->course->coursetype->short }}</td>
										<td>{{ $p->group_number }}</td>
										<td>
											@if (sizeof($p->rooms) > 0)
												@foreach($p->rooms as $r)
													{{ $r->name }} - {{Config::get('constants.weekdays_short')[$r->pivot->weekday]}}, {{substr($r->pivot->start_time,0,5)}}-{{substr($r->pivot->end_time,0,5)}}<br> 
												@endforeach  
											@else
												Unbekannt
											@endif
										</td>
										<td>{{ HTML::decode(link_to_route('editPlanningRoom_path', '<i class="glyphicon glyphicon-edit"></i>', array($turn->id, $p->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'))) }}</td>
									</tr>
								@endforeach
						</tbody>
					</table>
      			</div>
    		</div>
  		</div>
	@endif
</div>
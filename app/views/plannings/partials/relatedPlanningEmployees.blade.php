<div class="panel-group" id="lecturer_accordion">
	@if (sizeof($oldplannings) > 0)
		<div class="panel panel-default">
		    <div class="panel-heading">
		      	<h4 class="panel-title">
		        	<a data-toggle="collapse" data-parent="#lecturer_accordion" href="#collapseOneLecturer">
		        	Lehrendenzuordnung der vergangenen Semester:
		        	</a>
		      	</h4>
		    </div>
		    <div id="collapseOneLecturer" class="panel-collapse collapse">
		      	<div class="panel-body">
					<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>Semester</th>
								<th>Nummer</th>
								<th>Titel</th>
								<th>Modul</th>
								<th>Typ</th>
								<th>Lehrende</th>
							</tr>
						</thead>
						<tbody>
							@foreach($oldplannings as $p)								
								<tr>
									<td>{{ $p->turn->name }} {{$p->turn->year}}</td>
									<td>{{ $p->course_number }}</td>
									<td>{{ $p->course_title }}</td>
									<td>{{ $p->course->module->short }}</td>
									<td>{{ $p->course->coursetype->name }}</td>
									<td>
										@if (sizeof($p->employees) > 0)
											@foreach($p->employees as $e)
												{{ $e->name }} ({{ $e->researchgroup->short }} - {{$e->pivot->semester_periods_per_week}} SWS);
											@endforeach  
										@else
											Unbekannt
										@endif
									</td>
									<td>
										@if (sizeof($p->employees) > 0 && (Entrust::can('add_planning_employee') || Entrust::hasRole('Admin')))
											{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['copyPlanningLecturer_path', $turn->id, $planning->id]]) }}
											{{ Form::hidden('tabindex', 1) }}
											{{ Form::hidden('source_planning_id',$p->id) }}
											{{ Form::button('<i class="glyphicon glyphicon-repeat"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-copy', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung übernehmen')) }}
											{{ Form::close() }}
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
		      	</div>
		    </div>
		</div>
	@endif
	@if (sizeof($relatedplannings) > 0)
		<div class="panel panel-default">
		   	<div class="panel-heading">
		      	<h4 class="panel-title">
		        	<a data-toggle="collapse" data-parent="#lecturer_accordion" href="#collapseTwoLecturer">
		          	Dazugehörige Veranstaltungen:
		        	</a>
		      	</h4>
		    </div>
		    <div id="collapseTwoLecturer" class="panel-collapse collapse in">
		      	<div class="panel-body">
		      		<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>Nummer</th>
								<!-- <th>Titel</th> -->
								<th>Modul</th>
								<th>Typ</th>
								<th>Grp.</th>
								<th>Lehrende</th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach($relatedplannings as $p)								
								<tr>
									<td>{{ $p->course_number }}</td>
									<!-- <td>{{ $p->course_title }}</td> -->
									<td>{{ $p->course->module->short }}</td>
									<td>{{ $p->course->coursetype->short }}</td>
									<td>{{ $p->group_number }}</td>
									<td>
										@if (sizeof($p->employees) > 0)
											@foreach($p->employees as $e)
												{{ $e->firstname }} {{ $e->name }} ({{ $e->researchgroup->short}} - {{$e->pivot->semester_periods_per_week}} SWS);
											@endforeach  
										@else
											Unbekannt
										@endif
									</td>
									<td>{{ HTML::decode(link_to_route('editPlanningLecturer_path', '<i class="glyphicon glyphicon-edit"></i>', array($turn->id, $p->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'))) }}</td>
									<td>
										@if (sizeof($p->employees) > 0 && (Entrust::can('add_planning_employee') || Entrust::hasRole('Admin')))
											{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['copyPlanningLecturer_path', $turn->id, $planning->id]]) }}
											{{ Form::hidden('tabindex', 1) }}
											{{ Form::hidden('source_planning_id',$p->id) }}
											{{ Form::button('<i class="glyphicon glyphicon-repeat"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-copy', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung übernehmen')) }}
											{{ Form::close() }}
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
	      		</div>
	    	</div>
	  	</div>
	@endif
</div>
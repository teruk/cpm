<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-primary">
            <div class="panel-body">
            	
        		<table class="table table-striped table-condensed">
        			<thead>
        				<tr>
							<th>Lehrende</th>
							<th>SWS</th>
							<th colspan=2>Optionen</th>
						</tr>
        			</thead>
					<tbody>
						@if(sizeof($planning->employees) == 0)
        					<tr>
        						<td colspan=4>Momentan sind dieser Veranstaltung keine Lehrenden zugeordnet!</td>
        					</tr>
        				@else
							 @foreach($planning->employees as $ccte)
								<tr>
									{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['plannings.updateEmployee', $turn->id, $planning->id]]) }}
            						{{ Form::hidden('employee_id', $ccte->id) }}
									<td>{{ $ccte->firstname }} {{ $ccte->name }} ({{$lists['researchgroups'][$ccte->researchgroup_id]}})</td>
									<td>
										@if (Entrust::can('update_planning_employee') || Entrust::hasRole('Admin'))
											{{ Form::input('number', 'semester_periods_per_week', $ccte->pivot->semester_periods_per_week, array('min' => 0, 'max' => $course->semester_periods_per_week, 'step' => 0.5, 'class' => 'form-control input-sm'))}}
										@else
											{{ $ccte->pivot->semester_periods_per_week }}
										@endif
									</td>
									<td>
										@if (Entrust::can('update_planning_employee') || Entrust::hasRole('Admin'))
											{{ Form::button('<i class="glyphicon glyphicon-refresh"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
											{{ Form::hidden('tabindex', 1) }}
											{{ Form::close() }}
										@endif
									</td>
									<td>
										@if (Entrust::can('delete_planning_employee') || Entrust::hasRole('Admin'))
											{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('plannings.deleteEmployee', $turn->id, $planning->id))) }}
	            							{{ Form::hidden('employee_id', $ccte->id) }}
	            							{{ Form::hidden('tabindex', 1) }}
	            							{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zuordnung löschen')) }}
	            							{{ Form::close() }}
	            						@endif
									</td>
								</tr>
							@endforeach
						@endif
						<tr>
							@if (Entrust::can('add_planning_employee') || Entrust::hasRole('Admin'))
								<th colspan="4">Neue lehrende Person zuordnen:</th>
						</tr>
						{{ Form::model($planning, ['method' => 'POST', 'route' => ['plannings.addEmployee', $turn->id, $planning->id]]) }}
						<tr>
								<td>{{ Form::select('employee_id', $lists['possibleemployees'],'', array('class' => 'form-control input-sm')) }} </td>
								<td>{{ Form::input('number', 'semester_periods_per_week', 1, array('id' => 'semester_periods_per_week', 'min' => 0, 'max' => $course->semester_periods_per_week, 'step' => 0.5, 'class' => 'form-control input-sm'))}}</td>
								<td>{{ Form::hidden('tabindex', 1) }}</td>
								<td>{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Person zuordnen')) }}</td>
							@endif
						</tr>
						{{ Form::close() }}
					</tbody>
					<tfoot><tr><td colspan=4></td></tr></tfoot>
				</table>

				<div class="panel-group" id="lecturer_accordion">
					@if (sizeof($oldplannings) > 0)
						<div class="panel panel-primary">
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
													<td>{{ $lists['coursetypes'][$p->course->coursetype_id] }}</td>
													<td>
														@if (sizeof($p->employees) > 0)
															@foreach($p->employees as $e)
																{{ $e->name }} ({{ $lists['researchgroups'][$e->researchgroup_id]}} - {{$e->pivot->semester_periods_per_week}} SWS);
															@endforeach  
														@else
															Unbekannt
														@endif
													</td>
													<td>
														@if (sizeof($p->employees) > 0 && (Entrust::can('add_planning_employee') || Entrust::hasRole('Admin')))
															{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['plannings.copyEmployee', $turn->id, $planning->id]]) }}
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
						<div class="panel panel-primary">
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
													<td>{{ $lists['coursetypes'][$p->course->coursetype_id] }}</td>
													<td>{{ $p->group_number }}</td>
													<td>
														@if (sizeof($p->employees) > 0)
															@foreach($p->employees as $e)
																{{ $e->firstname }} {{ $e->name }} ({{ $lists['researchgroups'][$e->researchgroup_id]}} - {{$e->pivot->semester_periods_per_week}} SWS);
															@endforeach  
														@else
															Unbekannt
														@endif
													</td>
													<td>{{ HTML::decode(link_to_route('plannings.edit', '<i class="glyphicon glyphicon-edit"></i>', array($turn->id, $p->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'))) }}</td>
													<td>
														@if (sizeof($p->employees) > 0 && (Entrust::can('add_planning_employee') || Entrust::hasRole('Admin')))
															{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['plannings.copyEmployee', $turn->id, $planning->id]]) }}
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
			</div>
		</div>
	</div>
	
	<div class="col-sm-4">
		<div class="panel panel-primary">
            <div class="panel-body">
            	<table class="table table-striped table-condensed">
            		<tbody>
            			<tr>
            				<th colspan=4>Informationen</th>
            			</tr>
            			<tr>
            				<td colspan=2>Modul:</td>
            				<td colspan=2>{{ $course->module->short }}</td>		            				
            			</tr>
            			<tr>
            				<td colspan=2>Kurs:</td>
            				<td colspan=2>{{ $planning->course_title }}</td>		            				
            			</tr>
            			<tr>
            				<td colspan=2>Typ:</td>
            				<td colspan=2>{{ $lists['coursetypes'][$course->coursetype_id] }}</td>		            				
            			</tr>
            			<!-- <tr>
            				<td colspan=2>Teilnehmer:</td>
            				<td colspan=2>{{ $course->participants }}</td>		            				
            			</tr> -->
            			<tr>
            				<td colspan=2>Gruppe:</td>
            				<td colspan=2>{{ $planning->group_number }}</td>		            				
            			</tr>
            			<tr>
            				<td colspan=2>Vorstand:</td>
            				<td colspan=2>{{ Config::get('constants.pl_board_status')[$planning->board_status] }}</td>		            				
            			</tr>
            			<tr>
            				<td colspan=2>Status:</td>
            				<td colspan=2>{{ Config::get('constants.pl_rgstatus')[$planning->researchgroup_status] }}</td>
            			</tr>
						<tr>
            				<th>Raum</th>
            				<th></th>
            				<th>Start</th>
            				<th>Ende</th>
            			</tr>
            			@if(sizeof($planning->rooms) == 0)
            				<tr>
            					<td colspan=2>Keine Räume zugeordnet!</td>
            				</tr>
            			@else
							@foreach($planning->rooms as $r)
								 <tr>
								 	<td>{{ $r->name }} ({{ $r->location }})</td>
								 	<td>{{ Config::get('constants.weekdays_short')[$r->pivot->weekday] }}.</td>
								 	<td>{{ substr($r->pivot->start_time,0,5) }}</td>
								 	<td>{{ substr($r->pivot->end_time,0,5) }}</td>
								 </tr>
							@endforeach
						@endif
            		</tbody>
            	</table>
            </div>
        </div>
    </div>
</div>
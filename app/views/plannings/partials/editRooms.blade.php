<div class="row">
 	<div class="col-sm-8">
		<div class="panel panel-primary">
            <div class="panel-body">
            	<table class="table table-striped table-condensed">
        			<thead>
        				<tr>
							<th>Raum</th>
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
									{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['plannings.updateRoom', $turn->id, $planning->id]]) }}
            						{{ Form::hidden('room_id_old', $room->id) }}
									<td>{{ Form::select('room_id', $lists['rooms'], $room->id, array('class' => 'form-control input-sm')) }}</td>
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
											{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('plannings.deleteRoom', $turn->id, $planning->id))) }}
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
							<tr>
								@if (Entrust::can('add_planning_room') || Entrust::hasRole('Admin'))
									<th colspan="6">Neuen Raum zuordnen:</th>
							</tr>
							{{ Form::model($planning, ['method' => 'POST', 'route' => ['plannings.addRoom', $turn->id, $planning->id]]) }}
							<tr>
									<td>{{ Form::select('room_id', $lists['rooms'], 0, array('class' => 'form-control input-sm')) }}</td>
									<td>{{ Form::select('weekday', Config::get('constants.weekdays_short'), 0, array('class' => 'form-control input-sm')) }}</td>
									<td>{{ Form::input('time', 'start_time', '', array('class' => 'form-control input-sm', 'required'=>true)) }}</td>
									<td>{{ Form::input('time', 'end_time', '', array('class' => 'form-control input-sm', 'required'=>true)) }}</td>
									<td>{{ Form::hidden('tabindex', 2) }}</td>
									<td>{{ Form::button('<i class="glyphicon glyphicon-arrow-right"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Raum zuordnen')) }}</td>
								@endif
							</tr>
						{{ Form::close() }}
					</tbody>
					<tfoot><tr><td colspan=6></td></tr></tfoot>
				</table>
					
					<div class="panel-group" id="accordion">
						@if (sizeof($oldrooms) > 0)
							  <div class="panel panel-primary">
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
											@foreach($oldrooms as $room)
												<tr>
													<td>{{ $lists['turns'][$room->turn_id] }} </td>
													<td>{{ $lists['rooms'][$room->room_id] }}</td>
													<td>{{ Config::get('constants.weekdays_short')[$room->weekday] }}</td>
													<td>{{ substr($room->start_time,0,5) }}</td>
													<td>{{ substr($room->end_time,0,5) }}</td>
													<td>
														@if (Entrust::can('add_planning_room') || Entrust::hasRole('Admin'))
															{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['plannings.copyRoom', $turn->id, $planning->id]]) }}
															{{ Form::hidden('tabindex', 2) }}
															{{ Form::hidden('source_planning_room_id',$room->id) }}
															{{ Form::button('<i class="glyphicon glyphicon-repeat"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-copy', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Raum und Zeit übernehmen')) }}
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
						@if (sizeof($relatedplannings) > 0 )
						  	<div class="panel panel-primary">
						    	<div class="panel-heading">
						      		<h4 class="panel-title">
								        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
								          Raumzuordnung anderer Veranstaltungen dieses Moduls:
								        </a>
						      		</h4>
						    	</div>
						    	<div id="collapseTwo" class="panel-collapse collapse">
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
															<td>{{ $lists['coursetypes'][$p->course->course_type_id] }}</td>
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
															<td>{{ HTML::decode(link_to_route('plannings.edit', '<i class="glyphicon glyphicon-edit"></i>', array($turn->id, $p->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'))) }}</td>
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
            		<thead>
            			<tr>
            				<th colspan=4>Informationen</th>
            			</tr>
            		</thead>
            		<tbody>
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
            				<td colspan=2>{{ $lists['coursetypes'][$course->course_type_id] }}</td>		            				
            			</tr>
            			<tr>
            				<td colspan=2>Teilnehmer:</td>
            				<td colspan=2>{{ $course->participants }}</td>		            				
            			</tr>
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
            				<td colspan=2>Raumwunsch:</td>
            				<td colspan=2>{{ $planning->room_preference }}</td>
            			</tr>
            			<tr>
            				<th colspan=4>Lehrende</th>
            			</tr>
            			@if(sizeof($planning->employees) == 0)
            				<tr>
            					<td colspan=4>Keine Lehrenden zugeordnet!</td>
            				</tr>
            			@else
							@foreach($planning->employees as $e)
								 <tr>
								 	<td colspan=3>{{ $e->firstname }} {{ $e->name }} ({{ $lists['researchgroups'][$e->researchgroup_id] }})</td>
								 	<td>{{ $e->pivot->semester_periods_per_week }} SWS</td>
								 </tr>
							@endforeach
						@endif
            		</tbody>
            	</table>
            </div>
        </div>
    </div>
</div>
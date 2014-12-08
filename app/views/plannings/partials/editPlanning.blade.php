<div class="row"> 
	<div class="col-sm-8">
		<div class="panel panel-primary">
            <div class="panel-body">
				{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['plannings.update', $turn->id, $planning->id]]) }}
					<table class="table table-striped table-condensed">
						<tbody>
							<tr>
								<th>Nummer:</th>
								<td colspan=2 align="right">
									@if (Entrust::can('edit_planning_course_number') || Entrust::hasRole('Admin'))
										{{ Form::input('text', 'course_number', $planning->course_number, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm')) }}
									@else
										{{ Form::input('text', 'course_number', $planning->course_number, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
									@endif
								</td>
								<!-- <th>Modul:</th>
								<td align="right">{{ $course->module->short }}</td> -->
								<th>SWS:</th>
								<td colspan=2 align="right">{{ $course->semester_periods_per_week }}</td>
								<th>Typ:</th>
								<td align="right">{{ $lists['coursetypes'][$course->course_type_id] }}</td>
							</tr>
							<tr>
								<th>Titel:</th>
								<td colspan=5 align="right">
									@if (($course->course_type_id == 1 || $course->course_type_id == 4 || $course->course_type_id == 8 || $course->course_type_id == 9))
										{{ Form::input('text', 'course_title', $planning->course_title, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
									@else
										@if (Entrust::hasRole('Admin') || Entrust::can('edit_planning'))
											{{ Form::input('text', 'course_title', $planning->course_title, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm')) }}
										@else
											{{ Form::input('text', 'course_title', $planning->course_title, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
										@endif
									@endif
								</td>
								<th>Gruppe*:</th>
								<td align="right">{{ Form::input('number', 'group_number', $planning->group_number, array('min' => 1,'size' => 10,'max' => 25, 'required'=>true, 'class' => 'form-control input-sm')) }}</td>
							</tr>
							<tr>
								<td><strong>EngTitel:</strong></td>
								<td colspan=5 align="right">
									@if (($course->course_type_id == 1 || $course->course_type_id == 4 || $course->course_type_id == 8 || $course->course_type_id == 9))
										{{ Form::input('text', 'course_title_eng', $planning->course_title_eng, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
									@else
										@if (Entrust::hasRole('Admin') || Entrust::can('edit_planning'))
											{{ Form::input('text', 'course_title_eng', $planning->course_title_eng, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm')) }}
										@else
											{{ Form::input('text', 'course_title_eng', $planning->course_title_eng, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
										@endif
									@endif
								</td>
								<th>Sprache*:</th>
								<td align="right">{{ Form::select('language', Config::get('constants.language'), $planning->language, array('class' => 'form-control input-sm'))}}</td>
							<tr>
								<th>Zuständig:</th>
								<td align="right">{{ $lists['departments'][$course->module->department_id] }}</td>
								
								<th>VS:</th>
								<td colspan=3 align="right">
									@if (Entrust::hasRole('Admin') || Entrust::can('change_board_status'))
										{{ Form::select('board_status', Config::get('constants.pl_board_status'),$planning->board_status, array('class' => 'form-control input-sm')) }}
									@else
										{{ Form::select('board_status', Config::get('constants.pl_board_status'),$planning->board_status, array('class' => 'form-control input-sm', 'disabled' => true)) }}
									@endif
								</td>
								<th>AB:</th>
								<td colspan=1 align="right">
									@if (Entrust::hasRole('Admin') || Entrust::can('change_rg_status'))
										{{ Form::select('researchgroup_status', Config::get('constants.pl_rgstatus'), $planning->researchgroup_status, array('class' => 'form-control input-sm')) }}
									@else
										{{ Form::select('researchgroup_status', Config::get('constants.pl_rgstatus'), $planning->researchgroup_status, array('class' => 'form-control input-sm', 'disabled' => true)) }}
									@endif
								</td>
								
							</tr>
							<tr>
								<td><strong>Bemerkung:</strong></td>
								<td colspan=7 align="right">{{ Form::textarea('comment', $planning->comment, array('rows' => 5, 'class' => 'form-control input-sm', 'style' => 'resize:none;')) }}</td>
							</tr>
							<tr>
								<td><strong>Raum- und Zeitwunsch:</strong></td>
								<td colspan=7 align="right">{{ Form::textarea('room_preference', $planning->room_preference, array('rows' => 5, 'class' => 'form-control input-sm', 'style' => 'resize:none;')) }}</td>
							</tr>
							<tr>
								<td colspan=7>* erforderlich</td>
								<td align="right">
									@if (Entrust::can('edit_planning') || Entrust::hasRole('Admin'))
										{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
									@endif
								</td>
								{{ Form::hidden('tab_index', 0) }}
							</tr>
						</tbody>
						<tfoot><tr><td colspan=8></td></tr></tfoot>
					</table>
				{{ Form::close() }}

				<div class="panel-group" id="lecturer_accordion">
					@if (sizeof($oldplannings) > 0)
						  <div class="panel panel-primary">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" data-parent="#lecturer_accordion" href="#collapseOneCourse">
						        	Veranstaltungen der vergangenen Semester:
						        </a>
						      </h4>
						    </div>
						    <div id="collapseOneCourse" class="panel-collapse collapse">
						      <div class="panel-body">
        							<table class="table table-striped table-condensed">
										<thead>
											<tr>
												<th>Semester</th>
												<th>Nummer</th>
												<th>Titel</th>
												<th>Modul</th>
												<th>Typ</th>
												<th>Bemerkung</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach($oldplannings as $p)								
												<tr>
													<td>{{ $p->turn->name }} {{$p->turn->year}}</td>
													<td>{{ $p->course_number }}</td>
													<td>{{ $p->course_title }}</td>
													<td>{{ $p->course->module->short }}</td>
													<td>{{ $lists['coursetypesshort'][$p->course->course_type_id] }}</td>
													<td>{{ $p->comment }}</td>
													<td>{{ HTML::decode(link_to_route('plannings.edit', '<i class="glyphicon glyphicon-edit"></i>', array($p->turn_id, $p->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'))) }}</td>
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
						        <a data-toggle="collapse" data-parent="#lecturer_accordion" href="#collapseTwoCourse">
						          Dazugehörige Veranstaltungen:
						        </a>
						      </h4>
						    </div>
						    <div id="collapseTwoCourse" class="panel-collapse collapse">
						    	<div class="panel-body">
						    		<table class="table table-striped table-condensed">
										<thead>
											<tr>
												<th>Nummer</th>
												<th>Titel</th>
												<th>Modul</th>
												<th>Typ</th>
												<th>Grp.</th>
												<th>Bemerkung</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											@foreach($relatedplannings as $p)								
												<tr>
													<td>{{ $p->course_number }}</td>
													<td>{{ $p->course_title }}</td>
													<td>{{ $p->course->module->short }}</td>
													<td>{{ $lists['coursetypesshort'][$p->course->course_type_id] }}</td>
													<td>{{ $p->group_number }}</td>
													<td>{{ $p->comment }}</td>
													<td>{{ HTML::decode(link_to_route('plannings.edit', '<i class="glyphicon glyphicon-edit"></i>', array($turn->id, $p->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Zur Veranstaltung wechseln'))) }}</td>
												</tr>
											@endforeach
										</tbody>
										<tfoot><tr><td colspan=7></td></tr></tfoot>
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
            				<td colspan=2>Stand:</td>
            				<td colspan=2>{{ date('d.m.Y', strtotime($planning->updated_at))}}</td>
            			</tr>
            			<!-- <tr>
            				<td colspan=2>Abstimmung mit:</td>
            				<td colspan=2>[Funktion fehlt]</td>
            			</tr> -->
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
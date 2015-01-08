@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showTurnPlannings_path', 'Semesterplanung', $turn->id) }}</li>
	  <li>{{ link_to_route('showTurnPlannings_path', $turn->present(), $turn->id) }}</li>
	  <li  class="active">{{$course->module->short}} {{ $course->module->name }}</li>
	  <li class="active">Informationen bearbeiten</li>
	</ol>
@stop

@section('main')

	<div class="row">
		@include('plannings.partials.sidenav', ['showEmployees' => true, 'showRooms' => true, 'showInformation' => true])

		<div class="col-md-9">
			@include('plannings.partials.heading', ['title' => 'Informationen bearbeiten'])
			
			<p>
    			Die Aktualisierung des Bermerkungsfeldes sowie des Raum- und Zeitwunschfeldes wird auf alle verwandten Veranstaltungen übertragen.
    		</p>

			<div class="panel panel-default">
            	<div class="panel-body">
					{{ Form::model($planning, ['method' => 'PATCH', 'route' => ['updatePlanningInformation_path', $turn->id, $planning->id], 'class' => "form-horizontal"]) }}

						<div class="form-group">
							{{ Form::label('course_number', 'Nummer:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								@if ($currentUser->can('edit_planning_course_number') || $currentUser->hasRole('Admin'))
									{{ Form::input('text', 'course_number', $planning->course_number, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm')) }}
								@else
									{{ Form::input('text', 'course_number', $planning->course_number, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
									{{ Form::hidden('course_number', $planning->course_number)}}
								@endif
							</div>

							{{ Form::label('group_number', 'Gruppe:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								{{ Form::input('number', 'group_number', $planning->group_number, array('min' => 1,'size' => 10,'max' => 25, 'required'=>true, 'class' => 'form-control input-sm')) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('course_title', 'Titel:', ['class' => 'col-md-2'])}}
							<div class="col-md-10">
								@if (($course->coursetype_id == 1 || $course->coursetype_id == 4 || $course->coursetype_id == 8 || $course->coursetype_id == 9))
									{{ Form::input('text', 'course_title', $planning->course_title, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
									{{ Form::hidden('course_title', $planning->course_title) }}
								@else
									@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_planning'))
										{{ Form::input('text', 'course_title', $planning->course_title, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm')) }}
									@else
										{{ Form::input('text', 'course_title', $planning->course_title, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
										{{ Form::hidden('course_title', $planning->course_title) }}
									@endif
								@endif
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('course_title_eng', 'EngTitel:', ['class' => 'col-md-2'])}}
							<div class="col-md-10">
								@if (($course->coursetype_id == 1 || $course->coursetype_id == 4 || $course->coursetype_id == 8 || $course->coursetype_id == 9))
									{{ Form::input('text', 'course_title_eng', $planning->course_title_eng, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
									{{ Form::hidden('course_title_eng', $planning->course_title_eng) }}
								@else
									@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_planning'))
										{{ Form::input('text', 'course_title_eng', $planning->course_title_eng, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm')) }}
									@else
										{{ Form::input('text', 'course_title_eng', $planning->course_title_eng, array('min' => 3, 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => true)) }}
										{{ Form::hidden('course_title_eng', $planning->course_title_eng) }}
									@endif
								@endif
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('coursetype', 'LV-Typ:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								{{ Form::input('text', 'coursetype', $course->coursetype->name, array('class' => 'form-control input-sm', 'disabled' => true)) }}
							</div>

							{{ Form::label('sws', 'SWS:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								{{ Form::input('text', 'sws', $planning->semester_periods_per_week, array('class' => 'form-control input-sm', 'disabled' => true)) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('board_status', 'VS:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								@if ($currentUser->hasRole('Admin') || $currentUser->can('change_board_status'))
									{{ Form::select('board_status', Config::get('constants.pl_board_status'),$planning->board_status, array('class' => 'form-control input-sm')) }}
								@else
									{{ Form::select('board_status', Config::get('constants.pl_board_status'),$planning->board_status, array('class' => 'form-control input-sm', 'disabled' => true)) }}
									{{ Form::hidden('board_status', $planning->board_status) }}
								@endif
							</div>

							{{ Form::label('researchgroup_status', 'AB:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								@if ($currentUser->hasRole('Admin') || $currentUser->can('change_rg_status'))
									{{ Form::select('researchgroup_status', Config::get('constants.pl_rgstatus'), $planning->researchgroup_status, array('class' => 'form-control input-sm')) }}
								@else
									{{ Form::select('researchgroup_status', Config::get('constants.pl_rgstatus'), $planning->researchgroup_status, array('class' => 'form-control input-sm', 'disabled' => true)) }}
									{{ Form::hidden('researchgroup_status', $planning->researchgroup_status) }}
								@endif
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('language', 'Sprache:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								{{ Form::select('language', Config::get('constants.language'), $planning->language, array('class' => 'form-control input-sm'))}}
							</div>

							{{ Form::label('department', 'Zuständigkeit:', ['class' => 'col-md-2'])}}
							<div class="col-md-4">
								{{ Form::input('text', 'department', $course->module->department->name, array('class' => 'form-control input-sm', 'disabled' => true)) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('comment', 'Bemerkung:', ['class' => 'col-md-2'])}}
							<div class="col-md-10">
								{{ Form::textarea('comment', $planning->comment, array('rows' => 4, 'class' => 'form-control input-sm', 'style' => 'resize:none;')) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('room_preference', 'Raum- und Zeitwunsch*:', ['class' => 'col-md-2'])}}
							<div class="col-md-10">
								{{ Form::textarea('room_preference', $planning->room_preference, array('rows' => 4, 'class' => 'form-control input-sm', 'required'=>true,'style' => 'resize:none;')) }}
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
			  					*erforderlich
			  					@if ($currentUser->can('edit_planning') || $currentUser->hasRole('Admin'))
									{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
								@endif
							</div>
						</div>
					{{ Form::close() }}
				</div>
			</div>

			@include('plannings.partials.relatedPlannings')
		</div>
	</div>
@stop
@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('employees')}}">Mitarbeitermanagement</a></li>
	  <li class="active">{{ $employee->name }}</li>
	</ol>
@stop

@section('main')
	<h4>{{ $employee->title}} {{ $employee->firstname }} {{ $employee->name }} (<a href="{{ route('researchgroups.show', $employee->researchgroup_id) }}">{{ $employee->researchgroup->name }}</a>)</h4>

	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		<li class="active"><a href="#home" data-toggle="tab">Informationen</a></li>
		<li><a href="#courses" data-toggle="tab">Veranstaltungen</a></li>
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade active in" id="home">
			<div class="row">
				<div class="col-sm-7">
					<div class="panel panel-primary">
					    <div class="panel-body">
							{{ Form::model($employee, ['method' => 'PATCH', 'route' => ['employees.update', $employee->id], 'class' => "form-horizontal"]) }}
							<fieldset>
			        			<div class="form-group">
				    				{{ Form::label('title', 'Titel:', array('class' => "col-lg-4 control-label", 'id' => "title")) }}
				    				<div class="col-lg-8">
				    					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
				    						{{ Form::input('text', 'title', $employee->title, array('id' => "title", 'min' => 3, 'placeholder' => 'z.B. Prof.', 'class' => "form-control input-sm")) }}
				    					@else
				    						{{ $employee->title }}
				    					@endif
				    				</div>
			        			</div>

			        			<div class="form-group">
			        				{{ Form::label('firstname', 'Vorname*:', array('class' => "col-lg-4 control-label", 'id' => "firstname")) }}
			        				<div class="col-lg-8">
			        					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
				    						{{ Form::input('text', 'firstname', $employee->firstname, array('id' => "firstname", 'min' => 2, 'placeholder' => 'Vorname', 'required' => true, 'class' => "form-control input-sm")) }}
				    					@else
				    						{{ $employee->firstname }}
				    					@endif
			        				</div>
				        		</div>

				        		<div class="form-group">
			        				{{ Form::label('name', 'Nachname*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
			        				<div class="col-lg-8">
			        					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
			        						{{ Form::input('text', 'name', $employee->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Nachname', 'required' => true, 'class' => "form-control input-sm")) }}
			        					@else
				    						{{ $employee->name }}
				    					@endif
			        				</div>
				        		</div>

				        		<div class="form-group">
			        				{{ Form::label('researchgroup_id', 'Arbeitsbereich*:', array('class' => "col-lg-4 control-label", 'id' => "researchgroup_id")) }}
			        				<div class="col-lg-8">
			        					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
			        						{{ Form::select('researchgroup_id', $listofresearchgroups, $employee->researchgroup_id, array('id' => "researchgroup_id", 'class' => "form-control input-sm")) }}
			        					@else
			        						{{ $employee->researchgroup->name }}
			        					@endif
			        				</div>
			        			</div>

			        			<div class="form-group">
			        				{{ Form::label('teaching_load', 'Lehrdeputat (SWS):*:', array('class' => "col-lg-4 control-label", 'id' => "teaching_load")) }}
			        				<div class="col-lg-8">
			        					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
			        						{{ Form::input('number', 'teaching_load', $employee->teaching_load, array('min' => 0, 'id' => "teaching_load", 'class' => "form-control input-sm", 'required' => true)) }}
			        					@else
			        						{{ $employee->teaching_load }}
			        					@endif
			        				</div>
			        			</div>
		        			
			        			<div class="form-group">
			        				{{ Form::label('employed_since', 'Angestellt seit:*:', array('class' => "col-lg-4 control-label", 'id' => "employed_since")) }}
			        				<div class="col-lg-8">
			        					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
			        						{{ Form::input('date', 'employed_since', date('Y-m-d', strtotime($employee->employed_since)), array('id' => "employed_since", 'class' => "form-control input-sm", 'required' => true)) }}
			        					@else
			        						{{ $employee->employed_since }}
			        					@endif
			        				</div>
			        			</div>

			        			<div class="form-group">
			        				{{ Form::label('employed_till', 'Angestellt bis:*:', array('class' => "col-lg-4 control-label", 'id' => "employed_till")) }}
			        				<div class="col-lg-8">
			        					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
			        						{{ Form::input('date', 'employed_till', date('Y-m-d', strtotime($employee->employed_till)), array('id' => "employed_till", 'class' => "form-control input-sm", 'required' => true)) }}
			        					@else
			        						{{ $employee->employed_till }}
			        					@endif
			        				</div>
			        			</div>

			        			<div class="form-group">
			        				{{ Form::label('inactive', 'Ehemalig:', array('class' => "col-lg-4 control-label", 'id' => "inactive")) }}
			        				<div class="col-lg-8">
			        					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
			        						{{ Form::checkbox('inactive', 1, $employee->inactive, array('id' => "inactive", 'class' => "form-control input-sm")) }}
			        					@else
			        						{{ Form::checkbox('inactive', 1, $employee->inactive, array('id' => "inactive", 'class' => "form-control input-sm", 'disabled' => true)) }}
			        					@endif
			        				</div>
			        			</div>
		        			
			        			<div class="form-group">
			      					<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
			      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_employee'))
				      					*erforderlich
				      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
				      				@endif
			      					</div>
			      				</div>
			        		</fieldset>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="tab-pane fade" id="courses">
			<div class="row">
		        <div class="col-sm-12">
					<div class="panel panel-primary">
				        <div class="panel-body">
				        	<div class="table-responsive">
								<table class="table table-striped" cellspacing="0">
								    <thead>
										<tr>
										    <th>Semester</th>
										    <th>Veranstaltung</th>
										    <th>Verantwortliche</th>
										    <th>Raum - Uhrzeit</th>
									 	</tr>
								   	</thead>
								    <tbody>
										@foreach ($plannings as $p)	
											<tr>
												<td>{{ $p->turn->name }} {{ $p->turn->year }}</td>
												<td>{{ $p->course_number }} {{ $p->course_title }}</td>
												<td>
													@foreach ($p->employees as $e)
														{{ $e->firstname }} {{ $e->name }} ({{ $e->pivot->semester_periods_per_week }} SWS)<br>
													@endforeach
												</td>
												<td>
													@foreach ($p->rooms as $r)
														{{ $r->name }} ({{ $r->location }}) - {{ Config::get('constants.weekdays_short')[$r->pivot->weekday]}}, {{ substr($r->pivot->start_time,0,5) }} - {{ substr($r->pivot->end_time,0,5) }} Uhr<br>
													@endforeach
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>	
		    </div>
		</div>
	</div>
@stop
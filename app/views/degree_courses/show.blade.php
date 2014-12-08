
@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('degree_courses')}}">Studiengangsmanagement</a></li>
	  <li class="active">{{ $degreecourse->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $listofdegrees[$degreecourse->degree_id] }} {{ $degreecourse->name }}</h3>

	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		<li class="active"><a href="#home" data-toggle="tab">Informationen</a></li>
		<li><a href="#modules" data-toggle="tab">Zugeordnete Module</a></li>
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade active in" id="home">
			<div class="row">
				<div class="col-sm-7">
					<div class="panel panel-primary">
			            <div class="panel-body">
			            	{{ Form::model($degreecourse, ['method' => 'PATCH', 'route' => ['degree_courses.update', $degreecourse->id], 'class' => "form-horizontal"]) }}
			            	<fieldset>
								<legend>Studiengang aktualisieren</legend>
								<div class="form-group">
			        				{{ Form::label('short', 'Kürzel*:', array('class' => "col-lg-3 control-label", 'id' => "short")) }}
			        				<div class="col-lg-9">
			        					{{ Form::input('text', 'short', $degreecourse->short, array('id' => "short", 'min' => 2, 'placeholder' => 'Kürzel','required'=>true, 'class' => 'form-control input-sm')) }}
			        				</div>
				        		</div>

				        		<div class="form-group">
			        				{{ Form::label('name', 'Name*:', array('class' => "col-lg-3 control-label", 'id' => "name")) }}
			        				<div class="col-lg-9">
			        					{{ Form::input('text', 'name', $degreecourse->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Name','required'=>true, 'class' => 'form-control input-sm')) }}
			        				</div>
				        		</div>

				        		<div class="form-group">
			        				{{ Form::label('degree_id', 'Abschluss*:', array('class' => "col-lg-3 control-label", 'id' => "degree_id")) }}
			        				<div class="col-lg-9">
			        					{{ Form::select('degree_id', $listofdegrees, $degreecourse->degree_id, array('id' => "degree_id",  'class' => 'form-control input-sm')) }}
			        				</div>
				        		</div>

				        		<div class="form-group">
			        				{{ Form::label('department_id', 'Fachbereich*:', array('class' => "col-lg-3 control-label", 'id' => "department_id")) }}
			        				<div class="col-lg-9">
			        					{{ Form::select('department_id', $listofdepartments, $degreecourse->department_id, array('id' => "department_id",  'class' => 'form-control input-sm')) }}
			        				</div>
				        		</div>

				        		<div class="form-group">
			      					<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
			      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_degreecourse'))
				      					*erforderlich
				      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
				      					{{ Form::hidden('tabindex', 'home') }}
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

		<div class="tab-pane fade" id="modules">
			<div class="row">
				<div class="col-sm-12" style="margin-bottom: 5px;">
					<div class="table-responsive">
				        <table class="table table-striped table-condensed table-hover" cellspacing="0">
				        	<thead>
				                <tr>
				                  <th>FS</th>
				                  <th>Bereich</th>
				                  <th>Kürzel</th>
				                  <th>Titel</th>
				                  <th>LP</th>
				                  <th>Turnus</th>
				                </tr>
				          	</thead>
				          	<tbody>
								@foreach( $degreecourse->modules as $module )
									@if($listofsections[$module->pivot->section] != "Pflicht")
										@if($listofsections[$module->pivot->section] != "Wahlpflicht")
											<tr class="warning">
										@else
											<tr class="success">
										@endif
									@else
										<tr class="info">
									@endif
										<td>{{ $module->pivot->semester }}</td>
										<td>{{ $listofsections[$module->pivot->section] }}</td>
										<td>{{ $module->short }}</td>
										<td><a href="{{ route('modules.show', $module->id) }}">{{ $module->name }}</td>
										<td>{{ $module->semester_periods_per_week }}</td>
										<td>{{ $listofrotations[$module->rotation_id] }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
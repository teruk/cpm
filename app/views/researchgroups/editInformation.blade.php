@extends('layouts.main')

@include('researchgroups.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('researchgroups.partials.sidenav')

		<div class="col-md-9">
			@include('researchgroups.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Arbeitsbereiches.</p>

			<div class="panel panel-default">
			    <div class="panel-body">
					{{ Form::model($researchgroup, ['method' => 'PATCH', 'route' => ['updateResearchgroup_path', $researchgroup->id], 'class' => "form-horizontal"]) }}

						<div class="form-group">
							{{ Form::label('short', 'Kürzel*:', array('class' => "col-md-2 control-label", 'id' => "short")) }}
							<div class="col-md-4">
								{{ Form::text('short',$researchgroup->short,array('id' => "short", 'min' => 2, 'placeholder' => 'Kürzel','required'=>true, 'class' => 'form-control input-sm')) }}
							</div>

							{{ Form::label('department_id', 'Fachbereich:', array('class' => "col-md-2 control-label", 'id' => "department_id")) }}
							<div class="col-md-4">
								{{ Form::select('department_id', $listofdepartments, $researchgroup->department_id, ['class' => 'form-control input-sm']) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('name', 'Name*:', array('class' => "col-md-2 control-label", 'id' => "department_id")) }}
							<div class="col-md-10">
								{{ Form::select('department_id', $listofdepartments, $researchgroup->department_id,array('id' => "name", 'min' => 3, 'placeholder' => 'Name des Arbeitsbereiches','required'=>true, 'class' => 'form-control input-sm')) }}
							</div>
						</div>

						<div class="form-group">
	      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
	      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_researchgroup'))
		      					*erforderlich
		      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
		      				@endif
	      					</div>
	      				</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
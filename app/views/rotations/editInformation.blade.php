@extends('layouts.main')

@include('rotations.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('rotations.partials.sidenav')

		<div class="col-md-9">
			@include('rotations.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Turnuses.</p>

			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($rotation, ['method' => 'PATCH', 'route' => ['updateRotation_path', $rotation->id], 'class' => "form-horizontal"]) }}

						<div class="form-group">
							{{ Form::label('name', 'Name*:', ['class' => 'col-md-2 control-label']) }}
							<div class="col-md-10">
								{{ Form::text('name', $rotation->name, ['class' => 'form-control input-sm', 'placeholder' => 'Turnusname', 'required' => true, 'id' => 'name', 'min' => 3]) }}
							</div>
						</div>

						<div class="form-group">
	      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
	      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_rotation'))
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
@extends('layouts.main')

@include('turns.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('turns.partials.sidenav')

		<div class="col-md-9">
			@include('turns.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Turns.</p>

			<div class="panel panel-default">
			    <div class="panel-body">
					{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['updateTurn_path', $turn->id]]) }}

						<div class="form-group">
							{{ Form::label('name', 'Semester*:', ['class' => 'col-md-3 control-label']) }}
							<div class="col-md-9">
								{{ Form::input('text', 'name', $turn->present(), ['class' => 'input-sm form-control', 'disabled' => true]) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('semester_start', 'Semesterbeginn*:', ['class' => 'col-md-3 control-label']) }}
							<div class="col-md-3">
								{{ Form::input('date', 'semester_start', $turn->semester_start, ['class' => 'form-control input-sm', 'required' => true]) }}
							</div>

							{{ Form::label('semester_end', 'Semesterende*:', ['class' => 'col-md-3 control-label']) }}
							<div class="col-md-3">
								{{ Form::input('date', 'semester_end', $turn->semester_end, ['class' => 'form-control input-sm', 'required' => true]) }}
							</div>
						</div>

						<div class="form-group">
	      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
		      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_turn'))
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
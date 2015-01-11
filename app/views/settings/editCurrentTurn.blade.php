@extends('layouts.main')

@include('settings.partials.breadcrumb', ['breadcrumbTitle' => 'Aktuelles Semester bearbeiten'])

@section('main')
	
	<div class="row">
		@include('settings.partials.sidenav')

		<div class="col-md-9">
			@include('settings.partials.heading', ['title' => 'Aktuelles Semester bearbeiten:'])

			<p>Einstellung des aktuellen Semesters.</p>

			<div class="panel panel-default">
	            <div class="panel-body">
					{{ Form::model(new Turn, ['method' => 'PATCH', 'route' => ['updateCurrentTurn_path'], 'class' => "form-horizontal"]) }}
						<div class="form-group">
	        				{{ Form::label('current_turn', 'Aktuelles Semester:', array('class' => "col-md-3 control-label", 'id' => "current_turn")) }}
	        				<div class="col-md-9">
	        					{{ Form::select('current_turn', $turns, $currentTurn->id, array('id' => "current_turn", 'class' => 'form-control input-sm')) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
	      					<div class="col-md-8 col-md-offset-4" style="text-align: right">
		      					@if ($currentUser->hasRole('Admin') || $currentUser->can('change_setting_current_turn'))
			      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Aktuelles Semester aktualisieren')) }}
			      				@endif
	      					</div>
	      				</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
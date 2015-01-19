@extends('layouts.main')

@include('degreecourses.partials.breadcrumb', ['breadcrumbTitle' => 'FSB-Version '. $specialistregulation->turn->present()])

@section('main')
	
	<div class="row">
		@include('degreecourses.partials.sidenav')

		<div class="col-md-9">
			@include('degreecourses.partials.heading', ['title' => 'FSB-Version '.$specialistregulation->turn->present().' verwalten:'])

			<p>Die verschiedenen FSB-Versionen dienen der besseren Raum- und Zeitplanung von Lehrveranstaltungen. Der Status <i>Aktiv</i> gibt an, ob diese FSB bei der Zeitplanung der Veranstaltungen berücksichtigt werden soll.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	{{ Form::model($specialistregulation, ['method' => 'PATCH', 'route' => ['updateSpecialistregulation_path', $degreecourse->id, $specialistregulation->id], 'class' => "form-horizontal"]) }}

		            	<div class="form-group">
		            		{{ Form::label('turnId', 'Startsemester:', ['class' => 'control-label col-md-2']) }}
		            		<div class="col-md-4">
		            			{{Form::select('turnId', $availableTurns, $specialistregulation->turn_id, ['class' => 'input-sm form-control', 'required' => true, 'id' => 'turnId'])}}
		            		</div>

		            		{{ Form::label('active', 'Aktiv:', ['class' => 'control-label col-md-2']) }}
		            		<div class="col-md-4">
		            			{{ Form::checkbox('active', 1, $specialistregulation->id, ['class' => 'input-sm form-control', 'id' => 'active']) }}
		            		</div>
		            	</div>

		            	<div class="form-group">
		            		{{ Form::label('description', 'Beschreibung:', ['class' => 'control-label col-md-2']) }}
		            		<div class="col-md-10">
		            			{{ Form::textarea('description', nl2br($specialistregulation->description), ['class' => 'input-sm form-control', 'id' => 'description', 'style' => 'resize:none;', 'rows' => 10]) }}
		            		</div>
		            	</div>

		            	<div class="form-group">
		  					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
		  					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_specialistregulation'))
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
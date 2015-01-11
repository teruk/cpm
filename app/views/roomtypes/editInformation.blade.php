@extends('layouts.main')

@include('roomtypes.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('roomtypes.partials.sidenav')

		<div class="col-md-9">
			@include('roomtypes.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Studiengangs.</p>

			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($roomtype, ['method' => 'PATCH', 'route' => ['updateRoomtype_path', $roomtype->id], 'class' => "form-horizontal"]) }}

						<div class="form-group">
							{{ Form::label('name', 'Name*:', ['class' => 'col-md-2 control-label']) }}
							<div class="col-md-10">
								{{ Form::text('name', $roomtype->name, ['class' => 'input-sm form-control', 'required' => true, 'id' => 'name', 'placeholder' => 'Name des Raumtyps']) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('desciption', 'Beschreibung*:', ['class' => 'col-md-2 control-label']) }}
							<div class="col-md-10">
								{{ Form::textarea('description', $roomtype->description, ['class' => 'input-sm form-control', 'rows' => 3, 'required' => true, 'id' => 'description', 'placeholder' => 'Beschreibung des Raumtyps', 'style' => 'resize:none']) }}
							</div>
						</div>

						<div class="form-group">
	      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
	      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_roomtype'))
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
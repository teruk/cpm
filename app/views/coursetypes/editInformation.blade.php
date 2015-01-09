@extends('layouts.main')

@include('coursetypes.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('coursetypes.partials.sidenav')

		<div class="col-md-9">
			@include('coursetypes.partials.heading', ['title' => 'Information bearbeiten:'])

			<p>Bearbeitung der Informationen dieser Lehrveranstaltung.</p>
			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($coursetype, ['method' => 'PATCH', 'route' => ['updateCoursetype_path', $coursetype->id], 'class' => "form-horizontal"]) }}

						<div class="form-group">
							{{ Form::label('name', 'Name*:', ['class' => 'col-md-3 control-label']) }}
							<div class="col-md-4">
								{{ Form::input('text', 'name', $coursetype->name, array('id' => "name", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}
							</div>

							{{ Form::label('short', 'Kurz*:', ['class' => 'col-md-2 control-label']) }}
							<div class="col-md-3">
								{{ Form::input('text', 'short', $coursetype->short, array('id' => "short", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('description', 'Beschreibung:', ['class' => 'col-md-3 control-label']) }}
							<div class="col-md-9">
								{{ Form::textarea('description', $coursetype->description, array('id' => "description", 'class' => "form-control input-sm", 'rows'=>3, 'style' => 'resize:none;')) }}
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
								{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
							</div>
						</div>

					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
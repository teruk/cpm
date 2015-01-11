@extends('layouts.main')

@include('roles.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('roles.partials.sidenav')

		<div class="col-md-9">
			@include('roles.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Studiengangs.</p>

			<div class="panel panel-default">
	            <div class="panel-body">
					{{ Form::model($role, ['method' => 'PATCH', 'route' => ['updateRole_path', $role->id], 'class' => "form-horizontal"]) }}

						<div class="form-group">
	        				{{ Form::label('name', 'Name*:', array('class' => "col-md-2 control-label", 'id' => "name")) }}
	        				<div class="col-md-10">
	        					@if ($role->name != 'Admin')
	        						{{ Form::input('text', 'name', $role->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm")) }}
	        					@else
	        						{{ Form::input('text', 'name', $role->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm", 'disabled' => 'true')) }}
	        						{{ Form::hidden('name', $role->name) }}
	        					@endif
	        				</div>
		        		</div>
		        		<div class="form-group">
		    				{{ Form::label('description', 'Beschreibung:', array('class' => "col-md-2 control-label", 'id' => "description")) }}
		    				<div class="col-md-10">
		    					{{ Form::textarea('description', $role->description, array('id' => "description", 'class' => "form-control input-sm", 'placeholder' => 'Rollenbeschreibung ...', 'rows'=>5, 'style' => 'resize:none;')) }}
		    				</div>
		    			</div>
		        		<div class="form-group">
	      					<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
	      					@if ($role->name != "Admin")
		      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_role'))
			      					*erforderlich
			      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
			      				@endif
			      			@endif
	      					</div>
	      				</div>

					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
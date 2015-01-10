@extends('layouts.main')

@include('permissions.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		<div class="alert alert-dismissable alert-danger">
		  	<h4>Hinweis!</h4>
		  	<p>Vorsicht bei Änderungen. Sollten nur von geschultem Personal vorgenommen werden.</p>
		</div>

		@include('permissions.partials.sidenav')

		<div class="col-md-9">
			@include('permissions.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>[Infotext fehlt!]</p>

			<div class="panel panel-default">
	            <div class="panel-body">
					{{ Form::model($permission, ['method' => 'PATCH', 'route' => ['updatePermission_path', $permission->id], 'class' => "form-horizontal"]) }}
					<div class="form-group">
        				{{ Form::label('display_name', 'Anzeigename*:', array('class' => "col-md-2 control-label", 'id' => "display_name")) }}
        				<div class="col-md-10">
        					{{ Form::input('text', 'display_name', $permission->display_name, array('id' => "display_name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm")) }}
        				</div>
	        		</div>
	        		<div class="form-group">
        				{{ Form::label('name', 'Name*:', array('class' => "col-md-2 control-label", 'id' => "name")) }}
        				<div class="col-md-10">
        					{{ Form::input('text', 'name', $permission->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm")) }}
        				</div>
	        		</div>
	        		<div class="form-group">
	    				{{ Form::label('description', 'Beschreibung:', array('class' => "col-md-2 control-label", 'id' => "description")) }}
	    				<div class="col-md-10">
	    					{{ Form::textarea('description', $permission->description, array('id' => "description", 'class' => "form-control input-sm", 'placeholder' => 'Rollenbeschreibung ...', 'rows'=>5, 'style' => 'resize:none;')) }}
	    				</div>
	    			</div>
	        		<div class="form-group">
      					<div class="col-md-10 col-lg-offset-2" style="text-align: right">
      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_permission'))
	      					*erforderlich
	      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
	      					{{ Form::hidden('tabindex', 'home') }}
	      				@endif
      					</div>
      				</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
@extends('layouts.main')

@include('users.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('users.partials.sidenav')

		<div class="col-md-9">
			@include('users.partials.heading', ['title' => 'Informationen bearbeiten:'])

			<p>Bearbeitung der Informationen dieses Benutzers.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	
	            	{{ Form::model($user, ['method' => 'PATCH', 'route' => ['updateUser_path', $user->id], 'class' => "form-horizontal"]) }}

						<div class="form-group">
	        				{{ Form::label('name', 'Name*:', array('class' => "col-lg-3 control-label", 'id' => "name")) }}
	        				<div class="col-lg-9">
	        					{{ Form::input('text', 'name', $user->name, array('id' => "name", 'min' => 2, 'placeholder' => 'Name','required'=>true, 'class' => 'form-control input-sm')) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
		    				{{ Form::label('email', 'Email*:', array('class' => "col-lg-3 control-label", 'id' => "email")) }}
		    				<div class="col-lg-9">
		    					{{ Form::input('email','email', $user->email, array('id' => "email", 'placeholder' => 'Email-Adresse','required'=>true, 'class' => 'form-control input-sm')) }}
		    				</div>
		    			</div>

		    			<div class="form-group">
	        				{{ Form::label('password', 'Passwort:', array('class' => "col-lg-3 control-label", 'id' => "password")) }}
	        				<div class="col-lg-9">
	        					{{ Form::input('text', 'password', $user->password, array('class' => 'form-control input-sm', 'disabled' => "")) }}
	        				</div>
		        		</div>

		        		<div class="form-group">
	      					<div class="col-md-9 col-lg-offset-3" style="text-align: right">
	      					@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_user'))
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
@extends('layouts.main')

@include('users.partials.breadcrumb', ['breadcrumbTitle' => 'Passwort zurücksetzen'])

@section('main')
	
	<div class="row">
		@include('users.partials.sidenav')

		<div class="col-md-9">
			@include('users.partials.heading', ['title' => 'Passwort zurücksetzen:'])

			<p>Bearbeitung der Informationen dieses Benutzers.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	
	            	{{ Form::model($user, ['method' => 'PATCH', 'route' => ['setUserNewPassword_path', $user->id], 'class' => "form-horizontal"])}}
							<div class="form-group">
			    				{{ Form::label('password', 'Neues Passwort*:', array('class' => "col-lg-3 control-label", 'id' => "password")) }}
			    				<div class="col-lg-9">
			    					{{ Form::input('password', 'password', '', array('id' => "password", 'min' => 8, 'placeholder' => 'Neues Passwort', 'required' => true, 'class' => "form-control input-sm")) }}
			    				</div>
			        		</div>
			        		
			        		<div class="form-group">
			    				{{ Form::label('password_repeat', 'Neues Passwort wiederholen*:', array('class' => "col-lg-3 control-label", 'id' => "password_repeat")) }}
			    				<div class="col-lg-9">
			    					{{ Form::input('password', 'password_repeat', '', array('id' => "password_repeat", 'min' => 8, 'placeholder' => 'Neues Passwort wiederholen', 'required' => true, 'class' => "form-control input-sm")) }}
			    				</div>
			        		</div>
			    			
			    			<div class="form-group">
			  					<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
			  					*erforderlich
			  					@if(Entrust::hasRole('Admin'))
									{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Passwort aktualisieren')) }}
								@endif
			  					</div>
			  				</div>
							
		        	{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
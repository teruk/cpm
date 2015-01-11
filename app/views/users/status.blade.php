@extends('layouts.main')

@include('users.partials.breadcrumb', ['breadcrumbTitle' => 'Status ändern'])

@section('main')
	
	<div class="row">
		@include('users.partials.sidenav')

		<div class="col-md-9">
			@include('users.partials.heading', ['title' => 'Status ändern:'])

			<p>Bearbeitung der Informationen dieses Benutzers.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
	            	
					<div class="form-group">
	    				Die Deaktivierung eines Benutzers verhindert, dass dieser sich einloggen kann. Der Account wird nicht gelöscht.
	        		</div>

	        		<div class="form-group">
	    				{{ Form::label('none', 'Aktueller Status:', array('class' => "col-lg-3 control-label", 'id' => "none")) }}
	    				<div class="col-lg-9">
	    					@if ($user->deactivated == 1)
	    						Deaktiviert
	    					@else
	    						Aktiviert
	    					@endif
	    				</div>
	        		</div>
		        		
		        		
	    			<div class="form-group">
	  					<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
	  					@if ($user->deactivated == 1)
	  						@if($currentUser->hasRole('Admin') || $currentUser->can('activate_user'))
	  							{{ Form::model($user, ['method' => 'PATCH', 'route' => ['activateUser_path', $user->id], 'class' => "form-horizontal"])}}
	  								{{ Form::button('Aktivieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Benutzer aktivieren')) }}
	  								{{ Form::hidden('tabindex', "deactivation") }}
	  							{{ Form::close() }}
	  						@endif
	  					@else
	  						@if(($currentUser->hasRole('Admin') || $currentUser->can('deactivate_user')) && !$user->hasRole('Admin'))
		  						{{ Form::model($user, ['method' => 'PATCH', 'route' => ['deactivateUser_path', $user->id], 'class' => "form-horizontal"])}}
		  							{{ Form::button('Deaktivieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Benutzer deaktivieren')) }}
		  							{{ Form::hidden('tabindex', "deactivation") }}
		  						{{ Form::close() }}
		  					@endif
	  					@endif
	  					</div>
	  				</div>
				</div>
			</div>
		</div>
	</div>
@stop
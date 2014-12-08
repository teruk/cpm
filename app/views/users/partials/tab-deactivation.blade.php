<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-primary">
	        <div class="panel-body">
				
				<fieldset>
					<legend>Passwort aktualisieren</legend>
					<div class="form-group">
	    				Die Deaktivierung eines Benutzers verhindert, dass dieser sich einloggen kann. Der Account wird nicht gelöscht.
	        		</div>

	        		<div class="form-group">
	    				{{ Form::label('none', 'Aktueller Status:', array('class' => "col-lg-4 control-label", 'id' => "none")) }}
	    				<div class="col-lg-8">
	    					@if ($user->deactivated == 1)
	    						Deaktiviert
	    					@else
	    						Aktiviert
	    					@endif
	    				</div>
	        		</div>
	        		
	        		
	    			<div class="form-group">
	  					<div class="col-lg-8 col-lg-offset-4" style="text-align: right">
	  					@if ($user->deactivated == 1)
	  						@if(Entrust::hasRole('Admin') || Entrust::can('activate_user'))
	  							{{ Form::model($user, ['method' => 'PATCH', 'route' => ['users.activate', $user->id], 'class' => "form-horizontal"])}}
	  								{{ Form::button('Aktivieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-success', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Benutzer aktivieren')) }}
	  								{{ Form::hidden('tabindex', "deactivation") }}
	  							{{ Form::close() }}
	  						@endif
	  					@else
	  						@if((Entrust::hasRole('Admin') || Entrust::can('deactivate_user')) && !$user->hasRole('Admin'))
		  						{{ Form::model($user, ['method' => 'PATCH', 'route' => ['users.deactivate', $user->id], 'class' => "form-horizontal"])}}
		  							{{ Form::button('Deaktivieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-danger', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Benutzer deaktivieren')) }}
		  							{{ Form::hidden('tabindex', "deactivation") }}
		  						{{ Form::close() }}
		  					@endif
	  					@endif
	  					</div>
	  				</div>
				</fieldset>
	        </div>
	    </div>
	</div>
</div
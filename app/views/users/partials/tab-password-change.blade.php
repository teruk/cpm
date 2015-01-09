<div class="row">
	<div class="col-sm-8">
		<div class="panel panel-primary">
	        <div class="panel-body">
				{{ Form::model($user, ['method' => 'PATCH', 'route' => ['setUserNewPassword_path', $user->id], 'class' => "form-horizontal"])}}
				<fieldset>
					<legend>Passwort aktualisieren</legend>
					<div class="form-group">
	    				{{ Form::label('password', 'Neues Passwort*:', array('class' => "col-lg-4 control-label", 'id' => "password")) }}
	    				<div class="col-lg-8">
	    					{{ Form::input('password', 'password', '', array('id' => "password", 'min' => 8, 'placeholder' => 'Neues Passwort', 'required' => true, 'class' => "form-control input-sm")) }}
	    				</div>
	        		</div>
	        		
	        		<div class="form-group">
	    				{{ Form::label('password_repeat', 'Neues Passwort wiederholen*:', array('class' => "col-lg-4 control-label", 'id' => "password_repeat")) }}
	    				<div class="col-lg-8">
	    					{{ Form::input('password', 'password_repeat', '', array('id' => "password_repeat", 'min' => 8, 'placeholder' => 'Neues Passwort wiederholen', 'required' => true, 'class' => "form-control input-sm")) }}
	    				</div>
	        		</div>
	    			
	    			<div class="form-group">
	  					<div class="col-lg-8 col-lg-offset-4" style="text-align: right">
	  					*erforderlich
	  					@if(Entrust::hasRole('Admin'))
							{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Passwort aktualisieren')) }}
						@endif
	  					</div>
	  				</div>
				</fieldset>
					
	        	{{ Form::close() }}
	        </div>
	    </div>
	</div>
</div>
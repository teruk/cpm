<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-body">
	        {{ Form::model(new User, ['route' => ['saveUser_path'], 'class' => "form-horizontal"])}}
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <fieldset>
	        	<legend>Neuen Benutzer erstellen</legend>
	        	<div class="form-group">
        			{{ Form::label('name', 'Name*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
        			<div class="col-lg-8">
        				{{ Form::input('text', 'name', '', array('id' => "name", 'min' => 3, 'placeholder' => 'Name', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>
	        	
				<div class="form-group">
        			{{ Form::label('email', 'Email*:', array('class' => "col-lg-4 control-label", 'id' => "email")) }}
        			<div class="col-lg-8">
        				{{ Form::input('email', 'email', '', array('id' => "email", 'min' => 3, 'placeholder' => 'Emailadresse', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>

	        	<div class="form-group">
        			{{ Form::label('password', 'Passwort*:', array('class' => "col-lg-4 control-label", 'id' => "password")) }}
        			<div class="col-lg-8">
        				{{ Form::input('password', 'password', '', array('id' => "password", 'min' => 6, 'placeholder' => 'Passwort min. 6 Zeichen', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>

	        	<div class="form-group">
        			{{ Form::label('password_repeat', 'Passwort wiederholen*:', array('class' => "col-lg-4 control-label", 'id' => "password_repeat")) }}
        			<div class="col-lg-8">
        				{{ Form::input('password', 'password_repeat', '', array('id' => "password_repeat", 'min' => 6, 'placeholder' => 'Passwort wiederholen', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>
	        	
	        	<div class="form-group">
      				<div class="col-lg-8 col-lg-offset-4" style="text-align: right">
      					*erforderlich
      					<button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
						{{ Form::submit('Erstellen', array('class' => 'btn btn btn-success')) }}
      				</div>
      			</div>
	        </fieldset>
	        {{ Form::close() }}
			
	      	</div>
    	</div>
  	</div>
</div>
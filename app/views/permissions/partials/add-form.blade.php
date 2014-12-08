<div class="modal fade" id="myModal" tabindex="-1" perm="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-body">
	        {{ Form::model(new Permission, ['route' => ['permissions.store'], 'class' => "form-horizontal"])}}
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <fieldset>
	        	<legend>Neue Berechtigung erstellen</legend>
	        	<div class="form-group">
        			{{ Form::label('name', 'Name*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
        			<div class="col-lg-8">
        				{{ Form::input('text', 'name', '', array('id' => "name", 'min' => 3, 'placeholder' => 'Rollenname', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>

	        	<div class="form-group">
        			{{ Form::label('display_name', 'Anzeigename*:', array('class' => "col-lg-4 control-label", 'id' => "display_name")) }}
        			<div class="col-lg-8">
        				{{ Form::input('text', 'display_name', '', array('id' => "display_name", 'min' => 3, 'placeholder' => 'Anzeigename', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>

	        	<div class="form-group">
    				{{ Form::label('description', 'Beschreibung:', array('class' => "col-lg-4 control-label", 'id' => "description")) }}
    				<div class="col-lg-8">
    					{{ Form::textarea('description', '', array('id' => "description", 'class' => "form-control input-sm", 'placeholder' => 'Berechtigungsbeschreibung ...', 'rows'=>5, 'style' => 'resize:none;')) }}
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
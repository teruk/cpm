<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      		<div class="modal-body">
        	{{ Form::model(new Employee, ['route' => ['saveEmployee_path'], 'class' => "form-horizontal"])}}
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        	<fieldset>
        		<legend>Neuen Mitarbeiter anlegen</legend>
        		<div class="form-group">
    				{{ Form::label('title', 'Titel:', array('class' => "col-lg-4 control-label", 'id' => "title")) }}
    				<div class="col-lg-8">
    					{{ Form::input('text', 'title', '', array('id' => "title", 'min' => 3, 'placeholder' => 'z.B. Prof.', 'class' => "form-control input-sm")) }}
    				</div>
        		</div>
        		
        		<div class="form-group">
    				{{ Form::label('firstname', 'Vorname*:', array('class' => "col-lg-4 control-label", 'id' => "firstname")) }}
    				<div class="col-lg-8">
    					{{ Form::input('text', 'firstname', '', array('id' => "firstname", 'min' => 2, 'placeholder' => 'Vorname', 'required' => true, 'class' => "form-control input-sm")) }}
    				</div>
        		</div>
        		
        		<div class="form-group">
    				{{ Form::label('name', 'Nachname*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
    				<div class="col-lg-8">
    					{{ Form::input('text', 'name', '', array('id' => "name", 'min' => 2, 'placeholder' => 'Nachname', 'required' => true, 'class' => "form-control input-sm")) }}
    				</div>
        		</div>
        		
        		<div class="form-group">
    				{{ Form::label('researchgroup_id', 'Arbeitsbereich*:', array('class' => "col-lg-4 control-label", 'id' => "researchgroup_id")) }}
    				<div class="col-lg-8">
    					{{ Form::select('researchgroup_id', $researchgroups, 1, array('id' => "researchgroup_id", 'class' => "form-control input-sm")) }}
    				</div>
    			</div>
    			
    			<div class="form-group">
    				{{ Form::label('teaching_load', 'Lehrdeputat (SWS):*:', array('class' => "col-lg-4 control-label", 'id' => "teaching_load")) }}
    				<div class="col-lg-8">
    					{{ Form::input('number', 'teaching_load', 5, array('min' => 0, 'id' => "teaching_load", 'class' => "form-control input-sm", 'required' => true)) }}
    				</div>
    			</div>
    			
    			<div class="form-group">
    				{{ Form::label('employed_since', 'Angestellt seit:*:', array('class' => "col-lg-4 control-label", 'id' => "employed_since")) }}
    				<div class="col-lg-8">
    					{{ Form::input('date', 'employed_since', '', array('id' => "employed_since", 'class' => "form-control input-sm", 'required' => true)) }}
    				</div>
    			</div>
    			
    			<div class="form-group">
    				{{ Form::label('employed_till', 'Angestellt bis:*:', array('class' => "col-lg-4 control-label", 'id' => "employed_till")) }}
    				<div class="col-lg-8">
    					{{ Form::input('date', 'employed_till', '', array('id' => "employed_till", 'class' => "form-control input-sm", 'required' => true)) }}
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
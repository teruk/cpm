<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        {{ Form::model(new Turn, ['route' => ['saveTurn_path'], 'class' => "form-horizontal"])}}
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <fieldset>
        	<legend>Neues Semester anlegen</legend>
        	<div class="form-group">
    			{{ Form::label('name', 'Semester*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
    			<div class="col-lg-8">
    				{{ Form::select('name', $availableturns, 1, array('id' => "name", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}
    			</div>
        	</div>

        	<div class="form-group">
    			{{ Form::label('semester_start', 'Semesterbeginn*:', array('class' => "col-lg-4 control-label", 'id' => "semester_start")) }}
    			<div class="col-lg-8">
    				{{ Form::input('date', 'semester_start', '', array('id' => "semester_start", 'class' => "form-control input-sm", 'required' => true)) }}
    			</div>
        	</div>

        	<div class="form-group">
    			{{ Form::label('semester_end', 'Semesterende*:', array('class' => "col-lg-4 control-label", 'id' => "semester_end")) }}
    			<div class="col-lg-8">
    				{{ Form::input('date', 'semester_end', '', array('id' => "semester_end", 'class' => "form-control input-sm", 'required' => true)) }}
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
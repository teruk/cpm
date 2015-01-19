<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        {{ Form::model(new Specialistregulation, ['route' => ['saveSpecialistregulation_path', $degreecourse->id], 'class' => "form-horizontal"])}}
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    	    <fieldset>
    	    <legend>Neue Fachspezifische Bestimmungen erstellen</legend>
    	    	<div class="form-group">
              {{ Form::label('turnId', 'Startsemester:', ['class' => 'control-label col-md-4']) }}
              <div class="col-md-8">
                {{Form::select('turnId', $availableTurns, null, ['class' => 'input-sm form-control', 'required' => true, 'id' => 'turnId'])}}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('active', 'Aktiv:', ['class' => 'control-label col-md-4']) }}
              <div class="col-md-8">
                {{ Form::checkbox('active', 1, null, ['class' => 'input-sm form-control', 'id' => 'active']) }}
              </div>
            </div>

            <div class="form-group">
              {{ Form::label('description', 'Beschreibung:', ['class' => 'control-label col-md-4']) }}
              <div class="col-md-8">
                {{ Form::textarea('description', '', ['class' => 'input-sm form-control', 'placeholder' => 'Beschreibung der Fachspezifischen Bestimmungen. Welche Änderungen gibt es im Vergleich zur vorherigen Version...', 'id' => 'description', 'style' => 'resize:none;', 'rows' => 10]) }}
              </div>
            </div>

          	<div class="form-group">
      				<div class="col-lg-9 col-lg-offset-3" style="text-align: right">
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
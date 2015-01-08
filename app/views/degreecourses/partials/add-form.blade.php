<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        {{ Form::model(new DegreeCourse, ['route' => ['saveDegreecourse_path'], 'class' => "form-horizontal"])}}
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	    <fieldset>
	    <legend>Neuen Studiengang erstellen</legend>
	    	<div class="form-group">
    			{{ Form::label('short', 'Kürzel*:', array('class' => "col-lg-3 control-label", 'id' => "short")) }}
    			<div class="col-lg-9">
    				{{ Form::input('text', 'short', '', array('id' => "short", 'min' => 3, 'placeholder' => 'Kürzel, z.B. Inf BSc', 'required' => true, 'class' => "form-control input-sm")) }}
    			</div>
        	</div>

        	<div class="form-group">
    			{{ Form::label('name', 'Name*:', array('class' => "col-lg-3 control-label", 'id' => "name")) }}
    			<div class="col-lg-9">
    				{{ Form::input('text', 'name', '', array('id' => "name", 'min' => 3, 'placeholder' => 'Studiengangsname', 'required' => true, 'class' => "form-control input-sm")) }}
    			</div>
        	</div>

        	<div class="form-group">
    			{{ Form::label('degree_id', 'Abschluss*:', array('class' => "col-lg-3 control-label", 'id' => "degree_id")) }}
    			<div class="col-lg-9">
    				{{ Form::select('degree_id', $listofdegrees, '', array('id' => "degree_id", 'required' => true, 'class' => "form-control input-sm")) }}
    			</div>
        	</div>

        	<div class="form-group">
    			{{ Form::label('department_id', 'Fachbereich*:', array('class' => "col-lg-3 control-label", 'id' => "department_id")) }}
    			<div class="col-lg-9">
    				{{ Form::select('department_id', $listofdepartments, '', array('id' => "department_id", 'required' => true, 'class' => "form-control input-sm")) }}
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
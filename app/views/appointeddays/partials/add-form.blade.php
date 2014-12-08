<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-body">
	        {{ Form::model(new Appointedday, ['route' => ['appointeddays.store'], 'class' => "form-horizontal"])}}
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <fieldset>
	        	<legend>Neuen Termin erstellen</legend>
	        	<div class="form-group">
        			{{ Form::label('subject', 'Betreff*:', array('class' => "col-lg-3 control-label", 'id' => "subject")) }}
        			<div class="col-lg-9">
        				{{ Form::input('text', 'subject', '', array('id' => "subject", 'min' => 3, 'placeholder' => 'Betreff', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>

	        	<div class="form-group">
        			{{ Form::label('date', 'Datum*:', array('class' => "col-lg-3 control-label", 'id' => "date")) }}
        			<div class="col-lg-9">
        				{{ Form::input('date', 'date', '', array('id' => "date", 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>
	        	
	        	<div class="form-group">
	        		{{ Form::label('content', 'Text*:', array('class' => "col-lg-3 control-label", 'id' => "content")) }}
	        		<div class="col-lg-9">
	        			{{ Form::textarea('content', '', array('id' => "content", 'placeholder' => 'Text', 'class' => "form-control input-sm", 'rows'=>5, 'style' => 'resize:none;')) }}
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
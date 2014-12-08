<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
	      	<div class="modal-body">
	        {{ Form::model(new Announcement, ['route' => ['announcements.store'], 'class' => "form-horizontal"])}}
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <fieldset>
	        	<legend>Neue Ankündigung erstellen</legend>
	        	<div class="form-group">
        			{{ Form::label('subject', 'Betreff*:', array('class' => "col-lg-4 control-label", 'id' => "subject")) }}
        			<div class="col-lg-8">
        				{{ Form::input('text', 'subject', '', array('id' => "subject", 'min' => 3, 'placeholder' => 'Betreff', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>
	        	
	        	<div class="form-group">
	        		{{ Form::label('content', 'Ankündigung*:', array('class' => "col-lg-4 control-label", 'id' => "content")) }}
	        		<div class="col-lg-8">
	        			{{ Form::textarea('content', '', array('id' => "content", 'placeholder' => 'Ankündigungstext', 'class' => "form-control input-sm", 'rows'=>5, 'style' => 'resize:none;')) }}
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
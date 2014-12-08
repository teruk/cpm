<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      	{{ Form::model(new Section, ['route' => ['sections.store'], 'class' => "form-horizontal"])}}
      		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      		<fieldset>
      			<legend>Neuen Bereich erstellen</legend>
      			<div class="form-group">
      				{{Form::label('name','Name:*', array('class' => "col-lg-2 control-label", 'id' => "name"))}}
      				<div class="col-lg-10">
      					{{ Form::input('text', 'name', '', array('id' => "name", 'placeholder' => "Bereichsname", 'class' => "form-control", 'required'=>true, 'autofocus' => true)) }}
      				</div>
      			</div>
      			<div class="form-group">
      				<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
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
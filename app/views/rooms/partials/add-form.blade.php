<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-body">
	        {{ Form::model(new Room, ['route' => ['saveRoom_path'], 'class' => "form-horizontal"])}}
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        <fieldset>
	        	<legend>Neuen Raum erstellen</legend>
	        	<div class="form-group">
        			{{ Form::label('name', 'Name*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
        			<div class="col-lg-8">
        				{{ Form::input('text', 'name', '', array('id' => "name", 'min' => 3, 'placeholder' => 'Raumname, z.B. A-101', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>

	        	<div class="form-group">
        			{{ Form::label('location', 'Ort*:', array('class' => "col-lg-4 control-label", 'id' => "location")) }}
        			<div class="col-lg-8">
        				{{ Form::input('text', 'location', '', array('id' => "location", 'min' => 3, 'placeholder' => 'Ort, z.B. Gebäudename', 'required' => true, 'class' => "form-control input-sm")) }}
        			</div>
	        	</div>

	        	<div class="form-group">
	                {{ Form::label('seats', 'Plätze:*:', array('class' => "col-lg-4 control-label", 'id' => "seats")) }}
	                <div class="col-lg-8">
	                  	{{ Form::input('number', 'seats', 10, array('min' => 1, 'id' => "seats", 'class' => "form-control input-sm", 'required' => true)) }}
	                </div>
	            </div>

	            <div class="form-group">
	                {{ Form::label('room_type_id', 'Raumtyp*:', array('class' => "col-lg-4 control-label", 'id' => "room_type_id")) }}
	                <div class="col-lg-8">
	                  {{ Form::select('room_type_id', $listofroomtypes, 1, array('id' => "room_type_id", 'class' => "form-control input-sm")) }}
	                </div>
                </div>

                <div class="form-group">
                    {{ Form::label('beamer', 'Beamer:', array('class' => "col-lg-4 control-label", 'id' => "beamer")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','beamer', 1, array('id' => "beamer", 'class' => "form-control input-sm"))}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('blackboard', 'Tafel:', array('class' => "col-lg-4 control-label", 'id' => "blackboard")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','blackboard', 1, array('id' => "blackboard", 'class' => "form-control input-sm"))}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('overheadprojector', 'Overheadprojektor:', array('class' => "col-lg-4 control-label", 'id' => "overheadprojector")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','overheadprojector', 1, array('id' => "overheadprojector", 'class' => "form-control input-sm"))}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('accessible', 'Behindertengerecht:', array('class' => "col-lg-4 control-label", 'id' => "accessible")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','accessible', 1, array('id' => "accessible", 'class' => "form-control input-sm"))}}
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
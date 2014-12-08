<div class="modal-dialog">
	<div class="modal-content">
  		<div class="modal-body">
    		{{ Form::model(new Planning, ['route' => ['plannings.copylastturn',$display_turn->id], 'class' => "form-horizontal"])}}
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<fieldset>
    			<legend>{{ $display_turn->name }} {{ ($display_turn->year-1) }} kopieren</legend>

                <div class="form-group col-lg-12  col-lg-offset-1">
                    Wollen Sie alle Lehrveranstaltungen aus dem {{ $display_turn->name }} {{ ($display_turn->year-1) }} kopieren? Sollten Lehrveranstaltungen aus dem {{ $display_turn->name }} {{ ($display_turn->year-1) }} schon im aktuellen Semester geplant worden sein, so werden diese nicht kopiert!<br><br> Folgende Optionen können übernommen werden:
                </div>

                <div class="form-group">
                    {{ Form::label('employees', 'Verantwortliche:', array('class' => "col-lg-4 control-label", 'id' => "employees")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','employees', 1, array('id' => "employees", 'class' => "form-control input-sm"))}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('comments', 'Bemerkungen:', array('class' => "col-lg-4 control-label", 'id' => "comments")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','comments', 1, array('id' => "comments", 'class' => "form-control input-sm"))}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('room_preferences', 'Raumwünsche:', array('class' => "col-lg-4 control-label", 'id' => "room_preferences")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','room_preferences', 1, array('id' => "room_preferences", 'class' => "form-control input-sm"))}}
                    </div>
                </div>
    			
    			<div class="form-group">
  					<div class="col-lg-8 col-lg-offset-4" style="text-align: right">
  					<button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
					{{ Form::submit('Kopieren', array('class' => 'btn btn btn-copy')) }}
  					</div>
  				</div>
    		</fieldset>
    		{{ Form::close() }}
  		</div>
	</div>
</div>
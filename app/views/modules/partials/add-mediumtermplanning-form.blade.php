<div class="modal-dialog">
	<div class="modal-content">
  		<div class="modal-body">
            {{ Form::model($module, ['method' => 'POST', 'route' => ['saveMediumtermplanning_path', $module->id], 'class' => "form-horizontal"]) }}
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <fieldset>
                <legend>Mittelfristige Lehrplanung - Semester hinzufügen</legend>

                <!-- <div class="form-group col-lg-12  col-lg-offset-1">
                    Wollen Sie die Mittelfristige Lehrplanung des Semesters wirklich kopieren? Die Verantwortlichen werden samt Einstellungen übernommen.
                    <br>Bitte wählen Sie das Zielsemester aus:
                </div> -->

                <div class="form-group">
                    {{ Form::label('turn_id', 'Neues Semester:', array('class' => "col-lg-4 control-label", 'id' => "turn_id")) }}
                    <div class="col-lg-8">
                        {{ Form::select('turn_id', $availableTurns, 1, array('id' => "turn_id", 'class' => "form-control input-sm"))}}
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="col-lg-8 col-lg-offset-4" style="text-align: right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
                    {{ Form::submit('Hinzufügen', array('class' => 'btn btn btn-success')) }}
                    </div>
                </div>
            </fieldset>
            {{ Form::close() }}
  		</div>
	</div>
</div>
<div class="modal-dialog">
	<div class="modal-content">
  		<div class="modal-body">
            {{ Form::model($module, ['method' => 'PATCH', 'route' => ['copyMediumtermplanning_path', $module->id], 'class' => "form-horizontal"]) }}
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <fieldset>
                <legend>Mittelfristige Lehrplanung des Semesters kopieren</legend>

                <div class="form-group col-lg-12  col-lg-offset-1">
                    Wollen Sie die Mittelfristige Lehrplanung des Semesters wirklich kopieren? Die Verantwortlichen werden samt Einstellungen übernommen.
                    <br>Bitte wählen Sie Quelle und Ziel aus:
                </div>

                <div class="form-group">
                    {{ Form::label('mediumtermplanningId', 'Quelle:', array('class' => "col-lg-4 control-label", 'id' => "mediumtermplanningId")) }}
                    <div class="col-lg-8">
                        {{ Form::select('mediumtermplanningId', $mediumtermplanningTurns, 1, array('id' => "mediumtermplanningId", 'class' => "form-control input-sm"))}}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('turn_id_target', 'Ziel:', array('class' => "col-lg-4 control-label", 'id' => "turn_id_target")) }}
                    <div class="col-lg-8">
                        {{ Form::select('turn_id_target', $availableTurns, 1, array('id' => "turn_id_target", 'class' => "form-control input-sm"))}}
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
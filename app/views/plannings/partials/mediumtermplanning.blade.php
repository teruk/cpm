<div class="modal-dialog">
	<div class="modal-content">
  		<div class="modal-body">
    		{{ Form::model($display_turn->id, ['method' => 'PATCH', 'route' => ['plannings.generateFromMediumtermplanning',$display_turn->id], 'class' => "form-horizontal"])}}
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<fieldset>
    			<legend>Semester aus mittelfristiger Lehrplanung generieren</legend>

                <div class="form-group col-lg-12 col-lg-offset-1">
                    Wollen Sie alle Lehrveranstaltungen aus der mittelfristigen Lehrplanung für das Semester {{ $display_turn->name }} {{ $display_turn->year }} genieren? Sollten Lehrveranstaltungen aus der mittelfristigen Lehrplanung schon im aktuellen Semester geplant worden sein, so werden diese nicht generiert! Die Anzahl der, zu einer Vorlesung gehörenden, Übungen bzw. Seminaren, orientiert sich an der Standardteilnehmerzahl der Vorlesung. Diese sollte im Anschluss, unter Berücksichtung der prognostizierten Teilnehmerzahlen, angepasst werden.
                </div>
    			
    			<div class="form-group">
  					<div class="col-lg-8 col-lg-offset-4" style="text-align: right">
  					<button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
					{{ Form::submit('Generieren', array('class' => 'btn btn btn-default')) }}
  					</div>
  				</div>
    		</fieldset>
    		{{ Form::close() }}
  		</div>
	</div>
	</div>
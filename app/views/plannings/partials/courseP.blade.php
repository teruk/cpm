<div class="modal-dialog">
	<div class="modal-content">
  		<div class="modal-body">
    		{{ Form::model(new Planning, ['route' => ['plannings.storeIndividual',$display_turn->id], 'class' => "form-horizontal"])}}
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    		<fieldset>
    			<legend>Neue Lehrveranstaltung planen</legend>
    			<div class="form-group">
    				{{ Form::label('course_id', 'LV*:', array('class' => "col-lg-4 control-label", 'id' => "course_id")) }}
    				<div class="col-lg-8">
    					{{ Form::select('course_id', $select, 1, array('id' => "course_id", 'class' => "form-control input-sm")) }}
    				</div>
    			</div>
                <div class="form-group">
                    {{ Form::label('course_title', 'LV-Titel*:', array('class' => "col-lg-4 control-label", 'id' => "course_title")) }}
                    <div class="col-lg-8">
                        {{ Form::input('text', 'course_title', '', array('min' => 3, 'placeholder' => 'Veranstaltungstitel', 'id' => "course_title", 'class' => "form-control input-sm", 'required' => true)) }}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('course_title_eng', 'engl. LV-Titel*:', array('class' => "col-lg-4 control-label", 'id' => "course_title_eng")) }}
                    <div class="col-lg-8">
                        {{ Form::input('text', 'course_title_eng', '', array('min' => 3, 'placeholder' => 'engl. Veranstaltungstitel', 'id' => "course_title_eng", 'class' => "form-control input-sm", 'required' => true)) }}
                    </div>
                </div>
                @if (Entrust::can('change_rg_status') || Entrust::hasRole('Admin'))
            		<div class="form-group">
            			{{ Form::label('researchgroup_status', 'Status*:', array('class' => "col-lg-4 control-label", 'id' => "researchgroup_status")) }}
            			<div class="col-lg-8">
            				{{ Form::select('researchgroup_status', Config::get('constants.pl_rgstatus'), 0, array('id' => "researchgroup_status", 'class' => "form-control input-sm")) }}
            			</div>
            		</div>
                @endif
                @if (Entrust::can('change_board_status') || Entrust::hasRole('Admin'))
        			<div class="form-group">
        				{{ Form::label('board_status', 'Vorstand*:', array('class' => "col-lg-4 control-label", 'id' => "board_status")) }}
        				<div class="col-lg-8">
        					{{ Form::select('board_status', Config::get('constants.pl_board_status'), 0, array('id' => "board_status", 'class' => "form-control input-sm")) }}
        				</div>
        			</div>
                @endif
    			<div class="form-group">
    				{{ Form::label('semester_periods_per_week', 'SWS:*:', array('class' => "col-lg-4 control-label", 'id' => "semester_periods_per_week")) }}
    				<div class="col-lg-8">
    					{{ Form::input('number', 'semester_periods_per_week', 1, array('min' => 1, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }}
    				</div>
    			</div>
    			<div class="form-group">
    				{{ Form::label('language', 'Sprache*:', array('class' => "col-lg-4 control-label", 'id' => "language")) }}
    				<div class="col-lg-8">
    					{{ Form::select('language', Config::get('constants.language'), 0, array('id' => "language", 'class' => "form-control input-sm"))}}
    				</div>
    			</div>
               <!--  <div class="form-group">
                    {{ Form::label('teaching_assignment', 'Lehrauftrag erforderlich?', array('class' => "col-lg-4 control-label", 'id' => "teaching_assignment")) }}
                    <div class="col-lg-8">
                        {{ Form::input('checkbox','teaching_assignment', 1, array('id' => "teaching_assignment", 'class' => "form-control input-sm"))}}
                    </div>
                </div> -->
    			<div class="form-group">
    				{{ Form::label('comment', 'Bemerkung:', array('class' => "col-lg-4 control-label", 'id' => "comment")) }}
    				<div class="col-lg-8">
    					{{ Form::textarea('comment', '', array('id' => "comment", 'class' => "form-control input-sm", 'placeholder' => 'Anmerkungen zu Lehraufträgen, Verantwortliche ...', 'rows'=>5, 'style' => 'resize:none;')) }}
    				</div>
    			</div>
                <div class="form-group">
                    {{ Form::label('room_preference', 'Raum- und Zeitwunsch:', array('class' => "col-lg-4 control-label", 'id' => "room_preference")) }}
                    <div class="col-lg-8">
                        {{ Form::textarea('room_preference', '', array('id' => "room_preference", 'class' => "form-control input-sm", 'placeholder' => 'Raumwunsch mit Tag und Uhrzeit angeben. Ist der Raum- und Zeitwunsch von der lehrenden Person abhängig sein, sollte dies hier vermerkt werden!', 'rows'=>5, 'style' => 'resize:none;')) }}
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
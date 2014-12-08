<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
      {{ Form::model(new Course, ['route' => ['courses.store'], 'class' => "form-horizontal"])}}
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <fieldset>
        <legend>Neue Lehrveranstaltung erstellen</legend>
        <div class="form-group">
              {{ Form::label('name', 'Titel*:', array('class' => "col-lg-3 control-label", 'id' => "name")) }}
              <div class="col-lg-9">
                {{ Form::input('text', 'name', '', array('id' => "name", 'min' => 3, 'placeholder' => 'Lehrveranstaltungsname', 'required' => true, 'class' => "form-control input-sm")) }}
              </div>
            </div>
            
            <div class="form-group">
              {{ Form::label('name_eng', 'EngTitel*:', array('class' => "col-lg-3 control-label", 'id' => "name_eng")) }}
              <div class="col-lg-9">
                {{ Form::input('text', 'name_eng', '', array('id' => "name_eng", 'min' => 3, 'placeholder' => 'engl. Lehrveranstaltungsname', 'required' => true, 'class' => "form-control input-sm")) }}
              </div>
            </div>
            
            <div class="form-group">
              {{ Form::label('course_number', 'LV-Nr.*:', array('class' => "col-lg-3 control-label", 'id' => "course_number")) }}
              <div class="col-lg-9">
                {{ Form::input('text', 'course_number', '', array('id' => "course_number", 'min' => 3, 'placeholder' => 'Lehrveranstaltungsnummer', 'required' => true, 'class' => "form-control input-sm")) }}
              </div>
            </div>
            
            <div class="form-group">
              {{ Form::label('course_type_id', 'LV-Typ*:', array('class' => "col-lg-3 control-label", 'id' => "course_type_id")) }}
              <div class="col-lg-9">
                {{ Form::select('course_type_id', $listofcoursetypes, 1, array('id' => "course_type_id", 'class' => "form-control input-sm")) }}
              </div>
            </div>
              
            <div class="form-group">
              {{ Form::label('participants', 'Teilnehmer:*:', array('class' => "col-lg-3 control-label", 'id' => "participants")) }}
              <div class="col-lg-9">
                {{ Form::input('number', 'participants', 20, array('min' => 1, 'id' => "participants", 'class' => "form-control input-sm", 'required' => true)) }}
              </div>
            </div>
            
            <div class="form-group">
          {{ Form::label('semester_periods_per_week', 'SWS*:', array('class' => "col-lg-3 control-label", 'id' => "semester_periods_per_week")) }}
          <div class="col-lg-9">
            {{ Form::input('number', 'semester_periods_per_week', 2, array('min' => 1, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }}
          </div>
        </div>
        
        <div class="form-group">
              {{ Form::label('language', 'Sprache*:', array('class' => "col-lg-3 control-label", 'id' => "language")) }}
              <div class="col-lg-9">
                {{ Form::select('language', Config::get('constants.language'), 0, array('id' => "language", 'class' => "form-control input-sm")) }}
              </div>
            </div>
            
            <div class="form-group">
              {{ Form::label('module_id', 'Modul*:', array('class' => "col-lg-3 control-label", 'id' => "module_id")) }}
              <div class="col-lg-9">
                {{ Form::select('module_id', $listofmodules, 1, array('id' => "module_id", 'class' => "form-control input-sm")) }}
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
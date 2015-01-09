<!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            {{ Form::model(new Module, ['route' => ['saveModule_path'], 'class' => "form-horizontal"])}}
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <fieldset>
              <legend>Neues Modul anlegen</legend>
              <div class="form-group-sm">
                {{ Form::label('name', 'Titel*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
                <div class="col-lg-8">
                  {{ Form::input('text', 'name', '', array('id' => "name", 'min' => 3, 'placeholder' => 'Modulname', 'required' => true, 'class' => "form-control input-sm", 'autofocus' => true)) }}
                </div>
              </div>
              
              <div class="form-group-sm">
                {{ Form::label('name', 'engl. Titel*:', array('class' => "col-lg-4 control-label", 'id' => "name_eng")) }}
                <div class="col-lg-8">
                  {{ Form::input('text', 'name_eng', '', array('id' => "name_eng", 'min' => 3, 'placeholder' => 'engl. Modulname', 'required' => true, 'class' => "form-control input-sm")) }}
                </div>
              </div>
              
              <div class="form-group-sm">
                {{ Form::label('short', 'Kurz*:', array('class' => "col-lg-4 control-label", 'id' => "name_eng")) }}
                <div class="col-lg-8">
                  {{ Form::input('text', 'short', '', array('id' => "name_eng", 'min' => 3, 'placeholder' => 'z.B. InfB-SE 1', 'required' => true, 'class' => "form-control input-sm")) }}
                </div>
              </div>
              
              <div class="form-group-sm">
            {{ Form::label('credits', 'LP*:', array('class' => "col-lg-4 control-label", 'id' => "credits")) }}
            <div class="col-lg-8">
              {{ Form::input('number', 'credits', 2, array('min' => 1, 'step' => 0.5, 'id' => "credits", 'class' => "form-control input-sm", 'required' => true)) }}
            </div>
          </div>
          
          <div class="form-group-sm">
                {{ Form::label('rotation_id', 'Turnus*:', array('class' => "col-lg-4 control-label", 'id' => "rotation_id")) }}
                <div class="col-lg-8">
                  {{ Form::select('rotation_id', $listofrotations, 1, array('id' => "rotation_id", 'class' => "form-control input-sm")) }}
                </div>
              </div>
              
              <div class="form-group-sm">
                {{ Form::label('degree_id', 'Niveau*:', array('class' => "col-lg-4 control-label", 'id' => "degree_id")) }}
                <div class="col-lg-8">
                  {{ Form::select('degree_id', $listofdegrees, 1, array('id' => "degree_id", 'class' => "form-control input-sm")) }}
                </div>
              </div>
              
              <div class="form-group-sm">
                {{ Form::label('exam_type', 'Abschluss*:', array('class' => "col-lg-4 control-label", 'id' => "exam_type")) }}
                <div class="col-lg-8">
                  {{ Form::select('exam_type', Config::get('constants.exam_type'), 0, array('id' => "exam_type", 'class' => "form-control input-sm")) }}
                </div>
              </div>
              
              <div class="form-group-sm">
                {{ Form::label('language', 'Sprache*:', array('class' => "col-lg-4 control-label", 'id' => "language")) }}
                <div class="col-lg-8">
                  {{ Form::select('language', Config::get('constants.language'), 0, array('id' => "language", 'class' => "form-control input-sm")) }}
                </div>
              </div>
              
              <div class="form-group-sm">
                {{ Form::label('department_id', 'Zugehörigkeit*:', array('class' => "col-lg-4 control-label", 'id' => "department_id")) }}
                <div class="col-lg-8">
                  {{ Form::select('department_id', $listofdepartments, 1, array('id' => "department_id", 'class' => "form-control input-sm")) }}
                </div>
              </div>

              <div class="form-group-sm">
                {{ Form::label('individual_courses', 'Individuelle Lehr-veranstaltungen:', array('class' => "col-lg-4 control-label", 'id' => "individual_courses")) }}
                <div class="col-lg-8">
                  {{ Form::checkbox('individual_courses', 1, '', array('id' => "individual_courses", 'class' => "form-control input-sm")) }}
                </div>
              </div>
              
              <div class="form-group-sm">
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
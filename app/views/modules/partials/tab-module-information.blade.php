<div class="row">
	<div class="col-sm-7">
		<div class="panel panel-primary">
            <div class="panel-body">
				{{ Form::model($module, ['method' => 'PATCH', 'route' => ['modules.update', $module->id], 'class' => "form-horizontal"]) }}
				<fieldset>
					<legend>Modul aktualisieren</legend>
						<div class="form-group">
			                {{ Form::label('short', 'Kürzel*:', array('class' => "col-lg-4 control-label", 'id' => "name_eng")) }}
			                <div class="col-lg-8">
			                  {{ Form::input('text', 'short', $module->short, array('id' => "name_eng", 'min' => 3, 'placeholder' => 'z.B. InfB-SE 1', 'required' => true, 'class' => "form-control input-sm", 'autofocus' => true)) }}
			                </div>
			            </div>

						<div class="form-group">
			                {{ Form::label('name', 'Titel*:', array('class' => "col-sm-4 control-label", 'id' => "name")) }}
			                <div class="col-sm-8">
			                  {{ Form::input('text', 'name', $module->name, array('id' => "name", 'min' => 3, 'placeholder' => 'Modulname', 'required' => true, 'class' => "form-control input-sm")) }}
			                </div>
			            </div>

			            <div class="form-group">
				            {{ Form::label('name', 'engl. Titel*:', array('class' => "col-sm-4 control-label", 'id' => "name_eng")) }}
				            <div class="col-sm-8">
				              {{ Form::input('text', 'name_eng', $module->name_eng, array('id' => "name_eng", 'min' => 3, 'placeholder' => 'engl. Modulname', 'required' => true, 'class' => "form-control input-sm")) }}
				            </div>
				        </div>

				         <div class="form-group">
				            {{ Form::label('credits', 'LP*:', array('class' => "col-sm-4 control-label", 'id' => "credits")) }}
				            <div class="col-sm-8">
				              {{ Form::input('number', 'credits', $module->credits, array('min' => 1, 'step' => 0.5, 'id' => "credits", 'class' => "form-control input-sm", 'required' => true)) }}
				            </div>
				          </div>
				          
				          <div class="form-group">
			                {{ Form::label('rotation_id', 'Turnus:', array('class' => "col-sm-4 control-label", 'id' => "rotation_id")) }}
			                <div class="col-sm-8">
			                  {{ Form::select('rotation_id', $lists['rotations'], $module->rotation_id, array('id' => "rotation_id", 'class' => "form-control input-sm")) }}
			                </div>
			              </div>
			              
			              <div class="form-group">
			                {{ Form::label('degree_id', 'Niveau:', array('class' => "col-sm-4 control-label", 'id' => "degree_id")) }}
			                <div class="col-sm-8">
			                  {{ Form::select('degree_id', $lists['degrees'], $module->degree_id, array('id' => "degree_id", 'class' => "form-control input-sm")) }}
			                </div>
			              </div>
			              
			              <div class="form-group">
			                {{ Form::label('exam_type', 'Abschluss:', array('class' => "col-sm-4 control-label", 'id' => "exam_type")) }}
			                <div class="col-sm-8">
			                  {{ Form::select('exam_type', Config::get('constants.exam_type'), $module->exam_type, array('id' => "exam_type", 'class' => "form-control input-sm")) }}
			                </div>
			              </div>
			              
			              <div class="form-group">
			                {{ Form::label('language', 'Sprache:', array('class' => "col-sm-4 control-label", 'id' => "language")) }}
			                <div class="col-sm-8">
			                  {{ Form::select('language', Config::get('constants.language'), $module->language, array('id' => "language", 'class' => "form-control input-sm")) }}
			                </div>
			              </div>
			              
			              <div class="form-group">
			                {{ Form::label('department_id', 'Fachbereich:', array('class' => "col-sm-4 control-label", 'id' => "department_id")) }}
			                <div class="col-sm-8">
			                  {{ Form::select('department_id', $lists['departments'], $module->department_id, array('id' => "department_id", 'class' => "form-control input-sm")) }}
			                </div>
			              </div>

			              <div class="form-group">
			                {{ Form::label('individual_courses', 'Individuelle Lehr-veranstaltungen:', array('class' => "col-sm-4 control-label", 'id' => "individual_courses")) }}
			                <div class="col-sm-8">
			                  {{ Form::checkbox('individual_courses', 1, $module->individual_courses, array('id' => "individual_courses", 'class' => "form-control input-sm")) }}
			                </div>
			              </div>

			              <div class="form-group">
	      					<div class="col-sm-8 col-sm-offset-4" style="text-align: right">
	      					@if (Entrust::hasRole('Admin') || Entrust::can('edit_module'))
		      					*erforderlich
		      					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
		      				@endif
	      					</div>
      				</div>
				</fieldset>
				{{ Form::close() }}
			</div>
		</div>
	</div>
</div>
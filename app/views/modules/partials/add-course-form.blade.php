<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-body">
			{{ Form::model(new Course, ['route' => ['saveCourse_path'], 'class' => "form-horizontal"])}}
			{{ Form::hidden('module_id',$module->id) }}
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<fieldset>
				<legend>Neue Lehrveranstaltung anlegen</legend>
				<div class="form-group">
					{{ Form::label('module', 'Modul:', array('class' => "col-lg-4 control-label", 'id' => "module")) }}
					<div class="col-lg-8">
						{{ Form::input('text', 'module', $module->name, array('id' => "module", 'required'=>true, 'class' => 'form-control input-sm', 'disabled' => "")) }}
					</div>
				</div>	
				
				<div class="form-group">
					{{ Form::label('name', 'Titel*:', array('class' => "col-lg-4 control-label", 'id' => "name")) }}
					<div class="col-lg-8">
						{{ Form::input('text', 'name', '', array('id' => "name", 'required'=>true, 'class' => 'form-control input-sm')) }}
					</div>
				</div>		
				
				<div class="form-group">
					{{ Form::label('name_eng', 'EngTitel*:', array('class' => "col-lg-4 control-label", 'id' => "name_eng")) }}
					<div class="col-lg-8">
						{{ Form::input('text', 'name_eng', '', array('id' => "name_eng", 'required'=>true, 'class' => 'form-control input-sm')) }}
					</div>
				</div>
				
				<div class="form-group">
					{{ Form::label('course_number', 'Nummer*:', array('class' => "col-lg-4 control-label", 'id' => "course_number")) }}
					<div class="col-lg-8">
						{{ Form::input('text', 'course_number', '', array('id' => "course_number", 'required'=>true, 'class' => 'form-control input-sm')) }}
					</div>
				</div>
				
				<div class="form-group">
					{{ Form::label('coursetype_id', 'Typ*:', array('class' => "col-lg-4 control-label", 'id' => "coursetype_id")) }}
					<div class="col-lg-8">
						{{ Form::select('coursetype_id', $coursetypes, 0,array('id' => "coursetype_id", 'class' => "form-control input-sm")) }}
					</div>
				</div>	
				
				<div class="form-group">
					{{ Form::label('participants', 'Teilnehmer*:', array('class' => "col-lg-4 control-label", 'id' => "participants")) }}
					<div class="col-lg-8">
						{{ Form::input('number', 'participants', 12, array('min' => 1, 'id' => "participants", 'class' => "form-control input-sm", 'required' => true)) }}
					</div>
				</div>	
				
				<div class="form-group">
					{{ Form::label('semester_periods_per_week', 'SWS*:', array('class' => "col-lg-4 control-label", 'id' => "semester_periods_per_week")) }}
					<div class="col-lg-8">
						{{ Form::input('number', 'semester_periods_per_week', 2, array('min' => 1, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }}
					</div>
				</div>
				
				<div class="form-group">
					{{ Form::label('language', 'Sprache*:', array('class' => "col-lg-4 control-label", 'id' => "language")) }}
					<div class="col-lg-8">
						{{ Form::select('language', Config::get('constants.language'), 0, array('id' => "language", 'class' => "form-control input-sm")) }}
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
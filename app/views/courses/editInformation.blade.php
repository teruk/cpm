@include('courses.partials.breadcrumb', ['breadcrumbTitle' => 'Informationen bearbeiten'])

@section('main')
	
	<div class="row">
		@include('courses.partials.sidenav')

		<div class="col-md-9">
			@include('courses.partials.heading', ['title' => 'Information bearbeiten:'])

			<p>Bearbeitung der Informationen dieser Lehrveranstaltung.</p>
			<div class="panel panel-default">
		        <div class="panel-body">
					{{ Form::model($course, ['method' => 'PATCH', 'route' => ['updateCourse_path', $course->id], 'class' => 'form-horizontal']) }}

						<div class="form-group">
							{{ Form::label('name', 'Name*:', ['class' => 'col-md-2']) }}
							<div class="col-md-10">
								{{ Form::input('text', 'name', $course->name, array('id' => "name", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('name_eng', 'engl. Name*:', ['class' => 'col-md-2']) }}
							<div class="col-md-10">
								{{ Form::input('text', 'name_eng', $course->name_eng, array('id' => "name_eng", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('course_number', 'LV-Nr.*:', ['class' => 'col-md-2']) }}
							<div class="col-md-4">
								{{ Form::input('text', 'course_number', $course->course_number, array('id' => "course_number", 'min' => 3, 'required' => true, 'class' => "form-control input-sm")) }}
							</div>

							{{ Form::label('coursetype_id', 'LV-Typ*:', ['class' => 'col-md-2']) }}
							<div class="col-md-4">
								{{ Form::select('coursetype_id', $listofcoursetypes, $course->coursetype_id, array('id' => "coursetype_id", 'class' => "form-control input-sm")) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('participants', 'Teilnehmer*:', ['class' => 'col-md-2']) }}
							<div class="col-md-4">
								{{ Form::input('number', 'participants', $course->participants, array('min' => 1, 'id' => "participants", 'class' => "form-control input-sm", 'required' => true)) }}
							</div>

							{{ Form::label('semester_periods_per_week', 'SWS*:', ['class' => 'col-md-2']) }}
							<div class="col-md-4">
								{{ Form::input('number', 'semester_periods_per_week', $course->semester_periods_per_week, array('min' => 1, 'step' => 0.5, 'id' => "semester_periods_per_week", 'class' => "form-control input-sm", 'required' => true)) }}
							</div>

						</div>

						<div class="form-group">
							{{ Form::label('language', 'Sprache*:', ['class' => 'col-md-2']) }}
							<div class="col-md-4">
								{{ Form::select('language', Config::get('constants.language'), $course->language, array('id' => "language", 'class' => "form-control input-sm")) }}
							</div>
						</div>

						<div class="form-group">
							{{ Form::label('module_id', 'Modul:', ['class' => 'col-md-2']) }}
							<div class="col-md-10">
								{{ Form::select('module_id', $listofmodules, $course->module_id, array('id' => "module_id", 'class' => "form-control input-sm")) }}
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
								{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Informationen aktualisieren')) }}
							</div>
						</div>

					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
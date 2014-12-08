@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
		<li><a href="{{ route('overview.modules') }}">Module</a></li>
		<li class="active">{{ $module->name }} ({{ $module->short }})</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">

			<table class="table table-striped table-condensed">
				<thead>
					<tr>
	        			<th colspan="7">Modulinformationen:</th>
	        		</tr>
					<tr>
						<th>Kürzel</th>
						<th>Titel</th>
						<th>engl. Titel</th>
						<th>Fachbereich</th>
						<th>Niveau</th>
						<th>Sprache</th>
						<th>Abschluss</th>
						<th>Turnus</th>
						<th>LP</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ $module->short }}</td>
						<td>{{ $module->name }}</td>
						<td>{{ $module->name_eng }}</td>
						<td>{{ $module->department->name }}</td>
						<td>{{ $module->degree->name }}</td>
						<td>{{ Config::get('constants.language')[$module->language] }}</td>
						<td>{{ Config::get('constants.exam_type')[$module->exam_type] }}</td>
						<td>{{ $module->rotation->name }}</td>
						<td>{{ $module->credits }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="degreecourse_table" cellspacing="0">
		        	<thead>
		        		<tr>
		        			<th colspan="7">Diesem Modul sind folgenden Lehrveranstaltungen zugeordnet:</th>
		        		</tr>
		                <tr>
		                  <th>LV-Nr.</th>
		                  <th>Titel</th>
		                  <th>engl. Titel</th>
		                  <th>Typ</th>
		                  <th>Teilnehmer</th>
		                  <th>SWS</th>
		                  <th>Sprache</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $module->courses as $course )
							<tr>
								<td>{{ $course->course_number }}</td>
								<td><a href="{{ route('overview.course',$course->id)}}">{{ $course->name }}</a></td>
								<td>{{ $course->name_eng }}</td>
								<td>{{ $listofcoursetypes[$course->course_type_id] }}</td>
								<td>{{ $course->participants }}</td>
								<td>{{ $course->semester_periods_per_week }}</td>
								<td>{{ Config::get('constants.language')[$course->language] }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="degreecourse_table" cellspacing="0">
		        	<thead>
		        		<tr>
		        			<th colspan="5">Dieses Modul ist folgenden Studiengängen zugeordnet:</th>
		        		</tr>
		                <tr>
		                  <th>Studiengang</th>
		                  <th>Kurz</th>
		                  <th>Fachbereich</th>
		                  <th>Semester</th>
		                  <th>Bereich</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $module->degreecourses as $degreecourse )
							<tr>
								<td><a href="{{ route('overview.degreecourse', $degreecourse->id) }}">{{ $degreecourse->degree->name }} {{ $degreecourse->name }}</td>
								<td>{{ $degreecourse->short }}</td>
								<td>{{ $degreecourse->department->name }}</td>
								<td>{{ $degreecourse->pivot->semester }}</td>
								<td>{{ $listofsections[$degreecourse->pivot->section] }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
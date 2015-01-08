<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-primary">
            
            <div class="panel-body">
            	<div class="btn-toolbar" style="margin-bottom: 5px;">
						@if (Entrust::hasRole('Admin') || Entrust::can('add_course'))
							<div class="btn-group">
							    <a href="#" class="btn btn-success btn-xs" id="btn-addCourse" data-toggle="tooltip" data-placement="top" data-original-title="Neue Lehrveranstaltung zu dem Modul anlegen"><i class="glyphicon glyphicon-plus"></i> Lehrveranstaltung hinzufügen</a>
						  	</div>
						@endif
					</div>
            	<table class="table table-striped table-condensed">
            		<thead>
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
            			@if ( sizeof($courses) > 0 )
	            			@foreach ($courses as $course)
	            				<tr>
									<td>{{ $course->course_number }}</td>
									<td>{{ link_to_route('showCourse_path', $course->name, [$course->id]) }}</td>
									<td>{{ $course->name_eng }}</td>
									<td>{{ $course->coursetype->short }}</td>
									<td>{{ $course->participants }}</td>
									<td>{{ $course->semester_periods_per_week }}</td>
									<td>{{ Config::get('constants.language')[$course->language] }}</td>
								</tr>
	            			@endforeach
	            		@else
	            			<tr>
	            				<td colspan=5>Keine verknüpften Lehreranstaltungen</td>
	            			</tr>
		            	@endif
		            </tbody>
            	</table>
			</div>
		</div>
	</div>
</div> 
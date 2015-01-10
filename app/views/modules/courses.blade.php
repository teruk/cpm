@extends('layouts.main')

@section('scripts')
	<script type="text/javascript" class="init">

	    $(document).ready(function() {

		    $('#btn-addCourse').click(function () {
			     $('#myModal').modal('show');
			});

	    } );

	</script>
@stop

@include('modules.partials.breadcrumb', ['breadcrumbTitle' => 'Zugehörige Lehrveranstaltungen'])

@section('main')
	
	<div class="row">
		@include('modules.partials.sidenav')

		<div class="col-md-9">
			@include('modules.partials.heading', ['title' => 'Zugehörige Lehrveranstaltungen:'])

			<p>Bearbeiten der Modulinformationen.</p>
			<div class="panel panel-default">
	            <div class="panel-body">
					<div class="btn-toolbar" style="margin-bottom: 5px;">
						@if (Entrust::hasRole('Admin') || Entrust::can('add_course'))
							<div class="btn-group">
							    <a href="#" class="btn btn-success btn-xs" id="btn-addCourse" data-toggle="tooltip" data-placement="top" data-original-title="Neue Lehrveranstaltung zu dem Modul anlegen"><i class="glyphicon glyphicon-plus"></i> Lehrveranstaltung hinzufügen</a>
						  	</div>
						@endif
					</div>

					<div class="table-responsive">
						<table class="table table-striped table-condensed">
		            		<thead>
		            			<tr>
				                  <th>LV-Nr.</th>
				                  <th>Titel / engl. Titel</th>
				                  <th>Typ</th>
				                  <th>Teilnehmer</th>
				                  <th>SWS</th>
				                  <th>Sprache</th>
				                </tr>
		            		</thead>
		            		<tbody>
		            			@if ( $module->courses->count() > 0 )
			            			@foreach ($module->courses as $course)
			            				<tr>
											<td>{{ $course->course_number }}</td>
											<td>
												@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_course'))
													{{ HTML::decode(link_to_route('editCourseInformation_path', $course->name.'<br>'.$course->name_eng, [$course->id])) }}
												@else
													{{ $course->name}} <br> {{ $course->name_eng }}
												@endif
											</td>
											<td>{{ $course->coursetype->short }}</td>
											<td>{{ $course->participants }}</td>
											<td>{{ $course->semester_periods_per_week }}</td>
											<td>{{ Config::get('constants.language')[$course->language] }}</td>
										</tr>
			            			@endforeach
			            		@else
			            			<tr>
			            				<td colspan=6>Keine verknüpften Lehreranstaltungen</td>
			            			</tr>
				            	@endif
		            		</tbody>
            			</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		@include('modules.partials.add-course-form')
	</div>
@stop
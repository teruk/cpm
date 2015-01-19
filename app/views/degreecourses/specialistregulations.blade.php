@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.delete-confirm-js')
@stop

@include('degreecourses.partials.breadcrumb', ['breadcrumbTitle' => 'FSB-Versionen'])

@section('main')
	
	<div class="row">
		@include('degreecourses.partials.sidenav')

		<div class="col-md-9">
			@include('degreecourses.partials.heading', ['title' => 'FSB-Versionen verwalten:'])

			<p>Die verschiedenen FSB-Versionen dienen der besseren Raum- und Zeitplanung von Lehrveranstaltungen.</p>
			<div class="table-responsive">
		        <table class="table table-condensed" style="border: 1px solid lightgrey;">
		        	<thead>
		                <tr>
		                  <th>Startsemester</th>
		                  <th>Status</th>
		                  <th>Kurzbeschreibung</th>
		                  <th colspan="2" width="10%">Optionen</th>
		                </tr>
		          	</thead>
		          	<tbody>
		          		@foreach( $degreecourse->specialistregualtions as $specialistregulation )
							<tr>
								<td>{{$specialistregulation->turn->present()}}</td>
								<td>
									@if ($specialistregulation->active)
										aktiv
									@else
										inaktiv
									@endif
								</td>
								<td>{{(strlen($specialistregulation->description) > 120) ? substr($specialistregulation->description, 0, 120) : $specialistregulation->description}}</td>
								<td>
									@if ($currentUser->hasRole('Admin'))
										{{ HTML::decode(link_to_route('editSpecialistregulation_path', '<i class="glyphicon glyphicon-edit"></i>', [$degreecourse->id, $specialistregulation->id], ['class' => 'btn btn-warning btn-xs'])) }}
									@endif
								</td>
								<td>
									@if ($currentUser->hasRole('Admin'))
										{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteSpecialistregualtion_path', $degreecourse->id, $specialistregulation->id))) }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Fachspezifische Bestimmungen löschen', 'data-message' => 'Wollen Sie die Fachspezifischen Bestimmungen wirklich löschen?')) }}
										{{ Form::close()}}
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
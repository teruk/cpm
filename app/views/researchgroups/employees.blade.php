@extends('layouts.main')

@include('researchgroups.partials.breadcrumb', ['breadcrumbTitle' => 'Personalübersicht'])

@section('main')
	
	<div class="row">
		@include('researchgroups.partials.sidenav')

		<div class="col-md-9">
			@include('researchgroups.partials.heading', ['title' => 'Personalübersicht:'])

			<p>Bearbeitung der Informationen dieses Arbeitsbereiches.</p>

			<div class="table-responsive">
	            <table class="table table-striped" cellspacing="0">
	            	<thead>
		                <tr>
		                	<th>Name</th>
		                   	<th>Lehrdeputat</th>
		                  	<th>Angestellt seit</th>
		                  	<th>Angestellt bis</th>
		                </tr>
	              	</thead>
	              	<tbody>
						@foreach( $researchgroup->employees as $employee )
							<tr>
								<td>
									@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_employee'))
										{{ link_to_route('editEmployeeInformation_path', $employee->present(), $employee->id)}}
									@else
										{{ $employee->present() }}
									@endif
								</td>
								<td>{{ $employee->teaching_load }} SWS</td>
								<td>{{ date('d.m.Y', strtotime($employee->employed_since)) }}</td>
								<td>{{ date('d.m.Y', strtotime($employee->employed_till)) }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
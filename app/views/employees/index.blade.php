@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#employee_table').dataTable({
                "displayLength": 25,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
				"pagingType": "full"
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Mitarbeitermanagement</li>
	</ol>
@stop

@section('main')

	@if ($currentUser->hasRole('Admin') || $currentUser->can('add_employee'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Mitarbeiter hinzufügen'])
	@endif
	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-condensed table-hover" id="employee_table" cellspacing="0">
		        	<thead>
		                <tr>
		                	<th>Name</th>
		                  	<th>Arbeitsbereich</th>
		                   	<th>Lehrdeputat</th>
		                  	<th>Angestellt seit</th>
		                  	<th>Angestellt bis</th>
		                  	<th>Ehemalig</th>
		                  	<th>Option</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $employees as $employee )
							@if ($employee->inactive == 0)
								@if (date('d.m.Y', strtotime($employee->employed_till)) < date('d.m.Y'))
									<tr class="warning">
								@else
									<tr class="success">
								@endif
							@else
								<tr>
							@endif
								<td>
									@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_employee'))
										{{ link_to_route('editEmployeeInformation_path', $employee->present(), $employee->id) }}
									@else
										{{ $employee->present() }}
									@endif
								</td>
								<td>
									@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_researchgroup'))
										{{ link_to_route('showResearchgroup_path', $employee->researchgroup->short, $employee->researchgroup_id) }}
									@else
										{{ $employee->researchgroup->short }}
									@endif
								</td>
								<td>{{ $employee->teaching_load }} SWS</td>
								<td>{{ date('d.m.Y', strtotime($employee->employed_since)) }}</td>
								<td>{{ date('d.m.Y', strtotime($employee->employed_till)) }}</td>
								<td>
									@if ($employee->inactive == 1)
										ja
									@else
										nein
									@endif
								</td>
								<td>
									@if ($currentUser->hasRole('Admin') || $currentUser->can('delete_employee'))
										{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteEmployee_path', $employee->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Mitarbeiter löschen', 'data-message' => 'Wollen Sie den Mitarbeiter wirklich löschen?')) }}
										{{ Form::close() }}
									@endif
		    					</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- add form modal dialog -->
	@include('employees.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#module_table').dataTable({
				"pagingType": "full"
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Fachbereichsmanagement</li>
	</ol>
@stop

@section('main')
	@if ($currentUser->hasRole('Admin') OR $currentUser->can('add_department'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Fachbereich hinzufügen'])
	@endif
	     
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">   	
			<div  class="table-responsive">
	           	<table class="table table-striped table-condensed" id="module_table" cellspacing="0" width="100%">
	           		<thead>
	           			<tr>
	           				<th>Kurz</th>
	           				<th>Name</th>
	           				<th>Optionen</th>
	           			</tr>
	           		</thead>
	           		<tbody>
						@foreach( $departments as $department )
				
							<tr>
	        					<td>{{ $department->short }}</td>
	        					<td>
	        						@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_department'))
	        							{{ link_to_route('editDepartmentInformation_path', $department->name, $department->id) }}
	        						@else
	        							{{ $department->name }}
	        						@endif
	        					</td>
	        					<td>
	        						@if ($currentUser->hasRole('Admin') OR $currentUser->can('delete_department'))
		        						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteDepartment_path', $department->id))) }}

											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Fachbereich löschen', 'data-message' => 'Wollen Sie den Fachbereich wirklich löschen?')) }}
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
	@include('departments.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
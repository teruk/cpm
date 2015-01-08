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
	@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Fachbereich hinzufügen'])
	     
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
	        					<td>{{ link_to_route('showDepartment_path', $department->name, $department->id) }}</td>
	        					<td>
	        						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteDepartment_path', $department->id))) }}
										{{ HTML::decode(link_to_route('showDepartment_path', '<i class="glyphicon glyphicon-edit"></i>', array($department->id), array('class' => 'btn btn-xs btn-warning'))) }}

										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Fachbereich löschen', 'data-message' => 'Wollen Sie den Fachbereich wirklich löschen?')) }}
									{{ Form::close() }}
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
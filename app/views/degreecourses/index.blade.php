@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#degreecourse_table').dataTable();

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Studiengangsmanagement</li>
	</ol>
@stop
@section('main')
	
	@if ($currentUser->hasRole('Admin') OR $currentUser->can('add_degreecourse'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Studiengang hinzufügen'])
	@endif
	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="degreecourse_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>Abschluss</th>
		                  <th>Titel</th>
		                  <th>Kurz</th>
		                  <th>Fachbereich</th>
		                  <th>Optionen</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $degreecourses as $degreecourse )
							<tr>
								<td>{{ $listofdegrees[$degreecourse->degree_id] }}</td>
								<td>
									@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_degreecourse'))
										{{ link_to_route('editDegreecourseInformation_path', $degreecourse->name, $degreecourse->id) }}
									@else
										{{ $degreecourse->name }}
									@endif
								</td>
								<td>{{ $degreecourse->short }}</td>
								<td>{{ $listofdepartments[$degreecourse->department_id] }}</td>
								<td>
									@if ($currentUser->hasRole('Admin') OR $currentUser->can('delete_degreecourse'))
										{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteDegreecourse_path', $degreecourse->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Studiengang löschen', 'data-message' => 'Wollen Sie den Studiengang wirklich löschen?')) }}
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
	@include('degreecourses.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
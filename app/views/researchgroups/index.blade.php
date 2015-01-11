@extends('layouts.main')
<!--  scripts -->
@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#researchgroup_table').dataTable({
				"pagingType": "full"
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

<!-- breadcrumbs  -->
@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Arbeitsbereichsmanagement</li>
	</ol>
@stop

<!-- main content -->
@section('main')

	@if ($currentUser->hasRole('Admin') || $currentUser->can('add_researchgroup'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Arbeitsbereich hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="researchgroup_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>Kurz</th>
		                  <th>Name</th>
		                  <th>Verantwortlich</th>
		                  <th>Fachbereich</th>
		                  <th>Option</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $researchgroups as $researchgroup )
							<tr>
								<td>{{ $researchgroup->short }}</td>
								<td>
									@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_researchgroup'))
										{{ link_to_route('showResearchgroup_path', $researchgroup->name, $researchgroup->id) }}
									@else
										{{ $researchgroup->name }}
									@endif
								</td>
								<td>N.N.</td>
								<td>{{ $listofdepartments[$researchgroup->department_id] }}</td>
								<td>
									@if ($currentUser->hasRole('Admin') || $currentUser->can('delete_researchgroup'))
										{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteResearchgroup_path', $researchgroup->id))) }}

											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Arbeitsbereich löschen', 'data-message' => 'Wollen Sie den Arbeitsbereich wirklich löschen?')) }}
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
	@include('researchgroups.partials.add-form')
	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
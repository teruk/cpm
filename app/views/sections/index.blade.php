@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#section_table').dataTable({
				"pagingType": "full"
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Bereichsmanagement</li>
	</ol>
@stop

@section('main')

	@if ($currentUser->hasRole('Admin') || $currentUser->can('add_section'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Bereich hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div  class="table-responsive">
		       	<table class="table table-striped table-condensed" id="section_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Bereichsname</th>
		       				<th>Optionen</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $sections as $section )
							<tr>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_section'))
		    							{{ link_to_route('editSectionInformation_path', $section->name, $section->id) }}
		    						@else
		    							{{ $section->name }}
		    						@endif
		    					</td>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') || $currentUser->can('delete_section'))
			    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteSection_path', $section->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Bereich löschen', 'data-message' => 'Wollen Sie den Bereich wirklich löschen?')) }}
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

	<!-- add form dialog -->
	@include('sections.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
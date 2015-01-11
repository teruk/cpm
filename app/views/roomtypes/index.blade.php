@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#data_table').dataTable({
				"pagingType": "full"
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Raumtypenmanagement</li>
	</ol>
@stop

@section('main')

	@if ($currentUser->hasRole('Admin') || $currentUser->can('add_roomtype'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Raumtyp hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">  	
			<div  class="table-responsive">
		       	<table class="table table-striped table-condensed" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Raumtypname</th>
		       				<th>Beschreibung</th>
		       				<th>Option</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $roomtypes as $roomtype )
				
							<tr>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') || $currentUser->can('edit_roomtype'))
		    							{{ link_to_route('editRoomtypeInformation_path', $roomtype->name, $roomtype->id) }}
		    						@else
		    							{{ $roomtype->name }}
		    						@endif
		    					</td>
		    					<td>{{ $roomtype->description }}</td>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') || $currentUser->can('delete_roomtype'))
			    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteRoomtype_path', $roomtype->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Raumtyp löschen', 'data-message' => 'Wollen Sie den Raumtyp wirklich löschen?')) }}
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
	@include('roomtypes.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
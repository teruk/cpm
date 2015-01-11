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
	  <li class="active">Raummanagement</li>
	</ol>
@stop

@section('main')

	@if ($currentUser->hasRole('Admin') || $currentUser->can('add_room'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Raum hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div  class="table-responsive">
		       	<table class="table table-striped table-condensed" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Raumname</th>
		       				<th>Ort</th>
		       				<th>Sätze</th>
		       				<th>Typ</th>	
		       				<th>Beamer</th>
		       				<th>Tafel</th>
		       				<th>OHP</th>
		       				<th>Behindertengerecht</th>
		       				<th>Optionen</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $rooms as $room )
				
							<tr>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') || $currentUser->can('add_room'))
		    							{{ link_to_route('editRoomInformation_path', $room->name, $room->id) }}
		    						@else
		    							{{ $room->name }}
		    						@endif
		    					</td>
		    					<td>{{ $room->location }}</td>
		    					<td>{{ $room->seats }}</td>
		    					<td>{{ $listofroomtypes[$room->roomtype_id] }}</td>
		    					@if ($room->beamer)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		    					@if ($room->blackboard)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		    					@if ($room->overheadprojector)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		    					@if ($room->accessible)
		    						<td>ja</td>
		    					@else
		    						<td>nein</td>
		    					@endif
		    					<td>
		    						@if ($currentUser->hasRole('Admin') || $currentUser->can('delete_room'))
			    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteRoom_path', $room->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Raum löschen', 'data-message' => 'Wollen Sie den Raum wirklich löschen?')) }}
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
	@include('rooms.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
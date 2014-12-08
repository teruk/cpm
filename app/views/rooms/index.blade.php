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
<!-- 	<h2>Raummanagement 
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h2> -->

	@if (Entrust::hasRole('Admin') || Entrust::can('add_room'))
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
		    					<td><a href="{{ route('rooms.show', $room->id) }}">{{ $room->name }}</a></td>
		    					<td>{{ $room->location }}</td>
		    					<td>{{ $room->seats }}</td>
		    					<td>{{ $listofroomtypes[$room->room_type_id] }}</td>
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
		    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('rooms.destroy', $room->id))) }}
										{{ HTML::decode(link_to_route('rooms.show', '<i class="glyphicon glyphicon-edit"></i>', array($room->id), array('class' => 'btn btn-xs btn-warning'))) }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Raum löschen', 'data-message' => 'Wollen Sie den Raum wirklich löschen?')) }}
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
	@include('rooms.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
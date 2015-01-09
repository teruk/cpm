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
	  <li class="active">Lehrveranstaltungstypenmanagement</li>
	</ol>
@stop

@section('main')
	<!-- <h3>Lehrveranstaltungstypenmanagement 
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h3> -->

	@if ($currentUser->hasRole('Admin') OR $currentUser->can('add_coursetype'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Lehrveranstaltungstyp hinzufügen'])
	@endif
    
    <div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">   	
			<div  class="table-responsive">
		       	<table class="table table-striped" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Lehrveranstaltungstyp</th>
		       				<th>Kurz</th>
		       				<th>Beschreibung</th>
		       				<th>Option</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $coursetypes as $coursetype )
				
							<tr>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_coursetype'))
		    							{{ link_to_route('editCoursetypeInformation_path', $coursetype->name, $coursetype->id) }}
		    						@else
		    							{{ $coursetype->name }}
		    						@endif
		    					</td>
		    					<td>{{ $coursetype->short }}</td>
		    					<td>{{ $coursetype->description }}</td>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') OR $currentUser->canEdit('delete_coursetype'))
			    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteCoursetype_path', $coursetype->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Lehrveranstaltungstyp löschen', 'data-message' => 'Wollen Sie den Lehrveranstaltungstyp wirklich löschen?')) }}
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

	<!-- add form Modal dialog -->
	@include('coursetypes.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
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
	  <li class="active">Rollenmanagement</li>
	</ol>
@stop

@section('main')
<!-- 	<h3>Rollenmanagement
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h3> -->

	@if ($currentUser->hasRole('Admin') OR $currentUser->can('add_role'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Rolle hinzufügen'])
	@endif
	    	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div  class="table-responsive">
		       	<table class="table table-striped" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Name</th>
		       				<th>Beschreibung</th>
		       				<th>Optionen</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $roles as $role )
				
							<tr>
		    					<td>
		    						@if (($currentUser->hasRole('Admin') OR $currentUser->can('add_role')) AND $role->name != 'Admin')
		    							{{ link_to_route('editRoleInformation_path', $role->name, $role->id) }}
		    						@else
		    							{{ $role->name }}
		    						@endif
		    					</td>
		    					<td>{{ $role->description }}</td>
		    					<td>
		    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteRole_path', $role->id))) }}
		    						@if ($role->name != "Admin")
			    						@if ($currentUser->can('delete_role') OR $currentUser->hasRole('Admin'))
			        						{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Rolle löschen', 'data-message' => 'Wollen Sie die Rolle wirklich löschen?')) }}
			        					@endif
			        				@endif
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
	@include('roles.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
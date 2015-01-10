@extends('layouts.main')

@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#data_table').dataTable({
				"pagingType": "full",
				"displayLength": 50
			});

			$('div.dataTables_filter input').focus()
		} );
	</script>
	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Berechtigungsmanagement</li>
	</ol>
@stop

@section('main')
	<div class="alert alert-dismissable alert-danger">
	  	<h4>Hinweis!</h4>
	  	<p>Vorsicht bei Änderungen. Sollten nur von geschultem Personal vorgenommen werden.</p>
	</div>
<!-- 	<h3>Berechtigungsmanagement
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h3> -->

	@if ($currentUser->hasRole('Admin') || $currentUser->can('add_permission'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Berechtigung hinzufügen'])
	@endif
	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div  class="table-responsive">
		       	<table class="table table-striped" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Anzeigename</th>
		       				<th>Name</th>
		       				<th>Beschreibung</th>
		       				<th>Optionen</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $permissions as $perm )
							<tr>
								<td>
									@if ($currentUser->can('edit_permission') || $currentUser->hasRole('Admin'))
										{{ link_to_route('editPermissionInformation_path', $perm->display_name, $perm->id) }}
									@else
										{{ $perm->display_name }}
									@endif
								</td>
		    					<td>
		    						@if ($currentUser->can('edit_permission') || $currentUser->hasRole('Admin'))
		    							{{ link_to_route('editPermissionInformation_path', $perm->name, $perm->id) }}
		    						@else
		    							{{ $perm->name }}
		    						@endif
		    					</td>
		    					<td>{{ $perm->description }}</td>
		    					<td>
		    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deletePermission_path', $perm->id))) }}
			    						@if ($currentUser->can('delete_permission') || $currentUser->hasRole('Admin'))
			        						{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Berechtigung löschen', 'data-message' => 'Wollen Sie die Berechtigung wirklich löschen?')) }}
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

	<!-- add form Modal dialog -->
	@include('permissions.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
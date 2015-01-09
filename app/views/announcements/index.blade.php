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
	  <li class="active">Ankündigungen</li>
	</ol>
@stop

@section('main')
	<!-- <h3>Ankündigungsmanagement 
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h3> -->

	@if ($currentUser->hasRole('Admin') OR $currentUser->can('add_announcement'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Ankündigung hinzufügen'])
	@endif
	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">       	
			<div  class="table-responsive">
		       	<table class="table table-striped" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Betreff</th>
		       				<th>Inhalt</th>
		       				<th>Erstellt am</th>
		       				<th>Option</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $announcements as $announcement )
				
							<tr>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_announcement'))
		    							{{ link_to_route('editAnnouncementInformation_path', $announcement->subject, $announcement->id) }}
		    						@else
		    							{{ $announcement->subject }}
		    						@endif
		    					</td>
		    					<td>{{ $announcement->read_more }}</td>
		    					<td>{{ date('d.m.Y', strtotime($announcement->created_at)) }}</td>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') OR $currentUser->can('delete_announcement'))
			    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteAnnouncement_path', $announcement->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Ankündigung löschen', 'data-message' => 'Wollen Sie die Ankündigung wirklich löschen?')) }}
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
	@include('announcements.partials.add-form')

	<!-- delete confirmation dialog -->
	@include('layouts.partials.delete_confirm')
@stop
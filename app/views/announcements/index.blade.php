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

	@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Ankündigung hinzufügen'])
	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">       	
			<div  class="table-responsive">
		       	<table class="table table-striped" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Betreff</th>
		       				<th>Inhalt</th>
		       				<th>Erstellt am</th>
		       				<th>Optionen</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $announcements as $a )
				
							<tr>
		    					<td>{{ link_to_route('showAnnouncement_path', $a->subject, $a->id) }}</td>
		    					<td>{{ $a->read_more }}</td>
		    					<td>{{ date('d.m.Y', strtotime($a->created_at)) }}</td>
		    					<td>
		    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteAnnouncement_path', $a->id))) }}
										{{ HTML::decode(link_to_route('showAnnouncement_path', '<i class="glyphicon glyphicon-edit"></i>', array($a->id), array('class' => 'btn btn-xs btn-warning'))) }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Ankündigung löschen', 'data-message' => 'Wollen Sie die Ankündigung wirklich löschen?')) }}
									{{ Form::close() }}
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
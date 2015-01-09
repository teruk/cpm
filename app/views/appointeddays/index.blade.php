@section('scripts')
	@include ('layouts.partials.datatables-script')
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
	  <li class="active">Termine</li>
	</ol>
@stop

@section('main')
	<!-- <h3>Terminmanagement 
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h3> -->

	@if ($currentUser->hasRole('Admin') OR $currentUser->can('add_appointedday'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Termin hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">	       	
			<div  class="table-responsive">
		       	<table class="table table-striped" id="data_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Betreff</th>
		       				<th>Inhalt</th>
		       				<th>Datum</th>
		       				<th>Option</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $appointeddays as $appointedday )
							<tr>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_appointedday'))
		    							<a href="{{ route('editAppointeddayInformation_path', $appointedday->id) }}">{{ $appointedday->subject }}</a>
		    						@else
		    							{{ $appointedday->subject }}
		    						@endif
		    					</td>
		    					<td>{{ $appointedday->read_more }}</td>
		    					<td>{{ date('d.m.Y', strtotime($appointedday->date)) }}</td>
		    					<td>
		    						@if ($currentUser->hasRole('Admin') OR $currentUser->can('delete_appointedday'))
			    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteAppointedday_path', $appointedday->id))) }}
											{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Termin löschen', 'data-message' => 'Wollen Sie den Termin wirklich löschen?')) }}
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
	@include('appointeddays.partials.add-form')

	<!-- delete form dialog -->
	@include('layouts.partials.delete_confirm')
@stop
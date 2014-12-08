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
	  <li class="active">Turnusmanagement</li>
	</ol>
@stop

@section('main')
<!-- 	<h2>Turnusmanagement 
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h2> -->

	@if (Entrust::hasRole('Admin') || Entrust::can('add_rotation'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Turnus hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div  class="table-responsive">
	           	<table class="table table-striped table-condensed" id="section_table" cellspacing="0">
	           		<thead>
	           			<tr>
	           				<th>Turnusname</th>
	           				<th>Optionen</th>
	           			</tr>
	           		</thead>
	           		<tbody>
						@foreach( $rotations as $rotation )
				
							<tr>
	        					<td><a href="{{ route('rotations.show', $rotation->id) }}">{{ $rotation->name }}</a></td>
	        					<td>
	        						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('rotations.destroy', $rotation->id))) }}
										{{ HTML::decode(link_to_route('rotations.show', '<i class="glyphicon glyphicon-edit"></i>', array($rotation->id), array('class' => 'btn btn-xs btn-warning'))) }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Turnus löschen', 'data-message' => 'Wollen Sie den Turnus wirklich löschen?')) }}
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
	@include('appointeddays.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
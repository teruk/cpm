<!--  scripts -->
@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#turn_table').dataTable({
				"pagingType": "full"
			});
			$('div.dataTables_filter input').focus()
		} );
	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

<!-- breadcrumbs  -->
@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Semestermanagement</li>
	</ol>
@stop

<!-- main content -->
@section('main')
<!-- 	<h2>Semestermanagement
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h2> -->

	@if (Entrust::hasRole('Admin') || Entrust::can('add_turn'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Semester hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="turn_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>Semester</th>
		                  <th>Semesterbeginn</th>
		                  <th>Semesterende</th>
		                  <th>Optionen</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $turns as $turn )
							<tr>
								<td>{{ link_to_route('showTurn_path', $turn->present(), $turn->id) }}</td>
								<td>{{ $turn->semester_start }}</td>
								<td>{{ $turn->semester_end }}</td>
								<td>
									{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteTurn_path', $turn->id))) }}
										{{ HTML::decode(link_to_route('showTurn_path', '<i class="glyphicon glyphicon-edit"></i>', array($turn->id), array('class' => 'btn btn-xs btn-warning'))) }}

										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Semester löschen', 'data-message' => 'Wollen Sie das Semester wirklich löschen?')) }}
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
	@include('turns.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
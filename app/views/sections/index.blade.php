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
	  <li class="active">Bereichsmanagement</li>
	</ol>
@stop

@section('main')
	<!-- <h2>Bereichsmanagement 
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h2> -->

	@if (Entrust::hasRole('Admin') || Entrust::can('add_section'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Bereich hinzufügen'])
	@endif

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div  class="table-responsive">
		       	<table class="table table-striped table-condensed" id="section_table" cellspacing="0">
		       		<thead>
		       			<tr>
		       				<th>Bereichsname</th>
		       				<th>Optionen</th>
		       			</tr>
		       		</thead>
		       		<tbody>
						@foreach( $sections as $section )
							<tr>
		    					<td> {{ link_to_route('showSection_path', $section->name, $section->id) }}</td>
		    					<td>
		    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteSection_path', $section->id))) }}
										{{ HTML::decode(link_to_route('showSection_path', '<i class="glyphicon glyphicon-edit"></i>', array($section->id), array('class' => 'btn btn-xs btn-warning'))) }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Bereich löschen', 'data-message' => 'Wollen Sie den Bereich wirklich löschen?')) }}
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
	@include('sections.partials.add-form')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
@extends('layouts.main')

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
	  <li class="active">Abschlussmanagement</li>
	</ol>
@stop

@section('main')
	<!-- <h2>Abschlussmanagement 
		<button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
	</h2> -->

	@if (Entrust::hasRole('Admin') || Entrust::can('add_degree'))
		@include('layouts.partials.add-button-modal', ['buttonLabel' => 'Abschluss hinzufügen'])
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
						@foreach( $degrees as $degree )
				
							<tr>
		    					<td>
		    						@if (Entrust::hasRole('Admin') || Entrust::can('add_degree'))
		    							{{ link_to_route('editDegreeInformation_path', $degree->name, $degree->id) }}
		    						@else
		    							{{ $degree->name }}
		    						@endif
		    					</td>
		    					<td>
		    						@if (Entrust::hasRole('Admin') || Entrust::can('delete_degree'))
		    						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deleteDegree_path', $degree->id))) }}
										{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Abschluss löschen', 'data-message' => 'Wollen Sie den Abschluss wirklich löschen?')) }}
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

	<!-- add form Modal dialog-->
	@include('degrees.partials.add-form')

	<!-- delete confirm modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
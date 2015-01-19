@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
    	$('#module_table').dataTable({
    		"pagingType": "full",
    		"displayLength": -1,
    		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]]
    	});
    } );

	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
		<li class="active">Studiengänge</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="degreecourse_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>Studiengang</th>
		                  <th>Kurz</th>
		                  <th>Fachbereich</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $specialistregulations as $specialistregulation )
							<tr>
								<td>
									{{ link_to_route('showOverviewSelectedDegreecourse_path', $specialistregulation->present(), $specialistregulation->id) }}
								<td>{{ $specialistregulation->presentShort() }}</td>
								<td>{{ $specialistregulation->degreecourse->department->name }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
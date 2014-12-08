@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
		    var table = $('#data_table').DataTable({
		        "columnDefs": [
		            { "visible": false, "targets": 1 }
		        ],
		        "order": [[ 1, 'asc' ]],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
		        "pagingType": "full",
		        "displayLength": -1,
		        "drawCallback": function ( settings ) {
		            var api = this.api();
		            var rows = api.rows( {page:'current'} ).nodes();
		            var last=null;
		 
		            api.column(1, {page:'current'} ).data().each( function ( group, i ) {
		                if ( last !== group ) {
		                    $(rows).eq( i ).before(
		                        '<tr class="info"><td colspan="3">'+group+'</td></tr>'
		                    );
		 
		                    last = group;
		                }
		            } );
		        }
		    } );
 
		    // Order by the grouping
		    $('#data_table tbody').on( 'click', 'tr.info', function () {
		        var currentOrder = table.order()[0];
		        if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
		            table.order( [ 1, 'desc' ] ).draw();
		        }
		        else {
		            table.order( [ 1, 'asc' ] ).draw();
		        }
		    } );
		} );

	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
		<li class="active">Mitarbeiter</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="data_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>Mitarbeiter</th>
		                  <th>Arbeitsbereich</th>
		                  <th>am Fachbereich seit</th>
		                  <th>am Fachbereich?</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $employees as $employee )
							<tr>
								<td><a href="{{ route('overview.employee',$employee->id) }}">{{ $employee->title }} {{ $employee->firstname }} {{ $employee->name }}</a></td>
								<td>{{ $employee->researchgroup->name }} ({{ $employee->researchgroup->short}})</td>
								<td>{{ date('d.m.Y', strtotime($employee->employed_since)) }}</td>
								<td>
									@if ($employee->inactive == 0)
										ja
									@else
										nein
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
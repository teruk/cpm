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
		                        '<tr class="info"><td colspan="7">'+group+'</td></tr>'
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
		<li class="active">Lehrveranstaltungen</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">

			<table class="table table-striped table-condensed" id="data_table">
				<thead>
					<tr>
	        			<th colspan="7">Lehrveranstaltungsinformationen:</th>
	        		</tr>
					<tr>
		                <th>LV-Nr.</th>
		                <th>Modul</th>
		                <th>Titel / engl. Titel</th>
		                <th>Typ</th>
		                <th>Teilnehmer</th>
		                <th>SWS</th>
		                <th>Sprache</th>
	                </tr>
	          	</thead>
	          	<tbody>
					@foreach( $courses as $course )
						<tr>
							<td>{{ $course->course_number }}</td>
							<td>{{ link_to_route('showOverviewSelectedModule_path', $course->module->short, $course->module_id) }}</td>
							<td>{{ HTML::decode(link_to_route('showOverviewSelectedCourse_path', $course->name.'<br>'. $course->name_eng, $course->id)) }}  </td>
							<td>{{ $course->coursetype->name }}</td>
							<td>{{ $course->participants }}</td>
							<td>{{ $course->semester_periods_per_week }}</td>
							<td>{{ Config::get('constants.language')[$course->language] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop
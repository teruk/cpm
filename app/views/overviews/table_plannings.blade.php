@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">


		$(document).ready(function() {
		    var table = $('#data_table').DataTable({
		        "columnDefs": [
		            { "visible": false, "targets": 0 }
		        ],
		        "order": [[ 0, 'asc' ]],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
		        "pagingType": "full",
				"ordering":	false,
		        "displayLength": -1,
		        "drawCallback": function ( settings ) {
		            var api = this.api();
		            var rows = api.rows( {page:'current'} ).nodes();
		            var last=null;
		 
		            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
		                if ( last !== group ) {
		                    $(rows).eq( i ).before(
		                        '<tr class="info"><td colspan="6">'+group+'</td></tr>'
		                    );
		 
		                    last = group;
		                }
		            } );
		        }
		    } );
 
		    // Order by the grouping
		    $('#data_table tbody').on( 'click', 'tr.group', function () {
		        var currentOrder = table.order()[0];
		        if ( currentOrder[0] === 0 && currentOrder[1] === 'asc' ) {
		            table.order( [ 0, 'desc' ] ).draw();
		        }
		        else {
		            table.order( [ 0, 'asc' ] ).draw();
		        }
		    } );
		} );
	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
	    <li class="active">Aufstellung Lehrveranstaltungen</li>
	    <li class="active">{{ $turnNav['displayTurn']->present() }}</li>
	</ol>
@stop

@section('main')
	<h4>Lehrveranstaltungsaufstellung sortiert nach LV-Nummern {{ $turnNav['displayTurn']->present() }}</h4>
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			@include('layouts.partials.nav-turn-selection', ['route' => 'showPlanningsOrderByCourseNumber_path'])
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="table-responsive">
		        <table class="table table-condensed table-striped" id="data_table" cellspacing="0">
		        	<thead>
		                <tr>
		                	<th>Modul</th>
		                	<th>LVNr</th>
		                	<th>Gr* SWS</th>
		                	<th>Veranstaltung</th>
		                	<th>Bemerkung</th>
		                	<th>Status</th>
		                </tr>
		          	</thead>
		          	<tbody>
		          		@foreach ($plannings as $p)
		          			<tr>
		          				<td>{{ $p->course->module->short }} {{ $p->course->module->name }}</td>
		          				<td>
		          					{{ $p->course_number }}<br>
		          					{{ $p->course->coursetype->short }}
		          				</td>
		          				<td>{{ $plannings_data[$p->course_id]['groups'] }} * {{ $p->course->semester_periods_per_week }}</td>
		          				<td>
		          					{{ $plannings_data[$p->course_id]['groups'] * $p->course->semester_periods_per_week }} SWS {{ $p->course_title }}<br><br>
		          					@foreach($plannings_data[$p->course_id]['employees'] as $e)
		          						{{ $e['semester_periods_per_week'] }} SWS {{ $e['employee']->firstname }} {{ $e['employee']->name }} ({{ $e['employee']->researchgroup->short }})<br>
		          					@endforeach
		          				</td>
		          				<td>
		          					Sprache: {{ Config::get('constants.language')[$p->language] }}<br>
		          					{{ $p->comment }}
		          				</td>
		          				<td>
			          				AB: {{ Config::get('constants.pl_rgstatus')[$p->researchgroup_status] }}<br>
			          				VS: {{ Config::get('constants.pl_board_status')[$p->board_status] }}
			          			</td>
		          			</tr>
		          		@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
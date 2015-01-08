@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
		    var table = $('#data_table').DataTable({
		        "columnDefs": [
		            { "visible": false, "targets": 0 }
		        ],
		        "order": [[ 0, 'desc' ]],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
		        "pagingType": "full",
		        "displayLength": -1,
		        "drawCallback": function ( settings ) {
		            var api = this.api();
		            var rows = api.rows( {page:'current'} ).nodes();
		            var last=null;
		 
		            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
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
		<li>{{ link_to_route('showOverviewEmployees_path', 'Mitarbeiter') }}</li>
		<li class="active">{{ $employee->present() }} ({{ $employee->researchgroup->short}})</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>Mitarbeiter</th>
		                  <th>Arbeitsbereich</th>
		                  <th>am Fachbereich seit</th>
		                  <th>am Fachbereich?</th>
		                </tr>
		          	</thead>
		          	<tbody>
							<tr>
								<td>{{ $employee->present() }}</td>
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
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed" id="data_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>Semester</th>
		                  <th>Modul</th>
		                  <th>LV-Nr.</th>
		                  <th>LV-Typ</th>
		                  <th>Lehrveranstaltung</th>
		                  <th>Gruppe</th>
		                  <th>SWS</th>
		                </tr>
		          	</thead>
		          	<tbody>
		          		@foreach ($employee->plannings as $planning)
							<tr>
								<td>{{ $planning->turn->present() }}</td>
								<td>
									{{ link_to_route('showOverviewSelectedModule_path', $planning->course->module->short, $planning->course->module_id) }}
								</td>
								<td>{{ $planning->course_number }}</td>
								<td>{{ $listofcoursetypes[$planning->course->coursetype_id] }}</td>
								<td>
									{{ HTML::decode( link_to_route('showOverviewSelectedCourse_path', $planning->course_title.'<br>'.$planning->course_title_eng, $planning->course_id)) }}
								</td>
								<td>{{ $planning->group_number }}</td>
								<td>{{ $planning->pivot->semester_periods_per_week }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
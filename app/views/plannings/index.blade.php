@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
		    var table = $('#example').DataTable({
		        "columnDefs": [
		            { "visible": false, "targets": 3 }
		        ],
		        "order": [[ 3, 'asc' ]],
		        "pagingType": "full",
		        "displayLength": 50,
		        "drawCallback": function ( settings ) {
		            var api = this.api();
		            var rows = api.rows( {page:'current'} ).nodes();
		            var last=null;
		 
		            api.column(3, {page:'current'} ).data().each( function ( group, i ) {
		                if ( last !== group ) {
		                    $(rows).eq( i ).before(
		                        '<tr class="info"><td colspan="9">'+group+'</td></tr>'
		                    );
		 
		                    last = group;
		                }
		            } );
		        }
		    } );
 
		    // Order by the grouping
		    $('#example tbody').on( 'click', 'tr.info', function () {
		        var currentOrder = table.order()[0];
		        if ( currentOrder[0] === 3 && currentOrder[1] === 'asc' ) {
		            table.order( [ 3, 'desc' ] ).draw();
		        }
		        else {
		            table.order( [ 3, 'asc' ] ).draw();
		        }
		    } );
		} );

	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li class="active">Semesterplanung</li>
	  <li class="active">{{ $turnNav['displayTurn']->present() }}</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<h4>Semesterplanung {{ $turnNav['displayTurn']->present() }}</h4>

			@include('layouts.partials.nav-turn-selection', ['route' => 'showTurnPlannings_path'])
		</div>

		@include('plannings.partials.nav-options')
	</div>

	<div class="row">
		<div class="col-sm-12">
			       	
				<div  class="table-responsive">
		           	<table class="table table-striped table-condensed" id="example" cellspacing="0">
		           		<thead>
		           			<tr>
		           				<th>Nummer</th>
		           				<th>Typ</th>
		           				<th>Titel</th>
		           				<th>Modul</th>
		           				<!-- <th>TN</th> -->
		           				<th>Grp.</th>
		           				<th>Sprache</th>
		           				<th>AB</th>
		           				<th>VS</th>
		           				<th>Bemerkung</th>
		           				<th>Optionen</th>
		           			</tr>
		           		</thead>
		           		<tbody>
							@foreach( $planned_courses as $planning )
								<tr>
									<td>{{ $planning->course_number }}</td>
									<td>{{ $listofcoursetypes[$planning->course->coursetype_id] }}</td>
		        					<td><a href="{{ route('editPlanningInformation_path', array($turnNav['displayTurn']->id,$planning->id)) }}">{{$planning->course_title }}</a></td>
		        					<td>{{ $planning->course->module->short }}</td>
		        					<!-- <td>{{ $planning->course->participants }}</td> -->
		        					<td>{{ $planning->group_number }}</td>
		        					<td>{{ Config::get('constants.language')[$planning->language] }}</td>
		        					<td>{{ Config::get('constants.pl_rgstatus')[$planning->researchgroup_status] }}</td>
		        					<td>{{ Config::get('constants.pl_board_status')[$planning->board_status] }}</td>
		        					<td>{{ $planning->comment }}</td>
		        					
		        					<td>
		        						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('deletePlanning_path', $turnNav['displayTurn']->id, $planning->id))) }}
		        						{{ HTML::decode(link_to_route('editPlanningInformation_path', '<i class="glyphicon glyphicon-edit"></i>', array($turnNav['displayTurn']->id, $planning->id), array('class' => 'btn btn-xs btn-warning', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Planung bearbeiten'))) }}
		        						@if ($currentUser->id == $planning->user_id || $currentUser->can('delete_planning') || $currentUser->hasRole('Admin'))
			        						{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'button', 'class' => 'btn btn-xs btn-danger', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Planung löschen', 'data-message' => 'Wollen Sie die Planung wirklich löschen?')) }}
			        					@endif
			        					{{ Form::close() }}
		        					</td>
								</tr>
							
							@endforeach	
						</tbody>
					</table>
				</div>	
		</div>
	</div>

	<!-- collection of modal dialogs -->
	@include('plannings.partials.add-form-modal-collection')

	<!-- delete confirmation modal dialog -->
	@include('layouts.partials.delete_confirm')
@stop
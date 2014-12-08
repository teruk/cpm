@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

	$(document).ready(function() {
	    var table = $('#example').DataTable({
	        "columnDefs": [
	            { "visible": false, "targets": 4 }
	        ],
	        "order": [[ 4, 'asc' ]],
	        "displayLength": 50,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
	        "drawCallback": function ( settings ) {
	            var api = this.api();
	            var rows = api.rows( {page:'current'} ).nodes();
	            var last=null;
	 
	            api.column(4, {page:'current'} ).data().each( function ( group, i ) {
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
	            table.order( [ 4, 'desc' ] ).draw();
	        }
	        else {
	            table.order( [ 4, 'asc' ] ).draw();
	        }
	    } );

	    $('div.dataTables_filter input').focus()
	} );
	</script>
	
	@include('layouts.partials.select-checkbox')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('plannings')}}">Semesterplanung</a></li>
	  <li><a href="{{ URL::route('plannings.indexTurn', $turn->id)}}">{{ $turn->name }} {{ $turn->year }}</a></li>
	  <li class="active">Lehreranstaltungen kopieren</li>
	</ol>
@stop

@section('main')
	<h4>Semesterplanung {{ $turn->name }} {{ $turn->year }} - Lehrveranstaltungen übernehmen</h4>
	{{ Form::model(new Planning, ['route' => ['plannings.copyselected', $turn->id], 'class' => "form-horizontal"])}}
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-12 well well-sm">
			<div class="col-lg-2">
                {{ Form::label('employees', 'Verantwortl.:', array('class' => " control-label", 'id' => "employees")) }}
                {{ Form::input('checkbox','employees', 1, array('id' => "employees"))}}
            </div>
            <div class="col-sm-2">
                {{ Form::label('comments', 'Bemerkungen:', array('class' => " control-label", 'id' => "comments")) }}
                {{ Form::input('checkbox','comments', 1, array('id' => "comments"))}}
            </div>
            <div class="col-sm-2">
                {{ Form::label('room_preferences:', 'Raumwünsche:', array('class' => " control-label", 'id' => "room_preferences")) }}
                {{ Form::input('checkbox','room_preferences', 1, array('id' => "room_preferences"))}}
            </div>
			<div class="col-sm-2">
				{{ Form::button('<i class="glyphicon glyphicon-repeat"></i> LVs kopieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-copy')) }}
			</div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-link btn-sm" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Sollen Verantwortliche, Bemerkungen und Raumwünsche mitkopiert werden, dann kreuzen Sie bitte links die entsprechenden Optionen an." data-original-title="" title="" aria-describedby="popover55776">
					<span class="glyphicon glyphicon-question-sign"></span>
				</button>
			</div>
			</div>
        </div>
	</div>

	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
	            {{ Form::button('<i class="glyphicon glyphicon-check"></i> Alle LVs auswählen', array('type' => 'button', 'class' => 'btn btn-sm btn-default check')) }}
	            {{ Form::button('<i class="glyphicon glyphicon-unchecked"></i> Auswahl aufheben', array('type' => 'button', 'class' => 'btn btn-sm btn-default uncheck')) }}
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-sm-12">        	
			<div  class="table-responsive">
	           	<table class="table table-striped table-condensed" id="example" cellspacing="0">
	           		<thead>
	           			<tr>
	           				<th></th>
	           				<th>Nummer.</th>
	           				<th>Titel</th>
	           				<th>Typ</th>
	           				<th>Modul</th>
	           				<th>Semester</th>
	           				<th>Grp.</th>
	           				<th>Lehrende</th>
	           				<th>Status</th>
	           				<th>Bemerkung</th>
	           			</tr>
	           		</thead>
	           		<tbody>
						@foreach( $plannings as $planning )
							<tr>
								<td>{{ Form::checkbox('selected[]', $planning->id, false, array('class' => "selectCheckBox")) }}</td>
								<td>{{ $planning->course_number }}</td>
	        					<td>{{ $planning->course_title }}</td>
	        					<td>{{ $listofcoursetypes[$planning->course->course_type_id] }}</td>
	        					<td>{{ $planning->course->module->short }}</td>
	        					<td>{{ $planning->turn->name }} {{ $planning->turn->year }}</td>
	        					<td>{{ $planning->group_number }}</td>
	        					<td>
	        						@foreach ($planning->employees as $e)
	        							{{ $e->firstname}} {{ $e->name}} ({{ $e->pivot->semester_periods_per_week }} SWS)<br>
	        						@endforeach
	        					</td>
	        					<td>
	        						AB: {{ Config::get('constants.pl_rgstatus')[$planning->researchgroup_status] }}<br>
	        						VS: {{ Config::get('constants.pl_board_status')[$planning->board_status] }}
	        					</td>
	        					<td>{{ $planning->comment }}</td>
							</tr>
						@endforeach	
					</tbody>
				</table>
			</div>
		</div>
	</div>
	{{ Form::close() }}
@stop
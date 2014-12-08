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
	                        '<tr class="info"><td colspan="8">'+group+'</td></tr>'
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
	  <li class="active">Status aktualisieren</li>
	</ol>
@stop

@section('main')
	<h4>Semesterplanung {{ $turn->name }} {{ $turn->year }} - Status ändern</h4>
	{{ Form::model(new Planning, ['route' => ['plannings.updateStatus', $turn->id]])}}
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-12 well well-sm">
			<div class="form-group-sm">
	                {{ Form::label('board_status', 'VS:', array('class' => "col-xs-1 control-label", 'id' => "board_status")) }}
	            <div class="col-xs-3">
	                {{ Form::select('board_status', Config::get('constants.pl_board_status'), '', array('id' => "board_status", 'class' => "form-control input-sm"))}}
	            </div>
            </div>
			<div class="form-group-sm">
            		{{ Form::label('researchgroup_status', 'AB:', array('class' => "col-xs-1 control-label", 'id' => "researchgroup_status")) }}
	            <div class="col-sm-3">
	                {{ Form::select('researchgroup_status', Config::get('constants.pl_rgstatus'), '', array('id' => "researchgroup_status", 'class' => "form-control input-sm")) }}
	            </div>
	        </div>
	        <div class="form-group-sm">
		        <div class="col-sm-2">
					{{ Form::button('<i class="glyphicon glyphicon-refresh"></i> Status aktualisieren', array('type' => 'submit', 'class' => 'btn btn-sm btn-primary')) }}
				</div>
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
	           				<th>TN</th>
	           				<th>Grp.</th>
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
	        					<td>{{ $planning->course->participants }}</td>
	        					<td>{{ $planning->group_number }}</td>
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
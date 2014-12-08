@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{ url('css/dataTables.bootstrap.css')}}">
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery-1.10.2.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/dataTables.bootstrap.js')}}"></script>
	<script type="text/javascript" class="init">
	
$(document).ready(function() {
	$('#data_table').dataTable({
		"pagingType": "full"
	});
} );

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
                        '<tr class="group"><td colspan="9">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
 
    // Order by the grouping
    $('#example tbody').on( 'click', 'tr.group', function () {
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
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('plannings')}}">Semesterplanung</a></li>
	  <li class="active">{{ $turn->name }} {{ $turn->year }}</li>
	</ol>
@stop

@section('main')
	<h3>Semesterplanung {{ $turn->name }} {{ $turn->year }}</h3>
	<div class="row">
	  <div class="col-xs-2">
	    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
	  	<span class="glyphicon glyphicon-plus"></span>
		</button>
		Neue LV planen
	  </div>
	  <div class="col-xs-3">
	  	{{HTML::decode(link_to_route('plannings.showall', '<i class="glyphicon glyphicon-list-alt"></i>', array($turn->id) , array('class' => 'btn btn-xs btn-default')))}}
		Einzelne LV kopieren
	  </div>
	  <div class="col-xs-3">
	  	{{ Form::model($turn, ['method' => 'PATCH', 'route' => ['plannings.generateFromMediumtermplanning',$turn->id]]) }}
	  	{{ Form::button('<i class="glyphicon glyphicon-time"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-default')) }}
<!-- 	  	{{HTML::decode(link_to_route('plannings.showall', '<i class="glyphicon glyphicon-time"></i>', array($turn->id) , array('class' => 'btn btn-xs btn-default')))}} -->
		LV aus mittelfristiger Lehrplanung generieren
		{{ Form::close() }}
	  </div>
	  <div class="col-xs-3">
	    @if ( $pastcourses > 0 )
			{{ Form::model(new Turn, ['route' => ['plannings.copylastturn',$turn->id]])}}
			{{ Form::button('<i class="glyphicon glyphicon-repeat"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-info')) }}
			 alle LV aus {{ $turn->name }} {{ $turn->year-1 }} kopieren
			{{ Form::close() }}
		@endif
	  </div>
	</div>
	<p>
		
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	<div class="modal-dialog">
	    	<div class="modal-content">
	      		<div class="modal-body">
	        		{{ Form::model(new Planning, ['route' => ['plannings.store',$turn->id], 'class' => "form-horizontal"])}}
	        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	        		<fieldset>
	        			<legend>Neue Lehrveranstaltung planen</legend>
	        			<div class="form-group">
	        				{{ Form::label('course_id', 'LV*:', array('class' => "col-lg-2 control-label", 'id' => "course_id")) }}
	        				<div class="col-lg-10">
	        					{{ Form::select('course_id', $selectedcourselist, 1, array('id' => "course_id", 'class' => "form-control input-sm")) }}
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				{{ Form::label('researchgroup_status', 'Status*:', array('class' => "col-lg-2 control-label", 'id' => "researchgroup_status")) }}
	        				<div class="col-lg-10">
	        					{{ Form::select('researchgroup_status', Config::get('constants.pl_rgstatus'), 0, array('id' => "researchgroup_status", 'class' => "form-control input-sm")) }}
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				{{ Form::label('version', 'Version*:', array('class' => "col-lg-2 control-label", 'id' => "version")) }}
	        				<div class="col-lg-10">
	        					{{ Form::select('version', Config::get('constants.pl_version'), 0, array('id' => "version", 'class' => "form-control input-sm")) }}
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				{{ Form::label('group_number', 'Gruppe:*:', array('class' => "col-lg-2 control-label", 'id' => "group_number")) }}
	        				<div class="col-lg-10">
	        					{{ Form::input('number', 'group_number', 1, array('min' => 1, 'id' => "group_number", 'class' => "form-control input-sm", 'required' => true)) }}
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				{{ Form::label('language', 'Sprache*:', array('class' => "col-lg-2 control-label", 'id' => "language")) }}
	        				<div class="col-lg-10">
	        					{{ Form::select('language', Config::get('constants.language'), 0, array('id' => "language", 'class' => "form-control input-sm"))}}
	        				</div>
	        			</div>
	        			<div class="form-group">
	        				{{ Form::label('comment', 'Bemerkung:', array('class' => "col-lg-2 control-label", 'id' => "comment")) }}
	        				<div class="col-lg-10">
	        					{{ Form::textarea('comment', '', array('id' => "comment", 'class' => "form-control input-sm", 'rows'=>2, 'style' => 'resize:none;')) }}
	        				</div>
	        			</div>
	        			<div class="form-group">
	      					<div class="col-lg-10 col-lg-offset-2" style="text-align: right">
	      					*erforderlich
	      					<button type="button" class="btn btn-danger" data-dismiss="modal">Abbrechen</button>
							{{ Form::submit('Erstellen', array('class' => 'btn btn btn-success')) }}
	      					</div>
	      				</div>
	        		</fieldset>
	        		{{ Form::close() }}
			
	      </div>
	    </div>
	  </div>
	</div>
		
	</p>
	@if ( sizeof($plannings) <= 0  )
		<p>Sie haben für das aktuelle Semester keine Semesterplanung vorgenommen.</p>
	@else         	
		<div  class="table-responsive">
           	<table class="table table-striped table-condensed" id="example" cellspacing="0">
           		<thead>
           			<tr>
           				<th>Nummer</th>
           				<th>Typ</th>
           				<th>Titel</th>
           				<th>Modul</th>
           				<th>TN</th>
           				<th>Grp.</th>
           				<th>Sprache</th>
           				<th>AB</th>
           				<th>Version</th>
           				<th>Optionen</th>
           			</tr>
           		</thead>
           		<tbody>
					@foreach( $plannings as $planning )
			
						<tr>
							<td>{{ $listofcourses[$planning->course_id]->course_number }}</td>
							<td>{{ $listofcoursetypes[$listofcourses[$planning->course_id]->course_type_id] }}</td>
        					<td><a href="{{ route('plannings.edit', array($turn->id,$planning->id)) }}">{{$listofcourses[$planning->course_id]->name }}</a></td>
        					<td>{{ $listofcourses[$planning->course_id]->module->short }}</td>
        					<td>{{ $listofcourses[$planning->course_id]->participants }}</td>
        					<td>{{ $planning->group_number }}</td>
        					<td>{{ Config::get('constants.language')[$planning->language] }}</td>
        					<td>{{ Config::get('constants.pl_rgstatus')[$planning->researchgroup_status] }}</td>
        					<td>{{ Config::get('constants.pl_version')[$planning->version] }}</td>
        					
        					<td>
        						{{ Form::open(array('class' => 'inline', 'method' => 'DELETE', 'route' => array('plannings.destroy', $turn->id, $planning->id))) }}
        						{{ HTML::decode(link_to_route('plannings.edit', '<i class="glyphicon glyphicon-edit"></i>', array($turn->id, $planning->id), array('class' => 'btn btn-xs btn-warning'))) }}        					
        						{{ Form::button('<i class="glyphicon glyphicon-remove"></i>', array('type' => 'submit', 'class' => 'btn btn-xs btn-danger')) }}
        						{{ Form::close() }}
        					</td>
						</tr>
					
					@endforeach	
				</tbody>
			</table>
		</div>			
	@endif
	
@stop
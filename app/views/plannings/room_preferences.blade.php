@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#data_table').dataTable({
                "displayLength": -1,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]],
				"pagingType": "full"
			});
		} );
	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Semesterplanung</li>
	    <li class="active">Übersicht Raumwünsche</li>
	    <li class="active">{{ $display_turn->name }} {{ $display_turn->year }}</li>
	</ol>
@stop

@section('main')
	<h4>Semesterplanung {{ $display_turn->name }} {{ $display_turn->year }} - Übersicht Raumwünsche</h4>
	
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			@include('layouts.partials.nav-turn-selection',['route'=>'plannings.showRoomPreference'])
		</div>

		<div class="col-sm-12">
			<div class="table-responsive">
		        <table class="table table-condensed table-striped" id="data_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  	<th>LLPB</th>
		                  	<th>Lehrveranstaltung</th>
		                  	<th>SWS</th>
		                  	<th>Raumwunsch</th>
		                </tr>
		          	</thead>
		          	<tbody>
		          		@foreach ($plannings as $pl)
			          		<tr>
			                  	<td>{{ $pl->user->name }}</td>
			                  	<td><a href="{{ route('plannings.edit', array($display_turn->id,$pl->id)) }}">{{ $pl->course_number }} {{ $pl->course_title}} ({{ $pl->course->module->short }})</a></td>
			                  	<td>{{ $pl->course->semester_periods_per_week }}</td>
			                  	<td>{{ nl2br($pl->room_preference) }}</td>
			                </tr>
		               	@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
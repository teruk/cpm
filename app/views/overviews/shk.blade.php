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
		<li class="active">Übersichten</li>
	    <li class="active">SHK-Bedarf</li>
	    <li class="active">{{ $display_turn->name }} {{ $display_turn->year }}</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12">
			<h4>SHK-Bedarf {{ $display_turn->name }} {{ $display_turn->year }}</h4>	
		</div>

		<div class="col-sm-12" style="margin-bottom: 5px;">
			@include('layouts.partials.nav-turn-selection', ['route' => 'overview.showShk'])
		</div>

		<div class="col-sm-12">
			<div class="col-sm-12 well">
				SHK-Bedarf für dieses Semester: {{ $semester_periods_per_week_total }} SWS
			</div>
		</div>

		<div class="col-sm-12">
			<div class="table-responsive">
		        <table class="table table-condensed table-striped" id="data_table" cellspacing="0">
		        	<thead>
		                <tr>
		                  	<th>Arbeitsbereich</th>
		                  	<th>Name</th>
		                  	<th>Lehrveranstaltung</th>
		                  	<th>Gruppe-Nr.</th>
		                  	<th>SWS</th>
		                </tr>
		          	</thead>
		          	<tbody>
		          		@foreach ($plannings as $pl)
		          			@foreach ($pl->employees as $e)
		          				@if ($e->firstname == "SHK")
					          		<tr>
					                  	<td>{{ $e->researchgroup->short }}</td>
					                  	<td>{{ $e->firstname}} {{ $e->name }}</td>
					                  	<td>{{ $pl->course_number}} {{ $pl->course_title }}</td>
					                  	<td>{{ $pl->group_number }}</td>
					                  	<td>{{ $e->pivot->semester_periods_per_week }}</td>
					                </tr>
					            @endif
				            @endforeach
		               	@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
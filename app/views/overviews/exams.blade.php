@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
			$('#data_table').dataTable({
				"pagingType": "full",
				"displayLength": 100,
				"paging": false,
				"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]]
			});
		} );

	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
	  	<li class="active">Prüfungen</li>
	  	<li class="active">{{ $display_turn->name }} {{ $display_turn->year }}</li>
	</ol>
@stop

@section('main')
	<h4>Übersicht Prüfungsformen der angebotene Module {{ $display_turn->name }} {{ $display_turn->year }}</h4>
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			@include('layouts.partials.nav-turn-selection', ['route' => 'overview.showExams'])
		</div>
	</div>

	<div class="row">
	 	<div class="col-sm-12">
			<div  class="table-responsive">
	           	<table class="table table-striped table-condensed" id="data_table" cellspacing="0">
	           		<thead>
	           			<tr>
	           				<th>Modul</th>
	           				<th>Prüfungsart</th>
	           			</tr>
	           		</thead>
	           		<tbody>
							@foreach( $display_turn->modules as $module )
								@if ($module->individual_courses == 0)
									<tr>
				    					<td><a href="{{ route('overview.module',$module->id) }}">{{ $module->short }} {{ $module->name }}</a></td>
				              			<td>{{ Config::get('constants.exam_type')[$module->pivot->exam] }}</td>
									</tr>
								@endif
							@endforeach	
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
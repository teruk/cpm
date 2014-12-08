@section('scripts')
	@include('layouts.partials.datatables-script')
	<script type="text/javascript" class="init">

		$(document).ready(function() {
    	$('#module_table').dataTable({
    		"pagingType": "full",
    		"displayLength": -1,
    		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Alle"]]
    	});
    } );

	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
		<li class="active">Module</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">

			<table class="table table-striped table-condensed table-hover" id="module_table">
				<thead>
					<tr>
	        			<th colspan="7">Modulinformationen:</th>
	        		</tr>
					<tr>
						<th>Kürzel</th>
						<th>Titel</th>
						<th>engl. Titel</th>
						<th>Fachbereich</th>
						<th>Niveau</th>
						<th>Sprache</th>
						<th>Abschluss</th>
						<th>Turnus</th>
						<th>LP</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($modules as $module)
						@if ($module->degree->name != "Bachelor")
							@if ($module->degree->name != "Master")
								<tr class="warning">
							@else
								<tr class="success">
							@endif
						@else
							<tr class="info">
						@endif
							<td>{{ $module->short }}</td>
							<td><a href="{{ route('overview.module', $module->id) }}">{{ $module->name }}</a></td>
							<td>{{ $module->name_eng }}</td>
							<td>{{ $module->department->name }}</td>
							<td>{{ $module->degree->name }}</td>
							<td>{{ Config::get('constants.language')[$module->language] }}</td>
							<td>{{ Config::get('constants.exam_type')[$module->exam_type] }}</td>
							<td>{{ $module->rotation->name }}</td>
							<td>{{ $module->credits }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop
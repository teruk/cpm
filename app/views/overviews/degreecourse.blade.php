@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
		<li><a href="{{ route('overview.degreecourses') }}">Studiengänge</a></li>
		<li class="active">{{ $degreecourse->degree->name }} {{ $degreecourse->name }}</li>
	</ol>
@stop

@section('main')
	<div class="row">
		<div class="col-sm-12" style="margin-bottom: 5px;">
			<div class="table-responsive">
		        <table class="table table-striped table-condensed table-hover" cellspacing="0">
		        	<thead>
		                <tr>
		                  <th>FS</th>
		                  <th>Bereich</th>
		                  <th>Kürzel</th>
		                  <th>Titel</th>
		                  <th>LP</th>
		                  <th>Turnus</th>
		                </tr>
		          	</thead>
		          	<tbody>
						@foreach( $degreecourse->modules as $module )
							@if($listofsections[$module->pivot->section] != "Pflicht")
								@if($listofsections[$module->pivot->section] != "Wahlpflicht")
									<tr class="warning">
								@else
									<tr class="success">
								@endif
							@else
								<tr class="info">
							@endif
								<td>{{ $module->pivot->semester }}</td>
								<td>{{ $listofsections[$module->pivot->section] }}</td>
								<td>{{ $module->short }}</td>
								<td><a href="{{ route('overview.module', $module->id) }}">{{ $module->name }}</td>
								<td>{{ $module->credits }}</td>
								<td>{{ $module->rotation->name }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
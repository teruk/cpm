@extends('layouts.main')

@section('scripts')
	<link rel="stylesheet" type="text/css" href="{{ url('css/dataTables.bootstrap.css')}}">
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery.dataTables.min.js')}}"></script>
	<script type="text/javascript" language="javascript" src="{{ url('js/dataTables.bootstrap.js')}}"></script>
	<script type="text/javascript" class="init">

$(document).ready(function() {
	$('table.display').dataTable({
		"paging": 	false,
		"ordering":	false
	});

} );

	</script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
		<li class="active">Übersichten</li>
		<li class="active">Mittelfriste Lehrplanung</li>
	</ol>
@stop

@section('main')
	<h4>Mittelfristige Lehrplanung</h4>
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-sm-12">
			<ul class="nav nav-tabs" style="margin-bottom: 15px;">
				<li class="active"><a href="#module" data-toggle="tab">Module Alle</a></li>
				<li><a href="#module_bsc" data-toggle="tab">Module BSc</a></li>
				<li><a href="#module_msc" data-toggle="tab">Module MSc</a></li>
				<li><a href="#employees" data-toggle="tab">Personen Alle</a></li>
				<li><a href="#employees_bsc" data-toggle="tab">Personen BSc</a></li>
				<li><a href="#employees_msc" data-toggle="tab">Personen MSc</a></li>
			</ul>
	
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="module">
					@if (sizeof($mtpgrid['modules_all']) == 0)
						<p>Bisher ist keine mittelfristige Lehrplanung erfolgt</p>
					@else
		            		<table class="table table-striped table-bordered table-condensed display" id="" cellspacing="0">
		            			<thead>
			                		<tr>
			                  			<th>Modul</th>
							                 @foreach($turns as $turn)
							                 	<th>{{$turn->present()}}</th>
							                 @endforeach
			                		</tr>
		              			</thead>
		              			<tbody>
									@foreach( $mtpgrid['modules_all'] as $module )
										<tr>
											<td>
												{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['id']) }}
											</td>
											@foreach( $module['turns'] as $turn )
												<td>
													@if (sizeof($turn))
														@foreach( $turn as $employee)
															@if (!$employee['annulled']) 
																<p>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }} ({{$employee['semester_periods_per_week']}})</p>
															@else
																<p><s>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }} ({{$employee['semester_periods_per_week']}})</s></p>
															@endif
														@endforeach
													@endif
												</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
					@endif
					
					
					
				</div>
				
				<div class="tab-pane fade" id="module_bsc">
					@if (sizeof($mtpgrid['modules_bachelor']) == 0)
						<p>Bisher ist keine mittelfristige Lehrplanung erfolgt</p>
					@else
		            		<table class="table table-striped table-bordered table-condensed display" id="" cellspacing="0">
		            			<thead>
			                		<tr>
			                  			<th>Modul</th>
							                 @foreach($turns as $turn)
							                 	<th>{{$turn->name}} {{$turn->year}}</th>
							                 @endforeach
			                		</tr>
		              			</thead>
		              			<tbody>
									@foreach( $mtpgrid['modules_bachelor'] as $module )
										<tr>
											<td>
												{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['id']) }}
											</td>
											@foreach( $module['turns'] as $turn )
												<td>
													@if (sizeof($turn))
														@foreach( $turn as $employee)
															@if (!$employee['annulled'])
																<p>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }} ({{$employee['semester_periods_per_week']}})</p>
															@else
																<p><s>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }} ({{$employee['semester_periods_per_week']}})</s></p>
															@endif
														@endforeach
													@endif
												</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
					@endif
				
				</div>
				
				<div class="tab-pane fade" id="module_msc">
					@if (sizeof($mtpgrid['modules_master']) == 0)
						<p>Bisher ist keine mittelfristige Lehrplanung erfolgt</p>
					@else
						<div class="table-responsive">
		            		<table class="table table-striped table-bordered table-condensed display" id="" cellspacing="0">
		            			<thead>
			                		<tr>
			                  			<th>Modul</th>
							                 @foreach($turns as $turn)
							                 	<th>{{$turn->present() }}</th>
							                 @endforeach
			                		</tr>
		              			</thead>
		              			<tbody>
									@foreach( $mtpgrid['modules_master'] as $module )
										<tr>
											<td>
												{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['id']) }}
											</td>
											@foreach( $module['turns'] as $turn )
												<td>
													@if (sizeof($turn))
														@foreach( $turn as $employee)
															@if (!$employee['annulled'])
																<p>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }} ({{$employee['semester_periods_per_week']}})</p>
															@else
																<p><s>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }} ({{$employee['semester_periods_per_week']}})</s></p>
															@endif
														@endforeach
													@endif
												</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
					
				</div>
				
				<div class="tab-pane fade" id="employees">
					@if ( sizeof($mtpgrid['employees_all']) == 0 )
						Bisher ist keine mittelfriste Lehrplanung erfolgt.
					@else
						<div class="table-responsive">
				            <table class="table table-striped table-bordered table-condensed display" id="" cellspacing="0">
				            	<thead>
					                <tr>
					                  <th>Person</th>
					                  @foreach($turns as $turn)
					                  	<th>{{$turn->name}} {{$turn->year}}</th>
					                  @endforeach
					                </tr>
				              	</thead>
				              	<tbody>
									@foreach( $mtpgrid['employees_all'] as $employee )
										<tr>
											<td><p><strong>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }}</strong></p><p>{{ $employee['teaching_load'] }} SWS</p></td>
											@foreach( $employee['turns'] as $turn )
												<td>
													@if (sizeof($turn))
														@foreach( $turn as $module)
															@if (!$module['annulled'])
																<p>{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['module_id']) }}</a> ({{$module['semester_periods_per_week']}})</p>
															@else
																<p><s>{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['module_id']) }} ({{$module['semester_periods_per_week']}})</s></p>
															@endif
														@endforeach
													@endif
												</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
				
				<div class="tab-pane fade" id="employees_bsc">
					@if ( sizeof($mtpgrid['employees_bachelor']) == 0 )
						Bisher ist keine mittelfriste Lehrplanung erfolgt.
					@else
						<div class="table-responsive">
				            <table class="table table-striped table-bordered table-condensed display" id="" cellspacing="0">
				            	<thead>
					                <tr>
					                  <th>Person</th>
					                  @foreach($turns as $turn)
					                  	<th>{{$turn->name}} {{$turn->year}}</th>
					                  @endforeach
					                </tr>
				              	</thead>
				              	<tbody>
									@foreach( $mtpgrid['employees_bachelor'] as $employee )
										<tr>
											<td><p><strong>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }}</strong></p><p>{{ $employee['teaching_load'] }} SWS</p></td>
											@foreach( $employee['turns'] as $turn )
												<td>
													@if (sizeof($turn))
														@foreach( $turn as $module)
															@if (!$module['annulled'])
																<p>{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['module_id']) }} ({{$module['semester_periods_per_week']}})</p>
															@else
																<p><s>{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['module_id']) }} ({{$module['semester_periods_per_week']}})</s></p>
															@endif
														@endforeach
													@endif
												</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
				
				<div class="tab-pane fade" id="employees_msc">
				@if ( sizeof($mtpgrid['employees_master']) == 0 )
						Bisher ist keine mittelfriste Lehrplanung erfolgt.
					@else
						<div class="table-responsive">
				            <table class="table table-striped table-bordered table-condensed display" id="" cellspacing="0">
				            	<thead>
					                <tr>
					                  <th>Person</th>
					                  @foreach($turns as $turn)
					                  	<th>{{$turn->name}} {{$turn->year}}</th>
					                  @endforeach
					                </tr>
				              	</thead>
				              	<tbody>
									@foreach( $mtpgrid['employees_master'] as $employee )
										<tr>
											<td><p><strong>{{ link_to_route('showOverviewSelectedEmployee_path', $employee['name'], $employee['employee_id']) }}</strong></p><p>{{ $employee['teaching_load'] }} SWS</p></td>
											@foreach( $employee['turns'] as $turn )
												<td>
													@if (sizeof($turn))
														@foreach( $turn as $module)
															@if (!$module['annulled'])
																<p>{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['module_id']) }} ({{$module['semester_periods_per_week']}})</p>
															@else
																<p><s>{{ link_to_route('showOverviewSelectedModule_path', $module['short'], $module['module_id']) }} ({{$module['semester_periods_per_week']}})</s></p>
															@endif
														@endforeach
													@endif
												</td>
											@endforeach
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@stop
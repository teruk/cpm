@extends('layouts.main')

@include('degreecourses.partials.breadcrumb', ['breadcrumbTitle' => 'Zugeordnete Module'])

@section('main')
	
	<div class="row">
		@include('degreecourses.partials.sidenav')

		<div class="col-md-9">
			@include('degreecourses.partials.heading', ['title' => 'Zugeordnete Module:'])

			<p>Bearbeitung der Informationen dieses Studiengangs.</p>
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
								<td>
									@if ($currentUser->hasRole('Admin') OR $currentUser->can('edit_module'))
										{{ link_to_route('showModule_path', $module->name, $module->id) }}
									@else
										{{ $module->name }}
									@endif
								</td>
								<td>{{ $module->credits }}</td>
								<td>{{ $listofrotations[$module->rotation_id] }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
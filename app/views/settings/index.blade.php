@extends('layouts.main')

@include('settings.partials.breadcrumb', ['breadcrumbTitle' => 'Übersicht'])

@section('main')
	
	<div class="row">
		@include('settings.partials.sidenav')

		<div class="col-md-9">
			@include('settings.partials.heading', ['title' => 'Übersicht:'])

			<p>Übersicht über die vorhandenen Einstellungen.</p>

			<div class="panel panel-default">
	            <div class="panel-body">
					<table class="table table-striped table-condensed">
						<caption>table title and/or explanatory text</caption>
						<thead>
							<tr>
								<th>Anzeigenname</th>
								<th>Name</th>
								<th>Wert</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									@if ($currentUser->hasRole('Admin') OR $currentUser->can('change_setting_current_turn'))
										{{ link_to_route('editSettingCurrentTurn_path', 'Aktuelles Semester') }}
									@else
										Aktuelles Semester
									@endif
								</td>
								<td>current_turn</td>
								<td>{{ $currentTurn->present() }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop
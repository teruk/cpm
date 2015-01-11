@extends('layouts.main')

@include('researchgroups.partials.breadcrumb', ['breadcrumbTitle' => 'Veranstaltungsübersicht'])

@section('main')
	
	<div class="row">
		@include('researchgroups.partials.sidenav')

		<div class="col-md-9">
			@include('researchgroups.partials.heading', ['title' => 'Veranstaltungsübersicht:'])

			<p>Bearbeitung der Informationen dieses Arbeitsbereiches.</p>

			<div class="table-responsive">
				<table class="table table-striped" cellspacing="0">
				    <thead>
						<tr>
						    <th>Veranstaltung</th>
						    <th>Verantwortliche</th>
						    <th>Semester</th>
						    <th>SWS</th>
						    <th>Uhrzeit</th>
						    <th>Raum</th>
					 	</tr>
				   	</thead>
				    <tbody>
						<tr>
							<td colspan="6">[TODO]</td>
						</tr>			
					</tbody>
				</table>
			</div>
		</div>
	</div>
@stop
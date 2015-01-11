@extends('layouts.main')

@include('roles.partials.breadcrumb', ['breadcrumbTitle' => 'Rolleninhaber'])

@section('main')
	
	<div class="row">
		@include('roles.partials.sidenav')

		<div class="col-md-9">
			@include('roles.partials.heading', ['title' => 'Rolleninhaber:'])

			<p>Folgende Personen sind Inhaber dieser Rolle:</p>

			<div class="panel panel-default">
			            
	            <div class="panel-body">
	            	<table class="table table-striped table-condensed">
	            		<thead>
	            			<tr>
	            				<th>Name</th>
	            				<th>Email</th>
	            			</tr>
	            		</thead>
	            		<tbody>
	            			@foreach($role->users as $user)
	            				<tr>
	            					<td>{{ $user->name }}</td>
	            					<td>{{ $user->email }}</td>
	            				</tr>
	            			@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop
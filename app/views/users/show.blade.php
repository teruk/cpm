@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('users')}}">Benutzermanagement</a></li>
	  <li class="active">{{ $user->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $user->name }}</h3>
	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		
		{{ (Session::get('users_tabindex') == "home") ? '<li class="active">' : '<li>' }} <a href="#home" data-toggle="tab">Informationen</a></li>
		{{ (Session::get('users_tabindex') == "roles") ? '<li class="active">' : '<li>' }} <a href="#roles" data-toggle="tab">Rollen</a></li>
		{{ (Session::get('users_tabindex') == "researchgroups") ? '<li class="active">' : '<li>' }} <a href="#researchgroups" data-toggle="tab">Arbeitsbereiche</a></li>
		{{ (Session::get('users_tabindex') == "secret") ? '<li class="active">' : '<li>' }} <a href="#secret" data-toggle="tab">Passwort ändern</a></li>
		{{ (Session::get('users_tabindex') == "deactivation") ? '<li class="active">' : '<li>' }} <a href="#deactivation" data-toggle="tab">Deaktivierung</a></li>
		
	</ul>

	<div id="myTabContent" class="tab-content">
		<div class='{{ (Session::get('users_tabindex') == "home") ? 'tab-pane fade active in' : 'tab-pane fade' }}' id="home">
			
			@include('users.partials.tab-user-information')

		</div>

		<div class="{{ (Session::get('users_tabindex') == "roles") ? 'tab-pane fade active in' : 'tab-pane fade' }}" id="roles">
			
			@include('users.partials.tab-roles')

		</div>

		<div class="{{ (Session::get('users_tabindex') == "researchgroups") ? 'tab-pane fade active in' : 'tab-pane fade' }}" id="researchgroups">
			
			@include('users.partials.tab-researchgroups')

		</div>

		<div class="{{ (Session::get('users_tabindex') == "secret") ? 'tab-pane fade active in' : 'tab-pane fade' }}" id="secret">

			@include('users.partials.tab-password-change')

		</div>

		<div class="{{ (Session::get('users_tabindex') == "deactivation") ? 'tab-pane fade active in' : 'tab-pane fade' }}" id="deactivation">
			
			@include('users.partials.tab-deactivation')

		</div>
	</div>
@stop
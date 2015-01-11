@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showUsers_path', 'Benutzermanagement') }}</li>
	  <li class="active">{{ $user->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
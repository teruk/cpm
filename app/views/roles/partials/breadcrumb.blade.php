@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showRoles_path', 'Rollenmanagement') }}</li>
	  <li class="active">{{ $role->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
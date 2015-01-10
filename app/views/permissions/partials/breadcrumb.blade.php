@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showPermissions_path', 'Berechtigungsmanagement') }}</li>
	  <li class="active">{{ $permission->display_name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
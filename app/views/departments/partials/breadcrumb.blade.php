@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showDepartments_path', 'Fachbereichsmanagement') }}</li>
	  <li class="active">{{ $department->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
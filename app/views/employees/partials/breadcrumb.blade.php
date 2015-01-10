@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showEmployees_path', 'Mitarbeitermanagement')}}</li>
	  <li class="active">{{ $employee->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
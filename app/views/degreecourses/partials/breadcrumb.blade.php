@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showDegreecourses_path', 'Studiengangsmanagement') }}</li>
	  <li class="active">{{ $degreecourse->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
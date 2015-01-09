@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showCoursetypes_path', 'Kurstypmanagement') }}</li>
	  <li class="active">{{ $coursetype->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
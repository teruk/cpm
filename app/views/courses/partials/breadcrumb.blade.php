@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showCourses_path', 'Lehrveranstaltungsmanagement') }}</li>
	  <li class="active">{{ $course->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
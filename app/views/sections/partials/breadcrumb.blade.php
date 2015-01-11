@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showSections_path', Bereichsmanagement) }}</li>
	  <li class="active">{{ $section->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
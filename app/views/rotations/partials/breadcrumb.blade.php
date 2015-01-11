@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showRotations_path', 'Turnusmanagement') }}</li>
	  <li class="active">{{ $rotation->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showDegrees_path', 'Abschlussmanagement') }}</li>
	  <li class="active">{{ $degree->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
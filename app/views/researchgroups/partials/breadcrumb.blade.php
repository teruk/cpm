@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showResearchgroups_path', 'Arbeitsbereichsmanagement') }}</li>
	  <li class="active">{{ $researchgroup->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
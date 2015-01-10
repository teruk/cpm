@section('breadcrumbs')
	<ol class="breadcrumb">
		<li>{{ link_to_route('showModules_path', 'Modulmanagement') }}</li>
	  	<li class="active">{{ $module->name }}</li>
	 	<li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
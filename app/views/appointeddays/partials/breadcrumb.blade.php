@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showAppointeddays_path', 'Termine') }}</li>
	  <li class="active">{{ $appointedday->subject }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
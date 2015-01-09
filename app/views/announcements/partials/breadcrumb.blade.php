@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('announcements')}}">Ankündigungsmanagement</a></li>
	  <li class="active">{{ $announcement->subject }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
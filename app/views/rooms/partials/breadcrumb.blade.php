@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showRooms_path','Raummanagement') }}</li>
	  <li class="active">{{ $room->name }}</li>
	  <li class="active">{{ $breadcrumbTitle }}</li>
	</ol>
@stop
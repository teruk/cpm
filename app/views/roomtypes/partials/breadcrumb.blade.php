@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showRoomtypes_path', 'Raumtypmanagement') }}</li>
	  <li class="active">{{ $roomtype->name }}</li>
	  <li>{{ $breadcrumbTitle }}</li>
	</ol>
@stop
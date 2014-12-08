@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('home')}}">Home</a></li>
	  <li class="active">Termine</li>
	  <li class="active">{{ $appointedday->subject }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $appointedday->subject }}</h3>
	
	<div class="row">
		<div class="col-sm-8">
			<div class="panel panel-primary">
		        <div class="panel-body">
					{{ $appointedday->content }}
				</div>
			</div>
		</div>
	</div>
@stop
@section('scripts')
	<script type="text/javascript" language="javascript" src="{{ url('js/jquery-1.10.2.min.js')}}"></script>
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li>{{ link_to_route('showSections_path', Bereichsmanagement) }}</li>
	  <li class="active">{{ $section->name }}</li>
	</ol>
@stop

@section('main')
	<h3>{{ $section->name }}</h3>
	
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
		       	<div class="panel-heading">
			        <h3 class="panel-title">Informationen</h3>
		        </div>
		        <div class="panel-body">
					{{ Form::model($section, ['method' => 'PATCH', 'route' => ['updateSection_path', $section->id]]) }}
					<table class="table table-striped">
						<tbody>
							<tr>
								<td>{{ Form::label('name', 'Name*:') }}</td>
								<td align="right">{{ Form::text('name', $section->name, array('size' => 40)) }}</td>	
							</tr>							 
							<tr>
								<td >* erforderlich</td>
								<td align="right">{{ Form::submit('Bearbeiten') }}</td>
							</tr>
						</tbody>
					</table>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
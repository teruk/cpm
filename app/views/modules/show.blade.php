@section('scripts')
	<script type="text/javascript" class="init">

	    $(document).ready(function() {

		    $('#btn-addCourse').click(function () {
			     $('#myModal').modal('show');
			});

			$('#btn-copyMediumtermplanning').click(function () {
			     $('#copymediumtermplanning').modal('show');
			});

			$('#btn-addMediumtermplanning').click(function () {
			     $('#addmediumtermplanning').modal('show');
			});

	    } );

	</script>

	@include('layouts.partials.delete-confirm-js')
@stop

@section('breadcrumbs')
	<ol class="breadcrumb">
	  <li><a href="{{ URL::to('modules')}}">Modulmanagement</a></li>
	  <li class="active">{{ $module->name }}</li>
	</ol>
@stop

@section('main')
	<h4>{{ $module->name }}</h4>
	
	<ul class="nav nav-tabs" style="margin-bottom: 15px;">
		@if ( $tabindex == "home" )
			<li class="active">
		@else
			<li>
		@endif
			<a href="#home" data-toggle="tab">Informationen</a></li>
			
		@if ( $tabindex == "degreecourses" )
			<li class="active">
		@else
			<li>
		@endif
			<a href="#degreecourses" data-toggle="tab">Studiengänge</a></li>
			
		@if ( $tabindex == "courses" )
			<li class="active">
		@else
			<li>
		@endif
			<li><a href="#courses" data-toggle="tab">Lehrveranstaltungen</a></li>
			
		@if ( $tabindex == "mediumtermplanning" )
			<li class="active">
		@else
			<li>
		@endif
			<a href="#mediumtermplanning" data-toggle="tab">Mittelfristige Lehrlpanung</a></li>
		
	</ul>
	<div id="myTabContent" class="tab-content">
		@if ( $tabindex == "home" )
			<div class="tab-pane fade active in" id="home">
		@else
			<div class="tab-pane fade" id="home">
		@endif

			@include('modules.partials.tab-module-information')

		</div>
		
		@if ( $tabindex == "degreecourses" )
			<div class="tab-pane fade active in" id="degreecourses">
		@else
			<div class="tab-pane fade" id="degreecourses">
		@endif

			@include('modules.partials.tab-degreecourses')
			
		</div>
		
		@if ( $tabindex == "courses" )
			<div class="tab-pane fade active in" id="courses">
		@else
			<div class="tab-pane fade" id="courses">
		@endif
        
        	@include('modules.partials.tab-courses')

		</div>
		
		@if ( $tabindex == "mediumtermplanning" )
			<div class="tab-pane fade active in" id="mediumtermplanning">
		@else
			<div class="tab-pane fade" id="mediumtermplanning">
		@endif
			
			@include('modules.partials.tab-mediumtermplanning')
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		@include('modules.partials.addcourse')
	</div>

	<div class="modal fade" id="copymediumtermplanning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	@include('modules.partials.copymediumtermplanning')
	</div>

	<div class="modal fade" id="addmediumtermplanning" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  	@include('modules.partials.addmediumtermplanning')
	</div>

	<!-- delete confirmation modal dialog -->
  	@include('layouts.partials.delete_confirm')
@stop
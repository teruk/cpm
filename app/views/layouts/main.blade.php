
<!DOCTYPE html>
<html lang="de">
	<head>
	    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="Sebastian Meyer">
	    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
		
	    <title>Lehrplanungsmanagement</title>
	    <!-- Bootstrap core CSS -->
	    <link href="{{ url('css/bootstrap.readable.css')}}" rel="stylesheet">
	    <script type="text/javascript" language="javascript" src="{{ url('js/jquery-1.10.2.min.js')}}"></script>
		<!-- Additional Script -->
		@yield('scripts')
	   
	</head>

	<body>
		<!-- Navigation Bar -->
		@include('layouts/navigation')
	    <div class="container">
	    	<!-- Alerts -->
		    @if (Session::has('message'))
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert">×</button>
		        	{{ Session::get('message') }}
		      	</div>
			@endif
			@if (Session::has('error'))
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert">×</button>
					{{ Session::get('error') }}
				</div>
			@endif
			@if (Session::has('info'))
				<div class="alert alert-info alert-dismissable">
					<button type="button" class="close" data-dismiss="alert">×</button>
					{{ Session::get('info') }}
				</div>
			@endif
			@if ($errors->any()) 
				<div class="alert alert-danger alert-dismissable">
					<button type="button" class="close" data-dismiss="alert">×</button>
			       	{{ implode('', $errors->all('<li class="error">:message</li>')) }}
			   	</div>
			@endif
			<!-- Main Body -->
			<div class="bs-docs-section clearfix">
				<div class="row">
					<div class="col-lg-12">
						<div class="bs-component">
							@yield('breadcrumbs')
			    			@yield('main')
						</div>
		    		</div>
		    	</div>
			</div>
		    
			<!-- Footer -->
	      	<footer>
	      		<div class="row" style="border-top: 1px solid; border-color: #dddddd; margin-top: 5px;">
	      			<div class="col-lg-12">

	      				<ul class="list-unstyled">
	      					<li class="pull-right"><a href="#top">Nach oben</a></li>
	      				</ul>
			        	<p>&copy; Universtät Hamburg, Fachbereich Informatik 2014</p>
			        	<p>Basierend auf dem PHP-Framework <a href="http://laravel.com/">Laravel</a></p>
			        	<p>Verwendetes <a href="http://bootswatch.com/">Bootswatch</a>-Theme: <a href="http://bootswatch.com/readable/">Readable</a></p>
			        </div>
			    </div>
	      	</footer>
	    </div> <!-- /container -->


	    <!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
    	<script type="text/javascript" language="javascript" src="{{ url('jqueryui/jquery-ui.min.js')}}"></script>
    	<script type="text/javascript" language="javascript" src="{{ url('js/bootstrap.min.js')}}"></script>
    	<script type="text/javascript" language="javascript" src="{{ url('js/bootswatch.js')}}"></script>
  	</body>
</html>
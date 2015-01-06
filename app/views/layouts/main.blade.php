
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
		@include('layouts.partials.navigation')

	    <div class="container">
	    	<!-- Main Body -->
	    	@yield('breadcrumbs')
	    	@include('flash::message')
			@yield('main')
		    
			<!-- Footer -->
	    	@include('layouts.partials.footer')
	    </div> <!-- /container -->

	    

	    <!-- Bootstrap core JavaScript
	    ================================================== -->
	    <!-- Placed at the end of the document so the pages load faster -->
    	<script type="text/javascript" language="javascript" src="{{ url('jqueryui/jquery-ui.min.js')}}"></script>
    	<script type="text/javascript" language="javascript" src="{{ url('js/bootstrap.min.js')}}"></script>
    	<script type="text/javascript" language="javascript" src="{{ url('js/bootswatch.js')}}"></script>
  	</body>
</html>
<div class="navbar navbar-inverse" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			{{ link_to_route('index', 'Lehrplanungsmanagement', '', ['class' => 'navbar-brand']) }}
		</div>

	    <div class="navbar-collapse collapse navbar-inverse-collapse">
	    	<ul class="nav navbar-nav">
	    		@if($signedIn)
          			<li><a href="{{ URL::to('home')}}"><span class="glyphicon glyphicon-home"></span></a></li>
          			<!-- Plannings links -->
          			@include('layouts.partials.nav-plannings')

				    <!-- Administration links -->
				    @include('layouts.partials.nav-administrations')
				    
	            @endif

	            <!-- Overview links -->
	            @include('layouts.partials.nav-overviews')
	    	</ul>

			<ul class="nav navbar-nav navbar-right">
				@if($signedIn)
					<li class="navbar-brand">{{ $currentUser->name }}</li>
          			<li>{{ link_to_route('logout', 'Logout') }}</li>
          		@else
          			<li>{{ link_to_route('login', 'Anmelden') }}</li>
                @endif
          	</ul>
        </div>
	</div>
</div>